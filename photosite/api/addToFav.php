<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
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
$uid = $_SESSION["userinfo"]["id"];
$db = new Database();
$photoService = new PhotoService($db->getConnection());
echo json_encode($photoService->addToFav($data->photoId, $uid));
//if ($photoService->addToFav($data->photoId, $uid)) {
//    echo json_encode(Result::success());
//}
//else {
//    echo json_encode(Result::fail());
//}