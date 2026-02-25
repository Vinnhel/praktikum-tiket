<?php
require 'connection.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pemesan'];
    $kode = $_POST['kode_tiket'];
    $tujuan = $_POST['tujuan'];
    $tanggal = $_POST['tanggal'];
    $harga = $_POST['harga'];

    $sql = "INSERT INTO tiket(nama_pemesan, kode_tiket, tujuan, tanggal, harga) VALUES(?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nama, $kode, $tujuan, $tanggal, $harga])) {
        header("Location: index.php"); exit;
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Tambah Pemesanan</h2>
    <form method="POST" action="">
        <label>Nama Pemesan:</label><br><input type="text" name="nama_pemesan" required><br>
        <label>Kode Tiket:</label><br><input type="text" name="kode_tiket" required><br>
        <label>Tujuan:</label><br><input type="text" name="tujuan" required><br>
        <label>Tanggal:</label><br><input type="date" name="tanggal" required><br>
        <label>Harga:</label><br><input type="number" name="harga" required><br><br>
        <button type="submit">Simpan</button> <a href="index.php">Batal</a>
    </form>
</body>
</html>