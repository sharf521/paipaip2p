<?php
/**
 * @author Tissot.Cai(Email:Tissot.Cai@gmail.com)
 * @copyright Tissot.Cai
 * @version 1.0
 */

/**
 * Description of credit
 *
 * @author TissotCai
 */
require_once 'credit.class.php';
class CreditModule {

	/**
	 * ���»���
	 * @param $param
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'credit_type_code => '�������ʹ���',
	 *			'value' => '[OPTION]����ӷ�ֵ',
	 *			'op_user' => '[OPTION]������ID'
	 *		)
	 * @return bool
	 */
	public static function UpdateCredit ($param) {

		$user_id = (int)$param['user_id'];
		$credit_type_code = trim($param['credit_type_code']);
		$value   = isset($param['value'])?(int)$param['value']:0;
		$op_user = isset($param['op_user'])?(int)$param['op_user']:(int)$_SESSION['user_id'];
		if ($user_id <= 0 || !$credit_type_code) {
			return false;
		}
		
		return true === Credit::Update($user_id, $credit_type_code, $value, $op_user)?true:false;
	}

	/**
	 * ��ȡ����
	 * @param $user_id ��ԱID
	 * @return int
	 */
	public static function GetCredit ($user_id) {

		return Credit::Get($user_id);
	}

	/**
	 * ���»�������
	 * @param $param
	 *		array(
	 *			'id' => 0,
	 *			'code' => '�������ʹ���',
	 *			'name' => '������������',
	 *			'value' => '����ֵ',
	 *			'cycle' => '[OPTIOIN]��������',
	 *			'award_times' => '[OPTION]��������',
	 *			'interval' => '[OPTION]ʱ����',
	 *			'remark' => '[OPTION]��ע',
	 *			'op_user' => '[OPTION]������ID'
	 *		)
	 */
	public static function UpdateCreditType ($param) {

		$id     = isset($param['id'])?(int)$param['id']:0;
		$code   = isset($param['code'])?$param['code']:'';
		$name   = isset($param['name'])?$param['name']:'';
		$value  = isset($param['value'])?(int)$param['value']:0;
		$cycle  = isset($param['cycle'])?(int)$param['cycle']:0;
		$award_times = isset($param['award_times'])?(int)$param['award_times']:0;
		$interval    = isset($param['interval'])?(int)$param['interval']:0;
		$remark      = isset($param['remark'])?$param['remark']:'';
		$op_user     = isset($param['op_user'])?$param['op_user']:$_SESSION['user_id'];

		if (!$name || !$code || $cycle <= 0) {
			return false;
		}
		
		return Credit::UpdateCreditType(
					$id,
					$code,
					$name,
					$value,
					$cycle,
					$award_times,
					$interval,
					$remark,
					$op_user
				)?true:false;
	}
}
?>
