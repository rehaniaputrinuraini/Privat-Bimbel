<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Bimbel Privat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { overflow: hidden; font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body style="background-color: #F9FAFB;">
    <div class="h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="flex items-center justify-center gap-3 mb-6">
                <img src="<?php echo e(asset('images/logo/foto_logo.png')); ?>" alt="Logo" class="h-10 w-auto">
                <h2 class="text-2xl font-bold" style="color: #4D0B87;">Bimbel Privat</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
                <h3 class="text-xl font-bold text-center mb-1" style="color: #4D0B87;">Reset Kata Sandi</h3>
                <p class="text-center text-gray-500 text-sm mb-6">Masukkan Password Baru Anda</p>

                
                <form method="POST" action="<?php echo e(route('password.update')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="<?php echo e(session('otp_email')); ?>" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm outline-none"
                               readonly required>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="password" 
                               placeholder="Masukkan Password Baru"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required autofocus>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" 
                               placeholder="Ulangi Password Baru"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none text-sm"
                               required>
                    </div>

                    <button type="submit" 
                            class="w-full text-white py-3 rounded-lg font-bold hover:opacity-90 transition shadow-md active:scale-95"
                            style="background-color: #4D0B87;">
                        SIMPAN
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="<?php echo e(route('login')); ?>" class="text-xs font-semibold text-[#4D0B87] hover:underline">
                        Batal dan Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>