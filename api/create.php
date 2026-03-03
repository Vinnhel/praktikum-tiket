<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../models/tiket.php';

$database = new Database();
$db = $database->getConnection();
$tiket = new Tiket($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->nama_pemesan) && !empty($data->kode_tiket)) {
    $tiket->nama_pemesan = $data->nama_pemesan;
    $tiket->kode_tiket = $data->kode_tiket;
    $tiket->tujuan = $data->tujuan;
    $tiket->tanggal = $data->tanggal;
    $tiket->harga = $data->harga;

    if($tiket->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Tiket berhasil dibuat."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Gagal membuat tiket."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Data tidak lengkap."));
}
?>