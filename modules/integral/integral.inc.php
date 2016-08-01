<?php
/**
 * @author Tissot.Cai(Email:Tissot.Cai@gmail.com,QQ:1213690001)
 * @copyright Tissot.Cai
 * @version 1.0
 */

/**
 * Description of discount
 *
 * @author TissotCai
 */
require_once 'integral.class.php';
class IntegralModule {

	/**
	 * ��ȡ���ֶһ���Ʒ�б�
	 * @param $param
	 *		array(
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(goods=>����,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(��Ʒ��Ϣ),
	 *		'record_num' => ��¼��,
	 *		'page' => ҳ��,
	 *		'page_size' => ÿҳ��¼��
	 *		'total_page' => ��ҳ��
	 * )
	 */
	public static function Get ($param) {

		$p = isset($param['page'])?(int)$param['page']:1;
		$page_size = isset($param['epage'])?(int)$param['epage']:1;
		$where = isset($param['where'])?$param['where']:array();

		return Integral::ListIntegral($where, $p, $page_size);
	}

	/**
	 * ���ֶһ�
	 * @param $param ��ԱID
	 *		array(
	 *			'user_id' => '��ԱID',
	 *			'goods_id' => '��ƷID',
	 *			'number' => '[OPTION]�һ�����'
	 *		)
	 * @return
	 *		Integral::NOT_ENOUGH_GOODS ��Ʒ����
	 *		Integral::NOT_ALLOW_CITY �һ���������
	 *		true �ɹ�
	 */
	public static function ExchangeIntegral ($param) {

		$user_id = isset($param['user_id'])?$param['user_id']:0;
		$goods_id = isset($param['goods_id'])?$param['goods_id']:0;
		$number = isset($param['number'])?$param['number']:1;

		return Integral::ExchangeIntegral($user_id, $goods_id, $number);
	}
}
?>
