<?php
include_once '../config/RedisUtil.php';
$redis = new RedisUtil();
$redis->save("test", "test");
$redis->delete("test");
$redis = null;
