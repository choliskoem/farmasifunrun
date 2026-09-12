<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenuAccessMiddleware
{
    /**
     * Dipasang di route pakai ->middleware('menu:KEY'), KEY-nya
     * harus sama persis dengan key di config/admin_menu.php.
     *
     * Dipasang SETELAH middleware 'admin' (jadi login + is_admin
     * sudah pasti lolos duluan) -- ini lapisan tambahan: role-nya
     * (admin/user) harus diizinkan buka menu spesifik ini.
     */
    public function handle(
        Request $request,
        Closure $next,
        string $menuKey
    ): Response {

        $user = auth()->user();

        if (!$user || !$user->canAccessMenu($menuKey)) {
            abort(403, 'Anda tidak punya akses ke menu ini.');
        }

        return $next($request);
    }
}