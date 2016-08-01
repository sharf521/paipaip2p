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
require_once 'discount.class.php';
class DiscountModule {

	/**
	 * ��ȡ�ۿ��б�
	 * @param $param
	 *		array(
	 *			'page' => 'ҳ��',
	 *			'where' => 'array(shop=>�ֶ���,...)',
	 *			'epage' => 'ÿҳ��¼��'
	 *		)
	 * @return
	 *	array(
	 *		'list' => array(�ۿ���Ϣ��Ϣ),
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
		
		return Discount::ListDiscount($where, $p, $page_size);
	}
}
?>
