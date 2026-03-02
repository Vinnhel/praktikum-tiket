<?php
require 'connection.php';
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM tiket WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Data tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_pemesan'];
    $kode = $_POST['kode_tiket'];
    $tujuan = $_POST['tujuan'];
    $tanggal = $_POST['tanggal'];
    $harga = $_POST['harga'];

    $sql = "UPDATE tiket SET nama_pemesan=?, kode_tiket=?, tujuan=?, tanggal=?, harga=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nama, $kode, $tujuan, $tanggal, $harga, $id])) {
        header("Location: index.php"); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Pemesanan Tiket</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" 
                                       value="<?= htmlspecialchars($data['nama_pemesan']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="kode_tiket" class="form-label">Kode Tiket</label>
                                <input type="text" class="form-control" id="kode_tiket" name="kode_tiket" 
                                       value="<?= htmlspecialchars($data['kode_tiket']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <input type="text" class="form-control" id="tujuan" name="tujuan" 
                                       value="<?= htmlspecialchars($data['tujuan']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Perjalanan</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                       value="<?= htmlspecialchars($data['tanggal']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="harga" name="harga" 
                                       value="<?= htmlspecialchars($data['harga']); ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check-circle"></i> Update Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
