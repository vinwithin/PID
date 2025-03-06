@extends('layout.app')
@section('content')
    @role('admin|reviewer|dosen')
        <div class="w-100 ">
            <div class="card p-3 border rounded-3 shadow-sm">
                <h4 class="fw-bold">
                    <i class="bi bi-calendar-event"></i> Informasi Penting!
                </h4>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-3">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal pendaftaran Pro-IDe periode 10 mulai dari 10 Juni - 30 Juni 2024. <strong>Ayo daftar
                            sekarang!</strong></span>
                </div>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-2">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal pengumpulan berkas Pro-IDe periode 10 mulai dari 01 Juli - 15 Juli 2024. <strong>Lengkapi
                            berkas anda sekarang!</strong></span>
                </div>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-2">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal publikasi Pro-IDe periode 10 mulai dari 01 Desember - 20 Desember 2024. <strong>Segera
                            publikasi hasil anda!</strong></span>
                </div>
            </div>
        </div>


        @elserole('mahasiswa')
        <div class="w-100">
            <div class="card p-3 border rounded-3 shadow-sm">
                <h4 class="fw-bold">
                    <i class="bi bi-calendar-event"></i> Informasi Penting!
                </h4>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-3">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal pendaftaran Pro-IDe periode 10 mulai dari 10 Juni - 30 Juni 2024. <strong>Ayo daftar
                            sekarang!</strong></span>
                </div>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-2">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal pengumpulan berkas Pro-IDe periode 10 mulai dari 01 Juli - 15 Juli 2024. <strong>Lengkapi
                            berkas anda sekarang!</strong></span>
                </div>

                <div class="bg-light p-2 rounded d-flex align-items-center mt-2">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <span>Jadwal publikasi Pro-IDe periode 10 mulai dari 01 Desember - 20 Desember 2024. <strong>Segera
                            publikasi hasil anda!</strong></span>
                </div>
            </div>
        </div>
    @endrole
    {{-- <div class="row">
  
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Sales</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="truck"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">2.382</h1>
                            <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Visitors</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">14.212</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Earnings</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">$21.300</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Orders</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">64</h1>
                            <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -2.25% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div> --}}
@endsection
