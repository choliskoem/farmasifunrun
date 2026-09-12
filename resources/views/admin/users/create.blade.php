@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('content')

<div class="space-y-6">

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            🛡️
        </div>

        <div>
            <h1 class="text-2xl font-black text-slate-900">Tambah Admin</h1>
            <p class="text-sm text-slate-500">Buat akun admin baru & tentukan role-nya.</p>
        </div>

    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
            <ul class="list-inside list-disc text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6 p-6 md:p-8">

            @csrf

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Email / Login</label>
                <input
                    type="text"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="admin@himafa.test atau cukup teks singkat, mis. super"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                <p class="mt-1 text-xs text-slate-500">Boleh format email biasa, atau teks singkat tanpa @ — ini yang dipakai buat login.</p>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Role</label>

                <div class="grid gap-3 sm:grid-cols-2">

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}>
                        <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <p class="font-bold text-slate-800">Admin</p>
                            <p class="mt-1 text-xs text-slate-500">Akses panel admin standar.</p>
                        </div>
                    </label>

                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="super_admin" class="peer sr-only" {{ old('role') === 'super_admin' ? 'checked' : '' }}>
                        <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <p class="font-bold text-slate-800">Super Admin</p>
                            <p class="mt-1 text-xs text-slate-500">Akses penuh + kelola akun admin lain.</p>
                        </div>
                    </label>

                </div>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="3"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="rounded-xl border px-5 py-3 font-bold text-slate-600">Batal</a>
                <button class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white transition hover:bg-emerald-700">Simpan Admin</button>
            </div>

        </form>

    </div>

</div>

@endsection