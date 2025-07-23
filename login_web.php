<?php
session_start();
require 'koneksi.php';

// Blok 1: Cek jika pengguna SUDAH login, langsung alihkan.
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas') {
        header("Location: dashboard.php");
        exit;
    } else if ($_SESSION['role'] == 'customer') {
        header("Location: user.php");
        exit;
    }
}

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role_input = trim($_POST['role']);

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        
        // --- BAGIAN UTAMA YANG DIPERBARUI ---
        // Verifikasi password (bisa untuk yang di-hash ATAU teks biasa)
        // Ini membuat akun lama dan akun baru dari registrasi bisa login.
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            
            // Verifikasi peran setelah password cocok
            if ($role_input === $user['role']) {
                // Jika berhasil, simpan data ke session
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['id_user'] = $user['id_user'];
                
                // Redirect SETELAH login berhasil.
                if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas') {
                    header("Location: dashboard.php");
                } else {
                    header("Location: user.php");
                }
                exit;
            }
        }
    }
    
    // Jika username tidak ditemukan atau password/peran salah
    $errorMessage = '<div class="alert alert-danger">Username, Password, atau Peran salah!</div>';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style_login_web.css">
</head>
<body>
    <div class="login-container">
        <div class="left-panel">
            <div class="welcome-text">
                <h1>Selamat Datang</h1>
                <p>di KenZo Store</p>
            </div>
            <img src="foto/sepatu 3.jpg" alt="Ilustrasi Latar Belakang" class="left-panel-image">
        </div>
        <div class="right-panel">
            <div class="login-form">
                <h2>LOGIN</h2>
                <?php if (!empty($errorMessage)) { echo $errorMessage; } ?>
                <form action="login_web.php" method="POST">
                    <div class="role-selector">
                        <button type="button" class="role-btn" data-role="admin">Admin</button>
                        <button type="button" class="role-btn" data-role="petugas">Petugas</button>
                        <button type="button" class="role-btn active" data-role="customer">Customer</button>
                    </div>
                    <input type="hidden" name="role" id="selected-role" value="customer">
                    <div class="input-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="login-button">LOGIN</button>
                    <p class="register-link">
                        Belum punya akun? <a href="registrasi.php">Registrasi di sini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="js/script_login.js"></script>
</body>
</html>