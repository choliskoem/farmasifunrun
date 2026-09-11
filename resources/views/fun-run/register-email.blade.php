<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar - {{ $event->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
    </style>

</head>

<body class="min-h-screen bg-[#0B1120]">

    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-lg">

            <div class="mb-8 text-center text-white">

                <a href="{{ route('fun-run.index') }}" class="text-sm text-slate-500 transition hover:text-emerald-400">
                    ← Kembali ke Fun Run
                </a>

                <h1 class="mt-6 font-display text-3xl font-bold md:text-4xl">
                    Mulai Pendaftaran
                </h1>

                <p class="mt-3 text-slate-400">
                    {{ $event->name }}
                </p>

            </div>

            {{-- STEPPER --}}
            @include('fun-run.partials.stepper', ['currentStep' => 1])

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-500/30 bg-red-500/10 p-5 text-sm text-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <div class="rounded-3xl bg-white p-6 shadow-2xl md:p-8">

                <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50 p-5">
                    <p class="font-display font-bold text-emerald-800">
                        Langkah 1 dari 4
                    </p>
                    <p class="mt-2 text-sm leading-relaxed text-emerald-700">
                        Masukkan email aktif yang dapat Anda akses. Email ini akan
                        digunakan panitia untuk mengirim informasi pendaftaran dan
                        link pembayaran.
                    </p>
                </div>

                <form action="{{ route('fun-run.register.email.continue') }}" method="POST">

                    @csrf

                    <label for="email" class="mb-2 block text-sm font-bold text-slate-700">
                        Email Aktif
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-6 py-4 font-display font-bold text-white transition hover:bg-emerald-700"
                    >
                        Lanjutkan
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>