<?php

namespace config;
class Result
{
    public $code;

    public $message;

    public $data;

    public function __construct()
    {
        $this->data = array();
    }


    public static function success() {
        $res = new Result();
        $res->code = 200;
        $res->message = "success";
        return $res;
    }

    public static function successWithData($data) {
        $res = new Result();
        $res->code = 200;
        $res->message = "success";
        $res->data = $data;
        return $res;
    }

    public static function notLoginError() {
        $res = new Result();
        $res->code = 50010;
        $res->message = "please log in first";
        return $res;
    }

    public static function fail() {
        $res = new Result();
        $res->code = 60000;
        $res->message = "something went wrong...";
        return $res;
    }


}