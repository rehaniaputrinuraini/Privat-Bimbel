<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background-color: #F9FAFB;">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl">
            
            <div class="flex items-center justify-center gap-3 mb-8">
                <img src="<?php echo e(asset('images/logo/foto_logo.png')); ?>" alt="Logo Bimbel Privat" class="h-12 w-auto">
                <h2 class="text-3xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 w-full border border-gray-100">
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">Pemulihan Akun</h3>
                    <p class="text-gray-500 mt-3 leading-relaxed">
                        Masukkan email Anda untuk menerima <span class="font-semibold text-[#4D0B87]">6 digit kode OTP</span>. 
                        Pastikan email Anda aktif untuk memulihkan kata sandi.
                    </p>
                </div>

                
                <form method="POST" action="<?php echo e(route('otp.send')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 text-sm border border-red-100">
                            <i class="fas fa-exclamation-circle mr-2"></i> <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('status')): ?>
                        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 text-sm border border-green-100">
                            <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>" 
                               placeholder="contoh: user@gmail.com"
                               class="w-full px-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none transition-all"
                               required autofocus>
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-4 rounded-xl font-bold text-lg hover:opacity-90 transition-all shadow-lg active:scale-[0.98]"
                            style="background-color: #4D0B87; box-shadow: 0 10px 15px -3px rgba(77, 11, 135, 0.3);">
                        KIRIM
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold text-[#4D0B87] hover:text-purple-800 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>