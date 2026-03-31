<header class="header">
    <div class="header-left">
        <button class="menu-toggle" id="menuToggle">
            ☰
        </button>
        <div class="logo">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Logo">
        </div>
        <div class="header-text">
            <h2>Prestasi lebih baik</h2>
        </div>
    </div>

    <div class="header-right">
        <a href="{{ url('/dashboard/profil') }}" class="profile-link">
            <div class="user-avatar">
                <img src="{{ asset('images/dashboard/avatar/default-avatar.png') }}" alt="Avatar">
            </div>
        </a>
    </div>
</header>