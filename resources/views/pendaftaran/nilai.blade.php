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
                            <tr>
                                <td>
                                    @foreach ($value as $key => $item)
                                        <strong>{{ $key }}</strong>
                                        @foreach ($item as $subKriteria => $nilai)
                                            <ul>
                                                <li>{{ $subKriteria }}</li>

                                            </ul>
                                        @endforeach
                                    @endforeach


                                </td>
                                <td>30</td>
                                <td>
                                    @foreach ($value as $key => $item)
                                        <strong>{{ $key }}</strong>

                                        @foreach ($item as $subKriteria => $nilai)
                                            <ul>
                                                <li>{{ $nilai }}</li>

                                            </ul>
                                        @endforeach
                                    @endforeach

                                </td>

                            </tr>
                            <tr>
                                <td>Skor Total</td>
                                <td class="text-center" colspan="2">{{ $total }}</td>
                            </tr>
                            <tr>
                                <td>Reviewer</td>
                                <td class="text-center" colspan="2">{{ $reviewer }}</td>
                            </tr>




                        </tbody>
                    </table>
                @endforeach

                <a href="/pendaftaran" class="btn btn-primary">Kembali</a>
            </div>

        </div>
    </div>
@endsection
