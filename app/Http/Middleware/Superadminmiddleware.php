<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Dipasang SETELAH middleware 'admin' di route (jadi urutan
     * login & cek admin biasa sudah pasti lolos duluan). Ini cuma
     * nambah lapisan pengecekan: harus role 'super_admin', bukan
     * sekadar is_admin biasa.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
            abort(403, 'Halaman ini cuma bisa diakses oleh Super Admin');
        }

        return $next($request);
    }
}