<?
header("X-Powered-By:JAVA");
session_cache_limiter('private,must-revalidate');

$_G = array();
//���������ļ�
include ("core/config.inc.php");

include_once (ROOT_PATH."core/encrypt.php");

//ϵͳ������Ϣ
$system = array();
$system_name = array();
$_system = $mysql->db_selects("system");
foreach ($_system as $key => $value){
	$system[$value['nid']] = $value['value'];
	$system_name[$value['nid']] = $value['name'];
}
$_G['system'] = $system;
$_G['system_name'] = $system_name;

//liukun add for bug 304 begin
$biao_type = array();
$_biao_type_list = $mysql->db_selects("biao_type");
foreach ($_biao_type_list as $_biao_value){
	foreach ($_biao_value as $key => $value){
		$biao_type[$_biao_value['biao_type_name']][$key] = $value;
	}
}
$_G['biao_type'] = $biao_type;
//liukun add for bug 304 end

$_G['nowtime'] = time();//���ڵ�ʱ��

$_G['weburl'] = "http://".$_SERVER['SERVER_NAME'];//��ǰ������







//�жϲ��ú��ַ�ʽ��¼
$_user_id = array("");
$_G['user_id']=''; //��ʼ����ǰ��¼���û�id
$_G['is_cookie'] = isset($_G['system']['con_cookie'])?(int)$_G['system']['con_cookie']:0;
/*
if ($_G['is_cookie'] ==1){
	$_user_id = explode(",",authcode(isset($_COOKIE['rdun'])?$_COOKIE['rdun']:"","DECODE"));
}else{
	if (isset($_SESSION['login_endtime']) && $_SESSION['login_endtime']>time()){
		$_user_id = explode(",",authcode(isset($_SESSION[Key2Url("user_id","rdun")])?$_SESSION[Key2Url("user_id","rdun")]:"","DECODE"));
	}
}
*/
/*$_user_id = explode(",",authcode(isset($_COOKIE['rdun'])?$_COOKIE['rdun']:"","DECODE"));
//��¼cookies+session��֤ add by weego for �쳣��¼ 20120610 begin
$check_uid=$_COOKIE['login_uid'];
if($check_uid == $_user_id[0]){
	$_G['user_id'] = $_user_id[0];	
}*/
	
//��¼cookies+session��֤ add by weego for �쳣��¼ 20120610 end

$_user_id= explode(",",authcode(isset($_SESSION[Key2Url("user_id","rdun")])?$_SESSION[Key2Url("user_id","rdun")]:"","DECODE"));
$_G['user_id'] = $_user_id[0];	

if ($_G['user_id']!=""){
	$_G['user_result'] = $user->GetOne(array("user_id"=>$_G['user_id']));
	$_G['user_cache'] = $user->GetUserCache(array("user_id"=>$_G['user_id']));
	$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234567890";
	$e_uc_user_id = DeCode($_G['user_result']['uc_user_id'],'E',$con_mall_key);
	$_G['e_uc_user_id'] = urlencode($e_uc_user_id);
	//��ȡ�û�������֤��Ϣ
	$user_audit_result = $user->GetCreditAudit(array("user_id"=>$_G['user_id']));
	$_G['user_result']['credit_status'] = $user_audit_result['status'];
	
}

$query_string = explode("&",$_SERVER['QUERY_STRING']);
$_G['query_string'] = $query_string;



if (isset($_REQUEST['query_site']) && $_REQUEST['query_site']!=""){
	$_G['query_site'] = $_REQUEST['query_site'];
}elseif (isset($query_string[0])){
	$_G['query_site'] = $query_string[0];
}

//ģ�飬��ҳ��ÿҳ��ʾ����
$_G['page'] = isset($_REQUEST['page'])?$_REQUEST['page']:1;//��ҳ
$_G['epage'] = isset($_REQUEST['epage'])?$_REQUEST['epage']:10;//��ҳ��ÿһҳ

$_G['nowurl'] = "http//".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

//�����վ�Ļ���
//$_G['cache'] = systemClass::GetCacheOne();

//������ߵ��û�
//$_G['online'] = systemClass::Online(array("user_id"=>$_G['user_id']));

//VIP��
$_G['con_vip_money'] = isset($_G['system']['con_vip_money'])?$_G['system']['con_vip_money']:"340";
//ģ��ѡ��
//liukun add for ��������ѡ��ģ�� begin
$website = $_SERVER['SERVER_NAME'];
//$website='localhost';
//$_template = $mysql->db_selects("subsite", "website like '%{$website}%'");
$value=$mysql->db_fetch_array("select * from {subsite} where website like '%{$website}%' limit 1");
//foreach ($_template as $key => $value){
if($value){
	$_template_name=$value['template'];
	$_subsite_available = $value['subsite'];
	$_areaid = $value['id'];
	$_areaname = $value['name'];
	$_sitename = $value['sitename'];
	$_siteicp = $value['siteicp'];
	$_sitelogo = $value['sitelogo'];
	$_siteaddr = $value['siteaddr'];
	$_sitetel = $value['sitetel'];
	$_sitepost = $value['sitepost'];
	$_site_biaotype = $value['allow_biaotype'];
	$_sitetitle = $value['sitetitle'];
	$_sitekeywords = $value['sitekeywords'];
	$_sitedesc = $value['sitedesc'];
	$_mall_url = $value['mall_url'];
	$_jf_mall_url = $value['jf_mall_url'];
	$_province = $value['province'];
	$_city = $value['city'];
	$_area = $value['area'];
	
	$_site_email_host = $value['site_email_host'];
	$_site_email_auth = $value['site_email_auth'];
	$_site_email = $value['site_email'];
	$_site_email_pwd = $value['site_email_pwd'];
	
	$_sms_available = $value['sms_available'];
	
	$_statistics_code = $value['statistics_code'];
	$_qqgroup_code = $value['qqgroup_code'];
	$_sitecompany = $value['sitecompany'];
	$_sitecompanyno = $value['sitecompanyno'];
	$_site_remark = $value['site_remark'];
	
	$_G['only_show_sitebiao']=$value['only_show_sitebiao'];
}
//ȷ������
if (isset($_areaid) && $_subsite_available == 1){
	$_G['areaid'] = $_areaid;
	$_G['areaname'] = $_areaname;
	$_G['sitename'] = $_sitename;
	$_G['siteicp'] = $_siteicp;
	$_G['sitelogo'] = $_sitelogo;
	$_G['siteaddr'] = $_siteaddr;
	$_G['sitetel'] = $_sitetel;
	$_G['sitepost'] = $_sitepost;
	$_G['site_biaotype'] = $_site_biaotype;
	$_G['sitetitle'] = $_sitetitle;
	$_G['sitekeywords'] = $_sitekeywords;
	$_G['sitedesc'] = $_sitedesc;
	$_G['mall_url'] = $_mall_url;
	$_G['jf_mall_url'] = $_jf_mall_url;
	$_G['province'] = $_province;
	$_G['city'] = $_city;
	$_G['area'] = $_area;
	$_G['site_email_host'] = $_site_email_host;
	$_G['site_email_auth'] = $_site_email_auth;
	$_G['site_email'] = $_site_email;
	$_G['site_email_pwd'] = $_site_email_pwd;
	$_G['sms_available'] = $_sms_available;
	$_G['statistics_code'] = ($_statistics_code);
	$_G['qqgroup_code'] = ($_qqgroup_code);
	$_G['sitecompany'] =$_sitecompany;
	$_G['sitecompanyno'] =$_sitecompanyno;
	$_G['site_remark'] =$_site_remark;
	
	$_G['system']['con_webname'] = $_G['sitename'];
	
	$_G['system']['con_email_host'] = $_G['site_email_host'];
	$_G['system']['con_email_auth'] = $_G['site_email_auth'];
	$_G['system']['con_email_email'] = $_G['site_email'];
	$_G['system']['con_email_pwd'] = $_G['site_email_pwd'];
	$_G['system']['con_email_from'] = $_G['site_email'];

}
else{
	echo "վ�㵱ǰ���ɷ��ʣ�";
	exit;
}
if(isset($_REQUEST['sub']))
{
	$_arr_sub=explode('|',$_REQUEST['sub']);
	if (file_exists("data/city/{$_arr_sub[0]}/{$_arr_sub[1]}.jpg"))
	{
		$_G['sitelogo']="data/city/{$_arr_sub[0]}/{$_arr_sub[1]}.jpg";
	}
}


$con_template = "themes/";
if (isset($_template_name)  && ($_template_name!="")){
	$con_template .= $_template_name;
	$_G['con_template_name']=$_template_name;
}else{
	$con_template .= empty($system['con_template'])?"default":$system['con_template'];
	$_G['con_template_name']=$system['con_template'];
}

//liukun add for ��������ѡ��ģ�� begin

$template_error = false;
if (!file_exists($con_template)){
	$template_error = true;
	$con_template = "themes/default";
	$magic->template_error = $template_error;
}

$magic->template_dir = $con_template;
$magic->template_name = $_template_name;

$magic->compile_dir='./data/compile/'.$_template_name;
$magic->template_name = '';

$magic->force_compile = false;
$_G['tpldir'] = "/".$con_template;



$magic->assign("tpldir",$_G['tpldir']);
$magic->assign("tempdir",$_G['tpldir']);//ͼƬ��ַ



//����ģ��
include_once ("modules/linkage/linkage.class.php");
if (linkageClass::IsInstall()){
	$result = linkageClass::GetList(array("limit"=>"all"));
	foreach ($result as $key => $value){
		$_G['linkage'][$value['type_nid']][$value['value']] = $value['name'];
		$_G['linkage'][$value['id']] = $value['name'];
		if ($value['type_nid']!=""){
			$_G['_linkage'][$value['type_nid']][$value['id']] = array("name"=>$value['name'],"id"=>$value['id'],"value"=>$value['value']);
		}
	}
}

include_once (ROOT_PATH."modules/area/area.class.php");
$result = areaClass::GetList(array("limit"=>"all"));
$_G['arealist'] = $result;

/*//�����б�
if (file_exists(ROOT_PATH."modules/area/area.class.php")){
	include_once (ROOT_PATH."modules/area/area.class.php");
	//����Ѿ���װ����ģ�飬���ȡ��������Ϣ
	if (areaClass::IsInstall()){
		$result = areaClass::GetList(array("limit"=>"all"));
		$_G['arealist'] = $result;
	}
	//�����վ�ǲ��ö������������ģ��������ص�����
	if (isset($_G['system']['con_area_part']) && $_G['system']['con_area_part']==1){
		$city_area = explode(".",$_SERVER['SERVER_NAME']);
		$area_city_nid = $city_area[0] ; 
		
		//�����վ������
		if (count($city_area)==2){
			$domain = $_SERVER['SERVER_NAME'];
		}else{
			$domain = $city_area[1].".".$city_area[2];
		}
		$_G['domain'] = $domain;//��վ������
		$_G['webname'] = "http://".$area_city_nid.".".$domain;//��ǰ������
			
		//��ʾ���е��б�
		if ($area_city_nid =="city"){
			$magic->assign("_G",$_G);
			$tpl = "city.html";
			$magic->display($tpl);
			exit;
		}
		
		//�����ĵ�����ת
		elseif ($area_city_nid =="www" || count($city_area)==2){
			if (isset($_REQUEST['set_city_nid'])){
				setcookie("set_city",$_REQUEST['set_city_nid'],time()+3600*24*30);
				exit;
			}
			if (isset($_COOKIE['set_city'])){
				$url = "http://".$_COOKIE['set_city'].".".$_G['domain'];//��cookie��ַ
				echo "<script>location.href='$url';</script>";
				exit;
			}
			echo "<script>location.href='http://city.{$_G['domain']}';</script>";
			exit;
			
			
		}
		
		else{
		
			//ѭ��Ѱ����صĳ�����Ϣ
			foreach ($_G['arealist'] as $key => $value){
				if ($value['nid']==$area_city_nid){
					//���еĻ�����Ϣ
					$_G['city_result'] = $_G['arealist'][$key];
				}
			}	
			//ѭ��Ѱ����صĵ�����Ϣ
			foreach ($_G['arealist'] as $key => $value){
				//ʡ�ݵĻ�����Ϣ
				if ($value['id']==$_G['city_result']['pid']){
					$_G['province_result'] = $_G['arealist'][$key];
				}
				//���ڳ��е����б�
				if ($value['pid']==$_G['city_result']['id']){
					$_G['area_list'][] = $value;
				}
				//�����Ļ�����Ϣ
				if (isset($_REQUEST['area']) && $_REQUEST['area'] == $value['nid']){
					$_G['area_result'] = $value;
				}
			}	
			
			//�ж��ǲ��ǳ��е���Ϣ��������ǣ��򷵻س���ҳ����ѡ��
			if ($_G['province_result']['pid']!=0 || !isset($_G['city_result'])){
				unset($_COOKIE['set_city']);
				echo "<script>location.href='http://city.{$domain}';</script>";
				exit;
			}
			
		
		}
		
	}
}*/

//վ���б�
if (file_exists(ROOT_PATH."core/site.class.php")){
	include_once (ROOT_PATH."core/site.class.php");
	$_G['site_list'] = siteClass::GetList(array("limit"=>"all"));
	if ($_G['site_list']!=false){
		foreach ($_G['site_list'] as $key => $value){
			if ($value['rank']!=""){
				$_pur = explode(",",$value['rank']);
				if (isset($_G['user_result']['type_id']) && in_array($_G['user_result']['type_id'],$_pur)){
					$_G['site_list_pur'][$key] = $value; 
				}
			}
		}
	}
}

//�ϴ�ͼƬ������
$_G['upimg']['cut_status'] = 0;
$_G['upimg']['user_id'] = empty($_G['user_id'])?0:$_G['user_id'];
$_G['upimg']['cut_type'] = 2;
$_G['upimg']['cut_width'] = isset($_G['system']['con_fujian_imgwidth'])?$_G['system']['con_fujian_imgwidth']:"";
$_G['upimg']['cut_height'] = isset($_G['system']['con_fujian_imgheight'])?$_G['system']['con_fujian_imgheight']:"";
//$_G['upimg']['file_dir'] = "data/aa/";
$_G['upimg']['file_size'] = 1000;
$_G['upimg']['mask_status'] = isset($_G['system']['con_watermark_pic'])?$_G['system']['con_watermark_pic']:"";
$_G['upimg']['mask_position'] = isset($_G['system']['con_watermark_position'])?$_G['system']['con_watermark_position']:"";
if (isset($_G['system']['con_watermark_type']) && $_G['system']['con_watermark_type']==1){
	$_G['upimg']['mask_word'] =isset($_G['system']['con_watermark_word'])?$_G['system']['con_watermark_word']:"";
	$_G['upimg']['mask_font'] = "3";
	//$_G['upimg']['mask_size'] = $_G['system']['con_watermark_font'];
	$_G['upimg']['mask_color'] = isset($_G['system']['con_watermark_color'])?$_G['system']['con_watermark_color']:"";
}else{
	$_G['upimg']['mask_img'] = isset($_G['system']['con_watermark_file'])?$_G['system']['con_watermark_file']:"";
}

if ($_G['query_site'] == "user" ){
	$_G['site_result']['nid'] = "user";
}

$magic->assign("_G",$_G);
//�����ַ
if (isset($_G['system']['con_houtai']) && $_G['system']['con_houtai']!=""){
	$admin_name = $_G['system']['con_houtai'];
}else{
	$admin_name = "admin";
}

if ($_G['query_site'] == $admin_name ){
	include_once ("modules/admin/index.php");
	exit;
}

//add by weego for �ڶܰ�ȫ��� 20120606
$hackManArray=array('epage','keywords','code','type','area');
foreach($hackManArray as $hackKey){
	$_REQUEST[$hackKey] = urldecode($_REQUEST[$hackKey]);
	$_REQUEST[$hackKey]=htmlgl($_REQUEST[$hackKey],'1');
	$_REQUEST[$hackKey]=safegl($_REQUEST[$hackKey]);
}
//add by weego for �ڶܰ�ȫ��� 20120606

//�û�����
if ($_G['query_site'] == "user" ){
	//liukun add for bug 473 begin
// 	include_once ("modules/member/index_soonmes.php");exit;
	include_once ("modules/member/index.php");exit;
	//liukun add for bug 473 end
}
elseif($_G['query_site']=="login_myother")//
{
	$user_id = $_G['user_id'];
	if(empty($user_id))
	{
		if($_GET['t']=='m')
			$url=$_G['mall_url'];	
		elseif($_GET['t']=='f')
			$url=$_G['jf_mall_url'];
	}
	else
	{
		$con_mall_key = isset($_G['system']['con_mall_key'])?$_G['system']['con_mall_key']:"1234567890";
		$e_uc_user_id = DeCode($_G['user_result']['uc_user_id'],'E',$con_mall_key);
		$e_uc_user_id = urlencode($e_uc_user_id);
		if($_GET['t']=='m')
			$url=$_G['mall_url'].$_G['system']['con_mall_login_url'].$e_uc_user_id;
		elseif($_GET['t']=='f')
			$url=$_G['jf_mall_url'].$_G['system']['con_mall_login_url'].$e_uc_user_id;
	}
	header("location:http://$url");
	exit;
}

//�û�����
elseif ($_G['query_site'] == "home" ){
	$user_id = $_REQUEST['user_id'];
	$user->AddVisit(array("user_id"=>$user_id,"visit_userid"=>$_G['user_id']));
	$magic->display("home.html");
	exit;
}

//��ҳ
elseif ($_G['query_site'] == "cxbz" ){
	$magic->display("cxbz/bjbz/cxbz1.html");
	exit;
}

//�û�������
elseif ($_G['query_site'] == "u" ){
	include_once(ROOT_PATH."modules/borrow/borrow.class.php");
	$Bclass = new borrowClass();
	$_G['U_uid'] = $user_id = $_G['query_string'][1];
	
	if(isset($_G['query_string'][2])){
		$_G['query_string'][2]=str_replace("/",'',$_G['query_string'][2]);
		if($_G['query_string'][2]=='borrowlist'||$_G['query_string'][2]=='borrowinvest') $U_gid=$_G['query_string'][2];
		else $U_gid='';
	}
	
	$magic->assign("U_gid",$U_gid);
	$magic->assign("GU_uid",$_G['U_uid']);
	$magic->display("u.html");
	exit;
}
//����
elseif ($_G['query_site'] == "comment" ){
	include_once ("modules/comment/comment.inc.php");exit;
}
//����
elseif ($_G['query_site'] == "plugins" ){
	$q = !isset($_REQUEST['q'])?"":$_REQUEST['q'];
	$_ac = !isset($_REQUEST['ac'])?"html":$_REQUEST['ac'];
	if ($_ac=="html"){
		$file = ROOT_PATH."plugins/html/".$q.".inc.php";
	}else{
		$file = ROOT_PATH."plugins/{$_ac}/{$_ac}.php";
	}
	if (file_exists($file)){
		include_once ($file);exit;
	}
}
 

 
/**
 * �鿴��ݱ���Ϣ
**/
elseif ($_REQUEST['q'] == "viewfast"){
	$id = (int)$_REQUEST['id'];
	if(empty($id)) exit("��������");
	$sql = "select * from {daizi} where id = {$id} limit 1";
	$result = $mysql->db_fetch_array($sql);
	$magic->assign("viewfast",$result);
	$magic->display("fast_view.html");
}


else{	

		/**
		* �ر���վ
		**/
		if ($_G['system']['con_webopen']==1){
			die($_G['system']['con_closemsg']);
		}
		
		
		//���վ������µ���Ϣ
		$quer = explode("/",$query_string[0]);	
		if (isset($_REQUEST['query_site']) && $_REQUEST['query_site']!=""){
			$site_nid =$_REQUEST['query_site'];
		}else{
			$site_nid = isset($quer[0])?$quer[0]:"";
		}
		$article_id = isset($quer[1])?$quer[1]:"";
		$content_page = isset($quer[2])?$quer[2]:"";//���ݵķ�ҳ
		
		
		$_G['article_id'] = $article_id;
		//���վ�����Ϣ
		$_G['site_result'] = "";
		if (isset($_G['site_list']) && $_G['site_list']!=""){
			foreach ($_G['site_list'] as $key => $value){
				if ($value['nid'] == $site_nid){
					$_G['site_result'] = $value;
				}
			}
		}
		
		//ģ����Ϣ
		$_G['module_result'] = "";
		if (file_exists(ROOT_PATH."core/module.class.php")){
			include_once (ROOT_PATH."core/module.class.php");
			if (isset($_G['site_result']['code'])){
				$_G['module_result']  = moduleClass::GetOne(array("code"=>$_G['site_result']['code']));
			}
		}


		//�ж�վ���Ƿ����
		if (!empty($_G['site_result'])){		
			//�����վ�����Ϣ
			foreach ($_G['site_list'] as $key => $value){
				if ($value['pid'] == $_G['site_result']['site_id']){
					if ($value['status']==1){
						$_G['site_sub_list'][] = $value;//��վ���б�
					}
				}
				if ($value['site_id'] == $_G['site_result']['pid']){
					$_G['site_presult'] = $value;//��վ��
				}
				if ($value['pid'] == $_G['site_result']['pid']){
					if ($value['status']==1){
						$_G['site_brother_list'][] = $value;//ͬ��վ���б�
					}
				}
			}			
			if (isset($_G['site_presult']) && $_G['site_presult']['pid']!=0){
				foreach ($_G['site_list'] as $key => $value){
					if ($value['site_id'] == $_G['site_presult']['pid']){
						$_G['site_mresult'] = $value;//��վ��
					}
				}
			}
			//��������
			if ($article_id!="" && is_numeric($article_id)){
				$code = $_G['site_result']['code'];
				$codeclass = $code."Class";
				if (file_exists(ROOT_PATH."modules/{$code}/{$code}.class.php")){
					include_once(ROOT_PATH."modules/{$code}/{$code}.class.php");
					$class = new $codeclass();
					$result = $class->GetOne(array("id"=>$article_id,"click"=>true));					
					if($result['areaid'] != $_G['areaid'] && $result['site_id']!=71)
					{
						$result['name']='';
						$result['content']='';
					}
					$_G['article'] = $result;	
					$_G['sitetitle']=$result['name'].'-'.$_G['sitetitle'];
				}			
				if (count($_G['article']) <= 0){
					$template = "error.html";
				}else{
					$template = $_G['site_result']['content_tpl'];
				}
			}			
			//�����б�
			else{
				if ($_G['site_result']['pid']==0){
					$template = $_G['site_result']['index_tpl'];
				}else{
					$template = $_G['site_result']['list_tpl'];
				}
				$_G['sitetitle']=$_G['site_result']['name'].'-'.$_G['sitetitle'];
				
			}			
		}else{
			//var_dump($site_nid);exit;
			if ($site_nid==""){
			// Ĭ����ҳ��ģ���ļ�
				$template = !isset($_G['system']['con_index_tpl'])?"index.html":$_G['system']['con_index_tpl'];
			}else{
				$msg = array("������������,�Ҳ�����Ӧ��ҳ��","<a href='/'>������ҳ</a>");
			}
		}
		if (isset($msg) && $msg!=""){
			$_G['msg'] = $msg;
			$template = "error.html";
		}
		/* alpha add for bug 94 begin*/
		if(isset($_REQUEST['type'])) $biao_type = $_REQUEST['type'];
		/* alpha add for bug 94 end*/
		
		if($_REQUEST['type']=="miao") $miaobiao = true ;
		if($_REQUEST['type']=="credit") $creditbiao = true ;		
		if($_REQUEST['type']=="vouch") $vouchbiao = true ;
		if($_REQUEST['type']=="zhouzhuan") $zhouzhuanbiao = true ;
		
// 		if($_REQUEST['type']=='fast' || $_REQUEST['type']=='pledge'){
// 			if(($_G['user_result']['real_status'] == 1&&$_G['user_result']['scene_status'] == 1) ||($_G['user_result']['real_status'] == 1&&$_G['user_result']['video_status'] ==1)){}		else{
/* 				echo '<script>alert("�Բ�������ͨ��ʵ����֤,���ֳ���֤������Ƶ��֤");</script>';
// 				echo '<script>window.location.href="/index.php?user&q=code/user/video_status";</script>';*/
// 				exit;
// 			}
// 			$fastbiao = true;
// 		}
		if($_REQUEST['type']=='fast'){
			$fastbiao = true;
		}
        if($_REQUEST['type']=='jin'){
            $jinbiao = true;
        }
        if($_REQUEST['type']=='restructuring'){
            $restructuringbiao = true;
        }
        if($_REQUEST['type']=='circulation'){
        	$circulationbiao = true;
        }
        if($_REQUEST['type']=='love'){
        	$lovebiao = true;
        }
        if($_REQUEST['type']=='pledge'){
        	$pledgebiao = true;
        }
		
		$_G['st']=(int)$_REQUEST['st'];
		
		$magic->assign("_G",$_G);
		$magic->assign("biao_type",$biao_type);
		
		$magic->assign("miaobiao",$miaobiao);
        $magic->assign("jinbiao",$jinbiao);
		$magic->assign("zhouzhuanbiao",$zhouzhuanbiao);
		$magic->assign("fastbiao",$fastbiao);
		$magic->assign("restructuringbiao",$restructuringbiao);
		$magic->assign("circulationbiao",$circulationbiao);
		$magic->assign("creditbiao",$creditbiao);
		$magic->assign("vouchbiao",$vouchbiao);
		$magic->assign("lovebiao",$lovebiao);
		$magic->assign("pledgebiao",$pledgebiao);
		
		// ����û�û�е�¼����ת��
		// ������ﲻ������������û������ܻ������������õĴ���
		//�����䲻�õ�¼
		//echo $biao_type;
		if ($_G['user_id'] == "" && isset($biao_type) && $biao_type!=""){
			if($_REQUEST['type'] != 'success' && $_REQUEST['type'] != 'progress' && $_G['site_result']['nid'] !='lixi')
			{
				header('location:/index.action?user&q=action/login');
				exit;	
			}
		}
        
		if (isset($_G['site_result']['code']) && $_G['site_result']['code']!=""){
			$magic->display(format_tpl($template,array("code"=>$_G['site_result']['code'])));
		}else{
			$magic->display($template);
		}
		
		
		
/*		require_once('core/cache.class.php');
		$cache = new cache();
		$cache->set_dir(ROOT_PATH.'data/cache_dir/');
		$data=$cache->read('linkpage',0);
		if(empty($data))
		{
			//$data=array('aa'=>1111,'bb'=>2222,'date'=>date('Y-m-d H:i:s'));
			$data=$_G['linkage'];
			$cache->write('linkage',$data);	
		}
		print_r($data);*/
		//echo $template;
		
//echo   date("Y-m-d",strtotime("+1months",strtotime("2011-08-01")));



		exit;		
}
?>