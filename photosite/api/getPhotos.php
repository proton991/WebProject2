<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../service/PhotoService.php';

$data = json_decode(file_get_contents("php://input"));
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->getPhotos($data->pageNum, $data->pageSize, $data->filter));