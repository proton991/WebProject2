<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
require_once "../service/PhotoService.php";
require_once "../config/Database.php";
$db = new Database();
$photoService = new PhotoService($db->getConnection());

echo json_encode($photoService->getHotPhotosRan());