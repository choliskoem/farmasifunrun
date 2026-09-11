<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Tiket</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-display {
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>

</head>

<body class="flex min-h-screen items-center justify-center bg-[#0B1120] px-4 py-10">

    <div class="w-full max-w-sm text-center">

        @if ($valid)
            <div class="rounded-3xl border-2 border-emerald-500 bg-emerald-500/10 p-8">

                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-emerald-500">
                    <svg class="h-8 w-8 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <p class="font-display text-xs font-bold uppercase tracking-[0.25em] text-emerald-400">
                    Tiket Asli
                </p>

                <h1 class="mt-2 font-display text-2xl font-bold text-white">
                    Terverifikasi
                </h1>

                <div class="mt-6 space-y-2 rounded-2xl bg-white/5 p-5 text-left">

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Bib</span>
                        <span class="font-display font-bold text-white">{{ $registration->registration_code }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Nama</span>
                        <span class="font-bold text-white">{{ $registration->name }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Kategori</span>
                        <span class="font-bold text-white">{{ $registration->category->name }}</span>
                    </div>

                </div>

            </div>
        @else
            <div class="rounded-3xl border-2 border-red-500 bg-red-500/10 p-8">

                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-red-500">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <p class="font-display text-xs font-bold uppercase tracking-[0.25em] text-red-400">
                    Tidak Valid
                </p>

                <h1 class="mt-2 font-display text-2xl font-bold text-white">
                    Tiket Tidak Dikenali
                </h1>

                <p class="mt-3 text-sm text-slate-400">
                    Kode tiket ini tidak ditemukan, belum lunas, atau tanda
                    tangan digitalnya tidak cocok. Kemungkinan tiket palsu
                    atau sudah tidak berlaku.
                </p>

            </div>
        @endif

    </div>

</body>

</html>
