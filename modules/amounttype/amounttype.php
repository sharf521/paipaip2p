<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("manager_".$_A['query_type']);//���Ȩ��

$_A['list_purview'] =  array("manager"=>array("�� �� Ա"=>array("manager_list"=>"����Ա�б�","manager_new"=>"��ӹ���Ա","manager_edit"=>"�޸Ĺ���Ա","manager_type"=>"����Ա����","manager_type_order"=>"�޸���������","manager_type_del"=>"ɾ������","manager_type_new"=>"�������","manager_type_edit"=>"�༭����")));//Ȩ��
$_A['list_name'] = "������͹���";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>��������б�</a>";
$list_table ="";

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

/**
 * ����Ա�б�
**/
if ($_A['query_type'] == "list"){
	$_A['list_title'] = "�б�";

	$data['page'] = $_A['page'];
	$data['epage'] = $_A['epage'];
	$data['type'] = 1;

	global $mysql;

	$sql = "select * from  {user_amount_type}  order by id";
	$result = $mysql ->db_fetch_arrays($sql);

	// 		$pages->set_data(array(
	//             'list' => $list,
	//             'total' => $result,
	//             'page' => $page,
	//             'epage' => $epage,
	//             'total_page' => $total_page
	//         ));

	$_A['amount_type_list'] = $result;
	//$_A['showpage'] = $pages->show(3);

}

/**
 * ��Ӻͱ༭�û�
**/
elseif ($_A['query_type'] == "edit"){

	$_A['list_title'] = "�޸Ķ������";


	if (isset($_POST['type_id'])){

			
		$type_id = $_REQUEST['type_id'];

		$data['amount_type_name'] = $_POST['amount_type_name'];
		$data['fee_rate'] = $_POST['fee_rate'];
		$data['frost_rate'] = $_POST['frost_rate'];
			
		$data['show_name'] = $_POST['show_name'];

		$sql = "update  {user_amount_type}  set `id` = {$type_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where `id` = {$type_id}";
		$result = $mysql->db_query($sql);
		if ($result===false){
			$msg = array($result);
		}else{
			$msg = array("�޸ĳɹ�");
		}
			

	}else{

		if ($_A['query_type'] == "edit"){
				
			$type_id = $_REQUEST['type_id'];
			$sql = "select * from  {user_amount_type}  where id = {$type_id}";
			$result = $mysql ->db_fetch_array($sql);
				
				
			$_A['amount_type_result'] = $result;
				
		}
	}
}

















?>