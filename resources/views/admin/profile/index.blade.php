@extends('layouts.admin')

@section('content')

<div class="space-y-8">

    {{-- =====================================================
        WELCOME
    ====================================================== --}}

    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-emerald-600 to-teal-700 p-7 text-white shadow-xl shadow-emerald-600/10 sm:p-9">

        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>

        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-teal-950/20 blur-3xl"></div>

        <div class="relative">

            <div class="text-sm font-semibold text-emerald-100">
                Selamat datang kembali 👋
            </div>

            <h1 class="mt-2 text-3xl font-extrabold sm:text-4xl">
                Admin HIMAFA
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-7 text-emerald-50 sm:text-base">
                Kelola seluruh informasi website HIMAFA dengan mudah,
                mulai dari profil, struktur organisasi, galeri hingga event.
            </p>

            <div class="mt-7 flex flex-wrap gap-3">

                <a
                    href="{{ route('admin.profile') }}"
                    class="rounded-xl bg-white px-5 py-3 text-sm font-bold text-emerald-700 transition hover:-translate-y-0.5"
                >
                    Kelola Profil
                </a>

                <a
                    href="{{ route('admin.organization') }}"
                    class="rounded-xl border border-white/20 bg-white/10 px-5 py-3 text-sm font-bold text-white backdrop-blur transition hover:bg-white/20"
                >
                    Kelola Organisasi
                </a>

            </div>

        </div>

    </div>


    {{-- =====================================================
        STATISTICS
    ====================================================== --}}

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Profil --}}

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0"
                        />

                    </svg>

                </div>

                <span class="rounded-full bg-emerald-50 px-3 py-1 text-[10px] font-bold text-emerald-600">
                    Aktif
                </span>

            </div>

            <div class="mt-6">

                <div class="text-3xl font-extrabold text-slate-900">
                    1
                </div>

                <div class="mt-1 text-sm text-slate-500">
                    Profil HIMAFA
                </div>

            </div>

        </div>


        {{-- Pengurus --}}

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M17 20h5v-2a4 4 0 00-5-3.87M17 20H7m10 0v-2c0-.7-.12-1.37-.34-2M7 20H2v-2a4 4 0 015-3.87M7 20v-2c0-.7.12-1.37.34-2M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-6">

                <div class="text-3xl font-extrabold text-slate-900">
                    {{ $totalPengurus ?? 15 }}
                </div>

                <div class="mt-1 text-sm text-slate-500">
                    Pengurus Aktif
                </div>

            </div>

        </div>


        {{-- Galeri --}}

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M4 5h16v14H4zM4 16l4-4 3 3 3-4 6 5"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-6">

                <div class="text-3xl font-extrabold text-slate-900">
                    {{ $totalGallery ?? 6 }}
                </div>

                <div class="mt-1 text-sm text-slate-500">
                    Foto Galeri
                </div>

            </div>

        </div>


        {{-- Event --}}

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-start justify-between">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 2v4M16 2v4M3 10h18M5 5h14a2 2 0 012 2v13H3V7a2 2 0 012-2z"
                        />

                    </svg>

                </div>

            </div>

            <div class="mt-6">

                <div class="text-3xl font-extrabold text-slate-900">
                    {{ $totalEvent ?? 1 }}
                </div>

                <div class="mt-1 text-sm text-slate-500">
                    Event
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
        QUICK ACTION
    ====================================================== --}}

    <div>

        <div class="mb-5">

            <h2 class="text-xl font-extrabold text-slate-900">
                Kelola Website
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Pilih bagian yang ingin Anda ubah.
            </p>

        </div>


        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">

            {{-- Profil --}}

            <a
                href="{{ route('admin.profile') }}"
                class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl hover:shadow-emerald-900/5"
            >

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 6v12M6 12h12"
                        />

                    </svg>

                </div>

                <h3 class="mt-5 font-extrabold text-slate-900">
                    Profil HIMAFA
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Edit sejarah, deskripsi, visi dan misi.
                </p>

                <div class="mt-5 text-xs font-bold text-emerald-600">
                    Kelola →
                </div>

            </a>


            {{-- Organisasi --}}

            <a
                href="{{ route('admin.organization') }}"
                class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-blue-200 hover:shadow-xl"
            >

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linecap="round"
                            stroke-width="1.8"
                            d="M17 20h5v-2a4 4 0 00-5-3.87M17 20H7m10 0v-2c0-.7-.12-1.37-.34-2M7 20H2v-2a4 4 0 015-3.87M7 20v-2c0-.7.12-1.37.34-2M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                        />

                    </svg>

                </div>

                <h3 class="mt-5 font-extrabold text-slate-900">
                    Struktur Organisasi
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Kelola ketua, sekretaris, bendahara dan bidang.
                </p>

                <div class="mt-5 text-xs font-bold text-blue-600">
                    Kelola →
                </div>

            </a>


            {{-- Galeri --}}

            <a
                href="{{ route('admin.gallery') }}"
                class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-purple-200 hover:shadow-xl"
            >

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M4 5h16v14H4zM4 16l4-4 3 3 3-4 6 5"
                        />

                    </svg>

                </div>

                <h3 class="mt-5 font-extrabold text-slate-900">
                    Galeri
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Tambah, ubah dan hapus dokumentasi kegiatan.
                </p>

                <div class="mt-5 text-xs font-bold text-purple-600">
                    Kelola →
                </div>

            </a>


            {{-- Event --}}

            <a
                href="{{ route('admin.event') }}"
                class="group rounded-[1.75rem] border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-xl"
            >

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-50 text-orange-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M8 2v4M16 2v4M3 10h18M5 5h14a2 2 0 012 2v13H3V7a2 2 0 012-2z"
                        />

                    </svg>

                </div>

                <h3 class="mt-5 font-extrabold text-slate-900">
                    Event HIMAFA
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Kelola informasi event dan kegiatan HIMAFA.
                </p>

                <div class="mt-5 text-xs font-bold text-orange-600">
                    Kelola →
                </div>

            </a>

        </div>

    </div>


    {{-- =====================================================
        RECENT ACTIVITY
    ====================================================== --}}

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- Activity --}}

        <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 lg:col-span-2">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="font-extrabold text-slate-900">
                        Aktivitas Terbaru
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Perubahan terbaru pada website
                    </p>

                </div>

                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">
                    Live
                </span>

            </div>


            <div class="mt-6 space-y-4">

                <div class="flex gap-4 rounded-2xl bg-slate-50 p-4">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">

                        ✓

                    </div>

                    <div class="flex-1">

                        <div class="text-sm font-bold text-slate-800">
                            Sistem admin HIMAFA aktif
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            Siap digunakan untuk mengelola website.
                        </div>

                    </div>

                </div>


                <div class="flex gap-4 rounded-2xl bg-slate-50 p-4">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

                        i

                    </div>

                    <div class="flex-1">

                        <div class="text-sm font-bold text-slate-800">
                            Data organisasi dapat diperbarui
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            Perubahan pengurus tidak perlu mengubah kode website.
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- System Status --}}

        <div class="rounded-[1.75rem] bg-slate-950 p-6 text-white">

            <h2 class="font-extrabold">
                Status Sistem
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Informasi aplikasi
            </p>


            <div class="mt-7 space-y-5">

                <div>

                    <div class="flex justify-between text-xs">

                        <span class="text-slate-400">
                            Website
                        </span>

                        <span class="font-bold text-emerald-400">
                            Online
                        </span>

                    </div>

                    <div class="mt-2 h-2 rounded-full bg-white/10">

                        <div class="h-full w-full rounded-full bg-emerald-500"></div>

                    </div>

                </div>


                <div>

                    <div class="flex justify-between text-xs">

                        <span class="text-slate-400">
                            Database
                        </span>

                        <span class="font-bold text-emerald-400">
                            Connected
                        </span>

                    </div>

                    <div class="mt-2 h-2 rounded-full bg-white/10">

                        <div class="h-full w-full rounded-full bg-emerald-500"></div>

                    </div>

                </div>


                <div class="border-t border-white/10 pt-5">

                    <div class="text-xs text-slate-500">
                        Laravel
                    </div>

                    <div class="mt-1 font-bold">
                        {{ app()->version() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection