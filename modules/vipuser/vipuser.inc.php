<?

if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
require_once 'vipuser.class.php';
$action = isset($_REQUEST['action'])?$_REQUEST['action']:"";
if ($_U['query_type'] == "apply"){
	if ($_U['user_id']==""){
		$_url = '/index.php?user&q=action/login';
		echo  "<bg><br>����û�е�¼�����ȵ�¼<br /><br /><a href=$_url>��¼</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',4000);function curl(){ 	location.href='$_url'}</script>";
		exit;
	}
	
	elseif ($_U['user_result']['vip_status']!=1){
		$_url = '/index.php?user&q=vipuser';
		$msg = "<bg><br>������vip��Ա�����ȼ���vip<br /><br /><a href=$_url>����vip</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',4000);function curl(){ 	location.href='$_url'}</script>";
		echo $msg;
		exit;	
	}
	
	else{
		$id = $_REQUEST['id'];
		$result =  HuoDong::Apply($id,$_SESSION['user_id']);
		if ($result===true){
			echo "�����ɹ�";
		}else{
			echo $result;
		}
		echo "";
		exit;
	}
}
elseif ($_U['query_type'] == "active"){
	if (isset($_POST['password'])){
	$result =VipUser::AddVipUser($_U['user_result']['username'],$_POST['card_type'], $_POST['card_number'], $_POST['password']);
	if ($result == VipUser::USER_NOT_EXISTS){
		$vipmsg = "��Ա������";
	}elseif ($result == VipUser::USER_NOT_RESUME){
		$vipmsg = "��Աû�м���";
	}elseif ($result == VipUser::USER_NOT_RESUME){
		$vipmsg = "��Աû�м���";
	}elseif ($result == VipUser::USER_IS_VIP){
		$vipmsg = "���Ѿ���vip���������¼���";
	}elseif ($result == VipUser::CARD_NOT_EXISTS ){
		$vipmsg = "���Ų�����";
	}elseif ($result == VipUser::CARD_IS_USED   ){
		$vipmsg = "�˿��Ѿ���ʹ��";
	}elseif ($result == VipUser::CARD_ERROR_PASSWORD ){
		$vipmsg = "�����������";
	}else{
		$vipmsg = "����ɹ�";
	}
	$magic->assign("vipmsg",$vipmsg);
}
$_U['vip_cardtype_list'] = VipUser::CardType();

$template = 'user_vip.html';
}
?>