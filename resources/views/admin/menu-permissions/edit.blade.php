@extends('layouts.admin')

@section('title', 'Atur Akses Menu')

@section('content')

<div class="space-y-6">

    <div class="flex items-center gap-3">

        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-2xl">
            🔐
        </div>

        <div>
            <h1 class="text-2xl font-black text-slate-900">Atur Akses Menu</h1>
            <p class="text-sm text-slate-500">
                Centang menu yang boleh dibuka tiap role. Super Admin selalu full akses,
                jadi tidak perlu diatur di sini.
            </p>
        </div>

    </div>

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.menu-permissions.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @php
            $roleLabels = ['admin' => 'Admin', 'user' => 'User'];
            // PENTING: parameter kedua "true" WAJIB ada -- ini yang
            // bikin key asli menu ('profile', 'vision', dst) tetap
            // dipertahankan. Kalau dihapus, Laravel otomatis ganti
            // key-nya jadi angka urut (0, 1, 2, ...) dan checkbox-nya
            // jadi kekirim value yang salah (value="0" bukan
            // value="profile"), sehingga nggak pernah kesimpen.
            $groupedMenus = collect($menus)->groupBy('group', true);
        @endphp

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-4">Menu</th>
                        @foreach ($roles as $role)
                            <th class="px-6 py-4 text-center">{{ $roleLabels[$role] ?? ucfirst($role) }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @foreach ($groupedMenus as $groupName => $groupMenus)

                        <tr class="bg-slate-50/70">
                            <td colspan="{{ count($roles) + 1 }}" class="px-6 py-2 text-xs font-black uppercase tracking-wider text-slate-400">
                                {{ $groupName }}
                            </td>
                        </tr>

                        @foreach ($groupMenus as $menuKey => $menu)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $menu['label'] }}
                                </td>

                                @foreach ($roles as $role)
                                    <td class="px-6 py-4 text-center">
                                        <input
                                            type="checkbox"
                                            name="{{ $role }}[]"
                                            value="{{ $menuKey }}"
                                            {{ in_array($menuKey, $permissions[$role] ?? []) ? 'checked' : '' }}
                                            class="h-5 w-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                        >
                                    </td>
                                @endforeach

                            </tr>
                        @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>

        <button
            type="submit"
            class="rounded-lg bg-emerald-600 px-6 py-3 text-sm font-bold text-white transition hover:bg-emerald-700"
        >
            Simpan Akses Menu.
        </button>

    </form>

</div>

@endsection