<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

$valicode = isset($_POST['valicode'])?$_POST['valicode']:"";

$url = $_U['query_url']."/{$_U['query_type']}";
if (isset($_G['query_string'][2])){
	$url .= "&".$_G['query_string'][2];
}
if  ($_U['query_type'] == "vip") $url = "";
if (isset($_POST['valicode']) && $valicode!=$_SESSION['valicode']){

	$msg = array("��֤�����","",$url);
}else{
	$_SESSION['valicode'] = "";
	//���뱣������
	if ($_U['query_type'] == "protection"){
		if ((isset($_POST['type']) && $_POST['type'] == 1)){
			if (  $_G['user_result']['answer']=="" || $_POST['answer'] == $_G['user_result']['answer']){
				$_U['answer_type'] = 2;
			}else{
				$msg = array("����𰸲���ȷ","",$url);
			}
		}elseif (isset($_POST['type']) && $_POST['type'] == 2){
			$var = array("question","answer");
			$data = post_var($var);
			if ($data['answer']==""){
				$msg = array("����𰸲���Ϊ��","",$url);
			}else{
				$data['user_id'] = $_G['user_id'];
				$result = $user->UpdateUserProtection($data);
				if ($result == false){
					$msg = array($result);
				}else{
					$msg = array("���뱣���޸ĳɹ�","",$url);
				}
			}
		}
	}


	//������������
	elseif ($_U['query_type'] == "paypwd"){
		if (isset($_POST['oldpassword'])){
			if ($_G['user_result']['paypassword'] == "" && md5($_POST['oldpassword']) !=$_G['user_result']['password']){
				$msg = array("���벻��ȷ�����������ĵ�¼����","",$url);
			}elseif ($_G['user_result']['paypassword'] != "" && md5($_POST['oldpassword']) != $_G['user_result']['paypassword']){
				$msg = array("���벻��ȷ�����������ľɽ�������","",$url);
			}else{
				$data['user_id'] = $_G['user_id'];
				$data['paypassword'] = md5($_POST['newpassword']);
				$result = $user->UpdateUserAll($data);
				if ($result == false){
					$msg = array($result);
				}else{
					$msg = array("�����޸ĳɹ�","",$url);
				}
			}
		}
	}
	//������������
	elseif ($_U['query_type'] == "getpaypwd"){
		if(isset($_REQUEST['id']) && $_REQUEST['id']!=""){
			if (isset($_POST['paypwd']) && $_POST['paypwd']!=""){
				if ($_POST['paypwd']==""){
					$msg = array("���벻��Ϊ��","",$url);
				}elseif ($_POST['paypwd']!=$_POST['paypwd1']){
					$msg = array("�������벻һ��","",$url);
				}else{
					$data['user_id'] = $_G['user_id'];
					$data['paypassword'] = md5($_POST['paypwd']);
					$result = $user->UpdateUser($data);
					$msg = array("���������޸ĳɹ�","","index.php?user&q=code/user/paypwd");
				}
			}else{
				$id = urldecode($_REQUEST['id']);
				$_id = explode(",",authcode(trim($id),"DECODE"));
				$data['user_id'] = $_id[0];
				if ($_id[1]+60*60<time()){
					$msg = array("��Ϣ�ѹ��ڣ����������롣");
				}elseif ($data['user_id']!=$_G['user_id']){
					$msg = array("����Ϣ���������Ϣ���벻Ҫ�Ҳ���");
				}

			}
		}elseif (isset($_POST['valicode'])){
			$data['user_id'] = $_G['user_id'];
			$data['username'] = $_G['user_result']['username'];
			$data['email'] = $_G['user_result']['email'];
			$data['webname'] = $_G['system']['con_webname'];
			$data['title'] = "��������ȡ��";
			$data['key'] = "getPayPwd";
			$data['query_url'] = "code/user/getpaypwd";
			$data['msg'] = RegEmailMsg($data);
			$data['type'] = "getpaypwd";
			$result = $user->SendEmail($data);
			$msg = array("��Ϣ�ѷ��͵��������䣬��ע�����");
		}
	}

	//��¼��������
	elseif ($_U['query_type'] == "userpwd"){
		if (isset($_POST['oldpassword'])){
			//if (md5($_POST['oldpassword']) != $_G['user_result']['password']){
				//$msg = array("���벻��ȷ�����������ľ�����","",$url);
			//}else
			{
				if ($rdGlobal['uc_on'])
				{
					//liukun add for bug 46 begin
					//TODO liukun ���� ��UC���Ӹ�������Ĳ���
					require_once ROOT_PATH . '/config_ucenter.php';
					require_once ROOT_PATH . '/uc_client/client.php';
					$ucresult = uc_user_edit($_G['user_result']['username'], $_POST['oldpassword'], $_POST['newpassword']);
					//liukun add for bug 46 end
						
					if ($ucresult == -1) {
						$msg = array("�����벻��ȷ","",$url);
					} elseif ($ucresult == -4) {
						$msg = array("Email ��ʽ����","",$url);
					} elseif ($ucresult == -5) {
						$msg = array("Email ������ע��","",$url);
					} elseif ($ucresult == -6) {
						$msg = array("�� Email �Ѿ���ע��","",$url);
					} else{
						$data['user_id'] = $_G['user_id'];
						$data['password'] = $_POST['newpassword'];
						$result = $user->UpdateUser($data);
						if ($result == false){
							$msg = array($result);
						}else{
							$msg = array("��¼�����޸ĳɹ�","",$url);
						}
					}
				}else{
					$data['user_id'] = $_G['user_id'];
					$data['password'] = $_POST['newpassword'];
					$result = $user->UpdateUser($data);
					if ($result == false){
						$msg = array($result);
					}else{
						$msg = array("��¼�����޸ĳɹ�","",$url);
					}
				}
			}
		}
	}

	//��̬��������
	elseif ($_U['query_type'] == "serialStatusSet"){

		if (isset($_POST['action'])){
			/*�ж϶�̬����*/
			$result = userClass::GetOnes(array("user_id"=>$_G['user_id']));
			$uchon_sn_db = $result['serial_id'];
			$uchon_otp = $_POST['uchoncode'];
			$res = otp_check($uchon_sn_db, $uchon_otp);

			if($res == '200'){
				unset($_POST['action']);
				unset($_POST['name']);
				$a = array();
				foreach($_POST as $k=>$v){
					$a[$k] = $v;
				}

				$data['user_id'] = $_G['user_id'];
				$data['serial_status'] = json_encode($a);
				$result = $user->UpdateUser($data);
				if ($result == false){
					$msg = array($result);
				}else{
					$msg = array("�ύ�ɹ�","",$url);
				}
			}else{
				$msg = array("��̬�������","",$url);
			}
		}
	}

	//������˽
	elseif ($_U['query_type'] == "privacy"){
		if (isset($_POST['friend'])){
			$var = array("friend","friend_comment","borrow_list","loan_log","sent_msg","friend_request","look_black","allow_black_sent","allow_black_request");
			$_result = post_var($var);
			$data['privacy'] = serialize($_result);
			$data['user_id'] = $_G['user_id'];
			$result = $user->UpdateUserAll($data);
			if ($result == false){
				$msg = array($result);
			}else{
				$msg = array("��˽���óɹ�","",$url);
			}
				
		}else{
			$result = unserialize($_G['user_result']['privacy']);
			$_U['user_privacy'] = $result;
		}
	}

	//ʵ����֤
	elseif ($_U['query_type'] == "realname"){
		if (isset($_POST['realname'])){
			$var = array("realname","sex","card_type","card_id","province","city","province","city","area","nation");
			$data = post_var($var);
			$data['user_id'] = $_G['user_id'];
			$data['birthday'] = get_mktime($_POST['birthday']);
			$data['real_status'] = 2;
				
			$result = userClass::CheckIdcard(array("user_id"=>$data['user_id'],"card_id"=>$data['card_id']));
			if($_POST['card_type']==1 && !isIdCard($data['card_id']))
			{
				$msg = array("���֤�����ʽ����ȷ",'','javascript:history.go(-1)');
			}else{
				if($result == true){
					$msg = array("���֤�����Ѿ�����","","javascript:history.go(-1)");
				}else{
					$_G['upimg']['file'] = "card_pic2";
					$_G['upimg']['code'] = "user";
					$pic_result = $upload->upfile($_G['upimg']);
					if ($pic_result!=""){
						$data['card_pic2'] = $pic_result['filename'];
					}
					$_G['upimg']['file'] = "card_pic1";
					$pic_result = $upload->upfile($_G['upimg']);
					if ($pic_result!=""){
						$data['card_pic1'] = $pic_result['filename'];
					}
					$result = $user->UpdateUserAll($data);
					if ($result == false){
						$msg = array($result);
					}else{
						$msg = array("������֤��ӳɹ�����ȴ�����Ա���","",$url);
					}
				}
			}
		}
	}

	//������֤
	elseif ($_U['query_type'] == "email_status"){
		if (isset($_POST['email']) && $_POST['email']!="" ){
			$data['user_id'] = $_G['user_id'];
			$data['email'] = $_POST['email'];
			$result = $user->CheckEmail($data);
			if ($result==false){
				$result = $user->UpdateUserAll($data);
				if ($result == false){
					$msg = array($result);
				}else{
					$data['username'] = $_G['user_result']['username'];
					$data['webname'] = $_G['system']['con_webname'];
					$data['title'] = "ע���ʼ�ȷ��";
					$data['msg'] = RegEmailMsg($data);
					$data['type'] = "reg";
					if (isset($_SESSION['sendemail_time']) && $_SESSION['sendemail_time']+60*2>time()){
						$msg = array("��2���Ӻ��ٴ�����","",$url);
					}else{
						$result = $user->SendEmail($data);
						if ($result==true) {
							$_SESSION['sendemail_time'] = time();
							$msg = array("������Ϣ�Ѿ����͵��������䣬��ע����ա�","",$url);
						}
						else{
							$msg = array("����ʧ�ܣ��������Ա��ϵ��","",$url);
						}
					}
				}
			}else{
				$msg = array("��������д�������Ѿ�����","",$url);
			}
		}
	}

	//�ֻ���֤
	elseif ($_U['query_type'] == "phone_status"){
		if (isset($_POST['phone']) && $_POST['phone']!="" && $_POST['phone']>1){
				
			$data['user_id'] = $_G['user_id'];
			$data['phone_status'] = $_POST['phone'];
				
			$result = $user->UpdateUserAll($data);
			if ($result == false){
				$msg = array($result);
			}else{
				$msg = array("�ֻ���֤�����ɹ�����ȴ��ͷ���Ա���","",$url);
			}
		}
	}

	//��Ƶ��֤
	elseif ($_U['query_type'] == "video_status"){
		if (isset($_POST['submit']) && $_POST['submit']!="" ){
				
			$data['user_id'] = $_G['user_id'];
			$data['video_status'] = 2;
				
			$result = $user->UpdateUserAll($data);
			if ($result == false){
				$msg = array($result);
			}else{
				$msg = array("��Ƶ�����ɹ�����ȴ��ͷ���Ա������ϵ","",$url);
			}
		}
	}

	//������������
	elseif ($_U['query_type'] == "credit"){
		$_U['user_cache'] = userClass::GetUserCache(array("user_id"=>$_G['user_id']));//�û�����
	}

	//�������
	elseif ($_U['query_type'] == "reginvite"){
		$_U['user_inviteid'] =  Key2Url($_G['user_id'],"reg_invite");
	}

	//VIP����
	elseif ($_U['query_type'] == "applyvip"){
		if (isset($_POST['vip_remark'])){
			$data['user_id'] = $_G['user_id'];
			$data['vip_remark'] = nl2br($_POST['vip_remark']);;
			$data['kefu_userid'] = $_POST['kefu_userid'];

			if($data['kefu_userid'] == ""){
				echo "<script>alert('��ѡ������VIPר���ͷ�.');location.href='/vip/index.html';</script>";
				exit;
			}else{
				$result = userClass::ApplyUserVip($data);//�û�����
				if ($result == true){
					$msg = array("VIP����ɹ�����ȴ�����Ա���","","?vip");
				}
				else{
					$msg = array("VIP����ʧ��","","/index.php?user");
				}
			}

		}
	}

	//��Ϊ����
	elseif ($_U['query_type'] == "addfriend"){
		if (isset($_POST['type'])){
			$data['type'] = $_POST['type'];
			$data['content'] = nl2br($_POST['content']);
			$data['friends_userid'] = $_POST['friends_userid'];
			$data['user_id'] = $_G['user_id'];
			$result = userClass::AddFriends($data);
			if ($result==false){
				$msg = array($result,"","/index.php?user&q=code/user/myfriend");
			}else{
				$msg = array("��Ӻ��ѳɹ�����ȴ����ѵ����","","/index.php?user&q=code/user/myfriend");
			}
		}else{
			$result = userClass::GetOnes(array("username"=>$_REQUEST['username']));
			if ($result==false){
				$result = userClass::GetOnes(array("username"=>urldecode($_REQUEST['username'])));
				$_REQUEST['username'] = urldecode($_REQUEST['username']);
			}
			if ($result==false){
				echo "<script>alert('�Ҳ������û����벻Ҫ�Ҳ���');location.href='/index.php?user'</script>";
				exit;
			}elseif ($result['user_id']==$_G['user_id']){
				echo "<script>alert('���ܼ��Լ�Ϊ����');location.href='/index.php?user';</script>";
				exit;
			}else{
				echo "<form method='post' action='/index.php?user&q=code/user/addfriend'>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ѣ�{$_REQUEST['username']}<input type='hidden' name='friends_userid' value='{$result['user_id']}'></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ͣ�<select name='type'>";
				foreach ($_G["_linkage"]['friends_type'] as $key => $value){
					echo "<option value='{$value['value']}'>{$value['name']}</option>";
				}
				echo "</select></div><div align='left'><br>&nbsp;&nbsp;&nbsp;���ݣ�<textarea rows='5' cols='30' name='content'></textarea></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;<input type='submit' value='ȷ�����'></div>";
				echo "</form>";
				exit;
			}
		}
	}

	//����ļ�Ϊ����
	elseif ($_U['query_type'] == "raddfriend"){
		if (isset($_POST['type'])){
			$data['type'] = $_POST['type'];
			$data['content'] = nl2br($_POST['content']);
			$data['friends_userid'] = $_POST['friends_userid'];
			$data['user_id'] = $_G['user_id'];
			$result = userClass::RAddFriends($data);
			if ($result==false){
				$msg = array($result,"","/index.php?user&q=code/user/myfriend");
			}else{
				$msg = array("�ɹ���Ӻ��ѳɹ�","","/index.php?user&q=code/user/myfriend");
			}
		}else{
			$result = userClass::GetOnes(array("username"=>$_REQUEST['username']));
			if ($result==false){
				echo "<script>alert('�Ҳ������û����벻Ҫ�Ҳ���');location.href='/index.php?user'</script>";
				exit;
			}elseif ($result['user_id']==$_G['user_id']){
				echo "<script>alert('���ܼ��Լ�Ϊ����');location.href='/index.php?user';</script>";
				exit;
			}else{
				echo "<form method='post' action='/index.php?user&q=code/user/raddfriend'>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ѣ�{$_REQUEST['username']}<input type='hidden' name='friends_userid' value='{$result['user_id']}'></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ͣ�<select name='type'>";
				foreach ($_G["_linkage"]['friends_type'] as $key => $value){
					echo "<option value='{$value['value']}'>{$value['name']}</option>";
				}
				echo "</select></div><div align='left'><br>&nbsp;&nbsp;&nbsp;���ݣ�<textarea rows='5' cols='30' name='content'></textarea></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;<input type='submit' value='ȷ�����'></div>";
				echo "</form>";
				exit;
			}
		}
	}


	//��Ϊ����
	elseif ($_U['query_type'] == "checkaddfriend"){
		if (isset($_POST['type'])){
			$data['type'] = $_POST['type'];
			$data['content'] = nl2br($_POST['content']);
			$data['friends_userid'] = $_POST['friends_userid'];
			$data['user_id'] = $_G['user_id'];
			$result = userClass::AddFriends($data);
			if ($result==false){
				$msg = array($result,"","/index.php?user&q=code/user/myfriend");
			}else{
				$msg = array("��Ӻ��ѳɹ�����ȴ����ѵ����","","/index.php?user&q=code/user/myfriend");
			}
		}else{
			$result = userClass::GetOnes(array("username"=>$_REQUEST['username']));
			if ($result==false){
				echo "<script>alert('�Ҳ������û����벻Ҫ�Ҳ���');location.href='/index.php?user'</script>";
				exit;
			}elseif ($result['user_id']==$_G['user_id']){
				echo "<script>alert('���ܼ��Լ�Ϊ����');location.href='/index.php?user';</script>";
				exit;
			}else{
				echo "<form method='post' action='/index.php?user&q=code/user/addfriend'>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ѣ�{$_REQUEST['username']}<input type='hidden' name='friends_userid' value='{$result['user_id']}'></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;���ͣ�<select name='type'>";
				foreach ($_G["_linkage"]['friends_type'] as $key => $value){
					echo "<option value='{$value['value']}'>{$value['name']}</option>";
				}
				echo "</select></div><div align='left'><br>&nbsp;&nbsp;&nbsp;���ݣ�<textarea rows='5' cols='30' name='content'></textarea></div>";
				echo "<div align='left'><br>&nbsp;&nbsp;&nbsp;<input type='submit' value='ȷ�����'></div>";
				echo "</form>";
				exit;
			}
		}
	}

	//ɾ������
	elseif ($_U['query_type'] == "delfriend"){
		$data['user_id'] = $_G['user_id'];
		$data['friend_username'] = $_REQUEST['username'];
		userClass::DeleteFriends($data);
		$msg = array("ɾ���ɹ�","",$_U['query_url']."/myfriend");

	}

	//��Ϊ������
	elseif ($_U['query_type'] == "blackfriend"){

		$data['user_id'] = $_G['user_id'];
		$data['friend_username'] = $_REQUEST['username'];
		userClass::BlackFriends($data);
		$msg = array("�ѳɹ����������","",$_U['query_url']."/black");


	}
	//���¼�Ϊ����
	elseif ($_U['query_type'] == "readdfriend"){
		$data['user_id'] = $_G['user_id'];
		$data['friend_username'] = $_REQUEST['username'];
		userClass::ReaddFriends($data);
		$msg = array("�ѳɹ���Ϊ����","",$_U['query_url']."/myfriend");

	}

	//�����Ϊ��ְ
	elseif ($_U['query_type'] == "jianzhi"){
		if(isset($_POST['content']) && $_POST['content']!=""){
			$data['user_id'] = $_G['user_id'];
			$data['content'] = $_POST['content'];
			$data['old_type'] = $_G['user_result']['type_id'];
			$data['new_type'] = 7;
			userClass::TypeChange($data);
			$msg = array("�������ύ����ȴ�����Ա�����","",$_U['query_url']."/jianzhi");
		}else{
			$_U['typechange_result'] = userClass::TypeChange($data);
		}
	}
}

$template = "user_info.html.php";
?>
