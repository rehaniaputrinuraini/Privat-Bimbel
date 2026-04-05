<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bimbel Privat')</title>

    {{-- Font Awesome & Google Fonts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    
    {{-- CSS Utama Dashboard --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{-- Library AOS untuk Animasi --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @stack('styles')
</head>
<body>
    @include('components.header')

    <div class="main-container">
        @include('components.sidebar')

        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>

    {{-- =============================================
         MODAL LOGOUT GLOBAL
    ============================================= --}}
    <div id="modalLogout" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 40px; border-radius: 25px; width: 450px; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.3); font-family: 'Poppins', sans-serif;">
            
            <div style="color: #EF4444; font-size: 60px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle"></i>
            </div>

            <h2 style="margin: 0; font-size: 24px; color: #111827; font-weight: 700;">Konfirmasi Keluar</h2>
            <p style="color: #6B7280; font-size: 16px; margin-top: 10px; margin-bottom: 30px;">Apakah Anda yakin ingin keluar dari akun ini?</p>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <button onclick="tutupModalLogout()" style="padding: 15px; border-radius: 15px; border: 1.5px solid #E5E7EB; background: white; color: #374151; font-weight: 600; cursor: pointer; font-size: 16px; transition: 0.3s;">
                    Tidak
                </button>

                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 15px; border-radius: 15px; border: none; background: #4D0B87; color: white; font-weight: 600; cursor: pointer; font-size: 16px; transition: 0.3s;">
                        Iya
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPTS UTAMA --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // 1. Inisialisasi Animasi AOS
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // 2. Fungsi Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggle-sidebar');
            const sidebar = document.querySelector('.sidebar');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                });
            }
        });

        // 3. Fungsi Modal Logout
        function bukaModalLogout() {
            document.getElementById('modalLogout').style.display = 'flex';
        }

        function tutupModalLogout() {
            document.getElementById('modalLogout').style.display = 'none';
        }

        window.addEventListener('click', function(event) {
            let modal = document.getElementById('modalLogout');
            if (event.target == modal) {
                tutupModalLogout();
            }
        });

        // 4. FIX: LOCK SIDEBAR SCROLL POSITION (VERSI LEBIH KUAT)
document.addEventListener("DOMContentLoaded", function() {
    const sidebarElement = document.getElementById('sidebar');
    
    if (sidebarElement) {
        // A. AMBIL POSISI SAAT HALAMAN DIBUKA
        const sidebarScrollPos = localStorage.getItem('sidebar_scroll');
        if (sidebarScrollPos) {
            // Beri sedikit delay agar browser selesai merender layout
            setTimeout(() => {
                sidebarElement.scrollTo({
                    top: parseInt(sidebarScrollPos),
                    behavior: 'instant' // Langsung ke posisi tanpa animasi agar tidak terlihat melompat
                });
            }, 50); 
        }

        // B. SIMPAN POSISI SETIAP KALI USER SCROLL
        sidebarElement.addEventListener('scroll', function() {
            localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
        });

        // C. SIMPAN POSISI SAAT USER KLIK LINK (BACKUP)
        const sidebarLinks = sidebarElement.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
            });
        });
    }

    // D. RESET POSISI SAAT LOGOUT
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            localStorage.removeItem('sidebar_scroll');
        });
    }
});
    </script>

    @stack('scripts')
</body>
</html>