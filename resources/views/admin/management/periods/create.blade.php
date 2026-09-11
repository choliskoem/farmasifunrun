@extends('layouts.admin')

@section('title', 'Tambah Periode')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <a
            href="{{ route('admin.management-periods.index') }}"
            class="text-sm font-semibold text-emerald-600"
        >
            ← Kembali
        </a>

        <h1 class="mt-3 text-2xl font-extrabold text-slate-900">
            Tambah Periode Kepengurusan
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Tambahkan periode kepengurusan baru.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('admin.management-periods.store') }}"
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >

        @csrf


        <div class="space-y-5">


            <div>

                <label class="mb-2 block text-sm font-bold text-slate-700">
                    Nama Periode
                </label>

                <input
                    type="text"
                    name="nama_periode"
                    value="{{ old('nama_periode') }}"
                    placeholder="Contoh: HIMAFA Periode 2026/2027"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                    outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    required
                >

            </div>


            <div class="grid gap-5 sm:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Tahun Mulai
                    </label>

                    <input
                        type="number"
                        name="tahun_mulai"
                        value="{{ old('tahun_mulai') }}"
                        placeholder="2026"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                        outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                        required
                    >

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold text-slate-700">
                        Tahun Selesai
                    </label>

                    <input
                        type="number"
                        name="tahun_selesai"
                        value="{{ old('tahun_selesai') }}"
                        placeholder="2027"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                        outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100"
                    >

                </div>

            </div>


            <label
                class="flex cursor-pointer items-center gap-3 rounded-xl
                bg-slate-50 p-4"
            >

                <input
                    type="checkbox"
                    name="aktif"
                    value="1"
                    class="h-5 w-5 rounded border-slate-300 text-emerald-600"
                >

                <div>

                    <div class="font-bold text-slate-800">
                        Jadikan periode aktif
                    </div>

                    <div class="text-xs text-slate-500">
                        Periode lain akan otomatis menjadi tidak aktif.
                    </div>

                </div>

            </label>


            <div class="flex justify-end gap-3 pt-3">

                <a
                    href="{{ route('admin.management-periods.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3
                    text-sm font-bold text-slate-600 hover:bg-slate-50"
                >
                    Batal
                </a>


                <button
                    type="submit"
                    class="rounded-xl bg-emerald-600 px-6 py-3
                    text-sm font-bold text-white hover:bg-emerald-700"
                >
                    Simpan Periode
                </button>

            </div>

        </div>

    </form>

</div>

@endsection