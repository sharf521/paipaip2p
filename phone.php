<?php 
//基本配置文件
include ("./core/config.inc.php");
include ("./core/phone.inc.php");
include ("./core/json.php");
$json = new JSON;

//系统基本信息
$system = array();
$system_name = array();
$_system = $mysql->db_selects("system");
foreach ($_system as $key => $value){
	$system[$value['nid']] = $value['value'];
	$system_name[$value['nid']] = $value['name'];
}
$_G['system'] = $system;
$_G['system_name'] = $system_name;


$_G['nowtime'] = time();//现在的时间

$_G['weburl'] = "http://".$_SERVER['SERVER_NAME'];//当前的域名


//判断采用何种方式登录
$_user_id = array("");
$_G['is_cookie'] = isset($_G['system']['con_cookie'])?(int)$_G['system']['con_cookie']:0;
if ($_G['is_cookie'] ==1){
	$_user_id = explode(",",authcode(isset($_COOKIE[Key2Url("user_id","DWCMS")])?$_COOKIE[Key2Url("user_id","DWCMS")]:"","DECODE"));
}else{
	if (isset($_SESSION['login_endtime']) && $_SESSION['login_endtime']>time()){
		$_user_id = explode(",",authcode(isset($_SESSION[Key2Url("user_id","DWCMS")])?$_SESSION[Key2Url("user_id","DWCMS")]:"","DECODE"));
	}
	
}
$_G['user_id'] = $_user_id[0];


if($_POST['action']=="getvf"){
	$code=rand_string(4);
	$recode = sendSMS($_phone_username,$_phone_userpass,$_POST['phone'],$code);
	if($recode=='100'){
		$sql="insert into `dw_sms` set phone='{$_POST['phone']}',code='{$code}',userid = '{$_G['user_id']}' ,`time`='".time()."'";
		$re = $mysql->db_query($sql);
		$data['success'] = 1;
		$data['success_msg'] = iconv("gbk","utf-8","验证码发送成功，请在10分钟内验证");
		exit($json->encode($data));
	}else{
		$data['success'] = 0;
		$data['success_msg'] = iconv("gbk","utf-8","验证码获取失败");
		exit($json->encode($data));
	}
}elseif($_POST['action']=="vf"){

	$sql = "select id from `dw_sms` where phone='{$_POST['phone']}' AND userid = '{$_G['user_id']}' AND code='{$_POST['vf']}' AND `time`>".(time()-600)."";

	$re = $mysql->db_query($sql);
	$res = mysql_fetch_array($re);

	if($res['id']>0){
		include ("./modules/credit/credit.class.php");

		$mysql->db_query("update {user} set email_status=1,is_phone=1,phone='{$_POST['phone']}' where user_id='{$_G['user_id']}'");
		
		$result = creditClass::GetTypeOne(array("nid"=>"email"));
		$credit['nid'] = "email";
		$credit['user_id'] = $_G['user_id'];
		$credit['value'] = $result['value'];
		$credit['op_user'] = 0;
		$credit['op'] = 1;//增加
		$credit['type_id'] = $result['id'];
		$credit['remark'] = "手机认证成功";
		creditClass::UpdateCredit($credit);//更新积分

		$data['success'] = 1;
		$data['success_msg'] = iconv("gbk","utf-8","验证成功，现在进入下一步");
		exit($json->encode($data));
	}else{
		$data['success'] = 0;
		$data['success_msg'] = iconv("gbk","utf-8","验证码错误");
		exit($json->encode($data));
	}
}

function rand_string($len=6,$type='',$addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }
    if($len>10 ) {//位数过长重复字符串一定次数
        $chars= $type==1? str_repeat($chars,$len) : str_repeat($chars,5);
    }
    $chars   =   str_shuffle($chars);
    $str     =   substr($chars,0,$len);
    return strtolower($str);
}

?>