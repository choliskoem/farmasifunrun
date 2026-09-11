<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', sans-serif;
            background-color: #0B1120;
        }

        .card {
            width: 100%;
            height: 100%;
            background-color: #0B1120;
            color: #ffffff;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .side {
            width: 34%;
            background-color: #10B981;
            padding: 18px 16px;
            vertical-align: top;
        }

        .content {
            width: 66%;
            padding: 18px 22px;
            vertical-align: top;
        }

        .eyebrow {
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #062e21;
            font-weight: bold;
        }

        .bib-number {
            font-size: 26px;
            font-weight: bold;
            color: #062e21;
            letter-spacing: 1px;
            margin-top: 8px;
            word-break: break-all;
        }

        .category-badge {
            display: inline-block;
            margin-top: 14px;
            padding: 4px 10px;
            background-color: #062e21;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            border-radius: 3px;
        }

        .event-name {
            font-size: 15px;
            font-weight: bold;
            color: #ffffff;
        }

        .event-meta {
            font-size: 9px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .divider {
            border-top: 1px dashed #334155;
            margin: 14px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .data-label {
            color: #94a3b8;
            width: 50%;
        }

        .data-value {
            color: #ffffff;
            font-weight: bold;
            text-align: right;
        }

        .footer-note {
            margin-top: 14px;
            font-size: 8px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <div class="card">

        <table class="main-table">
            <tr>

                <td class="side">

                    <div class="eyebrow">Bib Number</div>
                    <div class="bib-number">{{ $registration->registration_code }}</div>

                    <div class="category-badge">{{ $registration->category->name }}</div>

                </td>

                <td class="content">

                    <div class="eyebrow" style="color:#10B981;">HIMAFA Race Day</div>
                    <div class="event-name">{{ $registration->event->name }}</div>

                    <div class="event-meta">
                        @if ($registration->event->event_date)
                            {{ \Illuminate\Support\Carbon::parse($registration->event->event_date)->translatedFormat('d F Y') }}
                        @endif
                        @if ($registration->event->location)
                            &middot; {{ $registration->event->location }}
                        @endif
                    </div>

                    <div class="divider"></div>

                    <table class="data-table">
                        <tr>
                            <td class="data-label">Nama Peserta</td>
                            <td class="data-value">{{ $registration->name }}</td>
                        </tr>
                        <tr>
                            <td class="data-label">Periode</td>
                            <td class="data-value">{{ $registration->price->period->name }}</td>
                        </tr>
                        @if ($registration->shirt_size)
                            <tr>
                                <td class="data-label">Ukuran Baju</td>
                                <td class="data-value">{{ $registration->shirt_size }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="data-label">Status</td>
                            <td class="data-value" style="color:#10B981;">LUNAS</td>
                        </tr>
                    </table>

                    <div class="footer-note">
                        Tunjukkan tiket ini (cetak atau digital) saat pengambilan race pack.
                    </div>

                </td>

            </tr>
        </table>

    </div>

</body>

</html>
