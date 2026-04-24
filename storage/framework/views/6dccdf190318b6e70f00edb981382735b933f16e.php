
<div style="padding: 30px; font-family: 'Poppins', sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 20px; font-weight: 700; color: #111827; margin: 0;">Edit Data Murid</h2>
        <button onclick="tutupModalForm()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #9CA3AF;">&times;</button>
    </div>

    <form action="<?php echo e(route($role . '.murid.update', $murid->id_murid)); ?>" method="POST" id="mainForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">ID Murid</label>
            <input type="text" value="<?php echo e($murid->id_murid); ?>" readonly 
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Lengkap <span style="color: red;">*</span></label>
            <input type="text" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $murid->nama_lengkap)); ?>" required
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Asal Sekolah</label>
            <input type="text" name="asal_sekolah" value="<?php echo e(old('asal_sekolah', $murid->asal_sekolah)); ?>" 
                   style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Alamat</label>
            <textarea name="alamat" rows="3" 
                      style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical;"><?php echo e(old('alamat', $murid->alamat)); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Siswa</label>
                    <input type="tel" name="no_hp" value="<?php echo e(old('no_hp', $murid->no_hp)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Nama Orang Tua</label>
                    <input type="text" name="nama_orang_tua" value="<?php echo e(old('nama_orang_tua', $murid->nama_orang_tua)); ?>" 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">No HP Orang Tua</label>
                    <input type="tel" name="no_hp_orang_tua" value="<?php echo e(old('no_hp_orang_tua', $murid->no_hp_orang_tua)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                </div>
            </div>
            <div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tahun Masuk</label>
                    <input type="tel" name="tahun_masuk" value="<?php echo e(old('tahun_masuk', $murid->tahun_masuk)); ?>" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #FFFFFF; outline: none; font-size: 14px;">
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 8px;">Tanggal Daftar</label>
                    <input type="text" value="<?php echo e($murid->tanggal_daftar ? date('d/m/Y', strtotime($murid->tanggal_daftar)) : '-'); ?>" readonly 
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #E5E7EB; background: #F3F4F6; outline: none; color: #6B7280; font-size: 14px;">
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 20px; margin-top: 20px;">
            <button type="button" onclick="tutupModalForm()" 
                    style="padding: 10px 45px; border: 1.5px solid #4D0B87; color: #4D0B87; border-radius: 10px; font-weight: 600; font-size: 16px; background: #FFFFFF; cursor: pointer;">Keluar</button>
            <button type="submit" 
                    style="padding: 10px 45px; border: none; background: #4D0B87; color: white; border-radius: 10px; font-weight: 600; font-size: 16px; cursor: pointer;">Update</button>
        </div>
    </form>
</div><?php /**PATH C:\xampp\htdocs\Privat-Bimbel\resources\views/dashboard/shared/kelola-murid/edit-murid.blade.php ENDPATH**/ ?>