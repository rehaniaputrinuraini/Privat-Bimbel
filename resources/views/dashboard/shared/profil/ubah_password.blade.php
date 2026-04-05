{{-- =============================================
     Dashboard Shared - Ubah Kata Sandi
     File: resources/views/dashboard/shared/ubah-kata-sandi.blade.php
============================================= --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kata Sandi - Bimbel Privat</title>
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
            
            <div class="flex items-center justify-center gap-3 mb-4">
                <img src="/images/logo/foto_logo.png" alt="Logo Bimbel Privat" class="h-10 w-auto">
                <h2 class="text-2xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 w-full border border-gray-200">
                
                <div class="text-center mb-5">
                    <h3 class="text-xl font-semibold text-gray-900">Ubah Kata Sandi</h3>
                    <p class="text-gray-500 text-sm">Masukkan Password Lama dan Password Baru Anda</p>
                </div>

               <form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT') {{-- Ini sudah benar --}}

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded-lg mb-3 text-xs border border-red-200">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
        </div>
    @endif

    {{-- Gunakan name="password" agar sesuai dengan validasi default Laravel jika perlu --}}
    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
        <input type="password" name="current_password" 
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
               required autofocus>
    </div>

    <div class="mb-3">
        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
        <input type="password" name="password" {{-- Diubah jadi 'password' agar standar --}}
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
               required>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" {{-- Diubah jadi 'password_confirmation' --}}
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
               required>
    </div>

    <button type="submit" 
            class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition flex items-center justify-center gap-2 text-sm shadow-md active:scale-[0.98]"
            style="background-color: #4D0B87;">
        Ubah Password
    </button>
</form>

                <div class="mt-4 text-center">
                    <a href="{{ route('profile.index') }}" class="text-xs text-[#4D0B87] hover:underline">
                        Kembali ke Profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>