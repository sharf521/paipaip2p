<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="admin_head.html.php"}

<!--ģ���б� ��ʼ-->
{if $_A.query_class == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">���</td>
		<td width="*" class="main_td">����</td>
		<th width="" class="main_td">����</th>
		<th width="" class="main_td">�汾</th>
		<th width="" class="main_td">����</th>
		<th width="" class="main_td">����ʱ��</th>
	</tr>
	{ foreach  from=$_A.module_list key=key item=item}
	{if $item.type!='admin'}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td align="center">{ $item.code}</td>
		<td align="center">{$item.name}</td>
		<td align="center">{$item.description}</td>
		<td align="center">{$item.version|default:"-"}</td>
		<td align="center">{$item.author|default:"-"}</td>
		<td align="center">{$item.date|default:"-"}</td>
		
	</tr>
	{/if}
	{ /foreach}	
</table>
<!--ģ���б� ����-->	

<!--ģ����� ��ʼ-->	
{elseif $_A.query_class=="channel"}

	<!--�Ѱ�װģ���б� ��ʼ-->
	{if $_A.query_type== "install"}
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<tr >
			<td width="" class="main_td">���</td>
			<td width="*" class="main_td">����</td>
			<th width="" class="main_td">����</th>
			<th width="" class="main_td">�汾</th>
			<th width="" class="main_td">����</th>
			<td width="" class="main_td">����</td>
		</tr>
		<form action="{$_A.query_url}/order" method="post">
		{ foreach  from=$_A.module_list key=key item=item}
		{if $item.type!='admin'}
		<tr {if $key%2==1}class="tr2"{/if}>
			<td align="center">{ $item.code}</td>
			<td align="center">{$item.name}</td>
			<td align="center">{$item.description}</td>
			<td align="center">{$item.version|default:"-"}</td>
			<td align="center"><input name="order[]" type="text" value="{ $item.order}" size="6"  /><input name="module_id[]" type="hidden" value="{ $item.module_id}" size="6"  /></td>
			<td align="center" ><a href="{$_A.admin_url}&q=module/fields&code={ $item.code}">�ֶ�</a> | <a href="{$_A.query_url}/edit&code={ $item.code}">�༭</a> |  <a href="#" onClick="javascript:if(confirm('��ȷ���Ƿ�Ҫж�ش�ģ�飬��ģ��ж�غ����е����ݶ�����գ������ش���')) location.href='{$_A.query_url}/del&code={$item.code}'">ж��</a> | <a href="{$_A.admin_url}&q=module/{$item.code}">���ݹ���</a></td>
		</tr>
		{/if}
		{ /foreach}
		<tr >
			<td  colspan="6" class="submit" ><input type="submit" value="�޸�����" />
				<input value="�����ģ��" type="button" onclick="javascript:location='{$_A.query_url}/new';" /> </div>	
			</td>
		</tr>
		</form>
	</table>
	<!--�Ѱ�װģ���б� ����-->
	
	<!--δ��װģ���б� ��ʼ-->
	{elseif $_A.query_type== "unstall"}
	<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
		<td class="main_td">ʶ��ID</td>
		<td width="*" class="main_td">ģ������</td>
		<td width="*" class="main_td">ģ����</td>
		<td width="*" class="main_td">�汾��</td>
		<td class="main_td">����</td>
		<th class="main_td">״̬</th>
	</tr>
	{ foreach  from=$_A.module_list key=key item=item}
		<tr  {if $key%2==1}class="tr2"{/if}>
		<td  >{ $item.code}</td>
		<td >{ $item.name}</td>
		<td >{ $item.description}</td>
		<td >{ $item.version}</td>
		<td  >{$item.type}</td>
		<td  ><a href="{$_A.admin_url}&q=module/channel/new&code={$item.code}">��װ</a></td>
	</tr>
	{ /foreach}
	</table>
	<!--δ��װģ���б� ����-->
	
	<!--ģ��༭ ��ʼ-->
	{elseif $_A.query_type== "edit" || $_A.query_type== "new"}
	<div class="module_add">
		<form action="" method="post" name="form1" onsubmit="return check_form();" >
		<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}ģ��</strong></div>
		
		<div class="module_border">
			<div class="l">ģ�����ƣ�</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="name" value="{$_A.module_result.name}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">ʶ��ID��code����</div>
			<div class="c">
				{ if $_A.query_type=="edit" || ($_A.query_type=="new" && $_A.module_result.code!="")}{$_A.module_result.code}<input type="hidden" name="code" value="{$_A.module_result.code}" />{ else}
				<input type="text" align="absmiddle" name="code" value="" class="input_border" onkeyup="value=value.replace(/[^a-z_]/g,'')" />{ /if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">���ͣ�</div>
			<div class="c">
				{$_A.module_result.type|default:'cms'}<input type="hidden" name="type" value="{$_A.module_result.type|default:'cms'}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">����</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="order" value="{$_A.module_result.order|default:10}" size="4"/>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">״̬��</div>
			<div class="c">
				<select name="status" class="input_border">
				<option value="1" { if $_A.module_result.status=='1' || $_A.module_result.status==""} selected="selected"{ /if}>����</option>
				<option value="0"  { if $_A.module_result.status=='0'} selected="selected"{ /if}>�ر�</option>
			  </select>
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">ģ���ѡ�</div>
			<div class="c">
				<label><input type="checkbox" name="default_field[]" value="title" checked="checked" disabled="disabled"/>����</label> {if $_A.query_type == "new"}{ html_checkboxes name="default_field" options="$_A.article_fields" checked="all" }{else}{ html_checkboxes name="default_field" options="$_A.article_fields" checked="$_A.module_result.default_field"  }{/if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�������ƣ�</div>
			<div class="c">
				<input type="text" align="absmiddle" name="title_name" value="{$_A.module_result.title_name|default:"����"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�����Զ����ֶΣ�</div>
			<div class="c">
				<input type="radio" name="fields" value="1" {if  $_A.module_result.fields==1} checked="checked"{/if}/> �� <input type="radio" name="fields" value="0" {if $_A.module_result.fields==0 || $_A.module_result.fields==""} checked="checked"{/if} /> ��
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�Ƿ�֧�ֻ�ԱͶ�壺</div>
			<div class="c">
				<input type="radio" name="issent" value="1" {if  $_A.module_result.issent==1} checked="checked"{/if}/> �� <input type="radio" name="issent" value="0" {if $_A.module_result.issent==0 || $_A.module_result.issent==""} checked="checked"{/if} /> ��
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ͷ���Ƿ�Ψһ��</div>
			<div class="c">
				<input type="radio" name="onlyone" value="1" {if $_A.module_result.onlyone==1} checked="checked"{/if}/> �� <input type="radio" name="onlyone" value="0" {if $_A.module_result.onlyone==0 || $_A.module_result.onlyone==""} checked="checked"{/if} /> ��
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ͷ���������ͣ�</div>
			<div class="c">
				<input type="radio" name="article_status" value="1" {if $_A.module_result.article_status==1} checked="checked"{/if}/> ����� <input type="radio" name="article_status" value="0" {if $_A.module_result.article_status==0 || $_A.module_result.article_status==""} checked="checked"{/if} /> δ���
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ĭ�Ϸ������ͣ�</div>
			<div class="c">
				 <input type="radio" name="visit_type" value="0" {if $_A.module_result.visit_type==0 || $_A.module_result.visit_type==""} checked="checked"{/if}  title="�磺?3/1"/> ��̬���� <input type="radio" name="visit_type" value="1" {if $_A.module_result.visit_type==1} checked="checked"{/if} title="�磺?article/dongtai/1.html"/> α��̬ <input type="radio" name="visit_type" value="2" {if $_A.module_result.visit_type==2} checked="checked"{/if}/ title="�磺/article/dongtai/1.html"> ����html
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ĭ�Ϸ���ģ�壺</div>
			<div class="c">
				<input type="text" align="absmiddle" name="index_tpl" value="{$_A.module_result.index_tpl|default:"[code].html"}" class="input_border"  />[code]��ʾ��ģ���ʶ��id����������
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ĭ���б�ģ�壺</div>
			<div class="c">
				<input type="text" align="absmiddle" name="list_tpl" value="{$_A.module_result.list_tpl|default:"[code]_list.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">Ĭ������ģ�壺</div>
			<div class="c">
				<input type="text" align="absmiddle" name="content_tpl" value="{$_A.module_result.content_tpl|default:"[code]_content.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">����ģ�壺</div>
			<div class="c">
				<input type="text" align="absmiddle" name="search_tpl" value="{$_A.module_result.search_tpl|default:"[code]_search.html"}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">��飺</div>
			<div class="c">
				<input type="text" align="absmiddle" name="description" value="{$_A.module_result.description}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�汾��</div>
			<div class="c">
				<input type="text" align="absmiddle" name="version" value="{$_A.module_result.version|default:'1.0'}" class="input_border"  />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">���ߣ�</div>
			<div class="c">
				<input type="text" align="absmiddle" name="author" value="{$_A.module_result.author|default:'hycms'}" class="input_border"  />
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
	<!--ģ��༭ ����-->
	
	<!--����ģ���б� ��ʼ-->
	{elseif $_A.query_type== "list"}
	<table width="100%" border="0" cellpadding="5" cellspacing="1" >
		<tr>
		  <td width="11%" class="main_td">ʶ��ID</td>
		  <td width="*" class="main_td">ģ������</td>
		  <td width="*" class="main_td">ģ����</td>
		  <td width="*" class="main_td">�汾��</td>
		  <td width="18%" class="main_td">����</td>
		  <th width="22%" class="main_td">״̬</th>
		</tr>
		{ foreach  from=$_A.module_list key=key item=item}
		<tr  {if $key%2==1}class="tr2"{/if}>
		  <td  >{ $item.code}</td>
		  <td >{ $item.name}</td>
		  <td >{ $item.description}</td>
		  <td >{ $item.version}</td>
		  <td  >{$item.type}</td>
		  <td  >{if $item.status == 1}<font color="#009900">�Ѱ�װ</font>{else}<font color="#FF0000">δ��װ</font>{/if}</td>
		</tr>
		{ /foreach}
	</table>
	<!--����ģ���б� ����-->
	{/if}
<!--ģ����� ����-->


<!--�ֶι��� ��ʼ-->
{elseif $_A.query_class=="fields"}

	{if $_A.query_type== "list"}
	<!--�ֶ��б� ��ʼ-->
	<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#dddddd">
		<tr class="tr">
		  <td class="main_td">�ֶ�����</td>
		  <td class="main_td">��ʶ��</td>
		  <td class="main_td">�ֶ�����</td>
		  <td class="main_td">����</td>
		  <td class="main_td">��������</td>
		  <td class="main_td">����</td>
		  <th class="main_td">����</th>
		</tr>
		<form action="{$_A.query_url}/order" method="post">
		{ foreach  from=$_A.fields_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center">{ $item.name}</td>
			<td class="main_td1"align="center">{ $item.nid}</td>
			<td  class="main_td1">{ $item.type}</td>
			<td  class="main_td1">{ $item.size|default:"-"}</td>
			<td class="main_td1">{ $item.input}</td>
			<td class="main_td1"><input name="order[]" type="text" value="{ $item.order}" size="6"  />
			<input name="fields_id[]" type="hidden" value="{ $item.fields_id}"  /></td>
			<td class="main_td1"> <a href="{$_A.query_url}/edit&code={$item.code}&fields_id={ $item.fields_id}">�޸�</a> | <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&code={$item.code}&fields_id={ $item.fields_id}'">ɾ��</a> </td>
		</tr>
		{ /foreach}
		<tr >
			<td  colspan="7" class="submit" >
			<input type="submit" value="�޸�����" />&nbsp;&nbsp;&nbsp;&nbsp;
			<input value="������ֶ�" type="button" onclick="javascript:location='{$_A.query_url}/new&code={$magic.request.code}';" /> 
			</td>
		</tr>
		</form>
	</table>
	<!--�ֶ��б� ����-->
	
	<!--����ֶ� ��ʼ-->
	{elseif $_A.query_type== "new" || $_A.query_type== "edit"}
	<div class="module_add">
	<form action="" method="post" name="form1"  onsubmit="return check_form()">
	
		<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}�ֶ�</strong></div>
		
		<div class="module_border">
			<div class="l">�ֶ����ƣ�</div>
			<div class="c">
				<input type="text" class="input_border" align="absmiddle" name="name" value="{$_A.fields_result.name}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">��ʾ����</div>
			<div class="c">
				{ if $_A.query_type=='new'}
			  <input type="text" align="absmiddle" name="nid" class="input_border"  onkeyup="value=value.replace(/[^a-z_]/g,'')"/>ֻ��Ϊ��ĸ���»���{ else}{$_A.fields_result.nid}<input type="hidden" align="absmiddle" name="nid" value="{$_A.fields_result.nid}"    />{ /if}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">����</div>
			<div class="c">
				<input type="text" align="absmiddle" name="order" value="{$_A.fields_result.order|default:10}"  />	 
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�������ͣ�</div>
			<div class="c">
				{html_options options =$_A.fields_input selected =$_A.fields_result.input name="input"}
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�ֶ����ͣ�</div>
			<div class="c">
				{html_options options =$_A.fields_type selected =$_A.fields_result.type name="type"}
			</div>
		</div>
	   
		<div class="module_border">
			<div class="l">Ĭ��ֵ��</div>
			<div class="c">
				<input name="default" id="default" type="text" value="{$_A.fields_result.default}"/>
			</div>
		</div>
		 <div class="module_border">
			<div class="l">�ֶο�ѡ��</div>
			<div class="c">
				<input name="select" type="text"  value="{$_A.fields_result.select}"/> �����ѡֵ����,�Ÿ���
			</div>
		</div>
		
		<div class="module_border">
			<div class="l">�ֶ�������</div>
			<div class="c">
				<textarea name="description" cols="50" rows="7" >{$_A.fields_result.description}</textarea>
			</div>
		</div>
		
		<div class="module_submit">
			<input name="code" type="hidden" value="{ $magic.request.code}"  />
			<input name="fields_id" type="hidden" value="{ $magic.request.fields_id}"  />
			<input type="submit" value=" �� �� " class="submitstyle" name="submit_ok" />
			<input name="reset" type="reset" class="submitstyle" value=" �� �� " /></td>
		</div>
		</form>
	</div>
	
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
	<!--����ֶ� ����-->
	{/if}
<!--�ֶι��� ����-->


{elseif $_A.query_class=="update"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">

<form action="{$_A.query_url}/{$result.type}&code={$magic.request.code}" method="post" name="form1" >

	<tr>
		<td align="right"  width="15%">ģ�����ƣ�</td>
		<td align="left"  >{$result.name}
	  </td>
	</tr>
<tr>
		<td align="right"  width="15%">ģ���ʶ��</td>
		<td align="left"  >{$result.code}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">���½��ܣ�</td>
		<td align="left"  >{$result.description}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">���°汾��</td>
		<td align="left"  >{$result.version}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">���ͣ�</td>
		<td align="left"  >{$result.type}
	  </td>
	</tr>
	<tr>
		<td align="right"  width="15%">����ʱ�䣺</td>
		<td align="left"  >{$result.date}
	  </td>
	</tr>
	<tr  >
		<td    colspan="2">
		<input type="hidden" name="list_code" value="{$result.code}" />
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" ȷ�ϸ��� "  name="submit_ok" />
		</td>
	</tr>
</table>
</form>
{else}
	{include file="$module_tpl" template_dir="$template_dir"}
{/if}


{include file="admin_foot.html"}

