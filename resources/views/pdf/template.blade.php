<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Pro Ide</title>
    <style>
        @page {
            /* margin: 40px 33px 33px 33px; */
            /* Top, Right, Bottom, Left margins */
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        .container {
            /* width: 100%; */
            margin: 33px 33px 33px 40px;
            width: 100%;
            overflow: hidden;
            padding: 0;
        }


        table {
            width: 90%;
            border-collapse: collapse;
        }

        .border {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
            border-style: none;
        }

        th {
            background-color: #ddd;
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container ">
        <h3 style="text-align: center;">PENILAIAN PELAKSANAAN PRO IDE TAHUN {{ now()->year }}</h3>

        <table class="table" style="width: 100%; border-style: none; margin-bottom: 10px;">
            <tr>
                <td class="text-left" style="width: 25%;">Judul Program</td>
                <td class="text-left" style="width: 75%;">{{ $data_regis->judul }}</td>
            </tr>
            <tr>
                <td class="text-left" style="width: 25%;">Ketua Pengusul</td>
                <td class="text-left" style="width: 75%;">{{ $data_regis->nama_ketua }}</td>
            </tr>
            <tr>
                <td class="text-left" style="width: 25%;">Ormawa Pengusul</td>
                <td class="text-left" style="width: 75%;">{{ $data_regis->ormawa->nama }}</td>
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
                            <td class="border border-black">{{ $loop->iteration }}</td>
                            <td class="text-left border border-black">
                                <strong>{{ $key }}</strong><br>
                                <ol style="padding-left: 20px; margin: 0;">
                                    @foreach ($value as $subKriteria => $nilai)
                                        <li>
                                            <span style="font-size: 10px;">{{ $subKriteria }}</span>
                                        </li>
                                    @endforeach
                                </ol>
                            </td>
                            <td class="border border-black">{{ $bobot[$key] }}</td>
                            <td class="text-center border border-black">
                                @foreach ($value as $subKriteria => $nilai)
                                    <div class="mb-1">{{ $nilai }}</div>
                                @endforeach
                            </td>
                            <td class="border border-black">
                                @foreach ($value as $subKriteria => $nilai)
                                    <div class="mb-1">{{ $nilai * $bobot[$key] }}</div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="border border-black"><strong>Total</strong></td>
                        <td class="border border-black"><strong></strong></td>
                        <td class="border border-black"></td>
                        <td class="border border-black"><strong>{{ $total }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @endforeach

        {{-- <p><strong>Keterangan:</strong> {{ $keterangan }}</p> --}}
        <p class="mt-4"><strong>Catatan Penilai: {{ $dataReviewId[0]->feedback ?? '' }}</strong></p>

        <table class="table" style="width: 100%; border-style: none; margin-top: 20px;">
            @foreach ($data as $reviewer => $item)
                <tr>
                    <td style="text-align: left; width: 50%;"></td>
                    <td style="text-align: left; width: 25%;"></td>
                    <td style="text-align: left; width: 25%;">Jambi, {{ date('d F Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; width: 50%;"></td>
                    <td style="text-align: left; width: 25%;"></td>
                    <td style="text-align: left; width: 25%;">Penilai</td>
                </tr>
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 25%; height: 30px; display: block;">&nbsp;</td>
                    <td style="width: 25%;"></td>
                </tr>
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 25%;">&nbsp;</td>
                    <td style="text-align: left; width: 25%"><strong>{{ $reviewer }}</strong></td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
