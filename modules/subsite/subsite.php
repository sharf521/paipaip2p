<?
if (!defined('ROOT_PATH'))  die('不能访问');//防止直接访问
check_rank("area_list");//检查权限

include_once("subsite.class.php");

$_A['list_purview'] =  array("subsite"=>array("地区模块"=>array("subsite_list"=>"地区管理")));
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>分站列表</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>添加分站</a>";
$_A['list_table'] = "";


/**
 * 如果类型为空的话则显示所有的文件列表
 **/

if ($_A['query_type'] == "list" || $_A['query_type'] == "edit" ||  $_A['query_type'] == "new"){
	$_A['list_title'] = "分站点";
	$data['page'] = $_A['page'];
	$data['epage'] = 50;
	// 	$data['pid'] = "1711";
	// 	$data['subsite'] = "1";
	// 	if (isset($_REQUEST['action'])  ){
	// 			$_A['list_title'] = "城市";
	// 			$data['pid'] = $_REQUEST['pid'];
	// 		if ($_REQUEST['action'] =="city"){
	// 		}elseif ($_REQUEST['action'] =="area"){
	// 			$_A['list_title'] = "地区";
	// 			$data['pid'] = $_REQUEST['pid'];
	// 		}
	// 	}
	$result = subsiteClass::GetList($data);
	if (is_array($result)){
		$pages->set_data($result);
		$_A['area_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}

	if ((isset($_POST['website']) && $_POST['website']!="")){
		$var = array("order");
		$data = post_var($var);
		//liukun add for bug 261 begin
		//分站与地区无关，因此ID自动生成即可

		$data['id']= $_POST['id'];
		$data['province']= $_POST['province'];
		$data['city']= $_POST['city'];
		$data['area']= $_POST['area'];
		$data['subsite']= $_POST['subsite'];
		$data['website']= $_POST['website'];
		$data['template']= $_POST['template'];
		$data['sitename']= $_POST['sitename'];
		$data['siteicp']= $_POST['siteicp'];
		$data['sitecompany']= $_POST['sitecompany'];
		$data['sitecompanyno']= $_POST['sitecompanyno'];

		//$data['sitelogo']= $_POST['sitelogo'];

		$_G['upimg']['file'] = "sitelogo";
		//$_G['upimg']['mask_status'] = 0;
		$pic_result = $upload->upfile($_G['upimg']);
		if ($pic_result!=""){
			$data['sitelogo'] = $pic_result['filename'];
		}
		$data['siteaddr']= $_POST['siteaddr'];
		$data['sitetel']= $_POST['sitetel'];
		$data['sitepost']= $_POST['sitepost'];
		
		//liukun add for bug 261 end

		$data['sitetitle']= $_POST['sitetitle'];
		$data['sitekeywords']= $_POST['sitekeywords'];
		$data['sitedesc']= $_POST['sitedesc'];
		$data['mall_url']= $_POST['mall_url'];
		$data['jf_mall_url']= $_POST['jf_mall_url'];
		$data['only_show_sitebiao']= $_POST['only_show_sitebiao'];
		$allow_biaotype = "";
		
		$data['credit_biao_available']= $_POST['credit_biao_available'];
		if($data['credit_biao_available']==1){
			$allow_biaotype .= "credit".":";
		}
		$data['zhouzhuan_biao_available']= $_POST['zhouzhuan_biao_available'];
		if($data['zhouzhuan_biao_available']==1){
			$allow_biaotype .= "zhouzhuan".":";
		}
		$data['restructuring_biao_available']= $_POST['restructuring_biao_available'];
		if($data['restructuring_biao_available']==1){
			$allow_biaotype .= "restructuring".":";
		}
		$data['vouch_biao_available']= $_POST['vouch_biao_available'];
		if($data['vouch_biao_available']==1){
			$allow_biaotype .= "vouch".":";
		}
		$data['jin_biao_available']= $_POST['jin_biao_available'];
		if($data['jin_biao_available']==1){
			$allow_biaotype .= "jin".":";
		}
		$data['miao_biao_available']= $_POST['miao_biao_available'];
		if($data['miao_biao_available']==1){
			$allow_biaotype .= "miao".":";
		}
		$data['fast_biao_available']= $_POST['fast_biao_available'];
		if($data['fast_biao_available']==1){
			$allow_biaotype .= "fast".":";
		}
		$data['pledge_biao_available']= $_POST['pledge_biao_available'];
		if($data['pledge_biao_available']==1){
			$allow_biaotype .= "pledge".":";
		}
		$data['love_biao_available']= $_POST['love_biao_available'];
		if($data['love_biao_available']==1){
			$allow_biaotype .= "love".":";
		}
		$data['circulation_biao_available']= $_POST['circulation_biao_available'];
		if($data['circulation_biao_available']==1){
			$allow_biaotype .= "circulation".":";
		}
		
		$data['safety_biao_available']= $_POST['safety_biao_available'];
		if($data['safety_biao_available']==1){
			$allow_biaotype .= "safety".":";
		}
		
		$allow_biaotype = trim($allow_biaotype, ":");
		$data['allow_biaotype']= $allow_biaotype;
		
		
		$data['site_email_host']= $_POST['site_email_host'];
		$data['site_email_auth']= $_POST['site_email_auth'];
		$data['site_email']= $_POST['site_email'];
		$data['site_email_pwd']= $_POST['site_email_pwd'];

		$data['vip_award_type']= $_POST['vip_award_type'];
		
		$data['only_show_siteright']= $_POST['only_show_siteright'];
		$data['sms_available']= $_POST['sms_available'];
		
		$data['statistics_code']= ($_POST['statistics_code']);
		$data['qqgroup_code']= ($_POST['qqgroup_code']);
		$data['site_remark']= ($_POST['site_remark']);
		
		
		if ($_A['query_type'] == "edit"){
			
			$result = subsiteClass::Update($data);
	
		}else{
			$result = subsiteClass::Add($data);
		}
		if ($result !== true){
			$msg = array($result);
		}else{
			$msg = array("操作成功");
		}

		$user->add_log($_log,$result);//记录操作

	}else{
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$_A['subsite_result'] = subsiteClass::GetOne($data);
		}

	}
}

/**
 * 删除
 **/
elseif ($_A['query_type'] == "del"){
	$result = subsiteClass::Delete(array("id"=>$_REQUEST['id']));
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("删除成功");
	}


	$user->add_log($_log,$result);//记录操作
}




?>