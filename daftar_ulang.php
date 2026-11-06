<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

if (!isset($_SESSION['id_peserta'])) {
    header("Location: login_ujian.php");
    exit();
}

$id_peserta = $_SESSION['id_peserta'];

// Ambil data peserta terbaru
$data = $conn->query("SELECT * FROM calon_mahasiswa WHERE id = $id_peserta")->fetch_assoc();

// Proses submit daftar ulang
if (isset($_POST['proses_daftar_ulang'])) {
    $conn->query("UPDATE calon_mahasiswa SET status_daftar_ulang = 'Menunggu Verifikasi' WHERE id = $id_peserta");
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ulang - Chula University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="pendaftaran.css">
</head>
<body>
    <div class="container" style="max-width: 600px; margin-top: 50px;">
        <div style="text-align: center; margin-bottom: 25px;">
            <h2 style="font-family: 'Playfair Display', serif; color: var(--primary);">Registrasi Daftar Ulang</h2>
            <p class="subtitle">Lakukan konfirmasi daftar ulang untuk mengaktifkan status mahasiswa baru dan mendapatkan NIM.</p>
        </div>

        <div style="background: var(--white); border: 1px solid var(--border-color); border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
            <div style="margin-bottom: 20px; font-size: 14px;">
                <p><b>Nama Lengkap:</b> <?php echo htmlspecialchars($data['nama_lengkap']); ?></p>
                <p><b>Program Studi:</b> <?php echo htmlspecialchars($data['jurusan']); ?></p>
                <p><b>Skor Ujian:</b> <?php echo isset($data['skor_ujian']) ? number_format($data['skor_ujian'], 2) : '0'; ?> / 100</p>
                <p><b>Status Saat Ini:</b> <span style="color: #28a745; font-weight: 600;"><?php echo htmlspecialchars($data['status_daftar_ulang']); ?></span></p>
            </div>

            <?php if ($data['status_daftar_ulang'] == 'Belum Daftar Ulang'): ?>
                <form action="" method="POST">
                    <p style="font-size: 13px; color: var(--text-gray); margin-bottom: 20px;">
                        Dengan menekan tombol di bawah, Anda menyatakan bersedia menjadi mahasiswa Chula University dan mematuhi seluruh peraturan akademik yang berlaku.
                    </p>
                    <button type="submit" name="proses_daftar_ulang" class="btn-primary" style="width: 100%; padding: 12px; cursor: pointer;">
                        <i class="fa-solid fa-file-invoice"></i> Konfirmasi Daftar Ulang Sekarang
                    </button>
                </form>
            <?php else: ?>
                <div style="background: #e6f4ea; color: #137333; padding: 15px; border-radius: 8px; text-align: center; font-weight: 600; font-size: 14px;">
                    <i class="fa-solid fa-circle-check"></i> Pengajuan daftar ulang Anda telah dikirim. Menunggu verifikasi admin untuk penerbitan NIM.
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin-top: 20px;">
                <a href="dashboard.php" style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 13px;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>