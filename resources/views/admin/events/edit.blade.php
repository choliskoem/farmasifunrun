@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')

    <div class="mx-auto max-w-3xl">

        <div class="mb-6">

            <div class="text-sm text-slate-500">
                Admin / Event / Edit
            </div>

            <h1 class="mt-1 text-2xl font-extrabold">
                Edit Event
            </h1>

        </div>


        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data"
            class="rounded-2xl border bg-white p-6 shadow-sm">

            @csrf
            @method('PUT')

            <div class="space-y-5">

                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Nama Event
                    </label>

                    <input type="text" name="nama" value="{{ old('nama', $event->nama) }}" required
                        class="w-full rounded-xl border-slate-300 px-4 py-3">

                </div>


                <div>

                    <label class="mb-3 block text-sm font-bold">
                        Tipe Event
                    </label>

                    @if (auth()->user()->isSuperAdmin())

                        <div class="grid gap-3 sm:grid-cols-2">

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="tipe"
                                    value="full"
                                    id="tipe-full"
                                    class="peer sr-only"
                                    {{ old('tipe', $event->tipe ?? 'full') === 'full' ? 'checked' : '' }}
                                >

                                <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                                    <p class="font-bold text-slate-800">Full Event</p>
                                    <p class="mt-1 text-xs text-slate-500">Judul, deskripsi, tanggal, dan link ditampilkan lengkap.</p>
                                </div>

                            </label>

                            <label class="cursor-pointer">

                                <input
                                    type="radio"
                                    name="tipe"
                                    value="flyer"
                                    id="tipe-flyer"
                                    class="peer sr-only"
                                    {{ old('tipe', $event->tipe ?? '') === 'flyer' ? 'checked' : '' }}
                                >

                                <div class="rounded-xl border border-slate-300 p-4 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                                    <p class="font-bold text-slate-800">Hanya Flyer</p>
                                    <p class="mt-1 text-xs text-slate-500">Cuma gambar poster yang tampil, tanpa detail teks.</p>
                                </div>

                            </label>

                        </div>

                    @elseif ($event->tipe === 'full')

                        {{-- Event ini sudah tipe Full Event (dibuat Super
                        Admin). Dikunci -- admin biasa/user cuma bisa lihat,
                        nggak bisa ubah ke Flyer atau sebaliknya. --}}
                        <input type="hidden" name="tipe" value="full">

                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                            <p class="font-bold text-slate-800">Full Event</p>
                            <p class="mt-1 text-xs text-slate-500">
                                Tipe event ini cuma bisa diubah oleh Super Admin.
                            </p>
                        </div>

                    @else

                        {{-- Belum pernah jadi Full Event -- tetap nggak
                        boleh diubah ke situ selain oleh Super Admin. --}}
                        <input type="hidden" name="tipe" value="flyer">

                        <div class="rounded-xl border border-slate-300 bg-emerald-50 p-4">
                            <p class="font-bold text-slate-800">Hanya Flyer</p>
                            <p class="mt-1 text-xs text-slate-500">Cuma gambar poster yang tampil, tanpa detail teks.</p>
                        </div>

                        <p class="mt-2 text-xs text-slate-500">
                            Tipe "Full Event" cuma bisa dibuat oleh Super Admin.
                        </p>

                    @endif

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi" rows="5" class="w-full rounded-xl border-slate-300 px-4 py-3">{{ old('deskripsi', $event->deskripsi) }}</textarea>

                </div>


                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Tanggal
                        </label>

                        <input type="date" name="tanggal" value="{{ old('tanggal', $event->tanggal?->format('Y-m-d')) }}"
                            class="w-full rounded-xl border-slate-300 px-4 py-3">

                    </div>


                    <div>

                        <label class="mb-2 block text-sm font-bold">
                            Tahun
                        </label>

                        <input type="number" name="tahun" value="{{ old('tahun', $event->tahun) }}"
                            class="w-full rounded-xl border-slate-300 px-4 py-3">

                    </div>

                </div>


                <div id="full-only-fields">

                    <label class="mb-2 block text-sm font-bold">
                        Link Event
                    </label>

                    <input type="url" name="link" value="{{ old('link', $event->link) }}"
                        class="w-full rounded-xl border-slate-300 px-4 py-3">

                </div>


                @if ($event->gambar)
                    <div>

                        <p class="mb-2 text-sm font-bold">
                            Gambar Saat Ini
                        </p>

                        <img src="{{ asset('storage/' . $event->gambar) }}"
                            class="h-48 w-full rounded-2xl object-cover sm:w-80">

                    </div>
                @endif


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Ganti Gambar
                        <span id="gambar-required-mark" class="hidden text-red-500">*</span>
                    </label>

                    <input type="file" name="gambar" id="gambar-input" accept="image/*"
                        class="w-full rounded-xl border border-slate-300 p-2">

                    <p id="gambar-flyer-hint" class="mt-2 hidden text-xs text-slate-500">
                        Wajib diisi untuk tipe "Hanya Flyer" kalau belum pernah upload gambar sebelumnya.
                    </p>

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Status
                    </label>

                    <select name="status" required class="w-full rounded-xl border-slate-300 px-4 py-3">

                        <option value="draft" @selected($event->status === 'draft')>
                            Draft
                        </option>

                        <option value="aktif" @selected($event->status === 'aktif')>
                            Aktif
                        </option>

                        <option value="selesai" @selected($event->status === 'selesai')>
                            Selesai
                        </option>

                    </select>

                </div>

            </div>


            <div class="mt-6 flex justify-end gap-3">

                <a href="{{ route('admin.events.index') }}" class="rounded-xl border px-5 py-3 font-bold">
                    Batal
                </a>

                <button class="rounded-xl bg-emerald-600 px-6 py-3 font-bold text-white">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

<script>
    const tipeFull = document.getElementById('tipe-full');
    const tipeFlyer = document.getElementById('tipe-flyer');
    const fullOnlyFields = document.getElementById('full-only-fields');
    const gambarInput = document.getElementById('gambar-input');
    const gambarRequiredMark = document.getElementById('gambar-required-mark');
    const gambarFlyerHint = document.getElementById('gambar-flyer-hint');

    function toggleTipe() {

        // Kalau tipeFlyer nggak ada (non-Super Admin, event sudah
        // Full Event), berarti tipenya PASTI 'full' -- baca dari
        // hidden input sebagai gantinya.
        const isFlyer = tipeFlyer
            ? tipeFlyer.checked
            : document.querySelector('input[name="tipe"]')?.value === 'flyer';

        if (isFlyer) {
            fullOnlyFields.classList.add('hidden');
            gambarRequiredMark?.classList.remove('hidden');
            gambarFlyerHint?.classList.remove('hidden');
        } else {
            fullOnlyFields.classList.remove('hidden');
            gambarRequiredMark?.classList.add('hidden');
            gambarFlyerHint?.classList.add('hidden');
        }

    }

    tipeFull?.addEventListener('change', toggleTipe);
    tipeFlyer?.addEventListener('change', toggleTipe);

    toggleTipe();
</script>

@endsection