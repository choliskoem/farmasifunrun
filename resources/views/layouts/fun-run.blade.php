<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'HIMAFA Fun Run 2026')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-slate-950 text-white">

    {{-- NAVBAR --}}

    <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/90 backdrop-blur">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

            <a
                href="{{ route('funrun.index') }}"
                class="text-xl font-black tracking-tight"
            >
                HIMAFA
                <span class="text-emerald-400">
                    FUN RUN
                </span>
            </a>

            <nav class="hidden items-center gap-8 md:flex">

                <a
                    href="{{ route('funrun.index') }}"
                    class="text-sm text-white/70 transition hover:text-white"
                >
                    Beranda
                </a>

                <a
                    href="{{ route('funrun.register') }}"
                    class="rounded-full bg-emerald-500 px-5 py-2.5 text-sm font-bold text-slate-950 transition hover:bg-emerald-400"
                >
                    Daftar Sekarang
                </a>

            </nav>

        </div>

    </header>


    {{-- ALERT --}}

    <div class="mx-auto max-w-7xl px-6 pt-6">

        @if(session('success'))

            <div class="rounded-2xl border border-emerald-400/30 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-300">

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="rounded-2xl border border-red-400/30 bg-red-400/10 px-5 py-4 text-sm text-red-300">

                {{ session('error') }}

            </div>

        @endif


        @if(session('info'))

            <div class="rounded-2xl border border-blue-400/30 bg-blue-400/10 px-5 py-4 text-sm text-blue-300">

                {{ session('info') }}

            </div>

        @endif

    </div>


    {{-- CONTENT --}}

    @yield('content')


    {{-- FOOTER --}}

    <footer class="border-t border-white/10 py-10">

        <div class="mx-auto max-w-7xl px-6 text-center">

            <p class="text-sm text-white/50">

                © {{ date('Y') }}
                HIMAFA Fun Run.
                All rights reserved.

            </p>

        </div>

    </footer>

</body>

</html>