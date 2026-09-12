@extends('layouts.app')

@section('content')

    {{-- =========================================================
    NAVBAR
========================================================= --}}

    <header id="navbar" class="fixed inset-x-0 top-0 z-50 bg-transparent transition-all duration-300">
        <div class="container-himafa">

            <div class="flex h-20 items-center justify-between">

                {{-- Logo --}}
                <a href="#beranda" class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center">
                        <img src="{{ asset('images/LOGO HIMAFA.png') }}" alt="Logo HIMAFA"
                            class="h-11 w-11 rounded-2xl object-contain">
                    </div>

                    <div>
                        <div class="text-sm font-extrabold tracking-tight text-slate-900">
                            HIMAFA
                        </div>

                        <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                            Jurusan Farmasi
                        </div>
                    </div>

                </a>


                {{-- Desktop Menu --}}
                <nav class="hidden items-center gap-7 lg:flex">

                    <a href="#beranda" class="text-sm font-semibold text-slate-700 transition hover:text-emerald-600">
                        Beranda
                    </a>

                    <a href="#tentang" class="text-sm font-semibold text-slate-700 transition hover:text-emerald-600">
                        Tentang
                    </a>

                    <a href="#visi-misi" class="text-sm font-semibold text-slate-700 transition hover:text-emerald-600">
                        Visi & Misi
                    </a>

                    <a href="#organisasi" class="text-sm font-semibold text-slate-700 transition hover:text-emerald-600">
                        Organisasi
                    </a>

                    <a href="#galeri" class="text-sm font-semibold text-slate-700 transition hover:text-emerald-600">
                        Galeri
                    </a>

                </nav>


                {{-- Event --}}
                <a href="#event"
                    class="hidden rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700 lg:inline-flex">
                    Event HIMAFA
                </a>


                {{-- Mobile --}}
                <button id="mobile-menu-button" type="button"
                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>


            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="glass hidden rounded-2xl border border-slate-200 p-3 shadow-card lg:hidden">

                <a href="#beranda" class="block rounded-xl px-4 py-3 text-sm font-semibold hover:bg-emerald-50">
                    Beranda
                </a>

                <a href="#tentang" class="block rounded-xl px-4 py-3 text-sm font-semibold hover:bg-emerald-50">
                    Tentang
                </a>

                <a href="#visi-misi" class="block rounded-xl px-4 py-3 text-sm font-semibold hover:bg-emerald-50">
                    Visi & Misi
                </a>

                <a href="#organisasi" class="block rounded-xl px-4 py-3 text-sm font-semibold hover:bg-emerald-50">
                    Organisasi
                </a>

                <a href="#galeri" class="block rounded-xl px-4 py-3 text-sm font-semibold hover:bg-emerald-50">
                    Galeri
                </a>

                <a href="#event"
                    class="mt-2 block rounded-xl bg-emerald-600 px-4 py-3 text-center text-sm font-bold text-white">
                    Event HIMAFA
                </a>

            </div>

        </div>
    </header>


    {{-- =========================================================
    HERO
========================================================= --}}

    <main>

        <section id="beranda"
            class="relative min-h-screen overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-slate-50">

            <div class="absolute -left-32 top-32 h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>

            <div class="absolute -right-32 top-20 h-96 w-96 rounded-full bg-teal-300/20 blur-3xl"></div>


            <div class="container-himafa relative flex min-h-screen items-center px-4 pb-16 pt-28">

                <div class="grid w-full items-center gap-14 lg:grid-cols-2">

                    {{-- TEXT --}}
                    <div class="animate-fade-up">

                        <div
                            class="mb-6 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-white/80 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-emerald-700 shadow-sm">

                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                            Himpunan Mahasiswa

                        </div>


                        <h1
                            class="max-w-3xl text-5xl font-extrabold leading-[1.05] tracking-tight text-slate-900 sm:text-6xl lg:text-7xl">

                            Jurusan

                            <span class="relative whitespace-nowrap text-emerald-600">

                                Farmasi

                                <svg class="absolute -bottom-3 left-0 w-full" viewBox="0 0 300 20" fill="none">
                                    <path d="M3 15C72 4 188 3 297 11" stroke="#34D399" stroke-width="5"
                                        stroke-linecap="round" />
                                </svg>

                            </span>

                        </h1>


                        <h2 class="mt-8 max-w-2xl text-2xl font-bold leading-tight text-slate-800 sm:text-3xl">

                            “{{ $profile?->tagline ?? 'HIMAFA Meracik Sinergi, Menghasilkan Prestasi' }}”

                        </h2>


                        <p class="mt-6 max-w-xl text-base leading-8 text-slate-600 sm:text-lg">

                            {{ $profile?->deskripsi ?? 'HIMAFA hadir sebagai wadah mahasiswa Farmasi untuk menyatukan potensi, membangun kolaborasi, dan mengembangkan diri dalam semangat kebersamaan.' }}

                        </p>


                        <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                            <a href="#tentang"
                                class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-7 py-3.5 text-sm font-bold text-white shadow-xl shadow-emerald-600/20 transition hover:-translate-y-1 hover:bg-emerald-700">
                                Kenal Lebih Dekat

                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>

                            </a>


                            <a href="#galeri"
                                class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-200 bg-white px-7 py-3.5 text-sm font-bold text-slate-700 transition hover:-translate-y-1 hover:border-emerald-200 hover:text-emerald-600">
                                Lihat Kegiatan
                            </a>

                        </div>


                        {{-- STATS --}}
                        <div class="mt-12 flex flex-wrap gap-8 border-t border-slate-200 pt-7">

                            <div>
                                <div class="text-2xl font-extrabold text-slate-900">
                                    {{ $profile?->tahun_berdiri ?? '2007' }}
                                </div>

                                <div class="mt-1 text-xs font-medium text-slate-500">
                                    Awal Perjalanan
                                </div>
                            </div>


                            <div>
                                <div class="text-2xl font-extrabold text-slate-900">
                                    @if ($profile->tahun_berdiri)
                                        {{ max(1, date('Y') - $profile->tahun_berdiri) }}+
                                    @else
                                        19+
                                    @endif
                                </div>

                                <div class="mt-1 text-xs font-medium text-slate-500">
                                    Tahun Perjalanan
                                </div>
                            </div>


                            <div>
                                <div class="text-2xl font-extrabold text-slate-900">
                                    {{ $activePeriod?->tahun_mulai ?? date('Y') }}
                                </div>

                                <div class="mt-1 text-xs font-medium text-slate-500">
                                    Periode Kepengurusan
                                </div>
                            </div>

                        </div>

                    </div>


                    {{-- HERO IMAGE --}}
                    <div class="relative hidden lg:block">

                        <div class="absolute -inset-5 rounded-[3rem] bg-emerald-200/30 blur-2xl"></div>

                        <div
                            class="relative overflow-hidden rounded-[3rem] border border-white/80 bg-white p-3 shadow-2xl shadow-emerald-900/10">

                            <div class="relative aspect-[4/5] overflow-hidden rounded-[2.4rem] bg-emerald-100">

                                @if ($profile?->hero_image)
                                    <img src="{{ asset('storage/' . $profile->hero_image) }}" alt="HIMAFA"
                                        class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('images/hero-pharmacy.jpg') }}" alt="Kegiatan mahasiswa Farmasi"
                                        class="h-full w-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                @endif


                                <div
                                    class="absolute inset-0 hidden items-center justify-center bg-gradient-to-br from-emerald-500 to-teal-700">

                                    <div class="text-center text-white">

                                        <img src="{{ asset('images/LOGO HIMAFA.png') }}"
                                            class="mx-auto h-30 w-30 object-contain" alt="Pharmacy">
                                        {{-- <p class="mt-4 text-sm font-semibold">
                                            HIMAFAA
                                        </p> --}}

                                    </div>

                                </div>


                                <div class="absolute bottom-6 left-6 right-6">

                                    <div class="glass rounded-3xl border border-white/70 p-5 shadow-xl">

                                        <div class="flex items-center gap-4">

                                            <div
                                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white">

                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M12 2l3 7 7 .5-5.5 4.5L18.5 21 12 17l-6.5 4 2-7L2 9.5 9 9z" />
                                                </svg>

                                            </div>

                                            <div>

                                                <div class="text-sm font-extrabold text-slate-900">
                                                    Meracik Potensi
                                                </div>

                                                <div class="mt-1 text-xs text-slate-600">
                                                    Bersama untuk berprestasi
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
    TENTANG
========================================================= --}}

        <section id="tentang" class="bg-white py-24 sm:py-32">

            <div class="container-himafa">

                <div class="grid gap-14 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">

                    <div class="reveal">

                        <span class="section-label">
                            Tentang HIMAFA
                        </span>

                        <h2 class="section-title">

                            Tumbuh bersama,

                            <span class="text-emerald-600">
                                berkarya bersama.
                            </span>

                        </h2>

                    </div>


                    <div class="reveal">

                        <p class="text-lg leading-8 text-slate-600">

                            {{ $profile?->deskripsi ?? 'Himpunan Mahasiswa Farmasi Universitas Negeri Gorontalo merupakan wadah mahasiswa Farmasi untuk menyatukan potensi, membangun kolaborasi, menyampaikan aspirasi, mengembangkan keilmuan, dan meningkatkan potensi mahasiswa.' }}

                        </p>

                        @if ($profile?->sejarah_awal)
                            <p class="mt-5 leading-8 text-slate-500">
                                {{ $profile->sejarah_awal }}
                            </p>
                        @endif

                    </div>

                </div>


                {{-- HISTORY --}}

                <div class="relative mt-20">

                    <div class="absolute left-0 right-0 top-8 hidden h-px bg-emerald-100 lg:block"></div>

                    <div class="grid gap-8 lg:grid-cols-3">


                        {{-- AWAL --}}
                        <div class="reveal relative">

                            <div
                                class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-600 text-xl font-extrabold text-white shadow-lg">
                                01
                            </div>

                            <div class="mt-6 rounded-[2rem] border border-slate-200 bg-slate-50 p-7">

                                <div class="text-sm font-extrabold text-emerald-600">
                                    {{ $profile?->tahun_berdiri ?? '2007' }}
                                </div>

                                <h3 class="mt-3 text-xl font-extrabold text-slate-900">
                                    Awal Perjalanan
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-500">

                                    {{ $profile?->sejarah_awal ?? 'HIMAFA menjadi bagian dari perjalanan mahasiswa Farmasi Universitas Negeri Gorontalo.' }}

                                </p>

                            </div>

                        </div>


                        {{-- PERJALANAN --}}
                        <div class="reveal relative">

                            <div
                                class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-900 text-xl font-extrabold text-white shadow-lg">
                                02
                            </div>

                            <div class="mt-6 rounded-[2rem] bg-slate-900 p-7 text-white shadow-xl">

                                <div class="text-sm font-extrabold text-emerald-400">

                                    {{ $profile?->tahun_berdiri ?? '2007' }}
                                    —
                                    {{ date('Y') }}

                                </div>

                                <h3 class="mt-3 text-xl font-extrabold">
                                    Tumbuh dari Generasi ke Generasi
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-300">

                                    {{ $profile?->sejarah_perjalanan ?? 'Berbagai dinamika, gagasan, karya, dan prestasi terus mewarnai perjalanan HIMAFA.' }}

                                </p>

                            </div>

                        </div>


                        {{-- KINI --}}
                        <div class="reveal relative">

                            <div
                                class="relative z-10 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-xl font-extrabold text-emerald-700">
                                03
                            </div>

                            <div class="mt-6 rounded-[2rem] border border-emerald-100 bg-emerald-50 p-7">

                                <div class="text-sm font-extrabold text-emerald-600">
                                    Kini
                                </div>

                                <h3 class="mt-3 text-xl font-extrabold text-slate-900">
                                    Meracik Sinergi
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600">

                                    {{ $profile?->sejarah_kini ?? 'HIMAFA terus membawa semangat merawat kebersamaan, meracik sinergi, dan menghasilkan prestasi.' }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
    VISI MISI
========================================================= --}}

        <section id="visi-misi" class="relative overflow-hidden bg-slate-950 py-24 text-white sm:py-32">

            <div class="absolute -right-40 -top-40 h-96 w-96 rounded-full bg-emerald-500/20 blur-3xl"></div>

            <div class="absolute -bottom-40 -left-40 h-96 w-96 rounded-full bg-teal-500/10 blur-3xl"></div>


            <div class="container-himafa relative">

                <div class="reveal max-w-3xl">

                    <span
                        class="inline-flex rounded-full border border-emerald-400/20 bg-emerald-400/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-emerald-300">
                        Visi & Misi
                    </span>

                    <h2 class="mt-5 text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">

                        Arah langkah

                        <span class="text-emerald-400">
                            HIMAFA.
                        </span>

                    </h2>

                </div>


                <div class="mt-16 grid gap-8 lg:grid-cols-5">


                    {{-- VISI --}}
                    <div class="reveal rounded-[2rem] border border-white/10 bg-white/5 p-8 lg:col-span-2">

                        <div class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-400">
                            Visi
                        </div>

                        <div
                            class="mt-7 flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">

                            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z" />

                                <circle cx="12" cy="12" r="3" />

                            </svg>

                        </div>

                        <p class="mt-7 text-xl font-bold leading-relaxed text-white sm:text-2xl">

                            “{{ $vision?->isi ?? 'Revitalisasi HIMAFA sebagai organisasi mahasiswa farmasi yang adaptif, inovatif, dan berdaya saing melalui tata kelola transparan dan profesional.' }}”

                        </p>

                    </div>


                    {{-- MISI --}}
                    <div class="reveal lg:col-span-3">

                        <div class="mb-5 text-sm font-bold uppercase tracking-[0.2em] text-emerald-400">
                            Misi
                        </div>


                        <div class="space-y-4">

                            @forelse($missions as $mission)
                                <div
                                    class="rounded-2xl border border-white/10 bg-white/[0.04] p-5 transition hover:-translate-y-1 hover:bg-white/[0.08]">

                                    <div class="flex gap-4">

                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500/15 text-sm font-extrabold text-emerald-400">

                                            {{ str_pad($mission->nomor, 2, '0', STR_PAD_LEFT) }}

                                        </div>

                                        <p class="text-sm leading-7 text-slate-300">
                                            {{ $mission->isi }}
                                        </p>

                                    </div>

                                </div>

                            @empty

                                <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 text-sm text-slate-400">
                                    Data misi belum tersedia.
                                </div>
                            @endforelse

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
    ORGANISASI
========================================================= --}}

        <section id="organisasi" class="bg-slate-50 py-24 sm:py-32">

            <div class="container-himafa">


                <div class="reveal text-center">

                    <span class="section-label">
                        Struktur Kepengurusan
                    </span>

                    <h2 class="section-title">

                        HIMAFA

                        <span class="text-emerald-600">

                            {{ $activePeriod?->nama_periode ?? 'Periode Kepengurusan' }}

                        </span>

                    </h2>

                    <p class="mx-auto mt-5 max-w-2xl leading-8 text-slate-500">

                        Himpunan Mahasiswa Farmasi Universitas Negeri Gorontalo
                        terus bergerak melalui kepengurusan yang kolaboratif,
                        profesional, dan berorientasi pada pengembangan mahasiswa.

                    </p>

                </div>


                {{-- PERIODE --}}
                @if ($activePeriod)
                    <div
                        class="mx-auto mt-6 flex w-fit items-center gap-2 rounded-full bg-emerald-100 px-5 py-2 text-sm font-bold text-emerald-700">

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                        Periode {{ $activePeriod->tahun_mulai }}
                        @if ($activePeriod->tahun_selesai)
                            — {{ $activePeriod->tahun_selesai }}
                        @endif

                    </div>
                @endif


                {{-- CORE MANAGEMENT --}}

                <div class="mt-14 grid gap-5 md:grid-cols-3">

                    @php

                        $corePositions = ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'];

                    @endphp


                    @foreach ($corePositions as $index => $position)
                        @php
                            $person = $members->firstWhere('jabatan', $position);
                        @endphp


                        @if ($person)
                            <div
                                class="reveal rounded-[2rem] border border-slate-200 bg-white p-7 text-center shadow-card transition duration-300 hover:-translate-y-2 hover:border-emerald-200">

                                <div
                                    class="mx-auto flex h-24 w-24 items-center justify-center overflow-hidden rounded-3xl
                            {{ $index === 0 ? 'bg-emerald-600' : 'bg-emerald-50' }}">

                                    @if ($person->foto)
                                        <img src="{{ asset('storage/' . $person->foto) }}" alt="{{ $person->nama }}"
                                            class="h-full w-full object-cover">
                                    @else
                                        <span
                                            class="text-3xl
                                    {{ $index === 0 ? 'text-white' : 'text-emerald-600' }}">
                                            {{ $index === 0 ? '👑' : ($index === 1 ? '✦' : '◆') }}
                                        </span>
                                    @endif

                                </div>


                                <div class="mt-6 text-xs font-bold uppercase tracking-[0.18em] text-emerald-600">

                                    {{ $person->jabatan }}

                                </div>


                                <div class="mt-3 text-lg font-extrabold leading-7 text-slate-900">

                                    {{ $person->nama }}

                                </div>


                                <div class="mt-2 text-xs text-slate-400">

                                    {{ $activePeriod?->nama_periode }}

                                </div>

                            </div>
                        @endif
                    @endforeach

                </div>


                {{-- BIDANG --}}

                <div class="mt-14">

                    <div class="mb-7 flex items-center justify-between">

                        <div>

                            <div class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600">
                                Bidang Kepengurusan
                            </div>

                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">
                                Tim HIMAFA
                            </h3>

                        </div>


                        <div
                            class="hidden rounded-full bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-700 sm:block">

                            {{ $departments->count() }} Bidang

                        </div>

                    </div>


                    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">

                        @forelse($departments as $index => $department)
                            <div
                                class="reveal group rounded-[2rem] border border-slate-200 bg-white p-7 transition duration-300 hover:-translate-y-2 hover:border-emerald-200 hover:shadow-card">

                                <div class="flex items-start justify-between">

                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-sm font-extrabold text-emerald-600 transition group-hover:bg-emerald-600 group-hover:text-white">

                                        {{ str_pad($department->urutan ?? $index + 1, 2, '0', STR_PAD_LEFT) }}

                                    </div>


                                    <span
                                        class="rounded-full bg-slate-50 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                                        Bidang
                                    </span>

                                </div>


                                <h3 class="mt-6 text-xl font-extrabold text-slate-900">

                                    {{ $department->nama }}

                                </h3>


                                <p class="mt-3 text-sm leading-7 text-slate-500">

                                    {{ $department->deskripsi }}

                                </p>


                                <div class="mt-6 space-y-3 border-t border-slate-100 pt-5">

                                    <div>

                                        <div class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">
                                            Ketua Bidang
                                        </div>

                                        <div class="mt-1 text-sm font-bold text-slate-800">
                                            {{ $department->ketua }}
                                        </div>

                                    </div>


                                    <div>

                                        <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                                            Sekretaris Bidang
                                        </div>

                                        <div class="mt-1 text-sm font-semibold text-slate-600">
                                            {{ $department->sekretaris }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="md:col-span-2 lg:col-span-3">

                                <div
                                    class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-10 text-center">

                                    <div class="text-sm font-semibold text-slate-500">
                                        Belum ada data bidang kepengurusan.
                                    </div>

                                </div>

                            </div>
                        @endforelse

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
    GALERI
========================================================= --}}

        <section id="galeri" class="bg-white py-24 sm:py-32">

            <div class="container-himafa">

                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

                    <div class="reveal">

                        <span class="section-label">
                            Galeri Kegiatan
                        </span>

                        <h2 class="section-title">

                            Momen yang

                            <span class="text-emerald-600">
                                berarti.
                            </span>

                        </h2>

                    </div>

                    <p class="max-w-md leading-7 text-slate-500">

                        Dokumentasi perjalanan, kebersamaan, dan berbagai
                        kegiatan HIMAFA.

                    </p>

                </div>


                <div class="mt-12 grid grid-cols-2 gap-4 md:grid-cols-4">

                    @forelse($galleries as $index => $gallery)

                        @php
                            $photos = $gallery->photos;
                            $firstPhoto = $photos->first();
                        @endphp

                        <button type="button"
                            data-gallery="{{ asset('storage/' . $firstPhoto->foto) }}"
                            data-interval="3500"
                            class="gallery-slider reveal group relative overflow-hidden rounded-3xl bg-slate-100 text-left
                    {{ $index === 0 ? 'col-span-2 row-span-2 aspect-square' : 'aspect-square' }}">

                            @foreach ($photos as $slideIndex => $photo)
                                <img src="{{ asset('storage/' . $photo->foto) }}" alt="{{ $gallery->judul }}"
                                    data-slide-src="{{ asset('storage/' . $photo->foto) }}"
                                    class="gallery-slide absolute inset-0 h-full w-full object-cover transition duration-1000 group-hover:scale-105
                            {{ $slideIndex === 0 ? 'opacity-100' : 'opacity-0' }}">
                            @endforeach


                            <div
                                class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 transition group-hover:opacity-100">
                            </div>


                            <div
                                class="pointer-events-none absolute bottom-0 left-0 right-0 translate-y-3 p-5 text-white opacity-0 transition duration-300 group-hover:translate-y-0 group-hover:opacity-100">

                                <div class="text-sm font-bold">
                                    {{ $gallery->judul }}
                                </div>

                                @if ($gallery->deskripsi)
                                    <div class="mt-1 text-xs text-slate-200">
                                        {{ $gallery->deskripsi }}
                                    </div>
                                @endif

                            </div>


                            @if ($photos->count() > 1)
                                <div class="pointer-events-none absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5">
                                    @foreach ($photos as $slideIndex => $photo)
                                        <span
                                            class="gallery-dot h-1.5 w-1.5 rounded-full transition
                                    {{ $slideIndex === 0 ? 'bg-white' : 'bg-white/50' }}"></span>
                                    @endforeach
                                </div>
                            @endif

                        </button>

                    @empty

                        <div class="col-span-2 md:col-span-4">

                            <div class="rounded-[2rem] border border-dashed border-slate-300 p-10 text-center">

                                <p class="text-sm text-slate-500">
                                    Belum ada foto galeri.
                                </p>

                            </div>

                        </div>
                    @endforelse

                </div>

            </div>

        </section>


        {{-- =========================================================
EVENT
========================================================= --}}

        <section id="event" class="relative overflow-hidden bg-emerald-600 py-24 sm:py-32">

            {{-- BACKGROUND DECORATION --}}
            <div class="absolute inset-0 overflow-hidden">

                <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl">
                </div>

                <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-teal-950/20 blur-3xl">
                </div>

                <div
                    class="absolute left-1/2 top-1/2 h-72 w-72 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/5 blur-3xl">
                </div>

            </div>


            <div class="container-himafa relative">

                {{-- HEADER --}}
                <div class="reveal mx-auto max-w-3xl text-center">

                    <span
                        class="inline-flex rounded-full bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.2em] text-emerald-50">

                        HIMAFA Event

                    </span>


                    <h2 class="mt-6 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">

                        Ruang untuk bertemu,

                        <span class="text-emerald-100">
                            belajar & berkolaborasi.
                        </span>

                    </h2>


                    <p class="mx-auto mt-6 max-w-2xl leading-8 text-emerald-50">

                        Temukan berbagai event HIMAFA mulai dari seminar,
                        workshop, kompetisi, pengabdian masyarakat,
                        hingga kegiatan mahasiswa lainnya.

                    </p>

                </div>


                {{-- EVENT LIST --}}
                @if ($events->count())
                    <div class="mt-14 grid gap-6 md:grid-cols-2">

                        @foreach ($events as $index => $event)

                            @if ($event->isFlyerOnly())

                                {{-- =========================================================
                                    FLYER-ONLY EVENT (gambar poster + info, tanpa tombol link)
                                ========================================================= --}}

                                <div class="reveal group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-slate-950 shadow-2xl transition duration-300 hover:-translate-y-2 hover:shadow-black/30">

                                    @if ($event->gambar)

                                        <img
                                            src="{{ asset('storage/' . $event->gambar) }}"
                                            alt="{{ $event->nama }}"
                                            class="aspect-[3/4] w-full object-cover transition duration-500 group-hover:scale-105"
                                        >

                                    @else

                                        <div class="flex aspect-[3/4] w-full items-center justify-center bg-slate-900 text-sm text-slate-500">
                                            Flyer belum diunggah.
                                        </div>

                                    @endif

                                    <div class="p-6">

                                        <h3 class="text-xl font-extrabold leading-tight text-white">
                                            {{ $event->nama }}
                                        </h3>

                                        @if ($event->tanggal)
                                            <div class="mt-3 flex items-center gap-2 text-sm font-bold text-emerald-400">

                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>

                                                {{ $event->tanggal->format('d F Y') }}

                                            </div>
                                        @endif

                                        @if ($event->deskripsi)
                                            <p class="mt-3 text-sm leading-7 text-slate-400">
                                                {{ $event->deskripsi }}
                                            </p>
                                        @endif

                                    </div>

                                </div>

                            @else

                                {{-- =========================================================
                                    FULL EVENT (kartu lengkap)
                                ========================================================= --}}

                                <div
                                    class="reveal group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-slate-950 p-8 shadow-2xl transition duration-300 hover:-translate-y-2 hover:shadow-black/30 sm:p-10">

                                    {{-- DECORATION --}}
                                    <div
                                        class="absolute -right-20 -top-20 h-48 w-48 rounded-full bg-emerald-500/10 blur-3xl transition duration-500 group-hover:bg-emerald-500/20">
                                    </div>


                                    {{-- HEADER CARD --}}
                                    <div class="relative flex items-center justify-between gap-4">

                                        <div
                                            class="flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-emerald-400">

                                            <span
                                                class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10">

                                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}

                                            </span>

                                            Event HIMAFA

                                        </div>


                                        <div
                                            class="rounded-full bg-emerald-500/10 px-4 py-2 text-xs font-bold text-emerald-400">

                                            {{ $event->tahun ?? (optional($event->tanggal)->format('Y') ?? date('Y')) }}

                                        </div>

                                    </div>


                                    {{-- FLYER IMAGE (opsional) --}}
                                    @if ($event->gambar)
                                        <div class="relative mt-6 overflow-hidden rounded-2xl">
                                            <img
                                                src="{{ asset('storage/' . $event->gambar) }}"
                                                alt="{{ $event->nama }}"
                                                class="aspect-video w-full object-cover transition duration-500 group-hover:scale-105"
                                            >
                                        </div>
                                    @endif


                                    {{-- EVENT CONTENT --}}
                                    <div class="relative mt-8">

                                        <h3 class="text-2xl font-extrabold leading-tight text-white sm:text-3xl">

                                            {{ $event->nama }}

                                        </h3>


                                        @if ($event->tanggal)
                                            <div class="mt-4 flex items-center gap-2 text-sm font-bold text-emerald-400">

                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                                </svg>

                                                {{ $event->tanggal->format('d F Y') }}

                                            </div>
                                        @endif


                                        <p class="mt-5 text-sm leading-7 text-slate-400">

                                            {{ $event->deskripsi ?? 'Informasi event HIMAFA.' }}

                                        </p>

                                    </div>


                                    {{-- FOOTER CARD --}}
                                    <div
                                        class="relative mt-8 flex flex-col gap-4 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">

                                        <div>

                                            <div class="text-[10px] font-bold uppercase tracking-widest text-slate-500">

                                                HIMAFA

                                            </div>

                                            <div class="mt-1 text-sm font-semibold text-slate-300">

                                                Event & Kegiatan Mahasiswa

                                            </div>

                                        </div>


                                        @if ($event->link)
                                            <a href="{{ $event->link }}" target="_blank" rel="noopener noreferrer"
                                                class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-1 hover:bg-emerald-400">

                                                Lihat Event

                                                <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h14M13 6l6 6-6 6" />

                                                </svg>

                                            </a>
                                        @endif

                                    </div>

                                </div>

                            @endif

                        @endforeach

                    </div>


                    {{-- EVENT SUMMARY --}}
                    <div
                        class="reveal mx-auto mt-8 flex max-w-2xl flex-col items-center justify-center gap-4 rounded-3xl border border-white/10 bg-white/10 p-5 text-center backdrop-blur sm:flex-row sm:text-left">

                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10 text-white">

                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z" />

                            </svg>

                        </div>


                        <div>

                            <div class="text-sm font-extrabold text-white">

                                {{ $events->count() }} Event HIMAFA

                            </div>

                            <div class="mt-1 text-xs leading-6 text-emerald-100">

                                Ikuti berbagai kegiatan dan kolaborasi
                                yang diselenggarakan HIMAFA.

                            </div>

                        </div>

                    </div>
                @else
                    {{-- EMPTY EVENT --}}
                    <div class="reveal mx-auto mt-14 max-w-2xl">

                        <div
                            class="rounded-[2.5rem] border border-white/10 bg-slate-950 p-10 text-center shadow-2xl sm:p-14">

                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">

                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 7V3m8 4V3m-9 4h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z" />

                                </svg>

                            </div>


                            <div class="mt-7 text-xs font-bold uppercase tracking-widest text-emerald-400">

                                Upcoming Event

                            </div>


                            <h3 class="mt-4 text-3xl font-extrabold text-white">

                                Event HIMAFA

                            </h3>


                            <p class="mx-auto mt-4 max-w-md text-sm leading-7 text-slate-400">

                                Informasi event HIMAFA akan tersedia
                                di halaman ini.

                            </p>

                        </div>

                    </div>
                @endif

            </div>

        </section>


        {{-- =========================================================
    FOOTER
========================================================= --}}

        <footer class="bg-slate-950 text-white">

            <div class="container-himafa py-16">

                <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">


                    <div class="lg:col-span-2">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-600">

                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18" />

                                    <circle cx="12" cy="12" r="8.5" />

                                </svg>

                            </div>


                            <div>

                                <div class="font-extrabold">
                                    HIMAFA
                                </div>

                                <div class="text-xs text-slate-500">
                                    Himpunan Mahasiswa Jurusan Farmasi
                                </div>

                            </div>

                        </div>


                        <p class="mt-6 max-w-md text-sm leading-7 text-slate-400">

                            Meracik sinergi, menghasilkan prestasi.
                            Bersama mahasiswa Farmasi membangun organisasi
                            yang aktif, inovatif, profesional, kolaboratif,
                            dan berdampak.

                        </p>

                    </div>


                    {{-- NAVIGASI --}}
                    <div>

                        <div class="text-sm font-bold">
                            Navigasi
                        </div>

                        <div class="mt-5 space-y-3">

                            <a href="#beranda" class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                Beranda
                            </a>

                            <a href="#tentang" class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                Tentang
                            </a>

                            <a href="#visi-misi" class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                Visi & Misi
                            </a>

                            <a href="#organisasi" class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                Organisasi
                            </a>

                            <a href="#galeri" class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                Galeri
                            </a>

                        </div>

                    </div>


                    {{-- SOCIAL --}}
                    <div>

                        <div class="text-sm font-bold">
                            Ikuti Kami
                        </div>

                        <div class="mt-5 space-y-3">

                            @forelse($socialLinks as $social)
                                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer"
                                    class="block text-sm text-slate-400 transition hover:text-emerald-400">
                                    {{ $social->platform }}
                                </a>

                            @empty

                                <span class="text-sm text-slate-500">
                                    Belum ada sosial media.
                                </span>
                            @endforelse

                        </div>

                    </div>

                </div>


                <div class="mt-14 border-t border-white/10 pt-7">

                    <div class="flex flex-col justify-between gap-3 text-xs text-slate-500 sm:flex-row">

                        <div>
                            © {{ date('Y') }} HIMAFA. All rights reserved.
                        </div>

                        <div>
                            Himpunan Mahasiswa Jurusan Farmasi
                        </div>

                    </div>

                </div>

            </div>

        </footer>


        {{-- =========================================================
    LIGHTBOX
========================================================= --}}

        <div id="lightbox"
            class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/90 p-5 backdrop-blur-sm">

            <button id="lightbox-close" type="button"
                class="absolute right-5 top-5 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20">

                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>

            </button>


            <img id="lightbox-image" src="" alt="Gallery"
                class="max-h-[90vh] max-w-6xl rounded-2xl object-contain shadow-2xl">

        </div>


        {{-- =========================================================
    BACK TO TOP
========================================================= --}}

        <a id="back-to-top" href="#beranda"
            class="pointer-events-none fixed bottom-6 right-6 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white opacity-0 shadow-xl shadow-emerald-600/20 transition-all duration-300 hover:bg-emerald-700">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>

        </a>


        {{-- =========================================================
    JAVASCRIPT
========================================================= --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                /*
                |--------------------------------------------------------------------------
                | NAVBAR
                |--------------------------------------------------------------------------
                */

                const navbar = document.getElementById('navbar');

                window.addEventListener('scroll', function() {

                    if (window.scrollY > 30) {

                        navbar.classList.add(
                            'bg-white/90',
                            'backdrop-blur-xl',
                            'shadow-sm',
                            'border-b',
                            'border-slate-100'
                        );

                    } else {

                        navbar.classList.remove(
                            'bg-white/90',
                            'backdrop-blur-xl',
                            'shadow-sm',
                            'border-b',
                            'border-slate-100'
                        );

                    }

                });


                /*
                |--------------------------------------------------------------------------
                | MOBILE MENU
                |--------------------------------------------------------------------------
                */

                const mobileButton =
                    document.getElementById('mobile-menu-button');

                const mobileMenu =
                    document.getElementById('mobile-menu');

                mobileButton?.addEventListener('click', function() {

                    mobileMenu.classList.toggle('hidden');

                });


                document.querySelectorAll('#mobile-menu a')
                    .forEach(function(link) {

                        link.addEventListener('click', function() {

                            mobileMenu.classList.add('hidden');

                        });

                    });


                /*
                |--------------------------------------------------------------------------
                | REVEAL ANIMATION
                |--------------------------------------------------------------------------
                */

                const revealElements =
                    document.querySelectorAll('.reveal');


                if ('IntersectionObserver' in window) {

                    const revealObserver =
                        new IntersectionObserver(
                            function(entries) {

                                entries.forEach(function(entry) {

                                    if (entry.isIntersecting) {

                                        entry.target.classList.add(
                                            'opacity-100',
                                            'translate-y-0'
                                        );

                                        entry.target.classList.remove(
                                            'opacity-0',
                                            'translate-y-8'
                                        );

                                        revealObserver.unobserve(
                                            entry.target
                                        );

                                    }

                                });

                            }, {
                                threshold: 0.1
                            }
                        );


                    revealElements.forEach(function(element) {

                        element.classList.add(
                            'opacity-0',
                            'translate-y-8',
                            'transition-all',
                            'duration-700'
                        );

                        revealObserver.observe(element);

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | GALLERY AUTO-SLIDE
                |--------------------------------------------------------------------------
                */

                function setActiveGallerySlide(slider, slides, dots, index) {

                    slides.forEach(function(slide, i) {
                        slide.classList.toggle('opacity-100', i === index);
                        slide.classList.toggle('opacity-0', i !== index);
                    });

                    dots.forEach(function(dot, i) {
                        dot.classList.toggle('bg-white', i === index);
                        dot.classList.toggle('bg-white/50', i !== index);
                    });

                    slider.dataset.gallery = slides[index].dataset.slideSrc;

                }


                document.querySelectorAll('.gallery-slider')
                    .forEach(function(slider) {

                        const slides = Array.from(
                            slider.querySelectorAll('.gallery-slide')
                        );

                        const dots = Array.from(
                            slider.querySelectorAll('.gallery-dot')
                        );

                        if (slides.length <= 1) {
                            return;
                        }

                        const interval =
                            parseInt(slider.dataset.interval || '3500', 10);

                        let current = 0;

                        setInterval(function() {

                            current = (current + 1) % slides.length;

                            setActiveGallerySlide(
                                slider,
                                slides,
                                dots,
                                current
                            );

                        }, interval);

                    });


                /*
                |--------------------------------------------------------------------------
                | GALLERY LIGHTBOX
                |--------------------------------------------------------------------------
                */

                const lightbox =
                    document.getElementById('lightbox');

                const lightboxImage =
                    document.getElementById('lightbox-image');

                const lightboxClose =
                    document.getElementById('lightbox-close');


                document.querySelectorAll('[data-gallery]')
                    .forEach(function(button) {

                        button.addEventListener('click', function() {

                            const image = this.dataset.gallery;

                            if (!image) {
                                return;
                            }

                            lightboxImage.src = image;

                            lightbox.classList.remove('hidden');

                            lightbox.classList.add('flex');

                            document.body.classList.add(
                                'overflow-hidden'
                            );

                        });

                    });


                function closeLightbox() {

                    lightbox.classList.add('hidden');

                    lightbox.classList.remove('flex');

                    lightboxImage.src = '';

                    document.body.classList.remove(
                        'overflow-hidden'
                    );

                }


                lightboxClose?.addEventListener(
                    'click',
                    closeLightbox
                );


                lightbox?.addEventListener(
                    'click',
                    function(event) {

                        if (event.target === lightbox) {

                            closeLightbox();

                        }

                    }
                );


                document.addEventListener(
                    'keydown',
                    function(event) {

                        if (event.key === 'Escape') {

                            closeLightbox();

                        }

                    }
                );


                /*
                |--------------------------------------------------------------------------
                | BACK TO TOP
                |--------------------------------------------------------------------------
                */

                const backToTop =
                    document.getElementById('back-to-top');


                window.addEventListener(
                    'scroll',
                    function() {

                        if (window.scrollY > 500) {

                            backToTop.classList.remove(
                                'opacity-0',
                                'pointer-events-none'
                            );

                            backToTop.classList.add(
                                'opacity-100'
                            );

                        } else {

                            backToTop.classList.add(
                                'opacity-0',
                                'pointer-events-none'
                            );

                            backToTop.classList.remove(
                                'opacity-100'
                            );

                        }

                    }
                );

            });
        </script>

    @endsection