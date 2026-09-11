@extends('layouts.admin')

@section('title', 'Social Media')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="text-sm text-slate-500">
                Admin / Social Media
            </div>

            <h1 class="mt-1 text-2xl font-extrabold">
                Social Media
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola tautan media sosial HIMAFA.
            </p>

        </div>

        <a
            href="{{ route('admin.social-links.create') }}"
            class="rounded-xl bg-emerald-600 px-5 py-3 text-center text-sm font-bold text-white hover:bg-emerald-700"
        >
            + Tambah Social Media
        </a>

    </div>


    @if(session('success'))

        <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>

    @endif


    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">

        @forelse($links as $link)

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-xl">
                        🔗
                    </div>

                    @if($link->aktif)

                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                            Aktif
                        </span>

                    @else

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                            Tidak Aktif
                        </span>

                    @endif

                </div>


                <h2 class="mt-5 font-extrabold text-slate-900">
                    {{ $link->platform }}
                </h2>


                <a
                    href="{{ $link->url }}"
                    target="_blank"
                    class="mt-2 block truncate text-sm text-emerald-600 hover:underline"
                >
                    {{ $link->url }}
                </a>


                <div class="mt-5 flex gap-2">

                    <a
                        href="{{ route('admin.social-links.edit', $link) }}"
                        class="flex-1 rounded-xl bg-blue-50 px-4 py-2.5 text-center text-sm font-bold text-blue-600"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('admin.social-links.destroy', $link) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Hapus social media ini?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="w-full rounded-xl bg-red-50 px-4 py-2.5 text-sm font-bold text-red-600"
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="md:col-span-2 xl:col-span-3 rounded-2xl border bg-white p-12 text-center text-slate-500">
                Belum ada social media.
            </div>

        @endforelse

    </div>

</div>

@endsection