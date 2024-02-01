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
$sql;
if($type == 0){
    $sql = "SELECT id,shoot_time,user_id,(SELECT display_id from db_bazi WHERE id = bazi_id LIMIT 1) AS bazi_id,point_x,point_y,scoure,mode,type,state,team_id,contest_id FROM db_shoot_list WHERE bazi_id = ".(string)$baziId." AND (SHOOT_TIME BETWEEN ".$s_time." AND ".$e_time.") AND state = 0  ORDER BY shoot_time ASC";
}else{
    $sql = "SELECT id,shoot_time,user_id,(SELECT display_id from db_bazi WHERE id = bazi_id LIMIT 1) AS bazi_id,point_x,point_y,scoure,mode,type,state,team_id,contest_id FROM db_shoot_list WHERE bazi_id = ".(string)$baziId." AND (SHOOT_TIME > ".$s_time.") AND state = 1 ORDER BY shoot_time ASC";
}
//echo ($sql);
$obj = $link->query($sql);
$lst = array();
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
        $lst[] = $row['id'];
    }
}
if($type == 0){
    foreach ($lst as $it) {
        //echo($it."\n");
    
        $sql = "UPDATE db_shoot_list SET state=1 WHERE id=".$it;
        $obj = $link->query($sql);
    }
    
}




/*
$stmt = $link->prepare("SELECT id,shoot_time,user_id,bazi_id,point_x,point_y,scoure,mode,type,state,team_id,contest_id FROM db_shooy_list WHERE user_id = " + $scrid);
//$stmt->bind_param("i",114514);
$stmt->execute();
$stmt->bind_result($id,$shoot_time,$user_id,$bazi_id,$point_x,$point_y,$scoure,$mode,$type,$state,$team_id,$contest_id);

while ($stmt->fetch()) {
    $res = new respone();
    $res-> id = $id;
    $res-> shoot_time = $shoot_time;
    $res-> user_id = $user_id;
    $res-> bazi_id = $bazi_id;
    $res-> point_x = $point_x;
    $res-> point_y = $point_y;
    $res-> scoure = $scoure;
    $res-> mode = $mode;
    $res-> type = $type;
    $res-> state = $state;
    $res-> team_id = $team_id;
    $res-> contest_id = $contest_id;

    $results[] = $res;
};
// 将数组转成json格式
// echo json_encode($results);
*/

$end -> data = $results;
$end -> code = 200;
$end -> msg = "获取成功！";



mysqli_close($link);
echo json_encode($end);
?>