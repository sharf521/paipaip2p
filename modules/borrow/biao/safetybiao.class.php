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


class safetybiaoClass extends biaotypeClass{
	protected $biao_type = "safety";

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
		$auto_verify = self::get_auto_verify();
		if ($auto_verify == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '自动审核';
			$data['verify_time'] = time();
		}
		if($data['isday']!=1)
		{
			$data['style']=2;//到期全额还款  到期全额还款 天标计算有问题
		}	
		$sql = "insert into  {borrow}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);
		
		if(!$result){
			return $result;
		}
		
		
		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;
				
		

		
		return $result;
	}


	/**
	 * 满标审核
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function full_verify($data = array()){
		global $mysql;
	
		$borrow_result = $data;
		$result = true;
		//如果复审成功，且还款方式是提前还款，要还第一期
		if($borrow_result['status'] == 3 && $borrow_result['style'] == 4){

	
			$sql="select p1.id from  {borrow_repayment}  as p1  where borrow_id = {$borrow_result['id']} and `order` = 0";
			$result = $mysql->db_fetch_array($sql);
	
			$repay_data['id'] = $result['id'];
			$repay_data['user_id'] = $borrow_result['user_id'];
			//TODO repay里本身是一个完整的事务，这里的事务开始时，会造成前面的事务被提交，事务的完整性被打破了
			$result = borrowClass::Repay($repay_data);
		}
	
		return $result;
	}
	


}
?>