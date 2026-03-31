<aside class="sidebar">
    <div class="sidebar-profile">
        <div class="avatar-circle">
            <i class="fas fa-user"></i>
        </div>
        <div class="profile-text">
            <h3 class="user-name">{{ auth()->user()->name ?? 'Maria Putri' }}</h3>
            <p class="user-role">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</p>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> <span>Dashboard</span>
        </a>

        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
            <a href="/admin/kelola-tentor" class="nav-item {{ request()->is('*kelola-tentor*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate"></i> <span>Data Tentor</span>
            </a>
            <a href="/admin/kelola-murid" class="nav-item {{ request()->is('*kelola-murid*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Kelola Murid</span>
            </a>
            <a href="/admin/harga-paket" class="nav-item {{ request()->is('*harga-paket*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> <span>Harga Paket</span>
            </a>
            <a href="/admin/pembayaran" class="nav-item {{ request()->is('*pembayaran*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i> <span>Pembayaran</span>
            </a>
            <a href="/admin/rekap-gaji" class="nav-item {{ request()->is('*rekap-gaji*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> <span>Rekap Gaji</span>
            </a>
        @endif

        @if(auth()->user()->role == 'tentor')
            <a href="/tentor/presensi" class="nav-item {{ request()->is('*presensi*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> <span>Presensi</span>
            </a>
            <a href="/tentor/riwayat" class="nav-item {{ request()->is('*riwayat*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> <span>Riwayat Mengajar</span>
            </a>
        @endif

        <div class="sidebar-bottom">
            <a href="/logout" class="nav-item logout">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>