<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

if (isset($_POST['password'])){
	$login_msg = "";

	 if ($_POST['keywords']==""){
		$msg = array("�˺Ų���Ϊ��","","?user&&q=action/login");
	}elseif ($_POST['password']==""){
		$msg = array("���벻��Ϊ��","","?user&&q=action/login");
	}else{
		if(!isset($index['user_id']) || $index['user_id']==""){
			$index['user_id'] = $_POST['keywords'];
		}
		$index['email'] =$_POST['keywords'];
		$index['username'] = $_POST['keywords'];
		$index['password'] = $_POST['password'];
		$result = $user->Login($index);
		if (is_array($result)){
			if($result['islock']==1){
				$_url = '/';
				$msg = array("���˻�{$result[username]}�Ѿ�������","����>>", $_url);			
			} 
			else
			{
			$data['username'] = $result['username'];
			$data['user_id'] = $result['user_id'];
			$data['user_typeid'] = $result['type_id'];
			$data['reg_step'] = "";
			set_session($data);//ע��session
			$_url = 'index.php?user';
			if (isset($_POST['cookietime']) && $_POST['cookietime']>0){
				$ctime = time()+$_POST['cookietime']*600;
			}else{
				$ctime = time()+60*600;
			}
			
			if ($_G['is_cookie'] ==1){
				setcookie(Key2Url("user_id","DWCMS"),authcode($data['user_id'].",".time(),"ENCODE"),$ctime);
			}else{
				$_SESSION[Key2Url("user_id","DWCMS")] = authcode($data['user_id'].",".time(),"ENCODE");
				$_SESSION['login_endtime'] = $ctime;
			}
							//add by weego for ��¼cookies��֤ 20120610
				setcookie('rdun', authcode($data['user_id'] . "," . time(), "ENCODE"), $ctime);
				setcookie('login_uid',$data['user_id'], $ctime);
				setcookie('login_endtime',$ctime, $ctime);
				
			$msg = array("��¼�ɹ�,ϵͳ��3�����ת","�����û�����",$_url);
			}
			//setcookie("useradsf",1,time()+60*60);
			//var_dump(Key2Url("user_id","DWCMS"));var_dump($_SESSION);exit;
			/*
			if ($result['email_status']!=1){
				$_SESSION['reg_step'] = "reg_email";
				header('location:index.php?user&q=action/reg_email');
				exit;
			}elseif ($result['avatar_status']!=1){
				$_SESSION['reg_step'] = "reg_avatar";
				header('location:index.php?user&q=action/reg_avatar');
			}else{
				$_url = 'index.php?user';
				$msg = array("��¼�ɹ�,ϵͳ��3�����ת","�����û�����"��$_url);
			}
			*/
		}else{
			$msg = array($result);
		}
	}
$_U['login_msg'] = $login_msg;
}
$title = '�û���¼';
$template = 'user_login.html.php';
?>