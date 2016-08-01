<?php
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
include_once("pioneer.class.php");

if ($_G['user_id']==""){

	$msg = array("你还没有登录，请先登录","会员登录","index.php?user&q=action/login");
}
if ($_U['query_type']=="add"){
	if ($_SESSION['valicode'] != $_POST['valicode']){
		$msg = array("验证码不正确",'','javascript:history.go(-1)');
	}else{
		$var = array("title",);
		$data = post_var($var);
		$data['applicant_name'] = $_POST['applicant_name'];
		$data['applicant_phone'] = $_POST['applicant_phone'];
		$_G['upimg']['file'] = "applicant_doc";
		$doc_result = $upload->upfile($_G['upimg']);
		if ($doc_result!=""){
			$data['doc_path'] = $doc_result['filename'];
		}
		$result = pioneerClass::Add($data);
		if ($result !== true){
			$msg = array($result);
		}else{
			$_SESSION['valicode'] = "";
			$msg = array("操作成功","","javascript:history.go(-1)");
		}
	}

}

$template = "user_msg.html.php";
?>
