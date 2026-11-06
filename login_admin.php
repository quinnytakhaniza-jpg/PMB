<?php
session_start();
$host = "localhost"; $user = "root"; $pass = ""; $db = "pmb_db";
$conn = new mysqli($host, $user, $pass, $db);

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek kredensial admin
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Username atau Password admin salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Chula University</title>
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
        .btn-submit { width: 100%; background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #360a0b; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 20px; text-align: center; }
        .back-link { display: inline-block; margin-top: 20px; font-size: 13px; color: #666; text-decoration: none; }
        .back-link:hover { color: var(--primary); text-decoration: underline; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login Administrator</h2>
        <p>Panel Kontrol PMB Chula University</p>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Tambahkan autocomplete="off" untuk mencegah browser asal isi -->
        <form action="" method="POST" autocomplete="off">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username admin" required>
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" name="login" class="btn-submit"><i class="fa-solid fa-lock"></i> Masuk Admin</button>
        </form>

        <a href="beranda.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>
</body>
</html>