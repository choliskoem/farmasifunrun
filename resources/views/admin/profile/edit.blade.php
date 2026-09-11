@extends('layouts.admin')

@section('title', 'Profil HIMAFA')

@section('content')

    <div class="mx-auto max-w-5xl space-y-6">

        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">
                Profil HIMAFA
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola informasi dan sejarah HIMAFA.
            </p>
        </div>

        @if (session('success'))
            <div
                class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-bold">Terdapat kesalahan pada input:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')


            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-extrabold">
                    Informasi Organisasi
                </h2>

                <div class="mt-6 space-y-5">

                    <div>
                        <label class="text-sm font-bold text-slate-700">
                            Nama Organisasi
                        </label>

                        <input type="text" name="nama_organisasi"
                            value="{{ old('nama_organisasi', $profile->nama_organisasi ?? 'Himpunan Mahasiswa Jurusan Farmasi') }}"
                            class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                        @error('nama_organisasi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold text-slate-700">
                            Tagline
                        </label>

                        <input type="text" name="tagline"
                            value="{{ old('tagline', $profile->tagline ?? 'HIMAFA Meracik Sinergi, Menghasilkan Prestasi') }}"
                            class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                        @error('tagline')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold text-slate-700">
                            Tahun Berdiri
                        </label>

                        <input type="number" name="tahun_berdiri"
                            value="{{ old('tahun_berdiri', $profile->tahun_berdiri ?? '') }}" min="1900" max="2100"
                            class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                        @error('tahun_berdiri')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold text-slate-700">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi" rows="5"
                            class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">{{ old('deskripsi', $profile->deskripsi ?? '') }}</textarea>

                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold text-slate-700">
                            Gambar Hero
                        </label>

                        @if (!empty($profile->hero_image))
                            <div class="mt-2">
                                <img src="{{ Storage::disk('public')->url($profile->hero_image) }}" alt="Hero HIMAFA"
                                    class="h-32 w-auto rounded-xl border border-slate-200 object-cover">
                            </div>
                        @endif

                        <input type="file" name="hero_image" accept="image/png, image/jpeg, image/webp"
                            class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">

                        <p class="mt-1 text-xs text-slate-400">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 4MB.
                        </p>

                        @error('hero_image')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>


            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-extrabold">
                    Sejarah HIMAFA
                </h2>

                <div class="mt-6 space-y-5">

                    <div>
                        <label class="text-sm font-bold">
                            ± 2007
                        </label>

                        <textarea name="sejarah_awal" rows="5" class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">{{ old('sejarah_awal', $profile->sejarah_awal ?? '') }}</textarea>

                        @error('sejarah_awal')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold">
                            2007 — 2026
                        </label>

                        <textarea name="sejarah_perjalanan" rows="5" class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">{{ old('sejarah_perjalanan', $profile->sejarah_perjalanan ?? '') }}</textarea>

                        @error('sejarah_perjalanan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div>
                        <label class="text-sm font-bold">
                            Kini
                        </label>

                        <textarea name="sejarah_kini" rows="5" class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">{{ old('sejarah_kini', $profile->sejarah_kini ?? '') }}</textarea>

                        @error('sejarah_kini')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>


            <div class="flex justify-end">

                <button type="submit"
                    class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

@endsection
