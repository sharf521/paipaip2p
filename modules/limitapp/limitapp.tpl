{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	{if $magic.request.user_id==""}
	<form name="form1" method="post" action="" enctype="multipart/form-data" >
	<div class="module_title"><strong>���������Ϣ���û�����ID</strong></div>
	

	<div class="module_border">
		<div class="l">�û�ID��</div>
		<div class="c">
			<input type="text" name="user_id"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<input type="text" name="username"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_submit" >
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	{else}
	<div class="module_title"><strong>����û���Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.limitapp_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��</div>
		<div class="c">
			<input type="text" name="account" value="{$_A.limitapp_result.account}" /> <span >��Ҫ���ӵĶ�ȡ�</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƽ��ˣ�</div>
		<div class="c">
			<input type="text" name="recommend_userid" value="{$_A.limitapp_result.recommend_userid}" /> <span >�Ƽ��ˣ�����á�|�������� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			<textarea name="content" rows="5" cols="50">{$_A.limitapp_result.content}</textarea> <span >�����ȷ��ڻ�����ָ�����߽��ɹ���,ÿ�»�Ϣ������������</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ط���ϸ˵����</div>
		<div class="c">
				<textarea name="other_content" rows="5" cols="50">{$_A.limitapp_result.other_content}</textarea> <span >�����ط���ϸ˵�� </span>
		</div>
	</div>
	
		
	<div class="module_submit" >
		{if $_A.query_type == "edit"}<input type="hidden"  name="id" value="{$magic.request.id}" />{/if}
		<input type="hidden"  name="user_id" value="{$magic.request.user_id}" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	
	
	{/if}
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
{elseif $_A.query_type == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>�����Ȳ鿴</strong></div>


	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.limitapp_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ӷ�ȣ�</div>
		<div class="c">
			{$_A.limitapp_result.account} Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϸ˵����</div>
		<div class="c">
		{$_A.limitapp_result.content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ط�˵����</div>
		<div class="c">
			{$_A.limitapp_result.other_content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.limitapp_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.limitapp_result.addip}</div>
	</div>
	
	{if $_A.limitapp_result.status!=1}
	<div class="module_title"><strong>��˴˽��</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="0" {if $_A.limitapp_result.status==0} checked="checked"{/if} />�ȴ����  <input type="radio" name="status" value="1" {if $_A.limitapp_result.status==1} checked="checked"{/if}/>���ͨ�� <input type="radio" name="status" value="2" {if $_A.limitapp_result.status==2} checked="checked"{/if}/>��˲�ͨ�� </div>
	</div>
	
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.limitapp_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.limitapp_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.limitapp_result.user_id }" />
		<input type="submit"  name="reset" value="��˴�����" />
	</div>
	{else}
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
	{if $_A.limitapp_result.status==1} ���ͨ�� {elseif $_A.limitapp_result.status==2} ��˲�ͨ��{elseif $_A.limitapp_result.status==3} �û�ȡ��{/if} </div>
	</div>
	<div class="module_border">
		<div class="l">���ʱ��:</div>
		<div class="c">
		{ $_A.limitapp_result.verify_time|date_format:"Y-m-d H:i"}
		 </div>
	</div>
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			{ $_A.limitapp_result.verify_remark}
		</div>
	</div>
	
	{/if}
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var verify_remark = frm.elements['verify_remark'].value;
	 var errorMsg = '';
	  if (verify_remark.length == 0 ) {
		errorMsg += '��ע������д' + '\n';
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
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="*" class="main_td">������</td>
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">���ӽ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.limitapp_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" >{ $item.id}</td>
			<td class="main_td1" align="center"><a href="{$_A.query_url}&username={$item.username}">{$item.username}</a></td>
			<td class="main_td1" align="center" >{$item.realname}</td>
			<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i"}</td>
			<td class="main_td1" align="center" >{$item.account}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}���ͨ��{ elseif $item.status ==0}�ȴ����{ elseif $item.status ==3}�û�ȡ��{else}���δͨ��{/if}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/view{$site_url}&user_id={$item.user_id}&id={$item.id}">���</a> <a href="{$_A.query_url}/edit{$site_url}&user_id={$item.user_id}&id={$item.id}">�޸�</a></td>
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