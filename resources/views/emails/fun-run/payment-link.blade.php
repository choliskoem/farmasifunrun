<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>
        Link Pembayaran Fun Run
    </title>

</head>

<body style="
    margin:0;
    padding:0;
    background:#f1f5f9;
    font-family:Arial, sans-serif;
">

    <div style="
        max-width:600px;
        margin:40px auto;
        background:white;
        border-radius:20px;
        padding:35px;
    ">

        <h2 style="
            margin-top:0;
            color:#0f172a;
        ">
            Link Pembayaran
        </h2>

        <p style="color:#475569; line-height:1.7;">

            Halo
            <strong>{{ $registration->name }}</strong>,

        </p>

        <p style="
            color:#475569;
            line-height:1.7;
        ">

            Data pendaftaran Anda untuk
            <strong>{{ $registration->event->name }}</strong>
            telah diverifikasi oleh admin.

        </p>

        <div style="
            margin:25px 0;
            padding:20px;
            background:#ecfdf5;
            border-radius:15px;
        ">

            <p style="
                margin:0;
                color:#64748b;
                font-size:14px;
            ">
                Total Pembayaran
            </p>

            <p style="
                margin:8px 0 0;
                font-size:28px;
                font-weight:bold;
                color:#059669;
            ">

                Rp {{ number_format(
                    $registration->amount,
                    0,
                    ',',
                    '.'
                ) }}

            </p>

        </div>

        <div style="text-align:center; margin:30px 0;">

            <a
                href="{{ route(
                    'fun-run.payment',
                    $paymentToken
                ) }}"
                style="
                    display:inline-block;
                    background:#059669;
                    color:white;
                    text-decoration:none;
                    padding:15px 25px;
                    border-radius:10px;
                    font-weight:bold;
                "
            >
                Buka Link Pembayaran
            </a>

        </div>

        <div style="
            margin-top:25px;
            padding:20px;
            background:#fef3c7;
            border-radius:15px;
            color:#92400e;
        ">

            <strong>PENTING</strong>

            <p style="
                margin-bottom:0;
                line-height:1.7;
            ">

                Link pembayaran ini bersifat pribadi.
                Jangan menyebarluaskan link ini kepada orang lain.

                Link akan tetap aktif selama pembayaran belum
                berhasil diverifikasi.

                Setelah pembayaran diverifikasi,
                link pembayaran otomatis tidak dapat digunakan lagi.

            </p>

        </div>

        <p style="
            margin-top:30px;
            color:#64748b;
            font-size:13px;
            line-height:1.6;
        ">

            Jika Anda tidak merasa melakukan pendaftaran,
            abaikan email ini.

        </p>

    </div>

</body>

</html>