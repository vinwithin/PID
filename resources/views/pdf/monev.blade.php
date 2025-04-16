<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Pro Ide</title>
    <style>
        @page {
            /* margin: 33px 33px 33px 40px; */
            /* Top, Right, Bottom, Left margins */
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .container {
            /* width: 100%; */
            margin: 33px 33px 33px 40px;
            width: 100%;
            overflow: hidden;
            padding: 0;
        }

        h3 {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 15px;
            
        }

        .border {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-left {
            text-align: left;
        }

        ul.list-unstyled {
            padding-left: 5px;
            margin: 0;
            list-style-type: none;
        }

        .info-table td {
            border-style: none;
            padding: 4px 6px;
            vertical-align: top;
        }

        .signature-table {
            margin-top: 30px;
        }

        .signature-space {
            height: 50px;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mt-4 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>PENILAIAN PELAKSANAAN PRO IDE TAHUN {{ now()->year }}</h3>

        <table class="info-table">
            <tr>
                <td class="text-left" style="width: 25%;">Judul Program</td>
                <td class="text-left" style="width: 75%;">: {{ $data_regis->judul }}</td>
            </tr>
            <tr>
                <td class="text-left" style="width: 25%;">Ketua Pengusul</td>
                <td class="text-left" style="width: 75%;">: {{ $data_regis->nama_ketua }}</td>
            </tr>
            <tr>
                <td class="text-left" style="width: 25%;">Ormawa Pengusul</td>
                <td class="text-left" style="width: 75%;">: {{ $data_regis->ormawa->nama }}</td>
            </tr>
        </table>

        @foreach ($data as $reviewer => $item)
            <table>
                <thead>
                    <tr>
                        <th class="border">No</th>
                        <th class="text-left border">Kriteria</th>
                        <th class="border">Bobot</th>
                        <th class="border">Skor</th>
                        <th class="border">Nilai (Bobot x Skor)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item as $key => $value)
                        <tr>
                            <td class="border">{{ $loop->iteration }}</td>
                            <td class="text-left border">
                                <strong>{{ $key }}</strong><br>
                                <ul class="list-unstyled">
                                    @foreach ($value as $subKriteria => $nilai)
                                        <li>
                                            <span style="font-size: 10px;">{{ $subKriteria }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="border">{{ $bobot[$key] }}</td>
                            <td class="border">
                                @foreach ($value as $subKriteria => $nilai)
                                    <div class="mb-1">{{ $nilai }}</div>
                                @endforeach
                            </td>
                            <td class="border">
                                @foreach ($value as $subKriteria => $nilai)
                                    <div class="mb-1">{{ $nilai * $bobot[$key] }}</div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="border"><strong>Total</strong></td>
                        <td class="border"><strong></strong></td>
                        <td class="border"></td>
                        <td class="border"><strong>{{ $total }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endforeach

        <p class="mt-4"><strong>Catatan Penilai:</strong> {{ $dataReviewId[0]->feedback ?? '' }}</p>

        <table class="signature-table">
            @foreach ($data as $reviewer => $item)
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="text-align: left; width: 40%;">Jambi, {{ date('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="text-align: left; width: 40%;">Penilai,</td>
                </tr>
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%;" class="signature-space"></td>
                </tr>
                <tr>
                    <td style="width: 60%;"></td>
                    <td style="text-align: left; width: 40%;"><strong>{{ $reviewer }}</strong></td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
