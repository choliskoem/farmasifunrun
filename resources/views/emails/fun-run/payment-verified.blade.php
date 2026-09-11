<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pembayaran Berhasil
    </title>
</head>

<body
    style="
        margin:0;
        padding:30px 15px;
        background:#f1f5f9;
        font-family:Arial, Helvetica, sans-serif;
    "
>

<div
    style="
        max-width:600px;
        margin:auto;
        background:#ffffff;
        border-radius:20px;
        overflow:hidden;
    "
>

    {{-- Header --}}
    <div
        style="
            padding:30px;
            text-align:center;
            background:#059669;
            color:#ffffff;
        "
    >

        <h1 style="margin:0;">
            Pembayaran Berhasil
        </h1>

        <p style="margin:10px 0 0;">
            Farmasi Fun Run
        </p>

    </div>


    {{-- Content --}}
    <div style="padding:30px;">

        <p>
            Halo
            <strong>
                {{ $registration->name }}
            </strong>,
        </p>

        <p>
            Pembayaran pendaftaran Fun Run Anda telah
            <strong style="color:#059669;">
                berhasil diverifikasi
            </strong>
            oleh admin.
        </p>


        {{-- Registration --}}
        <div
            style="
                margin-top:25px;
                padding:20px;
                background:#f8fafc;
                border-radius:15px;
            "
        >

            <p style="margin:0 0 8px; color:#64748b;">
                Kode Registrasi
            </p>

            <p
                style="
                    margin:0;
                    font-size:22px;
                    font-weight:bold;
                    color:#059669;
                "
            >
                {{ $registration->registration_code }}
            </p>

        </div>


        <table
            width="100%"
            cellpadding="8"
            cellspacing="0"
            style="margin-top:20px;"
        >

            <tr>
                <td style="color:#64748b;">
                    Nama
                </td>

                <td align="right">
                    <strong>
                        {{ $registration->name }}
                    </strong>
                </td>
            </tr>

            <tr>
                <td style="color:#64748b;">
                    Kategori
                </td>

                <td align="right">
                    <strong>
                        {{ $registration->category->name }}
                    </strong>
                </td>
            </tr>

            <tr>
                <td style="color:#64748b;">
                    Total Pembayaran
                </td>

                <td align="right">
                    <strong style="color:#059669;">
                        Rp
                        {{ number_format(
                            $registration->amount,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </td>
            </tr>

            <tr>
                <td style="color:#64748b;">
                    Status
                </td>

                <td align="right">
                    <strong style="color:#059669;">
                        LUNAS
                    </strong>
                </td>
            </tr>

        </table>


        {{-- Download Ticket Button --}}
        <table
            width="100%"
            cellpadding="0"
            cellspacing="0"
            style="margin-top:25px;"
        >
            <tr>
                <td align="center">
                    <a
                        href="{{ route('fun-run.ticket.download', $registration->registration_code) }}"
                        style="
                            display:inline-block;
                            width:100%;
                            box-sizing:border-box;
                            padding:16px 24px;
                            background:#059669;
                            color:#ffffff;
                            font-weight:bold;
                            font-size:15px;
                            text-decoration:none;
                            border-radius:12px;
                            text-align:center;
                        "
                    >
                        Download Tiket
                    </a>
                </td>
            </tr>
        </table>

        <p style="margin-top:10px; font-size:12px; color:#94a3b8; text-align:center;">
            Kalau tombol di atas tidak berfungsi, buka halaman sukses
            pendaftaran Anda untuk mengunduh ulang tiket.
        </p>


        <div
            style="
                margin-top:25px;
                padding:15px;
                background:#ecfdf5;
                border-radius:12px;
                color:#065f46;
            "
        >

            Pembayaran Anda telah diterima.
            Simpan email ini sebagai bukti konfirmasi
            pendaftaran Fun Run.

        </div>


        <p style="margin-top:30px;">
            Terima kasih telah berpartisipasi.
        </p>

        <p>
            Salam,
            <br>
            <strong>
                Panitia Farmasi Fun Run
            </strong>
        </p>

    </div>


    {{-- Footer --}}
    <div
        style="
            padding:20px;
            text-align:center;
            background:#f8fafc;
            color:#64748b;
            font-size:12px;
        "
    >

        Email ini dikirim otomatis oleh sistem
        pendaftaran Farmasi Fun Run.

    </div>

</div>

</body>
</html>