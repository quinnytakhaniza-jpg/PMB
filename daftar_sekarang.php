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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama    = $_POST['nama'] ?? '';
    $email   = $_POST['email'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $jurusan = $_POST['jurusan'] ?? '';
    $jalur   = $_POST['jalur'] ?? 'Umum';

    if (!empty($nama) && !empty($email) && !empty($telepon) && !empty($jurusan)) {
        
        $sql = "INSERT INTO calon_mahasiswa (nama_lengkap, email, telepon, jurusan, jalur) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error pada kueri SQL: " . $conn->error);
        }

        $stmt->bind_param("sssss", $nama, $email, $telepon, $jurusan, $jalur);

        if ($stmt->execute()) {
            // AMBIL ID UNIK DARI DATA YANG BARU SAJA MASUK
            $id_baru = $conn->insert_id;

            // SIMPAN KE SESSION BERDASARKAN ID TERSEBUT
            $_SESSION['id_peserta'] = $id_baru;
            $_SESSION['email_pendaftar'] = $email;
            $_SESSION['prodi_peserta'] = $jurusan;
            $_SESSION['peserta'] = $nama;

            echo "<script>window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan: " . $stmt->error . "'); window.location.href = 'pilih_jalur.html';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Semua kolom wajib diisi!'); window.location.href = 'pilih_jalur.html';</script>";
    }
} else {
    header("Location: pilih_jalur.html");
    exit();
}

$conn->close();
?>