<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use OSS\OssClient;
use OSS\Core\OssException;
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

// 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
$accessKeyId = "LTAI4*******UZ";
$accessKeySecret = "KK99*******zD";
// Endpoint以杭州为例，其它Region请按实际情况填写。
$endpoint = "http://oss-cn-shanghai.aliyuncs.com";
// 设置存储空间名称。
$bucket = "soft-photosbucket";
// 设置文件名称。
$object = "photos/" . time() . $_FILES["file"]["name"];
// <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt。
$filePath = $_FILES["file"]["tmp_name"];
$photo = new Photo();
if (isset($_POST)) {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $photo->title = $title;
    $photo->description = $description;
    $photo->uid = $_SESSION["userinfo"]["id"];
    $photo->cityCode = $city;
    $photo->countryCode = $country;
    $photo->theme = $_POST["theme"];
}

try {
    $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    $info = $ossClient->uploadFile($bucket, $object, $filePath);
    $photo->path = $info['oss-request-url'];
    $db = new Database();
    $photoService = new PhotoService($db->getConnection());
    if ($photoService->save($photo))
        echo json_encode(Result::success());
    else {
        $res = new Result();
        $res->message = "upload failed!";
        $res->code = 50011;
        echo json_encode($res);
    }

    return;
} catch (OssException $e) {
    printf(__FUNCTION__ . ": FAILED\n");
    printf($e->getMessage() . "\n");
    return;
}