<?php
// 设置返回json格式数据
//0204
header('content-type:application/json;charset=utf8');
// 关闭报错
error_reporting(E_ALL^E_NOTICE^E_WARNING);
//导入配置
require_once('../config/config.php');
class ress {
    public $data;
    public $code;
    public $count;
    public $msg;
}
class respone{
    public $id;
}

$results = array();
$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";
$rrr = file_get_contents('php://input');
$rrr = json_decode($rrr,true);
$in_token = $rrr["token"];
$type = $rrr["type"];
$queryId = $rrr["queryId"];
$token = json_decode(base64_decode($in_token),true);
$lst = $rrr["contestBazi"];
$scrid=(int)$token['id'];
$rule=(int)$token['rule'];
$state=(int)$token['state'];
// 鉴权 - 仅限教练&管理员接口，
if($rule  < 5 || $state !=1){
    $end->msg="账号权限不足或已被禁用！";
    echo json_encode($end);
    exit();
}

//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
$link->query("UPDATE db_bazi SET mode=1");
// 查询数据到数组中
$sql = "";
$f = 0;
foreach($lst as $key => $value){
    if($f != 0){
        $sql = $sql." OR ";
        $sql = $sql." id=".$value." ";
    }else{
        $sql = $sql." WHERE id=".$value." ";
    }
    $f = 1;

}
$end -> count = 0;
$end -> data = null;
$end -> code = 200;
$end -> msg = "更新成功！";
if( strlen($sql) <3){
    echo json_encode($end);
    exit();
}
$sql = "UPDATE db_bazi SET mode=2 ".$sql;
$obj = $link->query($sql);





mysqli_close($link);
echo json_encode($end);
?>