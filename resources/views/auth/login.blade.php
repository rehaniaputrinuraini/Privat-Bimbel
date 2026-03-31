<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: #F3E8FF;">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden max-w-5xl w-full">
            
            <!-- KIRI: Full Foto dengan Teks Overlay -->
            <div class="w-full md:w-1/2 relative bg-cover bg-center" style="background-image: url('/images/foto_login.png'); min-height: 500px;">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white p-8">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang</h2>
                    <p class="text-lg md:text-xl mb-4">Bimbel Privat - Prestasi Lebih Baik</p>
                    <p class="text-sm md:text-base">Masuk untuk melanjutkan pembelajaran Anda</p>
                </div>
            </div>

            <!-- KANAN: Form Login -->
            <div class="w-full md:w-1/2 p-8 md:p-10">
                <div class="mb-6">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2" style="color: #4D0B87;">Masuk & Aktivasi</h3>
                    <p class="text-sm text-gray-500">Silahkan masuk ke akun Anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email/Akun Pengguna</label>
                        <input type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan Email/ID/Username"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none" required>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <a href="{{ route('register') }}" class="text-sm text-[#4D0B87] hover:underline">Aktivasi Akun</a>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#4D0B87] hover:underline">Lupa Kata Sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition"
                            style="background-color: #4D0B87;">
                        Masuk
                    </button>
                </form>

                <!-- "atau login dengan" di tengah -->
                <div class="mt-6 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">atau login dengan</span>
                        </div>
                    </div>
                    
                    <button onclick="alert('Fitur Google Login akan segera hadir')"
                            class="mt-4 w-full border rounded-lg py-2 flex items-center justify-center gap-2 transition hover:opacity-90"
                            style="background-color: #4953A4; border-color: #4953A4;">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#FFFFFF" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#FFFFFF" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FFFFFF" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#FFFFFF" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-white">Google</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>