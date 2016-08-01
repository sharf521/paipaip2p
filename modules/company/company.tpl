{if $_A.query_type == "new" || $_A.query_type == "edit"}

<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��˾</strong></div>
	
	<div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			<input type="text" name="name" class="input_border" value="{ $_A.company_result.name}" size="30" />
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.company_result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ڣ�</div>
		<div class="c">
			<input type="text" name="foundyear"  value="{$_A.company_result.foundyear}" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">��˾��ַ��</div>
		<div class="c">
			<input type="text" name="weburl"  value="{$_A.company_result.weburl}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾��飺</div>
		<div class="c">
			<textarea rows="5" cols="30" name="summary">{$_A.company_result.summary|br2nl}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾��ϸ���ܣ�</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.company_result.content"}
		</div>
	</div>
	
	<div class="module_title"><strong>��˾��ϵ��ʽ</strong></div>
	
	
	<div class="module_border">
		<div class="l">��˾���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.company_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϵ�ˣ�</div>
		<div class="c">
			<input type="text" name="linkman"  class="input_border" value="{ $_A.company_result.linkman}"  size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">��ϵ��ַ��</div>
		<div class="c">
			<input type="text" name="address"  class="input_border" value="{ $_A.company_result.address}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ʱࣺ</div>
		<div class="c">
			<input type="text" name="postcode"  class="input_border" value="{ $_A.company_result.postcode}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">�绰��</div>
		<div class="c">
			<input type="text" name="tel"  class="input_border" value="{ $_A.company_result.tel}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���棺</div>
		<div class="c">
			<input type="text" name="fax" class="input_border" value="{ $_A.company_result.fax}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���䣺</div>
		<div class="c">
			<input type="text" name="email"  class="input_border" value="{ $_A.company_result.email}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">MSN��</div>
		<div class="c">
			<input type="text" name="msn"  class="input_border" value="{ $_A.company_result.msn}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">QQ��</div>
		<div class="c">
			<input type="text" name="qq"  class="input_border" value="{ $_A.company_result.qq}" size="30" />
		</div>
	</div>

	{if $input!=""}
	<div class="module_title"><strong>�Զ�������</strong></div>
	{foreach from=$input item=item}
	<div class="module_border">
		<div class="l">{$item.0}:</div>
		<div class="c">
			{$item.1}
		</div>
	</div>
	{/foreach}
	{/if}
	
	
	<div class="module_submit border_b" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.company_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if ($("#site_center").val()==""){
		errorMsg += '��ѡ����Ŀ' + '\n';
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
	<form name="form1" method="post" action="" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��˾</strong></div>
	
	<div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			 {$_A.company_result.name}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">�������ڣ�</div>
		<div class="c">
			{$_A.company_result.foundyear}
		</div>
	</div>
	<div class="module_border">
		<div class="l">��˾��ַ��</div>
		<div class="c">
		{$_A.company_result.weburl}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾��飺</div>
		<div class="c">
			{$_A.company_result.summary}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾��ϸ���ܣ�</div>
		<div class="c">
			{$_A.company_result.content}
		</div>
	</div>
	<div class="module_border">
		<div class="l">��ˣ�</div>
		<div class="c">
			<input type="radio" name="status" value="1" {if $_A.company_result.status==1} checked="checked"{/if} />���ͨ��<input type="radio" name="status" value="0" {if $_A.company_result.status!=1} checked="checked"{/if} />��˲�ͨ��
		</div>
	</div>
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="c">
			<textarea rows="5" cols="30" name="summary">{$_A.company_result.verify_remark|br2nl}</textarea>
		</div>
	</div>
	<div class="module_submit border_b" >
		<input type="hidden" name="id" value="{ $_A.company_result.id }" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</form>
</div>
{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="*" class="main_td">��˾����</td>
		<td width="*" class="main_td">��˾����</td>
		<td width="*" class="main_td">���ʱ��</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">״̬</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.company_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center">{$item.type|linkage}</td>
		<td class="main_td1" align="center">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" >{$item.flagname|default:-}</td>
		<td class="main_td1" align="center" >{if $item.status==1}���ͨ��{elseif $item.status==2}��������{else}��˲�ͨ��{/if}</td>
		<td class="main_td1" align="center" ><a href="{$_A.query_url}/edit{$site_url}&id={$item.id}{$_A.site_url}" >�޸�</a> <a href="{$_A.query_url}/view{$site_url}&id={$item.id}" >���</a> </td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<select name="type">
		<option value="0">����</option>
		<option value="1">��ʾ</option>
		<option value="2">����</option>
		<option value="3">�Ƽ�</option>
		<option value="4">ͷ��</option>
		<option value="5">�õ�Ƭ</option>
		<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
		</select> <input type="submit" value="ȷ�ϲ���" /> ������ȫѡ
		</div>
		<div class="floatr">
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="10"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var keywords = $("#keywords").val();
	location.href=url+"&keywords="+keywords;
}

</script>
{/literal}


{elseif $_A.query_type=="news"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="*" class="main_td">���ű���</td>
		<td width="*" class="main_td">�����û�</td>
		<td width="*" class="main_td">������˾</td>
		<td width="*" class="main_td">���ʱ��</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.company_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.company_name}</td>
		<td class="main_td1" align="center">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" ><a href="{$_A.query_url}/news_edit{$site_url}&id={$item.id}{$_A.site_url}" >�鿴�޸�</a> </td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<select name="type">
		<option value="0">����</option>
		<option value="1">��ʾ</option>
		<option value="2">����</option>
		<option value="3">�Ƽ�</option>
		<option value="4">ͷ��</option>
		<option value="5">�õ�Ƭ</option>
		<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
		</select> <input type="submit" value="ȷ�ϲ���" /> ������ȫѡ
		</div>
		<div class="floatr">
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="10"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var keywords = $("#keywords").val();
	location.href=url+"&keywords="+keywords;
}

</script>
{/literal}

{elseif $_A.query_type=="zhaopin"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="*" class="main_td">��Ƹ����</td>
		<td width="*" class="main_td">�����û�</td>
		<td width="*" class="main_td">������˾</td>
		<td width="*" class="main_td">���ʱ��</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.company_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.company_name}</td>
		<td class="main_td1" align="center">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" ><a href="{$_A.query_url}/zhaopin_edit{$site_url}&id={$item.id}{$_A.site_url}" >�鿴�޸�</a> </td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<select name="type">
		<option value="0">����</option>
		<option value="1">��ʾ</option>
		<option value="2">����</option>
		<option value="3">�Ƽ�</option>
		<option value="4">ͷ��</option>
		<option value="5">�õ�Ƭ</option>
		<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
		</select> <input type="submit" value="ȷ�ϲ���" /> ������ȫѡ
		</div>
		<div class="floatr">
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="10"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var keywords = $("#keywords").val();
	location.href=url+"&keywords="+keywords;
}

</script>
{/literal}

{elseif $_A.query_type == "zhaopin_edit"}

<div class="module_add">
	<form name="form1" method="post" action="" enctype="multipart/form-data">
	<div class="module_title"><strong>�鿴�޸���Ƹ��Ϣ</strong></div>
	
	<div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			{ $_A.company_result.company_name}
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">�����û���</div>
		<div class="c">
			{ $_A.company_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="1" {if  $_A.company_result.status==1} checked="checked"{/if} />��ʾ <input type="radio" name="status" value="0"{if  $_A.company_result.status==0} checked="checked"{/if} />���� 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��λ���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  value="{$_A.company_result.name}" size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ƹ������</div>
		<div class="c">
			<input type="text" name="num"  value="{$_A.company_result.num}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ص㣺</div>
		<div class="c">
			<script src="/plugins/index.php?q=area&area={$_A.company_result.area}"></script> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			<textarea name="description" cols="35" rows="5">{$_A.company_result.description}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			<textarea name="demand" cols="35" rows="5">{$_A.company_result.demand }</textarea>
		</div>
	</div>
	
	
	<div class="module_submit border_b" >
		<input type="hidden" name="id" value="{ $_A.company_result.id }" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if ($("#site_center").val()==""){
		errorMsg += '��ѡ����Ŀ' + '\n';
	}
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "news_edit"}

<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>�鿴�޸�������Ϣ</strong></div>
	
	<div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			{ $_A.company_result.company_name}
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">�����û���</div>
		<div class="c">
			{ $_A.company_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="1" {if  $_A.company_result.status==1} checked="checked"{/if} />��ʾ <input type="radio" name="status" value="0"{if  $_A.company_result.status==0} checked="checked"{/if} />���� 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="name"  value="{$_A.company_result.name}" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.company_result.content"}
		</div>
	</div>
	

	
	<div class="module_submit border_b" >
		<input type="hidden" name="id" value="{ $_A.company_result.id }" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if ($("#site_center").val()==""){
		errorMsg += '��ѡ����Ŀ' + '\n';
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