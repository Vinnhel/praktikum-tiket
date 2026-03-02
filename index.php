<?php
require 'connection.php';

$total_tiket = $pdo->query("SELECT COUNT(*) FROM tiket")->fetchColumn();
$total_pendapatan = $pdo->query("SELECT SUM(harga) FROM tiket")->fetchColumn() ?? 0;
$total_tujuan = $pdo->query("SELECT COUNT(DISTINCT tujuan) FROM tiket")->fetchColumn();

$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$sql = "SELECT * FROM tiket WHERE nama_pemesan LIKE ? OR tujuan LIKE ? OR kode_tiket LIKE ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(["%$cari%", "%$cari%", "%$cari%"]);
$tiket = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemesanan Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh; /* Minimal setinggi 1 layar penuh */
            display: flex;
            align-items: center; /* Vertikal center */
            padding: 80px 0;
            position: relative;
        }
        
        .welcome-content {
            z-index: 2;
        }

        .welcome-icon {
            font-size: 200px;
            opacity: 0.2;
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        /* 📊 SECTION SPACING */
        .section-spacing {
            padding-top: 80px;
            padding-bottom: 80px;
        }

        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .table-card {
            border-radius: 15px;
            border: none;
            overflow: hidden;
        }

        .footer-section {
            padding: 40px 0;
            background: #f8f9fa;
            margin-top: 80px;
        }
    </style>
</head>
<body class="bg-light">
    
    <!-- 🎉 WELCOME SECTION (FULL SCREEN) -->
    <div class="welcome-section">
        <div class="container welcome-content">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary mb-3 px-3 py-2 rounded-pill">
                        <i class="bi bi-check-circle-fill"></i> 247006111025
                    </span>
                    <h1 class="display-3 fw-bold mb-4">
                        Selamat Datang di<br>Sistem Pemesanan Tiket
                    </h1>
                    <p class="lead mb-5 opacity-75" style="max-width: 600px;">
                        Kelola pemesanan tiket perjalanan dengan mudah, cepat, dan aman. 
                        Implementasi Server Side Scripting menggunakan PHP & MySQL.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="tambah.php" class="btn btn-light btn-lg px-4 shadow">
                            <i class="bi bi-plus-circle-fill"></i> Pesan Tiket Sekarang
                        </a>
                        <a href="#dashboard" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-arrow-down-circle"></i> Lihat Data
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="bi bi-airplane-engines-fill welcome-icon"></i>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 animate-bounce">
            <i class="bi bi-chevron-down" style="font-size: 30px; opacity: 0.7;"></i>
        </div>
    </div>

    <!-- 📊 STATISTIK DASHBOARD -->
    <div id="dashboard" class="container section-spacing">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold text-dark">Dashboard Statistik</h2>
                <p class="text-muted">Ringkasan data pemesanan tiket</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card stat-card bg-primary text-white shadow-lg h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-white-50">Total Tiket Terjual</h6>
                                <h2 class="card-title fw-bold display-6"><?= $total_tiket; ?></h2>
                            </div>
                            <i class="bi bi-ticket-fill" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-success text-white shadow-lg h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-white-50">Total Pendapatan</h6>
                                <h2 class="card-title fw-bold display-6">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h2>
                            </div>
                            <i class="bi bi-cash-coin" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card bg-info text-white shadow-lg h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-white-50">Destinasi Tersedia</h6>
                                <h2 class="card-title fw-bold display-6"><?= $total_tujuan; ?></h2>
                            </div>
                            <i class="bi bi-geo-alt-fill" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 📋 TABEL DATA -->
    <div class="container section-spacing">
        <div class="card table-card shadow-lg">
            <div class="card-header bg-dark text-white py-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0"><i class="bi bi-table"></i> Daftar Pemesanan Tiket</h5>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <a href="export.php" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Form Pencarian -->
                <form method="GET" action="" class="mb-4 p-3 bg-light rounded">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="cari" class="form-control border-0" 
                                       placeholder="Cari nama, tujuan, atau kode tiket..." 
                                       value="<?= isset($_GET['cari']) ? htmlspecialchars($cari) : '' ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                Cari
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="index.php" class="btn btn-secondary w-100">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tombol Aksi -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="text-muted mb-0">Menampilkan <?= count($tiket); ?> data</p>
                    <a href="tambah.php" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Tambah Pemesanan Baru
                    </a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Kode Tiket</th>
                                <th>Nama Pemesan</th>
                                <th>Tujuan</th>
                                <th>Tanggal</th>
                                <th>Harga</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (count($tiket) > 0):
                                $no = 1; 
                                foreach ($tiket as $row): 
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold"><?= $no++; ?></td>
                                <td><span class="badge bg-primary"><?= htmlspecialchars($row['kode_tiket']); ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                                            <?= strtoupper(substr($row['nama_pemesan'], 0, 1)); ?>
                                        </div>
                                        <?= htmlspecialchars($row['nama_pemesan']); ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($row['tujuan']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal']); ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td class="text-end pe-4">
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox" style="font-size: 50px; opacity: 0.3;"></i><br>
                                    <p class="mt-3">Belum ada data pemesanan</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-section text-center">
        <div class="container">
            <p class="text-muted mb-0">&copy; 2025 Sistem Pemesanan Tiket - Praktikum Server Side Scripting</p>
            <small class="text-muted">Dibuat dengan PHP, MySQL & Bootstrap</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
