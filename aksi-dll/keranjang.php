<?php
session_start();
require 'koneksi.php';

// Otentikasi
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login_web.php");
    exit;
}

$keranjang = $_SESSION['keranjang'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Keranjang Belanja Anda</h1>
            <a href="user.php" class="btn btn-secondary">Kembali Belanja</a>
        </div>
        <hr>

        <?php if (empty($keranjang)): ?>
            <div class="alert alert-info text-center">
                Keranjang belanja Anda kosong.
            </div>
        <?php else: ?>
            <form action="keranjang_aksi.php" method="POST">
                <input type="hidden" name="aksi" value="update">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Inisialisasi total belanja di luar loop
                        $total_belanja = 0;
                        
                        foreach ($keranjang as $id_sepatu => $kuantitas):
                            $result = mysqli_query($koneksi, "SELECT * FROM sepatu WHERE id_sepatu = $id_sepatu");
                            $sepatu = mysqli_fetch_assoc($result);
                            
                            if ($sepatu):
                                // --- PERHITUNGAN PENTING DIMULAI DI SINI ---
                                // 1. Hitung subtotal dengan mengalikan harga dan kuantitas
                                $subtotal = $sepatu['harga'] * $kuantitas;
                                // 2. Tambahkan subtotal ke total belanja keseluruhan
                                $total_belanja += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="foto/<?php echo htmlspecialchars($sepatu['gambar']); ?>" alt="" style="width: 80px; height: 80px; object-fit: cover;" class="me-3 rounded">
                                    <div>
                                        <strong><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></strong><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($sepatu['merek']); ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-end">Rp <?php echo number_format($sepatu['harga']); ?></td>
                            <td class="text-center">
                                <input type="number" name="kuantitas[<?php echo $id_sepatu; ?>]" value="<?php echo $kuantitas; ?>" class="form-control mx-auto" style="width: 80px;" min="1">
                            </td>
                            <td class="text-end">Rp <?php echo number_format($subtotal); ?></td>
                            <td class="text-center">
                                <a href="keranjang_aksi.php?id_sepatu=<?php echo $id_sepatu; ?>&aksi=hapus" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus item ini?');">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endif; 
                        endforeach; 
                        ?>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="submit" class="btn btn-primary">Update Kuantitas</button>
                    <h4>Total Belanja: <span class="text-primary fw-bold">Rp <?php echo number_format($total_belanja); ?></span></h4>
                </div>
            </form>
            <div class="text-end mt-3">
                <a href="checkout.php" class="btn btn-success btn-lg">Lanjutkan ke Pembayaran</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>