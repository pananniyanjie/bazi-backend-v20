<?php
// 设置返回json格式数据
//0204
header('content-type:application/json;charset=utf8');
// 关闭报错
error_reporting(E_ALL^E_NOTICE^E_WARNING);
require_once('../config/config.php');
class res{
    public $id;
    public $nickName;
    public $phoneNum;
    public $token;
}

class ress {
    public $data;
    public $code;
    public $msg;
}

$results = null;
$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";

$token = $_GET["token"];

//连接数据库
$link = mysqli_connect("127.0.0.1", "bazidbuser", "bazidbuserpwd","bazi") or die(json_encode($end));
mysqli_query($link,"SET NAMES 'UTF8'");
// 查询数据到数组中
$stmt = $link->prepare("SELECT id,phone_num,nick_name FROM db_user WHERE username = ? ");
$stmt->bind_param("s",$username);
$stmt->execute();

$stmt->bind_result($id, $phoneNum, $nickName);

while ($stmt->fetch()) {
    $re = new res();
    $re->id = $id;
    $re->nickName = $nickName;
    $re->phoneNum = $phoneNum;
    $results = $re;
};
// 将数组转成json格式

// echo json_encode($results);

if($results->id== null || $results->id <1){
    $end -> data = null;
    $end -> code = 404;
    $end -> msg = "该用户不存在或用户名或密码错误！请仔细检查2";
}else{
    $end -> data = $results;
    $end -> code = 200;
    $res = new token();
	$end -> data -> token = base64_encode(json_encode($res));
	
	//$end -> data -> tokenrow = base64_decode(openssl_decrypt($end -> token,"AES-128-ECB","CPTBTPTP",0));
    $end -> msg = "登录成功，正在跳转";
}


mysqli_close($link);
echo json_encode($end);


?>