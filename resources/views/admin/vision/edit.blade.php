@extends('layouts.admin')

@section('title', 'Visi HIMAFA')

@section('content')

    <div class="mx-auto max-w-4xl">

        <div class="mb-6">
            <h1 class="text-3xl font-extrabold">
                Visi HIMAFA
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola visi organisasi HIMAFA.
            </p>
        </div>


        <form action="{{ route('admin.vision.update') }}" method="POST"
            class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

            @csrf
            @method('PUT')

            <label class="text-sm font-bold">
                Visi
            </label>

            <textarea name="isi" rows="8"
                class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3 focus:border-emerald-500 focus:ring-emerald-500">{{ old('isi', $vision->isi ?? '') }}</textarea>

            @error('isi')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <div class="mt-6 flex items-center gap-3">

                <input type="checkbox" name="aktif" id="aktif" value="1" @checked(old('aktif', $vision->aktif ?? false))
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">

                <label for="aktif" class="text-sm font-semibold text-slate-700">
                    Tampilkan visi ini di halaman publik
                </label>

            </div>

            <div class="mt-6 flex justify-end">

                <button type="submit"
                    class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white hover:bg-emerald-700">

                    Simpan Visi

                </button>

            </div>

        </form>

    </div>

@endsection
