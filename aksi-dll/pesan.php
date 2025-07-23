<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan hanya customer yang bisa mengakses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login_web.php");
    exit;
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_SESSION['id_user'];
    $subjek = trim($_POST['subjek']);
    $isi_pesan = trim($_POST['isi_pesan']);

    if (!empty($isi_pesan)) {
        $stmt = $koneksi->prepare("INSERT INTO pesan_kesan (id_user, subjek, isi_pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_user, $subjek, $isi_pesan);
        
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Terima kasih! Tanggapan Anda telah berhasil dikirim.</div>';
        } else {
            $message = '<div class="alert alert-danger">Maaf, terjadi kesalahan saat mengirim tanggapan.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-warning">Isi pesan tidak boleh kosong.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beri Tanggapan - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Beri Kami Tanggapan</h1>
            <a href="user.php" class="btn btn-secondary">Kembali</a>
        </div>
        <hr>
        <p>Kami sangat menghargai masukan Anda untuk meningkatkan kualitas layanan kami.</p>
        
        <?php if (!empty($message)) echo $message; ?>

        <form method="POST" action="pesan.php">
            <div class="mb-3">
                <label for="subjek" class="form-label">Subjek</label>
                <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Contoh: Kualitas Produk" required>
            </div>
            <div class="mb-3">
                <label for="isi_pesan" class="form-label">Pesan Anda</label>
                <textarea class="form-control" id="isi_pesan" name="isi_pesan" rows="5" placeholder="Tuliskan pesan dan kesan Anda di sini..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
        </form>
    </div>
</body>
</html>