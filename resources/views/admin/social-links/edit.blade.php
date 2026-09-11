@extends('layouts.admin')

@section('title', 'Edit Social Media')

@section('content')

<div class="mx-auto max-w-2xl">

    <div class="mb-6">

        <div class="text-sm text-slate-500">
            Admin / Social Media / Edit
        </div>

        <h1 class="mt-1 text-2xl font-extrabold">
            Edit Social Media
        </h1>

    </div>


    <form
        action="{{ route('admin.social-links.update', $socialLink) }}"
        method="POST"
        class="rounded-2xl border bg-white p-6 shadow-sm"
    >

        @csrf
        @method('PUT')

        <div class="space-y-5">

            <div>

                <label class="mb-2 block text-sm font-bold">
                    Platform
                </label>

                <input
                    type="text"
                    name="platform"
                    value="{{ old('platform', $socialLink->platform) }}"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <div>

                <label class="mb-2 block text-sm font-bold">
                    URL
                </label>

                <input
                    type="url"
                    name="url"
                    value="{{ old('url', $socialLink->url) }}"
                    required
                    class="w-full rounded-xl border-slate-300 px-4 py-3"
                >

            </div>


            <label class="flex items-center gap-3">

                <input
                    type="checkbox"
                    name="aktif"
                    value="1"
                    @checked(old('aktif', $socialLink->aktif))
                    class="h-5 w-5 rounded text-emerald-600"
                >

                <span class="text-sm font-semibold">
                    Tampilkan di website
                </span>

            </label>

        </div>


        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('admin.social-links.index') }}"
                class="rounded-xl border px-5 py-3 font-bold"
            >
                Batal
            </a>

            <button
                class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection