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
$type = $rrr["type"];
$queryId = $rrr["queryId"];
$token = json_decode(base64_decode($in_token),true);
$scrid=(int)$token['id'];
$rule=(int)$token['rule'];
$state=(int)$token['state'];
//鉴权
if($rule < 10 || $state !=1){
    $end->msg="账号权限不足或已被禁用！";
    echo json_encode($end);
    exit();
}

//连接数据库
$link = mysqli_connect(DB_HOST, DB_USER, DB_PWD,DB_DBNAME) or die(json_encode($end));
$link->query("SET NAMES 'UTF8'");
// 查询数据到数组中
//$scrid = 2335;
$sql;
if($type == 0){
    $sql = "SELECT *,(select name from db_link where id = link_id LIMIT 1) AS link_name FROM db_user ORDER BY id ASC";
}else if($type == 1){
    //按照ID查询
    $sql = "SELECT * FROM db_user WHERE id = ".(string)$queryId." ORDER BY id ASC";
}else{
    //按照账号查询
    $sql = "SELECT * FROM db_user WHERE username = ".(string)$queryId." ORDER BY id ASC";
}
//echo ($sql);
$obj = $link->query($sql);
$lst = array();
if($obj->num_rows > 0){
    while($row = $obj->fetch_assoc()){
        $res = new respone();
        $res-> id = $row['id'];
        $res-> username = $row['username'];
        $res-> nick_name = $row['nick_name'];
        $res-> phone_num = $row['phone_num'];
        $res-> rule = $row['rule'];
        $res-> state = $row['state'];
        $res-> avatar = $row['avatar'];
        $res-> link_id = $row['link_id'];
        $res-> link_name = $row['link_name'];
        $res-> setting = $row['setting'];
        $res-> create_time = $row['create_time'];
        $res-> update_time = $row['update_time'];
        $results[] = $res;
        $lst[] = $row['id'];
    }
}
foreach ($lst as $it) {
    //echo($it."\n");
    $sql = "UPDATE db_shoot_list SET state=1 WHERE id=".$it;
    $obj = $link->query($sql);
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