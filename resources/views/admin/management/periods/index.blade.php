@extends('layouts.admin')

@section('title', 'Periode Kepengurusan')

@section('content')

<div class="space-y-6">


    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>

            <p class="text-sm font-semibold text-emerald-600">
                Organisasi
            </p>

            <h1 class="mt-1 text-2xl font-extrabold text-slate-900">
                Periode Kepengurusan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola periode kepengurusan HIMAFA.
            </p>

        </div>


        <a
            href="{{ route('admin.management-periods.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl
            bg-emerald-600 px-5 py-3 text-sm font-bold text-white
            shadow-lg shadow-emerald-600/20 hover:bg-emerald-700"
        >

            <span>+</span>

            Tambah Periode

        </a>

    </div>



    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 font-bold text-slate-600">
                            #
                        </th>

                        <th class="px-6 py-4 font-bold text-slate-600">
                            Nama Periode
                        </th>

                        <th class="px-6 py-4 font-bold text-slate-600">
                            Tahun
                        </th>

                        <th class="px-6 py-4 font-bold text-slate-600">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right font-bold text-slate-600">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($periods as $period)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4 text-slate-500">
                                {{ $loop->iteration }}
                            </td>


                            <td class="px-6 py-4">

                                <div class="font-bold text-slate-900">
                                    {{ $period->nama_periode }}
                                </div>

                            </td>


                            <td class="px-6 py-4 text-slate-600">

                                {{ $period->tahun_mulai }}

                                -

                                {{ $period->tahun_selesai ?? 'Sekarang' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($period->aktif)

                                    <span
                                        class="inline-flex rounded-full bg-emerald-100
                                        px-3 py-1 text-xs font-bold text-emerald-700"
                                    >
                                        Aktif
                                    </span>

                                @else

                                    <span
                                        class="inline-flex rounded-full bg-slate-100
                                        px-3 py-1 text-xs font-bold text-slate-500"
                                    >
                                        Tidak Aktif
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.management-periods.edit', $period) }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2
                                        text-xs font-bold text-blue-600
                                        hover:bg-blue-100"
                                    >
                                        Edit
                                    </a>


                                    <form
                                        method="POST"
                                        action="{{ route('admin.management-periods.destroy', $period) }}"
                                        onsubmit="return confirm('Hapus periode ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-red-50 px-3 py-2
                                            text-xs font-bold text-red-600
                                            hover:bg-red-100"
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
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <div class="text-4xl">
                                    📅
                                </div>

                                <p class="mt-3 font-bold text-slate-700">
                                    Belum ada periode
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Silakan tambahkan periode kepengurusan.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection