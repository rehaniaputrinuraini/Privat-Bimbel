

<?php $__env->startSection('title', 'Master Data'); ?>

<?php $__env->startSection('content'); ?>
<div style="width: 100%; font-family: 'Poppins', sans-serif;">
    
    
    <div style="margin-bottom: 25px;">
        <p style="color: #374151; font-size: 13px; margin: 0 0 4px 0;">
            <?php echo e(\Carbon\Carbon::now()->translatedFormat('F Y')); ?>

        </p>
        <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0; letter-spacing: -0.5px; line-height: 1.2;">
            Master Data
        </h1>
        <p style="color: #374151; font-size: 14px; margin: 4px 0 0 0;">Manajemen Harga Paket, Kelas, Ruangan, dan Periode</p>
    </div>

    
    <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #F3F4F6;">
        
        
        <div style="display: flex; border-bottom: 1px solid #E5E7EB; background: #FAFAFA; padding: 0 20px; flex-wrap: wrap;">
            <button class="tab-btn active" onclick="switchTab(event, 'tab-paket')" 
                    style="padding: 16px 24px; font-weight: 600; font-size: 14px; border: none; background: transparent; color: #4D0B87; border-bottom: 3px solid #4D0B87; cursor: pointer; margin-right: 10px; transition: 0.2s;">
                <i class="fas fa-tag mr-2"></i> Harga Paket
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'tab-kelas')" 
                    style="padding: 16px 24px; font-weight: 500; font-size: 14px; border: none; background: transparent; color: #6B7280; border-bottom: 3px solid transparent; cursor: pointer; margin-right: 10px; transition: 0.2s;">
                <i class="fas fa-users mr-2"></i> Daftar Kelas
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'tab-ruang')" 
                    style="padding: 16px 24px; font-weight: 500; font-size: 14px; border: none; background: transparent; color: #6B7280; border-bottom: 3px solid transparent; cursor: pointer; margin-right: 10px; transition: 0.2s;">
                <i class="fas fa-door-open mr-2"></i> Daftar Ruang
            </button>
            <button class="tab-btn" onclick="switchTab(event, 'tab-periode')" 
                    style="padding: 16px 24px; font-weight: 500; font-size: 14px; border: none; background: transparent; color: #6B7280; border-bottom: 3px solid transparent; cursor: pointer; margin-right: 10px; transition: 0.2s;">
                <i class="fas fa-calendar-alt mr-2"></i> Periode
            </button>
        </div>

        
        <div style="padding: 25px;">
            
            
            <div id="tab-paket" class="tab-content" style="display: block;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                        <div style="position: relative; width: 300px;">
                            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                            <input type="text" id="searchPaket" placeholder="Cari ID atau Tingkat..." 
                                   style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB; outline: none; background: white; font-size: 14px; color: #374151;">
                        </div>
                    </div>
                    <a href="<?php echo e(route($role . '.harga-paket.create')); ?>" style="text-decoration: none;">
                        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; transition: 0.3s; box-shadow: 0 4px 6px rgba(77, 11, 135, 0.2);">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </a>
                </div>

                <?php if(session('success_paket')): ?>
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success_paket')); ?>

                    </div>
                <?php endif; ?>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                        <thead>
                            <tr style="background: #F3E8FF; color: #111827;">
                                <th style="padding: 15px; width: 60px; text-align: center;">No</th>
                                <th style="padding: 15px; width: 120px; text-align: center;">ID</th>
                                <th style="padding: 15px; width: 150px; text-align: center;">Harga Paket</th>
                                <th style="padding: 15px; width: 180px; text-align: center;">Tingkat</th>
                                <th style="padding: 15px; width: 150px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyPaket" style="color: #374151;">
                            <?php $__empty_1 = true; $__currentLoopData = $paket; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                                <td style="padding: 15px; text-align: center;">PK<?php echo e(str_pad($item->id_paket, 4, '0', STR_PAD_LEFT)); ?></td>
                                <td style="padding: 15px; text-align: center;">Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->tingkat); ?></td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="<?php echo e(route($role . '.harga-paket.edit', $item->id_paket)); ?>" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <button type="button" onclick="bukaModalHapusPaket('<?php echo e($item->id_paket); ?>', 'PK<?php echo e(str_pad($item->id_paket, 4, '0', STR_PAD_LEFT)); ?>')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data harga paket.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <select id="pageSelectPaket" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <option value="10">10 baris</option>
                            <option value="25">25 baris</option>
                            <option value="50">50 baris</option>
                        </select>
                        <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($paket->count()); ?> paket</span>
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>

            
            <div id="tab-kelas" class="tab-content" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <div style="width: 300px;">
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                            <input type="text" id="searchKelas" placeholder="Cari Nama Kelas..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        </div>
                    </div>
                    <a href="<?php echo e(route($role . '.kelas.create')); ?>" style="text-decoration: none;">
                        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-plus"></i> Tambah Kelas
                        </button>
                    </a>
                </div>

                <?php if(session('success_kelas')): ?>
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success_kelas')); ?>

                    </div>
                <?php endif; ?>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead style="background: #F3E8FF; color: #111827;">
                            <tr>
                                <th style="padding: 15px; text-align: center;">No</th>
                                <th style="padding: 15px; text-align: center;">Nama Kelas</th>
                                <th style="padding: 15px; text-align: center;">Jenjang</th>
                                <th style="padding: 15px; text-align: center;">Jumlah Murid</th>
                                <th style="padding: 15px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyKelas" style="color: #374151;">
                            <?php $__empty_1 = true; $__currentLoopData = $kelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->nama_kelas); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->jenjang); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->jumlah_murid ?? 0); ?></td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="<?php echo e(route($role . '.kelas.edit', $item->id_kelas)); ?>" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <button type="button" onclick="bukaModalHapusKelas('<?php echo e($item->id_kelas); ?>', '<?php echo e($item->nama_kelas); ?>')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="5" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data kelas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <select id="pageSelectKelas" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <option value="10">10 baris</option>
                            <option value="25">25 baris</option>
                            <option value="50">50 baris</option>
                        </select>
                        <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($kelas->count()); ?> kelas</span>
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>

            
            <div id="tab-ruang" class="tab-content" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <div style="width: 300px;">
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                            <input type="text" id="searchRuang" placeholder="Cari Nama Ruang..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        </div>
                    </div>
                    <a href="<?php echo e(route($role . '.ruang.create')); ?>" style="text-decoration: none;">
                        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-plus"></i> Tambah Ruang
                        </button>
                    </a>
                </div>

                <?php if(session('success_ruang')): ?>
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success_ruang')); ?>

                    </div>
                <?php endif; ?>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead style="background: #F3E8FF; color: #111827;">
                            <tr>
                                <th style="padding: 15px; text-align: center;">No</th>
                                <th style="padding: 15px; text-align: center;">Nama Ruang</th>
                                <th style="padding: 15px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyRuang" style="color: #374151;">
                            <?php $__empty_1 = true; $__currentLoopData = $ruang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->nama_ruang); ?></td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="<?php echo e(route($role . '.ruang.edit', $item->id_ruang)); ?>" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <button type="button" onclick="bukaModalHapusRuang('<?php echo e($item->id_ruang); ?>', '<?php echo e($item->nama_ruang); ?>')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="3" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data ruang.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <select id="pageSelectRuang" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <option value="10">10 baris</option>
                            <option value="25">25 baris</option>
                            <option value="50">50 baris</option>
                        </select>
                        <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($ruang->count()); ?> ruang</span>
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>

            
            <div id="tab-periode" class="tab-content" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <div style="width: 300px;">
                        <div style="position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9CA3AF;"></i>
                            <input type="text" id="searchPeriode" placeholder="Cari Periode..." style="width: 100%; padding: 10px 15px 10px 45px; border-radius: 12px; border: 1px solid #E5E7EB;">
                        </div>
                    </div>
                    <a href="<?php echo e(route($role . '.periode.create')); ?>" style="text-decoration: none;">
                        <button style="background-color: #4D0B87; color: white; border: none; padding: 12px 25px; border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-plus"></i> Tambah Periode
                        </button>
                    </a>
                </div>

                <?php if(session('success_periode')): ?>
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px; border-radius: 10px; margin-bottom: 20px;">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success_periode')); ?>

                    </div>
                <?php endif; ?>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead style="background: #F3E8FF; color: #111827;">
                            <tr>
                                <th style="padding: 15px; text-align: center;">No</th>
                                <th style="padding: 15px; text-align: center;">ID</th>
                                <th style="padding: 15px; text-align: center;">Tahun Periode</th>
                                <th style="padding: 15px; text-align: center;">Tahun Mulai</th>
                                <th style="padding: 15px; text-align: center;">Tahun Selesai</th>
                                <th style="padding: 15px; text-align: center;">Status</th>
                                <th style="padding: 15px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBodyPeriode" style="color: #374151;">
                            <?php $__empty_1 = true; $__currentLoopData = $periode; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #F3F4F6;">
                                <td style="padding: 15px; text-align: center;"><?php echo e($loop->iteration); ?></td>
                                <td style="padding: 15px; text-align: center;">PR<?php echo e(str_pad($item->id_periode, 4, '0', STR_PAD_LEFT)); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->tahun_periode); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->tahun_mulai); ?></td>
                                <td style="padding: 15px; text-align: center;"><?php echo e($item->tahun_selesai); ?></td>
                                <td style="padding: 15px; text-align: center;">
                                    <?php
                                        $tahunSekarang = date('Y');
                                        $aktif = ($item->tahun_mulai <= $tahunSekarang && $item->tahun_selesai >= $tahunSekarang);
                                    ?>
                                    <?php if($aktif): ?>
                                        <span style="background: #D1FAE5; color: #065F46; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Aktif</span>
                                    <?php else: ?>
                                        <span style="background: #F3F4F6; color: #6B7280; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td style="padding: 15px; text-align: center;">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="<?php echo e(route($role . '.periode.edit', $item->id_periode)); ?>" style="background: #5EB37E; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none;">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <button type="button" onclick="bukaModalHapusPeriode('<?php echo e($item->id_periode); ?>', '<?php echo e($item->tahun_periode); ?>')" style="background: #E35D5D; color: white; padding: 6px 12px; border-radius: 6px; border: none; cursor: pointer;">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="7" style="padding: 40px; text-align: center; color: #9CA3AF;">Belum ada data periode.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 0 5px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <select id="pageSelectPeriode" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #E5E7EB; color: #374151; font-size: 13px; background: white; outline: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <option value="10">10 baris</option>
                            <option value="25">25 baris</option>
                            <option value="50">50 baris</option>
                        </select>
                        <span style="color: #374151; font-size: 13px;">Menampilkan <?php echo e($periode->count()); ?> periode</span>
                    </div>
                    <div style="display: flex; gap: 5px;">
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-double-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-left"></i></button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; background: #4D0B87; color: white; border: none; font-weight: 600; cursor: pointer;">1</button>
                        <button style="width: 35px; height: 35px; border-radius: 8px; border: 1px solid #E5E7EB; background: white; color: #374151; cursor: pointer;"><i class="fas fa-angle-right"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
    <div id="modalHapusPaket" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
            <div style="color: #E35D5D; font-size: 40px;"><i class="fas fa-trash-alt"></i></div>
            <h2>Hapus Data?</h2>
            <p id="pesanHapusPaket">Apakah Anda yakin ingin menghapus data paket ini?</p>
            <div style="display: flex; gap: 10px;">
                <button onclick="tutupModalHapusPaket()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Batal</button>
                <form id="formHapusPaket" method="POST" style="flex: 1;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    
    <div id="modalHapusKelas" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
            <div style="color: #E35D5D; font-size: 40px;"><i class="fas fa-trash-alt"></i></div>
            <h2>Hapus Kelas?</h2>
            <p id="pesanHapusKelas">Apakah Anda yakin ingin menghapus kelas ini?</p>
            <div style="display: flex; gap: 10px;">
                <button onclick="tutupModalHapusKelas()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Batal</button>
                <form id="formHapusKelas" method="POST" style="flex: 1;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    
    <div id="modalHapusRuang" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
            <div style="color: #E35D5D; font-size: 40px;"><i class="fas fa-trash-alt"></i></div>
            <h2>Hapus Ruang?</h2>
            <p id="pesanHapusRuang">Apakah Anda yakin ingin menghapus ruang ini?</p>
            <div style="display: flex; gap: 10px;">
                <button onclick="tutupModalHapusRuang()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Batal</button>
                <form id="formHapusRuang" method="POST" style="flex: 1;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

    
    <div id="modalHapusPeriode" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); backdrop-filter: blur(3px); align-items: center; justify-content: center;">
        <div style="background: white; padding: 25px; border-radius: 20px; width: 320px; text-align: center;">
            <div style="color: #E35D5D; font-size: 40px;"><i class="fas fa-trash-alt"></i></div>
            <h2>Hapus Periode?</h2>
            <p id="pesanHapusPeriode">Apakah Anda yakin ingin menghapus periode ini?</p>
            <div style="display: flex; gap: 10px;">
                <button onclick="tutupModalHapusPeriode()" style="flex: 1; padding: 10px; border-radius: 10px; border: 1px solid #E5E7EB;">Batal</button>
                <form id="formHapusPeriode" method="POST" style="flex: 1;">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" style="width: 100%; padding: 10px; border-radius: 10px; border: none; background: #E35D5D; color: white;">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function switchTab(evt, tabId) {
        let contents = document.getElementsByClassName("tab-content");
        for (let i = 0; i < contents.length; i++) contents[i].style.display = "none";
        let btns = document.getElementsByClassName("tab-btn");
        for (let i = 0; i < btns.length; i++) {
            btns[i].style.color = "#6B7280";
            btns[i].style.fontWeight = "500";
            btns[i].style.borderBottomColor = "transparent";
        }
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.style.color = "#4D0B87";
        evt.currentTarget.style.fontWeight = "600";
        evt.currentTarget.style.borderBottomColor = "#4D0B87";
    }

    // Search Paket
    document.getElementById('searchPaket').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBodyPaket tr');
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 4) {
                let id = row.cells[1]?.innerText.toLowerCase() || '';
                let tingkat = row.cells[3]?.innerText.toLowerCase() || '';
                row.style.display = (id.includes(val) || tingkat.includes(val)) ? '' : 'none';
            }
        });
    });

    // Search Kelas
    document.getElementById('searchKelas').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBodyKelas tr');
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 2) {
                let nama = row.cells[1]?.innerText.toLowerCase() || '';
                row.style.display = nama.includes(val) ? '' : 'none';
            }
        });
    });

    // Search Ruang
    document.getElementById('searchRuang').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBodyRuang tr');
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 2) {
                let nama = row.cells[1]?.innerText.toLowerCase() || '';
                row.style.display = nama.includes(val) ? '' : 'none';
            }
        });
    });

    // Search Periode
    document.getElementById('searchPeriode').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBodyPeriode tr');
        rows.forEach(row => {
            if(row.cells && row.cells.length >= 3) {
                let tahun = row.cells[2]?.innerText.toLowerCase() || '';
                row.style.display = tahun.includes(val) ? '' : 'none';
            }
        });
    });

    // Modal Hapus Paket
    function bukaModalHapusPaket(id, nama) {
        let form = document.getElementById('formHapusPaket');
        form.action = "<?php echo e(route($role . '.harga-paket.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapusPaket').innerHTML = `Yakin ingin menghapus paket <strong>${nama}</strong>?`;
        document.getElementById('modalHapusPaket').style.display = 'flex';
    }
    function tutupModalHapusPaket() { document.getElementById('modalHapusPaket').style.display = 'none'; }

    // Modal Hapus Kelas
    function bukaModalHapusKelas(id, nama) {
        let form = document.getElementById('formHapusKelas');
        form.action = "<?php echo e(route($role . '.kelas.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapusKelas').innerHTML = `Yakin ingin menghapus kelas <strong>${nama}</strong>?`;
        document.getElementById('modalHapusKelas').style.display = 'flex';
    }
    function tutupModalHapusKelas() { document.getElementById('modalHapusKelas').style.display = 'none'; }

    // Modal Hapus Ruang
    function bukaModalHapusRuang(id, nama) {
        let form = document.getElementById('formHapusRuang');
        form.action = "<?php echo e(route($role . '.ruang.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapusRuang').innerHTML = `Yakin ingin menghapus ruang <strong>${nama}</strong>?`;
        document.getElementById('modalHapusRuang').style.display = 'flex';
    }
    function tutupModalHapusRuang() { document.getElementById('modalHapusRuang').style.display = 'none'; }

    // Modal Hapus Periode
    function bukaModalHapusPeriode(id, nama) {
        let form = document.getElementById('formHapusPeriode');
        form.action = "<?php echo e(route($role . '.periode.destroy', '')); ?>/" + id;
        document.getElementById('pesanHapusPeriode').innerHTML = `Yakin ingin menghapus periode <strong>${nama}</strong>?`;
        document.getElementById('modalHapusPeriode').style.display = 'flex';
    }
    function tutupModalHapusPeriode() { document.getElementById('modalHapusPeriode').style.display = 'none'; }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\privat-bimbel\resources\views/dashboard/shared/master-data/master-data.blade.php ENDPATH**/ ?>