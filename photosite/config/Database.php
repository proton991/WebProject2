<?php
class Database{

    // specify your own database credentials
    private $host = "rm-bp1h178crvw04w5cbno.mysql.rds.aliyuncs.com";
    private $db_name = "travels";
    private $u = "cxy";
    private $p = "990911Cxy";
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->u, $this->p);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}