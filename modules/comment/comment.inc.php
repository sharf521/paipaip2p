<?php
/**
 */
require_once 'comment.class.php';
$type = isset($_REQUEST['type'])?$_REQUEST['type']:'list';


$code = isset($_GET['code'])?$_GET['code']:'';
$article_id  = isset($_GET['id'])?$_GET['id']:0;
$pid  = isset($_GET['pid'])?$_GET['pid']:0;
# �����б�
if ('list' == $type) {
    $page  = isset($_GET['page'])?$_GET['page']:1;
    $epage = isset($_GET['epage'])?$_GET['epage']:10;
    if (!$module || !$article_id) {
        echo jsList(array(), $page, 0, 0, $epage, false, '������Ч');
    }
    else{
		$data['page'] = $page;
		$data['epage'] = $epage;
		$data['code'] = $code;
		$data['status'] = 1;
		$data['article_id'] = $article_id;
        $result = commentClass::GetList($data);
        echo jsList($result['list'], $result['page'], $result['total_page'], $result['total'], $epage);
    }
}

elseif ('lists' == $type) {
    $page  = isset($_GET['page'])?$_GET['page']:1;
    $epage = isset($_GET['epage'])?$_GET['epage']:10;
  
	$data['page'] = $page;
	$data['epage'] = $epage;
	$data['code'] = $code;
	$data['status'] = 1;
	$data['article_id'] = $article_id;
	$result = commentClass::GetList($data);
	$magic->display("comment.html.php");
      exit;
}


# �������
elseif ('add' == $type) {
	
    $valicode = isset($_GET['valicode'])?$_GET['valicode']:0;
    $comment = isset($_GET['comment'])?trim($_GET['comment']):'';
	$msg = "";
    if ($_G['user_id']=="") {
        $msg =  'û�е�¼,���ȵ�¼';
        echo "<br>$msg<br /><br /><a href='/index.php?user&type=login'>�رտ�</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',2000);function curl(){ location.href='/index.php?user&type=login'}</script>";
	exit;
    }
	
    if (!isset($_SESSION['valicode'])) {
        $msg =  '��֤�����!';
       
    }
	
    if ($_SESSION['valicode'] != $valicode) {
       $msg = '��֤�����!';
    }
	
    if ($article_id <= 0) {
        $msg = '����ID��Ч';
    }
    if (!$comment) {
        $msg =  '����������';
    }
	if (isset($msg) && $msg==""){
		$msg = "���۳ɹ�";
		$user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:0;
		$data = array(
			'pid' => 0,
            'user_id' => $_G['user_id'],
            'module_code' => $code,
            'article_id' => $article_id,
            'comment' => $comment,
            'status' => 1,
            'flag' => 1,
        );
  	 	 $result = commentClass::AddComment($data);
		 $_SESSION['valicode'] = "";
		 echo "<br>$msg<br /><br /><a href='javascript:void(0)' onclick='curl()'>�رտ�</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',2000);function curl(){history.go(0) }</script>";
	exit;
	}
	
	/* echo "<br>$msg<br /><br /><a href='javascript:void(0)' id='comment_close'>�رտ�</a><br /><br />ϵͳ��3�����ת<script>setTimeout('curl()',2000);function curl(){ }</script>";*/	
	echo "<br>$msg<br /><br /><a href='javascript:comment_close()'>�رտ�</a><br />";
	exit;
}
# ��Ч����
else{
    
}

/*
 * �б�����JAVASCRIPT
 * @param $list ��¼�б�
 * @param $page ��ǰҳ��
 * @param $total_page ��ҳ��
 * @param $record_num �ܼ�¼��
 * @param $epage ÿҳ��¼��
 * @param $code ״ֵ̬:true/false
 * @param $message ��Ϣ
 */
function jsList ($list, $page, $total_page, $record_num, $epage = 0, $code = true, $message='') {

    $list = $list?$list:array();

    $js_list = createJsList($list);
    
    return "
        var result = new Array();
        result = {
            'code':'" . (string)($code) . "',
            'message':'{$message}',
            'list':{$js_list},
            'page':$page,
            'total_page':{$total_page},
            'total':{$record_num},
            'epage':{$epage}
        };
    ";
}
//���鴦����
function ubbReplace($str){
 	$str = htmlgl($str);
	$str = preg_replace("[\[/face([0-9]*)\]]","<img src=\"/themes/face/face/$1.gif\" />",$str);
	return $str;
}

function createJsList ($list) {
	
	$js_list = array();
	$js_str = '';
    foreach ($list as $record) {
        $key_value = array();
        foreach ($record as $key => $value) {
			
			if (!is_array($value)) {
				if($key=='comment'){
					
					$value = ubbReplace($value);
					}
				array_push($key_value, "'{$key}':'{$value}'");
			}
			else {
				if (!empty ($value)) {
					$js_str .= "'{$key}':" . createJsList($value);
				}
			}
        }
        array_push($js_list, '{' . implode(',', $key_value) .'}');
    }
    $js_str .= implode(',', $js_list);
	
	return "new Array({$js_str})";
}
?>
