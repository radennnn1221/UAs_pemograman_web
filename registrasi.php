<?php
session_start();
require 'koneksi.php';

// Jika pengguna sudah login, alihkan ke halaman yang sesuai
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas') {
        header("Location: dashboard.php");
        exit;
    } else {
        header("Location: user.php");
        exit;
    }
}

$error = '';
$success = '';

// Proses form jika metode adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $role = 'customer'; // Role diatur secara otomatis menjadi customer

    // Validasi
    if (empty($nama_lengkap) || empty($username) || empty($password)) {
        $error = "Semua kolom wajib diisi!";
    } elseif ($password !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $stmt_check = $koneksi->prepare("SELECT id_user FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Hash password untuk keamanan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Masukkan data ke database
            $stmt = $koneksi->prepare("INSERT INTO users (nama_lengkap, username, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama_lengkap, $username, $hashed_password, $role);

            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan <a href='login_web.php'>login</a>.";
            } else {
                $error = "Terjadi kesalahan. Silakan coba lagi.";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style_login_web.css"> </head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="welcome-text">
                <h1>Bergabunglah</h1>
                <p>dengan KenZo Store</p>
            </div>
            <img src="foto/sepatu 3.jpg" alt="Ilustrasi Latar Belakang" class="left-panel-image">
        </div>
        <div class="right-panel">
            <div class="login-form">
                <h2>REGISTRASI</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form action="registrasi.php" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" name="konfirmasi_password" placeholder="Konfirmasi Password" required>
                    </div>
                    <button type="submit" class="login-button">DAFTAR</button>
                    <p class="register-link">
                        Sudah punya akun? <a href="login_web.php">Login di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>