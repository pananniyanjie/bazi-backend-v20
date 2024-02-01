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
    public $token;
    public $rule;
}

class ress {
    public $data;
    public $code;
    public $msg;
}
class token{
    public $id;
    public $username;
    public $nick_name;
    public $phonenum;
    public $rule;
    public $state;
    public $token;
    public $avatar;
    public $setting;
    public $createtime;
}

$results = null;
$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";

$in_username = $_GET["username"];
$in_password = $_GET["password"];
//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
mysqli_query($link,"SET NAMES 'UTF8'");
// 查询数据到数组中
$stmt = $link->prepare("SELECT id,username,nick_name,phone_num,password,salt,rule,state,token,avatar,setting,create_time FROM db_user WHERE username = ? ");
$stmt->bind_param("s",$in_username);
$stmt->execute();
$stmt->bind_result($id,$username,$nick_name,$phone_num,$password,$salt,$rule,$state,$token,$avatar,$setting,$create_time);
$res = new token();
while ($stmt->fetch()) {
    $tmp = md5($in_password.$salt);
    if($tmp != $password ){
        break;
    }
    $re = new res();
    $re->id = $id;
    $re->rule = $rule;
    $re->nickName = $nick_name;
    $re->phoneNum = $phone_num;
    $results = $re;

    $res -> id = $id;
    $res -> username = $username;
    $res -> nick_name =mb_convert_encoding($nick_name, 'UTF-8');
    $res -> phone_num = $phone_num;
    $res -> rule = $rule;
    $res -> state= $state;
    $res -> token= $token;
    $res -> avatar= $avatar;
    $res -> setting= json_decode($setting);
    $res -> create_time= $create_time;

};
// 将数组转成json格式

// echo json_encode($results);

if($results->id== null || $results->id <1){
    $end -> data = null;
    $end -> code = 404;
    $end -> msg = "该用户不存在或用户名或密码错误，请仔细检查！";
}else if($state == 0){
    $end -> data = null;
    $end -> code = 302;
    $end -> msg = "此账户已经到期或以被禁用，如有疑问请联系管理人员。";
}else{
    $end -> data = $results;
    $end -> code = 200;
	$end -> data -> token = base64_encode(json_encode($res));
	//$end -> data -> tokenrow = base64_decode($end -> data -> token);
    $end -> msg = "登录成功，正在跳转";
}


mysqli_close($link);
echo json_encode($end);
?>