<?php
require 'connection.php';
$stmt = $pdo->query("SELECT * FROM tiket ORDER BY id DESC");
$tiket = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Data Pemesanan Tiket</title></head>
<body>
    <h2>Daftar Pemesanan Tiket</h2>
    <a href="tambah.php">Tambah Pemesanan Baru</a> <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th><th>Kode Tiket</th><th>Nama</th><th>Tujuan</th><th>Tanggal</th><th>Harga</th><th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($tiket as $row): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['kode_tiket']); ?></td>
            <td><?= htmlspecialchars($row['nama_pemesan']); ?></td>
            <td><?= htmlspecialchars($row['tujuan']); ?></td>
            <td><?= htmlspecialchars($row['tanggal']); ?></td>
            <td><?= htmlspecialchars($row['harga']); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>