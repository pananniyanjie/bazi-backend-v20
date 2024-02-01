<?php
// 设置返回json格式数据
// 传入id数组，传回封装好的射击记录
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
$allresults = array();
$end = new ress();
$end->code=502;
$end->data=null;
$end->msg="内部系统出错！";
$rrr = file_get_contents('php://input');
$rrr = json_decode($rrr,true);

$in_token = $rrr["token"];
$s_time = $rrr["startime"];
$e_time = $rrr["endtime"];
$type = $rrr["type"];
$baziId = $rrr["baziId"];
$token = json_decode(base64_decode($in_token),true);
$scrid=(int)$token['id'];
//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
// 查询数据到数组中
//$scrid = 2335;
$sql = "";
foreach($baziId AS $key => $value){
    $sql = "SELECT id,shoot_time,user_id,(SELECT display_id from db_bazi WHERE id = bazi_id LIMIT 1) AS bazi_id,point_x,point_y,scoure,mode,type,state,team_id,contest_id FROM db_shoot_list WHERE bazi_id = ".(string)$value." AND (SHOOT_TIME >= ".$s_time.") AND state = 0  ORDER BY shoot_time ASC";
    //echo ($sql);
    $obj = $link->query($sql);
    $results= [];
    if($obj->num_rows > 0){
        
        while($row = $obj->fetch_assoc()){

            $res = new respone();
            $res-> id = $row['id'];
            $res-> shoot_time = $row['shoot_time'];
            $res-> user_id = $row['user_id'];
            $res-> bazi_id = $row['bazi_id'];
            $res-> point_x = $row['point_x'];
            $res-> point_y = $row['point_y'];
            $res-> scoure = $row['scoure'];
            $res-> mode = $row['mode'];
            $res-> type = $row['type'];
            $res-> state = $row['state'];
            $res-> team_id = $row['team_id'];
            $res-> contest_id = $row['contest_id'];
            $results[] = $res;
        }
       
    }
    $allresults[(string)$value] =  $results;
}



$end -> data = $allresults;
$end -> code = 200;
$end -> msg = "获取成功！";



mysqli_close($link);
echo json_encode($end);
?>