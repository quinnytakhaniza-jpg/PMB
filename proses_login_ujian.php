<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_nomor = trim($_POST['nomor_pendaftaran']);
    
    // Ambil hanya angka dari input (misal: dari "#PMB-2026-014" diambil angkanya saja jadi "14")
    $id_bersih = preg_replace('/[^0-9]/', '', $input_nomor);
    
    // Jika input kosong atau tidak ada angka
    if (empty($id_bersih)) {
        echo "<script>alert('Nomor Pendaftaran tidak valid!'); window.location='login_ujian.php';</script>";
        exit();
    }
    
    // Cari berdasarkan ID angka yang bersih atau nama lengkap
    $query = "SELECT * FROM calon_mahasiswa WHERE id = '$id_bersih' OR nama_lengkap LIKE '%$input_nomor%'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Cek apakah sudah pernah ujian (opsional, jika ingin peserta melihat hasil tanpa mengulang)
        if (isset($data['status_ujian']) && $data['status_ujian'] == 'Selesai') {
            // Jika sudah selesai, tetap simpan sesi agar bisa akses dashboard melihat status/NIM
            $_SESSION['peserta'] = $data['nama_lengkap'];
            $_SESSION['id_peserta'] = $data['id'];
            $_SESSION['email_pendaftar'] = $data['email'];
            $_SESSION['prodi_peserta'] = $data['jurusan'];
            
            header("Location: dashboard.php");
            exit();
        }

        // SIMPAN SEMUA SESSION DENGAN LENGKAP
        $_SESSION['peserta'] = $data['nama_lengkap'];
        $_SESSION['id_peserta'] = $data['id'];
        $_SESSION['email_pendaftar'] = $data['email']; // Agar beranda & dashboard mendeteksi akun login
        $_SESSION['prodi_peserta'] = $data['jurusan']; // Agar soal ujian otomatis terfilter sesuai prodi

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Nomor Pendaftaran tidak ditemukan di database!'); window.location='login_ujian.php';</script>";
    }
}
?>