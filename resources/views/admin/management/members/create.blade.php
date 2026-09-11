@extends('layouts.admin')

@section('title', 'Tambah Pengurus')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <a
            href="{{ route('admin.management-members.index') }}"
            class="text-sm font-semibold text-emerald-600"
        >
            ← Kembali
        </a>

        <h1 class="mt-3 text-2xl font-extrabold text-slate-900">
            Tambah Pengurus
        </h1>

    </div>


    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route('admin.management-members.store') }}"
        class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >

        @csrf


        <div>

            <label class="mb-2 block text-sm font-bold">
                Periode
            </label>

            <select
                name="management_period_id"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
                required
            >

                <option value="">
                    -- Pilih Periode --
                </option>

                @foreach($periods as $period)

                    <option
                        value="{{ $period->id }}"
                        @selected(old('management_period_id') == $period->id)
                    >
                        {{ $period->nama_periode }}
                    </option>

                @endforeach

            </select>

        </div>


        <div>

            <label class="mb-2 block text-sm font-bold">
                Jabatan
            </label>

            <input
                type="text"
                name="jabatan"
                value="{{ old('jabatan') }}"
                placeholder="Contoh: Ketua Umum"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
                required
            >

        </div>


        <div>

            <label class="mb-2 block text-sm font-bold">
                Nama
            </label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
                required
            >

        </div>


        <div>

            <label class="mb-2 block text-sm font-bold">
                Foto
            </label>

            <input
                type="file"
                name="foto"
                accept=".jpg,.jpeg,.png,.webp"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
            >

            <p class="mt-1 text-xs text-slate-500">
                Maksimal 4 MB.
            </p>

        </div>


        <div>

            <label class="mb-2 block text-sm font-bold">
                Urutan
            </label>

            <input
                type="number"
                name="urutan"
                value="{{ old('urutan', 0) }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3"
            >

        </div>


        <label class="flex items-center gap-3 rounded-xl bg-slate-50 p-4">

            <input
                type="checkbox"
                name="aktif"
                value="1"
                checked
                class="h-5 w-5 rounded text-emerald-600"
            >

            <span class="font-bold">
                Pengurus aktif
            </span>

        </label>


        <div class="flex justify-end gap-3 pt-4">

            <a
                href="{{ route('admin.management-members.index') }}"
                class="rounded-xl border border-slate-300 px-5 py-3 font-bold"
            >
                Batal
            </a>

            <button
                type="submit"
                class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white hover:bg-emerald-700"
            >
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection