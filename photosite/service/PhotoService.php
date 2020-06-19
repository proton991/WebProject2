<?php
include_once "../entity/Photo.php";
include_once '../config/Result.php';

use config\Result;

class PhotoService
{
    private $table_name = "travelimage";
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function isInFav($photoId, $uid) {
        $query = "SELECT * FROM `travelimagefavor` left join `travelimage` t on travelimagefavor.ImageID = t.ImageID WHERE travelimagefavor.UID=$uid";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                if ($ImageID === $photoId)
                    return true;
            }
        }
        return false;
    }
    public function addToFav($photoId, $uid)
    {
        if ($this->isInFav($photoId, $uid)) {
            $res = new Result();
            $res->code = 50011;
            $res->message = "Already in favourites, can't add again";
            return $res;
        }
        $query = "INSERT INTO `travelimagefavor` SET UID=:uid, ImageID=:photoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":photoId", $photoId);
        if ($stmt->execute()) {
            return Result::success();
        }
        return Result::fail();
    }

    public function removeFav($photoId, $uid)
    {
        $query = "DELETE FROM `travelimagefavor` WHERE UID=:uid and ImageID=:photoId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":uid", $uid);
        $stmt->bindParam(":photoId", $photoId);
        return $stmt->execute();
    }

    public function removePhoto($photoId, $uid)
    {
        $query = "DELETE FROM `travelimage` WHERE ImageID=$photoId AND UID=$uid";
        $stmt = $this->conn->prepare($query);
        if ($this->isInFav($photoId, $uid)) {
            $this->removeFav($photoId, $uid);
        }
        return $stmt->execute();
    }

    public function save(Photo $photo)
    {
        $query = "INSERT INTO  `travelimage` SET Title=:title, Description=:description,  CityCode=:cityCode, CountryCodeISO=:countryCode, UID=:uid, PATH=:path, Theme=:theme";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":title", $photo->title);
        $stmt->bindParam(":description", $photo->description);
        $stmt->bindParam(":cityCode", $photo->cityCode);
        $stmt->bindParam(":countryCode", $photo->countryCode);
        $stmt->bindParam(":uid", $photo->uid);
        $stmt->bindParam(":path", $photo->path);
        $stmt->bindParam(":theme", $photo->theme);
        return $stmt->execute();
    }

    public function edit(Photo $photo)
    {
        $stmt = null;
        $photoId = $photo->photoId;
        $uid = $photo->uid;
        if (is_null($photo->path)) {

            $query = "UPDATE `travelimage` SET Title=:title, Description=:description,  CityCode=:cityCode, CountryCodeISO=:countryCode, UID=:uid, Theme=:theme WHERE ImageID=$photoId AND UID=$uid";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $photo->title);
            $stmt->bindParam(":description", $photo->description);
            $stmt->bindParam(":cityCode", $photo->cityCode);
            $stmt->bindParam(":countryCode", $photo->countryCode);
            $stmt->bindParam(":uid", $photo->uid);
            $stmt->bindParam(":theme", $photo->theme);
        } else {
            $query = "UPDATE `travelimage` SET Title=:title, Description=:description,  CityCode=:cityCode, CountryCodeISO=:countryCode, UID=:uid, PATH=:path, Theme=:theme WHERE ImageID=$photoId AND UID=$uid";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $photo->title);
            $stmt->bindParam(":description", $photo->description);
            $stmt->bindParam(":cityCode", $photo->cityCode);
            $stmt->bindParam(":countryCode", $photo->countryCode);
            $stmt->bindParam(":uid", $photo->uid);
            $stmt->bindParam(":path", $photo->path);
            $stmt->bindParam(":theme", $photo->theme);
        }

        return $stmt->execute();
    }

    public function countryNameHelper($CountryCodeISO)
    {
        $query = "SELECT * FROM `geocountries` WHERE ISO=:countryCode";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":countryCode", $CountryCodeISO);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() != 0) {
            extract($row);
            return $CountryName;
        }
        return "";
    }

    public function cityNameHelper($cityCode)
    {
        $query = "SELECT * FROM `geocities` WHERE GeoNameID=:cityCode";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cityCode", $cityCode);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() != 0) {
            extract($row);
            return $AsciiName;
        }
        return "";
    }

    public function findPhotosByUid($id, $pageNum, $pageSize)
    {
        $query = "SELECT * FROM `travelimage` WHERE UID=$id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $totalPages = intval($num/$pageSize);
        if($num%$pageSize>0){
            $totalPages = $totalPages + 1;
        }
        $strSQL = $query . " limit " . (($pageNum-1)*$pageSize). "," . $pageSize;
        $stmt = $this->conn->prepare($strSQL);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }
            $res_arr = array();
            $res_arr["photos"] = $res_data;
            $res_arr["totalPages"] = $totalPages;
            return Result::successWithData($res_arr);
        }
        return Result::success();
    }

    public function findFavPhotosByUid($id, $pageNum, $pageSize)
    {
        $query = "SELECT * FROM `travelimagefavor` left join `travelimage` t on travelimagefavor.ImageID = t.ImageID WHERE travelimagefavor.UID=$id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $totalPages = intval($num/$pageSize);
        if($num%$pageSize>0){
            $totalPages = $totalPages + 1;
        }
        $strSQL = $query . " limit " . (($pageNum-1)*$pageSize). "," . $pageSize;
        $stmt = $this->conn->prepare($strSQL);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }
            $res_arr = array();
            $res_arr["photos"] = $res_data;
            $res_arr["totalPages"] = $totalPages;
            return Result::successWithData($res_arr);
        }
        return Result::success();
    }

    public function getFavCounts($Id) {
        $query = "SELECT COUNT(*) AS favCount FROM `travelimagefavor` WHERE ImageID=$Id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        extract($row);
        return $favCount;
    }
    public function findPhotoById($Id)
    {
        $query = "SELECT * FROM `travelimage` WHERE ImageID=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $Id);
        $stmt->execute();
        $num = $stmt->rowCount();
        $favCount = $this->getFavCounts($Id);
        if ($num != 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $photo = new Photo();
            $city = $this->cityNameHelper($CityCode);
            $country = $this->countryNameHelper($CountryCodeISO);
            $photo->photoId = $ImageID;
            $photo->cityCode = $city;
            $photo->favCount = $favCount;
            $photo->path = $PATH;
            $photo->countryCode = $country;
            $photo->uid = $UID;
            $photo->title = $Title;
            $photo->description = $Description;
            $photo->theme = $Theme;
            return Result::successWithData($photo);
        }
        return Result::fail();
    }

    public function getPhotosBy($selector, $flag)
    {
        $query = null;
        $stmt = null;
        $num = null;
        if ($flag === "Country") {
            $query = "SELECT * FROM `travelimage` WHERE CountryCodeISO=:countryCode";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":countryCode", $selector);
            $stmt->execute();
            $num = $stmt->rowCount();
        }
        if ($flag === "City") {
            $query = "SELECT * FROM `travelimage` WHERE CityCode=:cityCode";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":cityCode", $selector);
            $stmt->execute();
            $num = $stmt->rowCount();
        }
        if ($flag === "Theme") {
            $query = "SELECT * FROM `travelimage` WHERE Theme=:theme";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":theme", $selector);
            $stmt->execute();
            $num = $stmt->rowCount();
        }
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }

            return Result::successWithData($res_data);
        }
        return Result::success();
    }

    public function getPhotosBy3($cityCode, $countryCode, $theme)
    {
        $query = "SELECT * FROM `travelimage` WHERE CountryCodeISO=:countryCode AND CityCode=:cityCode AND Theme=:theme";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":countryCode", $countryCode);
        $stmt->bindParam(":theme", $theme);
        $stmt->bindParam(":cityCode", $cityCode);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }

            return Result::successWithData($res_data);
        }
        return Result::success();
    }

    public function searchByTitle($title)
    {
        $query = "SELECT * FROM `travelimage` WHERE Title like '%$title%'";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }

            return Result::successWithData($res_data);
        }
        return Result::success();
    }

    public function getHotPhotos()
    {
        $query = "SELECT * FROM `travelimage` WHERE `ImageID` IN
                (
                    SELECT `ImageID` FROM
                    (
                        SELECT `ImageID`, count(*) AS fav_count
                        FROM  `travelimagefavor`
                        GROUP BY `ImageID`
                        ORDER BY fav_count DESC
                        LIMIT 5
                    )
                    AS TMP
                )";
//        $query = "SELECT `ImageID`, count(*) AS fav_count FROM `travelimagefavor` ORDER BY `fav_count` DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }

            return Result::successWithData($res_data);
        }
        return Result::success();
    }


    public function getPhotos($pageNum, $pageSize, $filter)
    {
        $query = null;
        switch ($filter->type) {
            case "Country":
                $query = "SELECT * FROM `travelimage` WHERE CountryCodeISO='$filter->val'";
                break;
            case "City":
                $query = "SELECT * FROM `travelimage` WHERE CityCode='$filter->val'";
                break;
            case "Theme":
                $query = "SELECT * FROM `travelimage` WHERE Theme='$filter->val'";
                break;
            case "None":
                $query = "SELECT * FROM `travelimage`";
                break;
            case "Title":
                $query = "SELECT * FROM `travelimage` WHERE Title like '%$filter->val%'";
                break;
            case "Description":
                $query = "SELECT * FROM `travelimage` WHERE Description like '%$filter->val%'";
                break;
            case "All":
                $query = "SELECT * FROM `travelimage` WHERE CountryCodeISO='$filter->countryCode' AND CityCode='$filter->cityCode' AND Theme='$filter->theme'";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        $totalPages = intval($num/$pageSize);
        if($num%$pageSize>0){
            $totalPages = $totalPages + 1;
        }
        $strSQL = $query . " limit " . (($pageNum-1)*$pageSize). "," . $pageSize;
        $stmt = $this->conn->prepare($strSQL);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }
            $res_arr = array();
            $res_arr["photos"] = $res_data;
            $res_arr["totalPages"] = $totalPages;
            return Result::successWithData($res_arr);
        }
        return Result::success();
    }

    public function getHotPhotosRan()
    {
        $query = "SELECT * FROM `travelimage` WHERE ImageID >= ((SELECT MAX(ImageID) FROM travelimage)-(SELECT MIN(ImageID) FROM travelimage)) * RAND() + (SELECT MIN(ImageID) FROM travelimage)  LIMIT 6";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num != 0) {
            $res_data = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $photo = new Photo();
                $photo->photoId = $ImageID;
                $photo->cityCode = $CityCode;
                $photo->path = $PATH;
                $photo->countryCode = $CountryCodeISO;
                $photo->uid = $UID;
                $photo->title = $Title;
                $photo->description = $Description;
                $photo->theme = $Theme;
                array_push($res_data, $photo);
            }

            return Result::successWithData($res_data);
        }
        return Result::success();
    }


}