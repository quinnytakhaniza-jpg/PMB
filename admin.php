<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$prodi_list = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen', 'Psikologi', 'Ilmu Komunikasi', 'Kepelatihan Olahraga'];

// Aksi Update Program Studi & Status Pendaftar (Data Maba)
if (isset($_POST['update_maba'])) {
    $id_maba = intval($_POST['id_maba']);
    $jurusan = $conn->real_escape_string($_POST['jurusan']);
    $status_kelulusan = $conn->real_escape_string($_POST['status_kelulusan']);
    
    $conn->query("UPDATE calon_mahasiswa SET jurusan = '$jurusan', status_ujian = '$status_kelulusan' WHERE id = $id_maba");
    header("Location: admin.php?page=pendaftaran");
    exit();
}

// Aksi Hapus Pendaftar
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    $conn->query("DELETE FROM calon_mahasiswa WHERE id = $id_hapus");
    header("Location: admin.php?page=pendaftaran");
    exit();
}

// Aksi Setujui Daftar Ulang & Terbitkan NIM
if (isset($_GET['terbitkan_nim'])) {
    $id_maba = intval($_GET['terbitkan_nim']);
    $maba_data = $conn->query("SELECT * FROM calon_mahasiswa WHERE id = $id_maba")->fetch_assoc();
    
    if ($maba_data && empty($maba_data['nim'])) {
        $nim_baru = "2026" . str_pad($maba_data['id'], 4, '0', STR_PAD_LEFT);
        $conn->query("UPDATE calon_mahasiswa SET status_daftar_ulang = 'Selesai', nim = '$nim_baru' WHERE id = $id_maba");
    }
    header("Location: admin.php?page=daftar-ulang");
    exit();
}

// Aksi Tambah Soal Ujian Baru (DIJAMIN MASUK DENGAN PENANGANAN ERROR)
if (isset($_POST['tambah_soal'])) {
    $prodi = $conn->real_escape_string($_POST['prodi']);
    $pertanyaan = $conn->real_escape_string($_POST['pertanyaan']);
    $opsi_a = $conn->real_escape_string($_POST['opsi_a']);
    $opsi_b = $conn->real_escape_string($_POST['opsi_b']);
    $opsi_c = $conn->real_escape_string($_POST['opsi_c']);
    $opsi_d = $conn->real_escape_string($_POST['opsi_d']);
    $jawaban_benar = $conn->real_escape_string($_POST['jawaban_benar']);

    $sql = "INSERT INTO soal_ujian (prodi, pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, kunci_jawaban) 
            VALUES ('$prodi', '$pertanyaan', '$opsi_a', '$opsi_b', '$opsi_c', '$opsi_d', '$jawaban_benar')";
    
    if (!$conn->query($sql)) {
        // Jika nama kolom di database Anda berbeda (misal opsi_a bukan pilihan_a), errornya akan muncul di sini
        die("Gagal menyimpan soal ke database: " . $conn->error);
    }

    header("Location: admin.php?page=soal");
    exit();
}

// Statistik ringkasan
$total_pendaftar = $conn->query("SELECT COUNT(*) as total FROM calon_mahasiswa")->fetch_assoc()['total'];
$sudah_tes = $conn->query("SELECT COUNT(*) as total FROM calon_mahasiswa WHERE status_ujian = 'Selesai'")->fetch_assoc()['total'];
$lulus_tes = $conn->query("SELECT COUNT(*) as total FROM calon_mahasiswa WHERE status_ujian = 'Selesai'")->fetch_assoc()['total']; 
$daftar_ulang = $conn->query("SELECT COUNT(*) as total FROM calon_mahasiswa WHERE status_daftar_ulang = 'Selesai'")->fetch_assoc()['total']; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - PMB Jalur Mandiri</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4a1011; --sidebar-bg: #1e1e2d; --bg-light: #fdfaf6; --border-color: #e5ded7; --white: #ffffff; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-light); color: #222; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 260px; background: var(--sidebar-bg); color: #a2a5b9; display: flex; flex-direction: column; justify-content: space-between; position: fixed; height: 100%; box-sizing: border-box; }
        .sidebar-brand { padding: 25px 20px; font-size: 16px; font-weight: 700; color: white; border-bottom: 1px solid rgba(255,255,255,0.08); font-family: 'Playfair Display', serif; }
        .sidebar-brand span { display: block; font-size: 11px; color: #6c7293; font-family: 'Inter', sans-serif; letter-spacing: 1px; margin-top: 3px; }
        .sidebar-menu { list-style: none; padding: 0; margin: 20px 0; flex-grow: 1; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: #a2a5b9; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s; }
        .sidebar-menu li.active a, .sidebar-menu li a:hover { background: rgba(255,255,255,0.05); color: white; border-left: 4px solid #f1c40f; }
        .sidebar-footer { padding: 20px; border-top: 1px solid rgba(255,255,255,0.08); }
        .btn-keluar { display: block; color: #f87171; text-decoration: none; font-size: 14px; font-weight: 550; }
        .main-content { margin-left: 260px; flex-grow: 1; padding: 30px; box-sizing: border-box; }
        .top-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }
        .top-header h2 { font-family: 'Playfair Display', serif; color: var(--primary); margin: 0; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--white); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .stat-card p { margin: 0 0 8px 0; font-size: 12px; color: #666; font-weight: 600; text-transform: uppercase; }
        .stat-card h3 { margin: 0; font-size: 26px; color: var(--primary); font-family: 'Inter', sans-serif; }
        .quick-menu { background: var(--white); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px; margin-bottom: 30px; }
        .quick-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
        .q-btn { background: #111; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; }
        .q-btn.amber { background: #d97706; }
        .card { background: var(--white); border: 1px solid var(--border-color); border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 13px; }
        th, td { border-bottom: 1px solid var(--border-color); padding: 14px 10px; text-align: left; vertical-align: middle; }
        th { color: #555; font-weight: 600; font-size: 12px; background: #fcf9f5; text-transform: uppercase; }
        tr:hover { background-color: #fdfaf6; }
        .badge-lulus { background: #198754; color: white; padding: 5px 12px; border-radius: 4px; font-size: 11px; font-weight: 700; }
        .btn-danger { background: #d9534f; color: white; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; border: none; cursor: pointer; }
        .btn-success { background: #28a745; color: white; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; border: none; display: inline-block; }
        .btn-simpan { background: #111; color: white; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; margin-top: 10px; }
        select.form-control, input.form-control, textarea.form-control { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; font-size: 13px; background: #fff; margin-bottom: 12px; box-sizing: border-box; }
        .bank-soal-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        .form-section, .summary-section { background: #fff; border: 1px solid var(--border-color); border-radius: 10px; padding: 20px; }
        .summary-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; font-size: 13px; }
    </style>
</head>
<body>

    <div class="sidebar">
        <div>
            <div class="sidebar-brand">
                CHULA UNIVERSITY
                <span>Panel Admin - PMB Jalur Mandiri</span>
            </div>
            <ul class="sidebar-menu">
                <li class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>"><a href="admin.php?page=dashboard"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class="<?php echo ($page == 'pendaftaran') ? 'active' : ''; ?>"><a href="admin.php?page=pendaftaran"><i class="fa-solid fa-users"></i> Data Calon Maba</a></li>
                <li class="<?php echo ($page == 'soal') ? 'active' : ''; ?>"><a href="admin.php?page=soal"><i class="fa-solid fa-book-open"></i> Bank Soal</a></li>
                <li class="<?php echo ($page == 'hasil') ? 'active' : ''; ?>"><a href="admin.php?page=hasil"><i class="fa-solid fa-square-poll-vertical"></i> Hasil Tes</a></li>
                <li class="<?php echo ($page == 'daftar-ulang') ? 'active' : ''; ?>"><a href="admin.php?page=daftar-ulang"><i class="fa-solid fa-file-invoice"></i> Daftar Ulang</a></li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="logout_admin.php" class="btn-keluar"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-header">
            <div>
                <h2>
                    <?php 
                        if($page == 'pendaftaran') echo 'Data Calon Maba';
                        elseif($page == 'soal') echo 'Bank Soal Tes';
                        elseif($page == 'hasil') echo 'Hasil Tes';
                        elseif($page == 'daftar-ulang') echo 'Verifikasi Daftar Ulang & Terbitkan NIM';
                        else echo 'Dashboard Admin';
                    ?>
                </h2>
                <p style="margin: 4px 0 0 0; font-size: 13px; color: #666;">Ringkasan monitoring Penerimaan Mahasiswa Baru tahun akademik 2026/2027.</p>
            </div>
            <div style="font-size: 13px; color: #555; font-weight: 500;"><i class="fa-regular fa-user-circle"></i> Administrator</div>
        </div>

        <?php if ($page == 'dashboard'): ?>
            <div class="stats-grid">
                <div class="stat-card"><p>Total Pendaftar</p><h3><?php echo $total_pendaftar; ?></h3></div>
                <div class="stat-card"><p>Sudah Tes</p><h3><?php echo $sudah_tes; ?></h3></div>
                <div class="stat-card"><p>Lulus Tes</p><h3><?php echo $lulus_tes; ?></h3></div>
                <div class="stat-card"><p>Daftar Ulang Valid</p><h3><?php echo $daftar_ulang; ?></h3></div>
            </div>
            <div class="quick-menu">
                <h4>Menu Cepat</h4>
                <div class="quick-buttons">
                    <a href="admin.php?page=pendaftaran" class="q-btn"><i class="fa-solid fa-users"></i> Kelola Calon Maba</a>
                    <a href="admin.php?page=soal" class="q-btn"><i class="fa-solid fa-book-open"></i> Kelola Soal Tes</a>
                    <a href="admin.php?page=daftar-ulang" class="q-btn amber"><i class="fa-solid fa-file-invoice"></i> Verifikasi Daftar Ulang</a>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <?php if ($page == 'pendaftaran'): ?>
                <h3 style="margin-top: 0; font-size: 18px; color: var(--primary);">Data Calon Maba</h3>
                <table>
                    <thead>
                        <tr><th>Nomor / Nama</th><th>Kontak</th><th>Prodi & Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM calon_mahasiswa ORDER BY id DESC");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><b>SM-2027-<?php echo str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></b><br><b><?php echo htmlspecialchars($row['nama_lengkap']); ?></b></td>
                            <td><?php echo htmlspecialchars($row['email']); ?><br><?php echo htmlspecialchars($row['telepon']); ?></td>
                            <td style="width: 280px;">
                                <form action="admin.php?page=pendaftaran" method="POST">
                                    <input type="hidden" name="id_maba" value="<?php echo $row['id']; ?>">
                                    <select name="jurusan" class="form-control">
                                        <?php foreach($prodi_list as $p): ?>
                                            <option value="<?php echo $p; ?>" <?php if($row['jurusan'] == $p) echo 'selected'; ?>><?php echo $p; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select name="status_kelulusan" class="form-control">
                                        <option value="Selesai" <?php if(isset($row['status_ujian']) && $row['status_ujian'] == 'Selesai') echo 'selected'; ?>>Selesai / Lulus</option>
                                        <option value="Belum Ujian" <?php if(!isset($row['status_ujian']) || $row['status_ujian'] != 'Selesai') echo 'selected'; ?>>Belum Ujian</option>
                                    </select>
                                    <button type="submit" name="update_maba" class="btn-simpan">Simpan</button>
                                </form>
                            </td>
                            <td><a href="admin.php?page=pendaftaran&hapus=<?php echo $row['id']; ?>" class="btn-danger" onclick="return confirm('Hapus data?')">Hapus</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php elseif ($page == 'soal'): ?>
                <h3 style="margin-top: 0; font-size: 18px; color: var(--primary); margin-bottom: 20px;">Bank Soal Tes</h3>
                <div class="bank-soal-grid">
                    <div class="form-section">
                        <h4 style="margin-top: 0;">Tambah Soal</h4>
                        <!-- FORM DIPERBAIKI (ACTION DIKOSONGKAN AGAR POST JALAN DENGAN LANCAR) -->
                        <form action="" method="POST">
                            <label style="font-size: 12px; font-weight: 600;">Program Studi</label>
                            <select name="prodi" class="form-control" required>
                                <option value="">-- Pilih Program Studi --</option>
                                <?php foreach($prodi_list as $p): ?>
                                    <option value="<?php echo $p; ?>"><?php echo $p; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label style="font-size: 12px; font-weight: 600;">Pertanyaan</label>
                            <textarea name="pertanyaan" class="form-control" rows="3" required></textarea>
                            <label style="font-size: 12px; font-weight: 600;">Opsi A</label><input type="text" name="opsi_a" class="form-control" required>
                            <label style="font-size: 12px; font-weight: 600;">Opsi B</label><input type="text" name="opsi_b" class="form-control" required>
                            <label style="font-size: 12px; font-weight: 600;">Opsi C</label><input type="text" name="opsi_c" class="form-control" required>
                            <label style="font-size: 12px; font-weight: 600;">Opsi D</label><input type="text" name="opsi_d" class="form-control" required>
                            <label style="font-size: 12px; font-weight: 600;">Jawaban Benar (A/B/C/D)</label><input type="text" name="jawaban_benar" class="form-control" maxlength="1" required>
                            <button type="submit" name="tambah_soal" class="btn-simpan">Simpan Soal</button>
                        </form>
                    </div>
                    <div class="summary-section">
                        <h4 style="margin-top: 0;">Ringkasan Bank Soal</h4>
                        <?php foreach($prodi_list as $p): 
                            $jml = $conn->query("SELECT COUNT(*) as j FROM soal_ujian WHERE prodi = '$p'")->fetch_assoc()['j'];
                        ?>
                        <div class="summary-item"><span><?php echo $p; ?></span><b><?php echo $jml; ?> soal</b></div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php elseif ($page == 'hasil'): ?>
                <h3 style="margin-top: 0; font-size: 18px; color: var(--primary);">Hasil Tes Ujian</h3>
                <table>
                    <thead><tr><th>No Tes</th><th>Nama</th><th>Prodi</th><th>Nilai</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM calon_mahasiswa WHERE status_ujian = 'Selesai'");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><b>SM-2027-<?php echo str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></b></td>
                            <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                            <td><b><?php echo number_format($row['skor_ujian'], 2); ?></b></td>
                            <td><span class="badge-lulus">Lulus</span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php elseif ($page == 'daftar-ulang'): ?>
                <h3 style="margin-top: 0; font-size: 18px; color: var(--primary); margin-bottom: 5px;">Verifikasi Daftar Ulang & Terbitkan NIM</h3>
                <p style="font-size: 13px; color: #666; margin-bottom: 20px;">Setujui pengajuan daftar ulang peserta untuk menerbitkan Nomor Induk Mahasiswa (NIM).</p>
                <table>
                    <thead>
                        <tr>
                            <th>Nama & Kontak</th>
                            <th>Program Studi</th>
                            <th>Status Daftar Ulang</th>
                            <th>Nomor Induk Mahasiswa (NIM)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM calon_mahasiswa WHERE status_ujian = 'Selesai' ORDER BY id DESC");
                        if ($res->num_rows > 0):
                            while($row = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><b><?php echo htmlspecialchars($row['nama_lengkap']); ?></b><br><span style="font-size: 12px; color: #666;"><?php echo htmlspecialchars($row['email']); ?></span></td>
                            <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                            <td>
                                <span style="font-weight: 600; color: <?php echo ($row['status_daftar_ulang'] == 'Selesai') ? '#28a745' : '#d97706'; ?>;">
                                    <?php echo htmlspecialchars($row['status_daftar_ulang']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($row['nim'])): ?>
                                    <b style="color: #198754; font-size: 14px; background: #e6f4ea; padding: 4px 10px; border-radius: 6px; display: inline-block;"><?php echo $row['nim']; ?></b>
                                <?php else: ?>
                                    <span style="color: #999; font-style: italic;">Belum diterbitkan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (empty($row['nim'])): ?>
                                    <a href="admin.php?page=daftar-ulang&terbitkan_nim=<?php echo $row['id']; ?>" class="btn-success" onclick="return confirm('Setujui daftar ulang dan terbitkan NIM untuk peserta ini?')">
                                        <i class="fa-solid fa-check"></i> Terbitkan NIM
                                    </a>
                                <?php else: ?>
                                    <span style="color: #666; font-size: 12px; font-weight: 600;"><i class="fa-solid fa-circle-check"></i> Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; else: ?>
                        <tr><td colspan="5" style="text-align: center; color: #666; padding: 20px;">Belum ada peserta yang menyelesaikan ujian.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <h3 style="margin-top: 0; font-size: 18px; color: var(--primary);">Pendaftar Terbaru</h3>
                <table>
                    <thead><tr><th>ID</th><th>Nama</th><th>Prodi</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM calon_mahasiswa ORDER BY id DESC LIMIT 5");
                        while($row = $res->fetch_assoc()):
                        ?>
                        <tr>
                            <td><b>#<?php echo $row['id']; ?></b></td>
                            <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                            <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                            <td><span class="badge-lulus">Aktif</span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>