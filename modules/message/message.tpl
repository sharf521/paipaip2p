{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<div class="module_title"><strong>{$_A.list_title}</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�����ˣ�</div>
		<div class="c">
			<input type="text" name="send_userid" id="zz" value="{$magic.session.username}"  /> <span  class="label"  onclick='tipsWindown("ѡ���û�","url:get?plugins/index.php?q=user&name=send_username&id=zz&type=input",500,300,"false","","true","text")'>��ѡ��</span> <span>��д�û���</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ˣ�</div>
		<div class="c">
			<input type="text" name="receive_userid" id="suser"  /> <span  class="label"  onclick='tipsWindown("ѡ���û�","url:get?plugins/index.php?q=user&name=receive_username&id=suser&type=input",500,300,"false","","true","text")'>��ѡ��</span> <span>��д�û���</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ͣ�</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=type&nid=message_type&value={$_A.message_result.type}"></script> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">
				<textarea name="content" rows="5" cols="50" >{$_A.message_result.type}</textarea>
		</div>
	</div>
	
	
		
	<div class="module_submit" >
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	
</div>
{literal}
<script>


function check_form(){
	 var frm = document.forms['form1'];
	 var name = frm.elements['name'].value;
	 var award = frm.elements['award'].value;
	 var part_account = frm.elements['part_account'].value;
	 var errorMsg = '';
	  if (name.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	   if (award ==1 && part_account<5) {
		errorMsg += '��������С��5Ԫ' + '\n';
	  }
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}

{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="*" class="main_td">ID</td>
			<td width="*" class="main_td">������</td>
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">ʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.message_list key=key item=item}
			<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td>{ $item.send_username}</td>
			<td class="main_td1" align="center">{$item.receive_username}</td>
			<td>{$item.type|linkage}</td>
			<td>{$item.content}</td>
			<td>{ if $item.status ==1}�ѿ�{else}δ��{/if}</td>
			<td>{$item.addtime|date_format:"Y-m-d H:i"}</td>
			<td> <a href="{$_A.query_url}/del{$site_url}&id={$item.id}">ɾ��</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	var status = $("#status").val();
	if (status!=""){
		sou += "&status="+status;
	}
	if (sou!=""){
	location.href=url+sou;
	}
}
</script>
{/literal}


{/if}