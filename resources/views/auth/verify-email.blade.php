<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>
<body style="background-color: white;">
    <div class="h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Header: Logo + Bimbel Privat 1 baris -->
            <div class="flex items-center justify-center gap-3 mb-6">
                <img src="/images/logo/foto_logo.png" alt="Logo" class="h-10 w-auto">
                <h2 class="text-2xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <!-- Form Verifikasi -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-center mb-1" style="color: #4D0B87;">Pemulihan Akun</h3>
                <p class="text-center text-gray-500 text-sm mb-4">
                    Masukkan kode verifikasi yang telah dikirim lewat email.
                </p>

                <form method="POST" action="{{ route('verification.verify') }}">
                    @csrf

                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 p-2 rounded-lg mb-3 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 p-2 rounded-lg mb-3 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Verifikasi</label>
                        <input type="text" name="code" 
                               placeholder="Masukkan kode verifikasi"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required autofocus>
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition text-sm"
                            style="background-color: #4D0B87;">
                        Kirim
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-xs text-[#4D0B87] hover:underline">
                        Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>