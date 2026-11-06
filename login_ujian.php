<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

if (isset($_POST['login_ujian'])) {
    $nomor_pendaftaran = trim($_POST['nomor_pendaftaran']);
    
    // Ekstrak ID dari format nomor pendaftaran (misal: #PMB-2026-016 atau angka langsung)
    $id_peserta = intval(preg_replace('/[^0-9]/', '', $nomor_pendaftaran));

    // Cek ke database tabel calon_mahasiswa
    $stmt = $conn->prepare("SELECT * FROM calon_mahasiswa WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id_peserta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Simpan sesi peserta termasuk program studinya
        $_SESSION['id_peserta'] = $data['id'];
        $_SESSION['nama_peserta'] = $data['nama_lengkap'];
        $_SESSION['prodi_peserta'] = $data['jurusan'];

        header("Location: ruang_ujian.php");
        exit();
    } else {
        $error = "Nomor Pendaftaran tidak ditemukan di database!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Ujian - Chula University</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4a1011; --bg-light: #fdfaf6; --border-color: #e5ded7; --white: #ffffff; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: #222; margin: 0; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-card { background: var(--white); border: 1px solid var(--border-color); border-radius: 20px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); text-align: center; }
        h2 { font-family: 'Playfair Display', serif; color: var(--primary); margin-bottom: 5px; }
        p { font-size: 13px; color: #666; margin-bottom: 25px; }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; font-size: 12px; font-weight: 600; color: var(--primary); margin-bottom: 6px; }
        input { width: 100%; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; box-sizing: border-box; }
        .btn-submit { width: 100%; background: #28a745; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #218838; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: center; }
        .back-link { display: inline-block; margin-top: 20px; font-size: 13px; color: #666; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login Ujian Seleksi</h2>
        <p>Masukkan Nomor Pendaftaran Anda</p>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group">
                <label>Nomor Pendaftaran</label>
                <input type="text" name="nomor_pendaftaran" placeholder="Contoh: 16 atau #PMB-2026-016" required>
            </div>
            <button type="submit" name="login_ujian" class="btn-submit"><i class="fa-solid fa-right-to-bracket"></i> Masuk Ruang Ujian</button>
        </form>

        <a href="dashboard.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
</body>
</html>