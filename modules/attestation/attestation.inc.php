<?php
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
include_once("attestation.class.php");

if (isset($_POST['valicode']) && $_POST['valicode']!=$_SESSION['valicode']){
		$msg = array("��֤�����");
}else{
	$_SESSION['valicode'] = "";
	if ($_U['query_type'] == "list"){	
		
	}
	elseif($_U['query_type'] == "one"){
		if (isset($_POST['name'])){
			$var = array("name","type_id");
			$data = post_var($var);
			$data['user_id'] = $_G['user_id'];
			$_G['upimg']['user_id'] = $_G['user_id'];
			$_G['upimg']['file'] = "litpic";
			$_G['upimg']['cut_status'] = 0;
			$_G['upimg']['code'] = "attestation";
			$pic_result = $upload->upfile($_G['upimg']);
			if ($pic_result!=""){
				$data['litpic'] = $pic_result['filename'];//�ϴ���ͼƬ
				//$data['upfiles_id'] = $pic_result['upfiles_id'];//�ϴ���ͼƬ
			}
			
			$result = attestationClass::Add($data);
			if ($result!==true){
				$msg = array($reuslt);
			}else{
				$msg = array("�����ɹ�","","index.php?user&q=code/attestation");
			}
		}else{
			$_U['attestation_type_list'] = attestationClass::GetTypeList(array("limit"=>"all"));
		}
	}
	elseif($_U['query_type'] == "more"){
		if (isset($_POST['name'])){
			$var = array("name","type_id");
			$data = post_var($var);
			$data['user_id'] = $_G['user_id'];
			$_G['upimg']['file'] = "pics";
			$_G['upimg']['cut_status'] = 0;
			$_G['upimg']['code'] = "attestation";
			$pic_result = $upload->upfile($_G['upimg']);
			
			if ($pic_result!=""){
				foreach($pic_result as $key => $value){
					if($value!=""){
						$data['litpic'] = $value['filename'];
						$result = attestationClass::Add($data);
					}
				}
			}
			
			if ($result!==true){
				$msg = array($reuslt);
			}else{
				$msg = array("�����ɹ�","","index.php?user&q=code/attestation");
			}
		}else{
			$_U['attestation_type_list'] = attestationClass::GetTypeList(array("limit"=>"all"));
		}
		
	}
	

}



$template = "user_attestation.html.php";
?>
