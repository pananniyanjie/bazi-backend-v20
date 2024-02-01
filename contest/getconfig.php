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
    public $title;
    public $mode;
    public $point;
    public $roundLimit;
    public $timeLimit;
    public $free;
}
$end = new ress();
$configfile = "./ContestConfig.txt"; // 要读取的文本文件名
$raw_config = file_get_contents($configfile);
$lst = explode("|",$raw_config);
$config = new Config();
$config -> title = $lst[0];
$config -> mode = $lst[1];
$config -> point = $lst[2];
$config -> roundLimit = $lst[4];
$config -> timeLimit = $lst[3];
$config -> free = $lst[5];
// echo $content; // 输出文本文件的内容

$end -> data = $config;
$end -> code = 200;
$end -> msg = "获取成功！";


echo json_encode($end);

?>