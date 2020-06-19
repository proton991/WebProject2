<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
include_once "../entity/Photo.php";
include_once '../config/Database.php';
include_once '../service/PhotoService.php';

$data = json_decode(file_get_contents("php://input"));
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->findPhotoById($data->photoId));