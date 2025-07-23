<?php
session_start();
require 'koneksi.php';

// Otentikasi dan pastikan keranjang tidak kosong
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer' || empty($_SESSION['keranjang'])) {
    header("Location: user.php");
    exit;
}

$keranjang = $_SESSION['keranjang'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Konfirmasi Pesanan Anda</h3>
                    </div>
                    <div class="card-body">
                        <h5>Item Pesanan:</h5>
                        <table class="table">
                            <tbody>
                                <?php
                                $total_belanja = 0;
                                foreach ($keranjang as $id_sepatu => $kuantitas):
                                    $result = mysqli_query($koneksi, "SELECT * FROM sepatu WHERE id_sepatu = $id_sepatu");
                                    $sepatu = mysqli_fetch_assoc($result);
                                    if ($sepatu):
                                        $subtotal = $sepatu['harga'] * $kuantitas;
                                        $total_belanja += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></td>
                                    <td>x <?php echo $kuantitas; ?></td>
                                    <td class="text-end">Rp <?php echo number_format($subtotal); ?></td>
                                </tr>
                                <?php endif; endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">Total Pembayaran</td>
                                    <td class="text-end">Rp <?php echo number_format($total_belanja); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <hr>
                        <p>Pastikan pesanan Anda sudah benar sebelum melanjutkan. Dengan menekan tombol di bawah, pesanan Anda akan kami proses.</p>
                        <div class="d-grid">
                            <a href="aksi_checkout.php" class="btn btn-primary btn-lg">Konfirmasi dan Bayar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>