<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{if $_A.query_class=="new" || $_A.query_class=="edit"}
<div class="module_add">

	<form action="{if $_A.query_class=="new" && $result.code!=""}{ $query_site}&q=module/{$result.code}/install{else}{ $url}/{ if $_A.query_class=="new"}add{ else}update{ /if}{ /if}" method="post" name="form1" onsubmit="return check_form();" >
	<div class="module_title"><strong>{ if $_A.query_class == "edit" }�༭{else}����{/if}ģ��</strong></div>
	
	<div class="module_border">
		<div class="l">ģ�����ƣ�</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="name" value="{ $result.name}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ʶ��ID��code����</div>
		<div class="c">
			{ if $_A.query_class=="edit" || ($_A.query_class=="new" && $result.code!="")}{ $result.code}<input type="hidden" name="code" value="{ $result.code}" />{ else}
			<input type="text" align="absmiddle" name="code" value="" class="input_border" onkeyup="value=value.replace(/[^a-z_]/g,'')" />{ /if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ͣ�</div>
		<div class="c">
			{ $result.type|default:'cms'}<input type="hidden" name="type" value="{ $result.type|default:'cms'}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="order" value="{ $result.order|default:10}" size="4"/>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<select name="status" class="input_border">
			<option value="1" { if $result.status=='1' || $result.status==""} selected="selected"{ /if}>����</option>
			<option value="0"  { if $result.status=='0'} selected="selected"{ /if}>�ر�</option>
		  </select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ģ���ѡ�</div>
		<div class="c">
			<label><input type="checkbox" name="default_field[]" value="title" checked="checked" disabled="disabled"/>����</label> {if $_A.query_class == "new"}{ html_checkboxes name="default_field" options=$_A.article_fields checked=all }{else}{ html_checkboxes name="default_field" options=$_A.article_fields checked=$result.default_field  }{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ƣ�</div>
		<div class="c">
			<input type="text" align="absmiddle" name="title_name" value="{$result.title_name|default:"����"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƿ������ֶ���չ��</div>
		<div class="c">
			<input type="radio" name="fields" value="1" {if $result.fields==1} checked="checked"{/if}/> �� <input type="radio" name="fields" value="0" {if $result.fields==0 || $result.fields==""} checked="checked"{/if} /> �� (���õĻ��ֶν������Զ�������ӣ��޸�)
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƿ�֧�ֻ�ԱͶ�壺</div>
		<div class="c">
			<input type="radio" name="issent" value="1" {if $result.issent==1} checked="checked"{/if}/> �� <input type="radio" name="issent" value="0" {if $result.issent==0 || $result.issent==""} checked="checked"{/if} /> ��
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ͷ���Ƿ�Ψһ��</div>
		<div class="c">
			<input type="radio" name="onlyone" value="1" {if $result.onlyone==1} checked="checked"{/if}/> �� <input type="radio" name="onlyone" value="0" {if $result.onlyone==0 || $result.onlyone==""} checked="checked"{/if} /> ��
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ͷ���������ͣ�</div>
		<div class="c">
			<input type="radio" name="article_status" value="1" {if $result.article_status==1} checked="checked"{/if}/> ����� <input type="radio" name="article_status" value="0" {if $result.article_status==0 || $result.article_status==""} checked="checked"{/if} /> δ���
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ĭ�Ϸ������ͣ�</div>
		<div class="c">
			 <input type="radio" name="visit_type" value="0" {if $result.visit_type==0 || $result.visit_type==""} checked="checked"{/if}  title="�磺?3/1"/> ��̬���� <input type="radio" name="visit_type" value="1" {if $result.visit_type==1} checked="checked"{/if} title="�磺?article/dongtai/1.html"/> α��̬ <input type="radio" name="visit_type" value="2" {if $result.visit_type==2} checked="checked"{/if}/ title="�磺/article/dongtai/1.html"> ����html
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ĭ�Ϸ���ģ�壺</div>
		<div class="c">
			<input type="text" align="absmiddle" name="index_tpl" value="{$result.index_tpl|default:"[code].html"}" class="input_border"  />[code]��ʾ��ģ���ʶ��id����������
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ĭ���б�ģ�壺</div>
		<div class="c">
			<input type="text" align="absmiddle" name="list_tpl" value="{$result.list_tpl|default:"[code]_list.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ĭ������ģ�壺</div>
		<div class="c">
			<input type="text" align="absmiddle" name="content_tpl" value="{$result.content_tpl|default:"[code]_content.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ģ�壺</div>
		<div class="c">
			<input type="text" align="absmiddle" name="search_tpl" value="{$result.search_tpl|default:"[code]_search.html"}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��飺</div>
		<div class="c">
			<input type="text" align="absmiddle" name="description" value="{$result.description}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�汾��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="version" value="{$result.version|default:'1.0'}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ߣ�</div>
		<div class="c">
			<input type="text" align="absmiddle" name="author" value="{$result.author|default:'hycms'}" class="input_border"  />
		</div>
	</div>
	
	<div class="module_submit border_b" >
		<input type="submit" value=" �� �� " class="submitstyle" name="submit_ok" />&nbsp;&nbsp;
		<input name="reset" type="reset" class="submitstyle" value=" �� �� " />
	</div>
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var code = frm.elements['code'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += 'ģ�����Ʊ�����д' + '\n';
	  }
	  if (code.length == 0 ) {
		errorMsg += 'ʶ��id������д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}

{elseif $_A.query_class=="list"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
	  <td width="6%"class="main_td" >ID</td>
	  <td width="*" class="main_td">ģ������</td>
	  <td width="11%" class="main_td">ʶ��ID</td>
	  <td width="18%" class="main_td">����</td>
	  <td width="10%"class="main_td" >����</td>
	  <th width="22%" class="main_td">����</th>
	</tr>
	<form action="{$url}/order" method="post">
	{ foreach  from=$result key=key item=item}
	<tr  {if $key%2==1}class="tr2"{/if}>
	  <td align="center" bgcolor="#FFFFFF">{ $item.module_id}
      <input name="code[]" type="hidden" value="{$item.code}"  /></td>
	  <td bgcolor="#FFFFFF">{ $item.name}</td>
	  <td bgcolor="#FFFFFF" >{ $item.code}</td>
	  <td bgcolor="#FFFFFF" >{$item.type}</td>
	
      <td align="center" bgcolor="#FFFFFF" ><input name="order[]" type="text" value="{ $item.order}" size="6"  /><input name="module_id[]" type="hidden" value="{ $item.module_id}" size="6"  /></td>
	  <td bgcolor="#FFFFFF" ><a href="{ $url}/field&code={ $item.code}">�ֶ�</a> | <a href="{$url}/edit&code={ $item.code}">�༭</a> |<a href="{$query_site}&q=module/{$item.code}">����</a> </td>
	</tr>
	{ /foreach}

	<tr >
	  <td  colspan="6" class="submit" ><input type="submit" value="�޸�����" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="������ģ��" type="button" onclick="javascript:location='{$url}/new';" /> </div>	
	</td>
	</tr></form>

</table>
{ elseif $_A.query_class=="field"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">

	<tr class="tr">
	  <td width="*"  class="main_td">�ֶ�����</td>
	  <td width="10%"  class="main_td">��ʶ��</td>
	  <td width="10%" class="main_td">�ֶ�����</td>
	  <td width="14%" class="main_td">����</td>
	  <td width="14%" class="main_td">��������</td>
	  <td width="14%" class="main_td">����</td>
	  <th width="17%" class="main_td">����</th>
	</tr>
	<form action="{ $url}/field_order" method="post">
	{ if $result!=""}
	{ foreach  from=$result key=key item=item}
	<tr  {if $key%2==1} class="tr2"{/if}>
	  <td class="main_td1" align="center">{ $item.name}<input name="fields_id[]" type="hidden" value="{ $item.fields_id}"  /></td>
	   <td class="main_td1"align="center">{ $item.nid}</td>
	  <td  class="main_td1">{ $item.type}</td>
	   <td  class="main_td1">{ $item.size|default:"-"}</td>
	  <td class="main_td1">{ $item.input}</td>
	  <td class="main_td1"><input name="order[]" type="text" value="{ $item.order}" size="6"  /></td>
	  <td class="main_td1"> <a href="{ $url}/field_edit&code={$item.code}&nid={ $item.nid}">�޸�</a> | <a href="{ $url}/field_del&code={$item.code}&nid={ $item.nid}">ɾ��</a> </td>
	</tr>
	{ /foreach}
	{ /if}
	<tr >
	  <td  colspan="7" class="submit" ><input type="submit" value="�޸�����" />&nbsp;&nbsp;&nbsp;&nbsp;<input value="�������ֶ�" type="button" onclick="javascript:location='{ $url}/field_new&code={$magic.request.code}';" /> 
	</td>
	</tr></form>

	</table>
{ elseif $_A.query_class=="field_new" || $_A.query_class=="field_edit"}
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var nid = frm.elements['nid'].value;
	 var input = frm.elements['input'].value;
	 var selecte = frm.elements['select'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '�ֶ����Ʊ�����д' + '\n';
	  }
	   if (nid.length == 0 ) {
		errorMsg += '��ʾ��������д' + '\n';
	  }
	   if ((input == "select" || input == "checkbox" || input == "radio") && selecte=="") {
		errorMsg += '��ѡ����������ͱ���Ҫ��д�ֶεĿ�ѡֵ����Ӣ�ĵ�","����' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }

}

</script>
{/literal}
<div class="module_add">

	<form action="{ $url}/field_{ if $_A.query_class=='field_new'}add{ else}update{ /if}&code={$magic.request.code}" method="post" name="form1"  onsubmit="return check_form()">
<input name="code" type="hidden" value="{ $magic.request.code}"  />
	<div class="module_title"><strong>{ if $_A.query_class == "edit" }�༭{else}����{/if}�ֶ�</strong></div>
	
	<div class="module_border">
		<div class="l">�ֶ����ƣ�</div>
		<div class="c">
			<input type="text" class="input_border" align="absmiddle" name="name" value="{ $result.name}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʾ����</div>
		<div class="c">
			{ if $_A.query_class=='field_new'}
		  <input type="text" align="absmiddle" name="nid" class="input_border"  onkeyup="value=value.replace(/[^a-z_]/g,'')"/>ֻ��Ϊ��ĸ���»���{ else}{ $result.nid}<input type="hidden" align="absmiddle" name="nid" value="{ $result.nid}"    />{ /if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" align="absmiddle" name="order" value="{ $result.order|default:10}"  />	 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			{html_options options =$fields_input selected =$result.input name="input"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ֶ����ͣ�</div>
		<div class="c">
			{html_options options =$fields_type selected ="$result.type" name="type"}
		</div>
	</div>
   
    <div class="module_border">
		<div class="l">Ĭ��ֵ��</div>
		<div class="c">
			<input name="default" id="default" type="text" value="{ $result.default}"/>
		</div>
	</div>
     <div class="module_border">
		<div class="l">�ֶο�ѡ��</div>
		<div class="c">
			<input name="select" type="text"  value="{ $result.select}"/> �����ѡֵ����,�Ÿ���
		</div>
	</div>
	
    <div class="module_border">
		<div class="l">�ֶ�������</div>
		<div class="c">
			<textarea name="description" cols="50" rows="7" >{ $result.description}</textarea>
		</div>
	</div>
	
	<div class="module_submit">
		<input type="submit" value=" �� �� " class="submitstyle" name="submit_ok" />
      <input name="reset" type="reset" class="submitstyle" value=" �� �� " /></td>
	</div>
	</form>
</div>
{ /if}