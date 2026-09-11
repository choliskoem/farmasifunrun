@extends('layouts.admin')

@section('title', 'Misi HIMAFA')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">

        <div>
            <h1 class="text-3xl font-extrabold">
                Misi HIMAFA
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola misi organisasi.
            </p>
        </div>

        <a
            href="{{ route('admin.missions.create') }}"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white hover:bg-emerald-700">

            + Tambah Misi

        </a>

    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif


    <div class="overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Misi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($missions as $mission)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4 font-bold">
                                {{ $mission->nomor }}
                            </td>

                            <td class="max-w-2xl px-6 py-4 text-sm text-slate-600">
                                {{ $mission->isi }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($mission->aktif)
                                    <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">
                                        Aktif
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.missions.edit', $mission) }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-100">

                                        Edit

                                    </a>


                                    <form
                                        action="{{ route('admin.missions.destroy', $mission) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus misi ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600 hover:bg-red-100">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-400">
                                Belum ada data misi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection