<?php
//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class wsaccountClass{

	const ERROR = '操作有误，请不要乱操作';

	function addWSlog($data = array()){
		global $mysql;
		$user_id = isset($data['user_id'])?$data['user_id']:"";
		if (empty($user_id)) return self::ERROR;
		$ws_log['user_id']=$data['user_id'];
		$ws_log['account']=$data['account'];
		$ws_log['type']=$data['type'];
		$ws_log['direction']=$data['direction'];
		$ws_log['remark']=$data['remark'];
		$sql = "insert into  {account_ws_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($ws_log as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);

		if (!$result){
			return $result;
		}

		//0表示是出款，1表示入款
		$user_id = $data['user_id'];
		if ($data['direction']==0){
			$sql = "update  {account}  set  ws_out_money = ws_out_money + {$data['account']} where user_id = {$user_id}";

		}else{
			$sql = "update  {account}  set  ws_in_money = ws_in_money + {$data['account']} where user_id = {$user_id}";

		}

		$result = $mysql->db_query($sql);

		return $result;
	}

}

?>