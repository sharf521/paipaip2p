<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("dwbbs_".$_A['query_type']);//���Ȩ��

include_once("dwbbs.class.php");

$_A['list_purview'] =  array("dwbbs"=>array("��̳����"=>array("dwbbs_forumall"=>"��������","dwbbs_forum"=>"����")));//Ȩ��
$_A['list_name'] = "��̳����";
$_A['list_menu'] = " ";

if ($_A['query_class']== "list"){
	$_A['query_class'] = "info";
}

/**
 * ϵͳ������Ϣ����
**/
if ( $_A['query_class']== "info" ){
	check_rank("bbs_info");//���Ȩ��
	
	$_A['list_menu'] = "<a href='{$_A['query_url']}/list'>��̳���� </a> | <a href='{$_A['query_url']}/credits'>��̳����</a>";
	
	//��̳����
	if ($_A['query_type'] == "list"){
		$_A['list_title'] = "��̳����";
		if (isset($_POST['value'])){
			$data['value'] = $_POST['value'];
			$data['action'] = "updates";
			$data['style'] = "1";
			$result = dwbbsClass::ActionSettings($data);
			if ($result==true){
				$msg = array("�����ɹ�");
			}else{
				$msg = array($result);
			}
		}
	}
	
	//����
	elseif ($_A['query_type'] == "credits"){
		$_A['list_title'] = "��̳����";
		if (isset($_POST['credit'])){
			$data['credit'] = $_POST['credit'];
			$data['action'] = "updates";
			$result = dwbbsClass::ActionCredits($data);
			if ($result==true){
				$msg = array("�����ɹ�");
			}else{
				$msg = array($result);
			}
		}
	}
	
}


/**
 * ϵͳ������Ϣ����
**/
elseif ( $_A['query_class']== "forum" ){
	check_rank("bbs_info");//���Ȩ��
	
	$_A['list_menu'] = "<a href='{$_A['query_url']}/list'>�������</a> | <a href='{$_A['query_url']}/credits'>���ϲ�</a>";
	
	//��̳����
	if ($_A['query_type'] == "list"){
		$_A['list_title'] = "������� ";
		if (isset($_POST['name'])){       
			$data['name'] = $_POST['name'];
			$data['order'] = $_POST['order'];
			$data['id'] = $_POST['id'];
			$data['action'] = "updates";
			$result = dwbbsClass::ActionForum($data);
			if ($result==true){
				$msg = array("�����ɹ�");
			}else{
				$msg = array($result);
			}
		}
	}
	
	//��ӻ����޸�
	elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
		$_A['user_type_list'] = userClass::GetTypeList();
		
		if (isset($_POST['name'])){        
			$var = array("pid","name","content","rules","picurl","admins","isverify","showtype","ishidden","order","keywords","forumpass","forumusers","forumgroups");
			$data = post_var($var);
			if ($_A['query_type'] == "new" ){
				$data['action'] = "add";
			}else{
				$data['action'] = "update";
				$data['id'] = $_POST['id'];
			}
			$result = dwbbsClass::ActionForum($data);
			if ($result==true){
				$msg = array("�����ɹ�","�����б�ҳ",$_A['query_url']."/list");
			}else{
				$msg = array($result);
			}
		}
		if ($_A['query_type'] == "edit"){
			$data['id'] = $_REQUEST['id'];
			$data['action'] = "view";
			$_A['bbs_forum_result'] = dwbbsClass::ActionForum($data);
		}
	}
	
	//ɾ�����
	elseif ($_A['query_type'] == "del"){
		$data['fid'] = $_REQUEST['fid'];
		$data['action'] = "del";
		$result = dwbbsClass::ActionForum($data);
		if ($result==false){
			$msg = array("�ð������Ӱ�飬����ɾ��");
		}else{
			$msg = array("ɾ���ɹ�");
		}
	}
	
	//�趨����
	elseif ($_A['query_type'] == "admins"){
		$fid = isset($_REQUEST['fid'])?$_REQUEST['fid']:"";
		if (empty($fid)) {
			$msg = array("�����������");
		}else{
			if (isset($_POST['admins'])){
				$result = dwbbsClass::ActionForum(array("fid"=>$fid,"admins"=>$_POST['admins'],"action"=>"admins_add"));
				
				if ($result==""){
					$msg = array("�����ɹ�");
				}else{
					$msg = array("�û�".join(",",$result)."������");
				}		
			}else{
				$result = dwbbsClass::ActionForum(array("fid"=>$fid,"action"=>"admins_list"));
				if (!is_array($result)){
					$msg = array("�������������Ҳ���","�����б�ҳ",$_A['query_url']."/list");
				}else{
					$_A['admins_list'] = $result;
				}
			}
		}
	}	
	
	//���ϲ�
	elseif ($_A['query_type'] == "merge"){
		if(isset($_POST['fromfid'])){
			if ($_POST['fromfid']==$_POST['tofid']){
				$msg = array("Դ����Ŀ���鲻��һ��");
			}else{
				$result = dwbbsClass::ActionForum(array("fromfid"=>$_POST['fromfid'],"tofid"=>$_POST['tofid'],"action"=>"merge"));
				if ($result!==true){
					$msg = array($result);
				}else{
					$msg = array("���ϲ��ɹ�");
				}
			}
		}
	
	}
}

/**
 * ϵͳ������Ϣ����
**/
elseif ( $_A['query_class']== "topics" ){
	check_rank("bbs_topic");//���Ȩ��
	//��̳����
	if ($_A['query_type'] == "list"){
		$_A['list_title'] = "�����б� ";
	}
	elseif ($_A['query_type'] == "verify"){
		if (isset($_POST['status'])){
			$data['status'] = $_POST['status'];
			$data['tid'] = $_POST['tid'];
			$result = dwbbsClass::UpdateTopicsStatus($data);
			if ($result==false){
				$msg = array("��˴����������Ա��ϵ");
			}else{
				$msg = array("��˳ɹ�","",$_A['query_url']);
			}
		}else{
			$_A['list_title'] = "������� ";
		}
	}
	elseif ($_A['query_type'] == "recycle"){
		$_A['list_title'] = "�������վ ";
	}
	
	//ɾ�����
	elseif ($_A['query_type'] == "del"){
		$data['tid'] = $_REQUEST['id'];
		$result = dwbbsClass::DeleteTopics($data);
		if ($result==false){
			$msg = array("ɾ�������������Ա��ϵ");
		}else{
			$msg = array("ɾ���ɹ�","",$_A['query_url']);
		}
	}
}


/**
 * ���������ģ�����ȡ����ģ��������ļ�
**/
else{
	if ($_A['query_class'] == "dwbbs"){
		echo "<script>location.href='{$_A['admin_url']}&q=bbs';</script>";
		exit;
	}
	if (!isset($msg) || $msg =="")	$msg = array("����������");
}

if ($_A['query_class']!=""){
$magic->assign("template","dwbbs_".(empty($_A['query_class'])?'user':$_A['query_class']).".tpl");
}
$template = "admin_bbs.html";
?>
