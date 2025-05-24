@extends('layout.app')
@section('title', 'Nilai Proposal')
@section('description', 'Kelola Pendaftaran')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    @php
        $curentUser = auth()->user()->name;
    @endphp
    @role('admin|super admin')
        <div class="w-full container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">

                        <div class="card-body ">
                            @foreach ($data as $reviewer => $value)
                    
                                <div class="card mb-4 ">
                                    <div class="card-header bg-light border">
                                        <h5 class="mb-0">Penilai {{ $loop->iteration }}</h5>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover border">
                                            <thead class="table-primary ">
                                                <tr>
                                                    <th class="bg-dark text-light w-50">Aspek Penilaian</th>
                                                    <th class="w-20 text-center bg-dark text-light">Bobot</th>
                                                    <th class="w-30 text-center bg-dark text-light">Skor</th>
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
                                                    <td colspan="2">
                                                        {{ $data_review[$loop->index]->feedback ?? 'Tidak ada feedback' }}
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
                                        <a href="/pendaftaran/generate-nilai/{{$id_regis->id}}/{{$reviewer}}" class="btn btn-outline-primary"><i class="fa-solid fa-print me-2"></i>Cetak Nilai</a>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-end mt-3">
                                <a href="/pendaftaran" class="btn btn-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elserole('reviewer|dosen')
        <div class="w-full container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="card mb-4 border-light">
                                <div class="table-responsive">
                                    <table class="table table-hover border">
                                        <thead class="table-primary ">
                                            <tr>
                                                <th class="bg-dark text-light w-50">Aspek Penilaian</th>
                                                <th class="w-20 text-center bg-dark text-light">Bobot</th>
                                                <th class="w-30 text-center bg-dark text-light">Skor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data[auth()->user()->name] as $key => $item)
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
                                            <tr class="table-secondary">
                                                <td>Skor Total</td>

                                                <td class="text-center fw-bold" colspan="2">
                                                    {{ $total[auth()->user()->name] ?? '-' }}
                                                </td>
                                            </tr>
                                            {{-- Feedback --}}
                                            <tr>
                                                <td>Feedback</td>
                                                {{-- {{dd($data_review)}} --}}
                                                <td colspan="2" class="fw-bold">{{ $dataReviewId[0]->feedback }}</td>
                                            </tr>
                                            {{-- Reviewer --}}
                                            <tr class="table-secondary">
                                                <td>Penilai</td>
                                                <td class="text-center fw-bold" colspan="2">{{ $curentUser }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="text-start mt-3">
                                        <a href="/pendaftaran" class="btn btn-secondary">
                                            <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@endsection
