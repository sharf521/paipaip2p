{if $_A.query_type == "edit"}
<div class="module_add">
	
	<div class="module_title"><strong>������Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrowunion_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border"  size="20" value="{ $_A.borrowunion_result.name}" />
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��Ӫ��Χ��</div>
		<div class="c">
			<textarea name="range" rows="5" cols="50">{ $_A.borrowunion_result.range}</textarea>
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">������飺</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.borrowunion_result.content"}
		</div>
	</div>
	{if $_A.borrowunion_result.isvip==1}
	<div class="module_title"><strong>��˻���</strong></div>
	<div class="module_border">
		<div class="l">����Ƿ�ͨ����</div>
		<div class="c">
			<input type="radio" name="status" value="1" {if $_A.borrowunion_result.status==1} checked="checked"{/if} /> �� <input type="radio" name="status" value="0" {if $_A.borrowunion_result.status==0 || $_A.borrowunion_result.status==""} checked="checked"{/if} />��
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˱�ע��</div>
		<div class="c">
			<textarea name="verify_remark" rows="5" cols="50">{$_A.borrowunion_result.verify_remark}</textarea>
		</div>
	</div>
	{else}
	<div class="module_border">
		<div class="l"></div>
		<div class="c">
			<strong>�˻�Ա������VIP�����ܳ�Ϊ�ڴ�������</strong>
		</div>
	</div>
	{/if}
	<div class="module_submit" >
		<input type="hidden"  name="user_id" value="{$magic.request.user_id}" />
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
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (name.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	   if (content.length =="") {
		errorMsg += '���ݱ�����д' + '\n';
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
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">�Ƿ�VIP</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">���ʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.borrowunion_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" >{ $item.username}</td>
			<td class="main_td1" align="center" >{ if $item.isvip==1}��{else}��{/if}</td>
			<td class="main_td1" align="center">{$item.name|truncate:34}</td>
			<td class="main_td1" align="center" >{$item.addtime|date_format}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}���ͨ��{else}δͨ��{/if}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/edit{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> <input type="button" value="����" / onclick="sousuo()">
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