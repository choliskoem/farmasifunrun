<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view(
            'admin.users.index',
            compact('users')
        );
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'max:255', 'unique:users,email'],


            'role' => ['required', Rule::in(['admin', 'super_admin'])],

            'password' => ['required', Password::min(4)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'is_admin' => true,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view(
            'admin.users.edit',
            compact('user')
        );
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],


            'role' => ['required', Rule::in(['admin', 'super_admin'])],

            'password' => ['nullable', Password::min(4)],
        ]);

        // Jangan sampai Super Admin terakhir nurunin role dirinya
        // sendiri jadi admin biasa -- bikin sistem kehilangan Super
        // Admin sama sekali dan nggak ada yang bisa kelola user lagi.
        if (
            $user->id === auth()->id() &&
            $user->isSuperAdmin() &&
            $validated['role'] !== 'super_admin' &&
            User::where('role', 'super_admin')->count() <= 1
        ) {
            return back()
                ->withInput()
                ->with('error', 'Tidak bisa menurunkan role diri sendiri -- ini Super Admin terakhir yang tersisa.');
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus Super Admin terakhir yang tersisa.');
        }

        $user->delete();

        return back()->with('success', 'Akun admin berhasil dihapus.');
    }
}