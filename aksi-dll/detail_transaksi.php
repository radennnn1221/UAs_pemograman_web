<?php
session_start();
require 'koneksi.php';

// Otentikasi: Pastikan customer login
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login_web.php");
    exit;
}

// Ambil ID transaksi dari URL
if (!isset($_GET['id'])) {
    header("Location: riwayat_belanja.php");
    exit;
}
$id_transaksi = (int)$_GET['id'];
$id_user = $_SESSION['id_user'];

// Keamanan: Pastikan transaksi ini milik user yang sedang login
$stmt_check = $koneksi->prepare("SELECT * FROM transaksi WHERE id_transaksi = ? AND id_user = ?");
$stmt_check->bind_param("ii", $id_transaksi, $id_user);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
if ($result_check->num_rows === 0) {
    // Jika bukan, tendang ke halaman riwayat
    header("Location: riwayat_belanja.php");
    exit;
}
$transaksi_info = $result_check->fetch_assoc();

// Ambil detail item dari transaksi
$stmt_detail = $koneksi->prepare(
    "SELECT dt.*, s.nama_sepatu, s.merek, s.gambar 
     FROM detail_transaksi dt 
     JOIN sepatu s ON dt.id_sepatu = s.id_sepatu 
     WHERE dt.id_transaksi = ?"
);
$stmt_detail->bind_param("i", $id_transaksi);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Detail Transaksi #<?php echo $id_transaksi; ?></h1>
            <a href="riwayat_belanja.php" class="btn btn-secondary">Kembali ke Riwayat</a>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <p><strong>Tanggal:</strong> <?php echo date('d M Y, H:i', strtotime($transaksi_info['tanggal_transaksi'])); ?></p>
                <p><strong>Total Pembayaran:</strong> Rp <?php echo number_format($transaksi_info['total_harga']); ?></p>
                <p><strong>Status:</strong> <span class="badge <?php echo ($transaksi_info['status'] == 'Lunas') ? 'bg-success' : 'bg-warning text-dark'; ?>"><?php echo $transaksi_info['status']; ?></span></p>
            </div>
        </div>

        <h4 class="mt-4">Item yang Dibeli:</h4>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $result_detail->fetch_assoc()): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="foto/<?php echo htmlspecialchars($item['gambar']); ?>" alt="" style="width: 60px; height: 60px; object-fit: cover;" class="me-3 rounded">
                            <span><?php echo htmlspecialchars($item['nama_sepatu']); ?></span>
                        </div>
                    </td>
                    <td>Rp <?php echo number_format($item['harga_saat_transaksi']); ?></td>
                    <td><?php echo $item['jumlah']; ?></td>
                    <td>Rp <?php echo number_format($item['harga_saat_transaksi'] * $item['jumlah']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>