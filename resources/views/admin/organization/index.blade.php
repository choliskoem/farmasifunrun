@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- Header --}}

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>

            <h1 class="text-2xl font-extrabold text-slate-900">
                Struktur Organisasi
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola seluruh pengurus HIMAFA periode berjalan.
            </p>

        </div>

        <button
            type="button"
            onclick="openModal()"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 5v14M5 12h14"
                />

            </svg>

            Tambah Pengurus

        </button>

    </div>


    {{-- Periode --}}

    <div class="flex flex-col justify-between gap-4 rounded-2xl border border-emerald-100 bg-emerald-50 p-5 sm:flex-row sm:items-center">

        <div>

            <div class="text-xs font-bold uppercase tracking-wider text-emerald-600">
                Periode Aktif
            </div>

            <div class="mt-1 text-xl font-extrabold text-emerald-900">
                Kepengurusan HIMAFA 2026
            </div>

        </div>

        <div class="rounded-full bg-white px-4 py-2 text-xs font-bold text-emerald-600">
            15 Pengurus
        </div>

    </div>


    {{-- Pengurus Inti --}}

    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6">

        <div class="mb-6">

            <h2 class="font-extrabold text-slate-900">
                Pengurus Inti
            </h2>

            <p class="mt-1 text-xs text-slate-400">
                Ketua, Sekretaris dan Bendahara.
            </p>

        </div>


        <div class="grid gap-5 md:grid-cols-3">

            @php

                $core = [

                    [
                        'jabatan' => 'Ketua Umum',
                        'nama' => 'Rayyan Zulfanafilah Lasanudin',
                        'image' => 'ketua.jpg',
                    ],

                    [
                        'jabatan' => 'Sekretaris Umum',
                        'nama' => 'Faizal Eyato',
                        'image' => 'anggota.jpg',
                    ],

                    [
                        'jabatan' => 'Bendahara Umum',
                        'nama' => 'Rafiqa S. K Mamonto',
                        'image' => 'anggota.jpg',
                    ],

                ];

            @endphp


            @foreach($core as $item)

                <div class="group rounded-[1.5rem] border border-slate-200 p-5 transition hover:border-emerald-200 hover:shadow-lg">

                    <div class="flex items-start justify-between">

                        <div class="h-20 w-20 overflow-hidden rounded-2xl bg-emerald-50">

                            <img
                                src="{{ asset('images/' . $item['image']) }}"
                                class="h-full w-full object-cover"
                                onerror="this.style.display='none'"
                            >

                        </div>

                        <button
                            type="button"
                            class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-emerald-600"
                        >

                            ⋮

                        </button>

                    </div>

                    <div class="mt-5 text-[10px] font-bold uppercase tracking-widest text-emerald-600">
                        {{ $item['jabatan'] }}
                    </div>

                    <div class="mt-2 text-base font-extrabold text-slate-900">
                        {{ $item['nama'] }}
                    </div>

                    <div class="mt-4 flex gap-2">

                        <button
                            type="button"
                            class="flex-1 rounded-xl bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            class="rounded-xl bg-red-50 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-100"
                        >
                            Hapus
                        </button>

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    {{-- Bidang --}}

    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6">

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

            <div>

                <h2 class="font-extrabold text-slate-900">
                    Bidang Kepengurusan
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Kelola ketua dan sekretaris masing-masing bidang.
                </p>

            </div>

            <button
                type="button"
                onclick="openModal()"
                class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-bold text-slate-600 hover:border-emerald-200 hover:text-emerald-600"
            >
                + Tambah Bidang
            </button>

        </div>


        <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200">

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Bidang
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Ketua Bidang
                            </th>

                            <th class="px-5 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">
                                Sekretaris
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-bold uppercase tracking-wider text-slate-400">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @php

                            $departments = [

                                [
                                    'name' => 'BP3AO',
                                    'ketua' => 'Soraya Azahra Alaydrus',
                                    'sekretaris' => 'Diva Meilani',
                                ],

                                [
                                    'name' => 'Humas',
                                    'ketua' => 'Qurota Aini Az-Zahra Anda',
                                    'sekretaris' => 'Nurul Najwalya J. Puhi',
                                ],

                                [
                                    'name' => 'Minat & Bakat',
                                    'ketua' => 'Natasya Talango',
                                    'sekretaris' => 'Aulia Nisfatuzzahra Biki',
                                ],

                                [
                                    'name' => 'PIK',
                                    'ketua' => 'Dirga Anugrah Mokoginta',
                                    'sekretaris' => 'Fildzah Syaputri Mamonto',
                                ],

                                [
                                    'name' => 'Kewirausahaan',
                                    'ketua' => 'Nurindah Yuliyani Usman',
                                    'sekretaris' => 'Feby Adinda Malik',
                                ],

                                [
                                    'name' => 'TIK',
                                    'ketua' => 'Karim Putra Dunggio',
                                    'sekretaris' => 'Deswita Faradila Sango',
                                ],

                                [
                                    'name' => 'Kerohanian',
                                    'ketua' => 'Rahmat Aprianto Tamalero',
                                    'sekretaris' => 'Hariyanto Suronoto',
                                ],

                            ];

                        @endphp


                        @foreach($departments as $department)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-5">

                                    <div class="font-extrabold text-slate-900">
                                        {{ $department['name'] }}
                                    </div>

                                    <div class="mt-1 text-[10px] font-bold uppercase tracking-wider text-emerald-600">
                                        HIMAFA
                                    </div>

                                </td>

                                <td class="px-5 py-5 text-sm font-semibold text-slate-600">
                                    {{ $department['ketua'] }}
                                </td>

                                <td class="px-5 py-5 text-sm text-slate-500">
                                    {{ $department['sekretaris'] }}
                                </td>

                                <td class="px-5 py-5">

                                    <div class="flex justify-end gap-2">

                                        <button
                                            type="button"
                                            class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-bold text-slate-600 hover:bg-emerald-50 hover:text-emerald-600"
                                        >
                                            Edit
                                        </button>

                                        <button
                                            type="button"
                                            class="rounded-xl bg-red-50 px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =====================================================
    MODAL
====================================================== --}}

<div
    id="organization-modal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/50 p-5 backdrop-blur-sm"
>

    <div class="w-full max-w-lg rounded-[2rem] bg-white p-7 shadow-2xl">

        <div class="flex items-center justify-between">

            <div>

                <h2 class="text-xl font-extrabold text-slate-900">
                    Tambah Pengurus
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Masukkan data pengurus baru.
                </p>

            </div>

            <button
                onclick="closeModal()"
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200"
            >
                ×
            </button>

        </div>


        <form class="mt-7 space-y-5">

            <div>

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    class="form-input"
                    placeholder="Nama lengkap"
                >

            </div>


            <div>

                <label class="form-label">
                    Jabatan
                </label>

                <select class="form-input">

                    <option>Ketua Umum</option>

                    <option>Sekretaris Umum</option>

                    <option>Bendahara Umum</option>

                    <option>Ketua Bidang</option>

                    <option>Sekretaris Bidang</option>

                </select>

            </div>


            <div>

                <label class="form-label">
                    Foto
                </label>

                <input
                    type="file"
                    class="form-input"
                >

            </div>


            <div class="flex gap-3 pt-3">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="flex-1 rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-600"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="flex-1 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')

<style>

.form-label {
    @apply mb-2 block text-xs font-bold uppercase tracking-wider text-slate-500;
}

.form-input {
    @apply w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10;
}

</style>


<script>

function openModal()
{
    const modal = document.getElementById('organization-modal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal()
{
    const modal = document.getElementById('organization-modal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

</script>

@endpush