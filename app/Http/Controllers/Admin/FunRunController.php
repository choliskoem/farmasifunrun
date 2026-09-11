<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FunRunPaymentLinkMail;
use App\Mail\FunRunPaymentVerifiedMail;
use App\Models\FunRunCategory;
use App\Models\FunRunRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FunRunController extends Controller
{
    /**
     * Daftar peserta Fun Run
     */
   public function registrations(Request $request)
{
    $channel = $request->get('channel', 'public');

    $registrations = $this->filteredRegistrationsQuery($request, $channel)
        ->with([
            'category',
            'price.period',
            'latestPayment',
        ])
        ->latest()
        ->paginate(20)
        ->withQueryString();

    $categories = FunRunCategory::orderBy('name')->get();

    $channelCounts = [
        'public' => FunRunRegistration::where('channel', 'public')->count(),
        'invitation' => FunRunRegistration::where('channel', 'invitation')->count(),
        'backdoor' => FunRunRegistration::where('channel', 'backdoor')->count(),
    ];

    // Statistik kartu di atas -- ikut channel yang lagi dibuka,
    // bukan digabung semua channel.
    $stats = [
        'total' => FunRunRegistration::where('channel', $channel)->count(),
        'waiting_verification' => FunRunRegistration::where('channel', $channel)
            ->where('status', 'waiting_verification')
            ->count(),
        'paid' => FunRunRegistration::where('channel', $channel)
            ->where('status', 'paid')
            ->count(),
    ];

    return view(
        'admin.fun-run.registrations.index',
        compact('registrations', 'categories', 'channel', 'channelCounts', 'stats')
    );
}

    /**
     * Query dasar peserta + filter search/status/kategori, dipakai
     * bareng oleh registrations() (listing) dan exportRegistrations()
     * (export CSV) supaya hasilnya selalu konsisten.
     */
    private function filteredRegistrationsQuery(Request $request, string $channel)
    {
        return FunRunRegistration::where('channel', $channel)
            ->when($request->filled('search'), function ($query) use ($request) {

                $search = $request->string('search');

                $query->where(function ($query) use ($search) {

                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('identity_number', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {

                $query->where('status', $request->string('status'));
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {

                $query->where('category_id', $request->integer('category_id'));
            });
    }

    /**
     * Export peserta (sesuai tab/filter yang lagi aktif) ke CSV.
     *
     * Pakai CSV mentah (fputcsv) tanpa package tambahan, supaya
     * tidak perlu composer install apapun.
     */
    public function exportRegistrations(Request $request)
    {
        $channel = $request->get('channel', 'public');

        $channelLabels = [
            'public' => 'Umum',
            'invitation' => 'Jalur Undangan',
            'backdoor' => 'Jalur Spesial',
        ];

        $registrations = $this->filteredRegistrationsQuery($request, $channel)
            ->with(['category', 'price.period', 'latestPayment'])
            ->latest()
            ->get();

        $filename = 'fun-run-' . $channel . '-' . now()->format('Ymd-His') . '.xls';

        $statusLabels = [
            'waiting_payment' => 'Menunggu Pembayaran',
            'waiting_verification' => 'Menunggu Verifikasi',
            'paid' => 'Terverifikasi',
        ];

        $statusColors = [
            'waiting_payment' => '#e2e8f0',
            'waiting_verification' => '#fef3c7',
            'paid' => '#d1fae5',
        ];

        $columns = [
            'Kode Registrasi',
            'Nama',
            'Email',
            'No. WA',
            'NIK',
            'Kategori',
            'Periode',
            'Ukuran Baju',
            'Status',
            'Total',
            'Tanggal Daftar',
        ];

        ob_start();
        ?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Peserta Fun Run</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        table { border-collapse: collapse; font-family: Calibri, Arial, sans-serif; font-size: 12px; }
        .title { font-size: 18px; font-weight: bold; color: #065f46; }
        .subtitle { font-size: 11px; color: #64748b; }
        th {
            background-color: #059669;
            color: #ffffff;
            font-weight: bold;
            padding: 8px 10px;
            border: 1px solid #047857;
            text-align: left;
        }
        td {
            padding: 6px 10px;
            border: 1px solid #cbd5e1;
        }
        .num { mso-number-format: "#,##0"; text-align: right; }
        .row-even { background-color: #f8fafc; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="<?= count($columns) ?>" class="title">Data Peserta Fun Run — <?= htmlspecialchars($channelLabels[$channel] ?? $channel) ?></td>
        </tr>
        <tr>
            <td colspan="<?= count($columns) ?>" class="subtitle">Diexport pada <?= now()->translatedFormat('d F Y, H:i') ?> WITA &middot; Total <?= $registrations->count() ?> peserta</td>
        </tr>
        <tr><td colspan="<?= count($columns) ?>">&nbsp;</td></tr>

        <tr>
            <?php foreach ($columns as $column): ?>
                <th><?= htmlspecialchars($column) ?></th>
            <?php endforeach; ?>
        </tr>

        <?php foreach ($registrations as $index => $registration): ?>
            <tr class="<?= $index % 2 === 1 ? 'row-even' : '' ?>">
                <td><?= htmlspecialchars($registration->registration_code) ?></td>
                <td><?= htmlspecialchars($registration->name) ?></td>
                <td><?= htmlspecialchars($registration->email) ?></td>
                <td><?= htmlspecialchars($registration->phone) ?></td>
                <td><?= htmlspecialchars($registration->identity_number) ?></td>
                <td><?= htmlspecialchars($registration->category->name ?? '-') ?></td>
                <td><?= htmlspecialchars($registration->price->period->name ?? '-') ?></td>
                <td><?= htmlspecialchars($registration->shirt_size ?? '-') ?></td>
                <td style="background-color: <?= $statusColors[$registration->status] ?? '#f1f5f9' ?>;">
                    <?= htmlspecialchars($statusLabels[$registration->status] ?? $registration->status) ?>
                </td>
                <td class="num">Rp <?= number_format($registration->amount, 0, ',', '.') ?></td>
                <td><?= $registration->created_at?->format('d-m-Y H:i') ?></td>
            </tr>
        <?php endforeach; ?>

    </table>
</body>
</html>
        <?php
        $content = ob_get_clean();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response($content, 200, $headers);
    }

    /**
     * Detail peserta
     */
   public function show($id)
{
    $registration = FunRunRegistration::with([
        'event',
        'category',
        'price.period',
        'payments',
    ])->findOrFail($id);

    $payment = $registration->payments()
        ->latest('id')
        ->first();

    return view('admin.fun-run.registrations.show', compact(
        'registration',
        'payment'
    ));
}

    /**
     * Verifikasi pembayaran
     */
    public function verify(
        Request $request,
        FunRunRegistration $registration
    ) {
        $payment = $registration->payments()
            ->where('status', 'submitted')
            ->latest()
            ->first();

        if (!$payment) {
            return back()->with(
                'error',
                'Bukti pembayaran tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Verifikasi pembayaran
        |--------------------------------------------------------------------------
        */

        $payment->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'paid_at' => now(),
            'admin_note' => $request->admin_note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update registrasi
        |--------------------------------------------------------------------------
        */

        $registration->update([
            'status' => 'paid',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim email
        |--------------------------------------------------------------------------
        */

        Mail::to($registration->email)
            ->send(
                new FunRunPaymentVerifiedMail(
                    $registration
                )
            );

        return redirect()
            ->route(
                'admin.fun-run.registrations.show',
                $registration
            )
            ->with(
                'success',
                'Pembayaran berhasil diverifikasi dan email telah dikirim.'
            );
    }

    /**
     * Tolak pembayaran
     */
    public function reject(
        Request $request,
        FunRunRegistration $registration
    ) {
        $request->validate([
            'admin_note' => [
                'required',
                'string',
            ],
        ]);

        $payment = $registration->payments()
            ->where('status', 'submitted')
            ->latest()
            ->first();

        if (!$payment) {
            return back()->with(
                'error',
                'Bukti pembayaran tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LOG UNTUK JEJAK AUDIT
        |--------------------------------------------------------------------------
        |
        | Datanya akan dihapus total di bawah, jadi catatan alasan
        | penolakan ini cuma disimpan di log aplikasi (bukan database),
        | supaya masih ada jejaknya kalau suatu saat perlu ditelusuri.
        */

        Log::warning('Registrasi Fun Run ditolak & dihapus.', [
            'registration_id' => $registration->id,
            'registration_code' => $registration->registration_code,
            'name' => $registration->name,
            'email' => $registration->email,
            'admin_id' => auth()->id(),
            'admin_note' => $request->admin_note,
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS SEMUA FILE BUKTI TRANSFER
        |--------------------------------------------------------------------------
        */

        foreach ($registration->payments as $paymentRow) {

            if ($paymentRow->proof) {
                Storage::disk('public')->delete($paymentRow->proof);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS SEMUA DATA REGISTRASI
        |--------------------------------------------------------------------------
        |
        | Kode registrasi & kode unik pembayaran otomatis lepas dan
        | bisa dipakai peserta berikutnya, karena keduanya dihitung
        | dari data yang masih ada di database (lihat
        | FunRunController::store()).
        */

        $registrationName = $registration->name;
        $registrationCode = $registration->registration_code;

        $registration->payments()->delete();
        $registration->delete();

        return redirect()
            ->route('admin.fun-run.registrations')
            ->with(
                'success',
                "Pendaftaran \"{$registrationName}\" ({$registrationCode}) ditolak dan dihapus. Kode registrasi & kode unik pembayarannya kini tersedia untuk peserta berikutnya."
            );
    }

    /**
     * Kirim ulang link pembayaran.
     *
     * Sejak alur registrasi diubah, peserta sudah otomatis mendapatkan
     * token pembayaran begitu selesai isi biodata (tidak lagi menunggu
     * admin). Aksi ini bukan lagi gerbang wajib sebelum peserta bisa
     * membayar — ini cuma alat bantu admin untuk MENERBITKAN ULANG link
     * pembayaran (mis. peserta lupa/kehilangan link, HP mati sebelum
     * sempat menyimpan link, dsb).
     */
    public function verifyEmail(FunRunRegistration $registration)
{
    $registration->load([
        'event',
        'category',
        'price.period',
    ]);

    // Tidak boleh dilakukan lagi kalau peserta sudah lunas.
    if ($registration->status === 'paid') {
        return back()->with(
            'error',
            'Peserta ini sudah membayar dan diverifikasi.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE TOKEN PEMBAYARAN BARU
    |--------------------------------------------------------------------------
    |
    | Token lama otomatis tidak berlaku lagi karena yang disimpan
    | hanya hash-nya, bukan token asli.
    |
    */

    $paymentToken = Str::random(64);

    $registration->update([

        'email_verified_at' =>
            $registration->email_verified_at ?? now(),

        'payment_token_hash' =>
            hash('sha256', $paymentToken),

        'payment_link_sent_at' => now(),

        'status' => $registration->status === 'waiting_verification'
            ? $registration->status
            : 'waiting_payment',

    ]);

    /*
    |--------------------------------------------------------------------------
    | KIRIM EMAIL
    |--------------------------------------------------------------------------
    */

    Mail::to($registration->email)
        ->send(
            new FunRunPaymentLinkMail(
                $registration,
                $paymentToken
            )
        );

    return back()->with(
        'success',
        'Link pembayaran baru berhasil dikirim ulang ke email peserta.'
    );
}
    
}