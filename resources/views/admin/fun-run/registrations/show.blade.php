@extends('layouts.admin')

@section('title', 'Detail Peserta Fun Run')

@section('content')

    <div class="space-y-6">

        {{-- =========================================================
        HEADER
    ========================================================== --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <a href="{{ route('admin.fun-run.registrations') }}"
                    class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-emerald-600">
                    ← Kembali ke Peserta
                </a>

                <h1 class="text-2xl font-black text-slate-900">
                    Detail Peserta
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Periksa data peserta dan bukti pembayaran sebelum melakukan verifikasi.
                </p>

            </div>


            {{-- STATUS --}}

            <div class="flex items-center gap-3">

                @if ($registration->status === 'paid')

                    <a href="{{ route('fun-run.ticket.download', $registration->registration_code) }}"
                        class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-bold text-white transition hover:bg-emerald-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                        Download Tiket
                    </a>

                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Pembayaran Terverifikasi
                    </span>
                @elseif($registration->status === 'waiting_verification')
                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-4 py-2 text-sm font-bold text-amber-700">
                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        Menunggu Verifikasi
                    </span>
                @elseif($registration->status === 'rejected')
                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-bold text-red-700">
                        <span class="h-2 w-2 rounded-full bg-red-500"></span>
                        Pembayaran Ditolak
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-bold text-slate-600">
                        {{ ucfirst(str_replace('_', ' ', $registration->status)) }}
                    </span>
                @endif

            </div>

        </div>



        {{-- =========================================================
        REGISTRATION CODE
    ========================================================== --}}

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-bold uppercase tracking-widest text-emerald-600">
                        Kode Registrasi
                    </p>

                    <p class="mt-1 text-2xl font-black tracking-wide text-emerald-700">
                        {{ $registration->registration_code }}
                    </p>

                </div>

                <div class="text-left sm:text-right">

                    <p class="text-xs text-slate-500">
                        Tanggal Registrasi
                    </p>

                    <p class="font-bold text-slate-800">
                        {{ $registration->created_at?->format('d F Y H:i') }}
                    </p>

                </div>

            </div>

        </div>



        {{-- =========================================================
        DATA PESERTA
    ========================================================== --}}

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="font-black text-slate-900">
                    Data Peserta
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi yang diisi peserta saat melakukan registrasi.
                </p>

            </div>


            <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Nama --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Nama Lengkap
                    </p>

                    <p class="mt-2 font-bold text-slate-900">
                        {{ $registration->name }}
                    </p>

                </div>


                {{-- Email --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Email
                    </p>

                    <p class="mt-2 break-all font-semibold text-slate-800">
                        {{ $registration->email }}
                    </p>

                </div>


                {{-- Telepon --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Nomor HP
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->phone ?? '-' }}
                    </p>

                </div>


                {{-- NIK --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        NIK
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->identity_number ?? '-' }}
                    </p>

                </div>


                {{-- Jenis Kelamin --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Jenis Kelamin
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        @if ($registration->gender === 'L')
                            Laki-laki
                        @elseif ($registration->gender === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>

                </div>


                {{-- Tanggal Lahir --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Tanggal Lahir
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->birth_date ?? '-' }}
                    </p>

                </div>


                {{-- Ukuran Baju --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Ukuran Baju
                    </p>

                    <p class="mt-2">
                        <span class="inline-flex rounded-lg bg-emerald-100 px-3 py-1 text-sm font-bold text-emerald-700">
                            {{ $registration->shirt_size ?? '-' }}
                        </span>
                    </p>

                </div>


                {{-- Kontak Darurat --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Kontak Darurat
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->emergency_contact_phone ?? '-' }}
                    </p>

                </div>


                {{-- Alamat --}}

                <div class="sm:col-span-2 lg:col-span-3">

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Alamat
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->address ?? '-' }}
                    </p>

                </div>


                {{-- Riwayat Penyakit --}}

                <div class="sm:col-span-2 lg:col-span-3">

                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Riwayat Penyakit
                    </p>

                    <p class="mt-2 font-semibold text-slate-800">
                        {{ $registration->medical_history ?: 'Tidak ada' }}
                    </p>

                </div>

            </div>

        </div>



        {{-- =========================================================
        PAKET / KATEGORI
    ========================================================== --}}

        <div class="grid gap-6 lg:grid-cols-2">


            {{-- KATEGORI --}}

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="font-black text-slate-900">
                        Paket Pendaftaran
                    </h2>

                </div>


                <div class="space-y-5 p-6">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Kategori
                        </p>

                        <p class="mt-2 text-lg font-black text-slate-900">
                            {{ $registration->category?->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Periode Harga
                        </p>

                        <p class="mt-2 font-bold text-slate-800">
                            {{ $registration->price?->period?->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Total Pembayaran
                        </p>

                        <p class="mt-2 text-2xl font-black text-emerald-600">

                            Rp
                            {{ number_format($registration->amount ?? ($registration->price?->price ?? 0), 0, ',', '.') }}

                        </p>

                        @if ($registration->unique_code)
                            <p class="mt-1 text-xs text-slate-500">
                                Termasuk kode unik
                                <span class="font-bold text-slate-700">
                                    {{ $registration->unique_code }}
                                </span>
                            </p>
                        @endif

                    </div>

                </div>

            </div>



            {{-- INFORMASI EVENT --}}

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="font-black text-slate-900">
                        Informasi Event
                    </h2>

                </div>


                <div class="space-y-5 p-6">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Event
                        </p>

                        <p class="mt-2 font-black text-slate-900">
                            {{ $registration->event?->name ?? '-' }}
                        </p>

                    </div>


                    @if ($registration->event?->start_date)
                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Tanggal Event
                            </p>

                            <p class="mt-2 font-bold text-slate-800">
                                {{ $registration->event->start_date }}
                            </p>

                        </div>
                    @endif

                </div>

            </div>

        </div>



        {{-- =========================================================
        PEMBAYARAN
    ========================================================== --}}

        @php

            $payment = $registration->latestPayment ?? $registration->payments->sortByDesc('created_at')->first();

        @endphp


        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="font-black text-slate-900">
                    Informasi Pembayaran
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Periksa metode transfer dan bukti pembayaran peserta.
                </p>

            </div>


            @if ($payment)

                <div class="grid gap-6 p-6 lg:grid-cols-2">


                    {{-- INFORMASI TRANSFER --}}

                    <div class="space-y-5">


                        {{-- Channel --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Metode Pembayaran
                            </p>

                            <p class="mt-2 font-bold text-slate-900">
                                {{ strtoupper($payment->payment_channel ?? '-') }}
                            </p>

                        </div>


                        {{-- Tipe Transfer --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Transfer Melalui
                            </p>

                            <p class="mt-2 font-bold text-slate-900">

                                @if ($payment->transfer_type === 'self')
                                    Rekening Sendiri
                                @elseif($payment->transfer_type === 'other')
                                    Rekening Orang Lain
                                @else
                                    -
                                @endif

                            </p>

                        </div>


                        {{-- Nama Pengirim --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Nama Pengirim
                            </p>

                            <p class="mt-2 font-bold text-slate-900">
                                {{ $payment->sender_name ?? '-' }}
                            </p>

                        </div>


                        {{-- Bank Pengirim --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Bank Pengirim
                            </p>

                            <p class="mt-2 font-bold text-slate-900">
                                {{ $payment->sender_bank ?? '-' }}
                            </p>

                        </div>


                        {{-- Nomor Rekening --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Nomor Rekening Pengirim
                            </p>

                            <p class="mt-2 font-bold text-slate-900">
                                {{ $payment->sender_account_number ?? '-' }}
                            </p>

                        </div>


                        {{-- Jumlah --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Jumlah Transfer
                            </p>

                            <p class="mt-2 text-xl font-black text-emerald-600">

                                Rp
                                {{ number_format($payment->amount ?? 0, 0, ',', '.') }}

                            </p>

                        </div>

                        {{-- Waktu Pengajuan Pembayaran --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Waktu Pengajuan Pembayaran
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $payment->submitted_at?->format('d F Y H:i') ?? '-' }}
                            </p>

                        </div>


                        {{-- Status Payment --}}

                        <div>

                            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                                Status Pembayaran
                            </p>

                            <div class="mt-2">

                                @if ($payment->status === 'verified')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Terverifikasi
                                    </span>
                                @elseif($payment->status === 'submitted')
                                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($payment->status === 'rejected')
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-bold text-red-700">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                        {{ $payment->status }}
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- =========================================================
BUKTI TRANSFER
========================================================== --}}

                    <div>

                        <p class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                            Bukti Transfer
                        </p>

                        @if ($payment && $payment->proof)
                            @php
                                $proofUrl = asset('storage/' . $payment->proof);
                            @endphp

                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">

                                <a href="{{ $proofUrl }}" target="_blank" rel="noopener">

                                    <img src="{{ $proofUrl }}" alt="Bukti Transfer"
                                        class="max-h-[600px] w-full object-contain">

                                </a>

                            </div>


                            <a href="{{ $proofUrl }}" target="_blank" rel="noopener"
                                class="mt-3 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-emerald-600">
                                ↗ Buka Bukti Transfer
                            </a>


                            {{-- DEBUG / INFORMASI FILE --}}

                            <div class="mt-3 rounded-xl bg-slate-50 p-3 text-xs text-slate-500">

                                <div>
                                    <span class="font-bold">
                                        File:
                                    </span>

                                    {{ $payment->proof }}

                                </div>

                                <div class="mt-1 break-all">

                                    <span class="font-bold">
                                        URL:
                                    </span>

                                    {{ $proofUrl }}

                                </div>

                            </div>
                        @else
                            <div
                                class="flex min-h-[300px] items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50">

                                <div class="text-center">

                                    <div class="text-4xl">
                                        📄
                                    </div>

                                    <p class="mt-3 font-bold text-slate-700">
                                        Bukti transfer belum tersedia
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Kolom proof pada pembayaran masih kosong.
                                    </p>

                                </div>

                            </div>
                        @endif

                    </div>
                </div>
            @else
                <div class="p-10 text-center">

                    <div class="text-4xl">
                        💳
                    </div>

                    <p class="mt-3 font-bold text-slate-700">
                        Belum ada data pembayaran
                    </p>

                    <p class="mt-1 text-sm text-slate-400">
                        Peserta belum mengirim bukti pembayaran.
                    </p>

                </div>

            @endif

        </div>



        {{-- =========================================================
        CATATAN ADMIN
    ========================================================== --}}

        @if ($payment && $payment->admin_note)
            <div class="rounded-2xl border border-red-200 bg-red-50 p-6">

                <p class="text-xs font-bold uppercase tracking-wider text-red-500">
                    Catatan Admin
                </p>

                <p class="mt-2 text-sm font-semibold leading-6 text-red-700">
                    {{ $payment->admin_note }}
                </p>

            </div>
        @endif



        {{-- =========================================================
        KIRIM ULANG LINK PEMBAYARAN (OPSIONAL)
    ========================================================== --}}

        @if ($registration->status !== 'paid' && !($payment && $payment->status === 'submitted'))
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6">

                <div class="mb-4">

                    <h2 class="font-black text-slate-900">
                        Kirim Ulang Link Pembayaran
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Peserta sudah otomatis mendapatkan link pembayaran
                        setelah mengisi biodata, jadi ini bukan langkah wajib.
                        Gunakan tombol ini hanya kalau peserta kehilangan
                        link atau memintanya dikirim ulang ke email.
                    </p>

                </div>

                <form
                    action="{{ route('admin.fun-run.registrations.verify-email', $registration) }}"
                    method="POST"
                    onsubmit="return confirm(
        'Kirim ulang link pembayaran baru ke email peserta? Link lama akan tidak berlaku lagi.'
    )">
                    @csrf

                    <button type="submit"
                        class="rounded-xl bg-slate-800 px-4 py-2 text-sm font-bold text-white hover:bg-slate-900">
                        Kirim Ulang Link Pembayaran
                    </button>

                </form>

            </div>
        @endif


        {{-- =========================================================
        AKSI VERIFIKASI PEMBAYARAN
    ========================================================== --}}

        @if ($payment && $payment->status === 'submitted')
            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-6">

                <div class="mb-5">

                    <h2 class="font-black text-amber-900">
                        Verifikasi Pembayaran
                    </h2>

                    <p class="mt-1 text-sm text-amber-700">
                        Pastikan jumlah transfer, nama pengirim, rekening pengirim,
                        dan bukti transfer sudah sesuai sebelum menyetujui.
                    </p>

                    @if ($registration->channel && $registration->channel !== 'public')
                        <span class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-amber-200 px-3 py-1 text-xs font-bold text-amber-900">
                            Didaftarkan manual — {{ $registration->channel === 'backdoor' ? 'Jalur Spesial' : ucfirst($registration->channel) }}
                        </span>
                    @endif

                </div>


                <div class="grid gap-4 sm:grid-cols-2">


                    {{-- VERIFIKASI PEMBAYARAN --}}

                    <form
                        action="{{ route('admin.fun-run.registrations.verify', $registration) }}"
                        method="POST"
                        onsubmit="return confirm(
        'Verifikasi pembayaran ini? Kode registrasi akan diaktifkan dan email konfirmasi akan dikirim ke peserta. Jangan sebarluaskan kode registrasi peserta.'
    )">
                        @csrf

                        <button type="submit"
                            class="w-full rounded-xl bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">
                            ✓ Verifikasi Pembayaran
                        </button>

                    </form>



                    {{-- TOLAK --}}

                    <form method="POST" action="{{ route('admin.fun-run.registrations.reject', $registration) }}"
                        onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">

                        @csrf

                        <div class="mb-3">

                            <label class="mb-2 block text-sm font-bold text-slate-700">
                                Alasan Penolakan
                                <span class="text-red-500">*</span>
                            </label>

                            <textarea name="admin_note" rows="3" required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                placeholder="Contoh: Bukti transfer tidak sesuai / dana belum masuk."></textarea>

                        </div>


                        <button type="submit"
                            class="w-full rounded-xl bg-red-600 px-5 py-3 font-bold text-white transition hover:bg-red-700">
                            ✕ Tolak Pembayaran
                        </button>

                    </form>

                </div>

            </div>
        @endif



        {{-- =========================================================
        INFORMASI VERIFIKASI
    ========================================================== --}}

        @if ($payment && $payment->status === 'verified')

            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-6">

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-xl text-white">
                        ✓
                    </div>

                    <div>

                        <h2 class="font-black text-emerald-900">
                            Pembayaran Sudah Diverifikasi
                        </h2>

                        <p class="mt-1 text-sm text-emerald-700">
                            Pembayaran peserta telah dinyatakan valid.
                        </p>

                        @if ($payment->verified_at)
                            <p class="mt-3 text-xs font-semibold text-emerald-600">
                                Diverifikasi:
                                {{ $payment->verified_at->format('d F Y H:i') }}
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection