<?
/******************************
 * $File: my.php
 * $Description: �ҵĿ�����
 * $Author: ahui 
 * $Time:2010-07-09
 * $Update:None 
******************************/
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

$list_name = "";
$list_menu = "<a href='{$admin_url}&q=control'>Ŀ¼�б�</a> - <a href='{$admin_url}&q=control/new'>���Ŀ¼</a>";

if ($s == "" ||$s == "new" ||$s == "edit"){
	if ($s == "edit"){
		$sql = "select * from {control} where id!=".$_REQUEST['id'];
	}else{
		$sql = "select * from {control} ";
	}
	$result = $mysql -> db_fetch_arrays($sql);
	$i=0;
	$purview = explode(",",$_SESSION['purview']);
	
	foreach ($result as $key => $value){
		//$purview = explode(",",$value['purview']);
		if(in_array("other_all",$purview)){
			$result[$key]['show'] = 1;
		}else{
			$url = $value['url'];
			$_url = explode("&",$url);
			$url = explode("/",$_url[0]);
			if (!isset($url[2])){
				$url[2] = "list";
			}
			$_pur = $url[1]."_".$url[2];
			if(in_array($_SESSION['usertype'],$purview)){
				$result[$key]['show'] = 1;
			}else{
				$result[$key]['show'] = 0;
			}
		}
		if ($value['pid']==0  ){
			$list[$i] = $value;
			$list[$i]['aname'] = "<b>".$value['name']."</b>";
			$list[$i]['ppid'] = 1;
			$i++;
			foreach ($result as $_key => $_value){
				if ($_value['pid']==$value['id']){
					$list[$i] = $_value;
					$list[$i]['aname'] = "-".$_value['name'];
					$i++;
					foreach ($result as $__key => $__value){
						if ($__value['pid']==$_value['id']){
							$list[$i] = $__value;
							$list[$i]['aname'] = "--".$__value['name'];
							$i++;
						}
					}
				}
			}
		}
	}
	$magic -> assign("list",$list);
	
	//����Ա��������
	$sql = "select * from {user_type} where type=1 and type_id!=1 ";
	$admin_type = $mysql -> db_fetch_arrays($sql);
	$_admin_type = "";
	if ($admin_type!="false"){
		foreach ($admin_type as $key  => $value){
			$_admin_type[$value['type_id']] = $value['name'];
		}
	}
	$magic -> assign("admin_type",$_admin_type);
	
	
	if ($s=="edit"){
		$sql = "select * from {control} where id =   ".$_REQUEST['id'];
		$result = $mysql -> db_fetch_array($sql);
		$magic -> assign("result",$result);
	}
}elseif ($s == "add" || $s == "update"){
	$var = array("pid","name","url","order","purview");
	$index = post_var($var);
	if ($s=="add"){
	$result = $mysql->db_add('control', $index);
		$msg = array("��ӳɹ�");
	}else{
		$result = $mysql->db_update("control",$index,"id=".$_POST['id']);
		$msg = array("�޸ĳɹ�");
	}
}elseif ($s == "del"){
	$result = $mysql->db_delete('control', "id=".$_REQUEST['id']);
	$msg = array("ɾ���ɹ�");
}
elseif ($s == "actions"){
	if (isset($_POST['id']) && $_POST['id']!=''){
		foreach ($_POST['id'] as $key => $value){
		/*
			if ($_POST['purview'][$key]!=''){
			$purview = join(",",$_POST['purview'][$key]);
			}else{
			$purview = "";
			}
			*/
			$sql = "update {control} set `order`='".$_POST['order'][$key]."' where `id` = '$value'";
			$result = $mysql->db_query($sql);
		}
	}
		$msg = array("�޸ĳɹ�");
}


if ($msg!=""){
	$template_tpl = show_msg($msg,$msg_tpl);//�������Ϣ����ֱ�Ӷ�ȡϵͳ����Ϣģ��
	$s  = "msg";
}



$magic->assign("html_template","admin_".(empty($s)?'user':$s).".html");
$magic->assign("list_name",$list_name);
$magic->assign("list_menu",$list_menu);
$magic->display("admin_control.html.php");
?>