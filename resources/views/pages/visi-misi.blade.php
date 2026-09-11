@extends('layouts.app')

@section('title', 'Visi & Misi')

@section('content')
<section class="relative overflow-hidden bg-slate-950 bg-mesh py-20">
    <div class="mx-auto max-w-4xl px-5 lg:px-8">

        <div class="text-center">
            <p class="text-sm font-bold uppercase tracking-widest text-brand-400">Tentang HIMAFA</p>
            <h1 class="mt-2 text-4xl font-extrabold text-white sm:text-5xl">Visi & Misi</h1>
        </div>

        {{-- VISI --}}
        <div class="mt-14 rounded-3xl border border-brand-500/30 bg-gradient-to-br from-brand-900/40 to-slate-900/60 p-8 text-center sm:p-10">
            <p class="text-xs font-bold uppercase tracking-widest text-brand-300">Visi</p>
            <p class="mx-auto mt-4 max-w-2xl text-xl font-semibold leading-relaxed text-white sm:text-2xl">
                &ldquo;Revitalisasi HIMAFA sebagai organisasi mahasiswa farmasi yang adaptif, inovatif, dan
                berdaya saing melalui tata kelola transparan dan profesional.&rdquo;
            </p>
        </div>

        {{-- MISI --}}
        <div class="mt-12">
            <p class="text-center text-xs font-bold uppercase tracking-widest text-brand-300">Misi</p>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                @foreach ($misi as $i => $item)
                    <div class="flex gap-4 rounded-2xl border border-white/10 bg-slate-900/60 p-6 transition hover:border-brand-500/40">
                        <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand-500/15 text-sm font-extrabold text-brand-300">
                            {{ $i + 1 }}
                        </span>
                        <p class="text-sm leading-relaxed text-slate-300">{{ $item }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endsection
