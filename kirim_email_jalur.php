<?php
// Gunakan PHPMailer (Pastikan Anda sudah mengunduh/menginstal PHPMailer atau via Composer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Jika menggunakan manual folder PHPMailer, sesuaikan require di bawah:
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "pmb_db"; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tanggal hari ini (sesuaikan dengan waktu server, misal: 2026-05-01)
$tanggal_hari_ini = date('Y-m-d');

// Contoh logika: Misalkan hari ini adalah tanggal pembukaan Jalur Prestasi (13 Mei 2026)
// Atau Anda bisa mencocokkan dengan tanggal di database/pengaturan admin
$jalur_buka = "Jalur Prestasi";
$tanggal_buka_target = "2026-05-13"; 

if ($tanggal_hari_ini >= $tanggal_buka_target) {
    // Ambil semua email pendaftar yang sudah memiliki akun
    $query = "SELECT email, nama_lengkap FROM calon_mahasiswa";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tujuan_email = $row['email'];
            $nama_pendaftar = $row['nama_lengkap'];

            $mail = new PHPMailer(true);
            try {
                // Konfigurasi SMTP Gmail
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'email_kampus ANDA@gmail.com'; // Ganti dengan Gmail Anda
                $mail->Password   = 'App Password Gmail Anda';      // Ganti dengan App Password dari Google
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Pengirim dan Penerima
                $mail->setFrom('info@chula.ac.id', 'Chula University PMB');
                $mail->addAddress($tujuan_email, $nama_pendaftar);

                // Konten Email
                $mail->isHTML(true);
                $mail->Subject = "Pemberitahuan: $jalur_buka Telah Resmi Dibuka!";
                $mail->Body    = "
                    <h3>Halo, " . htmlspecialchars($nama_pendaftar) . "</h3>
                    <p>Kami menginformasikan bahwa seleksi masuk <b>$jalur_buka</b> di Chula University telah resmi dibuka hari ini.</p>
                    <p>Silakan login ke akun dashboard PMB Anda untuk melihat persyaratan lengkap dan segera melakukan pendaftaran.</p>
                    <br>
                    <p>Salam hangat,<br><b>Panitia PMB Chula University 2026</b></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                // Catat error jika gagal kirim ke email tertentu
                error_log("Gagal mengirim email ke {$tujuan_email}: {$mail->ErrorInfo}");
            }
        }
        echo "Notifikasi email berhasil diproses untuk semua pendaftar.";
    } else {
        echo "Belum ada pendaftar terdaftar di database.";
    }
} else {
    echo "Belum waktunya pembukaan jalur seleksi.";
}
?>