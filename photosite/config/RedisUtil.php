<?php


class RedisUtil
{
    private $server;
    private $port;
    private $redis;

    function __construct()
    {
        $this->server = "114.55.143.194";
        $this->port = 6379;
        $this->redis = new Redis();
        $this->redis->connect($this->server, $this->port);
    }
    function __destruct()
    {
        // TODO: Implement __destruct() method.
        echo "\n";
        $this->redis->close();
    }
    function save($key, $value){
        $this->redis->set($key, $value);
    }
    function delete($key){
        $this->redis->del($key);
    }
    function get($key) {
        return $this->redis->get($key);
    }


}