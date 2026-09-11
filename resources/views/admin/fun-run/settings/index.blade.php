@extends('layouts.admin')

@section('title', 'Pengaturan Fun Run')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            ⚙️
        </div>

        <div>

            <h1 class="text-2xl font-black text-slate-900">
                Pengaturan Fun Run
            </h1>

            <p class="text-sm text-slate-500">
                Atur periode pendaftaran dan stok tiket per kategori.
            </p>

        </div>

    </div>


    {{-- ALERT --}}

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- =========================================================
        REKENING PEMBAYARAN
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Rekening Pembayaran
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Nomor rekening ini yang tampil di halaman pembayaran peserta.
                Cuma bisa diubah dari sini (lewat panel admin yang sudah login),
                bukan lewat file kode.
            </p>

        </div>

        <form
            action="{{ route('admin.fun-run.settings.event.bank', $event) }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid gap-4 p-6 sm:grid-cols-2"
        >
            @csrf
            @method('PUT')

            <div class="sm:col-span-2">
                <p class="mb-1 text-xs font-black uppercase tracking-wider text-emerald-600">
                    Rekening 1
                </p>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nama Bank
                </label>
                <input
                    type="text"
                    name="bank_name"
                    value="{{ old('bank_name', $event->bank_name) }}"
                    placeholder="Contoh: BNI"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nomor Rekening
                </label>
                <input
                    type="text"
                    name="account_number"
                    value="{{ old('account_number', $event->account_number) }}"
                    placeholder="Contoh: 1881558736"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nama Pemilik Rekening
                </label>
                <input
                    type="text"
                    name="account_holder"
                    value="{{ old('account_holder', $event->account_holder) }}"
                    placeholder="Contoh: Nur Fadilah Sahran"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div class="sm:col-span-2 border-t border-slate-100 pt-4">
                <p class="mb-1 text-xs font-black uppercase tracking-wider text-emerald-600">
                    Rekening 2 (opsional)
                </p>
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nama Bank
                </label>
                <input
                    type="text"
                    name="bank_name_2"
                    value="{{ old('bank_name_2', $event->bank_name_2) }}"
                    placeholder="Contoh: BCA"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nomor Rekening
                </label>
                <input
                    type="text"
                    name="account_number_2"
                    value="{{ old('account_number_2', $event->account_number_2) }}"
                    placeholder="Contoh: 1234567890"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nama Pemilik Rekening
                </label>
                <input
                    type="text"
                    name="account_holder_2"
                    value="{{ old('account_holder_2', $event->account_holder_2) }}"
                    placeholder="Nama pemilik rekening kedua"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div class="sm:col-span-2 border-t border-slate-100 pt-4">
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Gambar QRIS (opsional)
                </label>

                @if ($event->qris_image)
                    <img
                        src="{{ asset('storage/' . $event->qris_image) }}"
                        alt="QRIS"
                        class="mb-2 h-24 w-24 rounded-lg border border-slate-200 object-cover"
                    >
                @endif

                <input
                    type="file"
                    name="qris_image"
                    accept="image/jpeg,image/png,image/webp"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-white hover:file:bg-emerald-600"
                >
            </div>

            <div class="sm:col-span-2">
                <button
                    type="submit"
                    class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700"
                >
                    Simpan Rekening
                </button>
            </div>

        </form>

    </div>


    {{-- =========================================================
        KONTAK PERSON
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Kontak Person
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Ditampilkan di halaman awal Fun Run, di bawah tombol "Daftar
                Sekarang", buat peserta yang mau tanya-tanya dulu.
            </p>

        </div>

        <form
            action="{{ route('admin.fun-run.settings.event.contact', $event) }}"
            method="POST"
            class="grid gap-4 p-6 sm:grid-cols-2"
        >
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nama Kontak Person
                </label>
                <input
                    type="text"
                    name="contact_person_name"
                    value="{{ old('contact_person_name', $event->contact_person_name) }}"
                    placeholder="Contoh: Kak Fadil"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div>
                <label class="mb-1 block text-xs font-semibold text-slate-500">
                    Nomor WhatsApp
                </label>
                <input
                    type="text"
                    name="contact_person_phone"
                    value="{{ old('contact_person_phone', $event->contact_person_phone) }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                >
            </div>

            <div class="sm:col-span-2">
                <button
                    type="submit"
                    class="rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-700"
                >
                    Simpan Kontak
                </button>
            </div>

        </form>

    </div>


    {{-- =========================================================
        MODE MAINTENANCE
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Mode Maintenance
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kalau diaktifkan, halaman pendaftaran (
                <code class="rounded bg-slate-100 px-1.5 py-0.5">/fun-run/register</code>
                ) otomatis tertutup untuk publik selama durasi yang dipilih —
                otomatis nyala lagi sendiri setelah waktunya habis, atau bisa
                dimatikan manual kapan saja.
            </p>

        </div>

        <div class="p-6">

            @if ($event->is_maintenance && $event->maintenance_until && now()->lt($event->maintenance_until))

                {{-- SEDANG MAINTENANCE --}}

                <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-5">

                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-red-500"></span>
                        <p class="font-bold text-red-700">
                            Sedang Maintenance
                        </p>
                    </div>

                    <p class="mt-2 text-sm text-red-600">
                        Aktif sampai
                        <strong>{{ $event->maintenance_until->translatedFormat('d F Y, H:i') }} WITA</strong>
                        (otomatis mati sendiri setelah itu).
                    </p>

                </div>

                <form
                    action="{{ route('admin.fun-run.settings.event.maintenance', $event) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="stop">

                    <button
                        type="submit"
                        onclick="return confirm('Matikan mode maintenance sekarang? Pendaftaran akan langsung terbuka lagi untuk publik.')"
                        class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-600"
                    >
                        Matikan Maintenance Sekarang
                    </button>

                </form>

            @else

                {{-- TIDAK SEDANG MAINTENANCE --}}

                <div class="mb-5 flex items-center gap-2">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                    <p class="text-sm font-semibold text-emerald-700">
                        Website normal, tidak sedang maintenance.
                    </p>
                </div>

                <form
                    action="{{ route('admin.fun-run.settings.event.maintenance', $event) }}"
                    method="POST"
                    class="flex flex-wrap items-end gap-3"
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="start">

                    <div>
                        <label class="mb-1 block text-xs font-semibold text-slate-500">
                            Durasi (jam)
                        </label>
                        <input
                            type="number"
                            name="hours"
                            min="1"
                            max="720"
                            value="1"
                            required
                            class="w-32 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                        >
                    </div>

                    <button
                        type="submit"
                        onclick="return confirm('Aktifkan mode maintenance? Pendaftaran akan tertutup untuk publik selama durasi yang dipilih.')"
                        class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-700"
                    >
                        Aktifkan Maintenance
                    </button>

                    <p class="w-full text-xs text-slate-500">
                        Contoh: isi "1" untuk 1 jam, "3" untuk 3 jam, dst.
                        Maksimal 720 jam (30 hari).
                    </p>

                </form>

            @endif

        </div>

    </div>


    {{-- =========================================================
        PERIODE PENDAFTARAN
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Periode Pendaftaran
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Periode yang diaktifkan akan langsung dipakai di halaman
                pendaftaran publik. Hanya boleh satu periode aktif dalam
                satu waktu — mengaktifkan periode baru otomatis
                menonaktifkan periode lain.
            </p>

        </div>

        {{-- FORM TAMBAH PERIODE BARU --}}

        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">

            <p class="mb-3 text-sm font-bold text-slate-700">
                Tambah Periode Baru
            </p>

            <form
                action="{{ route('admin.fun-run.settings.periods.store') }}"
                method="POST"
                class="grid gap-3 sm:grid-cols-3"
            >
                @csrf

                <div>

                    <label class="mb-1 block text-xs font-semibold text-slate-500">
                        Nama Periode
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Contoh: Presale"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    >

                </div>

                <div>

                    <label class="mb-1 block text-xs font-semibold text-slate-500">
                        Mulai
                    </label>

                    <input
                        type="datetime-local"
                        name="start_at"
                        value="{{ old('start_at') }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    >

                </div>

                <div>

                    <label class="mb-1 block text-xs font-semibold text-slate-500">
                        Selesai
                    </label>

                    <input
                        type="datetime-local"
                        name="end_at"
                        value="{{ old('end_at') }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                    >

                </div>

                <div class="sm:col-span-3">

                    <button
                        type="submit"
                        class="rounded-lg bg-emerald-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-700"
                    >
                        + Tambah Periode
                    </button>

                    <p class="mt-2 text-xs text-slate-500">
                        Periode baru dibuat dalam keadaan nonaktif. Aktifkan
                        manual dari daftar di bawah kalau sudah siap dipakai.
                    </p>

                </div>

            </form>

        </div>

        <div class="divide-y divide-slate-100">

            @forelse ($event->periods as $period)

                <div class="px-6 py-5">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <p class="font-bold text-slate-900">
                                {{ $period->name }}
                            </p>

                            @if ($period->is_active)
                                <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                    Nonaktif
                                </span>
                            @endif

                        </div>

                        <form
                            action="{{ route('admin.fun-run.settings.periods.toggle', $period) }}"
                            method="POST"
                        >
                            @csrf

                            <button
                                type="submit"
                                class="rounded-xl px-4 py-2.5 text-xs font-bold text-white transition
                                       {{ $period->is_active
                                            ? 'bg-red-600 hover:bg-red-700'
                                            : 'bg-emerald-600 hover:bg-emerald-700' }}"
                            >
                                {{ $period->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>

                        </form>

                    </div>

                    {{-- FORM EDIT NAMA & TANGGAL --}}

                    <form
                        action="{{ route('admin.fun-run.settings.periods.update', $period) }}"
                        method="POST"
                        class="mt-4 grid gap-3 sm:grid-cols-3"
                    >
                        @csrf
                        @method('PUT')

                        <div>

                            <label class="mb-1 block text-xs font-semibold text-slate-500">
                                Nama Periode
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $period->name) }}"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >

                        </div>

                        <div>

                            <label class="mb-1 block text-xs font-semibold text-slate-500">
                                Mulai
                            </label>

                            <input
                                type="datetime-local"
                                name="start_at"
                                value="{{ old('start_at', $period->start_at->format('Y-m-d\TH:i')) }}"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >

                        </div>

                        <div>

                            <label class="mb-1 block text-xs font-semibold text-slate-500">
                                Selesai
                            </label>

                            <input
                                type="datetime-local"
                                name="end_at"
                                value="{{ old('end_at', $period->end_at->format('Y-m-d\TH:i')) }}"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                            >

                        </div>

                        <div class="sm:col-span-3">

                            <button
                                type="submit"
                                class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-600"
                            >
                                Simpan Periode
                            </button>

                        </div>

                    </form>

                </div>

            @empty

                <div class="px-6 py-10 text-center text-sm text-slate-400">
                    Belum ada periode.
                </div>

            @endforelse

        </div>

    </div>


    {{-- =========================================================
        STOK TIKET
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Stok Tiket
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Kosongkan lalu simpan untuk membuat stok tidak terbatas.
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            Periode
                        </th>

                        <th class="px-6 py-4">
                            Kategori
                        </th>

                        <th class="px-6 py-4">
                            Harga
                        </th>

                        <th class="px-6 py-4">
                            Terpakai
                        </th>

                        <th class="px-6 py-4">
                            Stok
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($event->prices as $price)

                        <tr>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $price->period->name }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                    {{ $price->category->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4">

                                <form
                                    action="{{ route('admin.fun-run.settings.prices.price', $price) }}"
                                    method="POST"
                                    class="flex items-center gap-2"
                                >
                                    @csrf
                                    @method('PUT')

                                    <span class="text-slate-500">
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        name="price"
                                        min="0"
                                        step="1"
                                        value="{{ $price->price }}"
                                        required
                                        class="w-28 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                                    >

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white transition hover:bg-emerald-600"
                                    >
                                        Simpan
                                    </button>

                                </form>

                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $price->registrations()
                                    ->whereIn('status', ['waiting_payment', 'waiting_verification', 'paid'])
                                    ->count() }}
                            </td>

                            <td class="px-6 py-4">

                                <form
                                    action="{{ route('admin.fun-run.settings.prices.quota', $price) }}"
                                    method="POST"
                                    class="flex items-center gap-2"
                                >
                                    @csrf

                                    <input
                                        type="number"
                                        name="quota"
                                        min="0"
                                        value="{{ $price->quota }}"
                                        placeholder="Tanpa batas"
                                        class="w-28 rounded-lg border border-slate-300 px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20"
                                    >

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white transition hover:bg-emerald-600"
                                    >
                                        Simpan
                                    </button>

                                </form>

                            </td>

                            <td class="px-6 py-4 text-right text-xs text-slate-400">
                                #{{ $price->id }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-400">
                                Belum ada data harga/kategori.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection