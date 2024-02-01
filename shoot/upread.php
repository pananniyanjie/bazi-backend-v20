<?php
// 设置返回json格式数据
//0204
header('content-type:application/json;charset=utf8');
// 关闭报错
error_reporting(E_ALL^E_NOTICE^E_WARNING);
require_once('../config/config.php');
class ress {
    public $data;
    public $code;
    public $msg;
}
class respone{
    public $id;
}

$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";
$rrr = file_get_contents('php://input');
$rrr = json_decode($rrr,true);
$lst = $rrr["lst"] ;

//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
// 查询数据到数组中

$cnt = 0;
foreach ($rrr["lst"] as $it) {
    //echo($it."\n");
    $sql = "UPDATE db_shoot_list SET state=1 WHERE id=".$it;
    $obj = $link->query($sql);
    $cnt++;

}






$end -> data = $cnt;
$end -> code = 200;
$end -> msg = "获取成功！";



mysqli_close($link);
echo json_encode($end);
?>