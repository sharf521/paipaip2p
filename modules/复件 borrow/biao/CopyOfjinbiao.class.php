<?php
/*
 * 	��ֵ��ҵ���߼���
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
require_once(ROOT_PATH."modules/remind/remind.class.php");

//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end

class jinbiaoClass extends biaotypeClass{
	protected $biao_type = "jin";
	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql;

		$user_id = $data["user_id"];

		$userPermission = self::getUserPermission($user_id);

		if ($userPermission['is_restructuring'] == 1){
			$result = "��Ŀǰ��ծ�������У�ֻ�ܷ�ծ������ꡣ";
			return $result;
		}

		$user_data['user_id'] = $data['user_id'];

		$jinAmount = accountClass::getJinAmount($user_data);

		//��������ڿ������ö��
		if (($data['account'] > $jinAmount)){
			$result = "���þ��ʲ����㡣";
			return $result;
		}


		//�Զ���˴���
		$auto_verify = self::get_auto_verify();
		if ($auto_verify == 1){
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
		
		if ($result && $auto_verify){
			$auto['id']=$newid;
			$auto['user_id']=$data['user_id'];
			$auto['total_jie']=$data['account'];
			$auto['zuishao_jie']=$data['lowest_account'];
			$result = borrowClass::auto_borrow($auto);
			if(!$result){
				return $result;
			}
		}

		//liukun add for bug 88 begin
		if ($result){
			$sql = " update {account} set nocash_money=nocash_money+'{$data['account']}' where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
		}
		//liukun add for bug 88 end
			
		return $result;
	}


	/**
	 * ���괦��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function cancel($data = array()){
		global $mysql;

		//liukun add for bug 88 begin

		$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}' where user_id='{$data['user_id']}'";
		$result = $mysql ->db_query($sql);

		//liukun add for bug 88 end
		return $result;
	}

	/**
	 * ����������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function verify($data = array()){
		global $mysql;
		
		$result = true;
		//����ʧ�ܣ���Ӧ�������ֶ�ȿ۳�
		if($data['status'] == 2){
			$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}' where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
		}
	
	
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
		
		$result = true;
		//����ʧ�ܣ���Ӧ�������ֶ�ȿ۳�
		if($data['status'] == 4){
			$sql = " update {account} set nocash_money=nocash_money-'{$data['account']}' where user_id='{$data['user_id']}'";
			$result = $mysql ->db_query($sql);
		}
	
	
		return $result;
	}
	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function repay($data = array()){
		global $mysql;

		$borrow_userid=$data["borrow_userid"];

		
		//��������һ�ڻ��Ҫ��֤��ȫ�۳���������൱�ķ�ȡ�ֶ��,ֻҪ���ڳ���1�ڲ���Ҫ�����������Ե�ǰ�������Ϊ0ʱ������Ҫ�ж�
		/*
			$capital = $borrow_repayment_result['capital'];
		if ($borrow_repayment_result['order'] > 0 &&  $borrow_repayment_result['order']+1 == $borrow_repayment_result['time_limit']){
		$sql = "select sum(capital) capital_yes from  {borrow_repayment}   where borrow_id={$borrow_repayment_result['borrow_id']} and `order` < {$borrow_repayment_result['order']}";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
		$capital = $borrow_repayment_result['borrow_account'] - $value['capital_yes'];
		}
		}
		*/
		//TODO �ָ����ֶ�ȵ��㷨
// 		$nocash_amount = round(($data['borrow_account']/$data['time_limit']),2);
		$nocash_amount = $data['capital'];

		$sql = "update {account}  set nocash_money = nocash_money -  {$nocash_amount} where user_id = {$borrow_userid}";
		$result = $mysql->db_query($sql);

		return $result;
	}





}
?>