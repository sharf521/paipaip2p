<?
/******************************
 * $File: site.php
 * $Description: ��Ŀ
 * $Author: ahui 
 * $Time:2010-03-09
 * $Update:None 
******************************/
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���
check_rank("makehtml_".$_t);//���Ȩ��

$con_template = empty($system['con_template'])?"themes/default":"themes/".$system['con_template'];
$system['con_rewrite'] = 2;
/**
 *��ҳ����
**/
if ($t == "index"){	
	$magic->assign("site_id","0");
	if (isset($_REQUEST['action'])){
   		$content = $magic->gethtml("index.html",$con_template);
		mk_file("index.html",$content);
		$msg = array("���³ɹ�");
	}
}

/**
 *��Ŀ����
**/
elseif ($t == "site"){	
	if (isset($_POST['site_id']) ){		
		$sitelist = $module->get_sites($_POST['site_id'],1,$_POST['zilanmu']);//���վ����б���Ϣ
		foreach ($sitelist['result'] as $key => $value){
			$magic->assign("site_id",$value['site_id']);
			$url = $value['sitedir'];
			$format_var = array("code"=>$value['code'],"site_id"=>$value['site_id'],"nid"=>$value['nid'],"page"=>$page);
			if ($value['pid']==0){
				$list_name = "index.html";
				$template = format_tpl($value['index_tpl'],$format_var);
			}else{
				if ($value['list_name']!=""){
				$list_name = format_tpl($value['list_name'],$format_var);
				}
				$template = format_tpl($value['list_tpl'],$format_var);
			}
			$content = $magic->gethtml($template,$con_template);
			mk_file(format_tpl($url."/".$list_name,$format_var),$content);
			
			$msg = array("���³ɹ�");
		}
	}else{
		$magic->assign("sitelist",$module->get_site_li());
	}
	
}

if ($msg!="") {
	$template_tpl = show_msg($msg,$msg_tpl);//�������Ϣ����ֱ�Ӷ�ȡϵͳ����Ϣģ��
	$magic->assign("module_tpl",$template_tpl);
}
if ($msg==""){
		$template_tpl = "admin_makehtml.html.php";
	}
?>