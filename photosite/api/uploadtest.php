<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
include_once "../entity/Photo.php";
$photo = new Photo();
if (isset($_POST)) {

    $title = $_POST["title"];
    $description = $_POST["description"];
    $country = $_POST["country"];
    $city = $_POST["city"];
    $photo->title = $title;
    $photo->description = $description;
    $photo->cityCode = $city;
    $photo->countryCode = $country;
    $photo->theme = $_POST["theme"];

}
if (sizeof($_FILES) != 0) {
    var_dump($_FILES);
}