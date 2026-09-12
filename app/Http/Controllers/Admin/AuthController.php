<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
            ],
        ]);

        // Sengaja TIDAK divalidasi harus format email -- kolom
        // `email` di database dipakai juga buat nampung "username"
        // singkat kayak "super", tanpa perlu ada tanda @.
        // Tidak ada kolom/tabel baru, cuma cara isinya yang dilonggarkan.
        $credentials = [
            'email' => $validated['login'],
            'password' => $validated['password'],
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang di Dashboard Admin HIMAFA.');
        }


        return back()
            ->withErrors([
                'login' => 'Email/Username atau password tidak sesuai.',
            ])
            ->onlyInput('login');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil keluar.');
    }
}