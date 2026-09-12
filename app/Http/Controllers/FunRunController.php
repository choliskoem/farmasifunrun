<?php

namespace App\Http\Controllers;

use App\Models\FunRunEvent;
use App\Models\FunRunPeriod;
use App\Models\FunRunRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FunRunController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LANDING PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $event = FunRunEvent::with([
            'categories',
            'periods',
            'prices.category',
            'prices.period',
        ])
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$event) {
            abort(404, 'Event Fun Run belum tersedia.');
        }

        $activePeriod = FunRunPeriod::where('event_id', $event->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->first();

        $registrationOpen = $this->isRegistrationOpen($event);

        return view('fun-run.index', compact(
            'event',
            'activePeriod',
            'registrationOpen'
        ));
    }

    /**
     * Cek apakah pendaftaran sedang dibuka berdasarkan jangka waktu
     * yang diatur admin (registration_start / registration_end).
     * Kalau salah satu atau keduanya kosong, dianggap tidak dibatasi
     * pada sisi itu.
     */
    private function isRegistrationOpen(FunRunEvent $event): bool
    {
        if (!$event->is_maintenance) {
            return true;
        }

        // Maintenance diaktifkan, tapi durasinya sudah lewat -> anggap
        // sudah selesai otomatis, tidak perlu admin matikan manual.
        if ($event->maintenance_until && now()->gte($event->maintenance_until)) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | FORM REGISTRASI
    |--------------------------------------------------------------------------
    */

    public function register()
{
    $email = session('fun_run_registration_email');

    if (!$email) {
        return redirect()
            ->route('fun-run.register.email')
            ->with(
                'error',
                'Silakan masukkan email terlebih dahulu.'
            );
    }

    $event = FunRunEvent::with([
        'categories' => function ($query) {
            $query->where('is_active', true);
        },
    ])
        ->where('is_active', true)
        ->latest()
        ->first();

    if (!$event) {
        abort(404, 'Event Fun Run belum tersedia.');
    }

    if (!$this->isRegistrationOpen($event)) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Website sedang dalam mode maintenance, silakan coba lagi nanti.'
            );
    }

    $activePeriod = FunRunPeriod::where('event_id', $event->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->first();

    if (!$activePeriod) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Pendaftaran Fun Run sedang tidak dibuka.'
            );
    }

    $prices = $activePeriod->prices()
        ->with('category')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | STOK TIKET
    |--------------------------------------------------------------------------
    |
    | Kategori yang stoknya sudah habis disaring dari pilihan supaya
    | peserta tidak bisa memilihnya, tapi angka sisa stok TIDAK
    | ditampilkan di halaman pendaftaran.
    |
    */

    $prices = $prices->filter(function ($price) {

        if ($price->quota === null) {
            return true;
        }

        $used = FunRunRegistration::where('price_id', $price->id)
            ->whereIn('status', [
                'waiting_payment',
                'waiting_verification',
                'paid',
            ])
            ->count();

        return $used < $price->quota;

    })->values();

    return view('fun-run.register', compact(
        'event',
        'activePeriod',
        'prices',
        'email'
    ));
}

    /*
    |--------------------------------------------------------------------------
    | SIMPAN REGISTRASI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
{
    $email = session('fun_run_registration_email');

    if (!$email) {
        return redirect()
            ->route('fun-run.register.email')
            ->with(
                'error',
                'Silakan masukkan email terlebih dahulu.'
            );
    }

    $event = FunRunEvent::where('is_active', true)
        ->latest()
        ->firstOrFail();

    if (!$this->isRegistrationOpen($event)) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Website sedang dalam mode maintenance, silakan coba lagi nanti.'
            );
    }

    $activePeriod = FunRunPeriod::where('event_id', $event->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->first();

    if (!$activePeriod) {
        return back()
            ->withInput()
            ->with(
                'error',
                'Periode pendaftaran sudah ditutup.'
            );
    }

    $validated = $request->validate([
        'category_id' => [
            'required',
            'integer',
        ],

        'name' => [
            'required',
            'string',
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

        'gender' => [
            'required',
            'in:L,P',
        ],

        'birth_date' => [
            'required',
            'date',
        ],

        'address' => [
            'required',
            'string',
        ],

        'shirt_size' => [
            'required',
            'in:S,M,L,XL,2XL,3XL',
        ],

        'medical_history' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'emergency_contact_phone' => [
            'required',
            'string',
            'max:30',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | VALIDASI KATEGORI
    |--------------------------------------------------------------------------
    */

    $category = $event->categories()
        ->where('id', $validated['category_id'])
        ->where('is_active', true)
        ->first();

    if (!$category) {
        return back()
            ->withInput()
            ->with(
                'error',
                'Kategori Fun Run tidak valid.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL HARGA
    |--------------------------------------------------------------------------
    */

    $price = $activePeriod->prices()
        ->where('category_id', $category->id)
        ->first();

    if (!$price) {
        return back()
            ->withInput()
            ->with(
                'error',
                'Harga kategori belum tersedia.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK KUOTA
    |--------------------------------------------------------------------------
    */

    if ($price->quota !== null) {

        $registered = FunRunRegistration::where(
            'price_id',
            $price->id
        )
            ->whereIn('status', [
                'waiting_payment',
                'waiting_verification',
                'paid',
            ])
            ->count();

        if ($registered >= $price->quota) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kuota kategori ini sudah penuh.'
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | KODE REGISTRASI
    |--------------------------------------------------------------------------
    |
    | 4 digit terakhir per kategori, dimulai dari code_min kategori
    | tersebut (mis. kategori 5K -> 1000-2999, kategori 10K ->
    | 3000-3999). Kalau kategori belum diatur rentangnya, pakai
    | default 1000-9999.
    |
    | PENTING: dicari angka TERKECIL yang belum dipakai oleh data
    | registrasi yang MASIH ADA di database (bukan berdasarkan
    | status). Jadi:
    | - Peserta yang sudah lunas -> nomornya TERKUNCI PERMANEN,
    |   tidak akan pernah dipakai ulang selama datanya masih ada.
    | - Peserta yang DITOLAK admin -> datanya dihapus total, jadi
    |   nomornya otomatis lepas dan bisa dipakai peserta berikutnya.
    |
    */

    $codeMin = $category->code_min ?? 1000;
    $codeMax = $category->code_max ?? 9999;

    $usedSuffixes = FunRunRegistration::where('category_id', $category->id)
        ->pluck('registration_code')
        ->map(function ($code) {
            return (int) substr($code, -4);
        })
        ->all();

    $nextSuffix = null;

    for ($candidate = $codeMin; $candidate <= $codeMax; $candidate++) {

        if (!in_array($candidate, $usedSuffixes)) {
            $nextSuffix = $candidate;
            break;
        }
    }

    if ($nextSuffix === null) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Kuota kode registrasi kategori ini sudah habis, silakan hubungi panitia.'
            );
    }

    $registrationCode =
        'FR-' .
        now()->format('Ymd') .
        '-' .
        str_pad(
            (string) $nextSuffix,
            4,
            '0',
            STR_PAD_LEFT
        );

    /*
    |--------------------------------------------------------------------------
    | KODE UNIK PEMBAYARAN (100-500)
    |--------------------------------------------------------------------------
    |
    | Dicari angka terkecil yang belum dipakai HARI INI untuk harga
    | (kategori+periode) ini -- otomatis reset tiap hari, jadi tiap
    | hari mulai lagi dari 100 (maksimal 500 pendaftar/hari per
    | kategori+periode). Ini aman karena admin mencocokkan mutasi
    | rekening per hari, jadi kode yang sama boleh dipakai ulang di
    | hari yang berbeda.
    |
    | - Peserta yang sudah lunas hari ini -> kode uniknya terkunci
    |   sampai hari itu berakhir.
    | - Peserta yang ditolak admin -> datanya dihapus, kodenya lepas
    |   lagi (walau masih hari yang sama).
    |
    */

    $usedCodes = FunRunRegistration::where('price_id', $price->id)
        ->whereDate('created_at', now()->toDateString())
        ->whereNotNull('unique_code')
        ->pluck('unique_code')
        ->all();

    $uniqueCode = null;

    for ($candidate = 100; $candidate <= 500; $candidate++) {

        if (!in_array($candidate, $usedCodes)) {
            $uniqueCode = $candidate;
            break;
        }
    }

    if ($uniqueCode === null) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Kuota kode unik pembayaran untuk kategori ini hari ini sudah penuh (maks 500/hari), silakan coba lagi besok atau hubungi panitia.'
            );
    }

    $amount = $price->price + $uniqueCode;

    /*
    |--------------------------------------------------------------------------
    | TOKEN PEMBAYARAN
    |--------------------------------------------------------------------------
    |
    | Tidak perlu menunggu verifikasi admin. Token dibuat langsung
    | supaya peserta bisa langsung diarahkan ke halaman pembayaran.
    |
    */

    $paymentToken = Str::random(40);

    /*
    |--------------------------------------------------------------------------
    | SIMPAN REGISTRASI
    |--------------------------------------------------------------------------
    */

    $registration = FunRunRegistration::create([

        'event_id' => $event->id,

        'category_id' => $category->id,

        'price_id' => $price->id,

        'registration_code' => $registrationCode,

        'name' => $validated['name'],

        'email' => $email,

        'phone' => $validated['phone'],

        'identity_number' =>
            $validated['identity_number'],

        'gender' =>
            $validated['gender'],

        'birth_date' =>
            $validated['birth_date'],

        'address' =>
            $validated['address'],

        'shirt_size' =>
            $validated['shirt_size'],

        'medical_history' =>
            $validated['medical_history'] ?? null,

        'emergency_contact_phone' =>
            $validated['emergency_contact_phone'],

        'amount' =>
            $amount,

        'unique_code' =>
            $uniqueCode,

        /*
        |--------------------------------------------------------------------------
        | LANGSUNG AKTIF, TANPA VERIFIKASI ADMIN
        |--------------------------------------------------------------------------
        */

        'status' => 'waiting_payment',

        'email_verified_at' => now(),

        'payment_token_hash' => hash('sha256', $paymentToken),

        'payment_link_sent_at' => now(),
    ]);

    /*
    |--------------------------------------------------------------------------
    | HAPUS SESSION EMAIL
    |--------------------------------------------------------------------------
    */

    session()->forget([
        'fun_run_registration_email',
        'fun_run_event_id',
        'fun_run_period_id',
    ]);

    /*
    |--------------------------------------------------------------------------
    | LANGSUNG KE HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    return redirect()->route(
        'fun-run.payment',
        $paymentToken
    );
}

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

   public function payment(string $token)
{
    $tokenHash = hash(
        'sha256',
        $token
    );

    $registration = FunRunRegistration::with([
        'event',
        'category',
        'price.period',
        'latestPayment',
    ])
        ->where(
            'payment_token_hash',
            $tokenHash
        )
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | LINK SUDAH MATI
    |--------------------------------------------------------------------------
    */

    if ($registration->status === 'paid') {

        abort(
            403,
            'Link pembayaran sudah tidak aktif karena pembayaran telah diverifikasi.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EMAIL BELUM DIVERIFIKASI ADMIN
    |--------------------------------------------------------------------------
    */

    if (!$registration->email_verified_at) {

        abort(
            403,
            'Link pembayaran belum diaktifkan oleh admin.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUDAH SUBMIT PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    if ($registration->status === 'waiting_verification') {

        return view(
            'fun-run.payment-status',
            compact('registration')
        );
    }

    return view(
        'fun-run.payment',
        compact('registration')
    );
}

    /*
    |--------------------------------------------------------------------------
    | SUBMIT BUKTI TRANSFER
    |--------------------------------------------------------------------------
    */

   public function submitPayment(
    Request $request,
    string $token
) {
    $tokenHash = hash(
        'sha256',
        $token
    );

    $registration = FunRunRegistration::with(
        'latestPayment'
    )
        ->where(
            'payment_token_hash',
            $tokenHash
        )
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | LINK SUDAH MATI
    |--------------------------------------------------------------------------
    */

    if ($registration->status === 'paid') {

        abort(
            403,
            'Link pembayaran sudah tidak aktif.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BELUM DIVERIFIKASI ADMIN
    |--------------------------------------------------------------------------
    */

    if (!$registration->email_verified_at) {

        abort(
            403,
            'Link pembayaran belum diaktifkan.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUDAH MENUNGGU VERIFIKASI
    |--------------------------------------------------------------------------
    */

    if (
        $registration->status ===
        'waiting_verification'
    ) {

        return redirect()->route(
            'fun-run.payment.status',
            $token
        )->with(
            'error',
            'Bukti pembayaran Anda sedang menunggu verifikasi admin.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    $validated = $request->validate([
        'transfer_date' => [
            'required',
            'date',
            'before_or_equal:today',
        ],

        'transfer_amount' => [
            'required',
            'numeric',
            'min:1',
            'in:' . $registration->amount,
        ],

        'proof' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ],
    ]);

    DB::transaction(function () use (
        $request,
        $validated,
        $registration
    ) {

        $payment = $registration
            ->payments()
            ->where('status', 'rejected')
            ->latest()
            ->first();

        if ($payment && $payment->proof) {

            Storage::disk('public')->delete(
                $payment->proof
            );
        }

        if (!$payment) {

            $payment = $registration
                ->payments()
                ->create([

                    'payment_reference' =>
                        'PAY-' .
                        now()->format('YmdHis') .
                        '-' .
                        strtoupper(
                            Str::random(6)
                        ),

                    'amount' =>
                        $registration->amount,

                    'payment_method' =>
                        'manual',

                    'payment_channel' =>
                        'bank_transfer',

                    'status' =>
                        'submitted',
                ]);
        }

        $proofPath = $request
            ->file('proof')
            ->store(
                'fun-run/payment-proofs',
                'public'
            );

        $payment->update([

            'transfer_date' =>
                $validated['transfer_date'],

            'transfer_amount' =>
                $validated['transfer_amount'],

            'proof' =>
                $proofPath,

            'submitted_at' =>
                now(),

            'status' =>
                'submitted',

            'admin_note' =>
                null,

            'verified_by' =>
                null,

            'verified_at' =>
                null,

            'paid_at' =>
                null,
        ]);

        $registration->update([
            'status' =>
                'waiting_verification',
        ]);
    });

    return redirect()->route(
        'fun-run.payment.status',
        $token
    )->with(
        'success',
        'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | STATUS PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    public function paymentStatus(string $token)
{
    $tokenHash = hash(
        'sha256',
        $token
    );

    $registration = FunRunRegistration::with([
        'event',
        'category',
        'price.period',
        'latestPayment',
    ])
        ->where(
            'payment_token_hash',
            $tokenHash
        )
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | SUDAH LUNAS -> LANGSUNG KE HALAMAN SUKSES
    |--------------------------------------------------------------------------
    |
    | Kalau peserta refresh/buka lagi halaman status setelah admin
    | memverifikasi pembayarannya, jangan tunjukkan halaman "menunggu
    | verifikasi" yang sudah tidak relevan lagi.
    |
    */

    if ($registration->status === 'paid') {

        return redirect()->route(
            'fun-run.success',
            $registration->registration_code
        );
    }

    return view(
        'fun-run.payment-status',
        compact('registration')
    );
}

    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    public function success(string $registrationCode)
    {
        $registration = FunRunRegistration::with([
            'event',
            'category',
            'price.period',
            'payments',
        ])
            ->where('registration_code', $registrationCode)
            ->firstOrFail();

        if ($registration->status !== 'paid') {

            return redirect()
                ->route('fun-run.index')
                ->with(
                    'error',
                    'Registrasi ini belum lunas. Masukkan email Anda lagi untuk melanjutkan ke halaman pembayaran.'
                );
        }

        return view(
            'fun-run.success',
            compact('registration')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD TIKET (GAMBAR PNG)
    |--------------------------------------------------------------------------
    |
    | Dipakai baik dari tombol di admin maupun dari link di email
    | konfirmasi -- jaga-jaga kalau email peserta tidak pernah sampai
    | (masuk spam, salah ketik, dll), admin tetap bisa ambilkan
    | tiketnya lewat panel admin.
    |
    | Dibuat pakai GD (bawaan PHP, tidak perlu composer install apapun)
    | supaya tidak tergantung package eksternal seperti DomPDF.
    */

    public function downloadTicket(string $registrationCode)
    {
        $registration = FunRunRegistration::with([
            'event',
            'category',
            'price.period',
        ])
            ->where('registration_code', $registrationCode)
            ->firstOrFail();

        if ($registration->status !== 'paid') {

            return redirect()
                ->route('fun-run.index')
                ->with(
                    'error',
                    'Tiket hanya bisa diunduh setelah pembayaran lunas.'
                );
        }

        $imageData = $this->renderTicketImage($registration);

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header(
                'Content-Disposition',
                'attachment; filename="Tiket-' . $registration->registration_code . '.png"'
            );
    }

    /**
     * Gambar kartu tiket sebagai PNG pakai GD, termasuk QR code
     * verifikasi keaslian tiket.
     */
    /**
     * Gambar kartu tiket sebagai PNG pakai GD, termasuk QR code
     * verifikasi keaslian tiket.
     */
    private function renderTicketImage(FunRunRegistration $registration): string
    {
        $width = 1100;
        $height = 520;
        $sidebarWidth = 360;

        $image = imagecreatetruecolor($width, $height);

        // Palet warna (samakan dengan tema Race Day di web).
        $bg = imagecolorallocate($image, 11, 17, 32);        // #0B1120
        $darkGreen = imagecolorallocate($image, 4, 32, 24);  // teks di atas hijau
        $white = imagecolorallocate($image, 255, 255, 255);
        $gray = imagecolorallocate($image, 148, 163, 184);
        $lightGray = imagecolorallocate($image, 203, 213, 225);
        $line = imagecolorallocate($image, 30, 41, 59);
        $amber = imagecolorallocate($image, 245, 158, 11);

        imagefill($image, 0, 0, $bg);

        /*
        |--------------------------------------------------------------------------
        | SISI KIRI -- SIDEBAR GRADASI HIJAU + BIB NUMBER
        |--------------------------------------------------------------------------
        */

        $topColor = [52, 211, 153];    // emerald muda
        $bottomColor = [4, 120, 87];   // emerald tua

        for ($y = 0; $y < $height; $y++) {

            $ratio = $y / $height;

            $r = (int) ($topColor[0] + ($bottomColor[0] - $topColor[0]) * $ratio);
            $g = (int) ($topColor[1] + ($bottomColor[1] - $topColor[1]) * $ratio);
            $b = (int) ($topColor[2] + ($bottomColor[2] - $topColor[2]) * $ratio);

            imageline($image, 0, $y, $sidebarWidth, $y, imagecolorallocate($image, $r, $g, $b));
        }

        $darkGreenRgb = [4, 32, 24];
        $whiteRgb = [255, 255, 255];

        // "BIB NUMBER" label, diperbesar dikit biar nggak kalah sama nomornya.
        $this->drawScaledText(
            $image, 3, 36, 30, 'BIB NUMBER', $darkGreenRgb,
            $this->gradientColorAt(30, $height, $topColor, $bottomColor), 1.4
        );

        // Nomor bib, dispasi lebar (tracked) + diperbesar biar jelas
        // dibaca -- skalanya dihitung otomatis biar nggak pernah
        // kepanjangan sampai nabrak garis perforasi, apapun panjang
        // kode registrasinya.
        $bibTracking = 2;
        $bibAvailableWidth = $sidebarWidth - 36 - 24;
        $bibBaseWidth = strlen($registration->registration_code) * (imagefontwidth(5) + $bibTracking);
        $bibScale = min(1.5, $bibAvailableWidth / $bibBaseWidth);

        $this->drawTrackedTextScaled(
            $image, 5, 36, 58, $registration->registration_code, $darkGreenRgb,
            $this->gradientColorAt(58, $height, $topColor, $bottomColor), $bibTracking, $bibScale
        );

        /*
        |--------------------------------------------------------------------------
        | BADGE KATEGORI -- DIPERBESAR HAMPIR SELEBAR SIDEBAR
        |--------------------------------------------------------------------------
        */

        $pillX1 = 36;
        $pillX2 = $sidebarWidth - 36;
        $pillY1 = 124;
        $pillY2 = 214;

        $this->drawPill($image, $pillX1, $pillY1, $pillX2, $pillY2, $darkGreen);

        $categoryText = $registration->category->name;
        $categoryScale = 4.2;

        [$catW, $catH] = $this->drawScaledText(
            $image, 5, 0, 0, $categoryText, $whiteRgb, $darkGreenRgb, $categoryScale, true
        );

        $this->drawScaledText(
            $image,
            5,
            (int) ($pillX1 + (($pillX2 - $pillX1) - $catW) / 2),
            (int) ($pillY1 + (($pillY2 - $pillY1) - $catH) / 2),
            $categoryText,
            $whiteRgb,
            $darkGreenRgb,
            $categoryScale
        );

        $footerY1 = $height - 54;
        $footerY2 = $height - 30;

        $this->drawScaledText(
            $image, 2, 36, $footerY1, 'FARMASI RACE DAY', $darkGreenRgb,
            $this->gradientColorAt($footerY1, $height, $topColor, $bottomColor), 1.3
        );

        $this->drawScaledText(
            $image, 1, 36, $footerY2, 'farmasi.official', $darkGreenRgb,
            $this->gradientColorAt($footerY2, $height, $topColor, $bottomColor), 1.2
        );

        /*
        |--------------------------------------------------------------------------
        | LUBANG SOBEKAN (PERFORASI) ANTARA SIDEBAR & KONTEN
        |--------------------------------------------------------------------------
        */

        for ($y = 24; $y < $height; $y += 36) {
            imagefilledellipse($image, $sidebarWidth, $y, 22, 22, $bg);
        }

        /*
        |--------------------------------------------------------------------------
        | SISI KANAN -- DETAIL PESERTA
        |--------------------------------------------------------------------------
        */

        $contentX = $sidebarWidth + 44;

        imagestring($image, 3, $contentX, 34, strtoupper($registration->event->name), $amber);
        imagestring($image, 5, $contentX, 56, $registration->name, $white);

        $rows = [
            ['Periode', $registration->price->period->name],
            ['Ukuran Baju', $registration->shirt_size ?: '-'],
            ['Status', 'LUNAS'],
        ];

        $rowY = 118;
        $rowsRightEdge = $contentX + 420;

        foreach ($rows as [$label, $value]) {

            imageline($image, $contentX, $rowY + 16, $rowsRightEdge, $rowY + 16, $line);

            imagestring($image, 3, $contentX, $rowY, $label, $gray);

            $valueWidth = imagefontwidth(3) * strlen($value);
            imagestring($image, 3, $rowsRightEdge - $valueWidth, $rowY, $value, $lightGray);

            $rowY += 40;
        }

        /*
        |--------------------------------------------------------------------------
        | QR CODE VERIFIKASI (POJOK KANAN BAWAH)
        |--------------------------------------------------------------------------
        */

        $qrSize = 168;
        $qrX = $width - $qrSize - 50;
        $qrY = $height - $qrSize - 44;

        $verifyUrl = route('fun-run.verify', $registration->registration_code)
            . '?sig=' . $this->ticketSignature($registration);

        $qrRaw = @file_get_contents(
            'https://api.qrserver.com/v1/create-qr-code/?size=' .
            $qrSize . 'x' . $qrSize .
            '&margin=8&data=' . urlencode($verifyUrl)
        );

        if ($qrRaw !== false) {

            $qrImage = @imagecreatefromstring($qrRaw);

            if ($qrImage !== false) {

                imagefilledrectangle(
                    $image,
                    $qrX - 12,
                    $qrY - 12,
                    $qrX + $qrSize + 12,
                    $qrY + $qrSize + 12,
                    $white
                );

                imagecopy($image, $qrImage, $qrX, $qrY, 0, 0, $qrSize, $qrSize);
                imagedestroy($qrImage);

                imagestring(
                    $image,
                    2,
                    $qrX - 12,
                    $qrY - 34,
                    'SCAN UNTUK VERIFIKASI',
                    $gray
                );
            }
        }

        imagestring(
            $image,
            2,
            $contentX,
            $qrY + 30,
            'Tunjukkan tiket ini (cetak atau',
            $gray
        );
        imagestring(
            $image,
            2,
            $contentX,
            $qrY + 46,
            'digital) saat pengambilan race pack.',
            $gray
        );

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return $imageData;
    }

    /**
     * Hitung warna gradasi sidebar pada posisi Y tertentu -- dipakai
     * supaya teks yang di-scale-up (lihat drawScaledText) punya
     * warna latar belakang sementara yang mendekati warna gradasi
     * asli di baris itu, jadi tidak kelihatan ada kotak solid yang
     * nyembul pas ditempel ke gambar utama.
     */
    private function gradientColorAt(int $y, int $height, array $topColor, array $bottomColor): array
    {
        $ratio = max(0, min(1, $y / $height));

        return [
            (int) ($topColor[0] + ($bottomColor[0] - $topColor[0]) * $ratio),
            (int) ($topColor[1] + ($bottomColor[1] - $topColor[1]) * $ratio),
            (int) ($topColor[2] + ($bottomColor[2] - $topColor[2]) * $ratio),
        ];
    }

    /**
     * Gambar teks bitmap GD dalam ukuran yang DIPERBESAR (di-scale
     * naik beberapa kali dari ukuran font aslinya), supaya lebih
     * jelas/tidak kekecilan -- font bawaan GD (imagestring) cuma
     * punya 5 ukuran tetap yang semuanya kecil, jadi ini akal-akalan
     * bikin versinya lebih besar tanpa perlu file font .ttf.
     *
     * Kalau $returnOnly true, tidak digambar ke $image (cuma dipakai
     * untuk menghitung lebar/tinggi hasil scale, misalnya buat
     * menengahkan teks di dalam badge sebelum benar-benar digambar).
     */
    private function drawScaledText($image, int $font, int $x, int $y, string $text, array $colorRgb, array $bgRgb, float $scale, bool $returnOnly = false): array
    {
        $charWidth = imagefontwidth($font);
        $charHeight = imagefontheight($font);
        $textWidth = max($charWidth * strlen($text), 1);

        $scaledWidth = (int) round($textWidth * $scale);
        $scaledHeight = (int) round($charHeight * $scale);

        if ($returnOnly) {
            return [$scaledWidth, $scaledHeight];
        }

        $temp = imagecreatetruecolor($textWidth, $charHeight);
        $tempBg = imagecolorallocate($temp, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $tempColor = imagecolorallocate($temp, $colorRgb[0], $colorRgb[1], $colorRgb[2]);
        imagefill($temp, 0, 0, $tempBg);
        imagestring($temp, $font, 0, 0, $text, $tempColor);

        imagecopyresized($image, $temp, $x, $y, 0, 0, $scaledWidth, $scaledHeight, $textWidth, $charHeight);
        imagedestroy($temp);

        return [$scaledWidth, $scaledHeight];
    }

    /**
     * Sama seperti drawScaledText(), tapi hurufnya dikasih spasi
     * antar-karakter lebih lebar dulu (efek "tracked" ala nomor bib
     * lari) sebelum di-scale naik.
     */
    private function drawTrackedTextScaled($image, int $font, int $x, int $y, string $text, array $colorRgb, array $bgRgb, int $tracking, float $scale): array
    {
        $charWidth = imagefontwidth($font);
        $charHeight = imagefontheight($font);
        $textWidth = max((strlen($text) * ($charWidth + $tracking)), 1);

        $temp = imagecreatetruecolor($textWidth, $charHeight);
        $tempBg = imagecolorallocate($temp, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $tempColor = imagecolorallocate($temp, $colorRgb[0], $colorRgb[1], $colorRgb[2]);
        imagefill($temp, 0, 0, $tempBg);

        for ($i = 0; $i < strlen($text); $i++) {
            imagechar($temp, $font, $i * ($charWidth + $tracking), 0, $text[$i], $tempColor);
        }

        $scaledWidth = (int) round($textWidth * $scale);
        $scaledHeight = (int) round($charHeight * $scale);

        imagecopyresized($image, $temp, $x, $y, 0, 0, $scaledWidth, $scaledHeight, $textWidth, $charHeight);
        imagedestroy($temp);

        return [$scaledWidth, $scaledHeight];
    }

    /**
     * Gambar badge berbentuk pil (rounded pill) sederhana pakai
     * kombinasi persegi panjang + lingkaran di kedua ujungnya.
     */
    private function drawPill($image, int $x1, int $y1, int $x2, int $y2, int $color): void
    {
        $radius = $y2 - $y1;

        imagefilledrectangle($image, (int) ($x1 + $radius / 2), $y1, (int) ($x2 - $radius / 2), $y2, $color);
        imagefilledellipse($image, (int) ($x1 + $radius / 2), (int) (($y1 + $y2) / 2), $radius, $radius, $color);
        imagefilledellipse($image, (int) ($x2 - $radius / 2), (int) (($y1 + $y2) / 2), $radius, $radius, $color);
    }

    /**
     * Tanda tangan (signature) tiket, dipakai untuk memastikan QR
     * code di tiket benar-benar diterbitkan oleh sistem ini, bukan
     * hasil rekayasa/tebakan kode registrasi.
     */
    private function ticketSignature(FunRunRegistration $registration): string
    {
        return substr(
            hash_hmac(
                'sha256',
                $registration->id . '|' . $registration->registration_code,
                config('app.key')
            ),
            0,
            16
        );
    }

    /**
     * Halaman hasil scan QR tiket -- menunjukkan apakah tiket ini
     * asli/valid atau tidak.
     */
    public function verifyTicket(Request $request, string $registrationCode)
    {
        $registration = FunRunRegistration::with([
            'event',
            'category',
        ])
            ->where('registration_code', $registrationCode)
            ->first();

        $valid = false;

        if ($registration && $registration->status === 'paid') {

            $expectedSignature = $this->ticketSignature($registration);

            $valid = hash_equals(
                $expectedSignature,
                (string) $request->query('sig')
            );
        }

        return view(
            'fun-run.ticket-verify',
            compact('registration', 'valid')
        );
    }


    /*
|--------------------------------------------------------------------------
| HALAMAN EMAIL REGISTRASI
|--------------------------------------------------------------------------
*/

public function registerEmail()
{
    $event = FunRunEvent::where('is_active', true)
        ->latest()
        ->first();

    if (!$event) {
        abort(404, 'Event Fun Run belum tersedia.');
    }

    if (!$this->isRegistrationOpen($event)) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Website sedang dalam mode maintenance, silakan coba lagi nanti.'
            );
    }

    $activePeriod = FunRunPeriod::where('event_id', $event->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->first();

    if (!$activePeriod) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Pendaftaran Fun Run sedang tidak dibuka.'
            );
    }

    return view('fun-run.register-email', compact(
        'event',
        'activePeriod'
    ));
}

/*
|--------------------------------------------------------------------------
| SIMPAN EMAIL REGISTRASI
|--------------------------------------------------------------------------
*/

public function continueRegister(Request $request)
{
    $validated = $request->validate([
        'email' => [
            'required',
            'email',
            'max:255',
        ],
    ]);

    $event = FunRunEvent::where('is_active', true)
        ->latest()
        ->firstOrFail();

    if (!$this->isRegistrationOpen($event)) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Website sedang dalam mode maintenance, silakan coba lagi nanti.'
            );
    }

    $activePeriod = FunRunPeriod::where('event_id', $event->id)
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->first();

    if (!$activePeriod) {
        return redirect()
            ->route('fun-run.index')
            ->with(
                'error',
                'Pendaftaran Fun Run sedang tidak dibuka.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK EMAIL SUDAH TERDAFTAR
    |--------------------------------------------------------------------------
    |
    | Email yang masih dalam proses (menunggu verifikasi admin,
    | menunggu pembayaran, atau sudah lunas) tidak boleh dipakai
    | mendaftar lagi. Kalau registrasi sebelumnya ditolak (rejected),
    | email boleh dipakai daftar ulang.
    |
    */

    $existing = FunRunRegistration::where('event_id', $event->id)
        ->where('email', $validated['email'])
        ->whereIn('status', [
            'waiting_verification',
            'waiting_payment',
            'paid',
        ])
        ->latest()
        ->first();

    if ($existing) {

        /*
        |----------------------------------------------------------------
        | SUDAH LUNAS
        |----------------------------------------------------------------
        */

        if ($existing->status === 'paid') {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Email ini sudah terdaftar dan pembayaran sudah diverifikasi.'
                );
        }

        /*
        |----------------------------------------------------------------
        | SUDAH PERNAH ISI BIODATA (HP MATI / SESI HILANG, DLL)
        |----------------------------------------------------------------
        |
        | Status waiting_payment atau waiting_verification berarti
        | peserta sudah pernah menyelesaikan form biodata sebelumnya.
        | Tidak perlu isi biodata lagi, langsung arahkan ke halaman
        | pembayaran (token dibuat ulang karena token lama tidak
        | disimpan dalam bentuk plain text).
        |
        */

        $paymentToken = Str::random(40);

        $existing->update([
            'payment_token_hash' => hash('sha256', $paymentToken),
            'email_verified_at' => $existing->email_verified_at ?? now(),
        ]);

        return redirect()->route(
            'fun-run.payment',
            $paymentToken
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN EMAIL KE SESSION
    |--------------------------------------------------------------------------
    */

    session([
        'fun_run_registration_email' => $validated['email'],
        'fun_run_event_id' => $event->id,
        'fun_run_period_id' => $activePeriod->id,
    ]);

    return redirect()->route('fun-run.register.form');
}

public function registerPending(string $registrationCode)
{
    $registration = FunRunRegistration::with([
        'event',
        'category',
        'price.period',
    ])
        ->where(
            'registration_code',
            $registrationCode
        )
        ->firstOrFail();

    return view(
        'fun-run.register-pending',
        compact('registration')
    );
}
}