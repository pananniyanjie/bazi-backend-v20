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
$lst = $rrr["lst"];
$token = json_decode(base64_decode($in_token),true);
$scrid=(int)$token['id'];
$rule=(int)$token['rule'];
$state=(int)$token['state'];
// 鉴权 - 公共接口，无需鉴权
// if($rule < 10 || $state !=1){
//     $end->msg="账号权限不足或已被禁用！";
//     echo json_encode($end);
//     exit();
// }

//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
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

$sql ="SELECT *,(SELECT nick_name FROM db_user WHERE id = link_user LIMIT 1 ) AS 'nick_name' FROM db_bazi ".$sql."ORDER BY id ASC";
// echo($sql);
$obj = $link->query($sql);

if($obj->num_rows > 0){
    while($row = $obj->fetch_assoc()){
        $res = new respone();
        $res-> id = $row['id'];
        $res-> display_id = $row['display_id'];
        $res-> mode = $row['mode'];
        $res-> type = $row['type'];
        $res-> ip = $row['ip'];
        $res-> mac = $row['mac'];
        $res-> state = $row['state'];
        $res-> link_user = $row['link_user'];
        $res-> link_group = $row['link_group'];
        $res-> config = $row['config'];
        $res-> nick_name = $row['nick_name'];
        $results[] = $res;
        $lst[] = $row['id'];
        // echo("*");
    }
}

// print_r($results);
$end -> count = count($results);
$end -> data = $results;
$end -> code = 200;
$end -> msg = "获取成功！";



mysqli_close($link);
echo json_encode($end);
?>