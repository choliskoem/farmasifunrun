<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi Berhasil</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        .bib-card {
            position: relative;
            border: 2px dashed rgba(16, 185, 129, 0.35);
        }
        .bib-card::before, .bib-card::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 18px; height: 18px;
            border-radius: 9999px;
            background: #0B1120;
            transform: translateY(-50%);
        }
        .bib-card::before { left: -10px; }
        .bib-card::after { right: -10px; }
    </style>

</head>

<body class="min-h-screen bg-[#0B1120]">

    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-lg">

            {{-- STEPPER --}}
            @include('fun-run.partials.stepper', ['currentStep' => 4])

            <div class="rounded-3xl bg-white p-8 text-center shadow-2xl md:p-10">

                {{-- Icon --}}
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100">

                    <svg class="h-10 w-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>

                </div>

                <p class="font-display text-xs font-bold uppercase tracking-[0.3em] text-emerald-600">
                    Finish Line
                </p>

                <h1 class="mt-2 font-display text-3xl font-bold text-slate-900">
                    Registrasi Berhasil!
                </h1>

                <p class="mt-3 text-slate-500">
                    Terima kasih telah mendaftar
                    {{ $registration->event->name }}.
                </p>

                {{-- Registration Code — Bib Card --}}
                <div class="bib-card mx-4 mt-8 rounded-2xl bg-slate-50 px-5 py-6">

                    <p class="font-display text-[11px] font-bold uppercase tracking-[0.25em] text-slate-400">
                        Nomor Bib / Kode Registrasi
                    </p>

                    <p class="mt-2 font-display text-3xl font-bold tracking-[0.15em] text-emerald-600">
                        {{ $registration->registration_code }}
                    </p>

                </div>

                {{-- Detail --}}
                <div class="mt-8 space-y-3 text-left">

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Nama</span>
                        <span class="font-semibold text-slate-900">{{ $registration->name }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Kategori</span>
                        <span class="font-semibold text-slate-900">{{ $registration->category->name }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Periode</span>
                        <span class="font-semibold text-slate-900">{{ $registration->price->period->name }}</span>
                    </div>

                    <div class="flex justify-between gap-4 border-t pt-3">
                        <span class="font-semibold text-slate-600">Total</span>
                        <span class="font-display font-bold text-emerald-600">
                            Rp {{ number_format($registration->amount, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                <p class="mt-6 flex items-start gap-2 rounded-xl bg-amber-50 px-4 py-3 text-left text-xs leading-relaxed text-amber-700">
                    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>
                    Email konfirmasi &amp; tiket sudah kami kirim ke email Anda. Kalau
                    belum muncul dalam beberapa menit, cek juga folder
                    <strong>Spam atau Kotak Masuk</strong>.
                </p>

                <div class="mt-6">

                    <a href="{{ route('fun-run.index') }}"
                        class="block rounded-xl bg-emerald-600 px-6 py-4 font-display font-bold text-white transition hover:bg-emerald-700">
                        Kembali ke Fun Run
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>