<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FunRunPaymentVerifiedMail;
use App\Models\FunRunCategory;
use App\Models\FunRunEvent;
use App\Models\FunRunPayment;
use App\Models\FunRunPeriod;
use App\Models\FunRunPrice;
use App\Models\FunRunRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FunRunManualRegistrationController extends Controller
{
    /**
     * Form registrasi manual (Jalur Undangan / Jalur Spesial).
     */
    public function create()
    {
        $event = FunRunEvent::where('is_active', true)
            ->latest()
            ->first();

        if (!$event) {
            abort(404, 'Event Fun Run belum tersedia.');
        }

        $categories = FunRunCategory::where('event_id', $event->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STOK TIKET JALUR MANUAL
        |--------------------------------------------------------------------------
        |
        | Jalur Undangan & Jalur Spesial BERBAGI satu stok yang sama
        | per kategori (bukan dua stok terpisah).
        */

        $categories->each(function ($category) use ($event) {

            $price = $this->resolveManualPrice($event, $category);

            $category->manual_price_id = $price->id;
            $category->manual_quota = $price->quota;

            if ($price->quota === null) {
                $category->manual_remaining = null;
            } else {

                $used = FunRunRegistration::where('price_id', $price->id)
                    ->whereIn('status', ['waiting_verification', 'paid'])
                    ->count();

                $category->manual_remaining = max($price->quota - $used, 0);
            }
        });

        return view('admin.fun-run.manual.create', compact(
            'event',
            'categories'
        ));
    }

    /**
     * Ambil (atau buat) periode khusus buat jalur manual.
     *
     * Jalur Undangan & Jalur Spesial SENGAJA digabung jadi satu
     * periode ("Jalur Manual") supaya berbagi stok tiket yang sama
     * per kategori -- bukan dua stok terpisah. Periode ini dipisah
     * dari periode publik (Early Bird/Regular/dst) supaya stoknya
     * tidak kecampur dengan peserta yang daftar lewat form publik.
     * Periode ini selalu is_active=false, jadi tidak akan pernah
     * muncul/kepakai di halaman pendaftaran publik.
     */
    private function resolveManualPeriod(FunRunEvent $event): FunRunPeriod
    {
        return FunRunPeriod::firstOrCreate(
            [
                'event_id' => $event->id,
                'name' => 'Jalur Manual (Undangan & Spesial)',
            ],
            [
                'start_at' => now(),
                'end_at' => now()->addYears(10),
                'sort_order' => 9000,
                'is_active' => false,
            ]
        );
    }

    /**
     * Ambil (atau buat) baris harga/stok kategori pada periode
     * jalur manual di atas.
     */
    private function resolveManualPrice(FunRunEvent $event, FunRunCategory $category): FunRunPrice
    {
        $period = $this->resolveManualPeriod($event);

        return FunRunPrice::firstOrCreate(
            [
                'period_id' => $period->id,
                'category_id' => $category->id,
            ],
            [
                'event_id' => $event->id,
                'price' => 0,
                'quota' => null,
            ]
        );
    }

    /**
     * Cari kode registrasi berikutnya yang masih kosong buat jalur
     * manual -- Jalur Undangan & Jalur Spesial SENGAJA digabung jadi
     * satu kolam angka (bukan dipisah per channel, dan bukan ikut
     * rentang kategori publik), supaya urutannya nyambung terus
     * ("Undangan dapat 0100, Spesial berikutnya dapat 0101").
     */
    private function resolveNextRegistrationCode(int $codeMin, int $codeMax): ?string
    {
        $usedSuffixes = FunRunRegistration::whereIn('channel', ['invitation', 'backdoor'])
            ->pluck('registration_code')
            ->map(function ($code) {
                return (int) substr($code, -4);
            })
            ->all();

        for ($candidate = $codeMin; $candidate <= $codeMax; $candidate++) {

            if (!in_array($candidate, $usedSuffixes)) {

                return 'FR-' .
                    now()->format('Ymd') .
                    '-' .
                    str_pad(
                        (string) $candidate,
                        4,
                        '0',
                        STR_PAD_LEFT
                    );
            }
        }

        return null;
    }

    /**
     * Simpan registrasi manual.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'channel' => [
                'required',
                'in:invitation,backdoor',
            ],

            'category_id' => [
                'required',
                'integer',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'identity_number' => [
                'required',
                'digits:16',
            ],

            'shirt_size' => [
                'nullable',
                'in:S,M,L,XL,2XL,3XL',
            ],

            'medical_history' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'amount' => [
                'nullable',
                'numeric',
                'min:0',
                'required_if:channel,backdoor',
            ],

            'proof' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
                'required_if:channel,backdoor',
            ],
        ]);

        $event = FunRunEvent::where('is_active', true)
            ->latest()
            ->firstOrFail();

        $category = FunRunCategory::where('event_id', $event->id)
            ->findOrFail($validated['category_id']);

        $price = $this->resolveManualPrice($event, $category);

        /*
        |--------------------------------------------------------------------------
        | CEK STOK
        |--------------------------------------------------------------------------
        |
        | Stok dihitung gabungan Jalur Undangan + Jalur Spesial
        | (satu stok bersama per kategori), karena keduanya berbagi
        | $price yang sama.
        */

        if ($price->quota !== null) {

            $used = FunRunRegistration::where('price_id', $price->id)
                ->whereIn('status', ['waiting_verification', 'paid'])
                ->count();

            if ($used >= $price->quota) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Stok tiket jalur manual untuk kategori ini sudah habis.'
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | KODE REGISTRASI
        |--------------------------------------------------------------------------
        |
        | 4 digit terakhir dari rentang khusus 0100-0999, DIGABUNG
        | antara Jalur Undangan & Jalur Spesial jadi SATU urutan yang
        | sama (bukan dua urutan terpisah per channel, dan juga bukan
        | ikut rentang kategori publik yang 1000+/3000+). Rentang ini
        | dipakai lintas kategori (5K & 10K sama-sama ambil dari kolam
        | yang sama), supaya angkanya tetap nyambung apapun kategori
        | yang dipilih peserta berikutnya.
        |
        | Contoh: peserta 1 daftar Undangan -> 0100. Peserta 2 daftar
        | Spesial -> 0101 (lanjut, bukan mulai dari 0100 lagi). Kalau
        | peserta 2 (0101) nanti DITOLAK admin (datanya dihapus total),
        | nomor 0101 otomatis lepas dan langsung dipakai peserta
        | berikutnya -- entah dia daftar lewat Undangan atau Spesial.
        |
        | Rentang 100-999 ini tidak akan pernah bentrok dengan kode
        | peserta publik, karena kode publik selalu mulai dari 1000
        | ke atas (lihat code_min kategori).
        |
        */

        $codeMin = 100;
        $codeMax = 999;

        $isInvitation = $validated['channel'] === 'invitation';

        /*
        |--------------------------------------------------------------------------
        | HARGA
        |--------------------------------------------------------------------------
        |
        | Jalur Undangan selalu gratis. Jalur Spesial pakai nominal
        | yang diketik admin secara manual.
        |
        */

        $amount = $isInvitation
            ? 0
            : (float) $validated['amount'];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN REGISTRASI (DENGAN RETRY)
        |--------------------------------------------------------------------------
        |
        | Jalur Undangan -> langsung LUNAS (gratis, tidak ada bukti
        | transfer yang perlu dicek admin).
        | Jalur Spesial -> MENUNGGU VERIFIKASI, sama seperti peserta
        | publik. Admin tetap harus klik "Verifikasi" di halaman
        | detail peserta setelah mengecek bukti transfernya.
        |
        | Dibungkus retry (maks 3x) jaga-jaga kalau ada 2 submit
        | barengan di detik yang sama dan sempat lolos cek awal
        | (race condition) -- kalau tetap bentrok pas nyimpan,
        | otomatis coba lagi dengan nomor berikutnya.
        */

        $registration = null;

        for ($attempt = 0; $attempt < 3; $attempt++) {

            $registrationCode = $this->resolveNextRegistrationCode(
                $codeMin,
                $codeMax
            );

            if (!$registrationCode) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Kuota kode registrasi kategori ini sudah habis, silakan hubungi panitia.'
                    );
            }

            try {

                $registration = FunRunRegistration::create([

                    'event_id' => $event->id,
                    'category_id' => $category->id,
                    'price_id' => $price->id,

                    'registration_code' => $registrationCode,

                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'email_verified_at' => now(),

                    'phone' => $validated['phone'],
                    'identity_number' => $validated['identity_number'],

                    'shirt_size' => $validated['shirt_size'] ?? null,
                    'medical_history' => $validated['medical_history'] ?? null,

                    'amount' => $amount,
                    'unique_code' => null,

                    'status' => $isInvitation ? 'paid' : 'waiting_verification',
                    'channel' => $validated['channel'],

                    'payment_token_hash' =>
                        hash('sha256', Str::random(40)),

                    'payment_link_sent_at' => now(),
                ]);

                break;

            } catch (\Illuminate\Database\QueryException $e) {

                // 23000 = duplicate entry (unique constraint).
                // Coba lagi dengan nomor berikutnya kalau masih
                // ada percobaan tersisa, kalau tidak lempar ulang.
                if ($e->getCode() !== '23000' || $attempt === 2) {
                    throw $e;
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BUKTI PEMBAYARAN (JALUR SPESIAL)
        |--------------------------------------------------------------------------
        */

        $proofPath = null;

        if (!$isInvitation && $request->hasFile('proof')) {

            $proofPath = $request
                ->file('proof')
                ->store(
                    'fun-run/payment-proofs',
                    'public'
                );
        }

        FunRunPayment::create([

            'registration_id' => $registration->id,

            'payment_reference' =>
                'MANUAL-' .
                strtoupper($validated['channel']) .
                '-' .
                $registration->registration_code,

            'amount' => $amount,

            'transfer_date' => now()->toDateString(),
            'transfer_amount' => $amount,

            'proof' => $proofPath,

            'submitted_at' => now(),

            'status' => $isInvitation ? 'verified' : 'submitted',
            'verified_by' => $isInvitation ? auth()->id() : null,
            'verified_at' => $isInvitation ? now() : null,
            'paid_at' => $isInvitation ? now() : null,

            'admin_note' => $isInvitation
                ? 'Didaftarkan manual oleh admin — Jalur Undangan (gratis).'
                : 'Diajukan manual oleh admin — Jalur Spesial, menunggu verifikasi.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | KIRIM EMAIL KONFIRMASI
        |--------------------------------------------------------------------------
        |
        | Cuma dikirim buat Jalur Undangan (sudah pasti lunas). Jalur
        | Spesial belum dikirimi email di sini -- nanti email
        | "Pembayaran Terverifikasi" otomatis terkirim begitu admin
        | klik tombol Verifikasi di halaman detail peserta (lihat
        | Admin\FunRunController::verify()).
        */

        if ($isInvitation) {

            Mail::to($registration->email)
                ->send(
                    new FunRunPaymentVerifiedMail(
                        $registration
                    )
                );
        }

        return redirect()
            ->route(
                'admin.fun-run.registrations.show',
                $registration
            )
            ->with(
                'success',
                $isInvitation
                    ? "Peserta \"{$registration->name}\" berhasil didaftarkan (Jalur Undangan) dengan kode {$registration->registration_code}. Email konfirmasi sudah dikirim ke {$registration->email}."
                    : "Peserta \"{$registration->name}\" berhasil diajukan (Jalur Spesial) dengan kode {$registration->registration_code}. Silakan cek bukti transfernya dan klik Verifikasi untuk menyelesaikan."
            );
    }
}