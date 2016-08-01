<?php
if (!defined('ROOT_PATH')) die('不能访问'); //防止直接访问

require_once ROOT_PATH . '/config_ucenter.php';
require_once ROOT_PATH . '/uc_client/client.php';
include_once (ROOT_PATH."core/encrypt.php");
function is_email($email){
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-]+(\.\w+)+$/", $email);
}

$e_uc_user_id = $_REQUEST['user_id'];
$direct_login = false;
if (isset($_REQUEST['user_id'])){
	$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234abc5678";
	$uc_user_id =  DeCode($e_uc_user_id,'D',$con_mall_key);
	if ($uc_user_id !=""){
		$sql = "select * from  {user}  where uc_user_id = '{$uc_user_id}' limit 1";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_POST['keywords'] = $result['username'];
			$_POST['password'] = $result['password'];
			$direct_login = true;
		}
		else{
			$msg = array("该用户还没有激活，请登陆激活后再试！", "", "?user&&q=action/login");
		}
	}
}

if (isset($_POST['password']) ) {
	$login_msg = "";
	
	if ($_POST['keywords'] == "") {
		$msg = array("账号不能为空", "", "?user&&q=action/login");
	} 
	elseif (isset($_POST['valicode']) &&  strtolower($_POST['valicode'])!=$_SESSION['valicode']) {
		$msg = array("验证码错误", "", "?user&&q=action/login");
	}
	elseif ($_POST['password'] == "") {
		$msg = array("密码不能为空", "", "?user&&q=action/login");
	}
	elseif(is_email($_POST['keywords'])){
		$msg = array("请使用-用户名-登录！", "", "?user&&q=action/login");
	}else {

			
		if (!isset($index['user_id']) || $index['user_id'] == "") {
			$index['user_id'] = $_POST['keywords'];
		}
		$index['email'] = $_POST['keywords'];
		$index['username'] = $_POST['keywords'];
		$index['password'] = $_POST['password'];
		$index['direct_login'] = $direct_login;
		if ($rdGlobal['uc_on'])
		{
			if($direct_login){
				$ucsynlogin = uc_user_synlogin($uc_user_id);
				$uid = $uc_user_id;
			}else{
				//list($uid, $ucusername, $ucpassword, $email) = outer_call('uc_user_login', array($_POST['keywords'], $_POST['password']));
				list($uid, $ucusername, $ucpassword, $email) = uc_user_login($_POST['keywords'], $_POST['password']);
			}
			if ($uid > 0) {
				//$ucsynlogin = uc_user_synlogin($uid);
				$sql = "select * from  {user}  where username = '" . $_POST['keywords'] . "' limit 1";
				
				$result = $mysql -> db_fetch_array($sql);
					
				/***
				 * 登陆时验证动态口令
				* by:timest 2012-07-26 奥运之夜
				*/

				if(isset($result['serial_id']) && $result['serial_id']!='' ){
					$is_used_uchon = json_decode($result['serial_status'])->{"login"} == '1' ? 1 : 0;
					if($is_used_uchon == 1 && (!isset($_POST['uchoncode']) || $_POST['uchoncode'] == '') ){
						$msg = array("请输入动态密码", "", "?user&q=action/login&errror=" . $uid);
						return ;
					}
					if( $is_used_uchon == 1 && otp_check($result['serial_id'], $_POST['uchoncode'])!='200'){
						$msg = array("动态密码有误,请重试！", "", "?user&q=action/login&errror=" . $uid);
						return ;
					}
				}
				if (empty($result)) 
				{					
					list($uid, $username, $email) = uc_get_user($uid, 1);
	
					$index = array();
					$index["email"] = $email;
					$index["username"] = $username;
					$index["realname"] = $username;
					$index["password"] = $_POST['password'];
					$index["type_id"] = 2;					
					$index['uc_user_id'] = $uid;
					$index['areaid'] = $_G['areaid'];
					$user_id = $user -> AddUser($index);
					if ($user_id > 0) {
						$data['user_id'] = $user_id;
						$data['username'] = $index['username'];
						$data['email'] = $index['email'];
						$data['webname'] = $_G['system']['con_webname'];

						$data['title'] = "注册邮件确认";
						$data['key'] = $_U['user_reg_key'];
						$data['msg'] = RegEmailMsg($data);
						$data['type'] = "reg";
						$result = $user -> SendEmail($data);
						$data['reg_step'] = "reg_email";
						// set_session($data);//注册session
						// 建议cookie
						// setcookie("user_id",$user_id,time()+60*60);
						// setcookie(Key2Url("user_id","DWCMS"),authcode($user_id.",".time(),"ENCODE"),time()+60*60);
						if (isset($_POST['cookietime']) && $_POST['cookietime'] > 0) {
							$ctime = time() + $_POST['cookietime'] * 60;
						} else {
							$ctime = time() + 60 * 30;
						}

						if ($_G['is_cookie'] == 1) {
							setcookie(Key2Url("user_id", "rdun"), authcode($user_id . "," . time(), "ENCODE"), $ctime);
						} else {
							$_SESSION[Key2Url("user_id", "rdun")] = authcode($user_id . "," . time(), "ENCODE");
							$_SESSION['login_endtime'] = $ctime;
						}
						$_SESSION['reg_step'] = "reg_email";
					}
				}
				$result = $user -> LoginUc($index);				
				//add by weego 20120625 for 账户锁定功能
				if($result['islock']==1){
					$_url = '/';
					$msg = array("该账户".$result['username']."已经被锁定","返回>>", $_url);
				}elseif($result['status']==0){
					$_url = '/';
					$msg = array("该账户".$result['username']."已经被关闭","返回>>", $_url);
					
				}else{
					$data['username'] = $result['username'];
					$data['user_id'] = $result['user_id'];
					$data['user_typeid'] = $result['type_id'];
					$data['reg_step'] = "";
					set_session($data); //注册session
					$_url = 'index.php?user';
					if (isset($_POST['cookietime']) && $_POST['cookietime'] > 0) {
						$ctime = time() + $_POST['cookietime'] * 600;
					} else {
						$ctime = time() + 60 * 60;
					}
					if ($_G['is_cookie'] == 1) {
						setcookie(Key2Url("user_id", "rdun"), authcode($data['user_id'] . "," . time(), "ENCODE"), $ctime);
					} else {
						$_SESSION[Key2Url("user_id", "rdun")] = authcode($data['user_id'] . "," . time(), "ENCODE");
						$_SESSION['login_endtime'] = $ctime;
					}
					//add by weego for 登录cookies验证 20120610
					setcookie('rdun', authcode($data['user_id'] . "," . time(), "ENCODE"), $ctime);
					setcookie('login_uid',$data['user_id'], $ctime);
					setcookie('login_endtime',$ctime, $ctime);

					$areaLoginMsg=$result['areaLoginMsg'];
					//$msg = array($ucsynlogin."登录成功<br/><font style=color:red>请确认您的上一次登录时间</font><br/><font style=color:red>{$areaLoginMsg}</font>","跳过进入用户中心>>", $_url);
					echo "<script>location.href='index.php?user';</script>";
				}
			} elseif ($uid == -1) {				
				$msg = array("用户不存在或密码错误", "", "?user&q=action/login&errror=" . $uid);
			} elseif ($uid == -2) {
				$msg = array("密码错误", "", "?user&q=action/login&errror=" . $uid);
			} else {
				$msg = array("未定义错误", "", "?user&q=action/login&errror=" . $uid);
			}
		}
	}
	$_U['login_msg'] = $login_msg;
}
$title = '用户登录';
$template = 'user_login.html.php';

?>