<?php
require 'connection.php';

// Set header untuk download file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="data_tiket_' . date('Y-m-d') . '.csv"');

// Buat output stream
$output = fopen('php://output', 'w');

// Tambahkan BOM untuk Excel (agar karakter UTF-8 terbaca dengan benar)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Header kolom (baris pertama)
fputcsv($output, [
    'No', 
    'Kode Tiket', 
    'Nama Pemesan', 
    'Tujuan', 
    'Tanggal', 
    'Harga (Rp)'
]);

// Ambil data dari database
$stmt = $pdo->query("SELECT * FROM tiket ORDER BY id DESC");
$tiket = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tulis data ke CSV
$no = 1;
foreach ($tiket as $row) {
    fputcsv($output, [
        $no++,
        $row['kode_tiket'],
        $row['nama_pemesan'],
        $row['tujuan'],
        $row['tanggal'],
        number_format($row['harga'], 0, ',', '.')
    ]);
}

// Tutup output
fclose($output);
exit;
?>
