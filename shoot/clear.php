
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

$results = array();
$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";
$pwd= $_GET["pwd"];
if($pwd != API_PWD){
    echo json_encode($end);
    exit();
}
//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
// 查询数据到数组中
//$scrid = 2335;
$sql;
$need = urldecode(base64_decode($need));
$sql = "DELETE FROM db_shoot_list";
// echo($need);
//echo ($sql);
$obj = $link->query($sql);

$end -> data = null;
$end -> code = 200;
$end -> msg = "记录已清除！";

mysqli_close($link);
echo json_encode($end);
?>