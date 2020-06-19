<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../service/UserService.php';
$db = new Database();
$userService = new UserService($db->getConnection());
$data = json_decode(file_get_contents("php://input"));
if (!empty($data->cookie))
{
    echo $userService->logout($data);
}

