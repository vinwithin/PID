<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand text-center" href="{{ route('beranda') }}">
            <img src="/assets/Logo.png" alt="" srcset="" style="width: 186px; height:60px;">
        </a>
        <div class="text-center my-3">
            <img class="img-thumbnail rounded-circle" src="/img/photos/unsplash-1.jpg" alt=""
                style="width: 10rem; height: 10rem; object-fit: cover;">
        </div>


        <ul class="sidebar-nav ">
            <div class="border-top border-bottom">
                <div class="d-flex justify-content-around mx-3 my-3  ">
                    <a href="" class="sidebar-baseline text-dark"><i class="me-2"
                            data-feather="settings"></i><span>Pengaturan</span></a>
                    <a href="/logout" class="sidebar-baseline text-dark"><i class="me-2"
                            data-feather="log-out"></i><span>Keluar</span></a>

                </div>
            </div>

            {{-- <li class="sidebar-header">
                Pengaturan
            </li>
            <li class="sidebar-header">
                Keluar
            </li> --}}


            <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            {{-- @endrole --}}

            @can('register program')
                <li class="sidebar-item {{ Request::is(['daftarProgram*', 'program*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.daftar') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar
                            Pro-IDe</span>
                    </a>
                </li>

                {{-- <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('publikasi') }}">
                        <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Publikasi</span>
                    </a>
                </li> --}}
            @endcan

            @role('admin|reviewer|dosen|super admin')
                <li class="sidebar-item {{ Request::is(['pendaftaran*', 'reviewer*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pendaftaran') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Kelola
                            Pendaftaran</span>
                    </a>
                </li>
                <li class="sidebar-header">Laporan Kemajuan</li>
                <li class="sidebar-item {{ Request::is('laporan-kemajuan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-kemajuan') }}">
                        <i class="fa-regular fa-file"></i> <span class="align-middle">Daftar
                            Dokumen</span>
                    </a>
                </li>
                <li class="sidebar-header">
                    Monitoring dan Evaluasi
                </li>
                <li class="sidebar-item {{ Request::is('monitoring-evaluasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('monev.index') }}">
                        <i class="fa-solid fa-people-group"></i> <span class="align-middle">Daftar Kelompok</span>
                    </a>
                </li>

                <li class="sidebar-header">Laporan Akhir</li>
                <li class="sidebar-item {{ Request::is('dokumen-teknis*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumen-teknis') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Dokumen
                            Teknis</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('dokumen-publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumen-publikasi') }}">
                        <i class="align-middle" data-feather="inbox"></i> <span class="align-middle">Dokumen
                            Publikasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('dokumentasi-kegiatan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumentasi-kegiatan') }}">
                        <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Dokumentasi
                            Kegiatan</span>
                    </a>
                </li>
            @endrole
            @php
                $hasAccessToProgress =
                    auth()->user()->hasRole('mahasiswa') &&
                    App\Models\Registration::whereHas('registration_validation', function ($query) {
                        $query->where('status', 'lolos');
                    })
                        ->whereHas('teamMembers', function ($query) {
                            $query->where('nim', auth()->user()->nim);
                        })
                        ->exists();
            @endphp
            @if ($hasAccessToProgress)
                <li class="sidebar-header">Laporan Kemajuan</li>
                <li class="sidebar-item {{ Request::is('laporan-kemajuan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-kemajuan') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Unggah
                            Dokumen</span>
                    </a>
                </li>
            @endif

            @php
                $hasAccessToPublication =
                    auth()->user()->hasRole('mahasiswa') &&
                    App\Models\Registration::whereHas('registration_validation', function ($query) {
                        $query->where('status', 'Lanjutkan Program');
                    })
                        ->whereHas('teamMembers', function ($query) {
                            $query->where('nim', auth()->user()->nim);
                        })
                        ->exists();
            @endphp

            @if ($hasAccessToPublication)
                <li class="sidebar-header">Laporan Kemajuan</li>
                <li class="sidebar-item {{ Request::is('laporan-kemajuan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-kemajuan') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Unggah
                            Dokumen</span>
                    </a>
                </li>
                <li class="sidebar-header">Laporan Akhir</li>
                <li class="sidebar-item {{ Request::is('dokumen-teknis*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumen-teknis') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Dokumen
                            Teknis</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('dokumen-publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumen-publikasi') }}">
                        <i class="align-middle" data-feather="inbox"></i> <span class="align-middle">Dokumen
                            Publikasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('dokumentasi-kegiatan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumentasi-kegiatan') }}">
                        <i class="align-middle" data-feather="folder"></i> <span class="align-middle">Dokumentasi
                            Kegiatan</span>
                    </a>
                </li>
                <li class="sidebar-header">
                    Kelola Konten
                </li>
                <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('publikasi') }}">
                        <i class="align-middle" data-feather="upload-cloud"></i> <span class="align-middle">Publikasi
                            Artikel</span>
                    </a>
                </li>
            @endif


            @role('admin')
                <li class="sidebar-header">
                    Kelola Konten
                </li>
                <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('publikasi') }}">
                        <i class="align-middle" data-feather="upload-cloud"></i> <span class="align-middle">Publikasi
                            Artikel</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('kelola-konten/video*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kelola-konten.video') }}">
                        <i class="align-middle" data-feather="video"></i> <span class="align-middle">Konten Video</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('kelola-konten/foto*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kelola-konten.foto') }}">
                        <i class="align-middle" data-feather="image"></i> <span class="align-middle">Konten Galeri</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('announcement*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('announcement') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Kelola
                            Pengumuman</span>
                    </a>
                </li>
            @endrole
            @role('super admin')
                <li class="sidebar-header">
                   Master Data
                </li>
                <li class="sidebar-item {{ Request::is('manage-users*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('manage-users') }}">
                        <i class="fa-solid fa-gear"></i> <span class="align-middle">Akses Role</span>
                    </a>
                </li>
            @endrole


        </ul>

    </div>
</nav>
