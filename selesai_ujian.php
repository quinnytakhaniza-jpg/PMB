<?php
session_start();
if (!isset($_SESSION['id_peserta'])) {
    header("Location: login_ujian.php");
    exit();
}

$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

$benar = 0;
$salah = 0;

if (isset($_POST['jawaban'])) {
    foreach ($_POST['jawaban'] as $id_soal => $jawaban_user) {
        $q = $conn->query("SELECT kunci_jawaban FROM soal_ujian WHERE id = $id_soal");
        $data = $q->fetch_assoc();
        if ($data['kunci_jawaban'] == $jawaban_user) {
            $benar++;
        } else {
            $salah++;
        }
    }
}

$total_soal = $conn->query("SELECT COUNT(*) as total FROM soal_ujian")->fetch_assoc()['total'];
$skor = ($total_soal > 0) ? ($benar / $total_soal) * 100 : 0;
$id_peserta = $_SESSION['id_peserta'];

// Simpan skor dan ubah status menjadi Selesai di database
$conn->query("UPDATE calon_mahasiswa SET status_ujian = 'Selesai', skor_ujian = '$skor' WHERE id = '$id_peserta'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Ujian - Chula University</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap">
    <style>
        :root { --primary: #4a1011; --bg-light: #fdfaf6; --border-color: #e5ded7; --white: #ffffff; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 40px; text-align: center; max-width: 450px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
        h2 { font-family: 'Playfair Display', serif; color: var(--primary); }
        .score { font-size: 48px; font-weight: 700; color: #28a745; margin: 20px 0; }
        .btn { display: inline-block; background: var(--primary); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Ujian Selesai!</h2>
        <p>Terima kasih <b><?php echo htmlspecialchars($_SESSION['peserta']); ?></b>, hasil Anda telah direkam.</p>
        <div class="score"><?php echo number_format($skor, 0); ?></div>
        <p>Jawaban Benar: <?php echo $benar; ?> | Salah: <?php echo $salah; ?></p>
        <a href="beranda.php" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>