<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
include_once "../entity/Photo.php";
include_once '../config/Result.php';
include_once '../config/Database.php';
include_once '../service/PhotoService.php';
use \config\Result;
session_start();
if (empty($_SESSION["userinfo"])) {
    echo json_encode(Result::notLoginError());
    return;
}
$data = json_decode(file_get_contents("php://input"));
$id = $_SESSION["userinfo"]["id"];
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->findPhotosByUid($id,$data->pageNum, $data->pageSize));