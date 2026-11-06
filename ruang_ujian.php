<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

// Pastikan peserta sudah login ujian
if (!isset($_SESSION['id_peserta'])) {
    header("Location: login_ujian.php");
    exit();
}

$id_peserta = $_SESSION['id_peserta'];
$prodi_peserta = $_SESSION['prodi_peserta'];

// Ambil soal ujian HANYA yang sesuai dengan program studi peserta
$prodi_esc = $conn->real_escape_string($prodi_peserta);
$result_soal = $conn->query("SELECT * FROM soal_ujian WHERE prodi = '$prodi_esc'");

// Proses jika tombol selesai/kirim ujian diklik
if (isset($_POST['selesai_ujian'])) {
    $jawaban_user = isset($_POST['jawaban']) ? $_POST['jawaban'] : [];
    $benar = 0;
    $total_soal = ($result_soal) ? $result_soal->num_rows : 0;

    if ($total_soal > 0) {
        $result_soal->data_seek(0);
        while ($soal = $result_soal->fetch_assoc()) {
            $id_s = $soal['id'];
            if (isset($jawaban_user[$id_s]) && $jawaban_user[$id_s] === $soal['kunci_jawaban']) {
                $benar++;
            }
        }
        $skor = ($benar / $total_soal) * 100;
    } else {
        $skor = 0;
    }

    // Update status dan skor ujian ke database peserta
    $stmt_update = $conn->prepare("UPDATE calon_mahasiswa SET status_ujian = 'Selesai', skor_ujian = ? WHERE id = ?");
    $stmt_update->bind_param("di", $skor, $id_peserta);
    $stmt_update->execute();

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian Seleksi Mandiri - Chula University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4a1011; --bg-light: #fdfaf6; --border-color: #e5ded7; --white: #ffffff; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: #222; margin: 0; padding: 20px; }
        .exam-container { max-width: 800px; margin: 0 auto; background: var(--white); border: 1px solid var(--border-color); border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
        .exam-header { border-bottom: 1px solid var(--border-color); padding-bottom: 15px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .soal-card { background: #fcf9f5; border: 1px solid var(--border-color); border-radius: 10px; padding: 20px; margin-bottom: 20px; }
        .options label { display: block; padding: 8px 12px; margin-top: 8px; background: white; border: 1px solid var(--border-color); border-radius: 6px; cursor: pointer; font-size: 14px; }
        .options label:hover { background: #f1ede6; }
        .btn-submit { background: var(--primary); color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 15px; display: block; width: 100%; margin-top: 30px; }
        .btn-submit:hover { background: #360a0b; }
    </style>
</head>
<body>

    <div class="exam-container">
        <div class="exam-header">
            <div>
                <h2 style="margin: 0; font-family: 'Playfair Display', serif; color: var(--primary);">Ujian Seleksi Mandiri</h2>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: #666;">Peserta: <b><?php echo htmlspecialchars($_SESSION['nama_peserta'] ?? 'Peserta'); ?></b></p>
            </div>
            <div style="text-align: right;">
                <span style="background: #e6f4ea; color: #137333; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                    Prodi: <?php echo htmlspecialchars($prodi_peserta); ?>
                </span>
            </div>
        </div>

        <?php if ($result_soal && $result_soal->num_rows > 0): ?>
            <form action="" method="POST">
                <?>
                <?php 
                $no = 1;
                while ($soal = $result_soal->fetch_assoc()): 
                ?>
                    <div class="soal-card">
                        <p style="font-weight: 600; margin-top: 0; font-size: 15px;">
                            <?php echo $no++; ?>. <?php echo htmlspecialchars($soal['pertanyaan']); ?>
                        </p>
                        <div class="options">
                            <!-- DIPERBAIKI MENJADI pilihan_a, pilihan_b, pilihan_c, pilihan_d -->
                            <label><input type="radio" name="jawaban[<?php echo $soal['id']; ?>]" value="A" required> A. <?php echo htmlspecialchars($soal['pilihan_a']); ?></label>
                            <label><input type="radio" name="jawaban[<?php echo $soal['id']; ?>]" value="B"> B. <?php echo htmlspecialchars($soal['pilihan_b']); ?></label>
                            <label><input type="radio" name="jawaban[<?php echo $soal['id']; ?>]" value="C"> C. <?php echo htmlspecialchars($soal['pilihan_c']); ?></label>
                            <label><input type="radio" name="jawaban[<?php echo $soal['id']; ?>]" value="D"> D. <?php echo htmlspecialchars($soal['pilihan_d']); ?></label>
                        </div>
                    </div>
                <?php endwhile; ?>

                <button type="submit" name="selesai_ujian" class="btn-submit" onclick="return confirm('Yakin ingin mengumpulkan jawaban ujian?')">
                    <i class="fa-solid fa-paper-plane"></i> Selesai & Kirim Jawaban
                </button>
            </form>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 40px; color: #d9534f; margin-bottom: 15px;"></i>
                <h3>Soal Ujian Belum Tersedia</h3>
                <p>Maaf, bank soal untuk program studi <b><?php echo htmlspecialchars($prodi_peserta); ?></b> belum diunggah oleh administrator.</p>
                <a href="dashboard.php" style="display: inline-block; margin-top: 15px; color: var(--primary); font-weight: 600; text-decoration: none;">Kembali ke Dashboard</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>