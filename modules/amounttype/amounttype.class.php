<?php
class amounttypeClass{
	function GetList($data = array()){
		global $mysql;

	$sql = "select * from  {user_amount_type}  order by id";
	$list = $mysql ->db_fetch_arrays($sql);

	// 		$pages->set_data(array(
	//             'list' => $list,
	//             'total' => $result,
	//             'page' => $page,
	//             'epage' => $epage,
	//             'total_page' => $total_page
	//         ));

	return array(
			'list' => $list,
			'total' => $total,
			'page' => $page,
			'epage' => $epage,
			'total_page' => $total_page
	);
	
	}
}
?>