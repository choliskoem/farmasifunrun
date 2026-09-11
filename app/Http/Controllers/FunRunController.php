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
     * Path folder tempat file font .ttf disimpan. Taruh file-file
     * font (Anton-Regular.ttf, Poppins-*.ttf) di
     * resources/fonts/ pada project Laravel Anda.
     */
    private function fontPath(string $filename): string
    {
        return resource_path('fonts/' . $filename);
    }

    /**
     * Lebar & tinggi teks kalau digambar pakai font TTF tertentu --
     * dipakai buat menengahkan teks atau mengecilkan ukuran font
     * otomatis kalau teksnya kepanjangan.
     */
    private function ttfMeasure(float $size, string $fontPath, string $text): array
    {
        $box = imagettfbbox($size, 0, $fontPath, $text);

        return [
            'width' => abs($box[4] - $box[0]),
            'height' => abs($box[5] - $box[1]),
        ];
    }

    /**
     * Cari ukuran font TTF terbesar yang muat dalam $maxWidth,
     * dimulai dari $startSize lalu diperkecil sedikit demi sedikit.
     */
    private function ttfFitSize(float $startSize, float $minSize, string $fontPath, string $text, float $maxWidth): float
    {
        $size = $startSize;

        while ($size > $minSize) {

            if ($this->ttfMeasure($size, $fontPath, $text)['width'] <= $maxWidth) {
                break;
            }

            $size -= 1;
        }

        return $size;
    }

    /**
     * Gambar teks TTF dengan efek bayangan tipis di belakangnya,
     * supaya tetap kebaca jelas walau latarnya gradasi warna-warni.
     */
    private function ttfTextWithShadow($image, float $size, int $x, int $y, string $fontPath, string $text, int $color, int $shadowColor, int $offset = 2): void
    {
        imagettftext($image, $size, 0, $x + $offset, $y + $offset, $shadowColor, $fontPath, $text);
        imagettftext($image, $size, 0, $x, $y, $color, $fontPath, $text);
    }

    private function renderTicketImage(FunRunRegistration $registration): string
    {
        $width = 1200;
        $height = 560;
        $stripWidth = 150;

        $image = imagecreatetruecolor($width, $height);
        imageantialias($image, true);

        $anton = $this->fontPath('Anton-Regular.ttf');
        $popExtraBold = $this->fontPath('Poppins-ExtraBold.ttf');
        $popBold = $this->fontPath('Poppins-Bold.ttf');
        $popSemiBold = $this->fontPath('Poppins-SemiBold.ttf');
        $popRegular = $this->fontPath('Poppins-Regular.ttf');

        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 20, 10, 20);
        $shadow = imagecolorallocate($image, 40, 0, 40);
        $lime = imagecolorallocate($image, 163, 230, 53);
        $skyBlue = imagecolorallocate($image, 125, 211, 252);
        $creamBg = imagecolorallocate($image, 237, 238, 224);
        $pinkStrip = imagecolorallocate($image, 232, 140, 205);

        imagefill($image, 0, 0, $creamBg);

        /*
        |--------------------------------------------------------------------------
        | STRIP KIRI -- PINK + BARCODE DEKORATIF + KODE VERTIKAL
        |--------------------------------------------------------------------------
        */

        imagefilledrectangle($image, 0, 0, $stripWidth, $height, $pinkStrip);

        // Kode registrasi dibaca vertikal (dari bawah ke atas), dekat tepi kiri.
        $codeSize = 15;
        imagettftext($image, $codeSize, 90, 34, $height - 60, $black, $popSemiBold, $registration->registration_code);

        // Barcode dekoratif (bukan barcode asli yang bisa discan --
        // untuk verifikasi keaslian tiket, pakai QR code di sisi kanan).
        mt_srand(crc32($registration->registration_code));

        $barX = 45;
        $barEnd = $stripWidth - 12;
        $barTop = 55;
        $barBottom = $height - 55;

        while ($barX < $barEnd) {

            $barW = mt_rand(1, 5);

            if (mt_rand(0, 9) > 0) {
                imagefilledrectangle($image, $barX, $barTop, min($barX + $barW - 1, $barEnd), $barBottom, $black);
            }

            $barX += $barW + mt_rand(1, 3);
        }

        mt_srand();

        /*
        |--------------------------------------------------------------------------
        | AREA UTAMA -- GRADASI UNGU KE ORANYE
        |--------------------------------------------------------------------------
        */

        $gradStart = [107, 33, 130];  // ungu
        $gradEnd = [234, 88, 12];     // oranye

        for ($x = $stripWidth; $x < $width; $x++) {

            $ratio = ($x - $stripWidth) / ($width - $stripWidth);

            $r = (int) ($gradStart[0] + ($gradEnd[0] - $gradStart[0]) * $ratio);
            $g = (int) ($gradStart[1] + ($gradEnd[1] - $gradStart[1]) * $ratio);
            $b = (int) ($gradStart[2] + ($gradEnd[2] - $gradStart[2]) * $ratio);

            imageline($image, $x, 0, $x, $height, imagecolorallocate($image, $r, $g, $b));
        }

        $contentX = $stripWidth + 50;
        $maxContentWidth = $width - $contentX - 260;

        // Tag kecil nama event.
        imagettftext($image, 15, 0, $contentX, 55, $white, $popSemiBold, strtoupper($registration->event->name));

        // Headline besar "FARMASI" / "FUN RUN".
        imagettftext($image, 34, 0, $contentX, 105, $white, $anton, 'FARMASI');

        $runSize = $this->ttfFitSize(92, 55, $anton, 'FUN RUN', $maxContentWidth);
        $this->ttfTextWithShadow($image, $runSize, $contentX, 205, $anton, 'FUN RUN', $white, $shadow, 3);

        /*
        |--------------------------------------------------------------------------
        | BADGE KATEGORI (LINGKARAN) + NAMA PESERTA
        |--------------------------------------------------------------------------
        */

        $circleY = 260;
        $circleR = 66;
        $circleCx = $contentX + $circleR;

        imageellipse($image, $circleCx, $circleY, $circleR * 2, $circleR * 2, $white);
        imageellipse($image, $circleCx, $circleY, $circleR * 2 - 3, $circleR * 2 - 3, $white);

        $catText = $registration->category->name;
        $catMeasure = $this->ttfMeasure(28, $popExtraBold, $catText);
        imagettftext(
            $image, 28, 0,
            (int) ($circleCx - $catMeasure['width'] / 2),
            (int) ($circleY + $catMeasure['height'] / 2),
            $white, $popExtraBold, $catText
        );

        $nameX = $contentX + ($circleR * 2) + 30;
        $nameSize = $this->ttfFitSize(30, 16, $popExtraBold, strtoupper($registration->name), $maxContentWidth - ($circleR * 2) - 30);
        $this->ttfTextWithShadow($image, $nameSize, $nameX, $circleY - 5, $popExtraBold, strtoupper($registration->name), $white, $shadow, 2);

        imagettftext($image, 15, 0, $nameX, $circleY + 22, $skyBlue, $popSemiBold, $registration->price->period->name);

        /*
        |--------------------------------------------------------------------------
        | GARIS RUTE PUTUS-PUTUS (DEKORASI)
        |--------------------------------------------------------------------------
        */

        $dashY = 335;
        $dashX = $contentX;

        imagefilledrectangle($image, $dashX, $dashY, $dashX + 50, $dashY + 8, $lime);
        $dashX += 66;

        while ($dashX < $contentX + $maxContentWidth) {
            imagefilledrectangle($image, $dashX, $dashY + 2, $dashX + 20, $dashY + 5, $white);
            $dashX += 32;
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL PESERTA (UKURAN BAJU / STATUS)
        |--------------------------------------------------------------------------
        */

        $detailY = 385;

        $details = array_filter([
            $registration->shirt_size ? 'UKURAN BAJU: ' . $registration->shirt_size : null,
            'STATUS: LUNAS',
        ]);

        $detailX = $contentX;

        foreach ($details as $i => $detail) {

            if ($i > 0) {
                imagettftext($image, 16, 0, $detailX, $detailY, $white, $popRegular, '|');
                $detailX += 18;
            }

            imagettftext($image, 16, 0, $detailX, $detailY, $white, $popSemiBold, $detail);
            $detailX += $this->ttfMeasure(16, $popSemiBold, $detail)['width'] + 22;
        }

        // Footer kecil.
        imagettftext($image, 13, 0, $contentX, $height - 35, $white, $popRegular, 'farmasi.official');

        /*
        |--------------------------------------------------------------------------
        | QR CODE VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $qrSize = 170;
        $qrX = $width - $qrSize - 55;
        $qrY = $height - $qrSize - 55;

        imagettftext($image, 13, 0, $qrX - 4, $qrY - 16, $white, $popSemiBold, 'SCAN VERIFIKASI');

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
            }
        }

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return $imageData;
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