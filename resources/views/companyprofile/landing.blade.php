<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Privat - Company Profile</title>
    
    <link rel="stylesheet" href="{{ asset('css/companyprofile.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/galeri/foto_logo.png') }}" alt="Logo Bimbel Privat" class="h-12 w-auto">
            </div>
            <ul class="nav-links">
                <li><a href="#beranda">Beranda</a></li>
                <li><a href="#profil">Profil</a></li>
                <li><a href="#program">Program</a></li>
                <li><a href="#galeri">Galeri</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            <a href="{{ route('login') }}">
    <button class="btn-login">LOGIN</button>
</a>
        
        </div>
    </nav>

    <section id="beranda" class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <h1>Bimbel Privat</h1>
                <h2 class="text-purple">Prestasi Lebih Baik</h2>
                <p>Bimbingan belajar untuk SD, SMP, SMA dengan tentor berpengalaman untuk meningkatkan prestasi akademik Anda.</p>
                <a href="https://wa.me/6283845797999?text=Halo%20Admin,%20saya%20tertarik%20dengan%20Bimbel%20Privat" 
                class="btn-primary" target="_blank">
                <i class="fas fa-phone-alt"></i> 
                <span>Daftar atau Hubungi Kami</span></a> 
            </div>
            <div class="hero-image">
                <img src="{{ asset('images/galeri/gambar1.jpg') }}" alt="Aktivitas Belajar"> </div>
        </div>
    </section>

    <section class="stats">
        <div class="container stats-container">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>21</h3>
                <p>Tentor Profesional</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-graduation-cap"></i>
                <h3>300+</h3>
                <p>Siswa Aktif</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-book-open"></i>
                <h3>5</h3>
                <p>Tahun Pengalaman</p>
            </div>
        </div>
    </section>

    <section id="profil" class="visi-misi">
        <div class="container">
            <h2 class="section-title">Profil Kami</h2>
            <p class="section-subtitle">Kenali lebih dekat Bimbel Privat</p>
            <div class="visi-misi-container">
                <div class="visi-box">
                    <h3><i class="fas fa-eye text-purple"></i> Visi</h3>
                    <p>Menjadi lembaga bimbingan belajar terbaik yang menghasilkan siswa berprestasi dan berakhlak mulia.</p>
                </div>
                <div class="misi-box">
                    <h3><i class="fas fa-bullseye text-purple"></i> Misi</h3>
                    <ul>
                        <li><i class="fas fa-check"></i> Memberikan pembelajaran berkualitas tinggi.</li>
                        <li><i class="fas fa-check"></i> Mengembangkan potensi akademik siswa.</li>
                        <li><i class="fas fa-check"></i> Membentuk karakter siswa yang positif.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="fasilitas" class="fasilitas">
        <div class="container">
            <h2 class="section-title">Fasilitas Kami</h2>
            <p class="section-subtitle">Fasilitas yang kami tawarkan</p>
            <div class="fasilitas-grid">
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-snowflake"></i></div>
                    <h4>Ruang AC</h4>
                    <p>Belajar nyaman dengan AC.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-user-graduate"></i></div>
                    <h4>Konsultasi PTN</h4>
                    <p>Bimbingan masuk PTN favorit.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-pencil-ruler"></i></div>
                    <h4>Pojok PR</h4>
                    <p>Tempat mengerjakan PR bareng.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-file-signature"></i></div>
                    <h4>Try Out TPA/SNBT</h4>
                    <p>Simulasi ujian berkala.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-book-reader"></i></div>
                    <h4>Pendampingan STS/SAS</h4>
                    <p>Persiapan ujian sekolah.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-university"></i></div>
                    <h4>Bimbingan SPMB</h4>
                    <p>Bimbingan seleksi masuk.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-bus"></i></div>
                    <h4>Outing Class</h4>
                    <p>Belajar di luar kelas.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-calendar-check"></i></div>
                    <h4>3x/Minggu</h4>
                    <p>Pertemuan rutin.</p>
                </div>
                <div class="fasilitas-card">
                    <div class="icon-box"><i class="fas fa-users"></i></div>
                    <h4>Maks 10 Siswa</h4>
                    <p>Kelas kecil lebih fokus.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="program-section">
    <div class="container">
        <h2 class="section-title">Program Kami</h2>
        <p class="section-subtitle">Pilih program yang paling sesuai dengan kebutuhan belajar Anda</p>
        <div class="program-container">

            <div class="program-card">
                <div class="program-icon reguler-icon">
                    <i class="fas fa-users"></i> </div>
                <h3>Reguler</h3>
                <p class="program-desc">Belajar rutin dengan kurikulum terstruktur</p>
                
                <div class="pendaftaran-box">
                    <span class="label">Biaya Pendaftaran</span>
                    <span class="price">Rp 100.000</span>
                    <span class="per-period">(sekali)</span>
                </div>

                <div class="detail-section">
                    <h4>Tabel Harga:</h4>
                    <ul class="harga-list">
                        <li><span>SD</span> <span>Rp 120.000</span></li>
                        <li><span>SMP</span> <span>Rp 150.000</span></li>
                        <li><span>SMA</span> <span>Rp 175.000</span></li>
                    </ul>
                </div>

                <div class="detail-section">
                    <h4>Fasilitas:</h4>
                    <ul class="fasilitas-list">
                        <li><i class="fas fa-check"></i> Kelas kelompok (maks 10 siswa)</li>
                        <li><i class="fas fa-check"></i> Modul belajar</li>
                        <li><i class="fas fa-check"></i> Konsultasi gratis</li>
                    </ul>
                </div>
            </div>

            <div class="program-card">
                <div class="program-icon privat-icon">
                    <i class="fas fa-user-check"></i> </div>
                <h3>Privat</h3>
                <p class="program-desc">Belajar 1 guru 1 murid, fokus dan intensif</p>
                
                <div class="pendaftaran-box">
                    <span class="label">Biaya Pendaftaran</span>
                    <span class="price">Rp 100.000</span>
                    <span class="per-period">(sekali)</span>
                </div>

                <div class="detail-section">
                    <h4>Program Unggulan:</h4>
                    <div class="unggulan-box english-box">
                        <i class="fas fa-flag"></i> <span>Bahasa Inggris</span>
                        <p class="unggulan-desc">Program spesial dengan native speaker</p>
                    </div>
                </div>

                <div class="detail-section">
                    <h4>Mata Pelajaran Lain:
                </div>
                <div class="mapel-grid">
                    <ul>
                        <li>• Matematika</li>
                        <li>• IPS</li>
                        <li>• Kimia</li>
                    </ul>
                    <ul>
                        <li>• IPA</li>
                        <li>• Fisika</li>
                        <li>• Biologi</li>
                    </ul>
                </div>

                <div class="detail-section">
                    <h4>Fasilitas:</h4>
                    <ul class="fasilitas-list">
                        <li><i class="fas fa-check"></i> Waktu fleksibel</li>
                        <li><i class="fas fa-check"></i> Fokus penuh</li>
                        <li><i class="fas fa-check"></i> Bisa pilih guru</li>
                    </ul>
                </div>
            </div>

            <div class="program-card">
                <div class="program-icon intensif-icon">
                    <i class="fas fa-rocket"></i></div>
                <h3>Intensif</h3>
                <p class="program-desc">Persiapan khusus ujian dan kompetisi</p>
                
                <div class="detail-section">
                    <h4>Program Khusus:</h4>
                    <div class="khusus-container">
                        <div class="khusus-item khusus-osn-sd">
                            <i class="fas fa-trophy trophy-icon"></i>
                            <span>OSN SD/MI</span>
                        </div>
                        <div class="khusus-item khusus-osn-smp">
                            <i class="fas fa-trophy trophy-icon"></i>
                            <span>OSN SMP/MTs</span>
                        </div>
                        <div class="khusus-item khusus-ptn">
                            <i class="fas fa-graduation-cap graduate-icon"></i>
                            <span>MANDIRI PTN</span>
                        </div>
                        <div class="khusus-item khusus-kedinasan">
                            <i class="fas fa-plane kedinasan-icon"></i>
                            <span>KEDINASAN</span>
                        </div>
                        <div class="khusus-item khusus-alumni">
                            <i class="fas fa-user-graduate alumni-icon"></i>
                            <span>ALUMNI</span>
                        </div>
                    </div>
                </div>

                <div class="detail-section intensif-fasilitas">
                    <h4>Fasilitas:</h4>
                    <ul class="fasilitas-list">
                        <li><i class="fas fa-check"></i> Try out berkala</li>
                        <li><i class="fas fa-check"></i> Pembahasan soal</li>
                        <li><i class="fas fa-check"></i> Mentor berpengalaman</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

    <section id="galeri" class="galeri">
        <div class="container">
            <h2 class="section-title">Galeri Kegiatan</h2>
            <p class="section-subtitle">Dokumentasi kegiatan belajar mengajar kami</p>
            <div class="galeri-grid">
                <img src="{{ asset('images/galeri/gambar1.jpg') }}" alt="Galeri 1"> 
                <img src="{{ asset('images/galeri/gambar2.jpg') }}" alt="Galeri 2">
                <img src="{{ asset('images/galeri/gambar3.jpg') }}" alt="Galeri 3">
                <img src="{{ asset('images/galeri/gambar1.jpg') }}" alt="Galeri 4">
                <img src="{{ asset('images/galeri/gambar2.jpg') }}" alt="Galeri 5">
                <img src="{{ asset('images/galeri/gambar3.jpg') }}" alt="Galeri 6">
            </div>
        </div>
    </section>

    <section id="testimoni" class="testimoni">
    <div class="container">
        <h2 class="section-title">Testimoni</h2>
        <p class="section-subtitle">Apa kata mereka tentang kami?</p>
        
        <div class="testimoni-container">
            
            <div class="testimoni-card">
                <div class="testimoni-header">
                    <i class="fas fa-user-circle"></i> <h4>Andi Pratama</h4>
                </div>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Metode belajarnya sangat seru dan mudah dipahami. Nilai saya meningkat drastis!"</p>
            </div>

            <div class="testimoni-card">
                <div class="testimoni-header">
                    <i class="fas fa-user-circle"></i>
                    <h4>Jaden Bachtera</h4>
                </div>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i> </div>
                <p>"Alhamdulillah, tentornya sabar banget. Sekarang saya lebih percaya diri menghadapi ujian."</p>
            </div>

            <div class="testimoni-card">
                <div class="testimoni-header">
                    <i class="fas fa-user-circle"></i>
                    <h4>Rehania Putri</h4>
                </div>
                <div class="rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p>"Fasilitasnya lengkap dan nyaman. Bimbel di sini sangat membantu saya masuk PTN impian!"</p>
            </div>

        </div> </div>
</section>
    <footer id="kontak" class="footer">
    <div class="container">
        <div class="footer-content">
            
            <div class="footer-section">
                <h4><i class="fas fa-book-open"></i> Bimbel Privat</h4>
                <p>Prestasi lebih baik.</p>
            </div>

            <div class="footer-section">
                <h4><i class="fas fa-map-marker-alt"></i> Alamat</h4>
                <p>Jalan Wijaya, Rt 07/Rw 02, Dusun Uteran, Kecamatan Geger, Kabupaten Madiun.</p>
            </div>

            <div class="footer-section">
                <h4><i class="fas fa-phone-alt"></i> Kontak</h4>
                <p>WhatsApp: 0838-4579-7999</p>
                <p>Email: info@bimbelprivat.com</p>
            </div>

            <div class="footer-section">
                <h4><i class="fas fa-clock"></i> Jam Operasional</h4>
                <p>Senin - Jumat: 08.00 - 20.00 WIB</p>
                <p>Sabtu: 09.00 - 15.00 WIB</p>
            </div>

        </div>

        <div class="footer-bottom">
            <p style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; opacity: 0.7;">
                &copy; 2026 Bimbel Privat. All rights reserved.
            </p>
        </div>
    </div>
</footer>

</body>
</html>