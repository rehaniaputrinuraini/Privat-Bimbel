

<aside class="sidebar" id="sidebar" style="overflow-y: auto; scroll-behavior: smooth;">
    <?php
        $user = Auth::user();
        $role = $user->peran ?? 'guest';
    ?>

    
    <div class="sidebar-profile">
        <div class="avatar-circle">
            <img src="<?php echo e(asset('images/dashboard/icons/icon_orang.png')); ?>" alt="Profile">
        </div>
        <div class="profile-info">
            <h4><?php echo e($user->username ?? $user->name); ?></h4>
            <p><?php echo e(ucfirst($role)); ?></p>
        </div>
    </div>

    
    <nav class="sidebar-nav">
        <ul>

            
            <?php if($role == 'tentor'): ?>
                <li>
                    <a href="<?php echo e(route('tentor.dashboard')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('tentor.dashboard') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_dashboard.png')); ?>" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('tentor.presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('tentor.presensi') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_presensi.png')); ?>" class="sidebar-icon"> Presensi
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('tentor.riwayat-presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('tentor.riwayat-presensi') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_riwayatpresensi.png')); ?>" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>
            <?php endif; ?>

            
            <?php if($role == 'admin'): ?>
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.dashboard') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_dashboard.png')); ?>" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.data-tentor')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.data-tentor*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_datatentor.png')); ?>" class="sidebar-icon"> Data Tentor
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.kelola-murid')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.kelola-murid*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_kelolamurid.png')); ?>" class="sidebar-icon"> Kelola Murid
                    </a>
                </li>
                <li>
                    
                    <a href="<?php echo e(route('admin.master-data')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.master-data*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_hargapaket.png')); ?>" class="sidebar-icon"> Master Data
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.kelola-presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.kelola-presensi*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_riwayatpresensi.png')); ?>" class="sidebar-icon"> Riwayat Presensi
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.pembayaran')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.pembayaran*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_pembayaran.png')); ?>" class="sidebar-icon"> Pembayaran
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.rekap-gaji')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.rekap-gaji*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_rekapgaji.png')); ?>" class="sidebar-icon"> Rekap Gaji
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.laporan-keuangan')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.laporan-keuangan*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_laporankeuangan.png')); ?>" class="sidebar-icon"> Laporan Keuangan
                    </a>
                </li>
            <?php endif; ?>

            
            <?php if($role == 'superadmin'): ?>
                <li>
                    <a href="<?php echo e(route('superadmin.dashboard')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.dashboard') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_dashboard.png')); ?>" class="sidebar-icon"> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.kelola-admin')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.kelola-admin*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_orang.png')); ?>" class="sidebar-icon"> Kelola Admin
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.kelola-tentor')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.kelola-tentor*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_datatentor.png')); ?>" class="sidebar-icon"> Kelola Tentor
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.kelola-murid')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.kelola-murid*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_kelolamurid.png')); ?>" class="sidebar-icon"> Kelola Murid
                    </a>
                </li>
                <li>
                    
                    <a href="<?php echo e(route('superadmin.master-data')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.master-data*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_hargapaket.png')); ?>" class="sidebar-icon"> Master Data
                    </a>
                </li>
               <li>
                    <a href="<?php echo e(route('superadmin.kelola-presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.kelola-presensi*') ? 'nav-active' : ''); ?>">
                       <img src="<?php echo e(asset('images/dashboard/icons/icon_riwayatpresensi.png')); ?>" class="sidebar-icon"> Riwayat Presensi
                     </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.pembayaran')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.pembayaran*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_pembayaran.png')); ?>" class="sidebar-icon"> Pembayaran
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.rekap-gaji')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.rekap-gaji*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_rekapgaji.png')); ?>" class="sidebar-icon"> Rekap Gaji
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('superadmin.laporan-keuangan')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.laporan-keuangan*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_laporankeuangan.png')); ?>" class="sidebar-icon"> Laporan Keuangan
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

    
    <div class="sidebar-footer">
        <button type="button" class="logout-btn" onclick="bukaModalLogout()">
            <img src="<?php echo e(asset('images/dashboard/icons/icon_logout.png')); ?>" class="sidebar-icon"> Logout
        </button>
    </div>

</aside>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebarElement = document.getElementById('sidebar');
        
        if (sidebarElement) {
            const sidebarScrollPos = localStorage.getItem('sidebar_scroll');
            if (sidebarScrollPos) {
                setTimeout(() => {
                    sidebarElement.scrollTop = parseInt(sidebarScrollPos);
                }, 50);
            }

            sidebarElement.addEventListener('scroll', function() {
                localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
            });

            const sidebarLinks = sidebarElement.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    localStorage.setItem('sidebar_scroll', sidebarElement.scrollTop);
                });
            });
        }
    });
</script><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/components/sidebar.blade.php ENDPATH**/ ?>