<?php
/******************************
 * $File: safe.php
 * $Description: ���ݴ���ȫ���
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
 * $UpdateDate:None 
******************************/

/* ����ת���ַ� */
/*function safe_str($str){
	if(!get_magic_quotes_gpc())	{
		if( is_array($str) ) {
			foreach($str as $key => $value) {
				$str[$key] = safe_str($value);
			}
		}else{
			$str = addslashes($str);
		}
	}
	return $str;
}

$request_uri = explode("?",$_SERVER['REQUEST_URI']);
if(isset($request_uri[1])){
	$rewrite_url = explode("&",$request_uri[1]);
	foreach ($rewrite_url as $key => $value){
		$_value = explode("=",$value);
		if (isset($_value[1])){
		$_REQUEST[$_value[0]] = addslashes($_value[1]);
		}
	}
}

foreach(array('_GET','_POST','_COOKIE','_REQUEST') as $key) {
	if (isset($$key)){
		foreach($$key as $_key => $_value){
			$$key[$_key] = safe_str($_value);
		}
	}
	
}
/* �ϴ��ļ��ļ�� */
/*function safe_file(){
	$not_allow_file = "php|asp|jsp|aspx|cgi|php3|shtm|html|htm|shtml";
	foreach ($_FILES as $key=>$value){
		$_name = $_FILES[$key]['name'];
		if (is_array($_name)){
			foreach($_name as $key){
				if ( !empty($key) && (eregi("\.(".$not_allow_file.")$",$key) || !ereg("\.",$key)) ){
					//die("�������ϴ�������");		
				}
			}
		}else{
			if ( !empty($_name) && (eregi("\.(".$not_allow_file.")$",$_name) || !ereg("\.",$_name)) ){
				//die("�������ϴ�������");		
			}
		}
	}
}
safe_file();

?>
<?php
/******************************
 * $File: safe.php
 * $Description: ���ݴ���ȫ���
 * $Author: erongdu.com
 * $Time:2013-03-09
 * $Update: v2.0 �ڶ� 
 * $UpdateDate:None 
******************************/
$referer=empty($_SERVER['HTTP_REFERER']) ? array() : array($_SERVER['HTTP_REFERER']);
$getfilter="'|\\b(and|or)\\b.+?(>|<|=|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";


/* ����ת���ַ� */
function safe_str($str){
	if(!get_magic_quotes_gpc())	{
		if( is_array($str) ) {
			foreach($str as $key => $value) {
				$str[$key] = safe_str($value);
			}
		}else{
			$str = addslashes($str);
		}
	}
	return $str;
}

$request_uri = explode("?",$_SERVER['REQUEST_URI']);
if(isset($request_uri[1])){
	$rewrite_url = explode("&",$request_uri[1]);
	foreach ($rewrite_url as $key => $value){
		$_value = explode("=",$value);
		if (isset($_value[1])){
		$_REQUEST[$_value[0]] = addslashes($_value[1]);
		}
	}
}
function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){  

	$StrFiltValue=arr_foreach($StrFiltValue);
	if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){   

        slog("<br><br>����IP: ".$_SERVER["REMOTE_ADDR"]."<br>����ʱ��: ".strftime("%Y-%m-%d %H:%M:%S")."<br>����ҳ��:".$_SERVER["PHP_SELF"]."<br>�ύ��ʽ: ".$_SERVER["REQUEST_METHOD"]."<br>�ύ����: ".$StrFiltKey."<br>�ύ����: ".$StrFiltValue);
        ob_start();
		ob_get_clean();
		ob_clean();
		print "<div style=\"position:fixed;top:0px; color:red;font-weight:bold;border-bottom:5px solid #999;\"><br>�����ύ���в��Ϸ�����,лл����!<br> </div>";
        die("���ּ�ⷢ�ֿ�������  ");
		exit();
	}
	if (preg_match("/".$ArrFiltReq."/is",$StrFiltKey)==1){   
 
        slog("<br><br>����IP: ".$_SERVER["REMOTE_ADDR"]."<br>����ʱ��: ".strftime("%Y-%m-%d %H:%M:%S")."<br>����ҳ��:".$_SERVER["PHP_SELF"]."<br>�ύ��ʽ: ".$_SERVER["REQUEST_METHOD"]."<br>�ύ����: ".$StrFiltKey."<br>�ύ����: ".$StrFiltValue);
        ob_start();
		ob_get_clean();
		ob_clean();
		print "<div style=\"position:fixed;top:0px;  color:red;font-weight:bold;border-bottom:5px solid #999;\"><br>�����ύ���в��Ϸ�����,лл����!<br> </div>";
        die("���ּ�ⷢ�ֿ������� ");
		exit();
	}  
} 

foreach(array('_GET','_POST','_COOKIE','_REQUEST') as $key) {
	if (isset($$key)){
		foreach($$key as $_key => $_value){
			$$key[$_key] = safe_str($_value);
			$_value=urldecode($_value);
			//��վ����ͳ�ƴ���ʱ���ð�ȫ���
			if ($_key!="statistics_code" && $_key!="site_remark" && $_key !='content'){
				StopAttack($_key,$_value,$getfilter);
			}
		}
	}
	
}

/* д��safe��־/log/safe.log */
function slog($logs)
{
	$toppath=ROOT_PATH_SAFE;
	$Ts=fopen($toppath,"a+");
	fputs($Ts,$logs."\r\n");
	fclose($Ts);
}

/* �и����� */
function arr_foreach($arr) {
	static $str;
	if (!is_array($arr)) {
	return $arr;
	}
	foreach ($arr as $key => $val ) {

	if (is_array($val)) {

		arr_foreach($val);
	} else {

	  $str[] = $val;
	}
	}
	return implode($str);
}

/* �ϴ��ļ��ļ�� */
function safe_file(){
	$not_allow_file = "php|asp|jsp|aspx|cgi|php3|shtm|html|htm|shtml";
	foreach ($_FILES as $key=>$value){
		$_name = $_FILES[$key]['name'];
		if (is_array($_name)){
			foreach($_name as $key){
				if ( !empty($key) && (eregi("\.(".$not_allow_file.")$",$key) || !ereg("\.",$key)) ){
					//die("�������ϴ�������");		
				}
			}
		}else{
			if ( !empty($_name) && (eregi("\.(".$not_allow_file.")$",$_name) || !ereg("\.",$_name)) ){
				//die("�������ϴ�������");		
			}
		}
	}
}
safe_file();

?>