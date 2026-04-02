<aside class="sidebar">
    @php
        $user = Auth::user();
        $role = $user->peran ?? 'guest';
    @endphp

    <div class="sidebar-profile">
        <div class="avatar-circle">
            <img src="{{ asset('images/dashboard/icons/icon_orang.png') }}" alt="Profile">
        </div>
        <div class="profile-info">
            <h4>{{ $user->username ?? $user->name }}</h4>
            <p>{{ ucfirst($role) }}</p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul>
            {{-- Dashboard --}}
            <li>
                <a href="{{ route($role . '.dashboard') }}" class="nav-link-custom {{ request()->routeIs($role . '.dashboard') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_dashboard.png') }}" class="sidebar-icon"> Dashboard
                </a>
            </li>

            {{-- Menu Superadmin --}}
            @if($role == 'superadmin')
                <li><a href="{{ route('superadmin.kelola-admin') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-admin*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_orang.png') }}" class="sidebar-icon"> Kelola Admin
                </a></li>
                <li><a href="{{ route('superadmin.kelola-tentor') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-tentor*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_datatentor.png') }}" class="sidebar-icon"> Kelola Tentor
                </a></li>
            @endif

            {{-- Menu Admin --}}
            @if($role == 'admin')
                <li><a href="{{ route('admin.data-tentor') }}" class="nav-link-custom {{ request()->routeIs('admin.data-tentor*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_datatentor.png') }}" class="sidebar-icon"> Data Tentor
                </a></li>
            @endif

            {{-- Menu Shared (Admin & Superadmin) --}}
            @if($role == 'admin' || $role == 'superadmin')
                <li><a href="{{ route($role . '.kelola-murid') }}" class="nav-link-custom {{ request()->routeIs($role . '.kelola-murid*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_kelolamurid.png') }}" class="sidebar-icon"> Kelola Murid
                </a></li>
                <li><a href="{{ route($role . '.harga-paket') }}" class="nav-link-custom {{ request()->routeIs($role . '.harga-paket*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> Harga Paket
                </a></li>
                <li><a href="{{ route($role . '.riwayat-presensi') }}" class="nav-link-custom {{ request()->routeIs($role . '.riwayat-presensi*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                </a></li>
                <li><a href="{{ route($role . '.pembayaran') }}" class="nav-link-custom {{ request()->routeIs($role . '.pembayaran*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_pembayaran.png') }}" class="sidebar-icon"> Pembayaran
                </a></li>
                <li><a href="{{ route($role . '.rekap-gaji') }}" class="nav-link-custom {{ request()->routeIs($role . '.rekap-gaji*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_rekapgaji.png') }}" class="sidebar-icon"> Rekap Gaji
                </a></li>
                <li><a href="{{ route($role . '.laporan-keuangan') }}" class="nav-link-custom {{ request()->routeIs($role . '.laporan-keuangan*') ? 'nav-active' : '' }}">
                    <img src="{{ asset('images/dashboard/icons/icon_laporankeuangan.png') }}" class="sidebar-icon"> Laporan Keuangan
                </a></li>
            @endif
        </ul>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <img src="{{ asset('images/dashboard/icons/icon_logout.png') }}" class="sidebar-icon"> Logout
            </button>
        </form>
    </div>
</aside>