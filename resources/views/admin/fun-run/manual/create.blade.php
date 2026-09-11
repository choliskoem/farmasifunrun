@extends('layouts.admin')

@section('title', 'Registrasi Manual')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            📝
        </div>

        <div>

            <h1 class="text-2xl font-black text-slate-900">
                Registrasi Manual
            </h1>

            <p class="text-sm text-slate-500">
                Daftarkan peserta langsung tanpa lewat form publik. Status peserta
                otomatis "Lunas" begitu disimpan.
            </p>

        </div>

    </div>


    <div class="max-w-2xl overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <form
            action="{{ route('admin.fun-run.manual.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 p-6 md:p-8"
        >
            @csrf

            {{-- JALUR --}}

            <div>

                <label class="mb-3 block text-sm font-bold text-slate-700">
                    Jalur Pendaftaran
                </label>

                <div class="grid gap-4 sm:grid-cols-2">

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="channel"
                            value="invitation"
                            class="peer sr-only"
                            id="channel-invitation"
                            {{ old('channel', 'invitation') === 'invitation' ? 'checked' : '' }}
                        >

                        <div
                            class="h-full rounded-2xl border-2 border-slate-200 p-4 transition
                                   hover:border-slate-300
                                   peer-checked:border-emerald-500
                                   peer-checked:bg-emerald-50
                                   peer-checked:ring-2
                                   peer-checked:ring-emerald-500/20"
                        >
                            <p class="font-bold text-slate-900">
                                Jalur Undangan
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                Gratis, harga otomatis Rp 0.
                            </p>
                        </div>

                    </label>

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="channel"
                            value="backdoor"
                            class="peer sr-only"
                            id="channel-backdoor"
                            {{ old('channel') === 'backdoor' ? 'checked' : '' }}
                        >

                        <div
                            class="h-full rounded-2xl border-2 border-slate-200 p-4 transition
                                   hover:border-slate-300
                                   peer-checked:border-emerald-500
                                   peer-checked:bg-emerald-50
                                   peer-checked:ring-2
                                   peer-checked:ring-emerald-500/20"
                        >
                            <p class="font-bold text-slate-900">
                                Jalur Spesial
                            </p>
                            <p class="mt-1 text-sm text-slate-500">
                                Harga diinput manual oleh admin.
                            </p>
                        </div>

                    </label>

                </div>

            </div>

            {{-- KATEGORI --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Kategori
                    <span class="text-red-500">*</span>
                </label>

                <select
                    name="category_id"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                    <option value="">
                        Pilih kategori
                    </option>

                    @foreach ($categories as $category)
                        @php
                            $soldOut = $category->manual_remaining !== null
                                && $category->manual_remaining <= 0;
                        @endphp
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id') == $category->id)
                            @disabled($soldOut)
                        >
                            {{ $category->name }}
                            @if ($soldOut)
                                (Stok Habis)
                            @elseif ($category->manual_remaining !== null)
                                (Sisa {{ $category->manual_remaining }})
                            @endif
                        </option>
                    @endforeach

                </select>

                <p class="mt-2 text-xs text-slate-500">
                    Jalur Undangan & Spesial berbagi satu stok yang sama per
                    kategori, terpisah dari stok periode publik (Early Bird, dst).
                </p>

            </div>

            {{-- NAMA --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Nama Lengkap
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="Nama lengkap peserta"
                >

            </div>

            {{-- EMAIL --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Email
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="nama@email.com"
                >

            </div>

            {{-- WA --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Nomor WA
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="08xxxxxxxxxx"
                >

            </div>

            {{-- NIK --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    NIK
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    name="identity_number"
                    value="{{ old('identity_number') }}"
                    required
                    inputmode="numeric"
                    pattern="\d{16}"
                    maxlength="16"
                    minlength="16"
                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16)"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="16 digit NIK sesuai KTP"
                >

                <p class="mt-1 text-xs text-slate-500">
                    Harus tepat 16 digit angka.
                </p>

            </div>

            {{-- UKURAN BAJU --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Ukuran Baju
                </label>

                <select
                    name="shirt_size"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
                    <option value="">
                        Tidak diisi
                    </option>

                    @foreach (['S', 'M', 'L', 'XL', '2XL', '3XL'] as $size)
                        <option value="{{ $size }}" @selected(old('shirt_size') === $size)>
                            {{ $size }}
                        </option>
                    @endforeach

                </select>

            </div>

            {{-- RIWAYAT PENYAKIT --}}

            <div>

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Riwayat Penyakit
                </label>

                <textarea
                    name="medical_history"
                    rows="3"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    placeholder="Contoh: asma, jantung, alergi tertentu. Kosongkan jika tidak ada / tidak diketahui."
                >{{ old('medical_history') }}</textarea>

            </div>

            {{-- HARGA --}}

            <div id="price-field-invitation" class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">
                <p class="text-sm font-semibold text-emerald-700">
                    Harga: Gratis (Rp 0)
                </p>
            </div>

            <div id="price-field-backdoor" class="hidden space-y-4">

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga (manual)
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="number"
                        name="amount"
                        min="0"
                        step="1"
                        value="{{ old('amount') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        placeholder="Contoh: 50000"
                    >

                </div>

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Bukti Pembayaran
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="file"
                        name="proof"
                        accept="image/jpeg,image/png,image/webp"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none file:mr-4 file:rounded-lg file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-bold file:text-white hover:file:bg-emerald-600"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Format JPG/PNG/WEBP, maksimal 5MB.
                    </p>

                    @error('proof')
                        <p class="mt-2 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

            {{-- SUBMIT --}}

            <button
                type="submit"
                class="w-full rounded-xl bg-emerald-600 px-6 py-4 font-bold text-white transition hover:bg-emerald-700"
            >
                Daftarkan Peserta
            </button>

        </form>

    </div>

</div>

<script>
    const invitationRadio = document.getElementById('channel-invitation');
    const backdoorRadio = document.getElementById('channel-backdoor');

    const invitationField = document.getElementById('price-field-invitation');
    const backdoorField = document.getElementById('price-field-backdoor');
    const amountInput = backdoorField.querySelector('input[name="amount"]');
    const proofInput = backdoorField.querySelector('input[name="proof"]');

    function toggleChannel() {

        if (backdoorRadio.checked) {
            invitationField.classList.add('hidden');
            backdoorField.classList.remove('hidden');
            amountInput.required = true;
            proofInput.required = true;
        } else {
            invitationField.classList.remove('hidden');
            backdoorField.classList.add('hidden');
            amountInput.required = false;
            proofInput.required = false;
        }

    }

    invitationRadio.addEventListener('change', toggleChannel);
    backdoorRadio.addEventListener('change', toggleChannel);

    toggleChannel();
</script>

@endsection