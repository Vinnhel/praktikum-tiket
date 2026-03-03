<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");

if($_SERVER['REQUEST_METHOD'] !== 'DELETE'){
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/database.php';
include_once '../models/tiket.php';

$database = new Database();
$db = $database->getConnection();
$tiket = new Tiket($db);

$data = json_decode(file_get_contents("php://input"));

$tiket->id = $data->id;

if($tiket->delete()){
    http_response_code(200);
    echo json_encode(array("message" => "Tiket berhasil dihapus."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Gagal menghapus tiket."));
}
?>