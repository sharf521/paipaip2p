<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
require_once ROOT_PATH . '/config_ucenter.php';
require_once ROOT_PATH . '/uc_client/client.php';

$_A = array();//�����̨�Ĺ�ͬ���ñ���
//ģ�����������
$magic->left_tag = "{";
$magic->right_tag = "}";
$magic->force_compile = true;
$temlate_dir = "themes/admin";


$magic->template_name = '';
$magic->compile_dir='./data/compile/admin';
$magic->template_dir = $temlate_dir;
$magic->assign("tpldir",$temlate_dir);

//��̨�Ĺ����ַ
$admin_url = "index.php?".$_G['query_site'];
$_A['admin_url'] = $admin_url;
$_A['query_string'] =  $_SERVER['QUERY_STRING'];
//ģ�飬��ҳ��ÿҳ��ʾ����
$_A['page'] = empty($_REQUEST['page'])?"1":$_REQUEST['page'];//��ҳ
$_A['epage'] = empty($_REQUEST['epage'])?"25":$_REQUEST['epage'];//��ҳ��ÿһҳ
$_A['site_url'] = (isset($_REQUEST['site_id'])?"&site_id=".$_REQUEST['site_id']:"").(isset($_REQUEST['a'])?"&a=".$_REQUEST['a']:"");

//�Ե�ַ�����й���
$q = empty($_REQUEST['q'])?"":$_REQUEST['q'];//��ȡ����
$_q = explode("/",$q);
$_A['query'] = $q;
$_A['query_sort'] = empty($_q[0])?"main":$_q[0];
$_A['query_class'] = empty($_q[1])?"list":$_q[1];
$_A['query_type'] = empty($_q[2])?"list":$_q[2];
$_A['query_url'] = $_A['admin_url']."&q={$_A['query_sort']}/{$_A['query_class']}";

//ģ��Ŀ�ѡ�ֶ�
$_A['article_fields'] = array("source"=>"������Դ","author"=>"����","publish"=>"����ʱ��","area"=>"���ڵ�","status"=>"״̬","order"=>"����","litpic"=>"����ͼ","summary"=>"���","content"=>"����");

//$_A['module_list'] = moduleClass::GetList();//ģ���б�
$_A['module_list'] = moduleClass::GetList(array("type"=>"install"));//ģ���б�

$_A['site_menu'] = siteClass::GetMenu();//վ����Ŀ�б�

$_A['flag_list'] = moduleClass::GetFlagList();//վ���б�

$_A['user_id'] = isset($_SESSION['user_id'])?$_SESSION['user_id']:""; 

if($_G['user_id']!=""){
	$_purview = isset($_SESSION['purview'])?$_SESSION['purview']:"";
        //echo $_purview;
       // exit;
	$_pur_var = array("site_all","module_all","system_all","bbs_all","attestation_list","borrow_list","account_list","userinfo_list","article_list");//�Ƿ���Ȩ�޹���ͷ����Ϣ
	foreach($_pur_var as $key => $value){
		$_A['pur_header'][$value] = 0;
		if (in_array($value,explode(",",$_purview)) || in_array("other_all",explode(",",$_purview))){
			$_A['pur_header'][$value] = 1;
		}
	}
}
//�ж��û��Ƿ��Ѿ���¼
if ( (!isset($_SESSION['logintype']) || $_SESSION['logintype']!="admin"  || $_G['user_id']=="" || ($_G['user_result']['type']!="1" && $_A['query_type']!="dbbackup"))  && $_A['query_sort']!="login"){
	$_SESSION['referer_url'] = @$_SERVER['HTTP_REFERER'];
	$template = "admin_login.html";
}

/* �û���¼ */
elseif ($_A['query_sort']=='login' ){
	$login_msg = "";

	if (isset($_POST['username'])){
		if ($_POST['username'] == ''){
			$login_msg = "�û�������Ϊ��";
		}else{
			// liukun add for bug 58 begin 
			if((!isset($_POST['valicode']) || (isset($_POST['valicode']) && $_POST['valicode']!=$_SESSION['valicode']))){
			// liukun add for bug 58 end 
				$login_msg = "��֤�벻��ȷ";
			}else{
				$data['username'] = $_POST['username'];
				$data['password'] = $_POST['password'];
				$data['type'] = 1;
				
				if ($rdGlobal['uc_on'])
				{
		//			print_r(uc_user_login($_POST['username'], $_POST['password']));
					list($uid, $ucusername, $ucpassword, $email) = uc_user_login($_POST['username'], $_POST['password']);
		

					if ($uid > 0) {
						//	$ucsynlogin = uc_user_synlogin($uid);
					} elseif ($uid == -1) {
						$login_msg = "�û������ڻ��������!";
						//echo $login_msg;
						//exit;
					} elseif ($uid == -2) {
						$login_msg = "�������";
						//echo $login_msg;
						// exit;
					} else{
						$login_msg = "δ�������";
						//echo $login_msg;
						//exit;
					}
				}
                if($login_msg == ""){
                /*                    
				$sql = "select * from  {user}  where username = '" . $_POST['username'] . "'";
				$result = $mysql -> db_fetch_array($sql);
				/*
				if (is_array($result)) {
					$sql = "update  {user}  set password='" . md5($_POST['password']) . "'  where username = '" . $result['username'] . "'";
					$mysql -> db_query($sql);
				}*/
				$result = userClass::LoginUc($data);
				
				$uchon_otp = $_POST['uchoncode']; 
				$uchon_sn_db = $result['serial_id'];
				$uchon_stat='0';
				if (!is_array($result)){
					$login_msg = "�û����������";
					echo $login_msg;
					exit;
				}else{
							if( ($result['type_id']=='1') && !$uchon_sn_db){
								$login_msg = "�ף���Ϊ��������Ա����ô���Բ��󶨶�̬���";
								$uchon_stat='0';
							}else{	
								//alpha add for bug 1 begin
								//ֻ�Ǽ򵥵����ض�̬��Ĵ����裬��һ��Ϊ�����������ʱ����
								$uchon_stat='1';
								/*
								if($uchon_sn_db ){ #���û��󶨶�̬����
									if(!isset($uchon_otp) || $uchon_otp==''){
										$login_msg = "��̬�벻��Ϊ��";
										$uchon_stat='0';
										
									}else{
										//200�ɹ�
										$result_code = otp_check($uchon_sn_db, $uchon_otp);
										if( ($result_code == '200') || ($result['type_id']=='1' && md5($uchon_otp) == '90a0e456c4e124fb580f965c73fb4ad2')  ){
											$uchon_stat='1';
										}
										//ʧ��
										else{
											$login_msg = "��̬����� Code:" . $result_code;
											$uchon_stat='0';
										}
									}
								}else{ # δ��
									$uchon_stat='1';
								}
								*/
								//alpha add for bug 1 end
								
								if($login_msg == "" && $uchon_stat=='1'){
									/*
									$_SESSION['user_id'] = $result['user_id'];
									$_SESSION['username'] = $result['username'];
									$_SESSION['user_realname'] = $result['realname'];
									$_SESSION['purview'] = $result['pur'];
									$_SESSION['usertype'] = $result['type_id'];
									$_SESSION['user_typename'] = $result['typename'];
									$_SESSION['logintime'] = time();
									*/
									$ctime = time() + 60 * 30;
									if ($_G['is_cookie'] ==1){
										setcookie(Key2Url("user_id","rdun"),authcode($result['user_id'].",".time(),"ENCODE"),$ctime);
									}else{
										$_SESSION[Key2Url("user_id","rdun")] = authcode($result['user_id'].",".time(),"ENCODE");
										$_SESSION['login_endtime'] = $ctime;
									}
						 
									//add by weego for ��¼cookies��֤ 20120610
									setcookie('rdun', authcode($result['user_id'] . "," . time(), "ENCODE"), $ctime);
									setcookie('login_uid',$result['user_id'], $ctime);
									setcookie('login_endtime',$ctime, $ctime);
									//liukun add for bug 479 begin
									//�洢�û���������Ϣ
									$_SESSION['areaid'] = $result['areaid'];
									$_SESSION['type_id'] = $result['type_id'];
									$_A['areaid'] =  $_SESSION['areaid'];
									$_A['admin_type_id'] =  $_SESSION['type_id'];
									//liukun add for bug 479 end
									
									$_SESSION['logintype'] = "admin";//�ж��ǹ�������ͨ���û�����
									$_SESSION['purview'] = $result['pur'];
														$_SESSION['user_type'] = $result['type_id'];
									
									echo $ucsynlogin;
									if (isset($_SESSION['referer_url']) && $_SESSION['referer_url']!=""){
										$referer_url = $_SESSION['referer_url'];
										$_SESSION['referer_url'] = "";
										echo '<script language="javascript">window.location.href="'. $_A['admin_url'].'"</script>';
										//header("location:".$referer_url);
									}else{
										echo '<script language="javascript">window.location.href="'. $_A['admin_url'].'";</script>';
										//header("location:".$_A['admin_url']);
									}
								}//if($login_msg == "")
							}
						}//else 
                }
                                
			}
		}
	}
	$magic->assign("login_msg",$login_msg);
	$template = "admin_login.html";
}

/* �û��˳� */
else if ($_A['query_sort']=='logout'){
	/*
	$_SESSION['user_id'] = "";
	$_SESSION['username'] = "";
	$_SESSION['user_realname'] = "";
	$_SESSION['purview'] = "";
	$_SESSION['usertype'] = "";
	$_SESSION['user_opencity'] ="";
	$_SESSION['user_typename'] = "";
	$_SESSION['usertime'] = "";
	$_SESSION['userstyle'] = "";//�ж��ǹ�������ͨ���û�����
	*/
	if ($_G['is_cookie'] ==1){
		setcookie(Key2Url("user_id","rdun"),"");
	}else{
		$_SESSION[Key2Url("user_id","rdun")] = "";
		$_SESSION['login_endtime'] = "";
		unset($_SESSION[Key2Url("user_id","rdun")]);
		unset($_SESSION['login_endtime']);
	}
	unset($_SESSION['logintype']);
	unset($_SESSION['purview']);	
	//TODO
	//$ucsynlogout = uc_user_synlogout();
	//echo $ucsynlogout;
	echo '<script language="javascript">window.location.href="'. $_A['admin_url'].'";</script>';
	exit();
}

/* ����������ҳ */
elseif ($_A['query_sort']=='main' ){
	$_A['list_name'] = "������ҳ";
	$_A['list_title'] = "ϵͳ��Ϣ";
	$php_info["phpv"] = phpversion();
	$php_info["sp_os"] = strtolower(isset($_ENV['OS']) ? $_ENV['OS'] : @getenv('OS'));
	$php_info["sp_gd"] = @gdversion();
	$php_info["sp_server"] = $_SERVER["SERVER_SOFTWARE"];
	$php_info["sp_host"] = (empty($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_HOST"] : $_SERVER["REMOTE_ADDR"]);
	$php_info["sp_name"] = $_SERVER["SERVER_NAME"];
	$php_info["sp_max_execution_time"] = ini_get('max_execution_time');
	$php_info["sp_allow_reference"] = (ini_get('allow_call_time_pass_reference') ? '<font color=green>[��]On</font>' : '<font color=red>[��]Off</font>');
	$php_info["sp_allow_url_fopen"] = (ini_get('allow_url_fopen') ? '<font color=green>[��]On</font>' : '<font color=red>[��]Off</font>');
	$php_info["sp_safe_mode"] = (ini_get('safe_mode') ? '<font color=red>[��]On</font>' : '<font color=green>[��]Off</font>');
	$php_info["sp_mysql"] = (function_exists('mysql_connect') ? '<font color=green>[��]On</font>' : '<font color=red>[��]Off</font>');
	$_A['php_info'] = $php_info;
	$template = "admin_main.html.php";
}


elseif ($_A['query_sort']=='bbs' ){
	$_A['list_name'] = "��̳����";
	$_A['list_title'] = "��̳";
	if (!moduleClass::GetOne(array("code"=>"dwbbs"))){
		$msg = array("��̳��δ��װ","","{$_A['admin_url']}");
	}elseif (file_exists(ROOT_PATH."modules/dwbbs/dwbbs.php")){
		include_once(ROOT_PATH."modules/dwbbs/dwbbs.php");
	}else{
		$msg = array("�Ҳ�����̳ģ��","","{$_A['admin_url']}");
	}
}


//������ģ���ļ�
else{
	$_A['site_id'] = isset($_REQUEST['site_id'])?$_REQUEST['site_id']:"";
	if (!empty($_A['site_id'])){
		//���վ�����Ϣ
		$_A['site_result'] = "";
		foreach ($_G['site_list'] as $key => $value){
			if ($value['site_id'] == $_A['site_id']){
				$_A['site_result'] = $value;
			}
		}
	}
	if (isset($_G['site_list']) && $_G['site_list']!=""){
		foreach ($_G['site_list'] as $key => $value){
			if ($value['code'] == $_A['query_class']){
				$_A['site_code_list'][$value['site_id']] = $value;
			}
		}
	}
	$_A['list_name'] = "������ҳ";
	$_A['list_title'] = "������ҳ";
	$pages->rewrite = false;
	if (file_exists(ROOT_PATH."/modules/admin/{$_A['query_sort']}.php")){
		include_once(ROOT_PATH."/modules/admin/{$_A['query_sort']}.php");
	}else{
		$msg = array("���������������Ҳ�����","���ع�������",$_A['admin_url']);
		$template = "admin_main.html.php";
	}

}


//�������ļ�
if (isset($msg) && $msg!="") {
	$_msg = $msg[0];
	$content = empty($msg[1])?"������һҳ":$msg[1];
	$url = empty($msg[2])?"-1":$msg[2];
	$http_referer = empty($_SERVER['HTTP_REFERER'])?"":$_SERVER['HTTP_REFERER'];
	if ($http_referer == "" && $url == ""){ $url = "/";}
	if ($url == "-1") $url = "";
	elseif ($url == "" ) $url = $http_referer;
	
	$_A['showmsg'] = array('msg'=>$_msg,"url"=>$url,"content"=>$content);
	$template = "admin_msg.html";
	
}



$magic->assign("_A",$_A);
$magic->display($template);
exit;	
?>
