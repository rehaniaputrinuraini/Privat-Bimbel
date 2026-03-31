<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: white;">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            
            <!-- Header: Logo + Bimbel Privat 1 baris (di luar kontainer) -->
            <div class="flex items-center justify-center gap-3 mb-8">
                <img src="/images/foto_logo.png" alt="Logo Bimbel Privat" class="h-12 w-auto">
                <h2 class="text-3xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <!-- Kontainer Form (lebih lebar) -->
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-10 w-full border border-gray-200">
                
                <!-- Header Form -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-semibold text-gray-900">Pemulihan Akun</h3>
                    <p class="text-gray-500 mt-2">
                        Masukkan email akun Anda yang sudah terdaftar kemudian ikuti langkah pada email yang Kami kirimkan.
                    </p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               placeholder="Masukkan email yang sudah terdaftar"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none"
                               required autofocus>
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-3 rounded-lg font-semibold hover:opacity-90 transition"
                            style="background-color: #4D0B87;">
                        KIRIM
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-[#4D0B87] hover:underline">
                        Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>