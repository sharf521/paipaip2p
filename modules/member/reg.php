<?php
if (!defined('ROOT_PATH')) die('不能访问'); //防止直接访问
require_once ROOT_PATH . '/config_ucenter.php';
require_once ROOT_PATH . '/uc_client/client.php';

// if ($_G['user_id'] != "" && isset($_SESSION['step']) && $_SESSION['reg_step'] == "") {
// 	header('location:index.php?user');
// 	exit;
// } elseif (isset($_SESSION['reg_step']) && $_SESSION['reg_step'] == "reg_email") {
// 	header('location:index.php?user&q=action/reg_email');
// 	exit;
// } 
if (isset($_POST['email'])) {
	$var = array('email', 'username', 'sex', 'password', 'email', 'realname', 'invite_userid', 'type_id', 'phone', 'area', 'qq', 'card_type', 'card_id');
	$index = post_var($var);
	$varUserName = array('invite_username');
        $index2 =  post_var($varUserName);
        
        $index["invite_userid"] = $_SESSION["reginvite_user_id"];
        if($index["invite_userid"] == ""){
            $invite_username = $index2["invite_username"];
            $sql = "select user_id from {user} where `username`='{$invite_username}'";
            $result = $mysql->db_fetch_array($sql);
            $index["invite_userid"] = $result["user_id"];
        }
        
        
	$index["type_id"] = 2;
		if ($rdGlobal['uc_on'])
		{
			$uid = uc_user_register($index["username"], $index["password"], $index["email"]);
			if ($uid <= 0) {
				if ($uid == -1) {
					$msg = '用户名不合法';
				} elseif ($uid == -2) {
					$msg = '包含要允许注册的词语';
				} elseif ($uid == -3) {
					$msg = '用户名已经存在';
				} elseif ($uid == -4) {
					$msg = 'Email 格式有误';
				} elseif ($uid == -5) {
					$msg = 'Email 不允许注册';
				} elseif ($uid == -6) {
					$msg = '该 Email 已经被注册';
				} else {
					$msg = '未定义';
				} 
			} 
			if ($msg){
				echo "<script>alert('$msg');location.href='index.php?user&q=action/reg';</script>";
				exit();
			}
			$ucsynlogin = uc_user_synlogin($uid);
			//echo $ucsynlogin;
		}
	//保存uc user id
	$index['uc_user_id'] = $uid;
	
	//liukun add for 哪个分站注册的，就是哪个分站的用户
	$index['areaid'] = $_G['areaid'];
	$user_id = $user -> AddUser($index);

	if ($user_id > 0) {
		$data['user_id'] = $user_id;
		$data['username'] = $index['username'];
		$data['email'] = $index['email'];
		$data['webname'] = $_G['system']['con_webname'];
		$data['title'] = $data['webname']."注册邮件确认";
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
			$ctime = time() + 60 * 60;
		} 

		if ($_G['is_cookie'] == 1) {
			setcookie(Key2Url("user_id", "DWCMS"), authcode($user_id . "," . time(), "ENCODE"), $ctime);
		} else {
			$_SESSION[Key2Url("user_id", "DWCMS")] = authcode($user_id . "," . time(), "ENCODE");
			$_SESSION['login_endtime'] = $ctime;
		} 
		$_SESSION['reg_step'] = "reg_email";
		echo "<script>alert('注册成功');location.href='index.php?user&q=action/reg_email';</script>";
	} else {
		header('location:index.php?user&q=action/reg');
	} 
} else {
	$title = '用户注册';
	$template = 'user_reg_info.html.php';
} 

?>