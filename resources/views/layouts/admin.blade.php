<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') — Admin HIMAFA
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html {
            scroll-behavior: smooth;
        }

        .sidebar-transition {
            transition: transform .3s ease;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <div class="min-h-screen">

        {{-- Mobile Overlay --}}
        <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden">
        </div>

        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}
        <aside id="sidebar"
            class="sidebar-transition fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white lg:translate-x-0">

            {{-- Logo --}}
            <div class="flex h-20 items-center border-b border-slate-100 px-6">

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">

                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/20">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 3v18M3 12h18" />

                            <circle cx="12" cy="12" r="8.5" />

                        </svg>

                    </div>

                    <div>
                        <div class="font-extrabold text-slate-900">
                            HIMAFA
                        </div>

                        <div class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                            Admin Panel
                        </div>
                    </div>

                </a>

            </div>


            {{-- Navigation --}}
            <div class="flex-1 overflow-y-auto px-4 py-6">

                <div class="mb-3 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                    Utama
                </div>

                <nav class="space-y-1">

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 12l9-9 9 9M5 10v10h14V10M9 20v-6h6v6" />
                        </svg>

                        Dashboard

                    </a>

                </nav>


                <div class="mb-3 mt-8 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                    Fun Run
                </div>

                <nav class="space-y-1">

                    @if (auth()->user()->canAccessMenu('fun-run-registrations'))

                        @php
                            // Dihitung langsung di layout supaya konsisten
                            // di semua halaman admin (tidak tergantung
                            // controller mana yang me-render halaman).
                            $pendingPublicCount = \App\Models\FunRunRegistration::where(
                                'status',
                                'waiting_verification',
                            )->where('channel', 'public')->count();

                            $pendingInvitationCount = \App\Models\FunRunRegistration::where(
                                'status',
                                'waiting_verification',
                            )->where('channel', 'invitation')->count();

                            $pendingBackdoorCount = \App\Models\FunRunRegistration::where(
                                'status',
                                'waiting_verification',
                            )->where('channel', 'backdoor')->count();
                        @endphp

                        {{-- Peserta Fun Run — Umum --}}
                        <a href="{{ route('admin.fun-run.registrations', ['channel' => 'public']) }}"
                            class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.fun-run.registrations*') && request('channel', 'public') === 'public'
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="flex items-center gap-3">
                                <span class="text-lg">🌐</span>
                                Peserta — Umum
                            </span>

                            @if ($pendingPublicCount > 0)
                                <span
                                    class="flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-[11px] font-black text-white">
                                    {{ $pendingPublicCount }}
                                </span>
                            @endif

                        </a>


                        {{-- Peserta Fun Run — Jalur Undangan --}}
                        <a href="{{ route('admin.fun-run.registrations', ['channel' => 'invitation']) }}"
                            class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.fun-run.registrations*') && request('channel') === 'invitation'
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="flex items-center gap-3">
                                <span class="text-lg">🎟️</span>
                                Peserta — Undangan
                            </span>

                            @if ($pendingInvitationCount > 0)
                                <span
                                    class="flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-[11px] font-black text-white">
                                    {{ $pendingInvitationCount }}
                                </span>
                            @endif

                        </a>


                        {{-- Peserta Fun Run — Jalur Backdoor --}}
                        <a href="{{ route('admin.fun-run.registrations', ['channel' => 'backdoor']) }}"
                            class="flex items-center justify-between rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.fun-run.registrations*') && request('channel') === 'backdoor'
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="flex items-center gap-3">
                                <span class="text-lg">🔑</span>
                                Peserta — Spesial
                            </span>

                            @if ($pendingBackdoorCount > 0)
                                <span
                                    class="flex h-6 min-w-6 items-center justify-center rounded-full bg-red-500 px-2 text-[11px] font-black text-white">
                                    {{ $pendingBackdoorCount }}
                                </span>
                            @endif

                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('fun-run-settings'))

                        {{-- Pengaturan Fun Run (Periode & Stok Tiket) --}}
                        <a href="{{ route('admin.fun-run.settings.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.fun-run.settings.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">⚙️</span>

                            Pengaturan Fun Run

                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('fun-run-manual'))

                        {{-- Registrasi Manual --}}
                        <a href="{{ route('admin.fun-run.manual.create') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.fun-run.manual.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">📝</span>

                            Registrasi Manual

                        </a>

                    @endif

                </nav>


                <div class="mb-3 mt-8 px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">
                    Konten Website
                </div>

                <nav class="space-y-1">

                    @if (auth()->user()->canAccessMenu('profile'))

                        {{-- Profil --}}
                        <a href="{{ route('admin.profile.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.profile.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">📖</span>

                            Profil HIMAFA
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('vision'))

                        {{-- Visi --}}
                        <a href="{{ route('admin.vision.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.vision.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🎯</span>

                            Visi
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('missions'))

                        {{-- Misi --}}
                        <a href="{{ route('admin.missions.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.missions.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🚀</span>

                            Misi
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('management-periods'))

                        {{-- Periode --}}
                        <a href="{{ route('admin.management-periods.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.management-periods.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">📅</span>

                            Periode Kepengurusan
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('management-members'))

                        {{-- Pengurus --}}
                        <a href="{{ route('admin.management-members.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.management-members.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">👥</span>

                            Pengurus
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('departments'))

                        {{-- Bidang --}}
                        <a href="{{ route('admin.departments.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.departments.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🏢</span>

                            Bidang
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('galleries'))

                        {{-- Galeri --}}
                        <a href="{{ route('admin.galleries.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.galleries.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🖼️</span>

                            Galeri
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('events'))

                        {{-- Event --}}
                        <a href="{{ route('admin.events.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.events.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🎫</span>

                            Event
                        </a>

                    @endif


                    @if (auth()->user()->canAccessMenu('social-links'))

                        {{-- Social --}}
                        <a href="{{ route('admin.social-links.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.social-links.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🔗</span>

                            Social Media
                        </a>

                    @endif

                    @if (auth()->check() && auth()->user()->isSuperAdmin())

                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🛡️</span>

                            Kelola Admin

                        </a>

                        <a href="{{ route('admin.menu-permissions.edit') }}"
                            class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold transition
                            {{ request()->routeIs('admin.menu-permissions.*')
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-emerald-600' }}">

                            <span class="text-lg">🔐</span>

                            Atur Akses Menu

                        </a>

                    @endif

                </nav>

            </div>


            {{-- Bottom Sidebar --}}
            <div class="border-t border-slate-100 p-4">

                <a href="{{ route('home') }}" target="_blank"
                    class="mb-2 flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">

                    🌐

                    Lihat Website
                </a>


                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf

                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-left text-sm font-semibold text-red-500 hover:bg-red-50">

                        🚪

                        Keluar

                    </button>

                </form>

            </div>

        </aside>


        {{-- =====================================================
            MAIN
        ====================================================== --}}
        <div class="lg:pl-72">

            {{-- Topbar --}}
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">

                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                    <button id="mobile-menu-button" type="button"
                        class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 lg:hidden">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                    </button>


                    <div class="hidden lg:block">

                        <div class="text-xs font-semibold uppercase tracking-widest text-slate-400">
                            Administrator
                        </div>

                        <div class="mt-1 font-bold text-slate-900">
                            HIMAFA
                        </div>

                    </div>


                    <div class="ml-auto flex items-center gap-4">

                        <div class="hidden text-right sm:block">

                            <div class="text-sm font-bold text-slate-900">
                                {{ auth()->user()->name ?? 'Administrator' }}
                            </div>

                            <div class="text-xs text-slate-400">
                                Administrator
                            </div>

                        </div>

                        <div
                            class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 font-bold text-emerald-700">

                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                        </div>

                    </div>

                </div>

            </header>


            {{-- Content --}}
            <main class="min-h-[calc(100vh-80px)] px-4 py-8 sm:px-6 lg:px-8">

                @if (session('success'))
                    <div
                        class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">

                        ✓ {{ session('success') }}

                    </div>
                @endif


                @if (session('error'))
                    <div
                        class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">

                        ⚠ {{ session('error') }}

                    </div>
                @endif


                @if ($errors->any())

                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                        <div class="font-bold text-red-700">
                            Terdapat kesalahan:
                        </div>

                        <ul class="mt-2 list-disc pl-5 text-sm text-red-600">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                @yield('content')

            </main>

        </div>

    </div>


    <script>
        const button = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        if (button) {
            button.addEventListener('click', toggleSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>