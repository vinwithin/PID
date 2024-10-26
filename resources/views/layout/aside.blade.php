<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            @role('mahasiswa')
                <li class="sidebar-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
                @elserole('reviewer')
                <li class="sidebar-item {{ Request::is('reviewer/dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('reviewer.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
            @else
                <li class="sidebar-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                        <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>
            @endrole

            @role('mahasiswa')
                <li class="sidebar-item {{ Request::is('daftarProgram*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.daftar') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">Daftar
                            Pro-IDe</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Request::is('publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.publikasi') }}">
                        <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Publikasi</span>
                    </a>
                </li>
            @endrole
            @role('admin')
                <li class="sidebar-item {{ Request::is('admin/listPendaftaran*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('admin.listPendaftaran') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">List Pendaftaran</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('admin/publikasi*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('mahasiswa.publikasi') }}">
                        <i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Publikasi</span>
                    </a>
                </li>
            @endrole
            @role('reviewer')
                <li class="sidebar-item {{ Request::is('reviewer/listPendaftaran*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('reviewer.listPendaftaran') }}">
                        <i class="align-middle" data-feather="user"></i> <span class="align-middle">List Pendaftaran</span>
                    </a>
                </li>
            @endrole


            <li class="sidebar-item">
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
            </li>
        </ul>

    </div>
</nav>
