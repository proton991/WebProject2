<?php

include_once '../config/Result.php';

use config\Result;

class CategoryService
{
//SELECT `AsciiName` FROM `geocities` WHERE `GeoNameID` IN
//(
//SELECT `CityCode` FROM
//(
//SELECT `CityCode`, count(*) AS city_count
//FROM  `travelimage`
//WHERE `CityCode` IS NOT NULL
//GROUP BY `CityCode`
//ORDER BY city_count DESC
//LIMIT 10
//)
//AS TMP
//)

//
//SELECT `CountryName` FROM `geocountries` WHERE `ISO` IN
//(
//SELECT `CountryCodeISO` FROM
//(
//SELECT `CountryCodeISO`, count(*) AS country_count
//FROM  `travelimage`
//WHERE `CountryCodeISO` IS NOT NULL
//GROUP BY `CountryCodeISO`
//ORDER BY country_count DESC
//LIMIT 10
//)
//AS TMP
//)
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCitiesByISO($ISO)
    {
        $query = "select distinct `AsciiName`, `GeoNameID` from `geocities` where CountryCodeISO=:ISO order by `AsciiName`";
        $res = new Result();
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":ISO", $ISO);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $res->message = "success";
            $res->code = 200;

        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tmp = array();
            $tmp["cityName"] = $AsciiName;
            $tmp["cityID"] = $GeoNameID;
            array_push($res->data, $tmp);
        }
        return json_encode(Result::successWithData($res->data));
    }

    public function getCountries()
    {
        $query = "select `ISO`, `CountryName` from geocountries order by `CountryName`";
        $res = new Result();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $res->message = "success";
            $res->code = 200;

        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($res->data, array("CountryCode" => $ISO, "CountryName" => $CountryName));
        }
        return json_encode($res);
    }

    public function getHotCity()
    {
        $query = "SELECT `AsciiName`, `GeoNameID` FROM `geocities` WHERE `GeoNameID` IN
                (
                    SELECT `CityCode` FROM
                    (
                        SELECT `CityCode`, count(*) AS city_count
                        FROM  `travelimage`
                        WHERE `CityCode` IS NOT NULL
                        GROUP BY `CityCode`
                        ORDER BY city_count DESC
                        LIMIT 5
                    )
                    AS TMP
                )";
        $res = new Result();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $res->message = "success";
            $res->code = 200;

        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tmp = array();
            $tmp["cityName"] = $AsciiName;
            $tmp["cityID"] = $GeoNameID;
            array_push($res->data, $tmp);
        }
        return json_encode($res);
    }

    public function getHotCountry()
    {
        $query = "SELECT `CountryName`, `ISO` FROM `geocountries` WHERE `ISO` IN
                (
                    SELECT `CountryCodeISO` FROM
                    (
                        SELECT `CountryCodeISO`, count(*) AS country_count
                        FROM  `travelimage`
                        WHERE `CountryCodeISO` IS NOT NULL
                        GROUP BY `CountryCodeISO`
                        ORDER BY country_count DESC
                        LIMIT 5
                    )
                    AS TMP
                )";
        $res = new Result();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $res->message = "success";
            $res->code = 200;

        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tmp["countryName"] = $CountryName;
            $tmp["countryID"] = $ISO;
            array_push($res->data, $tmp);
        }
        return json_encode($res);
    }

    public function getHotTheme()
    {
        $query = "
                    SELECT `Theme`, count(*) AS theme_count
                    FROM  `travelimage`
                    GROUP BY `Theme`
                    ORDER BY theme_count DESC
                    LIMIT 3
                   ";
        $res = new Result();
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $res->message = "success";
            $res->code = 200;

        }
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($res->data, $Theme);
        }
        return json_encode($res);
    }

    public function getThemes()
    {
//        $query = " SELECT distinct `Theme` FROM  `travelimage`";
        $res = new Result();
//        $stmt = $this->conn->prepare($query);
//        $stmt->execute();
//        if ($stmt->rowCount() != 0) {
//            $res->message = "success";
//            $res->code = 200;
//
//        }
//        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//            extract($row);
//            array_push($res->data, $Theme);
//        }
        $arr = array();
        array_push($arr, "Other");
        array_push($arr, "Scenery");
        array_push($arr, "People");
        array_push($arr, "Animal");
        array_push($arr, "Building");
        array_push($arr, "Wonder");
        array_push($arr, "City");
        $res->code = 200;
        $res->data = $arr;
        return json_encode($res);

    }
}