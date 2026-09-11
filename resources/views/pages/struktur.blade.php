@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<section class="relative overflow-hidden bg-slate-950 bg-mesh py-20">
    <div class="mx-auto max-w-6xl px-5 lg:px-8">

        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand-400">Tentang HIMAFA</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white sm:text-5xl">Struktur Kepengurusan</h1>
            <p class="mt-3 text-slate-400">Himpunan Mahasiswa Farmasi &mdash; Periode 2026</p>
        </div>

        {{-- PENGURUS INTI --}}
        <div class="mt-16 grid gap-5 sm:grid-cols-3">
            @foreach ($pengurusInti as $p)
                <div class="rounded-2xl border border-brand-500/30 bg-gradient-to-br from-brand-900/40 to-slate-900/60 p-6 text-center">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-300">{{ $p['jabatan'] }}</p>
                    <p class="mt-3 text-base font-bold text-white">{{ $p['nama'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- BIDANG --}}
        <div class="mt-8">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-slate-500">Bidang Kepengurusan</p>
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($bidang as $b)
                    <div class="rounded-2xl border border-white/10 bg-slate-900/60 p-6 transition hover:-translate-y-1 hover:border-brand-500/40">
                        <p class="text-sm font-extrabold uppercase tracking-wide text-brand-300">{{ $b['nama'] }}</p>
                        <div class="mt-4 space-y-3 text-sm">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Ketua Bidang</p>
                                <p class="mt-0.5 font-semibold text-white">{{ $b['ketua'] }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-500">Sekretaris Bidang</p>
                                <p class="mt-0.5 font-semibold text-slate-300">{{ $b['sekretaris'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <p class="mt-10 text-center text-xs text-slate-500">
            Daftar lengkap anggota tiap bidang dapat ditambahkan pada view ini sesuai data terbaru dari sekretariat HIMAFA.
        </p>
    </div>
</section>
@endsection
