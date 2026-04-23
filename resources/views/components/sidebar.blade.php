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
                        <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> Master Data
                        <i class="fas fa-chevron-down submenu-arrow" style="float: right; margin-top: 3px;"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*master-data*') ? 'block' : 'none' }}; list-style: none; padding-left: 30px; background: rgba(0,0,0,0.03);">
                        <li>
                            <a href="{{ route('admin.master-data.harga-paket') }}" class="nav-link-custom {{ request()->routeIs('admin.master-data.harga-paket*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.kelas') }}" class="nav-link-custom {{ request()->routeIs('admin.master-data.kelas*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.ruang') }}" class="nav-link-custom {{ request()->routeIs('admin.master-data.ruang*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.periode') }}" class="nav-link-custom {{ request()->routeIs('admin.master-data.periode*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.kelola-presensi') }}" class="nav-link-custom {{ request()->routeIs('admin.kelola-presensi*') ? 'nav-active' : '' }}">
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

                {{-- MASTER DATA DENGAN SUB MENU (SUPERADMIN) --}}
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle {{ request()->is('*master-data*') ? 'nav-active' : '' }}" onclick="toggleSubmenu(this)">
                        <img src="{{ asset('images/dashboard/icons/icon_hargapaket.png') }}" class="sidebar-icon"> Master Data
                        <i class="fas fa-chevron-down submenu-arrow" style="float: right; margin-top: 3px;"></i>
                    </a>
                    <ul class="submenu-list" style="display: {{ request()->is('*master-data*') ? 'block' : 'none' }}; list-style: none; padding-left: 30px; background: rgba(0,0,0,0.03);">
                        <li>
                            <a href="{{ route('superadmin.master-data.harga-paket') }}" class="nav-link-custom {{ request()->routeIs('superadmin.master-data.harga-paket*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.kelas') }}" class="nav-link-custom {{ request()->routeIs('superadmin.master-data.kelas*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.ruang') }}" class="nav-link-custom {{ request()->routeIs('superadmin.master-data.ruang*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.master-data.periode') }}" class="nav-link-custom {{ request()->routeIs('superadmin.master-data.periode*') ? 'nav-active' : '' }}" style="font-size: 13px; padding: 8px 15px;">
                                <i class="far fa-circle" style="font-size: 8px; margin-right: 8px;"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

               <li>
                    <a href="{{ route('superadmin.kelola-presensi') }}" class="nav-link-custom {{ request()->routeIs('superadmin.kelola-presensi*') ? 'nav-active' : '' }}">
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