@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    {{-- ================= HERO ================= --}}
    <section class="relative overflow-hidden bg-slate-950 bg-mesh">
        {{-- Decorative molecule/pharmacy pattern --}}
        <svg class="pointer-events-none absolute -top-10 left-0 h-[520px] w-[520px] opacity-[0.07]" viewBox="0 0 200 200" fill="none">
            <circle cx="40" cy="40" r="3" fill="white"/><circle cx="100" cy="20" r="3" fill="white"/>
            <circle cx="160" cy="60" r="3" fill="white"/><circle cx="70" cy="90" r="3" fill="white"/>
            <circle cx="150" cy="130" r="3" fill="white"/><circle cx="30" cy="150" r="3" fill="white"/>
            <path d="M40 40 L100 20 M100 20 L160 60 M100 20 L70 90 M70 90 L150 130 M70 90 L30 150" stroke="white" stroke-width="1"/>
        </svg>
        <div class="pointer-events-none absolute -right-24 top-24 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-24 bottom-0 h-72 w-72 rounded-full bg-brand-700/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-6xl px-5 py-24 text-center lg:px-8 lg:py-32">
            <div class="animate-fade-up">
                <img src="{{ asset('images/logo-himafa.png') }}" alt="Logo HIMAFA"
                     class="mx-auto h-40 w-40 object-contain drop-shadow-[0_0_45px_rgba(61,139,245,0.55)] animate-float lg:h-48 lg:w-48">
            </div>

            <h1 class="mx-auto mt-8 max-w-3xl text-4xl font-extrabold leading-tight tracking-tight text-white animate-fade-up [animation-delay:100ms] sm:text-5xl lg:text-6xl">
                Himpunan Mahasiswa
                <span class="bg-gradient-to-r from-brand-300 via-brand-400 to-brand-200 bg-clip-text text-transparent">Jurusan Farmasi</span>
            </h1>

            <p class="mx-auto mt-5 max-w-xl text-lg font-semibold italic text-brand-200 animate-fade-up [animation-delay:180ms]">
                &ldquo;HIMAFA Meracik Sinergi, Menghasilkan Prestasi&rdquo;
            </p>

            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-slate-300 animate-fade-up [animation-delay:260ms]">
                HIMAFA hadir sebagai wadah mahasiswa Farmasi untuk menyatukan potensi, membangun kolaborasi,
                dan mengembangkan diri dalam semangat kebersamaan demi menciptakan karya, prestasi, serta
                kontribusi nyata bagi Farmasi dan masyarakat.
            </p>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-4 animate-fade-up [animation-delay:340ms]">
                <a href="{{ route('tentang.sejarah') }}"
                   class="rounded-full bg-brand-500 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-brand-500/30 transition hover:-translate-y-0.5 hover:bg-brand-400">
                    Kenali HIMAFA
                </a>
                <a href="{{ route('galeri') }}"
                   class="rounded-full border border-white/15 bg-white/5 px-7 py-3 text-sm font-bold text-white backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/10">
                    Lihat Galeri Kegiatan
                </a>
            </div>
        </div>
    </section>

    {{-- ================= QUICK STATS / SIGNATURE STRIP ================= --}}
    <section class="border-y border-white/10 bg-slate-900/60">
        <div class="mx-auto grid max-w-6xl grid-cols-2 gap-8 px-5 py-10 text-center lg:grid-cols-4 lg:px-8">
            <div>
                <p class="text-3xl font-extrabold text-brand-300">2007</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Tahun Berdiri</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-brand-300">19+</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Tahun Perjalanan</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-brand-300">7</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Bidang Kepengurusan</p>
            </div>
            <div>
                <p class="text-3xl font-extrabold text-brand-300">100+</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Anggota Aktif</p>
            </div>
        </div>
    </section>

    {{-- ================= NAVIGATION CARDS ================= --}}
    <section class="mx-auto max-w-6xl px-5 py-20 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand-400">Jelajahi</p>
            <h2 class="mt-2 text-3xl font-extrabold text-white sm:text-4xl">Kenali Lebih Dekat</h2>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <a href="{{ route('tentang.sejarah') }}" class="group rounded-2xl border border-white/10 bg-slate-900/60 p-7 transition hover:-translate-y-1 hover:border-brand-500/50 hover:bg-slate-900">
                <div class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/15 text-brand-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-white">Sejarah HIMAFA</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">Perjalanan hampir dua dekade sejak 2007 hingga menjadi rumah bagi mahasiswa Farmasi UNG.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-300 group-hover:gap-2 transition-all">Baca selengkapnya &rarr;</span>
            </a>

            <a href="{{ route('tentang.struktur') }}" class="group rounded-2xl border border-white/10 bg-slate-900/60 p-7 transition hover:-translate-y-1 hover:border-brand-500/50 hover:bg-slate-900">
                <div class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/15 text-brand-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" /></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-white">Struktur Organisasi</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">Susunan kepengurusan HIMAFA periode 2026, dari Ketua Umum hingga 7 bidang kerja.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-300 group-hover:gap-2 transition-all">Lihat struktur &rarr;</span>
            </a>

            <a href="{{ route('galeri') }}" class="group rounded-2xl border border-white/10 bg-slate-900/60 p-7 transition hover:-translate-y-1 hover:border-brand-500/50 hover:bg-slate-900">
                <div class="grid h-12 w-12 place-items-center rounded-xl bg-brand-500/15 text-brand-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 10.5h.008v.008H18V10.5zm-12 9h12a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0018 4.5H6a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 006 19.5z" /></svg>
                </div>
                <h3 class="mt-5 text-lg font-bold text-white">Galeri Kegiatan</h3>
                <p class="mt-2 text-sm leading-relaxed text-slate-400">Dokumentasi momen dan kegiatan yang telah dilaksanakan HIMAFA sepanjang periode.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-300 group-hover:gap-2 transition-all">Buka galeri &rarr;</span>
            </a>
        </div>
    </section>

@endsection
