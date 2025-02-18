<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand text-center btn btn-secondary" href="{{ route('beranda') }}">
            <span class=" align-middle">Logo</span>
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
                <li class="sidebar-item {{ Request::is('daftarProgram*') ? 'active' : '' }}">
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

            @role('admin|reviewer')
                <li class="sidebar-item {{ Request::is('pendaftaran*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pendaftaran') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Kelola
                            Pendaftaran</span>
                    </a>
                </li>
            @endrole
            @role('admin|dosen')
                <li class="sidebar-header">
                    Monitoring dan Evaluasi
                </li>
                <li class="sidebar-item {{ Request::is('monitoring-evaluasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('monev.index') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Daftar Kelompok</span>
                    </a>
                </li>
            @endrole
            @can('create publication')
                @php
                    $hasAccessToPublication = App\Models\Registration::whereHas('registration_validation', function (
                        $query,
                    ) {
                        $query->where('status', 'lolos'); // Cek status validasi
                    })
                        ->whereHas('teamMembers', function ($query) {
                            $query->where('nim', auth()->user()->nim); // Cek apakah NIM ada di tabel team_member
                        })
                        ->exists();
                @endphp
                @if ($hasAccessToPublication)
                    <li class="sidebar-header">
                        Laporan Akhir
                    </li>
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
                    <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('publikasi') }}">
                            <i class="align-middle" data-feather="upload-cloud"></i> <span class="align-middle">Publikasi
                                Artikel</span>
                        </a>
                    </li>
                @endif
            @endcan
            @role('admin')
                <li class="sidebar-header">
                    Laporan Akhir
                </li>
                <li class="sidebar-item {{ Request::is('dokumen-teknis*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('dokumen-teknis') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Dokumen Teknis</span>
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
                <li class="sidebar-item {{ Request::is('kelola-konten/artikel*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kelola-konten.artikel') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Kelola Artikel</span>
                    </a>
                </li>
            @endrole

            {{-- <li class="sidebar-item">
                <a class="sidebar-link" href="pages-sign-up.html">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Sign
                        Up</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="pages-blank.html">
                    <i class="align-middle" data-feather="book"></i> <span class="align-middle">Blank</span>
                </a>
            </li>

            <li class="sidebar-header">
                Tools & Components
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Buttons</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-forms.html">
                    <i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Forms</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-cards.html">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Typography</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="icons-feather.html">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                </a>
            </li>

            <li class="sidebar-header">
                Plugins & Addons
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="charts-chartjs.html">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Charts</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="maps-google.html">
                    <i class="align-middle" data-feather="map"></i> <span class="align-middle">Maps</span>
                </a>
            </li> --}}
        </ul>

    </div>
</nav>
