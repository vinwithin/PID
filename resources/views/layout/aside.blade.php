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
                    <a href="/profil" class="sidebar-baseline text-dark"><i class="me-2"
                            data-feather="settings"></i><span>Pengaturan</span></a>
                    <a href="/logout" class="sidebar-baseline text-dark"><i class="me-2"
                            data-feather="log-out"></i><span>Keluar</span></a>

                </div>
            </div>



            <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            {{-- @endrole --}}

            @can('register program')
                <li class="sidebar-item {{ Request::is(['daftarProgram*', 'program*', 'editProgram*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.daftar') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar
                            Pro-IDe</span>
                    </a>
                </li>
            @endcan

            @role('dosen')
                <li class="sidebar-item {{ Request::is(['kelola-tim-pendamping*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kelola.tim.pendamping') }}">
                        <i class="fa-solid fa-person-chalkboard"></i> <span class="align-middle">Kelola
                            Tim Pendamping</span>
                    </a>
                </li>
            @endrole

            @role('admin|reviewer|dosen')
                <li
                    class="sidebar-item {{ Request::is(['pendaftaran*', 'reviewer*', 'pilih-reviewer*', 'edit-reviewer*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('pendaftaran') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Kelola
                            Pendaftaran</span>
                    </a>
                </li>
                @if (Auth::user()->can('show logbook'))
                    <li class="sidebar-header">Log Book</li>
                    <li class="sidebar-item {{ Request::is(['logbook*']) ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('logbook') }}">
                            <i class="fa-regular fa-note-sticky"></i>
                            <span class="align-middle">Daftar Log Book</span>
                        </a>
                    </li>
                @endif
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
                <li class="sidebar-item {{ Request::is('laporan-akhir*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-akhir') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Laporan Akhir</span>
                    </a>
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
            @endrole

            @php
                $hasAccessToProgress =
                    auth()->user()->hasRole('mahasiswa') &&
                    App\Models\Registration::whereHas('registration_validation', function ($query) {
                        $query->where('status', 'lolos');
                    })
                        ->whereHas('teamMembers', function ($query) {
                            $query->where('identifier', auth()->user()->identifier);
                        })
                        ->exists();
            @endphp
            @if ($hasAccessToProgress)
                <li class="sidebar-header">Log Book</li>
                <li class="sidebar-item {{ Request::is(['logbook*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('logbook') }}">
                        <i class="fa-regular fa-note-sticky"></i> <span class="align-middle">Daftar Logbook</span>
                    </a>
                </li>

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
                            $query->where('identifier', auth()->user()->identifier);
                        })
                        ->exists();
            @endphp

            @if ($hasAccessToPublication)
                <li class="sidebar-header">Log Book</li>
                <li class="sidebar-item {{ Request::is(['logbook*']) ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('logbook') }}">
                        <i class="fa-regular fa-note-sticky"></i> <span class="align-middle">Daftar Logbook</span>
                    </a>
                </li>
                <li class="sidebar-header">Laporan Kemajuan</li>
                <li class="sidebar-item {{ Request::is('laporan-kemajuan*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-kemajuan') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Unggah
                            Dokumen</span>
                    </a>
                </li>
                <li class="sidebar-header">Laporan Akhir</li>
                <li class="sidebar-item {{ Request::is('laporan-akhir*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('laporan-akhir') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Laporan
                            Akhir</span>
                    </a>
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
                <li class="sidebar-header">
                    Kelola Konten
                </li>
                <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('publikasi') }}">
                        <i class="align-middle" data-feather="upload-cloud"></i> <span class="align-middle">Publikasi
                            Kegiatan</span>
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
                            Kegiatan</span>
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
                <li class="sidebar-item {{ Request::is('berita*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('berita') }}">
                        <i class="fa-solid fa-newspaper"></i> <span class="align-middle">Kelola
                            Berita</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('kelola-ormawa*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('kelola-ormawa.index') }}">
                        <i class="fa-solid fa-sitemap"></i> <span class="align-middle">Kelola
                            Ormawa</span>
                    </a>
                </li>
            @endrole

            @role('super admin')
                <li class="sidebar-header">
                    Kelola Konten
                </li>
                <li class="sidebar-item {{ Request::is('announcement*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('announcement') }}">
                        <i class="align-middle" data-feather="book"></i> <span class="align-middle">Kelola
                            Pengumuman</span>
                    </a>
                </li>
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
