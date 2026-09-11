<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $event->name }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap');

        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }

        .track-divider {
            height: 2px;
            background-image: repeating-linear-gradient(90deg, #10B981 0 22px, transparent 22px 38px);
            opacity: .3;
        }

        .bib-tag {
            position: relative;
            border-top: 3px dashed rgba(255,255,255,0.15);
        }
        .bib-tag::before {
            content: '';
            position: absolute;
            top: -9px; left: 50%;
            transform: translateX(-50%);
            width: 16px; height: 16px;
            border-radius: 9999px;
            background: #0B1120;
        }
    </style>

</head>

<body class="bg-[#0B1120] text-white">

    <main class="relative min-h-screen overflow-hidden">

        {{-- AMBIENT GLOW --}}
        <div class="pointer-events-none absolute -left-40 top-10 h-96 w-96 rounded-full bg-emerald-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-40 bottom-10 h-96 w-96 rounded-full bg-amber-500/10 blur-3xl"></div>

        <section class="relative flex min-h-screen items-center justify-center px-6 py-20">

            <div class="max-w-3xl text-center">

                <div class="mx-auto mb-6 inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                    <p class="font-display text-xs font-bold uppercase tracking-[0.3em] text-emerald-400">
                        Farmasi Race Day
                    </p>
                </div>

                <h1 class="font-display text-5xl font-bold leading-[1.05] md:text-7xl">
                    {{ $event->name }}
                </h1>

                @if ($event->description)
                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-400">
                        {{ $event->description }}
                    </p>
                @endif

                <div class="mt-10 flex flex-wrap justify-center gap-4">

                    @if ($registrationOpen)

                        <a href="{{ route('fun-run.register.email') }}"
                            class="group inline-flex items-center gap-2 rounded-full bg-emerald-500 px-8 py-4 font-display font-bold text-slate-950 shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-400">
                            Daftar Sekarang
                            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>

                    @else

                        <span
                            class="inline-flex cursor-not-allowed items-center gap-2 rounded-full bg-white/5 px-8 py-4 font-display font-bold text-slate-500 ring-1 ring-white/10">
                            <svg class="h-4 w-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12a7.5 7.5 0 0113.5-4.5M19.5 12a7.5 7.5 0 01-13.5 4.5M4.5 12H2m17.5 0h2.5M9 4.5L7.5 3M17 4.5L18.5 3M9 19.5L7.5 21M17 19.5l1.5 1.5"/></svg>
                            Sedang Maintenance
                        </span>

                    @endif

                </div>

                @if (!$registrationOpen)

                    <p class="mt-4 text-sm text-slate-500">
                        Website sedang dalam perbaikan sementara.
                        @if ($event->maintenance_until)
                            Perkiraan aktif lagi
                            {{ $event->maintenance_until->translatedFormat('d F Y, H:i') }} WITA.
                        @else
                            Silakan cek kembali beberapa saat lagi.
                        @endif
                    </p>

                @endif

                @if ($event->contact_person_name || $event->contact_person_phone)

                    <div class="mt-6 flex items-center justify-center gap-2 text-sm text-slate-400">

                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>

                        <span>
                            Ada pertanyaan? Hubungi
                            @if ($event->contact_person_name)
                                <span class="font-semibold text-slate-300">{{ $event->contact_person_name }}</span>
                            @endif
                            @if ($event->contact_person_phone)
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $event->contact_person_phone);
                                    $waNumber = str_starts_with($waNumber, '0') ? '62' . substr($waNumber, 1) : $waNumber;
                                @endphp
                                —
                                <a
                                    href="https://wa.me/{{ $waNumber }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="font-semibold text-emerald-400 underline decoration-emerald-400/40 underline-offset-2 hover:text-emerald-300"
                                >
                                    {{ $event->contact_person_phone }}
                                </a>
                            @endif
                        </span>

                    </div>

                @endif

                @if ($activePeriod)

                    <div class="mx-auto mt-14 max-w-xs">

                        <div class="track-divider mb-6"></div>

                        <div class="bib-tag rounded-2xl bg-white/[0.03] px-6 pb-6 pt-8 ring-1 ring-white/10">
                            <p class="font-display text-[11px] font-bold uppercase tracking-[0.25em] text-slate-500">
                                Periode Berjalan
                            </p>
                            <p class="mt-2 font-display text-xl font-bold text-emerald-400">
                                {{ $activePeriod->name }}
                            </p>
                        </div>

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>