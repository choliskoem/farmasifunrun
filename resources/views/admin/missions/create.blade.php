@extends('layouts.admin')

@section('title', 'Tambah Misi')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold">
            Tambah Misi
        </h1>

        <p class="mt-2 text-sm text-slate-500">
            Tambahkan misi baru HIMAFA.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-bold">Terdapat kesalahan pada input:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form
        action="{{ route('admin.missions.store') }}"
        method="POST"
        class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">

        @csrf

        <div>
            <label class="text-sm font-bold">
                Nomor Urut
            </label>

            <input
                type="number"
                name="nomor"
                value="{{ old('nomor', $nextNumber ?? 1) }}"
                min="1"
                required
                class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">

            @error('nomor')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <div class="mt-5">
            <label class="text-sm font-bold">
                Isi Misi
            </label>

            <textarea
                name="isi"
                rows="6"
                required
                class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">{{ old('isi') }}</textarea>

            @error('isi')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <div class="mt-5 flex items-center gap-3">

            <input
                type="checkbox"
                name="aktif"
                id="aktif"
                value="1"
                {{ old('aktif', true) ? 'checked' : '' }}
                class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">

            <label for="aktif" class="text-sm font-bold text-slate-700">
                Aktif ditampilkan di website
            </label>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.missions.index') }}"
                class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-600">

                Batal

            </a>

            <button
                type="submit"
                class="rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white">

                Simpan

            </button>

        </div>

    </form>

</div>

@endsection