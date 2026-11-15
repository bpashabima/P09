<?php
declare(strict_types=1);


require __DIR__ . "/data.php";
require __DIR__ . "/functions.php";

$semuaPesanan = bacaPesanan(FILE_PESANAN);

$jumlahPesanan = count($semuaPesanan);
$totalOmzet = 0;
foreach ($semuaPesanan as $pesanan) {
    $totalOmzet += (int) ($pesanan["total"] ?? 0);
}

$pesananTampil = array_reverse($semuaPesanan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan — <?= e($namaToko) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="kepala">
        <h1><?= e($namaToko) ?></h1>
        <nav class="nav-utama">
            <a href="index.php">Katalog</a>
            <a href="pesan.php">Pesan</a>
            <a href="daftar-pesanan.php" class="aktif">Daftar Pesanan</a>
        </nav>
    </header>

    <main class="wadah">
        <h2>Daftar Pesanan</h2>

        <p class="ringkasan-pesanan">
            <?= $jumlahPesanan ?> pesanan &middot; Total <?= formatRupiah($totalOmzet) ?>
        </p>

        <?php if ($jumlahPesanan === 0): ?>
            <p class="kosong">Belum ada pesanan yang masuk.</p>
        <?php else: ?>
            <div class="bungkus-tabel">
                <table class="tabel-pesanan">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Metode</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pesananTampil as $pesanan): ?>
                            <tr>
                                <td><?= e($pesanan["kode"]) ?></td>
                                <td><?= e($pesanan["waktu"]) ?></td>
                                <td><?= e($pesanan["nama"]) ?></td>
                                <td><?= e($pesanan["alamat"] ?? "-") ?></td>
                                <td><?= e($pesanan["metode"] ?? "-") ?></td>
                                <td><?= e($pesanan["produk"]) ?></td>
                                <td><?= (int) $pesanan["jumlah"] ?></td>
                                <td><?= formatRupiah((int) $pesanan["total"]) ?></td>
                                <td><?= e($pesanan["catatan"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>

    <footer class="kaki">
        <p>&copy; <?= date("Y") ?> Pemrograman Web &middot; Informatika TSU</p>
    </footer>
</body>
</html>