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


class safetybiaoClass extends biaotypeClass{
	protected $biao_type = "safety";

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
		$auto_verify = self::get_auto_verify();
		if ($auto_verify == 1){
			$data['status'] = 1;
			$data['verify_user'] = 1;
			$data['verify_remark'] = '�Զ����';
			$data['verify_time'] = time();
		}
		if($data['isday']!=1)
		{
			$data['style']=2;//����ȫ���  ����ȫ��� ������������
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
	 * �������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function full_verify($data = array()){
		global $mysql;
	
		$borrow_result = $data;
		$result = true;
		//�������ɹ����һ��ʽ����ǰ���Ҫ����һ��
		if($borrow_result['status'] == 3 && $borrow_result['style'] == 4){

	
			$sql="select p1.id from  {borrow_repayment}  as p1  where borrow_id = {$borrow_result['id']} and `order` = 0";
			$result = $mysql->db_fetch_array($sql);
	
			$repay_data['id'] = $result['id'];
			$repay_data['user_id'] = $borrow_result['user_id'];
			//TODO repay�ﱾ����һ���������������������ʼʱ�������ǰ��������ύ������������Ա�������
			$result = borrowClass::Repay($repay_data);
		}
	
		return $result;
	}
	


}
?>