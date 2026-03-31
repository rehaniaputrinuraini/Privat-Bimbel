<aside class="sidebar">
    <!-- Profile Section -->
    <div class="sidebar-profile">
        <div class="profile-avatar">
            <img src="{{ asset('images/dashboard/avatar/default-avatar.png') }}" alt="Profile">
        </div>
        <div class="profile-info">
            <h4>Maria Putri</h4>
            <span>{{ $role ?? 'Tentor' }}</span>
        </div>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <!-- Menu SUPERADMIN -->
            <li class="menu-superadmin">
                <a href="{{ url('/dashboard/superadmin') }}">
                    <span class="menu-icon">📊</span> Dashboard
                </a>
            </li>
            <li class="menu-superadmin">
                <a href="{{ url('/dashboard/superadmin/kelola-admin') }}">
                    <span class="menu-icon">👥</span> Kelola Admin
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/kelola-tentor') }}">
                    <span class="menu-icon">👨‍🏫</span> Kelola Tentor
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/kelola-murid') }}">
                    <span class="menu-icon">👩‍🎓</span> Kelola Murid
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/harga-paket') }}">
                    <span class="menu-icon">💰</span> Harga Paket
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/riwayat-presensi') }}">
                    <span class="menu-icon">📋</span> Riwayat Presensi
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/pembayaran') }}">
                    <span class="menu-icon">💳</span> Pembayaran
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/rekap-gaji') }}">
                    <span class="menu-icon">💰</span> Rekap Gaji
                </a>
            </li>
            <li class="menu-superadmin menu-admin">
                <a href="{{ url('/dashboard/laporan-keuangan') }}">
                    <span class="menu-icon">📊</span> Laporan Keuangan
                </a>
            </li>

            <!-- Menu TENTOR -->
            <li class="menu-tentor">
                <a href="{{ url('/dashboard/tentor') }}">
                    <span class="menu-icon">📊</span> Dashboard
                </a>
            </li>
            <li class="menu-tentor">
                <a href="{{ url('/dashboard/tentor/presensi') }}">
                    <span class="menu-icon">📝</span> Presensi
                </a>
            </li>
            <li class="menu-tentor">
                <a href="{{ url('/dashboard/tentor/riwayat-presensi') }}">
                    <span class="menu-icon">📋</span> Riwayat Presensi
                </a>
            </li>

            <!-- Logout untuk semua role -->
            <li class="logout-menu">
                <a href="{{ url('/logout') }}">
                    <span class="menu-icon">🚪</span> Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>