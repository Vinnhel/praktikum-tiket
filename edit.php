<?php
require 'connection.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tiket WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pemesan'];
    $kode = $_POST['kode_tiket'];
    $tujuan = $_POST['tujuan'];
    $tanggal = $_POST['tanggal'];
    $harga = $_POST['harga'];

    $sql = "UPDATE tiket SET nama_pemesan=?, kode_tiket=?, tujuan=?, tanggal=?, harga=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nama, $kode, $tujuan, $tanggal, $harga, $id])) {
        header("Location: index.php"); exit;
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Edit Pemesanan</h2>
    <form method="POST" action="">
        <label>Nama:</label><br><input type="text" name="nama_pemesan" value="<?= $data['nama_pemesan']; ?>" required><br>
        <label>Kode:</label><br><input type="text" name="kode_tiket" value="<?= $data['kode_tiket']; ?>" required><br>
        <label>Tujuan:</label><br><input type="text" name="tujuan" value="<?= $data['tujuan']; ?>" required><br>
        <label>Tanggal:</label><br><input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required><br>
        <label>Harga:</label><br><input type="number" name="harga" value="<?= $data['harga']; ?>" required><br><br>
        <button type="submit">Update</button> <a href="index.php">Batal</a>
    </form>
</body>
</html>