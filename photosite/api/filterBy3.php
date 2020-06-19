<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");
require_once "../service/PhotoService.php";
require_once "../config/Database.php";
$data = json_decode(file_get_contents("php://input"));
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->getPhotosBy3($data->cityCode, $data->countryCode, $data->theme));