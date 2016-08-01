<?php
/*
 * 	抵押标（快速标）业务逻辑类
	发标处理 add
	投标处理 tender
	流标处理（含到期和主动撤消）cancel
	审核处理 verify
	还款处理 repay
	逾期处理 overdue
	
*/

include_once(ROOT_PATH."modules/borrow/biao/biaotype.class.php");
include_once(ROOT_PATH."modules/borrow/borrow.class.php");
include_once(ROOT_PATH."modules/account/account.class.php");


//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class lovebiaoClass extends biaotypeClass{
	protected $biao_type = "love";

	/**
	 * 发标
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;
		
		$user_id = $data["user_id"];
		
		$userPermission = self::getUserPermission($user_id);
		
		if ($userPermission['is_restructuring'] == 1){
			$result = "你目前是债务重组中，只能发债务重组标。";
			return $result;
		}
		
		$addAudit = parent::checkAddBiaoAudit(array("user_id" => $user_id));
		if ($addAudit!==true){
			return $addAudit;
		}
		
		
		//自动审核处理
		if (self::get_auto_verify() == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '自动审核';
			$data['verify_time'] = time();
		}
		
		$sql = "insert into  {borrow}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);
		
		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;
							
		return $result;
		
		
	}


	
	
	


}
?>