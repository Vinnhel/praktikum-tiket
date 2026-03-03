<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../models/tiket.php';

$database = new Database();
$db = $database->getConnection();
$tiket = new Tiket($db);

$stmt = $tiket->read();
$num = $stmt->rowCount();

if($num > 0) {
    $tiket_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $tiket_item = array(
            "id" => $id,
            "nama_pemesan" => $nama_pemesan,
            "kode_tiket" => $kode_tiket,
            "tujuan" => $tujuan,
            "tanggal" => $tanggal,
            "harga" => $harga
        );
        array_push($tiket_arr, $tiket_item);
    }
    http_response_code(200);
    echo json_encode($tiket_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Data tidak ditemukan."));
}
?>