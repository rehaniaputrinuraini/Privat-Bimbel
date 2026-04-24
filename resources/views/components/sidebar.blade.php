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

                {{-- MASTER DATA DENGAN SUB MENU (ADMIN) --}}
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle {{ request()->is('*master-data*') ? 'nav-active' : '' }}" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> 
                            Master Data
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*master-data*') ? 'block' : 'none' }};">
                        <li>
                            <a href="{{ route('admin.master-data.harga-paket') }}" class="submenu-link {{ request()->routeIs('admin.master-data.harga-paket*') ? 'sub-active' : '' }}">
                                <i class="fas fa-tag submenu-icon"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.kelas') }}" class="submenu-link {{ request()->routeIs('admin.master-data.kelas*') ? 'sub-active' : '' }}">
                                <i class="fas fa-users submenu-icon"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.ruang') }}" class="submenu-link {{ request()->routeIs('admin.master-data.ruang*') ? 'sub-active' : '' }}">
                                <i class="fas fa-door-open submenu-icon"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.periode') }}" class="submenu-link {{ request()->routeIs('admin.master-data.periode*') ? 'sub-active' : '' }}">
                                <i class="fas fa-calendar-alt submenu-icon"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.kelola-presensi') }}" class="nav-link-custom {{ request()->routeIs('admin.kelola-presensi*') ? 'nav-active' : '' }}">
                        <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>

                {{-- PEMBAYARAN DENGAN SUB MENU (ADMIN) --}}
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle {{ request()->is('*pembayaran*') ? 'nav-active' : '' }}" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="{{ asset('images/dashboard/icons/icon_pembayaran.png') }}" class="sidebar-icon"> 
                            Pembayaran
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*pembayaran*') ? 'block' : 'none' }};">
                        <li>
                            <a href="{{ route('admin.pembayaran.tagihan') }}" class="submenu-link {{ request()->routeIs('admin.pembayaran.tagihan*') ? 'sub-active' : '' }}">
                                <i class="fas fa-file-invoice submenu-icon"></i> Tagihan Murid
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembayaran.riwayat') }}" class="submenu-link {{ request()->routeIs('admin.pembayaran.riwayat*') ? 'sub-active' : '' }}">
                                <i class="fas fa-history submenu-icon"></i> Riwayat Pembayaran
                            </a>
                        </li>
                    </ul>
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

                {{-- MASTER DATA DENGAN SUB MENU (SUPERADMIN) --}}
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle {{ request()->is('*master-data*') ? 'nav-active' : '' }}" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> 
                            Master Data
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*master-data*') ? 'block' : 'none' }};">
                        <li>
                            <a href="{{ route('superadmin.master-data.harga-paket') }}" class="submenu-link {{ request()->routeIs('superadmin.master-data.harga-paket*') ? 'sub-active' : '' }}">
                                <i class="fas fa-tag submenu-icon"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.kelas') }}" class="submenu-link {{ request()->routeIs('superadmin.master-data.kelas*') ? 'sub-active' : '' }}">
                                <i class="fas fa-users submenu-icon"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.ruang') }}" class="submenu-link {{ request()->routeIs('superadmin.master-data.ruang*') ? 'sub-active' : '' }}">
                                <i class="fas fa-door-open submenu-icon"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.periode') }}" class="submenu-link {{ request()->routeIs('superadmin.master-data.periode*') ? 'sub-active' : '' }}">
                                <i class="fas fa-calendar-alt submenu-icon"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

               <li>
                    <a href="{{ route('superadmin.kelola-presensi') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-presensi*') ? 'nav-active' : '' }}">
                       <img src="{{ asset('images/dashboard/icons/icon_riwayatpresensi.png') }}" class="sidebar-icon"> Riwayat Presensi
                     </a>
                </li>

                {{-- PEMBAYARAN DENGAN SUB MENU (SUPERADMIN) --}}
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle {{ request()->is('*pembayaran*') ? 'nav-active' : '' }}" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="{{ asset('images/dashboard/icons/icon_pembayaran.png') }}" class="sidebar-icon"> 
                            Pembayaran
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*pembayaran*') ? 'block' : 'none' }};">
                        <li>
                            <a href="{{ route('superadmin.pembayaran.tagihan') }}" class="submenu-link {{ request()->routeIs('superadmin.pembayaran.tagihan*') ? 'sub-active' : '' }}">
                                <i class="fas fa-file-invoice submenu-icon"></i> Tagihan Murid
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.pembayaran.riwayat') }}" class="submenu-link {{ request()->routeIs('superadmin.pembayaran.riwayat*') ? 'sub-active' : '' }}">
                                <i class="fas fa-history submenu-icon"></i> Riwayat Pembayaran
                            </a>
                        </li>
                    </ul>
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

{{-- SCRIPT TOGGLE SUBMENU --}}
<script>
    function toggleSubmenu(element) {
        const submenu = element.nextElementSibling;
        const arrow = element.querySelector('.submenu-arrow');
        
        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
            arrow.style.transform = 'rotate(180deg)';
        } else {
            submenu.style.display = 'none';
            arrow.style.transform = 'rotate(0deg)';
        }
    }
</script>

{{-- SCRIPT UNTUK LOCK SIDEBAR SCROLL POSITION --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarElement = document.getElementById('sidebar');
        
        if (sidebarElement) {
            const sidebarScrollPos = localStorage.getItem('sidebar_scroll');
            if (sidebarScrollPos) {
                setTimeout(() => {
                    sidebarElement.scrollTop = parseInt(sidebarScrollPos);
                }, 50);
            }

            sidebarElement.addEventListener('scroll', function() {
                localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
            });

            const sidebarLinks = sidebarElement.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
                });
            });
        }
    });
</script>