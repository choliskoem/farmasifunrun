@extends('layouts.admin')

@section('title', 'Tambah Bidang')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <div class="text-sm text-slate-500">
            Admin / Bidang / Tambah
        </div>

        <h1 class="mt-1 text-2xl font-extrabold">
            Tambah Bidang
        </h1>

    </div>


    <form
        action="{{ route('admin.departments.store') }}"
        method="POST"
        class="rounded-2xl border bg-white p-6 shadow-sm"
    >

        @csrf

        <div class="space-y-5">

            <div>

                <label class="mb-2 block text-sm font-bold">
                    Periode
                </label>

                <select
                    name="management_period_id"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

                    <option value="">
                        -- Pilih Periode --
                    </option>

                    @foreach($periods as $period)

                        <option value="{{ $period->id }}">
                            {{ $period->nama_periode }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Nama Bidang
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Contoh: Bidang PSDM"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="4"
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >{{ old('deskripsi') }}</textarea>

            </div>


            <div class="grid gap-5 sm:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Ketua
                    </label>

                    <input
                        type="text"
                        name="ketua"
                        value="{{ old('ketua') }}"
                        required
                        class="w-full rounded-xl border-slate-300 px-4 py-3"
                    >

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Sekretaris
                    </label>

                    <input
                        type="text"
                        name="sekretaris"
                        value="{{ old('sekretaris') }}"
                        required
                        class="w-full rounded-xl border-slate-300 px-4 py-3"
                    >

                </div>

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Urutan
                </label>

                <input
                    type="number"
                    name="urutan"
                    value="{{ old('urutan', 0) }}"
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="aktif"
                    value="1"
                    checked
                    class="h-5 w-5 rounded text-emerald-600"
                >

                <span class="text-sm font-semibold">
                    Bidang aktif
                </span>

            </label>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.departments.index') }}"
                class="rounded-xl border px-5 py-3 font-bold"
            >
                Batal
            </a>

            <button
                class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white"
            >
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection