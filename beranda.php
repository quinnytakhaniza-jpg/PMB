<?php
session_start();
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "pmb_db"; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek status login berdasarkan Session ID atau Email yang aktif
$pendaftar = null;
if (isset($_SESSION['id_peserta'])) {
    $id_sess = $_SESSION['id_peserta'];
    $query = "SELECT * FROM calon_mahasiswa WHERE id = '$id_sess' LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $pendaftar = $result->fetch_assoc();
    }
} elseif (isset($_SESSION['email_pendaftar'])) {
    $email_sess = $_SESSION['email_pendaftar'];
    $query = "SELECT * FROM calon_mahasiswa WHERE email = '$email_sess' LIMIT 1";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $pendaftar = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chula University - Pendaftaran Mahasiswa Baru</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="beranda.css">
</head>
<body>

    <!-- Header / Navbar -->
    <header class="navbar" style="position: sticky; top: 0; z-index: 1000;">
        <div class="container">
            <div class="logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <div class="logo-text">
                    <span>CHULA UNIVERSITY</span>
                    <span>Pendaftaran Mahasiswa Baru</span>
                </div>
            </div>
            
            <ul class="nav-links">
                <li><a href="beranda.php" class="active" style="border-bottom: 2px solid #fff; padding-bottom: 5px;">Beranda</a></li>
                
                <li class="dropdown">
                    <a href="javascript:void(0)" id="dropdownBtn">
                        Informasi <i class="fa-solid fa-chevron-down" style="font-size: 10px;"></i>
                    </a>
                    <ul class="dropdown-menu" id="dropdownMenu">
                        <li><a href="#tentang">Tentang Kampus</a></li>
                        <li><a href="#tentang">Fasilitas</a></li>
                        <li><a href="#akreditasi">Akreditasi</a></li>
                    </ul>
                </li>

                <li><a href="#alur">Alur Pendaftaran</a></li>
                <li><a href="#jadwal">Jadwal</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
            
            <!-- TOMBOL DINAMIS & LOGIN ADMIN -->
            <div style="display: flex; gap: 10px; align-items: center;">
                <?php if ($pendaftar): ?>
                    <button class="btn-login" onclick="window.location.href='dashboard.php'" style="background-color: #28a745; border-color: #28a745;">
                        <i class="fa-solid fa-user-check"></i> Halo, <?php echo htmlspecialchars(explode(' ', $pendaftar['nama_lengkap'])[0]); ?>
                    </button>
                <?php else: ?>
                    <button class="btn-login" onclick="window.location.href='pilih_jalur.html'">
                        <i class="fa-regular fa-user"></i> Masuk / Daftar
                    </button>
                <?php endif; ?>

                <!-- Tombol Login Admin di Navbar -->
                <a href="login_admin.php" style="background: #333; color: white; padding: 10px 15px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; border: 1px solid #444;" title="Login Administrator">
                    <i class="fa-solid fa-lock" style="font-size: 11px;"></i> Admin
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="badge">
                    <i class="fa-solid fa-graduation-cap"></i> Knowledge Meets Innovation
                </div>
                <h1 class="hero-title">Wujudkan Masa Depan Bersama Chula University</h1>
                <p class="hero-desc">Bergabunglah bersama ribuan calon mahasiswa untuk meraih pendidikan berkualitas dan masa depan yang gemilang.</p>
                <div class="hero-buttons">
                    <?php if ($pendaftar): ?>
                        <button class="btn-primary" onclick="window.location.href='dashboard.php'">Lihat Status Pendaftaran <i class="fa-solid fa-arrow-right"></i></button>
                    <?php else: ?>
                        <button class="btn-primary" onclick="window.location.href='pilih_jalur.html'">Daftar Sekarang <i class="fa-solid fa-arrow-right"></i></button>
                    <?php endif; ?>
                    <button class="btn-outline" onclick="document.getElementById('tentang').scrollIntoView();">Informasi Selengkapnya</button>
                </div>
            </div>
        </div>

        <div class="registration-card">
            <div class="registration-card-header">
                <div class="icon">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <h3>Pendaftaran Telah Dibuka!</h3>
            </div>
            <p>Periode Pendaftaran</p>
            <div class="date">01 Mei 2026 –<br>30 Juni 2026</div>
            <button class="btn-light" onclick="document.getElementById('jadwal').scrollIntoView();">Lihat Jadwal</button>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="stats-wrapper">
        <div class="stat-item">
            <i class="fa-solid fa-users"></i>
            <div class="stat-text"><h4>2.450+</h4><p>Pendaftar</p></div>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-building-columns"></i>
            <div class="stat-text"><h4>12</h4><p>Program Studi</p></div>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-graduation-cap"></i>
            <div class="stat-text"><h4>850+</h4><p>Lulus Seleksi</p></div>
        </div>
        <div class="stat-item">
            <i class="fa-solid fa-trophy"></i>
            <div class="stat-text"><h4>95%</h4><p>Tingkat Kepuasan</p></div>
        </div>
    </div>

    <!-- Bagian 1: Tentang Kampus & Video Profil -->
    <section id="tentang" class="container">
        <div class="why-us-section">
            <div class="why-us-text">
                <h2>Mengapa Memilih Chula University?</h2>
                <p>Kami berkomitmen memberikan pendidikan terbaik dengan fasilitas modern dan tenaga pengajar profesional.</p>
                
                <div class="why-us-features">
                    <div class="feature">
                        <div class="feature-icon"><i class="fa-solid fa-user-tie"></i></div>
                        <div class="feature-text">
                            <h4>Dosen Profesional</h4>
                            <p>Tenaga pengajar berpengalaman</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon"><i class="fa-solid fa-building"></i></div>
                        <div class="feature-text">
                            <h4>Fasilitas Modern</h4>
                            <p>Sarana belajar lengkap</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon"><i class="fa-solid fa-leaf"></i></div>
                        <div class="feature-text">
                            <h4>Lingkungan Nyaman</h4>
                            <p>Kampus hijau dan kondusif</p>
                        </div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon"><i class="fa-solid fa-users-gear"></i></div>
                        <div class="feature-text">
                            <h4>Peluang Karir</h4>
                            <p>Jaringan luas dan penempatan</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="why-us-video" id="openVideoModal">
                <div class="play-btn">
                    <i class="fa-solid fa-play"></i>
                </div>
                <span style="position: absolute; bottom: 10px; right: 10px; font-size: 10px; background: rgba(0,0,0,0.6); color: #fff; padding: 4px 8px; border-radius: 4px; z-index: 2;">Video Profil</span>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section container">
        <div class="section-header">
            <h2>Program Studi Unggulan</h2>
            <a href="#" class="link-all">Lihat Semua Program Studi <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="programs-grid">
            <div class="program-card">
                <div class="program-icon" style="background-color: #4a1011;"><i class="fa-solid fa-laptop-code"></i></div>
                <h4>Teknik Informatika</h4>
                <p>Fakultas Teknik</p>
                <button class="btn-detail">Lihat Detail</button>
            </div>
            <div class="program-card">
                <div class="program-icon" style="background-color: #1a365d;"><i class="fa-solid fa-building-columns"></i></div>
                <h4>Sistem Informasi</h4>
                <p>Fakultas Teknik</p>
                <button class="btn-detail">Lihat Detail</button>
            </div>
            <div class="program-card">
                <div class="program-icon" style="background-color: #dd6b20;"><i class="fa-solid fa-chart-line"></i></div>
                <h4>Manajemen</h4>
                <p>Fakultas Ekonomi</p>
                <button class="btn-detail">Lihat Detail</button>
            </div>
            <div class="program-card">
                <div class="program-icon" style="background-color: #553c9a;"><i class="fa-solid fa-brain"></i></div>
                <h4>Psikologi</h4>
                <p>Fakultas Psikologi</p>
                <button class="btn-detail">Lihat Detail</button>
            </div>
            <div class="program-card">
                <div class="program-icon" style="background-color: #2b6cb0;"><i class="fa-solid fa-bullhorn"></i></div>
                <h4>Ilmu Komunikasi</h4>
                <p>Fakultas Ilmu Sosial</p>
                <button class="btn-detail">Lihat Detail</button>
            </div>
        </div>
    </section>

    <!-- Alur Pendaftaran -->
    <section id="alur" class="container section-box">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 40px;">
            <span style="display: inline-block; background: #f5f0eb; color: var(--primary); padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px;">Alur Pendaftaran</span>
            <h2 style="font-size: 36px; color: var(--primary); margin-bottom: 12px;">7 Langkah Mudah Menjadi Mahasiswa Chula University</h2>
            <p style="font-size: 14px; color: var(--text-gray);">Ikuti setiap tahapan di bawah ini untuk menyelesaikan proses pendaftaran calon mahasiswa baru.</p>
        </div>

        <div class="alur-grid-7">
            <div class="alur-card-item">
                <div class="alur-number">1</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-user-plus"></i></div>
                    <h4>1. Pilih Jalur</h4>
                    <p>Tentukan pilihan jalur masuk kuliah yang sesuai dengan kualifikasi Anda.</p>
                </div>
            </div>
            <div class="alur-card-item">
                <div class="alur-number">2</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-laptop-code"></i></div>
                    <h4>2. Pilih Prodi</h4>
                    <p>Tentukan program studi unggulan berdasarkan minat dan kemampuan akademik.</p>
                </div>
            </div>
            <div class="alur-card-item">
                <div class="alur-number">3</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-file-pen"></i></div>
                    <h4>3. Isi Formulir</h4>
                    <p>Lengkapi formulir pendaftaran online dengan memasukkan data diri secara benar.</p>
                </div>
            </div>
            <div class="alur-card-item">
                <div class="alur-number">4</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-id-card"></i></div>
                    <h4>4. Cetak Kartu</h4>
                    <p>Setelah formulir dikirim, simpan nomor pendaftaran dan cetak kartu peserta.</p>
                </div>
            </div>
        </div>

        <div class="alur-grid-bottom">
            <div class="alur-card-item">
                <div class="alur-number">5</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-book-bookmark"></i></div>
                    <h4>5. Persiapan Seleksi</h4>
                    <p>Pelajari ketentuan teknis, materi ujian, serta jadwal tahapan seleksi.</p>
                </div>
            </div>
            <div class="alur-card-item">
                <div class="alur-number">6</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-pencil-alt"></i></div>
                    <h4>6. Ikuti Ujian</h4>
                    <p>Ikuti rangkaian ujian mandiri sesuai dengan jadwal dan ketentuan pilihan Anda.</p>
                </div>
            </div>
            <div class="alur-card-item">
                <div class="alur-number">7</div>
                <div class="alur-content-wrapper">
                    <div class="alur-icon-box"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h4>7. Lulus & Daftar Ulang</h4>
                    <p>Cek pengumuman kelulusan dan lakukan registrasi ulang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Portal Pendaftaran Live -->
    <section id="jadwal" class="container section-box">
        <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 35px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); margin-bottom: 35px; position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #f2efe9; color: var(--primary); padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 15px;">
                        <i class="fa-solid fa-compass"></i> STATUS JALUR
                    </div>
                    <h2 style="font-size: 32px; color: var(--primary); margin-bottom: 10px; font-family: 'Playfair Display', serif;">Portal Pendaftaran Live</h2>
                    <p style="font-size: 14px; color: var(--text-gray); max-width: 600px;">Cek jalur yang sedang buka, akan dibuka, atau telah ditutup berdasarkan tanggal pendaftaran aktif.</p>
                </div>
                <div style="background: #111; color: #fff; padding: 12px 20px; border-radius: 12px; display: flex; align-items: center; gap: 10px; font-size: 13px;">
                    <i class="fa-solid fa-clock" style="color: #f1c40f;"></i>
                    <span>WAKTU SERVER: <strong id="live-clock" style="color: #f1c40f;"><?php echo date('D, d M Y, H:i:s'); ?></strong></span>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px;">
            <!-- Jalur Pindahan -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-right-left"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Jalur Pindahan</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Seleksi Mahasiswa Pindahan</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Seleksi khusus untuk mahasiswa pindahan dari perguruan tinggi terakreditasi.</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=Pindahan'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <button onclick="window.location.href='pendaftaran.html?jalur=Pindahan'" style="width: 100%; background: #222; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Daftar Sekarang</button>
                </div>
            </div>

            <!-- Nilai UTBK -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Nilai UTBK</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Seleksi Berdasarkan Nilai UTBK-SNBT</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Seleksi masuk perguruan tinggi menggunakan perolehan skor nilai UTBK nasional.</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=UTBK'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <button onclick="window.location.href='pendaftaran.html?jalur=UTBK'" style="width: 100%; background: #28a745; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Daftar Sekarang</button>
                </div>
            </div>

            <!-- Jalur Rapor -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Jalur Rapor</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Seleksi Berdasarkan Nilai Rapor</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Seleksi nilai akademik berdasarkan portofolio rapor SMA/SMK/MA sederajat.</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=Rapor'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <button onclick="window.location.href='pendaftaran.html?jalur=Rapor'" style="width: 100%; background: #333; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Daftar Sekarang</button>
                </div>
            </div>

            <!-- Mandiri Tulis Luring -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Mandiri Tulis Luring</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Ujian Tulis Luring di Kampus</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Ujian tulis berbasis komputer diselenggarakan langsung di Kampus Chula.</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=Mandiri_Luring'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <?php if ($pendaftar && isset($pendaftar['status_ujian']) && $pendaftar['status_ujian'] == 'Selesai'): ?>
                        <button disabled style="width: 100%; background: #6c757d; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: not-allowed;">Anda Sudah Ujian</button>
                    <?php else: ?>
                        <button onclick="window.location.href='login_ujian.php'" style="width: 100%; background: #d9534f; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Mulai Ujian Mandiri</button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mandiri Tulis Daring -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-laptop"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Mandiri Tulis Daring</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Ujian Daring dari Rumah</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Ujian tulis mandiri dari rumah/domisili masing-masing (Sistem Daring).</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=Mandiri_Daring'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <?php if ($pendaftar && isset($pendaftar['status_ujian']) && $pendaftar['status_ujian'] == 'Selesai'): ?>
                        <button disabled style="width: 100%; background: #6c757d; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: not-allowed;">Anda Sudah Ujian</button>
                    <?php else: ?>
                        <button onclick="window.location.href='login_ujian.php'" style="width: 100%; background: #00bcd4; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Mulai Ujian Mandiri</button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Jalur Prestasi -->
            <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                        <div style="width: 44px; height: 44px; background: #fdfaf6; border: 1px solid var(--border-color); color: var(--primary); border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 18px;">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <span style="background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">TUTUP</span>
                    </div>
                    <h3 style="font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">Jalur Prestasi</h3>
                    <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 15px; font-style: italic;">Seleksi Berdasarkan Prestasi</p>
                    <p style="font-size: 13px; color: var(--text-dark); margin-bottom: 20px; line-height: 1.5;">Khusus Ketua OSIS, Hafidz Al-Qur'an, Atlet, dan prestasi lain sesuai ketentuan.</p>
                </div>
                <div>
                    <button onclick="window.location.href='syarat_jalur.php?jalur=Prestasi'" style="width: 100%; background: transparent; border: 1px solid var(--border-color); color: var(--text-dark); padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer; margin-bottom: 10px;">Info & Syarat</button>
                    <button onclick="window.location.href='pendaftaran.html?jalur=Prestasi'" style="width: 100%; background: #ffc107; color: #111; border: none; padding: 10px; border-radius: 8px; font-weight: 600; font-size: 13px; cursor: pointer;">Daftar Sekarang</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="margin-top: 50px;">
        <div class="container">
            <div class="footer-bottom">
                &copy; 2026 Chula University. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>