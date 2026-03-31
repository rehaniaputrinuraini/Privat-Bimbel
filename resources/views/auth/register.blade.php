<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivasi Akun - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body style="background-color: white;">
    <div class="h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg">
            
            <!-- Header: Logo + Bimbel Privat 1 baris -->
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="/images/foto_logo.png" alt="Logo Bimbel Privat" class="h-10 w-auto">
                <h2 class="text-2xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <!-- Kontainer Form -->
            <div class="bg-white rounded-2xl shadow-lg p-6 w-full border border-gray-200">
                
                <!-- Header Form -->
                <div class="text-center mb-5">
                    <h3 class="text-xl font-semibold text-gray-900">Aktivasi Akun</h3>
                    <p class="text-gray-500 text-sm">Buat Akun Baru</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-2 rounded-lg mb-3 text-xs">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               placeholder="Masukkan Email"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required autofocus>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" 
                               placeholder="Masukkan Username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" 
                               placeholder="Masukkan Password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required>
                    </div>

                    <!-- Tombol Aktivasi dengan Icon Pesawat -->
                    <button type="submit" 
                            class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition flex items-center justify-center gap-2 text-sm"
                            style="background-color: #4D0B87;">
                        <img src="/images/aktivasi/icon_kirim.png" alt="Kirim" class="h-4 w-auto">
                        Aktivasi
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-xs text-[#4D0B87] hover:underline">
                        Sudah aktivasi akun?
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>