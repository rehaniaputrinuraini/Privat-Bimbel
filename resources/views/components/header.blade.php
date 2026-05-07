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
                @php
                    $user = Auth::user();
                @endphp
                @if($user->foto)
                    <img src="{{ asset('storage/' . $user->foto) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <img src="{{ asset('images/dashboard/icons/icon_orang.png') }}" alt="Avatar">
                @endif
            </div>
        </a>
    </div>
</header>