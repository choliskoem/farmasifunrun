@extends('layouts.admin')

@section('title', 'Galeri Kegiatan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                🖼️
            </div>

            <div>

                <h1 class="text-2xl font-black text-slate-900">
                    Galeri Kegiatan
                </h1>

                <p class="text-sm text-slate-500">
                    Satu kegiatan bisa punya sampai 3 foto, tampil auto-slide di website.
                </p>

            </div>

        </div>

        <a
            href="{{ route('admin.galleries.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-700"
        >
            + Tambah Kegiatan
        </a>

    </div>


    {{-- ALERT --}}

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- LIST --}}

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

        @forelse ($galleries as $gallery)

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- PHOTO PREVIEW STRIP --}}

                <div class="grid grid-cols-3 gap-0.5 bg-slate-100">

                    @for ($slot = 1; $slot <= 3; $slot++)

                        @php
                            $photo = $gallery->photos->firstWhere('urutan', $slot);
                        @endphp

                        <div class="aspect-square overflow-hidden bg-slate-200">

                            @if ($photo)
                                <img
                                    src="{{ asset('storage/' . $photo->foto) }}"
                                    alt="{{ $gallery->judul }} - foto {{ $slot }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-xs text-slate-400">
                                    Kosong
                                </div>
                            @endif

                        </div>

                    @endfor

                </div>

                <div class="p-5">

                    <div class="flex items-start justify-between gap-2">

                        <p class="font-bold text-slate-900">
                            {{ $gallery->judul }}
                        </p>

                        @if ($gallery->aktif)
                            <span class="shrink-0 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                Aktif
                            </span>
                        @else
                            <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                Nonaktif
                            </span>
                        @endif

                    </div>

                    @if ($gallery->deskripsi)
                        <p class="mt-2 line-clamp-2 text-sm text-slate-500">
                            {{ $gallery->deskripsi }}
                        </p>
                    @endif

                    <p class="mt-2 text-xs text-slate-400">
                        Urutan: {{ $gallery->urutan ?? '-' }}
                        &middot;
                        {{ $gallery->photos->count() }}/3 foto
                    </p>

                    <div class="mt-4 flex gap-2">

                        <a
                            href="{{ route('admin.galleries.edit', $gallery) }}"
                            class="flex-1 rounded-xl bg-slate-900 px-4 py-2.5 text-center text-xs font-bold text-white transition hover:bg-emerald-600"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.galleries.destroy', $gallery) }}"
                            method="POST"
                            onsubmit="return confirm('Hapus kegiatan ini beserta semua fotonya?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-xs font-bold text-red-600 transition hover:bg-red-100"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white p-16 text-center">

                <div class="text-4xl">
                    🖼️
                </div>

                <p class="mt-3 font-bold text-slate-700">
                    Belum ada kegiatan di galeri
                </p>

                <p class="mt-1 text-sm text-slate-400">
                    Klik "+ Tambah Kegiatan" untuk mulai menambahkan.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection