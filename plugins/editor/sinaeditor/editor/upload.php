<?php
/**
*�������߱༭��PHP��
*

**/


if($_REQUEST['action']=='upload'){
	$fileType=array('jpg','gif','bmp','png');//�����ϴ����ļ�����
	
	$upfileDir='../../../../data/upfiles/';
	$_upfileDir='../../../data/upfiles/';
	$maxSize=500; //��λ��KB
	
	if(exif_imagetype($_FILES['file1']['tmp_name'])<1)
	{
	  ob_start();
	  ob_get_clean();
	  ob_clean();
	  die("���ּ�ⷢ�ֿ����ϴ��ļ� ��");
	  exit;
	}
	
	if(!in_array(strtolower(substr($_FILES['file1']['name'],-3,3)),$fileType))
		die("<script>alert('�������ϴ������͵��ļ���-808');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if(strpos($_FILES['file1']['type'],'image')===false)
		die("<script>alert('�������ϴ������͵��ļ���');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['size']> $maxSize*1024)
		die( "<script>alert('�ļ�����');window.parent.\$('divProcessing').style.display='none';history.back();</script>");
	if($_FILES['file1']['error'] !=0)
		die("<script>alert('δ֪�����ļ��ϴ�ʧ�ܣ�');window.parent.$('divProcessing').style.display='none';history.back();</script>");
	
	$targetFile=date('Ymd').time().substr($_FILES['file1']['name'],-4,4);
	$realFile=$upfileDir.$targetFile;
	
	if(function_exists('move_uploaded_file')){
		 move_uploaded_file($_FILES['file1']['tmp_name'],$realFile) && die("<script>window.parent.LoadIMG('$_upfileDir$targetFile');</script>");
	}
	else{
		@copy($_FILES['file1']['tmp_name'],$realFile) && die("<script>window.parent.LoadIMG('$_upfileDir$targetFile');</script>");
	}
}

?>