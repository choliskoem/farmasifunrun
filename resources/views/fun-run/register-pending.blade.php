<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pendaftaran Berhasil
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="min-h-screen bg-slate-950">

    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-xl">

            <div class="rounded-3xl bg-white p-8 text-center shadow-2xl md:p-10">

                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-amber-100">

                    <svg
                        class="h-10 w-10 text-amber-600"
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

                </div>

                <h1 class="text-3xl font-black text-slate-900">
                    Data Berhasil Dikirim
                </h1>

                <p class="mt-4 leading-relaxed text-slate-500">

                    Terima kasih telah melakukan pendaftaran
                    <strong>
                        {{ $registration->event->name }}
                    </strong>.

                </p>

                <div class="mt-6 rounded-2xl bg-slate-50 p-5 text-left">

                    <p class="text-sm text-slate-500">
                        Email peserta
                    </p>

                    <p class="mt-1 font-bold text-slate-900">
                        {{ $registration->email }}
                    </p>

                </div>

                <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-left">

                    <p class="font-bold text-amber-800">
                        Selanjutnya
                    </p>

                    <ul class="mt-3 space-y-2 text-sm leading-relaxed text-amber-700">

                        <li>
                            • Admin akan memeriksa data pendaftaran Anda.
                        </li>

                        <li>
                            • Silakan cek email yang Anda daftarkan secara berkala.
                        </li>

                        <li>
                            • Jika data telah diverifikasi, admin akan mengirimkan
                            link pembayaran melalui email.
                        </li>

                        <li>
                            • Jangan membagikan link pembayaran kepada orang lain.
                        </li>

                    </ul>

                </div>

                <a
                    href="{{ route('fun-run.index') }}"
                    class="mt-8 block rounded-xl bg-emerald-600 px-6 py-4 font-bold text-white transition hover:bg-emerald-700"
                >
                    Kembali ke Fun Run
                </a>

            </div>

        </div>

    </div>

</body>

</html>