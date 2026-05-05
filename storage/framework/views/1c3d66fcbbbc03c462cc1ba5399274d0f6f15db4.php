<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Bimbel Privat'); ?></title>
    
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Pacifico&display=swap" rel="stylesheet">
    
    
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">

    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    
    <style>
        /* Alert Toast Notification */
        .alert-toast {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 99999;
            min-width: 320px;
            max-width: 450px;
            padding: 16px 20px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: slideInRight 0.3s ease forwards;
            cursor: pointer;
        }
        
        .alert-toast.alert-danger {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
            color: white;
            border-left: 4px solid #7F1D1D;
        }
        
        .alert-toast.alert-success {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            border-left: 4px solid #064E3B;
        }
        
        .alert-toast i {
            font-size: 20px;
        }
        
        .alert-toast .close-toast {
            margin-left: auto;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        
        .alert-toast .close-toast:hover {
            opacity: 1;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                visibility: hidden;
            }
        }
        
        .alert-toast.fade-out {
            animation: fadeOut 0.5s ease forwards;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="main-container">
        <?php echo $__env->make('components.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="content-wrapper">
            
            <?php if(session('error')): ?>
                <div class="alert-toast alert-danger" id="alertToast">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo e(session('error')); ?></span>
                    <i class="fas fa-times close-toast" onclick="closeToast(this)"></i>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="alert-toast alert-success" id="alertToast">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo e(session('success')); ?></span>
                    <i class="fas fa-times close-toast" onclick="closeToast(this)"></i>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    
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

                <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin: 0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="width: 100%; padding: 15px; border-radius: 15px; border: none; background: #4D0B87; color: white; font-weight: 600; cursor: pointer; font-size: 16px; transition: 0.3s;">
                        Iya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    
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
            const modal = document.getElementById('modalLogout');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function tutupModalLogout() {
            const modal = document.getElementById('modalLogout');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        window.addEventListener('click', function(event) {
            let modal = document.getElementById('modalLogout');
            if (event.target == modal) {
                tutupModalLogout();
            }
        });

        // 4. Fungsi Close Toast Alert
        function closeToast(element) {
            const toast = element.closest('.alert-toast');
            if (toast) {
                toast.classList.add('fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }
        }

        // 5. Auto close toast setelah 5 detik
        setTimeout(() => {
            const toasts = document.querySelectorAll('.alert-toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    if (toast && toast.parentNode) {
                        toast.classList.add('fade-out');
                        setTimeout(() => {
                            if (toast && toast.parentNode) toast.remove();
                        }, 500);
                    }
                }, 5000);
            });
        }, 1000);

        // 6. FIX: LOCK SIDEBAR SCROLL POSITION
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarElement = document.getElementById('sidebar');
            
            if (sidebarElement) {
                const sidebarScrollPos = localStorage.getItem('sidebar_scroll');
                if (sidebarScrollPos) {
                    setTimeout(() => {
                        sidebarElement.scrollTo({
                            top: parseInt(sidebarScrollPos),
                            behavior: 'instant'
                        });
                    }, 50); 
                }

                sidebarElement.addEventListener('scroll', function() {
                    localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
                });

                const sidebarLinks = sidebarElement.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
                    });
                });
            }

            const logoutBtn = document.querySelector('.logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function() {
                    localStorage.removeItem('sidebar_scroll');
                });
            }
        });

        // 7. SIMPAN URL SAAT INI KE SESSION (untuk redirect balik)
        document.addEventListener('DOMContentLoaded', function() {
            fetch('<?php echo e(route("store.last.url")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ url: window.location.href })
            }).catch(err => console.log('Error saving URL:', err));
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/layouts/app.blade.php ENDPATH**/ ?>