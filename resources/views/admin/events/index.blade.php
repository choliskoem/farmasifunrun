@extends('layouts.admin')

@section('title', 'Event')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="text-sm text-slate-500">
                Admin / Event
            </div>

            <h1 class="mt-1 text-2xl font-extrabold">
                Event HIMAFA
            </h1>

        </div>

        <a
            href="{{ route('admin.events.create') }}"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-center text-sm font-bold text-white hover:bg-emerald-700"
        >
            + Tambah Event
        </a>

    </div>


    @if(session('success'))

        <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>

    @endif


    <div class="overflow-hidden rounded-2xl border bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-bold">
                            Event
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-bold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y">

                    @forelse($events as $event)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    @if($event->gambar)

                                        <img
                                            src="{{ asset('storage/' . $event->gambar) }}"
                                            class="h-16 w-24 rounded-xl object-cover"
                                        >

                                    @else

                                        <div class="flex h-16 w-24 items-center justify-center rounded-xl bg-slate-100">
                                            📅
                                        </div>

                                    @endif


                                    <div>

                                        <div class="font-bold text-slate-900">
                                            {{ $event->nama }}
                                        </div>

                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $event->tahun ?? '-' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            <td class="px-6 py-4 text-sm text-slate-600">

                                {{ $event->tanggal?->format('d M Y') ?? '-' }}

                            </td>


                            <td class="px-6 py-4">

                                @if($event->status === 'aktif')

                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                        Aktif
                                    </span>

                                @elseif($event->status === 'selesai')

                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                        Selesai
                                    </span>

                                @else

                                    <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-700">
                                        Draft
                                    </span>

                                @endif

                            </td>


                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.events.edit', $event) }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-600"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.events.destroy', $event) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus event ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button class="rounded-lg bg-red-50 px-3 py-2 text-xs font-bold text-red-600">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                Belum ada event.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection