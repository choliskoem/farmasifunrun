@extends('layouts.admin')

@section('title', 'Pengurus')

@section('content')

<div class="space-y-6">


    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>

            <p class="text-sm font-semibold text-emerald-600">
                Organisasi
            </p>

            <h1 class="mt-1 text-2xl font-extrabold text-slate-900">
                Pengurus HIMAFA
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola struktur dan data pengurus HIMAFA.
            </p>

        </div>


        <a
            href="{{ route('admin.management-members.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl
            bg-emerald-600 px-5 py-3 text-sm font-bold text-white
            hover:bg-emerald-700"
        >

            <span>+</span>

            Tambah Pengurus

        </a>

    </div>



    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4">
                            #
                        </th>

                        <th class="px-6 py-4">
                            Pengurus
                        </th>

                        <th class="px-6 py-4">
                            Jabatan
                        </th>

                        <th class="px-6 py-4">
                            Periode
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($members as $member)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    @if($member->foto)

                                        <img
                                            src="{{ asset('storage/' . $member->foto) }}"
                                            class="h-12 w-12 rounded-xl object-cover"
                                        >

                                    @else

                                        <div
                                            class="flex h-12 w-12 items-center
                                            justify-center rounded-xl
                                            bg-emerald-100 text-lg font-bold
                                            text-emerald-600"
                                        >
                                            {{ strtoupper(substr($member->nama, 0, 1)) }}
                                        </div>

                                    @endif


                                    <div>

                                        <div class="font-bold text-slate-900">
                                            {{ $member->nama }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ $member->jabatan }}
                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $member->period->nama_periode ?? '-' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($member->aktif)

                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Aktif
                                    </span>

                                @else

                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.management-members.edit', $member) }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.management-members.destroy', $member) }}"
                                        onsubmit="return confirm('Hapus pengurus ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-slate-500"
                            >
                                Belum ada data pengurus.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection