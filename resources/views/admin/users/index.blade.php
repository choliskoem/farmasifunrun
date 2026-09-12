@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
                🛡️
            </div>

            <div>

                <h1 class="text-2xl font-black text-slate-900">
                    Kelola Admin
                </h1>

                <p class="text-sm text-slate-500">
                    Cuma Super Admin yang bisa buka halaman ini.
                </p>

            </div>

        </div>

        <a
            href="{{ route('admin.users.create') }}"
            class="inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-emerald-700"
        >
            + Tambah Admin
        </a>

    </div>

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

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <table class="w-full text-left text-sm">

            <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse ($users as $user)
                    <tr class="transition hover:bg-slate-50">

                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900">
                                {{ $user->name }}
                                @if ($user->id === auth()->id())
                                    <span class="ml-1 text-xs font-normal text-slate-400">(Anda)</span>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($user->isSuperAdmin())
                                <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700">
                                    Super Admin
                                </span>
                            @else
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                                    Admin
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">

                            <div class="flex justify-end gap-2">

                                <a
                                    href="{{ route('admin.users.edit', $user) }}"
                                    class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white transition hover:bg-emerald-600"
                                >
                                    Edit
                                </a>

                                @if ($user->id !== auth()->id())
                                    <form
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus akun {{ $user->name }}?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-100"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-sm text-slate-400">
                            Belum ada akun admin.
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection