<?php
declare(strict_types=1);

require __DIR__ . "/data.php";
require __DIR__ . "/functions.php";

$kategoriDipilih = $_GET["kategori"] ?? "Semua";
$kataKunci = trim($_GET["q"] ?? "");
$urutDipilih = $_GET["urut"] ?? "";

if (!in_array($kategoriDipilih, $daftarKategori, true)) {
    $kategoriDipilih = "Semua";
}

if (!in_array($urutDipilih, ["termurah", "termahal"], true)) {
    $urutDipilih = "";
}

$produkTampil = filterKategori($daftarProduk, $kategoriDipilih);
$produkTampil = cariProduk($produkTampil, $kataKunci);
$produkTampil = urutkanProduk($produkTampil, $urutDipilih);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog <?= e($namaToko) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="kepala">
        <h1><?= e($namaToko) ?></h1>

        <nav class="nav-utama">
            <a href="index.php" class="aktif">Katalog</a>
            <a href="pesan.php">Pesan</a>
            <a href="daftar-pesanan.php">Daftar Pesanan</a>
        </nav>

        <form method="GET" action="index.php" class="form-cari">
            <input type="text" name="q" placeholder="Cari nama produk..." value="<?= e($kataKunci) ?>">
            <select name="kategori">
                <?php foreach ($daftarKategori as $kategori): ?>
                    <option value="<?= e($kategori) ?>" <?= $kategori === $kategoriDipilih ? 'selected' : '' ?>>
                        <?= e($kategori) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="urut">
                <option value="">Urutkan</option>
                <option value="termurah" <?= $urutDipilih === "termurah" ? "selected" : "" ?>>Termurah</option>
                <option value="termahal" <?= $urutDipilih === "termahal" ? "selected" : "" ?>>Termahal</option>
            </select>
            <button type="submit" class="btn">Cari</button>
        </form>

        <?php if ($kataKunci !== ""): ?>
            <p class="info-cari">Hasil pencarian "<?= e($kataKunci) ?>": <?= count($produkTampil) ?> produk.</p>
        <?php endif; ?>
    </header>

    <main class="grid">
        <?php if (count($produkTampil) === 0): ?>
            <p class="kosong">Produk tidak ditemukan.</p>
        <?php endif; ?>

        <?php foreach ($produkTampil as $produk): ?>
            <?php $status = statusStok($produk["stok"]); ?>
            <article class="kartu">
                <span class="<?= kelasBadge($status) ?>"><?= $status ?></span>
                <h2><?= e($produk["nama"]) ?></h2>
                <p class="kategori"><?= e($produk["kategori"]) ?> &middot; <?= e($produk["kode"]) ?></p>
                <p class="harga"><?= formatRupiah($produk["harga"]) ?></p>

                <?php if ($produk["stok"] > 0): ?>
                    <a href="pesan.php?produk=<?= urlencode($produk["kode"]) ?>" class="btn btn-pesan">Pesan</a>
                <?php else: ?>
                    <span class="btn btn-habis">Habis</span>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </main>

    <footer class="kaki">
        <p>&copy; <?= date("Y") ?> Pemrograman Web &middot; Informatika TSU</p>
    </footer>
</body>
</html>