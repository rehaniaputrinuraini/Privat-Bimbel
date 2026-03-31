<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Bimbel Privat</title>
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
                <img src="/images/foto_logo.png" alt="Logo" class="h-10 w-auto">
                <h2 class="text-2xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <!-- Form Reset Password -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-center mb-1" style="color: #4D0B87;">Reset Kata Sandi</h3>
                <p class="text-center text-gray-500 text-sm mb-4">Masukkan Password Baru Anda</p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm"
                               readonly required>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" 
                               placeholder="Masukkan Password Lama"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required>
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" 
                               placeholder="Masukkan Password Baru"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-2 rounded-lg font-semibold hover:opacity-90 transition text-sm"
                            style="background-color: #4D0B87;">
                        Reset Password
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