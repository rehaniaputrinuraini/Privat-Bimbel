<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bimbel Privat</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body style="background-color: #F3E8FF;">

    
    <a href="<?php echo e(route('companyprofile')); ?>" 
       class="fixed top-6 left-6 z-[100] flex items-center justify-center w-12 h-12 bg-white/80 backdrop-blur-md rounded-full shadow-lg text-[#4D0B87] transition-all duration-300 hover:scale-110 hover:bg-white group"
       title="Kembali ke Company Profile">
        <i class="fas fa-arrow-left text-xl transition-transform group-hover:-translate-x-1"></i>
    </a>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-lg overflow-hidden max-w-5xl w-full">
            
            
            <div class="w-full md:w-1/2 relative bg-cover bg-center" style="background-image: url('<?php echo e(asset('images/auth/foto_login.png')); ?>'); min-height: 500px;">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white p-8">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Selamat Datang</h2>
                    <p class="text-lg md:text-xl mb-4 font-light">Bimbel Privat - <span class="font-semibold text-purple-200">Prestasi Lebih Baik</span></p>
                    <p class="text-sm md:text-base opacity-80">Masuk untuk melanjutkan pembelajaran Anda</p>
                </div>
            </div>

            
            <div class="w-full md:w-1/2 p-8 md:p-10">
                <div class="mb-6">
                    <h3 class="text-2xl md:text-3xl font-bold mb-2" style="color: #4D0B87;">Masuk</h3>
                    <p class="text-sm text-gray-500">Silahkan masuk ke akun Anda</p>
                </div>

                <form method="POST" action="<?php echo e(route('login.post')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if($errors->any()): ?>
                        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm border-l-4 border-red-500">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email / Username</label>
                        <input type="text" name="email" value="<?php echo e(old('email')); ?>" placeholder="Masukkan Email atau Username"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none transition-all" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="Masukkan Password"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#4D0B87] focus:border-[#4D0B87] outline-none transition-all pr-12" required>
                            <button type="button" id="togglePassword" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-[#4D0B87] transition-colors">
                                <i class="fas fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-end items-center mb-6">
                        <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-semibold text-[#4D0B87] hover:underline decoration-2">Lupa Kata Sandi?</a>
                    </div>

                    <button type="submit" class="w-full text-white py-3 rounded-lg font-bold hover:opacity-90 shadow-md transition-all active:scale-95"
                            style="background-color: #4D0B87;">
                        Masuk
                    </button>
                </form>

                
                <div class="mt-8 text-center">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-400">atau login dengan</span>
                        </div>
                    </div>
                    
                    
                    <a href="<?php echo e(route('google.login')); ?>" 
                       class="mt-6 w-full border rounded-lg py-2.5 flex items-center justify-center gap-2 transition hover:bg-gray-50 border-gray-300 shadow-sm"
                       style="background-color: #4953A4; border-color: #4953A4; text-decoration: none;">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#FFFFFF" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#FFFFFF" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FFFFFF" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#FFFFFF" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="text-white font-medium">Google</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle tipe input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon mata
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/auth/login.blade.php ENDPATH**/ ?>