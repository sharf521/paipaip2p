<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
require_once 'albums.class.php';
$albums = new albumsClass();
$action = isset($_REQUEST['action'])?$_REQUEST['action']:"";
if ($_U['query_type'] == "apply"){
	if ($_U['user_id']==""){
		$_url = '/index.php?user&q=action/login';
		echo  "<bg><br>����û�е�¼�����ȵ�¼<br /><br /><a href=$_url>��¼</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',4000);function curl(){ 	location.href='$_url'}</script>";
		exit;
	}
	
	elseif ($_U['user_result']['vip_status']!=1){
		$_url = '/index.php?user&q=code/vipuser/active';
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

elseif ($_U['query_type'] == "apply_list"){
	$result =  HuoDong::GetApply($_REQUEST['id'],"","huodong");
	$display ='';
	
	foreach ($result as $key => $value){
		$avatar = get_avatar(array("user_id"=>$value['user_id']));
		$display .='<li><div ><a href="/dzx/home.php?mod=space&uid='.$value['uc_user_id'].'" target=_blank><img src="'.$avatar.'" width=80 height=80 /></a></div><a href="">'.$value['realname'].'</a></li>';
	}
	echo "document.write('$display')";
	exit;

}

//�˶�
elseif ($_U['query_type'] == "cancel"){
	if (!isset($_REQUEST['id']) || $_REQUEST['id']==""){
	   $msg = array("��������");
	}
	$data['id'] = $_REQUEST['id'];
	$data['user_id'] = $_G['user_id'];
	$data['code'] =  "yghd";
	$result = applyClass::CancelApply($data);
	if ($result !==true){
		$msg = array($result);
	}else{
		$msg = array("�˶��ɹ�","",$_U['query_url']);
	}
	

	
	
}elseif ($_U['query_type']=="join"){
	$data['user_id']   = $_G['user_id2'];
	$data['page']      = $_U['page'];
	$data['epage'] = $_U['epage'];
	$data['fuzeren'] = $_G['user_result']['username'];
	$data['code'] = "yghd1";

	$result = yghdClass::GetList($data);
	$_U['join_list'] = $result['list'];
	$_U['showpage'] = $pages->show(3);
	
}
//�����Ƭ
elseif ($_U['query_type']=="pics"){
	if (isset($_POST['picname']) && trim($_POST['picname'])!=""){
		$data['name'] = $_POST['picname'];
		$data['id'] = $_POST['id'];
		$data['user_id'] = $_G['user_id'];
		$upload->UpdateMore($data);
		$msg = array("��Ƭ�޸ĳɹ�");
	}
	
}


//�����Ƭ
elseif ($_U['query_type']=="edit"){
	if (!isset($_REQUEST['albums_id']) || $_REQUEST['albums_id']==""){
		$msg = array("����������CODE:-1");
	}elseif ( $_REQUEST['albums_id']==0){
		$msg = array("������ΪϵͳĬ�����ͣ����ܱ༭��CODE:-2");
	}else{
		if (isset($_POST['name']) && trim($_POST['name'])!=""){
			$var = array("name","order","content","type_id","id");
			$data = post_var($var);
			$data['user_id'] = $_G['user_id'];
			albumsClass::Update($data);
			$msg = array("����޸ĳɹ�");
		}else{
			$_U['albums_result'] = albumsClass::GetAlbumsOne(array("user_id"=>$_G['user_id'],"id"=>$_REQUEST['albums_id']));
			if ($_U['albums_result']==false){
				$msg = array("���Ĳ�������CODE:-1");
			}
		}
	}
}

//�����Ƭ
elseif ($_U['query_type'] == "upload"){
	if (isset($_POST['albums_id']) && $_POST['albums_id']!=""){
		$data['user_id'] = $_G['user_id'];
		$data['aid'] = $_POST['albums_id'];
		$data['code']= "albums";
		$data['name'] = $_POST['picname'];
		$data['file'] = "pic";
		$data['cut_status'] = 1;
		$data['cut_type'] = 2;
		$data['cut_width'] = 680;
		$data['cut_height'] = 680;
		$result = $upload->upfiles($data);
		$msg = array($result);
	}
}
//��Ƭ�Ĳ���
elseif ($_U['query_type'] == "action"){
	$pic_result = $upload -> GetOne(array("id"=>$_REQUEST['id'],"user_id"=>$_G['user_id']));
	
	$result = albumsClass::GetAlbumsList(array("user_id"=>$_G['user_id'],"limit"=>"all"));
	$_albums = "";
	foreach ($result as $key => $value){
		if ($pic_result['aid'] == $value['id']){
			$_albums .= "<option value='{$value['id']}' selected='selected'>{$value['name']}</option>";
		}else{
			$_albums .= "<option value='{$value['id']}'  >{$value['name']}</option>";
		}
	}
	$_select_no = $_select_yes = "";
	if ($pic_result['if_cover'] == 0){
		$_select_no = " checked";
	}else{
		$_select_yes = " checked";
	}
	echo "<br>�Ƿ���棺<input type='radio' id='if_cover' value='1' name='if_cover' {$_select_yes}>�� <input type='radio' id='if_cover' value='0' name='if_cover' {$_select_no}>�� <br/><br/>�ƶ�����<select id='type_id' name='type_id'><option value=0>ϵͳĬ�����</option>{$_albums}</select><br/><br/><input type='button' value='ȷ�����' onclick='actionPic({$_REQUEST['id']})'>&nbsp;&nbsp; <input type='button' value='ȡ��' onclick=closeW(); >";
	exit;
}


//��Ƭ�Ĳ���
elseif ($_U['query_type'] == "action_ok"){
	
	$result = albumsClass::UpdateCover(array("user_id"=>$_G['user_id'],"id"=>$_REQUEST['id']));
}


//������ĵ�ַ
elseif ($_U['query_type'] == "albums_new"){
	echo "<br>�������<input type='text' name='' size='15' id='ablums_name'><br/><br/><input type='button' value='ȷ�����' onclick='addAblums()'>&nbsp;&nbsp; <input type='button' value='ȡ��' onclick=closeW(); >";
	exit;
}

//ajaxɾ����Ƭ
elseif ($_U['query_type'] == "del"){
	echo "<br>ȷ������ƬҪ���õ�ɾ����<br/><br/><input type='button' value='ȷ��ɾ��' onclick='delPic({$_REQUEST['id']})'>&nbsp;&nbsp; <input type='submit' value='ȡ��' onclick=closeW(); >";
	exit;
}

//ȷ��ɾ����Ƭ
elseif ($_U['query_type'] == "del_ok"){
	if ($_REQUEST['id']!=""){
		$result = $upload->Delete(array("user_id"=>$_G['user_id'],"id"=>$_REQUEST['id']));
		echo $result;
	}
	exit;
}

//������ĵ�ַ
elseif ($_U['query_type'] == "del_albums"){
	echo "<br>ɾ������ᣬͬʱ�����õ�ɾ�������������Ƭ��<br/><br/><input type='button' value='ȷ��ɾ��' onclick='delAlbums({$_REQUEST['albums_id']})'>&nbsp;&nbsp; <input type='submit' value='ȡ��' onclick=closeW(); >";
	exit;
}

//ȷ��ɾ�����
elseif ($_U['query_type'] == "del_albumsok"){
	if ($_REQUEST['albums_id']!=""){
		$result = albumsClass::DeleteAlbums(array("user_id"=>$_G['user_id'],"id"=>$_REQUEST['albums_id']));
		echo $result;
	}
	exit;
}

//ajax������
elseif ($_U['query_type'] == "aladd"){
	if ($_REQUEST['name']!=""){
		$result = albumsClass::AlbumsAdd(array("user_id"=>$_G['user_id'],"name"=>$_REQUEST['name']));
		echo $result;
	}
	exit;
}

//�鿴���
elseif ($_U['query_type'] == "view"){
	$result = albumsClass::GetOne(array("id"=>$_REQUEST['albums_id']));
	if ($result['user_id']!=$_G['user_id']){
		$msg = array("��û��Ȩ�޲鿴���˵����","",$_U['query_url']);
	}

}

$template  = "user_albums.html";
?>