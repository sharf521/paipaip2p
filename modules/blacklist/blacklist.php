<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("blacklist_".$_A['query_type']);//���Ȩ��

include_once("blacklist.class.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

$_A['list_purview'] =  array("links"=>array("�������б�"=>array("blacklist_list"=>"�������б�","blacklist_new"=>"���������","blacklist_del"=>"ɾ��������")));//Ȩ��
$_A['list_name'] = $_A['module_result']['name'];
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�������б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���������</a>";

//������Ա�����ڵķ�վ��Ϣ����
$data['areaid'] = $_SESSION['areaid'];
/**
 * �������Ϊ�յĻ�����ʾ���е��ļ��б�
 **/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�������б�";

	$data['page'] = $_A['page'];
	$data['epage'] = 20;
	$data['keywords'] = isset($_REQUEST['keywords'])?$_REQUEST['keywords']:"";

	if(isset($_REQUEST['username'])){
		$data['username'] = $_REQUEST['username'];
	}
	if(isset($_REQUEST['realname'])){
		$data['realname'] = $_REQUEST['realname'];
	}
	if(isset($_REQUEST['card_id'])){
		$data['card_id'] = $_REQUEST['card_id'];
	}
	if(isset($_REQUEST['phone'])){
		$data['phone'] = $_REQUEST['phone'];
	}
	if(isset($_REQUEST['email'])){
		$data['email'] = $_REQUEST['email'];
	}

	$result = blacklistClass::GetList($data);
	//liukun add for bug 52 begin
	fb($result, FirePHP::TRACE);
	//liukun add for bug 52 end
	if (is_array($result)){
		$pages->set_data($result);
		$_A['blacklist_list'] = $result['list'];
		$_A['showpage'] = $pages->show(3);
	}else{
		$msg = array($result);
	}
}


/**
 * ���
 **/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit" ){
	if (isset($_POST['submit'])){
		// 		$var = array("type_id","status","order","url","logo","webname","summary","linkman","email", "areaid");
		// 		foreach ( $var as $val){
		// 			$data[$val] = !isset($_POST[$val])?"":$_POST[$val];
		// 		}

		$_G['upimg']['file'] = "logoimg";
		$_G['upimg']['mask_status'] = 0;
		$pic_result = $upload->upfile($_G['upimg']);
		if ($pic_result!=""){
			$data['logoimg'] = $pic_result['filename'];
		}

		$fname = $data['logoimg'];
		$handle=fopen("$fname","r");
		$i = 0;
		while($data=fgetcsv($handle,10000,",")){
			$black_user[$i]['platform'] = $data[0];
			$black_user[$i]['username'] = $data[1];
			$black_user[$i]['realname'] = $data[2];
			if ($data[3] == "��"){
				$black_user[$i]['sex'] = 1;
			}else{
				$black_user[$i]['sex'] = 0;
			}
			$black_user[$i]['card_id'] = $data[4];
			$black_user[$i]['phone'] = $data[5];
			$black_user[$i]['email'] = $data[6];
			$black_user[$i]['huhou_addr'] = $data[7];
			$black_user[$i]['live_addr'] = $data[8];
			$black_user[$i]['late_amount'] = $data[9];
			$black_user[$i]['late_num'] = $data[10];
			$black_user[$i]['advance_num'] = $data[11];
			$black_user[$i]['late_day_num'] = $data[12];
			$black_user[$i]['count_date'] = $data[13];
			$black_user[$i]['inner'] = 0;
			$i++;
		}
		fclose($handle);
		$data['list'] = $black_user;
		$result = blacklistClass::Add($data);
		if ($result == false){
			$msg = array("���������������Ա��ϵ");
		}else{
			$msg = array("�����ɹ�","������һҳ",$_A['query_url']);
		}
		$user->add_log($_log,$result);//��¼����


	}
}


/**
 * ɾ��
 **/
elseif ($_A['query_type'] == "del"){
	$data['id'] = $_REQUEST['id'];
	$result = blacklistClass::Delete($data);
	if ($result !== true){
		$msg = array($result);
	}else{
		$msg = array("ɾ���ɹ�","������һҳ",$_A['query_url']);
	}
	$user->add_log($_log,$result);//��¼����
}


?>