{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">ʶ����</td>
		<td width="*" class="main_td">��������</td>
		<td width="*" class="main_td">�������</td>
		<td width="*" class="main_td">�������</td>
		<td width="*" class="main_td">����</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.amount_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center">{$item.amount_type_name}</td>
		<td class="main_td1" align="center">{$item.show_name}</td>
		<td class="main_td1" align="center">{$item.fee_rate}</td>
		<td class="main_td1" align="center">{$item.frost_rate}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&type_id={$item.id}{$_A.site_url}">�޸�</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="8" class="page">
		<input type="submit" value="�޸�����" /
		</td>
	</tr>
	<tr>
		<td colspan="8" class="page">
		{$_A.showpage}
		</td>
	</tr>
	</form>
</table>


{elseif $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form_user" method="post" action="" { if $_A.query_type == "new" }{/if} >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}</strong></div>
	
	<div class="module_border">
		<div class="l">ʶ���룺</div>
		<div class="c">
			{ $_A.amount_type_result.amount_type_name }<input type="hidden" name="amount_type_name" value="{ $_A.amount_type_result.amount_type_name }" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ƣ�</div>
		<div class="c">
			<input name="show_name" type="text" value="{ $_A.amount_type_result.show_name }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ʣ�</div>
		<div class="c">
			<input name="fee_rate" type="text" value="{ $_A.amount_type_result.fee_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���������</div>
		<div class="c">
			<input name="frost_rate" type="text" value="{ $_A.amount_type_result.frost_rate }" class="input_border" />
		</div>
	</div>
	
	
	
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="type_id" value="{ $_A.amount_type_result.id }" />{/if}
	<input type="submit" value="ȷ���ύ" />
	<input type="reset" name="reset" value="���ñ�" />
	</div>
	</form>
</div>
{literal}
<script>
function joincity(id){
	alert($("#"+id+"city option").text());

}

function check_user(){
	 var frm = document.forms['form_user'];
	 var username = frm.elements['username'].value;
	 var password = frm.elements['password'].value;
	  var password1 = frm.elements['password1'].value;
	   var email = frm.elements['email'].value;
	 var errorMsg = '';
	  if (username.length == 0 ) {
		errorMsg += '�û�������Ϊ��' + '\n';
	  }
	   if (username.length<4) {
		errorMsg += '�û������Ȳ�������4λ' + '\n';
	  }
	  if (password.length==0) {
		errorMsg += '���벻��Ϊ��' + '\n';
	  }
	  if (password.length<6) {
		errorMsg += '���볤�Ȳ���С��6λ' + '\n';
	  }
	   if (password.length!=password1.length) {
		errorMsg += '�������벻һ��' + '\n';
	  }
	   if (email.length==0) {
		errorMsg += '���䲻��Ϊ��' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}
{/if}