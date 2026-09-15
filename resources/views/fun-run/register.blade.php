<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi {{ $event->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[#0B1120]">

    <div class="min-h-screen px-4 py-10">

        <div class="mx-auto max-w-3xl">

            {{-- Header --}}
            <div class="mb-8 text-center text-white">

                <a href="{{ route('fun-run.index') }}"
                    class="mb-5 inline-flex items-center text-sm text-slate-500 transition hover:text-emerald-400">
                    ← Kembali ke Fun Run
                </a>

                <h1 class="font-display text-3xl font-bold md:text-4xl">
                    Registrasi Peserta
                </h1>

                <p class="mt-2 text-slate-400">
                    {{ $event->name }}
                </p>

            </div>

            {{-- STEPPER --}}
            @include('fun-run.partials.stepper', ['currentStep' => 2])

            {{-- Alert --}}
            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())

                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 px-5 py-4">

                    <ul class="list-inside list-disc text-sm text-red-300">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            {{-- Card --}}
            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl">

                {{-- Period --}}
                <div class="bg-emerald-600 px-6 py-5 text-white">

                    <p class="font-display text-xs font-bold uppercase tracking-[0.2em] text-emerald-100">
                        Periode Pendaftaran
                    </p>

                    <h2 class="font-display text-xl font-bold">
                        {{ $activePeriod->name }}
                    </h2>

                    <p class="mt-1 text-sm text-emerald-100">

                        {{ $activePeriod->start_at->format('d M Y H:i') }}
                        -
                        {{ $activePeriod->end_at->format('d M Y H:i') }}

                    </p>

                </div>

                <form action="{{ route('fun-run.register.store') }}" method="POST" class="space-y-6 p-6 md:p-8">

                    @csrf

                    {{-- Kategori --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori
                        </label>

                        <select name="category_id" id="category_id" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach ($prices as $price)
                                <option value="{{ $price->category_id }}" data-price="{{ $price->price }}"
                                    @selected(old('category_id') == $price->category_id)>

                                    {{ $price->category->name }}
                                    —
                                    Rp {{ number_format($price->price, 0, ',', '.') }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    {{-- Nama --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            placeholder="Nama lengkap">

                    </div>

                    {{-- Email --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Email Peserta
                        </label>

                        <input type="email" value="{{ $email }}" readonly
                            class="w-full rounded-xl border border-slate-300 bg-slate-100 px-4 py-3 font-semibold text-slate-700 outline-none">

                        <p class="mt-2 text-xs text-slate-500">
                            Email ini digunakan panitia untuk mengirim link pembayaran.
                        </p>

                    </div>

                    {{-- Phone --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor WhatsApp
                        </label>

                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            placeholder="08xxxxxxxxxx">

                    </div>

                    {{-- NIK --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Nomor Identitas (NIK)
                        </label>

                        <input type="text" name="identity_number" value="{{ old('identity_number') }}"
                            required
                            inputmode="numeric"
                            pattern="\d{16}"
                            maxlength="16"
                            minlength="16"
                            oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16)"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            placeholder="16 digit NIK sesuai KTP">

                        <p class="mt-1 text-xs text-slate-500">
                            Harus tepat 16 digit angka.
                        </p>

                    </div>

                    {{-- Gender --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Jenis Kelamin
                        </label>

                        <div class="grid grid-cols-2 gap-3">

                            <label class="cursor-pointer">

                                <input type="radio" name="gender" value="L" class="peer sr-only"
                                    @checked(old('gender') === 'L')>

                                <div
                                    class="rounded-xl border border-slate-300 p-3 text-center transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                    Laki-laki
                                </div>

                            </label>

                            <label class="cursor-pointer">

                                <input type="radio" name="gender" value="P" class="peer sr-only"
                                    @checked(old('gender') === 'P')>

                                <div
                                    class="rounded-xl border border-slate-300 p-3 text-center transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700">
                                    Perempuan
                                </div>

                            </label>

                        </div>

                    </div>

                    {{-- Tanggal Lahir --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Tanggal Lahir
                        </label>

                        <input type="date" name="birth_date" value="{{ old('birth_date') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">

                    </div>

                    {{-- Address --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Alamat
                        </label>

                        <textarea name="address" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            placeholder="Alamat lengkap">{{ old('address') }}</textarea>

                    </div>

                    {{-- Ukuran Baju --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Ukuran Baju
                        </label>

                        <select name="shirt_size" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20">

                            <option value="">
                                Pilih ukuran baju
                            </option>

                            @foreach (['S', 'M', 'L', 'XL', '2XL', '3XL'] as $size)
                                <option value="{{ $size }}" @selected(old('shirt_size') === $size)>
                                    {{ $size }}
                                </option>
                            @endforeach

                        </select>

                        {{-- Contoh gambar ukuran baju --}}
                        <div class="mt-3 overflow-hidden rounded-xl border border-slate-200">

                            <img
                                src="{{ asset('images/size-chart2.png') }}"
                                alt="Contoh ukuran baju S, M, L, XL, 2XL, 3XL"
                                class="w-full object-contain"
                            >

                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            Cocokkan ukuran badan Anda dengan gambar di atas sebelum memilih.
                        </p>

                    </div>

                    {{-- Riwayat Penyakit --}}
                    <div>

                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Riwayat Penyakit
                        </label>

                        <textarea name="medical_history" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            placeholder="Contoh: asma, jantung, alergi tertentu. Kosongkan jika tidak ada.">{{ old('medical_history') }}</textarea>

                        <p class="mt-2 text-xs text-slate-500">
                            Opsional. Informasi ini membantu panitia bertindak cepat jika terjadi keadaan darurat.
                        </p>

                    </div>

                    {{-- Emergency --}}
                    <div class="border-t border-slate-200 pt-6">

                        <h3 class="mb-4 font-display font-bold text-slate-800">
                            Kontak Darurat
                        </h3>

                        <input type="text" name="emergency_contact_phone"
                            value="{{ old('emergency_contact_phone') }}" required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-500"
                            placeholder="Nomor kontak darurat">

                    </div>

                    {{-- Total --}}
                    <div id="priceBox" class="rounded-2xl bg-slate-100 p-5">

                        <div class="flex items-center justify-between">

                            <span class="font-semibold text-slate-600">
                                Biaya Registrasi
                            </span>

                            <span id="priceText" class="font-display text-2xl font-bold text-emerald-600">
                                Rp 0
                            </span>

                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            Kode unik pembayaran akan ditambahkan otomatis setelah Anda
                            mendaftar. Total akhir yang harus ditransfer akan tampil di
                            halaman pembayaran.
                        </p>

                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 font-display font-bold text-white transition hover:bg-emerald-700">
                        Daftar Sekarang
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        const category = document.getElementById('category_id');
        const priceText = document.getElementById('priceText');

        function updatePriceText() {

            const selected =
                category.options[category.selectedIndex];

            const price =
                (selected && selected.dataset.price) || 0;

            priceText.textContent =
                'Rp ' +
                new Intl.NumberFormat('id-ID').format(price);

        }

        category.addEventListener('change', updatePriceText);

        // Jalankan sekali saat halaman dimuat. Ini penting supaya
        // kalau form gagal validasi (mis. ada isian lain yang kosong)
        // dan halaman reload dengan kategori yang tadi sudah dipilih
        // ikut ke-select otomatis, harga yang tampil tetap sesuai
        // kategori itu -- bukan balik ke Rp 0 karena event "change"
        // memang tidak kepicu waktu reload.
        updatePriceText();
    </script>

</body>

</html>