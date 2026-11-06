<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data berdasarkan session ID atau Email peserta yang sedang aktif login
if (isset($_SESSION['id_peserta'])) {
    $id_sess = $_SESSION['id_peserta'];
    $query = "SELECT * FROM calon_mahasiswa WHERE id = '$id_sess' LIMIT 1";
} elseif (isset($_SESSION['email_pendaftar'])) {
    $email_sess = $_SESSION['email_pendaftar'];
    $query = "SELECT * FROM calon_mahasiswa WHERE email = '$email_sess' LIMIT 1";
} else {
    // Jika tidak ada session, arahkan kembali ke beranda atau login
    header("Location: beranda.php");
    exit();
}

$result = $conn->query($query);
$data = ($result) ? $result->fetch_assoc() : null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaftaran - Chula University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="pendaftaran.css">
    <style>
        .dashboard-card { text-align: left; margin-top: 20px; }
        .status-badge { display: inline-block; background-color: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        .info-row span:first-child { color: var(--text-gray); font-weight: 500; }
        .info-row span:last-child { color: var(--text-dark); font-weight: 600; }
        .btn-group { display: flex; gap: 10px; margin-top: 25px; flex-wrap: wrap; }
        .btn-exam { width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; margin-top: 15px; display: block; text-align: center; text-decoration: none; }
        .btn-exam:hover { background: #218838; }
        .btn-daftar-ulang { width: 100%; padding: 12px; background: #ffc107; color: #111; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; margin-top: 15px; display: block; text-align: center; text-decoration: none; }
        .btn-daftar-ulang:hover { background: #e0a800; }
    </style>
</head>
<body>

    <div class="container" style="max-width: 600px;">
        <div style="text-align: center;">
            <i class="fa-solid fa-circle-check" style="font-size: 48px; color: #28a745; margin-bottom: 15px;"></i>
            <h2>Dashboard Pendaftaran</h2>
            <p class="subtitle">Status seleksi dan informasi akademik calon mahasiswa.</p>
        </div>

        <?php if ($data): ?>
            <div class="dashboard-card">
                <div style="text-align: center;">
                    <span class="status-badge"><i class="fa-solid fa-check"></i> Status: Pendaftaran Aktif</span>
                </div>
                
                <div class="info-row">
                    <span>Nomor Pendaftaran</span>
                    <span>#PMB-2026-<?php echo str_pad($data['id'], 3, '0', STR_PAD_LEFT); ?></span>
                </div>
                <div class="info-row">
                    <span>Jalur Pendaftaran</span>
                    <span><?php echo htmlspecialchars($data['jalur']); ?></span>
                </div>
                <div class="info-row">
                    <span>Nama Lengkap</span>
                    <span><?php echo htmlspecialchars($data['nama_lengkap']); ?></span>
                </div>
                <div class="info-row">
                    <span>Email Aktif</span>
                    <span><?php echo htmlspecialchars($data['email']); ?></span>
                </div>
                <div class="info-row">
                    <span>Nomor Telepon / WA</span>
                    <span><?php echo htmlspecialchars($data['telepon']); ?></span>
                </div>
                <div class="info-row">
                    <span>Program Studi Pilihan</span>
                    <span><?php echo htmlspecialchars($data['jurusan']); ?></span>
                </div>
                <div class="info-row">
                    <span>Status Ujian</span>
                    <span style="color: <?php echo (isset($data['status_ujian']) && $data['status_ujian'] == 'Selesai') ? '#28a745' : '#d9534f'; ?>;">
                        <?php echo (isset($data['status_ujian']) && $data['status_ujian'] == 'Selesai') ? 'Selesai (Skor: ' . number_format($data['skor_ujian'], 2) . ')' : 'Belum Ujian'; ?>
                    </span>
                </div>
                <div class="info-row">
                    <span>Status Daftar Ulang</span>
                    <span style="color: #2b6cb0; font-weight: 700;">
                        <?php echo htmlspecialchars($data['status_daftar_ulang'] ?? 'Belum Daftar Ulang'); ?>
                    </span>
                </div>
                <div class="info-row" style="background: #fdfaf6; padding: 12px; border-radius: 8px; margin-top: 5px;">
                    <span style="color: var(--primary); font-weight: 700;">Nomor Induk Mahasiswa (NIM)</span>
                    <span style="font-size: 16px; color: #198754;">
                        <?php echo !empty($data['nim']) ? $data['nim'] : '<em style="color:#999; font-weight:normal;">Belum diterbitkan</em>'; ?>
                    </span>
                </div>

                <!-- Tombol aksi ujian / daftar ulang -->
                <?php if (!isset($data['status_ujian']) || $data['status_ujian'] != 'Selesai'): ?>
                    <a href="login_ujian.php" class="btn-exam"><i class="fa-solid fa-pen-to-square"></i> Mulai Ujian Seleksi Sekarang</a>
                <?php else: ?>
                    <?php if (empty($data['nim'])): ?>
                        <a href="daftar_ulang.php" class="btn-daftar-ulang"><i class="fa-solid fa-file-invoice"></i> Lakukan Daftar Ulang Sekarang</a>
                    <?php else: ?>
                        <div style="background: #e6f4ea; color: #137333; padding: 12px; border-radius: 6px; text-align: center; font-weight: 600; margin-top: 15px; font-size: 14px;">
                            <i class="fa-solid fa-graduation-cap"> Selamat! Anda resmi menjadi Mahasiswa Chula University.</i>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Tombol Navigasi & Keluar -->
                <div class="btn-group">
                    <button type="button" onclick="window.location.href='beranda.php'" style="flex: 1; min-width: 130px; padding: 12px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Kembali ke Beranda</button>
                    <button type="button" onclick="window.print()" style="flex: 1; min-width: 110px; padding: 12px; background: #4a1011; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;"><i class="fa-solid fa-print"></i> Cetak Bukti</button>
                    <a href="logout.php" onclick="return confirm('Yakin ingin keluar akun?')" style="flex: 1; min-width: 90px; padding: 12px; background: #dc3545; color: white; border-radius: 6px; text-align: center; text-decoration: none; font-weight: 600; box-sizing: border-box;"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: var(--text-gray);">Belum ada data pendaftaran yang ditemukan.</p>
            <div style="text-align: center; margin-top: 20px;">
                <a href="pilih_jalur.html" class="btn-primary" style="padding: 10px 20px; display: inline-block; text-decoration: none;">Pilih Jalur Pendaftaran</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>