<?php
/*
 * 	��ת������ҵ���߼���
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

class circulationbiaoClass extends biaotypeClass{
	protected $biao_type = "circulation";


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
		
		$circulation_data['account_circu'] = $data['account'];
		$circulation_data['duration'] = $data['time_limit'];
		$circulation_data['begin_apr'] = $data['apr'];
		$circulation_data['begin_month_num'] = $data['begin_month_num'];
		$circulation_data['increase_month_num'] = $data['increase_month_num'];
		$circulation_data['increase_apr'] = $data['increase_apr'];
		$circulation_data['unit_price'] = $data['unit_price'];
		$circulation_data['min_unit_num'] = $data['min_unit_num'];
		$circulation_data['max_unit_num'] = $data['max_unit_num'];
		$circulation_data['valid_unit_num'] = $circulation_data['account_circu'] / $circulation_data['unit_price'];
		$circulation_data['total_unit_num'] = $circulation_data['valid_unit_num'];
		$circulation_data['circulated_num'] = 0;

		$circulation_data['st'] = intval($data['st']);
		unset($data['st']);

		//ע������data�е����ݣ���Ϊ��Щ���ݲ�ֱ�Ӵ���dw_borrow�У���ע�������insert dw_borrowʱ��������

		unset($data['begin_month_num']);
		unset($data['increase_month_num']);
		unset($data['increase_apr']);
		unset($data['unit_price']);
		unset($data['min_unit_num']);
		unset($data['max_unit_num']);
		

		//����ת��Ļ��ʽֱ��ֻ��Ϊ��������Ͱ��»�Ϣ�����ڻ���
		if ($data['style'] == 0){
			$result = "��ת�겻֧�ֵȶϢ���ʽ��";
			return $result;
		}
		$data['valid_time'] = $data['time_limit'] * 30;

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

		if (!result){
			$result = "��ת�귢��ʧ�ܡ�";
			return $result;
		}

		$newid = $mysql->db_insert_id();
		$_G['new_borrow_id'] = $newid;

		$circulation_data['borrow_id'] = $newid;
		//liukun add for bug 52 begin
		fb($circulation_data, FirePHP::TRACE);
		//liukun add for bug 52 end

		$sql = "insert into  {circulation}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
		foreach($circulation_data as $key => $value){
			$sql .= ",`$key` = '$value'";
		}
		
		//liukun add for bug 52 begin
		fb($sql, FirePHP::TRACE);
		//liukun add for bug 52 end
		$result = $mysql->db_query($sql);
		return $result;
	}


	/**
	 * ��ñ�ĸ�����Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function getAdditionalInfo($data = array()){
		global $mysql;

		$sql = "select * from  {circulation}  where borrow_id={$data['borrow_id']}";
		$result = $mysql ->db_fetch_array($sql);

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
		$borrow_id = $data['id'];

		$current_time = time();
		$total_account = 0;
		$total_frost_account = 0;
		$seller_id = $data['user_id'];

		$borrow_result = borrowClass::GetOne(array("id"=>$borrow_id));//��ȡ����ĵ�����Ϣ
		$borrow_url = "<a href=\'/invest/a{$borrow_result['id']}.html\' target=_blank>{$borrow_result['name']}</a>";
		//��ȡ�����
		$interest_fee_rate = self::get_interest_fee_rate();

		$sql = "select cs.*, bw.user_id as seller_id from dw_circulation_buy_serial cs, dw_circulation cn, dw_borrow bw

		where cs.circulation_id = cn.id and cn.borrow_id = bw.id and bw.id = {$borrow_id} and cs.buyback = 0";
		$result = $mysql->db_fetch_arrays($sql);

		foreach ($result as $key => $value){
			$buy_id = $value['id'];
			$buyer_id = $value['buyer_id'];

			$circulation_id = $value['circulation_id'];
			$buy_type = $value['buy_type'];

			$interest = $value['interest'];
			$account_money = $value['capital'];

			$total_account += $account_money + $interest;
			$total_frost_account += $value['frost_account'];

			//����Ч���ʽ�ֱ�ӽ��н��ף�����Ͷ�����˻����۳��������˻�

			if ($buy_type == "award"){
				//����Ͷ��õ�����Ϣ�������ã�ֻ���ۼƵ���Ϣ��
				//liukun add for bug 174 begin
				$sql = "update  {account}  set `use_award` = `use_award` + {$account_money}";
				$sql .= ", award_interest = award_interest + {$interest}";
				$sql .= " where user_id=$buyer_id";
				//liukun add for bug 174 end

				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
				//����award��־
				//Ͷ�ʱ�����־
				$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
				$award_log['user_id'] = $buyer_id;
				$award_log['type'] = "buyback_circulation";
				$award_log['award'] = $account_money;
				$award_log['remark'] = "�ɹ��ع���ת���տ����";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
				//liukun add for bug 174 begin
				//��Ϣ��־
				$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
				$award_log['user_id'] = $buyer_id;
				$award_log['type'] = "buyback_circulation_interest";
				$award_log['award'] = $interest;
				$award_log['remark'] = "�ɹ��ع���ת���տ��Ϣ��";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
				//liukun add for bug 174 begin
				$interest_fee = round($interest * $interest_fee_rate, 2);
				$sql = "update  {account}  set  ";
				$sql .= " award_interest = award_interest - {$interest_fee}";
				$sql .= " where user_id=$buyer_id";
				//liukun add for bug 174 end

				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}

				$award_log['user_id'] = $buyer_id;
				$award_log['type'] = "tender_mange";
				$award_log['award'] =  -$interest_fee;
				$award_log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
				$sql = "insert into  {recharge_award_log}  set `addtime` = '".time()."',`addip` = '".ip_address()."'";
				foreach($award_log as $key => $value){
					$sql .= ",`$key` = '$value'";
				}
				$result = $mysql->db_query($sql);
				if ($result != true){
					return $result;
				}
				//liukun add for bug 174 end

			}
			else{
				
				//liukun add for bug 223 begin
				$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
				$log['user_id'] = $buyer_id;
				$log['type'] = "buyback_circulation_collection";
				$log['money'] = $account_money + $interest;
				$log['total'] = $account_result['total']-$log['money'];
				$log['use_money'] =  $account_result['use_money'];
				$log['no_use_money'] =  $account_result['no_use_money'];
				$log['collection'] =  $account_result['collection']-$log['money'];
				$log['to_user'] = $seller_id;
				$log['remark'] = "�ɹ��ع���ת����ٴ���";
				$result = accountClass::AddLog($log);//��Ӽ�¼
				if ($result != true){
					return $result;
				}
				//liukun add for bug 223 end
				
				//����Ч���ʽ�ֱ�ӽ��н��ף�����Ͷ�����˻����۳��������˻�
				$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));//��ȡ��ǰ�û������
				$log['user_id'] = $buyer_id;
				$log['type'] = "buyback_circulation";
				$log['money'] = $account_money + $interest;
				$log['total'] = $account_result['total']+$log['money'];
				$log['use_money'] =  $account_result['use_money']+$log['money'];
				$log['no_use_money'] =  $account_result['no_use_money'];
				$log['collection'] =  $account_result['collection'];
				$log['to_user'] = $seller_id;
				$log['remark'] = "�ɹ��ع���ת���տ����+��Ϣ��";
				$result = accountClass::AddLog($log);//��Ӽ�¼
				if ($result != true){
					return $result;
				}


				$interest_fee = round($interest * $interest_fee_rate, 2);
				$account_result =  accountClass::GetOne(array("user_id"=>$buyer_id));
				$log['user_id'] = $buyer_id;
				$log['type'] = "tender_mange";//
				$log['money'] = $interest_fee;
				$log['total'] = $account_result['total']-$log['money'];
				$log['use_money'] = $account_result['use_money']-$log['money'];
				$log['no_use_money'] = $account_result['no_use_money'];
				$log['collection'] = $account_result['collection'];
				$log['to_user'] = 0;
				$log['remark'] = "�û��ɹ�����۳���Ϣ�Ĺ����";
				$result = accountClass::AddLog($log);
				if ($result != true){
					return $result;
				}
			}

			//���ûع��ɹ����
			$sql = "update  {circulation_buy_serial}  set `buyback` = 1, `buyback_time` = '".time()."'";
			$sql .= " where id={$buy_id}";

			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
		}

		if ($total_account > 0){
			$sql = "update  {circulation}  set `valid_unit_num` = `total_unit_num`";
			$sql .= " where borrow_id={$borrow_id}";

			$result = $mysql->db_query($sql);
			if ($result != true){
				return $result;
			}
			//�۳������˵��ʽ𣨱���+��Ϣ��
			$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));//��ȡ��ǰ�û������
			$log['user_id'] = $seller_id;
			$log['type'] = "accept_buyback_circulation";
			$log['money'] = $total_account;
			$log['total'] = $account_result['total']-$log['money'];
			$log['use_money'] =  $account_result['use_money']-$log['money'];
			$log['no_use_money'] =  $account_result['no_use_money'];
			$log['collection'] =  $account_result['collection'];
			$log['to_user'] = 0;
			$log['remark'] = "�ɹ����ܻع���ת�����븶�����+��Ϣ��";

			$result = accountClass::AddLog($log);//��Ӽ�¼
			if ($result != true){
				return $result;
			}
		}

		$account_result =  accountClass::GetOne(array("user_id"=>$seller_id));
		$account_log['user_id'] =$seller_id;
		$account_log['type'] = "borrow_frost";
		$account_log['money'] = $total_frost_account;
		$account_log['total'] =$account_result['total'];
		$account_log['use_money'] = $account_result['use_money']+$account_log['money'];
		$account_log['no_use_money'] = $account_result['no_use_money']-$account_log['money'];
		$account_log['collection'] = $account_result['collection'];
		$account_log['to_user'] = "0";
		$account_log['remark'] = "��[{$borrow_url}]��֤��Ľⶳ";
		$result = accountClass::AddLog($account_log);
			

		return $result;
	}
}
?>