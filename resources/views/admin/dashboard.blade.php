@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="space-y-6">

        {{-- HEADER --}}
        <div>
            <h1 class="text-2xl font-black text-slate-900">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Ringkasan aktivitas HIMAFA.
            </p>
        </div>


        {{-- FUN RUN SUMMARY --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="mb-5 flex items-center justify-between">

                <div>
                    <h2 class="font-bold text-slate-900">
                        Fun Run
                    </h2>
                    <p class="text-sm text-slate-500">
                        Ringkasan peserta dan pembayaran.
                    </p>
                </div>

                <a href="{{ route('admin.fun-run.registrations') }}"
                    class="rounded-xl bg-slate-900 px-4 py-2.5 text-xs font-bold text-white hover:bg-emerald-600">
                    Lihat Semua
                </a>

            </div>

            @php
                $funRunTotal = \App\Models\FunRunRegistration::count();
                $funRunPending = \App\Models\FunRunRegistration::where('status', 'waiting_verification')->count();
                $funRunPaid = \App\Models\FunRunRegistration::where('status', 'paid')->count();
                $funRunRejected = \App\Models\FunRunRegistration::where('status', 'rejected')->count();
            @endphp

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-semibold text-slate-500">
                        Total Peserta
                    </p>
                    <p class="mt-2 text-3xl font-black text-slate-900">
                        {{ $funRunTotal }}
                    </p>
                </div>

                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">
                    <p class="text-sm font-semibold text-amber-600">
                        Menunggu Verifikasi
                    </p>
                    <p class="mt-2 text-3xl font-black text-amber-700">
                        {{ $funRunPending }}
                    </p>
                </div>

                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5">
                    <p class="text-sm font-semibold text-emerald-600">
                        Terverifikasi
                    </p>
                    <p class="mt-2 text-3xl font-black text-emerald-700">
                        {{ $funRunPaid }}
                    </p>
                </div>

                <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
                    <p class="text-sm font-semibold text-red-600">
                        Ditolak
                    </p>
                    <p class="mt-2 text-3xl font-black text-red-700">
                        {{ $funRunRejected }}
                    </p>
                </div>

            </div>

        </div>


        {{-- QUICK LINKS --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="mb-4 font-bold text-slate-900">
                Menu Cepat
            </h2>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">

                <a href="{{ route('admin.profile.edit') }}"
                    class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                    <span class="text-lg">📖</span>
                    Profil HIMAFA
                </a>

                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                    <span class="text-lg">📆</span>
                    Event
                </a>

                <a href="{{ route('admin.galleries.index') }}"
                    class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">
                    <span class="text-lg">🖼️</span>
                    Galeri
                </a>

            </div>

        </div>

    </div>

@endsection
