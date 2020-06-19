<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
require_once "../service/PhotoService.php";
require_once "../config/Database.php";
$data = json_decode(file_get_contents("php://input"));
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->searchByTitle($data->title));