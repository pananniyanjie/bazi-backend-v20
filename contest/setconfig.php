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
$end = new ress();


// $rrr = file_get_contents('php://input');
// $rrr = json_decode($rrr,true);
// $in_token = $rrr["token"];
// $token = json_decode(base64_decode($in_token),true);
// $scrid=(int)$token['id'];
// $rule=(int)$token['rule'];
// $state=(int)$token['state'];
// // 鉴权 - 仅限教练&管理员接口，
// if($rule  < 5 || $state !=1){
//     $end->msg="账号权限不足或已被禁用！";
//     echo json_encode($end);
//     exit();
// }



$config =  (string)$_GET["title"]."|".(string)$_GET["mode"]."|".(string)$_GET["point"]."|".(string)$_GET["timeLimit"]."|".(string)$_GET["roundLimit"]."|0";
$filename = "./ContestConfig.txt"; // 要读取的文本文件名
// 使用 file_put_contents 函数将文本写入文件
file_put_contents($filename, $config);


$end -> data = null;
$end -> code = 200;
$end -> msg = "设置成功！";


echo json_encode($end);

?>