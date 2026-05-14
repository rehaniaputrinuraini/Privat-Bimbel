

<aside class="sidebar" id="sidebar" style="overflow-y: auto; scroll-behavior: smooth;">
    <?php
        $user = Auth::user();
        $role = $user->peran ?? 'guest';
    ?>

    
    <div class="sidebar-profile">
        <div class="avatar-circle" style="cursor: pointer;" onclick="bukaPreviewFotoSidebar()">
            <?php if($user->foto): ?>
                <img src="<?php echo e(asset('storage/' . $user->foto)); ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
            <?php else: ?>
                <img src="<?php echo e(asset('images/dashboard/icons/icon_orang.png')); ?>" alt="Profile">
            <?php endif; ?>
        </div>
        <div class="profile-info">
            <h4><?php echo e($user->pegawai->nama_lengkap ?? $user->username ?? $user->name); ?></h4>
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
        <a href="<?php echo e(route('tentor.pengajaran')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('tentor.pengajaran*') ? 'nav-active' : ''); ?>">
            <img src="<?php echo e(asset('images/dashboard/icons/icon_presensi.png')); ?>" class="sidebar-icon"> Pengajaran
        </a>
    </li>
<?php endif; ?>

            
            <?php if($role == 'admin'): ?>
                
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.dashboard') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_dashboard.png')); ?>" class="sidebar-icon"> Dashboard
                    </a>
                </li>

                
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle <?php echo e(request()->is('*master-data*') || request()->is('*data-tentor*') || request()->is('*kelola-murid*') ? 'nav-active' : ''); ?>" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="<?php echo e(asset('images/dashboard/icons/icon_hargapaket.png')); ?>" class="sidebar-icon"> 
                            Master Data
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: <?php echo e(request()->is('*master-data*') || request()->is('*data-tentor*') || request()->is('*kelola-murid*') ? 'block' : 'none'); ?>;">
                        <li>
                            <a href="<?php echo e(route('admin.data-tentor')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.data-tentor*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-chalkboard-teacher submenu-icon"></i> Data Tentor
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.kelola-murid')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.kelola-murid*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-user-graduate submenu-icon"></i> Kelola Murid
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.master-data.harga-paket')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.master-data.harga-paket*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-tag submenu-icon"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.master-data.kelas')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.master-data.kelas*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-users submenu-icon"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.master-data.ruang')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.master-data.ruang*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-door-open submenu-icon"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.master-data.periode')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.master-data.periode*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-calendar-alt submenu-icon"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle <?php echo e(request()->is('*transaksi*') || request()->is('*pembayaran*') || request()->is('*rekap-gaji*') ? 'nav-active' : ''); ?>" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="<?php echo e(asset('images/dashboard/icons/icon_pembayaran.png')); ?>" class="sidebar-icon"> 
                            Transaksi
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: <?php echo e(request()->is('*transaksi*') || request()->is('*pembayaran*') || request()->is('*rekap-gaji*') ? 'block' : 'none'); ?>;">
                        <li>
                            <a href="<?php echo e(route('admin.transaksi.pemasukan')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.transaksi.pemasukan*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-arrow-down submenu-icon"></i> Pembayaran Murid
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.transaksi.pemasukan-lain')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.transaksi.pemasukan-lain*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-plus-circle submenu-icon"></i> Pemasukan Lain
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.transaksi.pengeluaran')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.transaksi.pengeluaran*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-arrow-up submenu-icon"></i> Pengeluaran Lain
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('admin.transaksi.penggajian')); ?>" class="submenu-link <?php echo e(request()->routeIs('admin.transaksi.penggajian*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-hand-holding-usd submenu-icon"></i> Penggajian
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li>
                    <a href="<?php echo e(route('admin.kelola-presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('admin.kelola-presensi*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_riwayatpresensi.png')); ?>" class="sidebar-icon"> Riwayat Pengajaran
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

                
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle <?php echo e(request()->is('*kelola-admin*') || request()->is('*kelola-tentor*') || request()->is('*kelola-murid*') || request()->is('*master-data*') ? 'nav-active' : ''); ?>" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="<?php echo e(asset('images/dashboard/icons/icon_hargapaket.png')); ?>" class="sidebar-icon"> 
                            Master Data
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: <?php echo e(request()->is('*kelola-admin*') || request()->is('*kelola-tentor*') || request()->is('*kelola-murid*') || request()->is('*master-data*') ? 'block' : 'none'); ?>;">
                        <li>
                            <a href="<?php echo e(route('superadmin.kelola-admin')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.kelola-admin*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-user-shield submenu-icon"></i> Kelola Admin
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.kelola-tentor')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.kelola-tentor*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-chalkboard-teacher submenu-icon"></i> Kelola Tentor
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.kelola-murid')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.kelola-murid*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-user-graduate submenu-icon"></i> Kelola Murid
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.master-data.harga-paket')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.master-data.harga-paket*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-tag submenu-icon"></i> Harga Paket
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.master-data.kelas')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.master-data.kelas*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-users submenu-icon"></i> Kelas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.master-data.ruang')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.master-data.ruang*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-door-open submenu-icon"></i> Ruang
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.master-data.periode')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.master-data.periode*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-calendar-alt submenu-icon"></i> Periode
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="has-submenu">
                    <a href="javascript:void(0)" class="nav-link-custom submenu-toggle <?php echo e(request()->is('*transaksi*') || request()->is('*pembayaran*') || request()->is('*rekap-gaji*') ? 'nav-active' : ''); ?>" onclick="toggleSubmenu(this)">
                        <div style="display: flex; align-items: center; flex: 1;">
                            <img src="<?php echo e(asset('images/dashboard/icons/icon_pembayaran.png')); ?>" class="sidebar-icon"> 
                            Transaksi
                        </div>
                        <i class="fas fa-caret-down submenu-arrow"></i>
                    </a>
                    <ul class="submenu-list" style="display: <?php echo e(request()->is('*transaksi*') || request()->is('*pembayaran*') || request()->is('*rekap-gaji*') ? 'block' : 'none'); ?>;">
                        <li>
                            <a href="<?php echo e(route('superadmin.transaksi.pemasukan')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.transaksi.pemasukan*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-arrow-down submenu-icon"></i> Pembayaran Murid
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.transaksi.pemasukan-lain')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.transaksi.pemasukan-lain*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-plus-circle submenu-icon"></i> Pemasukan Lain
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.transaksi.pengeluaran')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.transaksi.pengeluaran*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-arrow-up submenu-icon"></i> Pengeluaran Lain
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('superadmin.transaksi.penggajian')); ?>" class="submenu-link <?php echo e(request()->routeIs('superadmin.transaksi.penggajian*') ? 'sub-active' : ''); ?>">
                                <i class="fas fa-hand-holding-usd submenu-icon"></i> Penggajian
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li>
                    <a href="<?php echo e(route('superadmin.kelola-presensi')); ?>" class="nav-link-custom <?php echo e(request()->routeIs('superadmin.kelola-presensi*') ? 'nav-active' : ''); ?>">
                        <img src="<?php echo e(asset('images/dashboard/icons/icon_riwayatpresensi.png')); ?>" class="sidebar-icon"> Riwayat Pengajaran
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


<div id="modalPreviewFotoSidebar" style="display: none; position: fixed; z-index: 99999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); flex-direction: column; align-items: center; justify-content: center;" onclick="tutupPreviewFotoSidebar(event)">
    <div style="position: fixed; top: 0; left: 0; right: 0; display: flex; justify-content: flex-end; align-items: center; padding: 12px 20px; background: rgba(0,0,0,0.6); z-index: 10;">
        <button onclick="document.getElementById('modalPreviewFotoSidebar').style.display='none'" style="background: rgba(255,255,255,0.15); border: none; color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px;" title="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; padding: 60px 20px 20px 20px;">
        <img id="previewFotoSidebarImg" src="" alt="Foto Profil" style="max-width: 95%; max-height: 88vh; object-fit: contain; border-radius: 4px;">
    </div>
</div>


<script>
    function toggleSubmenu(element) {
        const submenu = element.nextElementSibling;
        const arrow = element.querySelector('.submenu-arrow');
        
        if (submenu.style.display === 'none' || submenu.style.display === '') {
            submenu.style.display = 'block';
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            submenu.style.display = 'none';
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    }
    
    // Preview foto dari sidebar
    function bukaPreviewFotoSidebar() {
        <?php if($user->foto): ?>
            document.getElementById('previewFotoSidebarImg').src = "<?php echo e(asset('storage/' . $user->foto)); ?>";
            document.getElementById('modalPreviewFotoSidebar').style.display = 'flex';
        <?php endif; ?>
    }
    
    function tutupPreviewFotoSidebar(event) {
        if (event.target === document.getElementById('modalPreviewFotoSidebar')) {
            document.getElementById('modalPreviewFotoSidebar').style.display = 'none';
        }
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('modalPreviewFotoSidebar').style.display = 'none';
        }
    });
</script>


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
</script><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/components/sidebar.blade.php ENDPATH**/ ?>