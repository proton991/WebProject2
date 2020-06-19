<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/Database.php';
include_once '../service/UserService.php';
$db = new Database();
$userService = new UserService($db->getConnection());

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->username))
{

    $res = $userService->register($data);
    echo $res;
}