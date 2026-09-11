@extends('layouts.app')

@section('title', 'Sejarah HIMAFA')

@section('content')
<section class="relative overflow-hidden bg-slate-950 bg-mesh py-20">
    <div class="mx-auto max-w-4xl px-5 lg:px-8">

        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand-400">Tentang HIMAFA</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white sm:text-5xl">Sejarah HIMAFA</h1>
        </div>

        <div class="mt-16 space-y-10 border-l-2 border-brand-500/30 pl-8">
            <div class="relative">
                <span class="absolute -left-[41px] top-1 grid h-5 w-5 place-items-center rounded-full bg-brand-500 ring-4 ring-slate-950"></span>
                <p class="text-sm font-bold text-brand-300">± 2007</p>
                <p class="mt-2 leading-relaxed text-slate-300">
                    Himpunan Mahasiswa Farmasi (HIMAFA) Universitas Negeri Gorontalo telah menjadi bagian dari
                    perjalanan mahasiswa Farmasi sejak sekitar tahun 2007. Kehadirannya tumbuh seiring
                    perkembangan Jurusan Farmasi sebagai wadah yang menyatukan mahasiswa dalam semangat
                    kebersamaan, aspirasi, keilmuan, dan pengembangan potensi.
                </p>
            </div>

            <div class="relative">
                <span class="absolute -left-[41px] top-1 grid h-5 w-5 place-items-center rounded-full bg-brand-500 ring-4 ring-slate-950"></span>
                <p class="text-sm font-bold text-brand-300">2007 &mdash; 2026</p>
                <p class="mt-2 leading-relaxed text-slate-300">
                    Selama kurang lebih 19 tahun perjalanannya hingga tahun 2026, HIMAFA terus tumbuh dari
                    generasi ke generasi. Berbagai dinamika, gagasan, karya, dan prestasi telah mewarnai
                    perjalanan organisasi serta membentuk HIMAFA menjadi ruang bagi mahasiswa Farmasi untuk
                    belajar, berkolaborasi, mengembangkan kepemimpinan, dan memberikan kontribusi kepada
                    lingkungan kampus maupun masyarakat.
                </p>
            </div>

            <div class="relative">
                <span class="absolute -left-[41px] top-1 grid h-5 w-5 place-items-center rounded-full bg-brand-400 ring-4 ring-slate-950"></span>
                <p class="text-sm font-bold text-brand-300">Kini</p>
                <p class="mt-2 leading-relaxed text-slate-300">
                    Setelah hampir dua dekade perjalanan, HIMAFA terus membawa semangat yang sama: merawat
                    kebersamaan, meracik sinergi, dan menghasilkan prestasi &mdash; sekaligus menjadi rumah bagi
                    setiap generasi mahasiswa Farmasi Universitas Negeri Gorontalo.
                </p>
            </div>
        </div>

        <div class="mt-16 flex justify-center">
            <img src="{{ asset('images/logo-himafa.png') }}" alt="Logo HIMAFA" class="h-32 w-32 object-contain opacity-90">
        </div>
    </div>
</section>
@endsection
