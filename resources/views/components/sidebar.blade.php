{{-- =============================================
     Component: Sidebar
     File: resources/views/components/sidebar.blade.php
============================================= --}}

<aside class="sidebar" id="sidebar" style="overflow-y: auto; scroll-behavior: smooth;">
    @php
        $user = Auth::user();
        $role = $user->peran ?? 'guest';
    @endphp

    {{-- ── PROFILE ── --}}
    <div class="sidebar-profile">
        <div class="avatar-circle">
            <img src="{{ asset('images/dashboard/icons/icon_orang.png') }}" alt="Profile">
        </div>
        <div class="profile-info">
            <h4>{{ $user->username ?? $user->name }}</h4>
            <p>{{ ucfirst($role) }}</p>
        </div>
    </div>

    {{-- ── NAVIGASI ── --}}
    <nav class="sidebar-nav">
        <ul>

            {{-- ===== MENU TENTOR ===== --}}
            @if($role == 'tentor')
                <li>
                    <a href="{{ route('tentor.dashboard') }}" class="nav-link-custom {{ request()->routeIs('tentor.dashboard') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_dashboard.png') }}" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('tentor.presensi') }}" class="nav-link-custom {{ request()->routeIs('tentor.presensi') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_presensi.png') }}" class="sidebar-icon"> Presensi
                    </a>
                </li>
                <li>
                    <a href="{{ route('tentor.riwayat-presensi') }}" class="nav-link-custom {{ request()->routeIs('tentor.riwayat-presensi') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>
            @endif

            {{-- ===== MENU ADMIN ===== --}}
            @if($role == 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_dashboard.png') }}" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.data-tentor') }}" class="nav-link-custom {{ request()->routeIs('admin.data-tentor*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_datatentor.png') }}" class="sidebar-icon"> Data Tentor
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kelola-murid') }}" class="nav-link-custom {{ request()->routeIs('admin.kelola-murid*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_kelolamurid.png') }}" class="sidebar-icon"> Kelola Murid
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.harga-paket') }}" class="nav-link-custom {{ request()->routeIs('admin.harga-paket*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> Harga Paket
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.riwayat-presensi') }}" class="nav-link-custom {{ request()->routeIs('admin.riwayat-presensi*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pembayaran') }}" class="nav-link-custom {{ request()->routeIs('admin.pembayaran*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_pembayaran.png') }}" class="sidebar-icon"> Pembayaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.rekap-gaji') }}" class="nav-link-custom {{ request()->routeIs('admin.rekap-gaji*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_rekapgaji.png') }}" class="sidebar-icon"> Rekap Gaji
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.laporan-keuangan') }}" class="nav-link-custom {{ request()->routeIs('admin.laporan-keuangan*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_laporankeuangan.png') }}" class="sidebar-icon"> Laporan Keuangan
                    </a>
                </li>
            @endif

            {{-- ===== MENU SUPERADMIN ===== --}}
            @if($role == 'superadmin')
                <li>
                    <a href="{{ route('superadmin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('superadmin.dashboard') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_dashboard.png') }}" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.kelola-admin') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-admin*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_orang.png') }}" class="sidebar-icon"> Kelola Admin
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.kelola-tentor') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-tentor*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_datatentor.png') }}" class="sidebar-icon"> Kelola Tentor
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.kelola-murid') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-murid*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_kelolamurid.png') }}" class="sidebar-icon"> Kelola Murid
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.harga-paket') }}" class="nav-link-custom {{ request()->routeIs('superadmin.harga-paket*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> Harga Paket
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.riwayat-presensi') }}" class="nav-link-custom {{ request()->routeIs('superadmin.riwayat-presensi*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.pembayaran') }}" class="nav-link-custom {{ request()->routeIs('superadmin.pembayaran*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_pembayaran.png') }}" class="sidebar-icon"> Pembayaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.rekap-gaji') }}" class="nav-link-custom {{ request()->routeIs('superadmin.rekap-gaji*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_rekapgaji.png') }}" class="sidebar-icon"> Rekap Gaji
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.laporan-keuangan') }}" class="nav-link-custom {{ request()->routeIs('superadmin.laporan-keuangan*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_laporankeuangan.png') }}" class="sidebar-icon"> Laporan Keuangan
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    {{-- ── LOGOUT ── --}}
    <div class="sidebar-footer">
        <button type="button" class="logout-btn" onclick="bukaModalLogout()">
            <img src="{{ asset('images/dashboard/icons/icon_logout.png') }}" class="sidebar-icon"> Logout
        </button>
    </div>

</aside>