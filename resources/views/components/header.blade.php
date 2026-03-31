<header class="header">
    <div class="header-left">
        <i class="fas fa-bars burger-btn" id="toggle-sidebar"></i>
        <img src="{{ asset('images/logo/foto_logo.png') }}" alt="Logo" class="logo-img">
    </div>
    <div class="header-center">
        <div class="tagline">Prestasi Lebih Baik</div>
    </div>
    <div class="header-right">
        <a href="{{ route('profile.index') }}" class="profile-link">
            <div class="user-avatar-top">
                <img src="{{ asset('images/icon_orang.png') }}" alt="Avatar">
            </div>
        </a>
    </div>
</header>