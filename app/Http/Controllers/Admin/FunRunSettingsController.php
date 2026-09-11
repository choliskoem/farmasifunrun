<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FunRunCategory;
use App\Models\FunRunEvent;
use App\Models\FunRunPeriod;
use App\Models\FunRunPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FunRunSettingsController extends Controller
{
    /**
     * Halaman pengaturan periode & stok tiket.
     */
    public function index()
    {
        $event = FunRunEvent::with([
            'periods' => function ($query) {
                $query->orderBy('sort_order');
            },
            'prices' => function ($query) {
                $query->with(['category', 'period'])
                    ->orderBy('period_id')
                    ->orderBy('category_id');
            },
        ])
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$event) {
            abort(404, 'Event Fun Run belum tersedia.');
        }

        return view(
            'admin.fun-run.settings.index',
            compact('event')
        );
    }

    /**
     * Tambah periode baru.
     */
    public function storePeriod(Request $request)
    {
        $event = FunRunEvent::where('is_active', true)
            ->latest()
            ->first();

        if (!$event) {
            abort(404, 'Event Fun Run belum tersedia.');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'start_at' => [
                'required',
                'date',
            ],

            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
        ]);

        $nextSortOrder = (int) FunRunPeriod::where('event_id', $event->id)
            ->max('sort_order') + 1;

        $period = FunRunPeriod::create([
            'event_id' => $event->id,

            'name' => $validated['name'],
            'start_at' => $validated['start_at'],
            'end_at' => $validated['end_at'],

            'sort_order' => $nextSortOrder,

            // Baru dibuat, biar admin yang aktifkan manual
            // supaya tidak tumpang tindih sama periode berjalan.
            'is_active' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTO-BUAT BARIS HARGA/STOK PER KATEGORI
        |--------------------------------------------------------------------------
        |
        | Supaya periode baru langsung muncul di tabel "Stok Tiket"
        | tanpa admin harus bikin manual satu-satu per kategori.
        | Harga default 0, tinggal diedit admin lewat tabel Stok Tiket.
        */

        $categories = FunRunCategory::where('event_id', $event->id)->get();

        foreach ($categories as $category) {

            FunRunPrice::firstOrCreate(
                [
                    'period_id' => $period->id,
                    'category_id' => $category->id,
                ],
                [
                    'event_id' => $event->id,
                    'price' => 0,
                    'quota' => $category->quota,
                ]
            );
        }

        return back()->with(
            'success',
            "Periode \"{$validated['name']}\" berhasil ditambahkan. Jangan lupa aktifkan kalau sudah waktunya dipakai."
        );
    }

    /**
     * Update nama & nomor kontak person yang ditampilkan di
     * halaman awal Fun Run (di bawah tombol Daftar).
     */
    public function updateEventContact(Request $request, FunRunEvent $event)
    {
        $validated = $request->validate([
            'contact_person_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contact_person_phone' => [
                'nullable',
                'string',
                'max:30',
            ],
        ]);

        $event->update($validated);

        return back()->with(
            'success',
            'Kontak person berhasil diperbarui.'
        );
    }

    /**
     * Update jangka waktu pendaftaran dibuka (registration_start /
     * registration_end). Di luar jangka waktu ini, link pendaftaran
     * otomatis ditutup untuk publik.
     */
    public function toggleMaintenance(Request $request, FunRunEvent $event)
    {
        $validated = $request->validate([
            'action' => [
                'required',
                'in:start,stop',
            ],

            'hours' => [
                'required_if:action,start',
                'nullable',
                'integer',
                'min:1',
                'max:720',
            ],
        ]);

        if ($validated['action'] === 'start') {

            $hours = (int) $validated['hours'];

            $event->update([
                'is_maintenance' => true,
                'maintenance_until' => now()->addHours($hours),
            ]);

            return back()->with(
                'success',
                "Mode maintenance diaktifkan selama {$hours} jam (sampai " .
                    $event->maintenance_until->translatedFormat('d F Y, H:i') .
                    ').'
            );
        }

        $event->update([
            'is_maintenance' => false,
            'maintenance_until' => null,
        ]);

        return back()->with(
            'success',
            'Mode maintenance dinonaktifkan. Website kembali normal.'
        );
    }

    /**
     * Update informasi rekening pembayaran event.
     *
     * Sengaja dibuat lewat form admin (bukan ditulis langsung di
     * kode/blade) supaya cuma bisa diubah oleh admin yang sudah
     * login lewat panel resmi -- bukan lewat edit file.
     */
    public function updateEventBank(Request $request, FunRunEvent $event)
    {
        $validated = $request->validate([
            'bank_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'account_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'account_holder' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_name_2' => [
                'nullable',
                'string',
                'max:100',
            ],

            'account_number_2' => [
                'nullable',
                'string',
                'max:50',
            ],

            'account_holder_2' => [
                'nullable',
                'string',
                'max:255',
            ],

            'qris_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if ($request->hasFile('qris_image')) {

            if ($event->qris_image) {
                Storage::disk('public')->delete($event->qris_image);
            }

            $validated['qris_image'] = $request
                ->file('qris_image')
                ->store('fun-run/qris', 'public');
        }

        $event->update($validated);

        return back()->with(
            'success',
            'Informasi rekening pembayaran berhasil diperbarui.'
        );
    }

    /**
     * Aktif / nonaktifkan periode pendaftaran.
     *
     * Hanya boleh ada satu periode aktif dalam satu waktu untuk
     * satu event, supaya tidak ambigu periode mana yang dipakai
     * di halaman pendaftaran publik. Mengaktifkan satu periode akan
     * otomatis menonaktifkan periode lain pada event yang sama.
     */
    public function togglePeriod(FunRunPeriod $period)
    {
        $activating = !$period->is_active;

        if ($activating) {

            FunRunPeriod::where('event_id', $period->event_id)
                ->where('id', '!=', $period->id)
                ->update(['is_active' => false]);
        }

        $period->update([
            'is_active' => $activating,
        ]);

        return back()->with(
            'success',
            $activating
                ? "Periode \"{$period->name}\" diaktifkan. Periode lain otomatis dinonaktifkan."
                : "Periode \"{$period->name}\" dinonaktifkan."
        );
    }

    /**
     * Update nama & rentang tanggal periode.
     */
    public function updatePeriod(Request $request, FunRunPeriod $period)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'start_at' => [
                'required',
                'date',
            ],

            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
        ]);

        $period->update($validated);

        return back()->with(
            'success',
            "Periode \"{$period->name}\" berhasil diperbarui."
        );
    }

    /**
     * Update stok (kuota) tiket untuk satu kategori pada satu periode.
     */
    public function updateQuota(Request $request, FunRunPrice $price)
    {
        $validated = $request->validate([
            'quota' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $price->update([
            'quota' => $validated['quota'] ?? null,
        ]);

        return back()->with(
            'success',
            'Stok tiket berhasil diperbarui.'
        );
    }

    /**
     * Update harga tiket untuk satu kategori pada satu periode.
     */
    public function updatePrice(Request $request, FunRunPrice $price)
    {
        $validated = $request->validate([
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $price->update([
            'price' => $validated['price'],
        ]);

        return back()->with(
            'success',
            'Harga tiket berhasil diperbarui.'
        );
    }
}