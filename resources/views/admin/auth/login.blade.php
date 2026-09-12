<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin — HIMAFA</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="min-h-screen bg-slate-950">

    <div class="flex min-h-screen items-center justify-center px-5 py-10">

        <div class="w-full max-w-md">

            {{-- Logo --}}

            <div class="mb-8 text-center">

                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-xl shadow-emerald-600/20"
                >

                    <svg
                        class="h-8 w-8"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M12 3v18M3 12h18"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="8.5"
                        />

                    </svg>

                </div>


                <h1 class="mt-5 text-2xl font-extrabold text-white">
                    HIMAFA
                </h1>

                <p class="mt-1 text-sm text-slate-400">
                    Administrator Dashboard
                </p>

            </div>


            {{-- Card --}}

            <div
                class="rounded-[2rem] border border-white/10 bg-white p-8 shadow-2xl"
            >

                <div class="mb-7">

                    <h2 class="text-xl font-extrabold text-slate-900">
                        Selamat Datang
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Silakan masuk ke halaman administrator.
                    </p>

                </div>


                {{-- Success --}}

                @if(session('success'))

                    <div
                        class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                {{-- Error --}}

                @if($errors->any())

                    <div
                        class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600"
                    >

                        {{ $errors->first() }}

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('login.process') }}"
                    class="space-y-5"
                >

                    @csrf


                    {{-- Email / Username --}}

                    <div>

                        <label
                            for="login"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Email / Username
                        </label>

                        <input
                            id="login"
                            name="login"
                            type="text"
                            value="{{ old('login') }}"
                            required
                            autofocus
                            placeholder="admin@himafa.ac.id atau username"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        >

                    </div>


                    {{-- Password --}}

                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-bold text-slate-700"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10"
                        >

                    </div>


                    {{-- Remember --}}

                    <div class="flex items-center gap-2">

                        <input
                            id="remember"
                            name="remember"
                            type="checkbox"
                            class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                        >

                        <label
                            for="remember"
                            class="text-sm text-slate-500"
                        >
                            Ingat saya
                        </label>

                    </div>


                    {{-- Button --}}

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-600 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:-translate-y-0.5 hover:bg-emerald-700"
                    >

                        Masuk ke Dashboard

                    </button>

                </form>

            </div>


            <div class="mt-6 text-center">

                <a
                    href="{{ route('home') }}"
                    class="text-sm text-slate-500 transition hover:text-emerald-400"
                >
                    ← Kembali ke Website HIMAFA
                </a>

            </div>

        </div>

    </div>

</body>

</html>