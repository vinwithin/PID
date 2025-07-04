@extends('layout.app')
@section('title', 'Nilai Monitoring dan Evaluasi')
@section('description', 'Monitoring dan Evaluasi')

@section('content')
    @php
        $curentUser = auth()->user()->name;
    @endphp

    <div class="w-full container-fluid">
        @role('admin|super admin')
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body ">
                            @foreach ($data as $reviewer => $value)
                                <div class="card mb-4 border-light">
                                    <div class="card-header bg-light border">
                                        <h5 class="mb-0">Penilai : {{ $loop->iteration }}</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover border">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th class="w-50">Aspek Penilaian</th>
                                                    <th class="w-20 text-center">Bobot</th>
                                                    <th class="w-30 text-center">Skor</th>
                                                    {{-- @dd($value) --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($value as $key => $item)
                                                    <tr>
                                                        <td>
                                                            <strong class="fw-bold">{{ $key }}</strong>
                                                            <ul class="list-unstyled ps-3 mt-2">
                                                                @foreach ($item as $subKriteria => $nilai)
                                                                    <li class="mb-1">
                                                                        <i
                                                                            class="bi bi-dot text-muted me-1"></i>{{ $subKriteria }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td class="text-center fw-bold">
                                                            {{ $bobot[$key] ?? '-' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @foreach ($item as $subKriteria => $nilai)
                                                                <div class="mb-1">{{ $nilai }}</div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr class="table-secondary">
                                                    <td class="fw-bold">Total Skor</td>
                                                    <td colspan="2" class="text-center fw-bold text-success">
                                                        {{ $total[$reviewer] ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Feedback</td>
                                                    <td colspan="2" class="text-center text-primary">
                                                        {{-- {{ $data_review[0]->catatan ?? 'Tidak ada feedback' }} --}}
                                                        {{-- {{ dd($data_review->firstWhere('user.name', $reviewer)->catatan) }} --}}


                                                        {{ $data_review->firstWhere('user.name', $reviewer)->catatan }}

                                                    </td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <td class="fw-bold">Penilai</td>
                                                    <td colspan="2" class="text-center text-primary">
                                                        {{ $reviewer }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <a href="/monev/generate-nilai/{{ $id_regis->id }}/{{ $reviewer }}"
                                            class="btn btn-outline-primary"><i class="fa-solid fa-print me-2"></i>Cetak
                                            Nilai</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-start mt-3">
                                <a href="/monitoring-evaluasi" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @elserole('dosen|reviewer')
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body ">
                            <div class="card mb-4 border-light">

                                <div class="table-responsive">
                                    <table class="table table-hover border">
                                        <thead class="table-dark">
                                            <tr>
                                                <th class="w-50">Aspek Penilaian</th>
                                                <th class="w-20 text-center">Bobot</th>
                                                <th class="w-30 text-center">Skor</th>
                                                {{-- @dd($value) --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data[auth()->user()->name] as $reviewer => $value)
                                                {{-- @foreach ($value as $key => $item) --}}
                                                <tr>
                                                    <td>
                                                        <strong class="fw-bold">{{ $reviewer }}</strong>
                                                        <ul class="list-unstyled ps-3 mt-2">
                                                            @foreach ($value as $subKriteria => $nilai)
                                                                <li class="mb-1">
                                                                    <i
                                                                        class="bi bi-dot text-muted me-1"></i>{{ $subKriteria }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td class="text-center fw-bold">
                                                        {{ $bobot[$reviewer] ?? '-' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @foreach ($value as $subKriteria => $nilai)
                                                            <div class="mb-1">{{ $nilai }}</div>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endforeach

                                            {{-- @endforeach --}}
                                            <tr class="table-secondary">
                                                <td class="fw-bold">Total Skor</td>
                                                <td colspan="2" class="text-center fw-bold text-success">
                                                    {{ $total[auth()->user()->name] ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Feedback</td>
                                                <td colspan="2" class="text-center text-primary">
                                                    {{ $data_review->firstWhere('user_id', auth()->user()->id)->catatan ?? 'Tidak ada feedback' }}

                                                </td>
                                            </tr>
                                            <tr class="table-secondary">
                                                <td class="fw-bold">Penilai</td>
                                                <td colspan="2" class="text-center text-primary">
                                                    {{ auth()->user()->name }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                {{-- <div class="text-end mt-3">
                                        <a href="/monev/generate-nilai/{{ $id_regis->id }}/{{ $reviewer }}"
                                            class="btn btn-outline-primary"><i class="fa-solid fa-print me-2"></i>Cetak
                                            Nilai</a>
                                    </div> --}}
                            </div>
                            <div class="text-start mt-3">
                                <a href="/monitoring-evaluasi" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
    </div>
@endsection
