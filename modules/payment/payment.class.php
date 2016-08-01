<?php
/**
 * @author Tissot.Cai(Email:Tissot.Cai@gmail.com)
 * @version 1.0
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
class paymentClass {

	const ERROR = '���������벻Ҫ�Ҳ���';

	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetList($data = array()){
		global $mysql;
		$alllist = self::GetListAll();
		$_sql = "where 1=1 ";		 
		if (isset($data['status']) && $data['status']!=""){
			$_sql .= " and status = {$data['status']}";
		}
		$sql = "select * from  {payment}  {$_sql} order by `order` desc";
		$result = $mysql->db_fetch_arrays($sql);
		foreach ($result as $key => $value){
			$result[$key]['logo'] = $alllist[$value['nid']]['logo'];
		}
		return $result;
	}
	
	/**
	 * �б�
	 *
	 * @return Array
	 */
	function GetListAll($data = array()){
		global $mysql;
		$result = get_file(ROOT_PATH."modules/payment/paytype","file");
		$_result = "";
		
		foreach ($result as $key => $value){
			$_nid = explode(".class.php",$value);
			$nid = $_nid[0];
			$_result[$nid]['nid'] = $nid;
			$classname = $nid."Payment";
			
			include_once(ROOT_PATH."modules/payment/paytype/{$value}");
			$o = new $classname();
			$_result[$nid]['type'] = $o->type;
			$_result[$nid]['name'] = $o->name;
			$_result[$nid]['description'] = $o->description;
			$_result[$nid]['logo'] = "/data/images/payment/".$o->logo.".gif";
		}
		
		return $_result;
	}
	
	/**
	 * �鿴
	 *
	 * @param Array $data
	 * @return Array
	 */
	public static function GetOne($data = array()){
		global $mysql;
		$nid = $data['nid'];
		$classname = $nid."Payment";
		include_once(ROOT_PATH."modules/payment/paytype/{$nid}.class.php");
		$o = new $classname();
		$_result['nid'] = $nid;
		$_result['type'] = $o->type;
		$_result['name'] = $o->name;
		$_result['description'] = $o->description;
		$_result['fields'] = $o->GetFields();
		$_result['logo'] = "/data/images/payment/".$o->logo.".gif";

// 		if ($_result['type'] ==1 || isset($data['id']) && $data['id']!=""){
		if (isset($data['id']) && $data['id']!=""){
			$sql = "select * from  {payment}  where id = {$data['id']}  ";
			$result = $mysql->db_fetch_array($sql);
			if ($result!=false){
			$_config = unserialize($result['config']);
			foreach ($_result['fields'] as $_key => $_value){
				$_result['fields'][$_key]['value'] =  isset($_config[$_key])?$_config[$_key]:"";
			
			}
			}
			if ($result != false) return $result+$_result;
		}
		return $_result;
	}
	
	 /**
	 * ���
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Action($data = array()){
		global $mysql;
		$nid = $data['nid'];
		$type = $data['type'];
		unset($data['type']);
		$sql = "select * from  {payment}  where nid = '{$nid}'";
		$result = $mysql->db_fetch_array($sql);
		if (($result == false || $type=="new")  && $type!="edit"){
			$_sql = "";
			$sql = "insert into  {payment}  set ";
			foreach($data as $key => $value){
				$_sql[] = "`$key` = '$value'";
			}
			return $mysql->db_query($sql.join(",",$_sql));
		}else{
			$_sql = $__sql = "";
			if (isset($data['id'])){
				$__sql .=" and id = '{$data['id']}'";
			}
			$sql = "update  {payment}  set ";
			foreach($data as $key => $value){
				$_sql[] .= "`$key` = '$value'";
			}
			$sql .= join(",",$_sql)." where nid = '$nid' {$__sql} ";
			return $mysql->db_query($sql);
		}
        
	}
	
	
	/**
	 * �޸�
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	function Update($data = array()){
		global $mysql;
		$id = $data['id'];
        if ($data['id'] == "") {
            return self::ERROR;
        }
		
		$_sql = "";
		$sql = "update  {payment}  set ";
		foreach($data as $key => $value){
			$_sql[] .= "`$key` = '$value'";
		}
		$sql .= join(",",$_sql)." where id = '$id'";
        return $mysql->db_query($sql);
	}
	
	function ToSubmit($data = array()){
		global $mysql,$_G;
		$payment = isset($data['payment'])?$data['payment']:"";
		$data['notify_url'] = $_G['weburl']."/modules/payment/notify2.php";//֪ͨ��ַ
		$data['return_url'] = $_G['weburl']."/modules/payment/return.php";//�ص���ַ
		$data['webname'] = $_G['system']['con_webname'];//�ص���ַ
		$data['subject'] = isset($data['subject'])?$data['subject']:"";
		$data['body'] = isset($data['body'])?$data['body']:"";
		$data['trade_no'] = isset($data['trade_no'])?$data['trade_no']:"";
		$sql = "select * from  {payment}  where id = '{$payment}' limit 1";
		$result = $mysql->db_fetch_array($sql);
		if($result['config']!="")
		{
			$data = unserialize($result['config'])+$data;	
			include_once(ROOT_PATH."modules/payment/paytype/{$result['nid']}.class.php");
			$classname = $result['nid']."Payment";
			$payclass = new $classname;
			$url = $payclass->ToSubmit($data);
			return $url;			
		}else{
			return "pay config empty";
		}
		
	}
	
	//˫ǬMD5����
   function getSignature_sq($MerNo, $BillNo, $Amount, $ReturnURL, $MD5key){
		$_SESSION['MerNo'] = $MerNo;
	    $_SESSION['MD5key'] = $MD5key;
		$sign_params  = array(
			'MerNo'       => $MerNo,
			'BillNo'       => $BillNo, 
			'Amount'         => $Amount,   
			'ReturnURL'       => $ReturnURL
		   );
	    $sign_str = "";
	    ksort($sign_params);
	    foreach ($sign_params as $key => $val) {
			$sign_str .= sprintf("%s=%s&", $key, $val);                
				}
	    return strtoupper(md5($sign_str. strtoupper(md5($MD5key))));   
	}
	
	//������������4��ƽ̨��ֵ
	function ToSubmit_auto($data=array())
	{
		global $mysql,$_G;
		if($_G['con_template_name'] == "jinhoudai")
		{   
            $MD5key = "{DSP[TzN";  			                        //MD5keyֵ
            $huic['MerNo'] = "22785"; 			                    //�̻�ID
            $huic['BillNo'] = $data['trade_no'];                    //������� 
            $huic['Amount'] = sprintf("%.2f",$data['OrdAmt']); 	    //֧����� ���Է�Ϊ��λ��
            $huic['orderTime'] = date('Y-m-d H:i:s',time()); 	    //�µ����� ����ʱ�䣺YYYYMMDD
            $huic['ReturnURL'] = "http://www.jinhoudai.com/modules/payment/ecpssResult.php";  //ͬ��֪ͨurl
            $huic['AdviceURL'] = "http://www.jinhoudai.com/modules/payment/ecpssResult.php";  //֧����ɺ󣬺�̨����֧��������������������ݿ�ֵ
            $huic['SignInfo'] = strtoupper(md5($huic['MerNo']."&".$huic['BillNo']."&".$huic['Amount']."&".$huic['ReturnURL']."&".$MD5key));
			$huic['defaultBankNumber'] = $data['InstCode'];        //���д���
			if($huic['defaultBankNumber'] == "HXBC"){$huic['defaultBankNumber'] = "HXB";}
			if($huic['defaultBankNumber'] == "CITIC"){$huic['defaultBankNumber'] = "CNCB";}
			if($huic['defaultBankNumber'] == "BOC"){$huic['defaultBankNumber'] = "BOCSH";}
			
            //˫Ǭ  ��ʼ
			if($data['InstCode'] =="shuangq")
			{
				$MD5key1 = "dHSqC}SS";  			                                      //MD5keyֵ
				$sqian['MerNo'] = "181823"; 			                                  //�̻�ID
				$sqian['BillNo'] = isset($data['trade_no'])?$data['trade_no']:"";         //������� 
				$sqian['Amount'] = sprintf("%.2f",$data['OrdAmt']); 			          //֧����� ���Է�Ϊ��λ��
				$sqian['orderTime'] = date('Y-m-d H:i:s',time()); 	                      //�µ����� ����ʱ�䣺YYYYMMDD
				$sqian['ReturnURL'] = "http://www.jinhoudai.com/modules/payment/95epayResult.php";  //ͬ��֪ͨurl
				$sqian['NotifyURL'] = "http://www.jinhoudai.com/modules/payment/95epayResult.php";  //֧����ɺ󣬺�̨����֧��������������������ݿ�ֵ
				$sqian['MD5info'] = self::getSignature_sq($sqian['MerNo'], $sqian['BillNo'], $sqian['Amount'], $sqian['ReturnURL'], $MD5key1);
				$sqian['PayType']="CSPAY";                              //��������
				$sqian['PaymentType']="";                
				$sqian['MerRemark']="";
				$sqian['products']="";
				
				$sHtml = "<form id='paysq' name='paysq' action='https://www.95epay.cn/sslpayment' method='post' style='display:none'>";
				while (list ($key, $val) = each ($sqian)) {
				   $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
														 }
				$sHtml = $sHtml."<input type='submit'></form>";		
				$sHtml = $sHtml."<script>document.forms['paysq'].submit();</script>";
				echo $sHtml;
				exit;
	        //˫Ǭ  ����
			}else{
				
			$sHtml = "<form id='payhc' name='payhc' action='https://pay.ecpss.com/sslpayment' method='post' style='display:none'>";
			while (list ($key, $val) = each ($huic)) {
				$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
													 }		
			$sHtml = $sHtml."<input type='submit'></form>";		
			$sHtml = $sHtml."<script>document.forms['payhc'].submit();</script>"; //submit��ť�ؼ��벻Ҫ����name����
			echo $sHtml;
			exit;
			}
		}
		
		$sql = "select * from  {payment}  where id = '{$data['payment']}' limit 1";
		$result = $mysql->db_fetch_array($sql);
		if($result['config']!=""){
			$data = unserialize($result['config'])+$data;			
			include_once(ROOT_PATH."modules/payment/paytype/{$result['nid']}.class.php");
			$classname = $result['nid']."Payment";
			$payclass = new $classname;
			$payclass->ToSubmit($data);
			exit;
		}else{
			return "pay config empty";
		}
		
		
	}

	
	//������������4��ƽ̨��ֵend
	//
	/**
	 * ɾ��
	 *
	 * @param Array $data
	 * @return Boolen
	 */
	public static function Delete($data = array()){
		global $mysql;
		$id = $data['id'];
		if (!is_array($id)){
			$id = array($id);
		}
		$sql = "delete from {payment}  where id in (".join(",",$id).")";
		return $mysql->db_query($sql);
	}
	
	
	
	
}

?>
