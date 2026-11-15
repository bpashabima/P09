<?php
declare(strict_types=1);
$nama = trim($_POST["nama"] ?? "");
$kota = trim($_POST["kota"] ?? "");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Sapa</title>
</head>
<body>
    <h1>Form Sapa</h1>
    <form action="form-sapa.php" method="get">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama">
        <label for="kota">Kota</label>
        <input type="text" id="kota" name="kota">
        <button type="submit">Kirim</button>
    </form>
    <?php if ($nama !== ""): ?>
        <p>Halo, <?= htmlspecialchars($nama) ?> dari <b>Solo</b>!</p>
    <?php endif; ?>
</body>
</html>