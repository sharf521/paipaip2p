<?
/*
 1,�û�����ҳ�棬��Ҫ��ȡ���еĶ�ȣ�������borrow.class.php function GetUserLog

2,�û����� -�������ҳ��
*/
include_once(ROOT_PATH."modules/account/account.class.php");
class amountClass{



	//��Ӷ�ȵļ�¼��user_amountlog��
	//user_id �û�id
	//type ����������
	//amount_type ��ȵ����� ��credit ���ö��  borrow_vouch �����  tender Ͷ�ʶ��
	//account  ��Ȳ����Ľ��
	//account_all �ܵĶ��
	//account_use ���ö��
	//account_nouse �����ö��
	//remark ��ȵļ�¼
	function  AddAmountLog($data){
		global $mysql;
		$user_id = $data['user_id'];
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�
		$sql = "insert into  {user_amountlog}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$result = $mysql->db_query($sql);

		//�����¼��ӳɹ�������Ӧ�ĸı���Ϣ
		if ($result == true){
			$_data["user_id"] = $user_id;
			if ($data['amount_type'] == "credit"){
				$_data["credit"] = $data['account_all'];
				$_data["credit_use"] = $data['account_use'];
				$_data["credit_nouse"] = $data['account_nouse'];
			}
			elseif ($data['amount_type'] == "borrow_vouch"){
				$_data["borrow_vouch"] = $data['account_all'];
				$_data["borrow_vouch_use"] = $data['account_use'];
				$_data["borrow_vouch_nouse"] = $data['account_nouse'];
			}
			elseif ($data['amount_type'] == "tender_vouch"){
				$_data["tender_vouch"] = $data['account_all'];
				$_data["tender_vouch_use"] = $data['account_use'];
				$_data["tender_vouch_nouse"] = $data['account_nouse'];
			}
			//liukun add for bug 48 begin
			elseif ($data['amount_type'] == "restructuring"){
				$_data["restructuring"] = $data['account_all'];
				$_data["restructuring_use"] = $data['account_use'];
				$_data["restructuring_nouse"] = $data['account_nouse'];
			}
			//liukun add for bug 48 end
			$result = self::UpdateAmount($_data);
			return $result;
		}
	}

	//����û��Ķ�ȣ�user_amount��
	//user_id �û�id
	function GetAmountOne($user_id,$type = ""){
		global $mysql;
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�
		$sql = "select * from  {user_amount}  where user_id={$user_id}";
		$result = $mysql ->db_fetch_array($sql);
		if ($result == false){
			self::AddAmount($user_id);//��Ӽ�¼
			return self::GetAmountOne($user_id);
		}

		//add by jackfeng 2011-12-22
		$sql = "select * from  {account}  where user_id={$user_id}";
		$resultA = $mysql ->db_fetch_array($sql);


		if ($type!=""){
			if ($type == "credit"){
				$result['account_all'] = $result["credit"];
				//******************************************************
				/*if($result["credit_use"]>$resultA["total"]){
					$result['account_use'] = $result["credit_use"];
				}else{
				$result['account_use'] = $resultA["total"];
				}*/
				$result['account_use'] = $result["credit_use"];
				//*****************************************************
				$result['account_nouse'] = $result["credit_nouse"];
			}
			elseif ($type == "borrow_vouch"){
				$result['account_all'] = $result["borrow_vouch"];
				$result['account_use'] = $result["borrow_vouch_use"];
				$result['account_nouse'] = $result["borrow_vouch_nouse"];
			}
			elseif ($type == "tender_vouch"){
				$result['account_all'] = $result["tender_vouch"];
				$result['account_use'] = $result["tender_vouch_use"];
				$result['account_nouse'] = $result["tender_vouch_nouse"];
			}
			//liukun add for bug 48 begin
			elseif ($type == "restructuring"){
				$result['account_all'] = $result["restructuring"];
				$result['account_use'] = $result["restructuring_use"];
				$result['account_nouse'] = $result["restructuring_nouse"];
			}
			//liukun add for bug 48 end
		}
		return $result;
	}

	//�����û��Ķ����Ϣ��user_amount��
	//user_id �û�id
	function  UpdateAmount($data){
		global $mysql;
		$user_id = $data['user_id'];
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�

		self::AddAmount($user_id);//��Ӽ�¼

		$sql = "update  {user_amount}  set user_id={$user_id}";
		foreach($data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		$sql .= " where user_id = {$user_id}";
		return $mysql->db_query($sql);
	}



	//����û��Ķ����Ϣ��user_amount��
	//user_id �û�id
	function  AddAmount($user_id){
		global $mysql,$_G;
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�

		$credit = isset($_G['system']['con_user_amount'])?$_G['system']['con_user_amount']:2000;//��ʼ����Ͷ��
		$sql = "select * from  {user_amount}  where user_id={$user_id}";
		$result = $mysql ->db_fetch_array($sql);
		if ($result == false){
			$sql = "insert into  {user_amount}  set  user_id = {$user_id},credit ={$credit},credit_use ={$credit} ";
			return $mysql->db_query($sql);
		}
		return 1;
	}


	/**
	 * ����û��Ķ�����루user_amountapply��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function AddAmountApply($data = array()){
		global $mysql;
		$user_id = $data['user_id'];
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�

		$add_amount = $data['account'];
		//liukun add for bug ��������ʱ�����Ҫ֧����Ҫ���ж��û���û�п���������еĻ���Ҫ�ȶ���
		$account_result =  accountClass::GetOne(array("user_id"=>$data['user_id']));//��ȡ��ǰ�û������
		$sql = "select * from  {user_amount_type}  where amount_type_name='{$data['type']}'";
		$amount_type_result = $mysql ->db_fetch_array($sql);

		//��ʹ�þ�ֵ��ʽ1�����ľ�ֵ�껹��ռ��״̬��ָû�л�����߳�����ʱ���������뵣�����
		if($account_result['jinbiao_money'] > 0 && $data['type']=="tender_vouch"){
			$msg="�����о�ֵ��û�г�����ϣ���������Ͷ�ʵ�����ȡ�";
			return $msg;
		}


		if ($amount_type_result['fee_rate'] > 0){

			$amount_fee =  round($add_amount * $amount_type_result['fee_rate'], 2);


			if($account_result['use_money'] < $amount_fee){
				$msg="�������㣬�޷����롣";
				return $msg;
			}
		}

		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{

			if ($amount_type_result['fee_rate'] > 0){
					
				$amount_fee =  round($add_amount * $amount_type_result['fee_rate'], 2);

				$log['user_id'] = $user_id;
				$log['type'] = "amount_fee_frost";
				$log['money'] = $amount_fee;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']-$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']+$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "������붳�������";

				$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
				if ($transaction_result !==true){
					throw new Exception();
				}
			}


			//��ȡ������
			$result = self::GetAmountOne($user_id);
			if ($data['type'] == "credit"){
				$data["account_old"] = $result['credit'];
			}
			elseif ($data['type'] == "borrow_vouch"){
				$data["account_old"] = $result['borrow_vouch'];
			}
			elseif ($data['type'] == "tender_vouch"){
				$data["account_old"] = $result['tender_vouch'];
			}
			//liukun add for bug 48 begin
			elseif ($data['type'] == "restructuring"){
				$data["account_old"] = $result['restructuring'];
			}
			//liukun add for bug 48 end
			$data["amount_frost_fee"] = $amount_fee;
			$sql = "insert into  {user_amountapply}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
			foreach($data as $key => $value){
				$sql .= ",`$key` = '$value'";
			}
			$transaction_result = $mysql->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}
		}

		catch (Exception $e){
			//���뱣֤���в��ɽ��ܵĴ��󶼷����쳣����ִ���˻ع�
			$mysql->db_query("rollback");
		}
		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
			return true;
		}else{
			$mysql->db_query("rollback");
			return $transaction_result;
		}
	}

	//����û��������¼��user_amountapply��
	//id id
	//user_id �û�id
	function GetAmountApplyOne($data){
		global $mysql;
		$sql = " where 1=1 ";
		if (isset($data['user_id'])){
			$sql .= " and p1.user_id={$data['user_id']}  ";
		}
		if (isset($data['id'])){
			$sql .= " and p1.id={$data['id']} ";
		}
		if (isset($data['type'])){
			$sql .= " and p1.type='{$data['type']}' ";
		}
		$sql = "select p1.*,p2.username from  {user_amountapply}  as  p1 left join  {user}  as p2 on p1.user_id=p2.user_id " . $sql ." order by p1.id desc";
		$result = $mysql ->db_fetch_array($sql);

		return $result;
	}

	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetAmountList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1 ";

		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status = {$data['status']}";
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p1.user_id = {$data['user_id']}";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%' ";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type like '%{$data['type']}%' ";
		}
		$_select = 'p1.*,p2.username';
		$sql = "select SELECT from {user_amount} as p1
		left join {user} as p2 on p1.user_id=p2.user_id
		$_sql ORDER LIMIT";
			
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.`order` desc,p1.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));
		$list = $list?$list:array();


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}



	function CheckAmountApply($data){
		global $mysql,$_G;

		$user_id = $data['user_id'];
		if (!isset($user_id)) return -1;//����û������ڣ��򷵻�

		$sql = "select * from  {user_amount_type}  where amount_type_name='{$data['type']}'";
		$amount_type_result = $mysql ->db_fetch_array($sql);

// 		$result = self::GetAmountApplyOne(array("id",$data['id']));//��ȡ��ȵ���Ϣ�����Ƿ��Ѿ�������
		$result = self::GetAmountApplyOne(array("id"=>$data['id']));//��ȡ��ȵ���Ϣ�����Ƿ��Ѿ�������
		$amountapply = $result['account'];
		$amount_fee_frost = $result["amount_frost_fee"];

		if ($result['status']!=2){
			return "�˶���Ѿ���˹����벻Ҫ�ظ�������";
		}

		//liukun add for bug 472 begin
		$mysql->db_query("start transaction");
		//liukun add for bug 472 end
		$transaction_result = true;
		try{
			//�����Ƿ�����ͨ����Ҫ�ⶳ����ʱ����ķ���

			$amount_fee =  $amount_fee_frost;
			if ($amount_fee_frost > 0){
				$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
				$log['user_id'] = $user_id;
				$log['type'] = "amount_fee_unfrost";
				$log['money'] = $amount_fee;
				$log['total'] = $account_result['total'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money']-$log['money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "�ⶳ������붳�������";

				$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
				if ($transaction_result !==true){
					throw new Exception();
				}
			}
			if ($data['status']==1){

				//��Ӷ�ȼ�¼
				$_result = self::GetAmountOne($user_id,$data["type"]);

				//liukun add for bug 199 begin

				//��������ӵĶ��
				$add_amount = $data['account'] - $_result['account_all'];
				//��ȡ�������Ѻͳ�ʼ�������

				$_data["user_id"] = $user_id;
				$_data["type"] = "apply_add";
				$_data["amount_type"] = $data['type'];
				$_data["account"] = $data['account'];
				$_data["account_all"] = $data['account'];
				$_data["account_use"] = $data['account'] - $_result['account_nouse'];
				$_data["account_nouse"] = $_result['account_nouse'];//type ����������
				$_data["remark"] = "���������ͨ��";//type ����������
				$transaction_result = self::AddAmountLog($_data);
				if ($transaction_result !==true){
					throw new Exception();
				}

				//����ͨ��������ͨ�����ٶ�ȣ�����ķ���ȫ���۳�
				if ($amount_fee_frost > 0){
					$account_result =  accountClass::GetOne(array("user_id"=>$user_id));//��ȡ��ǰ�û������
					$log['user_id'] = $user_id;
					$log['type'] = "amount_fee";
					$log['money'] = $amount_fee_frost;
					$log['total'] = $account_result['total']-$log['money'];
					$log['use_money'] =  $account_result['use_money']-$log['money'];
					$log['no_use_money'] =  $account_result['no_use_money'];
					$log['collection'] =  $account_result['collection'];
					$log['to_user'] = 0;
					$log['remark'] = "��������շ�";

					$transaction_result = accountClass::AddLog($log);//��Ӽ�¼
					if ($transaction_result !==true){
						throw new Exception();
					}
				}
				//�����������ӣ������������0�Ļ���Ҫ���Ӷ���
				if ($add_amount > 0 ){

					if($amount_type_result['frost_rate'] > 0){
						$_result = self::GetAmountOne($user_id,$data["type"]);

						$_data["user_id"] = $user_id;
						$_data["type"] = "amount_frost";
						$_data["amount_type"] = $data['type'];
						$_data["account"] = round($add_amount * $amount_type_result['frost_rate'], 2) ;
						$_data["account_all"] = $_result['account_all'];
						$_data["account_use"] = $_result['account_use'] - $_data["account"];
						$_data["account_nouse"] = $_result['account_nouse'] + $_data["account"];//type ����������
						$_data["remark"] = "�����Ȳ��ֶ���";//type ����������
						$transaction_result = self::AddAmountLog($_data);
						if ($transaction_result !==true){
							throw new Exception();
						}
							
					}
				}

				//liukun add for bug 199 end
			}


			//������Ϣ
			$sql = "update  {user_amountapply}  set status={$data['status']},verify_time='".time()."',verify_user=".$_G['user_id'].",verify_remark='{$data['verify_remark']}',account_new='{$data['account']}' where id = {$data['id']}";
			$transaction_result = $mysql ->db_query($sql);
			if ($transaction_result !==true){
				throw new Exception();
			}

		}
		catch(Exception $e){
			$mysql->db_query("rollback");
		}

		//liukun add for bug 472 begin
		if($transaction_result===true){
			$mysql->db_query("commit");
			return true;
		}else{
			$mysql->db_query("rollback");
			return $transaction_result;
		}
		//liukun add for bug 472 end

	}


	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetAmountApplyList($data = array()){
		global $mysql;

		$page = empty($data['page'])?1:$data['page'];
		$epage = empty($data['epage'])?10:$data['epage'];

		$_sql = "where 1=1 ";

		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and p1.status = {$data['status']}";
		}
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and p1.user_id = {$data['user_id']}";
		}
		if (isset($data['username']) && $data['username']!=""){
			$_sql .= " and p2.username like '%{$data['username']}%' ";
		}
		if (isset($data['type']) && $data['type']!=""){
			$_sql .= " and p1.type like '%{$data['type']}%' ";
		}
		//liukun add for site_id search begin
		if (isset($data['areaid']) && $data['areaid']!="0"){
			$_sql .= " and p2.areaid = {$data['areaid']} ";
		}
		//liukun add for biao_type search begin

		$_select = 'p1.*,p2.username';
		$sql = "select SELECT from {user_amountapply} as p1
		left join {user} as p2 on p1.user_id=p2.user_id
		$_sql ORDER LIMIT";

			
		//�Ƿ���ʾȫ������Ϣ
		if (isset($data['limit']) ){
			$_limit = "";
			if ($data['limit'] != "all"){
				$_limit = "  limit ".$data['limit'];
			}
			return $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select,  'order by p1.`order` desc,p1.id desc', $_limit), $sql));
		}

		$row = $mysql->db_fetch_array(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array('count(1) as num', '', ''), $sql));

		$total = $row['num'];
		$total_page = ceil($total / $epage);
		$index = $epage * ($page - 1);
		$limit = " limit {$index}, {$epage}";

		$list = $mysql->db_fetch_arrays(str_replace(array('SELECT', 'ORDER', 'LIMIT'), array($_select, 'order by p1.id desc', $limit), $sql));
		$list = $list?$list:array();


		return array(
				'list' => $list,
				'total' => $total,
				'page' => $page,
				'epage' => $epage,
				'total_page' => $total_page
		);

	}

	//�����û��Ķ����Ϣ��user_amount��
	//user_id �û�id
	function  UpdateAmountApply($data){
		global $mysql;
		$id = $data['id'];
		if (!isset($id)) return -1;//����û������ڣ��򷵻�

		$subsite_remark = $data['subsite_remark'];
		$sql = "update  {user_amountapply}  set id={$id}, subsite_remark='{$subsite_remark}'";
		$sql .= " where id = {$id}";
		return $mysql->db_query($sql);
	}

	

}
?>