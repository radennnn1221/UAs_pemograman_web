<?php
session_start();
require 'koneksi.php';

// Otentikasi: Cek apakah pengguna sudah login sebagai customer
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: login_web.php");
    exit;
}

// --- Logika untuk Filter Kategori ---
$kategori_filter = $_GET['kategori'] ?? '';
$sql_where = '';
if (!empty($kategori_filter)) {
    $kategori_safe = mysqli_real_escape_string($koneksi, $kategori_filter);
    $sql_where = " AND merek = '$kategori_safe'";
}

// Ambil semua data sepatu yang stoknya lebih dari 0, dengan filter jika ada
$sql_sepatu = "SELECT * FROM sepatu WHERE stok > 0" . $sql_where;
$result_sepatu = mysqli_query($koneksi, $sql_sepatu);

// Ambil semua merek unik untuk ditampilkan di filter kategori
$result_kategori = mysqli_query($koneksi, "SELECT DISTINCT merek FROM sepatu ORDER BY merek ASC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk - KenZo Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/user_style.css"> 
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="user.php">👟 KenZo Store</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="keranjang.php"><i class="bi bi-cart"></i> Keranjang</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat_belanja.php">Riwayat Belanja</a></li>
                    <li class="nav-item"><a class="nav-link" href="pesan.php">Beri Tanggapan</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid page-title-section p-5 text-center">
        <h1>PRODUK KAMI</h1>
        <p class="text-muted">Temukan sepatu terbaik untuk gaya Anda</p>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3 sidebar">
                <div class="card">
                    <div class="card-header"><h5>Kategori</h5></div>
                    <ul class="list-group list-group-flush">
                        <a href="user.php" class="list-group-item list-group-item-action <?php echo empty($kategori_filter) ? 'active' : ''; ?>">Semua</a>
                        <?php while($kategori = mysqli_fetch_assoc($result_kategori)): ?>
                            <a href="user.php?kategori=<?php echo urlencode($kategori['merek']); ?>" class="list-group-item list-group-item-action <?php echo ($kategori_filter === $kategori['merek']) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($kategori['merek']); ?>
                            </a>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($sepatu = mysqli_fetch_assoc($result_sepatu)): ?>
                    <div class="col">
                        <div class="card h-100 product-card">
                            <img src="foto/<?php echo htmlspecialchars($sepatu['gambar']); ?>" class="product-card-img" alt="<?php echo htmlspecialchars($sepatu['nama_sepatu']); ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($sepatu['nama_sepatu']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($sepatu['merek']); ?></p>
                                <h6 class="card-subtitle mb-2">Rp <?php echo number_format($sepatu['harga']); ?></h6>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <form action="keranjang_aksi.php" method="POST">
                                    <input type="hidden" name="id_sepatu" value="<?php echo $sepatu['id_sepatu']; ?>">
                                    <input type="hidden" name="aksi" value="tambah">
                                    <button type="submit" class="btn btn-primary w-100">Tambah ke Keranjang</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script_user.js"></script>
</body>
</html>