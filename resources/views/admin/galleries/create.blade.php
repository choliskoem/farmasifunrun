@extends('layouts.admin')

@section('title', 'Tambah Kegiatan Galeri')

@section('content')

<div class="space-y-6">

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            🖼️
        </div>

        <div>

            <h1 class="text-2xl font-black text-slate-900">
                Tambah Kegiatan
            </h1>

            <p class="text-sm text-slate-500">
                Isi minimal 1 foto, maksimal 3 foto per kegiatan.
            </p>

        </div>

    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
            <ul class="list-inside list-disc text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <form
            action="{{ route('admin.galleries.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 p-6 md:p-8"
        >
            @csrf

            {{-- JUDUL --}}

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Judul Kegiatan
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul') }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="Contoh: Pelantikan Pengurus 2026"
                >
            </div>

            {{-- DESKRIPSI --}}

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="Opsional"
                >{{ old('deskripsi') }}</textarea>
            </div>

            {{-- URUTAN --}}

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Urutan Tampil
                </label>

                <input
                    type="number"
                    name="urutan"
                    value="{{ old('urutan') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="Angka kecil tampil duluan"
                >
            </div>

            {{-- FOTO 1-3 --}}

            @for ($slot = 1; $slot <= 3; $slot++)

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Foto {{ $slot }}
                        @if ($slot === 1)
                            <span class="text-red-500">*</span>
                        @else
                            <span class="text-xs font-normal text-slate-400">(opsional)</span>
                        @endif
                    </label>

                    <input
                        type="file"
                        name="foto_{{ $slot }}"
                        accept="image/jpeg,image/png,image/webp"
                        {{ $slot === 1 ? 'required' : '' }}
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-bold file:text-white hover:file:bg-emerald-600"
                    >

                    @error("foto_{$slot}")
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            @endfor

            <p class="text-xs text-slate-500">
                Format JPG/PNG/WEBP, maksimal 5MB per foto.
            </p>

            {{-- AKTIF --}}

            <label class="flex items-center gap-3">
                <input
                    type="checkbox"
                    name="aktif"
                    value="1"
                    {{ old('aktif', true) ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <span class="text-sm font-semibold text-slate-700">
                    Tampilkan di website
                </span>
            </label>

            {{-- SUBMIT --}}

            <button
                type="submit"
                class="w-full rounded-xl bg-emerald-600 px-6 py-4 font-bold text-white transition hover:bg-emerald-700"
            >
                Simpan Kegiatan
            </button>

        </form>

    </div>

</div>

@endsection