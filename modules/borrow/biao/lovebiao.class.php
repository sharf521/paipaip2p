<?php
/*
 * 	��Ѻ�꣨���ٱ꣩ҵ���߼���
	���괦�� add
	Ͷ�괦�� tender
	���괦�������ں�����������cancel
	��˴��� verify
	����� repay
	���ڴ��� overdue
	
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
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql, $_G;
		
		$user_id = $data["user_id"];
		
		$userPermission = self::getUserPermission($user_id);
		
		if ($userPermission['is_restructuring'] == 1){
			$result = "��Ŀǰ��ծ�������У�ֻ�ܷ�ծ������ꡣ";
			return $result;
		}
		
		$addAudit = parent::checkAddBiaoAudit(array("user_id" => $user_id));
		if ($addAudit!==true){
			return $addAudit;
		}
		
		
		//�Զ���˴���
		if (self::get_auto_verify() == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '�Զ����';
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