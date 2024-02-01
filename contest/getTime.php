<?php


header('content-type:application/json;charset=utf8');
// 关闭报错
error_reporting(E_ALL^E_NOTICE^E_WARNING);
require_once('../config/config.php');
class ress {
    public $data;
    public $code;
    public $msg;
}
class Config{
    public $startTime;
}
$end = new ress();
$configfile = "./StartTime.txt"; // 要读取的文本文件名
$raw_config = file_get_contents($configfile);

$config = new Config();
$config -> startTime = $raw_config;
// echo $content; // 输出文本文件的内容

$end -> data = $config;
$end -> code = 200;
$end -> msg = "获取成功！";


echo json_encode($end);

?>