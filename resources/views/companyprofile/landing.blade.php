<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Privat - Company Profile</title>
    
    <link rel="stylesheet" href="{{ asset('css/companyprofile.css') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- --- TAMBAHAN: CSS UNTUK ANIMASI AOS --- --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Mengaktifkan scroll halus saat navigasi diklik */
        html { scroll-behavior: smooth; }
        /* Animasi berdenyut khusus untuk tombol daftar/hubungi */
        @keyframes pulse-purple {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .btn-primary { animation: pulse-purple 2s infinite; }

        /* REVISI: UKURAN IKON SOSIAL FOOTER 30PX BERDAMPINGAN */
        .social-icons-img {
            display: flex;
            gap: 15px;
            margin-top: 10px;
            align-items: center;
        }
        .social-icons-img img {
            width: 30px;
            height: 30px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .social-icons-img img:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <img src="{{ asset('images/logo/foto_logo.png') }}" alt="Logo Bimbel Privat" class="h-12 w-auto">
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
            {{-- Animasi: Muncul dari kiri --}}
            <div class="hero-text" data-aos="fade-right" data-aos-duration="1000">
                <h1>Bimbel Privat</h1>
                <h2 class="text-purple">Prestasi Lebih Baik</h2>
                <p>Bimbingan belajar untuk SD, SMP, SMA dengan tentor berpengalaman untuk meningkatkan prestasi akademik Anda.</p>
                <a href="https://wa.me/628986368457?text=Halo%20Admin%20Bimbel%20Privat,%20saya%20tertarik%20dengan%20Bimbel%20Privat" 
                class="btn-primary" target="_blank">
                <i class="fas fa-phone-alt"></i> 
                <span>Daftar atau Hubungi Kami</span></a> 
            </div>
            {{-- Animasi: Muncul dari kanan --}}
            <div class="hero-image" data-aos="fade-left" data-aos-duration="1000">
                <img src="{{ asset('images/companyprofile/galeri/gambar1.jpg') }}" alt="Aktivitas Belajar"> </div>
        </div>
    </section>

    <section class="stats">
        <div class="container stats-container">
            {{-- Animasi: Muncul satu per satu (delay bergantian) --}}
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
                <i class="fas fa-users"></i>
                <h3>21</h3>
                <p>Tentor Profesional</p>
            </div>
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                <i class="fas fa-graduation-cap"></i>
                <h3>300+</h3>
                <p>Siswa Aktif</p>
            </div>
            <div class="stat-card" data-aos="zoom-in" data-aos-delay="500">
                <i class="fas fa-book-open"></i>
                <h3>5</h3>
                <p>Tahun Pengalaman</p>
            </div>
        </div>
    </section>

    <section id="profil" class="visi-misi">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Profil Kami</h2>
            <p class="section-subtitle" data-aos="fade-up">Kenali lebih dekat Bimbel Privat</p>
            <div class="visi-misi-container">
                <div class="visi-box" data-aos="fade-up" data-aos-delay="200">
                    <h3><i class="fas fa-eye text-purple"></i> Visi</h3>
                    <p>Menjadi lembaga bimbingan belajar terbaik yang menghasilkan siswa berprestasi dan berakhlak mulia.</p>
                </div>
                <div class="misi-box" data-aos="fade-up" data-aos-delay="400">
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
            <h2 class="section-title" data-aos="fade-up">Fasilitas Kami</h2>
            <p class="section-subtitle" data-aos="fade-up">Fasilitas yang kami tawarkan</p>
            <div class="fasilitas-grid">
                {{-- Fasilitas menggunakan data-aos fade-up agar muncul meluncur dari bawah --}}
                <div class="fasilitas-card" data-aos="fade-up">
                    <div class="icon-box"><i class="fas fa-snowflake"></i></div>
                    <h4>Ruang AC</h4>
                    <p>Belajar nyaman dengan AC.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box"><i class="fas fa-user-graduate"></i></div>
                    <h4>Konsultasi PTN</h4>
                    <p>Bimbingan masuk PTN favorit.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box"><i class="fas fa-pencil-ruler"></i></div>
                    <h4>Pojok PR</h4>
                    <p>Tempat mengerjakan PR bareng.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up">
                    <div class="icon-box"><i class="fas fa-file-signature"></i></div>
                    <h4>Try Out TPA/SNBT</h4>
                    <p>Simulasi ujian berkala.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box"><i class="fas fa-book-reader"></i></div>
                    <h4>Pendampingan STS/SAS</h4>
                    <p>Persiapan ujian sekolah.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box"><i class="fas fa-university"></i></div>
                    <h4>Bimbingan SPMB</h4>
                    <p>Bimbingan seleksi masuk.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up">
                    <div class="icon-box"><i class="fas fa-bus"></i></div>
                    <h4>Outing Class</h4>
                    <p>Belajar di luar kelas.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-box"><i class="fas fa-calendar-check"></i></div>
                    <h4>3x/Minggu</h4>
                    <p>Pertemuan rutin.</p>
                </div>
                <div class="fasilitas-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-box"><i class="fas fa-users"></i></div>
                    <h4>Maks 10 Siswa</h4>
                    <p>Kelas kecil lebih fokus.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="program" class="program-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-down">Program Kami</h2>
            <p class="section-subtitle" data-aos="fade-down">Pilih program yang paling sesuai dengan kebutuhan belajar Anda</p>
            <div class="program-container">

                {{-- Animasi Flip (berputar) untuk kartu program --}}
                <div class="program-card" data-aos="flip-left" data-aos-duration="1000">
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
                            <li><i class="fas fa-check"></i> Free Merchandise</li>
                            
                        </ul>
                    </div>
                </div>

                <div class="program-card" data-aos="flip-left" data-aos-delay="300" data-aos-duration="1000">
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
                        <h4>Mata Pelajaran Lain:</h4>
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

                <div class="program-card" data-aos="flip-left" data-aos-delay="600" data-aos-duration="1000">
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
            <h2 class="section-title" data-aos="fade-up">Galeri Kegiatan</h2>
            <p class="section-subtitle" data-aos="fade-up">Dokumentasi kegiatan belajar mengajar kami</p>
            <div class="galeri-grid">
                <img src="{{ asset('images/companyprofile/galeri/gambar_1.jpg') }}" alt="Galeri 1" data-aos="zoom-in"> 
                <img src="{{ asset('images/companyprofile/galeri/gambar2.jpg') }}" alt="Galeri 2" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{ asset('images/companyprofile/galeri/gambar3.jpg') }}" alt="Galeri 3" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{ asset('images/companyprofile/galeri/gambar1.jpg') }}" alt="Galeri 4" data-aos="zoom-in">
                <img src="{{ asset('images/companyprofile/galeri/gambar2.jpg') }}" alt="Galeri 5" data-aos="zoom-in" data-aos-delay="100">
                <img src="{{ asset('images/companyprofile/galeri/gambar3.jpg') }}" alt="Galeri 6" data-aos="zoom-in" data-aos-delay="200">
            </div>
        </div>
    </section>

    <section id="testimoni" class="testimoni">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Testimoni</h2>
            <p class="section-subtitle" data-aos="fade-up">Apa kata mereka tentang kami?</p>
            
            <div class="testimoni-container">
                
                <div class="testimoni-card" data-aos="fade-right">
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

                <div class="testimoni-card" data-aos="fade-up" data-aos-delay="200">
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

                <div class="testimoni-card" data-aos="fade-left">
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

    <footer id="kontak" class="footer" data-aos="fade-in">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4><i class="fas fa-book-open"></i> Bimbel Privat</h4>
                    <p>Prestasi lebih baik.</p>
                    {{-- REVISI: Ikon Berdampingan 30px --}}
                    <div class="social-icons-img">
                        <a href="https://www.instagram.com/bimbelprivatmadiun_" target="_blank" title="Instagram">
                            <img src="{{ asset('images/companyprofile/instagram.png') }}" alt="Instagram">
                        </a>
                        <a href="https://www.tiktok.com/@bimbelprivatmadiun_" target="_blank" title="TikTok">
                            <img src="{{ asset('images/companyprofile/tiktok.png') }}" alt="TikTok">
                        </a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-map-marker-alt"></i> Alamat</h4>
                    <p>Jalan Wijaya, Rt 07/Rw 02, Dusun Uteran, Kecamatan Geger, Kabupaten Madiun.</p>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-phone-alt"></i> Kontak</h4>
                    <p>WhatsApp: 0822-4555-2901</p>
                    <p>Email: info@bimbelprivat.com</p>
                </div>
                <div class="footer-section">
                    <h4><i class="fas fa-clock"></i> Jam Operasional</h4>
                    <p>Senin - Jumat: 14.00 - 20.00 WIB</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.8rem; opacity: 0.7;">
                    &copy; 2026 Bimbel Privat. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    {{-- --- TAMBAHAN: JS UNTUK ANIMASI AOS --- --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Inisialisasi AOS agar animasi berjalan saat di-scroll
        AOS.init({
            duration: 800, // Durasi animasi 0.8 detik
            once: true,    // Animasi hanya muncul sekali saat scroll ke bawah
            offset: 100    // Muncul saat elemen berjarak 100px dari layar
        });
    </script>
</body>
</html>