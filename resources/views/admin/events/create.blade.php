@extends('layouts.admin')

@section('title', 'Tambah Event')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6">

        <div class="text-sm text-slate-500">
            Admin / Event / Tambah
        </div>

        <h1 class="mt-1 text-2xl font-extrabold">
            Tambah Event
        </h1>

    </div>


    <form
        action="{{ route('admin.events.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="rounded-2xl border bg-white p-6 shadow-sm"
    >

        @csrf

        <div class="space-y-5">

            <div>

                <label class="mb-2 block text-sm font-bold">
                    Nama Event
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <div>

                <label class="mb-3 block text-sm font-bold">
                    Tipe Event
                </label>

                <div class="grid gap-3 sm:grid-cols-2">

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="tipe"
                            value="full"
                            id="tipe-full"
                            class="peer sr-only"
                            {{ old('tipe', 'full') === 'full' ? 'checked' : '' }}
                        >

                        <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <p class="font-bold text-slate-800">Full Event</p>
                            <p class="mt-1 text-xs text-slate-500">Judul, deskripsi, tanggal, dan link ditampilkan lengkap.</p>
                        </div>

                    </label>

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="tipe"
                            value="flyer"
                            id="tipe-flyer"
                            class="peer sr-only"
                            {{ old('tipe') === 'flyer' ? 'checked' : '' }}
                        >

                        <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                            <p class="font-bold text-slate-800">Hanya Flyer</p>
                            <p class="mt-1 text-xs text-slate-500">Cuma gambar poster yang tampil, tanpa detail teks.</p>
                        </div>

                    </label>

                </div>

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    rows="5"
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >{{ old('deskripsi') }}</textarea>

            </div>


            <div class="grid gap-5 sm:grid-cols-2">

                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal') }}"
                        class="w-full rounded-xl border-slate-300 px-4 py-3"
                    >

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Tahun
                    </label>

                    <input
                        type="number"
                        name="tahun"
                        value="{{ old('tahun', date('Y')) }}"
                        class="w-full rounded-xl border-slate-300 px-4 py-3"
                    >

                </div>

            </div>


            <div id="full-only-fields">

                <label class="mb-2 block text-sm font-bold">
                    Link Event
                </label>

                <input
                    type="url"
                    name="link"
                    value="{{ old('link') }}"
                    placeholder="https://..."
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Gambar
                    <span id="gambar-required-mark" class="hidden text-red-500">*</span>
                </label>

                <input
                    type="file"
                    name="gambar"
                    id="gambar-input"
                    accept="image/*"
                    class="w-full rounded-xl border border-slate-300 p-2"
                >

                <p id="gambar-flyer-hint" class="mt-2 hidden text-xs text-slate-500">
                    Wajib diisi untuk tipe "Hanya Flyer" — gunakan gambar poster resolusi tinggi (rasio potret/3:4 disarankan).
                </p>

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                    required
                >

                    <option value="draft">
                        Draft
                    </option>

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="selesai">
                        Selesai
                    </option>

                </select>

            </div>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.events.index') }}"
                class="rounded-xl border px-5 py-3 font-bold"
            >
                Batal
            </a>

            <button
                class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white"
            >
                Simpan Event
            </button>

        </div>

    </form>

</div>

<script>
    const tipeFull = document.getElementById('tipe-full');
    const tipeFlyer = document.getElementById('tipe-flyer');
    const fullOnlyFields = document.getElementById('full-only-fields');
    const gambarInput = document.getElementById('gambar-input');
    const gambarRequiredMark = document.getElementById('gambar-required-mark');
    const gambarFlyerHint = document.getElementById('gambar-flyer-hint');

    function toggleTipe() {

        if (tipeFlyer.checked) {
            fullOnlyFields.classList.add('hidden');
            gambarInput.required = true;
            gambarRequiredMark.classList.remove('hidden');
            gambarFlyerHint.classList.remove('hidden');
        } else {
            fullOnlyFields.classList.remove('hidden');
            gambarInput.required = false;
            gambarRequiredMark.classList.add('hidden');
            gambarFlyerHint.classList.add('hidden');
        }

    }

    tipeFull.addEventListener('change', toggleTipe);
    tipeFlyer.addEventListener('change', toggleTipe);

    toggleTipe();
</script>

@endsection