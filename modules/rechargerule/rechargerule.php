<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("manager_".$_A['query_type']);//���Ȩ��

$_A['list_purview'] =  array("manager"=>array("�� �� Ա"=>array("manager_list"=>"����Ա�б�","manager_new"=>"��ӹ���Ա","manager_edit"=>"�޸Ĺ���Ա","manager_type"=>"����Ա����","manager_type_order"=>"�޸���������","manager_type_del"=>"ɾ������","manager_type_new"=>"�������","manager_type_edit"=>"�༭����")));//Ȩ��
$_A['list_name'] = "��ֵ�����������";
$_A['list_menu'] = "<a href='{$_A['query_url']}{$_A['site_url']}'>�����б�</a> - <a href='{$_A['query_url']}/new{$_A['site_url']}'>���ӹ���</a>";
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
	if (isset($_POST['user_id']) && $_POST['user_id']!=""){
		userClass::ActionUser(array("user_id"=>$_POST['user_id'],"order"=>$_POST['order']));
		$msg = array("�޸ĳɹ�","",$_A['query_url'].$_A['query_site']);
	
	}else{
		$data['page'] = $_A['page'];
		$data['epage'] = $_A['epage'];
		$data['type'] = 1;
		
		global $mysql;
		
		$sql = "select * from  {recharge_award_rule}  order by id";
		$result = $mysql ->db_fetch_arrays($sql);
		
// 		$pages->set_data(array(
//             'list' => $list,
//             'total' => $result,
//             'page' => $page,
//             'epage' => $epage,
//             'total_page' => $total_page
//         ));
		
		$_A['rule_list'] = $result;
		//$_A['showpage'] = $pages->show(3);
	}
}

/**
 * ��Ӻͱ༭�û�
**/
elseif ($_A['query_type'] == "new" || $_A['query_type'] == "edit"){
	if ($_A['query_type'] == "new" ){
		$_A['list_title'] = "��ӹ���";
	}else{
		$_A['list_title'] = "�޸Ĺ���";
	}
	
	if (isset($_POST['award_rate'])){
		
			if ($_A['query_type'] == "new"){
				
				$min_account = $_POST['min_account'];
				$max_account = $_POST['max_account'];
				$award_rate = $_POST['award_rate'];
				$begin_time = strtotime($_POST['begin_time']." 00:00:00");
				$end_time = strtotime($_POST['end_time']." 23:59:59");
				
				
				$sql = "insert into  {recharge_award_rule}  set `min_account` = {$min_account}, `max_account` = {$max_account}, 
						`award_rate` = {$award_rate}, begin_time = '{$begin_time}', end_time = '{$end_time}'  ";
				
				//liukun add for bug 52 begin
				fb($begin_time, FirePHP::TRACE);
				fb($end_time, FirePHP::TRACE);
				fb($sql, FirePHP::TRACE);
				//liukun add for bug 52 end
				
				$result = $mysql ->db_query($sql);
				
				
					if ($result===true){
						$msg = array("���ӳ�ֵ��������ɹ���");
					}else{
						$msg = array($result);
					}
					
				
			}else{
				$rule_id = $_REQUEST['rule_id'];
				
				$data['min_account'] = $_POST['min_account'];
				$data['max_account'] = $_POST['max_account'];
				$data['award_rate'] = $_POST['award_rate'];
				$data['begin_time'] = strtotime($_POST['begin_time']." 00:00:00");
				$data['end_time'] = strtotime($_POST['end_time']." 23:59:59");
				
				$sql = "update  {recharge_award_rule}  set `id` = {$rule_id}";
				foreach($data as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$sql .= " where `id` = {$rule_id}";
				$result = $mysql->db_query($sql);
				if ($result===false){
					$msg = array($result);
				}else{
					$msg = array("�޸ĳɹ�");
				}
			}
		
	}else{
		
		if ($_A['query_type'] == "edit"){
			
			$rule_id = $_REQUEST['rule_id'];
			$sql = "select * from  {recharge_award_rule}  where id = {$rule_id}";
			$result = $mysql ->db_fetch_array($sql);
			//$result['begin_time']=substr($result['begin_time'], 0, 10); 
			//$result['end_time']=substr($result['end_time'], 0, 10); 
			
			$_A['rule_result'] = $result;
			
		}
	}
}


/**
 * ɾ���û�
**/
elseif ($_A['query_type'] == "del"){
	$rule_id = $_REQUEST['rule_id'];
	$sql = "delete  from  {recharge_award_rule}  where id = {$rule_id}";
	$result =  $mysql->db_query($sql);

	if ($result == false){
		$msg = array("���������������Ա��ϵ");
	}else{
		$msg = array("ɾ���ɹ�");
	}

	$user->add_log($_log,$result);//��¼����
}














?>