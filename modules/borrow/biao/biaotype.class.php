<?php
/*
 * 	�����ҵ���߼���
���괦�� add
�������� vouch 
Ͷ�괦�� tender
���괦�������ں�����������cancel
��˴��� verify
������˴��� full_verify
����� repay
���ڴ��� late_repay

*/
//liukun add for bug 52 begin
$firePHPEnable=TRUE;
if ($firePHPEnable){
	require_once('modules/FirePHPCore/FirePHP.class.php');
	require_once('modules/FirePHPCore/fb.php');
	ob_start();

	$firephp = FirePHP::getInstance(true);
}
//liukun add for bug 52 end
class biaotypeClass{
	protected $biao_type = "";
	
	function checkAddBiaoAudit($data = array()){
		global $mysql;
		
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$biaotype_info = $mysql ->db_fetch_array($sql);
		
		$user_id = $data["user_id"];
		
		$sql = "select ur.*, uc.vip_status from  {user}  as ur,  {user_cache}  as uc where ur.user_id={$user_id} and ur.user_id = uc.user_id ";
		$user_result = $mysql ->db_fetch_array($sql);
		
		$user_audit_result = userClass::GetCreditAudit(array("user_id"=>$user_id));
		$user_result['credit_status'] = $user_audit_result['status'];
		
		if($biaotype_info['biao_real_status'] == 1 && $user_result['real_status']!=1){
			$result = "�������꣬�������ʵ����֤��";
			return $result;
		}
		
		if($biaotype_info['biao_email_status'] == 1 && $user_result['email_status']!=1){
			$result = "�������꣬�������������֤��";
			return $result;
		}
		
		if($biaotype_info['biao_phone_status'] == 1 && $user_result['phone_status']!=1){
			$result = "�������꣬������ɵ绰��֤��";
			return $result;
		}
		
		if($biaotype_info['biao_video_status'] == 1 && $user_result['video_status']!=1){
			$result = "�������꣬���������Ƶ��֤��";
			return $result;
		}
		
		if($biaotype_info['biao_scene_status'] == 1 && $user_result['scene_status']!=1){
			$result = "�������꣬��������ֳ���֤��";
			return $result;
		}
		
		if($biaotype_info['biao_avatar_status'] == 1 && $user_result['avatar_status']!=1){
			$result = "�������꣬�����ϴ�ͷ��";
			return $result;
		}
		
		if($biaotype_info['biao_vip_status'] == 1 && $user_result['vip_status']!=1){
			$result = "�������꣬������VIP��Ա��";
			return $result;
		}
	
		if($biaotype_info['biao_credit_status'] == 1 && $user_result['credit_status']!=1){
			$result = "�������꣬�������������֤��";
			return $result;
		}
		
		return true;
	}
	
	function get_auto_verify(){
		global $mysql;
		
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
		
		return $result['auto_verify'];
		
	}
	function get_auto_full_verify(){
		global $mysql;
		
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
		
		return $result['auto_full_verify'];
		
	}
	
	function getUserPermission($user_id){
		global $mysql;
		
		$sql = "select * from  {user}  where user_id={$user_id}";
		$result = $mysql ->db_fetch_array($sql);
		
		return $result;
	}
	
	function get_borrow_fee_rate(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}' limit 1";
		
		$result = $mysql ->db_fetch_array($sql);
		$fee_rate['borrow_fee_rate_start'] = $result['borrow_fee_rate_start'];
		$fee_rate['borrow_fee_rate_start_month_num'] = $result['borrow_fee_rate_start_month_num'];
		$fee_rate['borrow_fee_rate'] = $result['borrow_fee_rate'];
		$fee_rate['borrow_day_fee_rate'] = $result['borrow_day_fee_rate'];
		
		return $fee_rate;
	}
	
	function get_interest_fee_rate(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
	
		return $result['interest_fee_rate'];
	}
	
	function get_frost_rate(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
	
		return $result['frost_rate'];
	}
	
	function get_advance(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
		
		$advance['advance_time'] = $result['advance_time'];
		$advance['advance_scope'] = $result['advance_scope'];
		$advance['advance_rate'] = $result['advance_rate'];
		$advance['advance_vip_scope'] = $result['advance_vip_scope'];
		$advance['advance_vip_rate'] = $result['advance_vip_rate'];
	
		return $advance;
	}
	
	function get_late_interest_rate(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
		
		$late_interest_rate['late_interest_rate'] = $result['late_interest_rate'];
		$late_interest_rate['late_customer_interest_rate'] = $result['late_customer_interest_rate'];
		
		return $late_interest_rate;
	}

	function get_max_tender_times(){
		global $mysql;
	
		$sql = "select * from  {biao_type}  where biao_type_name='{$this->biao_type}'";
		$result = $mysql ->db_fetch_array($sql);
	
		return $result['max_tender_times'];
	}
	
	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function add($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function vouch($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * �û�Ͷ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function tender($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ���괦��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function cancel($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ����������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function verify($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * �������
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function full_verify($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ����
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function repay($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ���ڴ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function late_repay($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ��ñ�ĸ�����Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function getAdditionalInfo($data = array()){
		global $mysql;
	
	
		return true;
	}
	
	/**
	 * ���������Ϣ
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function getLateInterest($data = array()){
		global $mysql;

		$loan_account = $data['capital'];
		
		if ($loan_account == 0){
			$loan_account = $data['repayment_account'];
		}

		$biao_type = $data['biao_type'];

		$late_interest_rate = self::get_late_interest_rate();

		$late_rate=$late_interest_rate['late_interest_rate'];

		$now_time = get_mktime(date("Y-m-d",time()));
// 		$repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
		$repayment_time = $data['repayment_time'];
// 		$late_days = ($now_time - $repayment_time)/(60*60*24);
// 		$_late_days = explode(".",$late_days);
// 		$late_days = ($_late_days[0]<0)?0:$_late_days[0];

		$late_days = ceil((time() - $repayment_time)/(60*60*24));
		
		$late_days = ($late_days<0)?0:$late_days;
		
		$late_interest = round($loan_account*$late_rate*$late_days,2);

		$late_customer_rate=$late_interest_rate['late_customer_interest_rate'];
// 		if ($data["status"] == 2){
// 			//�����վ�Ѿ��渶��Ͷ����Ӧ��������Ϣ��Ҫ���ݵ渶ʱ������

// 			$repayment_time = get_mktime(date("Y-m-d",$data['repayment_time']));
// 			$advance_time = get_mktime(date("Y-m-d",$data['advance_time']));
// 			$advance_days = ($advance_time - $repayment_time)/(60*60*24);
// 			$_advance_days = explode(".",$advance_days);
// 			$advance_days = ($_advance_days[0]<0)?0:$_advance_days[0];

// 			$late_customer_interest = round($loan_account*$late_customer_rate*$advance_days,2);
// 		}
// 		else{
// 			//�����վ��û�е渶����Ͷ����Ӧ��������Ϣ������������ʱ�����Ϣ
				
// 			$late_customer_interest = round($loan_account*$late_customer_rate*$late_days,2);
// 		}

		//if ($data["status"] == 2){
			//�����վ�Ѿ��渶��Ͷ����û��������Ϣ����
			//$late_customer_interest = 0;
		//}
		//else{
			$late_customer_interest = round_money($loan_account*$late_customer_rate*$late_days);
		//}
		
		$interest_result['late_days'] = $late_days;
		$interest_result['late_interest'] = $late_interest;
		$interest_result["late_customer_interest"] = $late_customer_interest;

		return $interest_result;
	}
	
	/**
	 * ��ý��������
	 *
	 * @param Array $data
	 * @return Boolen
	 */

	
	
	function getBorrowFee($data = array()){
		global $mysql;
		$borrow_account = $data['account'];
		$month_times = $data['time_limit'];
		$isday = $data['isday'];
		$time_limit_day = $data['time_limit_day'];
		
		$fee_rate = self::get_borrow_fee_rate();
		
		$borrow_fee_rate_start = $fee_rate['borrow_fee_rate_start'];
		$borrow_fee_rate_start_month_num = $fee_rate['borrow_fee_rate_start_month_num'];
		$borrow_fee_rate = $fee_rate['borrow_fee_rate'];
		$borrow_day_fee_rate = $fee_rate['borrow_day_fee_rate'];
		
		//liukun add for bug 52 begin
		fb($data, FirePHP::TRACE);
		fb($fee_rate, FirePHP::TRACE);
		//liukun add for bug 52 end
	
		if($isday==1){
			$borrow_fee=round($borrow_account*$borrow_day_fee_rate/30*$time_limit_day,2);
		}else{
			$_fee_rate = $borrow_fee_rate_start + (($month_times - $borrow_fee_rate_start_month_num)>0?($month_times - $borrow_fee_rate_start_month_num)*$borrow_fee_rate:0);
			$borrow_fee = round($borrow_account*$_fee_rate,2);
		}
		return $borrow_fee;
	}
}