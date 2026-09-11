<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Status Pembayaran - {{ $registration->event->name }}
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

    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-xl">

            {{-- STEPPER --}}
            @include('fun-run.partials.stepper', ['currentStep' => 3])

            {{-- =========================================================
                CARD
            ========================================================== --}}

            <div class="overflow-hidden rounded-3xl bg-white shadow-2xl">

                {{-- HEADER --}}

                <div class="bg-slate-900 px-6 py-8 text-center text-white">

                    <div class="mx-auto flex h-20 w-20 items-center justify-center
                                rounded-full bg-amber-500/10
                                ring-8 ring-amber-500/5">

                        <svg
                            class="h-10 w-10 text-amber-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                            />

                        </svg>

                    </div>

                    <h1 class="mt-6 font-display text-3xl font-bold">
                        Menunggu Verifikasi
                    </h1>

                    <p class="mt-2 text-slate-400">
                        {{ $registration->event->name }}
                    </p>

                </div>


                {{-- CONTENT --}}

                <div class="p-6 md:p-8">

                    {{-- SUCCESS --}}

                    @if (session('success'))

                        <div class="mb-6 rounded-2xl
                                    border border-emerald-200
                                    bg-emerald-50 p-4">

                            <div class="flex gap-3">

                                <svg
                                    class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600"
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

                                <p class="text-sm text-emerald-700">
                                    {{ session('success') }}
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- ERROR --}}

                    @if (session('error'))

                        <div class="mb-6 rounded-2xl
                                    border border-red-200
                                    bg-red-50 p-4">

                            <div class="flex gap-3">

                                <svg
                                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
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

                                <p class="text-sm text-red-700">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- MESSAGE --}}

                    <div class="text-center">

                        <p class="leading-relaxed text-slate-500">

                            Bukti pembayaran Anda sudah diterima.
                            Admin akan melakukan pemeriksaan terhadap
                            bukti transfer dan mutasi rekening panitia.

                        </p>

                    </div>


                    {{-- STATUS --}}

                    <div class="mt-5 rounded-2xl
                                border border-amber-200
                                bg-amber-50 p-5">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0
                                        items-center justify-center
                                        rounded-xl bg-amber-100">

                                <svg
                                    class="h-5 w-5 text-amber-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />

                                </svg>

                            </div>

                            <div>

                                <p class="font-bold text-amber-800">
                                    Status Pembayaran
                                </p>

                                <p class="mt-1 text-sm leading-relaxed text-amber-700">
                                    Menunggu verifikasi pembayaran oleh admin.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- PAYMENT DETAIL --}}

                    @if ($registration->latestPayment)

                        <div class="mt-6 rounded-2xl
                                    border border-slate-200
                                    bg-white p-5">

                            <h2 class="font-display font-bold text-slate-900">
                                Detail Pembayaran
                            </h2>

                            <div class="mt-4 space-y-4">

                                {{-- Sender --}}

                                @if ($registration->latestPayment->sender_name)

                                    <div class="flex flex-col gap-1 sm:flex-row
                                                sm:items-center sm:justify-between">

                                        <span class="text-sm text-slate-500">
                                            Nama Pengirim
                                        </span>

                                        <span class="font-semibold text-slate-900">
                                            {{ $registration->latestPayment->sender_name }}
                                        </span>

                                    </div>

                                @endif


                                {{-- Bank --}}

                                @if ($registration->latestPayment->sender_bank)

                                    <div class="flex flex-col gap-1 sm:flex-row
                                                sm:items-center sm:justify-between">

                                        <span class="text-sm text-slate-500">
                                            Bank Pengirim
                                        </span>

                                        <span class="font-semibold text-slate-900">
                                            {{ $registration->latestPayment->sender_bank }}
                                        </span>

                                    </div>

                                @endif


                                {{-- Transfer Date --}}

                                @if ($registration->latestPayment->transfer_date)

                                    <div class="flex flex-col gap-1 sm:flex-row
                                                sm:items-center sm:justify-between">

                                        <span class="text-sm text-slate-500">
                                            Tanggal Transfer
                                        </span>

                                        <span class="font-semibold text-slate-900">
                                            {{ $registration->latestPayment->transfer_date->format('d/m/Y') }}
                                        </span>

                                    </div>

                                @endif


                                {{-- Transfer Amount --}}

                                @if ($registration->latestPayment->transfer_amount)

                                    <div class="flex flex-col gap-1 sm:flex-row
                                                sm:items-center sm:justify-between">

                                        <span class="text-sm text-slate-500">
                                            Nominal Transfer
                                        </span>

                                        <span class="font-display font-bold text-emerald-600">
                                            Rp {{ number_format(
                                                $registration->latestPayment->transfer_amount,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                        </span>

                                    </div>

                                @endif

                            </div>

                        </div>

                    @endif


                    {{-- INFORMATION --}}

                    <div class="mt-6 rounded-2xl bg-slate-50 p-5">

                        <p class="text-sm font-bold text-slate-700">
                            Informasi
                        </p>

                        <ul class="mt-3 space-y-2 text-sm text-slate-500">

                            <li class="flex gap-2">

                                <span class="text-emerald-600">
                                    •
                                </span>

                                Bukti pembayaran sedang diperiksa oleh admin.

                            </li>

                            <li class="flex gap-2">

                                <span class="text-emerald-600">
                                    •
                                </span>

                                Pastikan kode registrasi Anda disimpan.

                            </li>

                            <li class="flex gap-2">

                                <span class="text-emerald-600">
                                    •
                                </span>

                                Setelah pembayaran disetujui, status akan berubah menjadi berhasil.

                            </li>

                            <li class="flex gap-2">

                                <span class="text-emerald-600">
                                    •
                                </span>

                                Email konfirmasi &amp; tiket akan dikirim ke email Anda. Kalau
                                belum masuk, periksa juga folder <strong>Spam atau Kotak Masuk</strong>.

                            </li>

                        </ul>

                    </div>


                    {{-- BUTTON --}}

                    <div class="mt-8">

                        <a
                            href="{{ route('fun-run.index') }}"
                            class="flex w-full items-center justify-center
                                   rounded-xl bg-emerald-600
                                   px-6 py-4
                                   font-bold text-white
                                   transition hover:bg-emerald-700
                                   focus:outline-none
                                   focus:ring-4
                                   focus:ring-emerald-500/20"
                        >

                            Kembali ke Fun Run

                        </a>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="mt-6 text-center">

                <p class="text-xs text-slate-500">
                    Simpan kode registrasi untuk keperluan pengecekan pembayaran.
                </p>

            </div>

        </div>

    </div>

</body>

</html>