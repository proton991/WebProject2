<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../service/CategoryService.php";
include_once '../config/Database.php';

$db = new Database();
$ctg_service = new CategoryService($db->getConnection());
$data = json_decode(file_get_contents("php://input"));
echo $ctg_service->getCitiesByISO($data->CountryCode);