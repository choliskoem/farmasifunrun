@extends('layouts.app')

@section('title', 'Fun Run')

@section('content')
<section class="relative overflow-hidden bg-slate-950 bg-mesh py-24">
    <div class="mx-auto max-w-3xl px-5 text-center lg:px-8">
        <p class="text-sm font-bold uppercase tracking-widest text-brand-400">Event HIMAFA</p>
        <h1 class="mt-2 text-4xl font-extrabold text-white sm:text-5xl">Fun Run</h1>
        <p class="mx-auto mt-5 max-w-xl leading-relaxed text-slate-400">
            Bagian dari rangkaian <span class="font-semibold text-brand-300">Pharmacy Run Fest 2026</span>,
            memperingati Dies Natalis ke-19 Jurusan Farmasi UNG. Nikmati pengalaman berlari yang menyenangkan
            sambil merayakan semangat hidup sehat dan kebersamaan.
        </p>
        <div class="mt-10">
            <span class="inline-block rounded-full border border-brand-500/40 bg-brand-500/10 px-6 py-3 text-sm font-semibold text-brand-200">
                Detail lengkap &amp; pendaftaran tersedia di microsite Pharmacy Run Fest 2026
            </span>
        </div>
    </div>
</section>
@endsection
