<?php
include_once '../config/Result.php';
include_once  '../config/RedisUtil.php';
use config\Result;


class UserService
{
    private $table_name = "traveluser";
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save($user)
    {
        $query = "INSERT INTO " . $this->table_name . " SET UserName=:username, Pass=:pass, State=:state";
        $stmt = $this->conn->prepare($query);
        $userStatus = 1;
        $stmt->bindParam(":username", $user->username);
        $stmt->bindParam(":pass", $user->password);
        $stmt->bindParam(":state", $userStatus);
        return $stmt->execute();
    }

    public function findUserByName($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE UserName=:username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();
        if ($num!= 0) {
            extract($row);
            $result = array(
                "id" => $UID,
                "username" => $UserName,
                "password" => $Pass
            );
            return $result;
        }
        return null;

    }

    public function login($login_form)
    {
        $user = $this->findUserByName($login_form->username);
        session_start();
        $res = new Result();
        if (is_null($user)) {
            $res->code = 50001;
            $res->message = "Login failed, user not exist!";
        }
//        if ($this->redis->get($user["username"]) != null) {
//            $res->code = 50002;
//            $res->message = "You have already logged in";
//            return json_encode($res);
//        }
        if (!empty($_SESSION["userinfo"])) {
            $res->code = 50002;
            $res->message = "You have already logged in";
            return json_encode($res);
        }
        if (strcmp($user["password"], $login_form->password) == 0) {
            $userinfo = array(
                'uid' => $user["id"],
                'username' => $user["username"]
            );

            $salt = "fudan";
            $cookie = serialize($userinfo);
            $cookie = base64_encode(openssl_encrypt($cookie, 'des-ede3', $salt, 0));
//            $this->redis->save($user["username"], $cookie);
//            $this->redis->save($cookie, $user["username"]);
            $_SESSION["userinfo"] = array(
                "token"=>$cookie,
                "username"=>$user["username"],
                "id"=>$user["id"]
            );
            $arr = array(
                "username"=>$user["username"],
                "token"=>$cookie
            );
            return json_encode(Result::successWithData($arr));
        } else {
            $res->code = 50002;
            $res->message = "Login failed, wrong password!";
        }
        return json_encode($res);
    }

    public function register($register_form)
    {
        $res = new Result();
        if ($this->findUserByName($register_form->username) != null) {
            $res->code = 50003;
            $res->message = "Register failed, user already exist, change your username";
            return json_encode($res);
        }
        if ($this->save($register_form)) {
            return json_encode(Result::success());
        }
        return json_encode($res);
    }

    public function logout($data)
    {
        session_start();
//        echo strcmp($_SESSION["userinfo"]["token"], $data->cookie);

        if (!empty($_SESSION["userinfo"]) && strcmp($_SESSION["userinfo"]["token"], $data->cookie) == 0) {
            unset($_SESSION["userinfo"]);
            return json_encode(Result::success());
        }
        $res = new Result();
        $res->code = 50004;
        $res->message = "logout failed";
        return json_encode($res);
    }
}