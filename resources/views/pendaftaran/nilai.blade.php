@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Nilai Proposal</h5>
            </div>
            <div class="card-body">
                @foreach ($data as $reviewer => $value)
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th colspan="3">Reviewer {{ $loop->iteration }}</th>
                            </tr>
                            <tr>
                                <th style="width: 60%">Aspek Penilaian</th> 
                                <th style="width: 20%">Bobot</th>
                                <th style="width: 20%">Skor yang Diberikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($value as $key => $item)
                                <tr>
                                    <td>
                                        <strong>{{ $key }}</strong>
                                        <ul>
                                            @foreach ($item as $subKriteria => $nilai)
                                                <li>{{ $subKriteria }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ $bobot[$key] ?? '-' }} {{-- Tampilkan '-' jika bobot tidak ditemukan --}}
                                    </td>
                                    <td>
                                        <ul class="list-unstyled text-center">
                                            @foreach ($item as $subKriteria => $nilai)
                                                <li>{{ $nilai }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Skor Total --}}
                            <tr>
                                <td>Skor Total</td>
                                <td class="text-center" colspan="2">{{ $total[$reviewer] ?? '-' }}</td>
                            </tr>

                            {{-- Feedback --}}
                            <tr>
                                <td>Feedback</td>
                                <td colspan="2">{{ $data_review[$loop->index]->status ?? 'Tidak ada feedback' }}</td>
                            </tr>

                            {{-- Reviewer --}}
                            <tr>
                                <td>Reviewer</td>
                                <td class="text-center fw-bold" colspan="2">{{ $reviewer }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach


                <a href="/pendaftaran" class="btn btn-primary">Kembali</a>

            </div>

        </div>
    </div>
@endsection
