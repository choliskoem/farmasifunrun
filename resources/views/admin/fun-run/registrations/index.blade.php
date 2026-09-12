@extends('layouts.admin')

@section('title', 'Peserta Fun Run')

@section('content')

@php
    $tabs = [
        'public' => ['label' => 'Umum', 'icon' => '🌐'],
        'invitation' => ['label' => 'Jalur Undangan', 'icon' => '🎟️'],
    ];

    if (auth()->user()->role !== 'user') {
        $tabs['backdoor'] = ['label' => 'Jalur Spesial', 'icon' => '🔑'];
    }
@endphp

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                    🏃
                </div>

                <div>

                    <h1 class="text-2xl font-black text-slate-900">
                        Peserta Fun Run
                    </h1>

                    <p class="text-sm text-slate-500">
                        Kelola peserta dan verifikasi pembayaran.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- STAT CARD --}}

    <div class="grid gap-4 sm:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-semibold text-slate-500">
                Total Peserta — {{ $tabs[$channel]['label'] ?? 'Umum' }}
            </p>

            <p class="mt-2 text-3xl font-black text-slate-900">
                {{ $stats['total'] }}
            </p>

        </div>


        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5">

            <p class="text-sm font-semibold text-amber-600">
                Menunggu Verifikasi
            </p>

            <p class="mt-2 text-3xl font-black text-amber-700">
                {{ $stats['waiting_verification'] }}
            </p>

        </div>


        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5">

            <p class="text-sm font-semibold text-emerald-600">
                Terverifikasi
            </p>

            <p class="mt-2 text-3xl font-black text-emerald-700">
                {{ $stats['paid'] }}
            </p>

        </div>

    </div>

    <p class="text-xs text-slate-400">
        Kartu "Ditolak" dihilangkan — begitu peserta ditolak, datanya
        langsung dihapus (bukan diberi status "rejected" lagi), jadi
        tidak ada lagi yang perlu dihitung di sini.
    </p>


    {{-- CHANNEL TABS --}}

    <div class="flex gap-2 overflow-x-auto">

        @foreach ($tabs as $tabChannel => $tab)

            <a
                href="{{ route('admin.fun-run.registrations', array_merge(request()->except(['channel', 'page']), ['channel' => $tabChannel])) }}"
                class="flex shrink-0 items-center gap-2 rounded-xl px-5 py-3 text-sm font-bold transition
                    {{ $channel === $tabChannel
                        ? 'bg-slate-900 text-white'
                        : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' }}"
            >
                <span>{{ $tab['icon'] }}</span>
                {{ $tab['label'] }}
                <span class="rounded-full px-2 py-0.5 text-xs
                    {{ $channel === $tabChannel ? 'bg-white/20' : 'bg-slate-100 text-slate-500' }}">
                    {{ $channelCounts[$tabChannel] }}
                </span>
            </a>

        @endforeach

    </div>


    {{-- TABLE --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <div class="flex flex-wrap items-center justify-between gap-3">

                <h2 class="font-bold text-slate-900">
                    Data Registrasi — {{ $tabs[$channel]['label'] ?? 'Umum' }}
                </h2>

                <a
                    href="{{ route('admin.fun-run.registrations.export', request()->except('page')) }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-sm font-bold text-slate-600 transition hover:bg-slate-50"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                    Export Excel
                </a>

            </div>

            {{-- SEARCH & FILTER --}}

            <form
                action="{{ route('admin.fun-run.registrations') }}"
                method="GET"
                class="mt-4 flex flex-col gap-3 sm:flex-row"
            >

                <input type="hidden" name="channel" value="{{ $channel }}">

                <div class="relative flex-1">

                    <svg
                        class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"
                        />
                    </svg>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama, email, NIK, atau no. telepon..."
                        class="w-full rounded-xl border border-slate-300 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    >

                </div>

                <select
                    name="category_id"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select
                    name="status"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                    <option value="">
                        Semua Status
                    </option>

                    <option value="waiting_payment" @selected(request('status') === 'waiting_payment')>
                        Menunggu Pembayaran
                    </option>

                    <option value="waiting_verification" @selected(request('status') === 'waiting_verification')>
                        Menunggu Verifikasi
                    </option>

                    <option value="paid" @selected(request('status') === 'paid')>
                        Terverifikasi
                    </option>
                </select>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-600"
                >
                    Cari
                </button>

                @if (request()->filled('search') || request()->filled('status') || request()->filled('category_id'))

                    <a
                        href="{{ route('admin.fun-run.registrations', ['channel' => $channel]) }}"
                        class="flex items-center justify-center rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>

                @endif

            </form>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            Kode
                        </th>

                        <th class="px-6 py-4">
                            Peserta
                        </th>

                        <th class="px-6 py-4">
                            Kategori
                        </th>

                        <th class="px-6 py-4">
                            Pembayaran
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($registrations as $registration)

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <div class="font-bold text-emerald-600">
                                    {{ $registration->registration_code }}
                                </div>

                                <div class="mt-1 text-xs text-slate-400">
                                    {{ $registration->created_at->format('d M Y H:i') }}
                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <div class="font-bold text-slate-900">
                                    {{ $registration->name }}
                                </div>

                                <div class="mt-1 text-xs text-slate-500">
                                    {{ $registration->email }}
                                </div>

                            </td>


                            <td class="px-6 py-4">

                                <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                    {{ $registration->category->name }}
                                </span>

                            </td>


                            <td class="px-6 py-4">

                                @if($registration->latestPayment)

                                    <div class="font-bold text-slate-900">
                                        Rp {{ number_format($registration->amount, 0, ',', '.') }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $registration->latestPayment->status }}
                                    </div>

                                @else

                                    <span class="text-xs text-slate-400">
                                        Belum ada pembayaran
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                @if($registration->status === 'waiting_verification')

                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                        Menunggu Verifikasi
                                    </span>

                                @elseif($registration->status === 'paid')

                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Terverifikasi
                                    </span>

                                @elseif($registration->status === 'waiting_payment')

                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        Menunggu Pembayaran
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        {{ $registration->status }}
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route(
                                        'admin.fun-run.registrations.show',
                                        $registration
                                    ) }}"
                                    class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-emerald-600"
                                >
                                    Lihat Detail
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="text-4xl">
                                    🏃
                                </div>

                                @if (request()->filled('search') || request()->filled('status') || request()->filled('category_id'))

                                    <p class="mt-3 font-bold text-slate-700">
                                        Tidak ada peserta yang cocok
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Coba kata kunci lain atau reset pencarian/filter.
                                    </p>

                                @else

                                    <p class="mt-3 font-bold text-slate-700">
                                        Belum ada peserta Fun Run
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Data peserta akan muncul setelah melakukan registrasi.
                                    </p>

                                @endif

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($registrations->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $registrations->links() }}
            </div>

        @endif

    </div>

</div>

@endsection