<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pembayaran - {{ $registration->event->name }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>

</head>

<body class="min-h-screen bg-[#0B1120]">

    <div class="px-4 py-10">

        <div class="mx-auto max-w-3xl">

            {{-- =========================================================
                HEADER
            ========================================================== --}}

            <div class="mb-8 text-center text-white">

                <div class="mb-4 inline-flex items-center rounded-full
                            border border-emerald-500/20
                            bg-emerald-500/10
                            px-4 py-2
                            text-sm font-semibold text-emerald-400">

                    Pembayaran Fun Run

                </div>

                <h1 class="font-display text-3xl font-bold md:text-4xl">
                    Pembayaran Pendaftaran
                </h1>

                <p class="mt-2 text-slate-400">
                    {{ $registration->event->name }}
                </p>

            </div>


            {{-- STEPPER --}}
            @include('fun-run.partials.stepper', ['currentStep' => 3])


            {{-- =========================================================
                SUCCESS MESSAGE
            ========================================================== --}}

            @if (session('success'))

                <div class="mb-6 rounded-2xl
                            border border-emerald-500/30
                            bg-emerald-500/10
                            p-5 text-emerald-300">

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        <p>
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                ERROR SESSION
            ========================================================== --}}

            @if (session('error'))

                <div class="mb-6 rounded-2xl
                            border border-red-500/30
                            bg-red-500/10
                            p-5 text-red-300">

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>

                        <p>
                            {{ session('error') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                VALIDATION ERRORS
            ========================================================== --}}

            @if ($errors->any())

                <div class="mb-6 rounded-2xl
                            border border-red-500/30
                            bg-red-500/10
                            p-5">

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-red-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 01-18 0z"
                            />
                        </svg>

                        <div>

                            <p class="font-bold text-red-300">
                                Periksa kembali data berikut:
                            </p>

                            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-300">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                REGISTRATION SUMMARY
            ========================================================== --}}

            <div class="mb-6 overflow-hidden rounded-3xl bg-white shadow-xl">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="font-display text-xl font-bold text-slate-900">
                        Detail Pendaftaran
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Periksa kembali data pendaftaran Anda.
                    </p>

                </div>


                <div class="p-6">

                    <div class="grid gap-5 md:grid-cols-2">

                        {{-- Name --}}

                        <div class="rounded-2xl bg-slate-50 p-4">

                            <p class="text-sm text-slate-500">
                                Nama Peserta
                            </p>

                            <p class="mt-1 font-bold text-slate-900">
                                {{ $registration->name }}
                            </p>

                        </div>


                        {{-- Category --}}

                        <div class="rounded-2xl bg-slate-50 p-4">

                            <p class="text-sm text-slate-500">
                                Kategori
                            </p>

                            <p class="mt-1 font-bold text-slate-900">
                                {{ $registration->category->name }}
                            </p>

                        </div>


                        {{-- Period --}}

                        <div class="rounded-2xl bg-slate-50 p-4">

                            <p class="text-sm text-slate-500">
                                Periode Harga
                            </p>

                            <p class="mt-1 font-bold text-slate-900">
                                {{ $registration->price->period->name }}
                            </p>

                        </div>

                    </div>


                    {{-- Total --}}

                    <div class="mt-6 rounded-2xl
                                border border-emerald-100
                                bg-emerald-50
                                p-5">

                        <div class="flex flex-col gap-2 sm:flex-row
                                    sm:items-center sm:justify-between">

                            <div>

                                <p class="text-sm font-semibold text-slate-600">
                                    Total Pembayaran
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Silakan transfer sesuai nominal berikut.
                                </p>

                            </div>

                            <span class="font-display text-4xl font-black tracking-tight text-emerald-600 md:text-5xl">
                                Rp {{ number_format($registration->amount, 0, ',', '.') }}
                            </span>

                        </div>

                        @if ($registration->unique_code)

                            <div class="mt-4 space-y-1 border-t border-emerald-200 pt-4 text-sm">

                                <div class="flex items-center justify-between text-slate-600">
                                    <span>
                                        Harga Kategori
                                    </span>
                                    <span class="font-display text-base font-bold text-slate-800">
                                        Rp {{ number_format($registration->amount - $registration->unique_code, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex items-center justify-between text-slate-600">
                                    <span>
                                        Kode Unik
                                    </span>
                                    <span class="font-display text-base font-bold text-slate-800">
                                        + Rp {{ number_format($registration->unique_code, 0, ',', '.') }}
                                    </span>
                                </div>

                            </div>

                            <div class="mt-4 flex gap-3 rounded-xl border border-amber-200 bg-amber-50 p-3">

                                <svg
                                    class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                                    />
                                </svg>

                                <p class="text-xs leading-relaxed text-amber-800">
                                    Transfer harus <strong>tepat</strong> sampai 3 digit
                                    terakhir (kode unik). Nominal yang tidak sesuai
                                    akan menyulitkan proses verifikasi.
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =========================================================
                PAYMENT INFORMATION
            ========================================================== --}}

            <div class="mb-6 overflow-hidden rounded-3xl bg-white shadow-xl">

                <div class="border-b border-slate-100 px-6 py-5">

                    <h2 class="font-display text-xl font-bold text-slate-900">
                        Informasi Pembayaran
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Gunakan rekening atau QRIS berikut untuk melakukan pembayaran.
                    </p>

                </div>


                <div class="p-6">

                    {{-- BANK --}}

                    @php
                        $bankAccounts = collect([
                            [
                                'bank' => $registration->event->bank_name,
                                'number' => $registration->event->account_number,
                                'holder' => $registration->event->account_holder,
                            ],
                            [
                                'bank' => $registration->event->bank_name_2,
                                'number' => $registration->event->account_number_2,
                                'holder' => $registration->event->account_holder_2,
                            ],
                        ])->filter(fn ($account) => $account['bank'] || $account['number']);
                    @endphp

                    @if ($bankAccounts->isNotEmpty())

                        <div class="space-y-4">

                            @foreach ($bankAccounts as $accountIndex => $account)

                                <div class="rounded-2xl bg-[#0B1120] p-6 text-white">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-11 w-11 items-center justify-center
                                                    rounded-xl bg-white/10">

                                            <svg
                                                class="h-6 w-6 text-emerald-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M3 10l9-7 9 7M5 10h14M6 10v8m4-8v8m4-8v8m4-8v8M3 18h18M2 21h20"
                                                />
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="text-sm text-slate-400">
                                                Rekening Panitia
                                                @if ($bankAccounts->count() > 1)
                                                    ({{ $accountIndex + 1 }})
                                                @endif
                                            </p>

                                            <p class="font-bold">
                                                {{ $account['bank'] }}
                                            </p>

                                        </div>

                                    </div>


                                    <div class="mt-6">

                                        <p class="text-sm text-slate-400">
                                            Nomor Rekening
                                        </p>

                                        <div class="mt-2 flex items-center gap-3">

                                            <p
                                                id="account-number-{{ $accountIndex }}"
                                                class="break-all font-display text-3xl font-bold tracking-wider"
                                            >
                                                {{ $account['number'] }}
                                            </p>

                                            <button
                                                type="button"
                                                onclick="copyAccountNumber('account-number-{{ $accountIndex }}', this)"
                                                class="flex shrink-0 items-center gap-1.5 rounded-lg bg-white/10 px-3 py-2 text-xs font-bold text-white transition hover:bg-white/20"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                <span class="copy-label">Salin</span>
                                            </button>

                                        </div>

                                        <p class="mt-2 text-slate-300">
                                            a.n. {{ $account['holder'] }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endif


                    {{-- QRIS --}}

                    @if ($registration->event->qris_image)

                        <div class="mt-6 rounded-2xl
                                    border border-slate-200
                                    bg-slate-50 p-6 text-center">

                            <p class="font-bold text-slate-800">
                                Pembayaran melalui QRIS
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Scan QRIS berikut menggunakan aplikasi pembayaran Anda.
                            </p>


                            <div class="mt-5 inline-block rounded-2xl
                                        border border-slate-200
                                        bg-white p-4 shadow-sm">

                                <img
                                    src="{{ asset('storage/' . $registration->event->qris_image) }}"
                                    alt="QRIS Pembayaran"
                                    class="mx-auto h-64 w-64 object-contain"
                                >

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- =========================================================
                PAYMENT FORM
            ========================================================== --}}

            <form
                action="{{ route(
                    'fun-run.payment.submit',
                    request()->route('token')
                ) }}"
                method="POST"
                enctype="multipart/form-data"
                class="overflow-hidden rounded-3xl bg-white shadow-xl"
            >

                @csrf


                {{-- FORM HEADER --}}

                <div class="border-b border-slate-100 px-6 py-5 md:px-8">

                    <h2 class="font-display text-xl font-bold text-slate-900">
                        Data Transfer
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Isi data sesuai dengan bukti transfer.
                    </p>

                </div>


                <div class="p-6 md:p-8">

                    {{-- =================================================
                        TRANSFER DATE
                    ================================================== --}}

                    <div>

                        <label
                            for="transfer_date"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Tanggal Transfer
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="transfer_date"
                            type="date"
                            name="transfer_date"
                            value="{{ old('transfer_date', now()->format('Y-m-d')) }}"
                            max="{{ now()->format('Y-m-d') }}"
                            required
                            class="w-full rounded-xl border border-slate-300
                                   px-4 py-3 outline-none transition
                                   focus:border-emerald-500
                                   focus:ring-2 focus:ring-emerald-500/20"
                        >

                        @error('transfer_date')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        TRANSFER AMOUNT
                    ================================================== --}}

                    <div class="mt-5">

                        <label
                            for="transfer_amount"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Nominal Transfer
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="relative">

                            <span
                                class="pointer-events-none absolute inset-y-0 left-0
                                       flex items-center pl-4 font-display text-xl font-black text-slate-500"
                            >
                                Rp
                            </span>

                            <input
                                id="transfer_amount"
                                type="number"
                                name="transfer_amount"
                                value="{{ old('transfer_amount', $registration->amount) }}"
                                readonly
                                required
                                min="1"
                                class="w-full rounded-xl border border-slate-300
                                       bg-slate-100 px-4 py-4 pl-14
                                       font-display text-2xl font-black text-slate-800 outline-none"
                            >

                        </div>

                        <div class="mt-2 flex items-start gap-2">

                            <svg
                                class="mt-0.5 h-4 w-4 shrink-0 text-emerald-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                />
                            </svg>

                            <p class="text-sm text-slate-600">
                                Nominal pembayaran harus tepat
                                <strong class="font-display text-base font-black text-slate-900">
                                    Rp {{ number_format($registration->amount, 0, ',', '.') }}
                                </strong>.
                            </p>

                        </div>

                        @error('transfer_amount')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        PROOF
                    ================================================== --}}

                    <div class="mt-5">

                        <label
                            for="proof"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Bukti Transfer
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            id="proof"
                            type="file"
                            name="proof"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            required
                            class="w-full rounded-xl border border-slate-300
                                   bg-white px-4 py-3 text-sm
                                   file:mr-4 file:rounded-lg
                                   file:border-0 file:bg-slate-100
                                   file:px-4 file:py-2
                                   file:font-semibold file:text-slate-700"
                        >

                        <p class="mt-2 text-xs text-slate-500">
                            Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
                        </p>

                        @error('proof')

                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                        CONFIRMATION
                    ================================================== --}}

                    <div class="mt-6 rounded-2xl
                                border border-amber-200
                                bg-amber-50 p-4">

                        <div class="flex gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"
                                />
                            </svg>

                            <p class="text-sm leading-relaxed text-amber-800">

                                Pastikan semua data transfer dan bukti pembayaran
                                yang diunggah benar. Pembayaran akan diperiksa oleh
                                admin sebelum registrasi dinyatakan berhasil.

                            </p>

                        </div>

                    </div>


                    {{-- =================================================
                        SUBMIT
                    ================================================== --}}

                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center
                               gap-2 rounded-xl
                               bg-emerald-600 px-6 py-4
                               font-bold text-white
                               transition
                               hover:bg-emerald-700
                               focus:outline-none
                               focus:ring-4
                               focus:ring-emerald-500/20"
                    >

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 10h11m0 0l-4-4m4 4l-4 4m9-7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h7"
                            />
                        </svg>

                        Kirim Bukti Pembayaran

                    </button>

                </div>

            </form>


            {{-- =========================================================
                FOOTER
            ========================================================== --}}

            <div class="mt-6 text-center">

                <a
                    href="{{ route('fun-run.index') }}"
                    class="text-sm font-semibold text-slate-400 transition hover:text-white"
                >
                    ← Kembali ke halaman Fun Run
                </a>

            </div>

        </div>

    </div>

    <script>
        function copyAccountNumber(elementId, buttonEl) {

            const text = document.getElementById(elementId).textContent.trim();
            const label = buttonEl.querySelector('.copy-label');

            function showCopied() {
                const original = label.textContent;
                label.textContent = 'Tersalin!';
                buttonEl.classList.add('bg-emerald-500');
                setTimeout(function() {
                    label.textContent = original;
                    buttonEl.classList.remove('bg-emerald-500');
                }, 1500);
            }

            if (navigator.clipboard && window.isSecureContext) {

                navigator.clipboard.writeText(text).then(showCopied);

            } else {

                // Fallback buat browser lama / koneksi non-HTTPS.
                const temp = document.createElement('textarea');
                temp.value = text;
                temp.style.position = 'fixed';
                temp.style.opacity = '0';
                document.body.appendChild(temp);
                temp.focus();
                temp.select();

                try {
                    document.execCommand('copy');
                    showCopied();
                } catch (err) {
                    alert('Gagal menyalin otomatis. Nomor rekening: ' + text);
                }

                document.body.removeChild(temp);
            }
        }
    </script>

</body>

</html>