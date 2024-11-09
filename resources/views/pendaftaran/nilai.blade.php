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
                                <th>Aspek Penilaian</th>
                                <th>Skor Maksimum</th>
                                <th>Skor yang Diberikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($value as $key => $item)
                                <tr>
                                    <td>
                                        <strong>{{ $key }}</strong>
                                        @foreach ($item as $subKriteria => $nilai)
                                            <ul>
                                                <li>{{ $subKriteria }}</li>

                                            </ul>
                                        @endforeach
                                    </td>
                                    <td>
                                        <p class="text-center fw-bold">{{ $bobot[$key] }}</p>
                                    </td>
                                 <td>
                                        @foreach ($item as $subKriteria => $nilai)
                                            <p class="text-center">{{ $nilai }}</p>
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach

                            {{-- @foreach ($total as $item => $value) --}}
                            <tr>
                                <td>Skor Total</td>
                                <td class="text-center" colspan="2">{{ $total[$reviewer] }}</td>
                            </tr>
                            {{-- @endforeach --}}
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
