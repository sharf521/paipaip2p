{if $_A.query_type == "list" }
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/type_action" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">��������</td>
		<td class="main_td">��ʾ��</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.remind_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td  >{ $item.id}</td>
		<td  ><input type="text" value="{$item.name}" name="name[]" /></td>
		<td  width="*">{$item.nid}</td>
		<td  ><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td  width="130"><a href="{$_A.query_url}/new&id={$item.id}">����</a> / <a href="{$_A.query_url}/type_edit&id={$item.id}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/type_del&id={$item.id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr >
		<td colspan="8"  class="page">
			{$_A.showpage}
		</td>
	</tr>
	<tr >
		<td colspan="8"  class="submit">
			<input type="submit" name="submit" value="�޸�����" />
		</td>
	</tr>
	</form>	
</table>

{elseif $_A.query_type == "new" || $_A.query_type == "edit"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="{$_A.query_url}/actions" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">��������</td>
		<td class="main_td">����</td>
		<td class="main_td">��ʶ��</td>
		<td class="main_td">����Ϣ</td>
		<td class="main_td">����</td>
		<td class="main_td">�ֻ�����</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.remind_list.list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td >{$item.id}</td>
		<td >{$_A.remind_type_result.name}</td>
		<td ><input type="text" value="{$item.name}" name="name[]" size="15" /></td>
		<td ><input type="text" value="{$item.nid}" name="nid[]" size="15" /></td>
		<td >
			<select name="message[]">
				<option value="1" {if $item.message==1} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="2" {if $item.message==2} selected="selected"{/if}>��ѡδѡ</option>
				<option value="3" {if $item.message==3} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="4" {if $item.message==4} selected="selected"{/if}>��ѡδѡ</option>
			</select>
			{if $item.message==1}<input type="checkbox" disabled="disabled" checked="checked" />{elseif $item.message==2} <input type="checkbox" disabled="disabled"/>{elseif $item.message==3} <input type="checkbox" checked="checked" />{elseif $item.message=4} <input type="checkbox" />{/if}
		</td>
		<td >
			<select name="email[]">
				<option value="1" {if $item.email==1} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="2" {if $item.email==2} selected="selected"{/if}>��ѡδѡ</option>
				<option value="3" {if $item.email==3} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="4" {if $item.email==4} selected="selected"{/if}>��ѡδѡ</option>
			</select>
			{if $item.email==1}<input type="checkbox" disabled="disabled" checked="checked" />{elseif $item.email==2} <input type="checkbox" disabled="disabled"/>{elseif $item.email==3} <input type="checkbox" checked="checked" />{elseif $item.email=4} <input type="checkbox" />{/if}
		</td>
		<td >
			<select name="phone[]">
				<option value="1" {if $item.phone==1} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="2" {if $item.phone==2} selected="selected"{/if}>��ѡδѡ</option>
				<option value="3" {if $item.phone==3} selected="selected"{/if}>��ѡ��ѡ</option>
				<option value="4" {if $item.phone==4} selected="selected"{/if}>��ѡδѡ</option>
			</select>
			{if $item.phone==1}<input type="checkbox" disabled="disabled" checked="checked" />{elseif $item.phone==2} <input type="checkbox" disabled="disabled"/>{elseif $item.phone==3} <input type="checkbox" checked="checked" />{elseif $item.phone=4} <input type="checkbox" />{/if}
		</td>
		<td  ><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td ><!--<a href="{$_A.query_url}/subnew&id={$item.type_id}&pid={$item.id}">����</a> /--> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
<tr >
	<td colspan="6"  class="submit">
		<input type="submit" name="submit" value="�޸�" />
	</td>
</tr>
</form>	
</table>

<div class="module_add">
<form name="form1" method="post" action="" onsubmit="return check_form()" >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if} ({$_A.remind_type_result.name}) �����µ�����</strong></div>
	
	<div class="module_border">
		<div class="l">�������</div>
		<div class="c">
			{$_A.remind_type_result.name}
		</div>
	</div>

	<div class="module_border">
		<div class="l">���ƣ�</div>
		<div class="c">
			<input type="text" name="name"  value="{$_A.remind_result.name}"/> *
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʶ����</div>
		<div class="c">
			<input type="text" name="nid"  value="{$_A.remind_result.nid}" /> *
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  value="{$_A.remind_result.order|default:10}" onkeyup="value=value.replace(/[^0-9]/g,'')"/>
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ţ�</div>
		<div class="c">
			<select name="message">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
			(����״̬�������£�<input type="checkbox" disabled="disabled" checked="checked" />��ѡ��ѡ <input type="checkbox" disabled="disabled"/>��ѡδѡ <input type="checkbox" checked="checked" />��ѡ��ѡ <input type="checkbox" />��ѡδѡ��
		</div>
	</div>
	
	
	
	<div class="module_border">
		<div class="l">���䣺</div>
		<div class="c">
			<select name="email">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</div>
	</div>
	
	
	
	<div class="module_border">
		<div class="l">�ֻ���</div>
		<div class="c">
			<select name="phone">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</div>
	</div>
	
	<div class="module_submit" >
		<input type="hidden" name="type_id" value="{$magic.request.id}" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</form>
</div>
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="{$_A.query_url}/actions" method="post">
	<tr >
		<td class="main_td" colspan="6" align="left">&nbsp;�������</td>
	</tr>
	<tr  class="tr2">
		<td >����</td>
		<td >��ʶ��</td>
		<td>����Ϣ</td>
		<td >����</td>
		<td >�ֻ�����</td>
		<td >����</td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td>
			<select name="message[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="email[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="phone[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td>
			<select name="message[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="email[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="phone[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td>
			<select name="message[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="email[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="phone[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td>
			<select name="message[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="email[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="phone[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td>
			<select name="message[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="email[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td>
			<select name="phone[]">
				<option value="1">��ѡ��ѡ</option>
				<option value="2">��ѡδѡ</option>
				<option value="3">��ѡ��ѡ</option>
				<option value="4">��ѡδѡ</option>
			</select>
		</td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	
	<input type="hidden" name="type_id" value="{$magic.request.id}" />
<tr >
	<td colspan="6"  class="submit">
		<input type="submit" name="submit" value="ȷ�����" />
	</td>
</tr>
</form>	
</table>
{literal}
<script>
function check_form(){
	
	var frm = document.forms['form1'];
	var title = frm.elements['name'].value;
	
	 var errorMsg = '';
	  if (title == "") {
		errorMsg += '���ѵ����Ʊ�����д' + '\n';
	  }
	 
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "subnew" || $_A.query_type == "subedit"}

<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	 <form action="{$_A.query_url}/order" method="post">
	<tr >
		<td class="main_td">����</td>
		<td class="main_td">����</td>
		<td class="main_td">��������</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$result key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td  width="250"><input type="text" value="{$item.name}" name="name[]" /></td>
		<td  width="150">{$liandong_type.typename}</td>
		<td  width="150">{$liandong_sub.name}</td>
		<td  ><input type="text" value="{$item.order|default:10}" name="order[]" size="5" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td  width="130"><a href="{$_A.query_url}/subnew&id={$item.type_id}&pid={$item.id}">����</a> / <a href="{$_A.query_url}/edit&id={$item.id}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
<tr >
	<td colspan="6"  class="submit">
		<input type="submit" name="submit" value="�޸�����" />
	</td>
</tr>
</form>	

<form action="" method="post">
	<tr >
		<td colspan="6" class="action">
			<strong>�����������ͣ�</strong>{$liandong_type.typename} -> <input type="text" name="name" /> <input type="submit" name="submit" value="���" /> <input type="hidden" name="pid" value="{$magic.request.pid|default:0}" /><input type="hidden" name="type_id" value="{$magic.request.id}" />
		</td>
	</tr>
	</form>	
</table>
{elseif $_A.query_type == "type_new" || $_A.query_type == "type_edit"}
<div class="module_add">

	<form name="form1" method="post" action="" >
	<div class="module_title"><strong>{ if $_A.query_type == "type_edit" }�༭{else}���{/if}��������</strong></div>
	
	<div class="module_border">
		<div class="l">�����������ƣ�</div>
		<div class="c">
			<input type="text" name="name" value="{$_A.remind_type_result.name}" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���ѵı�ʶ����</div>
		<div class="c">
			<input type="text" name="nid"  value="{$_A.remind_type_result.nid}" onkeyup="value=value.replace(/[^a-z_]/g,'')"/>
		</div>
	</div>

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  value="{$_A.remind_type_result.order|default:10}"  onkeyup="value=value.replace(/[^0-9]/g,'')"/>
		</div>
	</div>
	
	<div class="module_submit" >
		{if $_A.query_type=="type_edit"}<input type="hidden" name="id" value="{$magic.request.id}" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>
{if $_A.query_type == "type_new" }
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="{$_A.query_url}/type_action" method="post">
	<tr >
		<td class="main_td" colspan="6" align="left">&nbsp;�������</td>
	</tr>
	<tr  class="tr2">
		<td >������������</td>
		<td >���ѵı�ʶ��</td>
		<td  >����</td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td  ><input type="text" name="order[]"  value="10"size="5" /></td>
	</tr>
	<tr >
		<td ><input type="text"  name="name[]" /></td>
		<td ><input type="text" name="nid[]" /></td>
		<td  ><input type="text" name="order[]" value="10" size="5" /></td>
	</tr>
	
<tr >
	<td colspan="6"  class="submit">
		<input type="hidden" name="type" value="add" />
		<input type="submit" name="submit" value="ȷ�����" />
	</td>
</tr>
</form>	
</table>
{/if}
{/if}