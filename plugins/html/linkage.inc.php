<?php

$order = " order by `order` desc,id asc ";


$name = isset($_REQUEST['name'])?$_REQUEST['name']:"";//��������
$nid = isset($_REQUEST['nid'])?$_REQUEST['nid']:"";//����������
$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";//Ҫ������div
$type = !isset($_REQUEST['type'])?"":$_REQUEST['type'];//��������
$val = !isset($_REQUEST['value'])?"":$_REQUEST['value'];//����ֵ
$isid = !isset($_REQUEST['isid'])?"true":$_REQUEST['isid'];//����ֵ
$default = !isset($_REQUEST['default'])?"":$_REQUEST['default'];//����Ĭ��ֵ

if (isset($_G['linkage'])){
	$result = $_G['_linkage'][$nid];
	if ($result=="") return ;
}else{
	$sql = "select * from {linkage_type} where nid='$nid'";
	$result = $mysql->db_fetch_array($sql);
	if ($result==false){
		return ;
	}else{
		$type_id = $result['id'];
		$sql = "select * from {linkage} where type_id=$type_id order by `order` asc";
		$result = $mysql->db_fetch_arrays($sql);
	}
}

if ($isid=="true"){
	$vid = "id";
}else{
	$vid = "value";
}

$display = "";
$_val = array("");
if ($type=="" || $type == "select"){
	$display .=  "<select name='$name' id=$name >";
	if ($default!=""){
		$display .=  "<option value=''>".urldecode($default)."</option>";
	}
	if ($result !="false"){
		
		foreach ($result as $key => $value){
			if ($val==$value['id'] || ($isid!="true" && $val==$value['value'])){
				$display .=  "<option value='".$value[$vid]."' selected>".$value['name']."</option>";
			}else{
				$display .=  "<option value='".$value[$vid]."'>".$value['name']."</option>";
			}	
		}
	}
	
	$display .=  "</select>";
	
}elseif ($type == "checkbox"){
	$name = $name."[]";
	if ($result !="false"){	
		if ($val!=""){
			$_val = explode(",",$val);
		}
		foreach ($result as $key => $value){
			$display .= "<label>";
			if (in_array($value['id'],$_val) || ($isid!="true" && in_array($value['value'],$_val))){
				$display .=  " <input  type='checkbox' name=$name value='".$value[$vid]."'   checked > ".$value['name']."&nbsp;&nbsp;";
			}else{
				$display .=  " <input type='checkbox' name=$name value='".$value[$vid]."'  > ".$value['name']."&nbsp;&nbsp;";
			}	
			$display .= "</label>";
		}
	}
}
elseif ($type == "radio"){
	$name = $name."[]";
	if ($result !="false"){	
		foreach ($result as $key => $value){
			if ($value['id']==$val || ($isid!="true" && $val==$value['value'])){
				$display .=  "<input  type='radio' name=$name value='".$value[$vid]."' checked>".$value['name']."</option>";
			}else{
				$display .=  "<input type='radio' name=$name value='".$value[$vid]."'>".$value['name']."</option>";
			}	
		}
	}
}

?>


document.write("<? echo $display;?>");
<? if (!empty($id)){?>
$("#<? echo $name;?>").change(function(){
	var val = $(this).val();
	$("#<? echo $id;?>").val(val);

})
<? }?>