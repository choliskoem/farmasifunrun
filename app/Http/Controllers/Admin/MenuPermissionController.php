<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleMenuPermission;
use Illuminate\Http\Request;

class MenuPermissionController extends Controller
{
    /**
     * Role yang bisa diatur dari halaman ini. Super Admin sengaja
     * TIDAK dimasukkan -- dia selalu full akses (lihat
     * User::canAccessMenu()).
     */
    private array $manageableRoles = ['admin', 'user'];

    public function edit()
    {
        $menus = config('admin_menu');

        $permissions = RoleMenuPermission::whereIn('role', $this->manageableRoles)
            ->get()
            ->groupBy('role')
            ->map(fn ($rows) => $rows->pluck('menu_key')->all());

        return view('admin.menu-permissions.edit', [
            'menus' => $menus,
            'roles' => $this->manageableRoles,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request)
    {
        $menuKeys = array_keys(config('admin_menu'));

        foreach ($this->manageableRoles as $role) {

            $checked = $request->input($role, []);

            // Cuma terima menu_key yang beneran valid/terdaftar di
            // config -- jaga-jaga ada input aneh yang di-inject.
            $checked = array_values(array_intersect($checked, $menuKeys));

            RoleMenuPermission::where('role', $role)->delete();

            foreach ($checked as $menuKey) {
                RoleMenuPermission::create([
                    'role' => $role,
                    'menu_key' => $menuKey,
                ]);
            }
        }

        return back()->with(
            'success',
            'Akses menu berhasil diperbarui.'
        );
    }
}