@extends('layouts.admin')

@section('title', 'Edit Kegiatan Galeri')

@section('content')

<div class="space-y-6">

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            🖼️
        </div>

        <div>

            <h1 class="text-2xl font-black text-slate-900">
                Edit Kegiatan
            </h1>

            <p class="text-sm text-slate-500">
                {{ $gallery->judul }}
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
            action="{{ route('admin.galleries.update', $gallery) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 p-6 md:p-8"
        >
            @csrf
            @method('PUT')

            {{-- JUDUL --}}

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Judul Kegiatan
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="judul"
                    value="{{ old('judul', $gallery->judul) }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
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
                >{{ old('deskripsi', $gallery->deskripsi) }}</textarea>
            </div>

            {{-- URUTAN --}}

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Urutan Tampil
                </label>

                <input
                    type="number"
                    name="urutan"
                    value="{{ old('urutan', $gallery->urutan) }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            {{-- FOTO 1-3 --}}

            @for ($slot = 1; $slot <= 3; $slot++)

                @php
                    $existingPhoto = $gallery->photos->firstWhere('urutan', $slot);
                @endphp

                <div class="rounded-2xl border border-slate-200 p-4">

                    <label class="mb-3 block text-sm font-semibold text-slate-700">
                        Foto {{ $slot }}
                        @if ($slot === 1 && !$existingPhoto)
                            <span class="text-red-500">*</span>
                        @endif
                    </label>

                    @if ($existingPhoto)

                        <div class="mb-3 flex items-center gap-4">

                            <img
                                src="{{ asset('storage/' . $existingPhoto->foto) }}"
                                alt="Foto {{ $slot }}"
                                class="h-20 w-20 rounded-xl object-cover"
                            >

                            <label class="flex items-center gap-2 text-sm text-red-600">
                                <input
                                    type="checkbox"
                                    name="hapus_foto_{{ $slot }}"
                                    value="1"
                                    class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                                >
                                Hapus foto ini
                            </label>

                        </div>

                    @endif

                    <input
                        type="file"
                        name="foto_{{ $slot }}"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-bold file:text-white hover:file:bg-emerald-600"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        {{ $existingPhoto ? 'Upload untuk mengganti foto ini.' : 'Belum ada foto di slot ini.' }}
                    </p>

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
                    {{ old('aktif', $gallery->aktif) ? 'checked' : '' }}
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
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>

@endsection