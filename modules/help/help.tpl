{if $t == "new" || $t == "edit"}
<div class="module_add">
	
	<form name="form1" method="post" action="{$url}/{ if $t == "edit" }update{else}add{/if}{$site_url}" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>{ if $t == "edit" }�༭{else}���{/if}����</strong></div>
	

	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $result.name}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
			{loop table="flag" order="`order` desc" var="var"}<input type="checkbox" name="flag[]" value="{$var.nid}" {$var.nid|checked:$result.flag } />{$var.name} {/loop}
		</div>
	</div>

	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $result.status ==1 ||$result.status ==""}checked="checked"{/if}/>��ʾ </div>
	</div>

	<div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			<select name="type_id"><option value="0">Ĭ������</option>{foreach from=$list item=item key=key}
<option value="{$item.type_id}" {if $result.type_id == $item.type_id} selected="selected"{/if} >-{$item.aname}</option>
{ /foreach}</select></div>
	</div>

	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $result.order|default:10}" size="10" />
		</div>
	</div>

	<div class="module_border" {if $field.litpic==false}style="display:none"{/if} id="jump_url">
		<div class="l">����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $result.litpic!=""}<a href="./{$result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearlitpic" value="1" />ȥ������ͼ{/if}</div>
	</div>
	
	<div class="module_border">
		<div class="l">������Դ��</div>
		<div class="c">
			<input type="text" name="source"  class="input_border" value="{ $result.source}" size="30" /></div>
	</div>

	<div class="module_border">
		<div class="l">���ߣ�</div>
		<div class="c">
			<input type="text" name="author"  class="input_border" value="{ $result.author}" size="30" /></div>
	</div>

	<div class="module_border">
		<div class="l">���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=procity&area_id={$result.area|default:$magic.session.result.area}" type='text/javascript' language="javascript"></script> </div>
	</div>

	<div class="module_border">
		<div class="l">���:</div>
		<div class="c">
			<textarea name="summary" cols="45" rows="5">{$result.summary}</textarea>
		</div>
	</div>

	<div class="module_border" >
		<div class="l">����:</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$result.content"}
		</div>
	</div>

	<div class="module_submit" >
		{ if $t == "edit" }<input type="hidden" name="id" value="{ $result.id }" />{/if}
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
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

function jump_url(){
	if (document.getElementById('jump_url').style.display == ""){
		document.getElementById('jump_url').style.display = "none";
		document.getElementById('jump_id').style.display = "";
	}else{
		document.getElementById('jump_url').style.display = "";
		document.getElementById('jump_id').style.display = "none";
	}
}
</script>
{/literal}

{elseif $t == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="{$url}/{ if $t == "edit" }update{else}add{/if}{$site_url}" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>�����鿴</strong></div>

	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			{$result.title}
		</div>
	</div>

	<div class="module_border">
		<div class="l">��ת��ַ��</div>
		<div class="c">
			{ $result.jumpurl}</div>
	</div>

	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			{$result.site_name|default:"Ĭ����Ŀ" }</select>
		</div>
	</div>

	{if $result.is_jump!=1}
	{if $result.litpic!=""}
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			{if $result.litpic!=""}<a href="./{$result.litpic}" target="_blank" title="����鿴��ͼ" ><img src="./{$result.litpic}" border="0" width="100" alt="����鿴��ͼ" title="����鿴��ͼ" /></a>{/if}</div>
	</div>

	{/if}
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{ if $result.status == 0 }����{else}��ʾ{/if}
		 </div>
	</div>

	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{ $result.order|default:10}
		</div>
	</div>

	<div class="module_border">
		<div class="l">������Դ:</div>
		<div class="c">
			{ $result.source}</div>
	</div>

	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{ $result.author}</div>
	</div>

	<div class="module_border">
		<div class="l">���:</div>
		<div class="c">
			{$result.summary}</div>
	</div>

	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{$result.content}</div>
	</div>

	{foreach from=$input item=item}
	<div class="module_border">
		<div class="l">{$item.0}:</div>
		<div class="c">
			{$item.1}
		</div>
	</div>

	{/foreach}
	<div class="module_border">
		<div class="l">�������/����:</div>
		<div class="c">
			{$result.hits}/{$result.comment}</div>
	</div>

	{/if}
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{$result.addtime|date_format:'Y-m-d'}/{$result.addip}</div>
	</div>

	<div class="module_border">
		<div class="l">�����:</div>
		<div class="c">
			{$result.username}</div>
	</div>

	<div class="module_submit" >
		{ if $t == "edit" }<input type="hidden" name="id" value="{ $result.id }" />{/if}
		<input type="button"  name="submit" value="������һҳ" onclick="javascript:history.go(-1)" />
		<input type="button"  name="reset" value="�޸İ���" onclick="javascript:location.href('{$url}/edit{$site_url}&id={$result.id}')"/>
	</div>
	</form>
</div>
{elseif 'type'==$t}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">��������</td>
		<td width="" class="main_td">״̬</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
	</tr>
	<form action="{ $url}/type_order" method="post" name="form1" >
	{ foreach  from=$result key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.type_id}</td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center">{ if $item.status ==1}<a href="{$url}/type{$site_url}&status=0&id={ $item.type_id}">��ʾ</a>{else}<a href="{$url}/type{$site_url}&status=1&id={ $item.type_id}">����</a>{/if}</td>
		<td class="main_td1" align="center" ><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="type_id[{$key}]" value="{$item.type_id}" /></td>
		<td class="main_td1" align="center" ><a href="{$url}/type_edit{$site_url}&id={$item.type_id}" >�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$url}/type_del{$site_url}&id={$item.type_id}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="5"  class="submit">
		<input type="submit" value=" �� �� "  name="submit_ok" />&nbsp;&nbsp;
					<input type="button" name="new" value="�������" onclick="javascript:window.location.href='{$url}/type_new';" />
		</td>
	</tr>
	</form>
	<tr>
		<td colspan="5" class="page">
			{$page}
		</td>
	</tr>
</table>
{elseif 'type_new'==$t || 'type_edit'==$t}
<div class="module_add">
	
	<form action="{ $url}/{ if $t=='type_edit'}type_update{ else}type_add{ /if}" method="post" name="form1"  enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $t == "type_edit" }�༭{else}���{/if}����</strong></div>
	 <div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			<select name="type_id"><option value="0">Ĭ������</option>{foreach from=$list item=item key=key}
<option value="{$item.type_id}" {if $result.type_id == $item.type_id} selected="selected"{/if} >-{$item.aname}</option>
{ /foreach}</select></div>
	</div>
	
	 <div class="module_border">
		<div class="l">�������� ��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="name" value="{ $result.name}" /> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ʶ��ID(nid)��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="nid"  onkeyup="value=value.replace(/[^a-zA-Z_]/g,'')" value="{$result.nid}"/>ֻ��Ϊ ��ĸ���»��ߣ�_��
				
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״&nbsp;&nbsp;&nbsp; ̬ ��</div>
		<div class="c">
			<input type="radio" value="0" name="status" { if $result.status==0}checked="checked"{ /if}/>����
			<input type="radio" value="1" name="status" { if $result.status==1 || $result.status==""}checked="checked"{ /if} />��ʾ
		</div>
	</div>
	
	 <div class="module_border">
		<div class="l">����˳��</div>
		<div class="c">
				<input type="text" align="absmiddle" name="order"  onkeyup="value=value.replace(/[^0-9]/g,'')" size="5" value="{$result.order|default:10}"/>
		</div>
	</div>
	
	
	
	<div class="module_border">
		<div class="l">����ģ�壺</div>
		<div class="c">
			<input name="index_tpl" type="text"  style="width:300px" value="{ $result.index_tpl|default:"help.html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�б�ģ�壺</div>
		<div class="c">
			<input name="list_tpl" type="text"  style="width:300px" value="{ $result.list_tpl|default:"help_list.html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ģ�壺</div>
		<div class="c">
			<input name="content_tpl" type="text"  style="width:300px" value="{$result.content_tpl|default:"help_content.html"}" />
		</div>
	</div>
			  
	{ if $s=="edit"}
	<div class="module_border">
		<div class="l">ģ���޸ģ�</div>
		<div class="c">
			 <input type="checkbox" value="1" name="update_all" />������Ŀһ���޸� <input type="checkbox" value="1" name="update_brother" />ͬ����Ŀһ���޸�
		</div>
	</div>
	 {/if}
	 
	<div class="module_border">
		<div class="l">�б���������</div>
		<div class="c">
			<input name="list_name" type="text"  style="width:300px" value="{$result.list_name|default:"index_[page].html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������������</div>
		<div class="c">
			<input name="content_name" type="text"  style="width:300px" value="{$result.content_name|default:"[id].html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ļ�����Ŀ¼��</div>
		<div class="c">
			<input name="sitedir" type="text"  style="width:300px" value="{$result.sitedir|default:"[nid]"}" />
		</div>
	</div>
	
	{ if $s=="type_new"}
	<div class="module_border">
		<div class="l">Ŀ¼���λ�ã�</div>
		<div class="c">
			<input name="referpath" type="radio" value="parent" checked="chekced" />
              �ϼ�Ŀ¼
                            <input name="referpath" type="radio" value="cmspath" />
              CMS��Ŀ¼
		</div>
	</div>
	{/if}
	
	<div class="module_border">
		<div class="l">�ļ��������ͣ�</div>
		<div class="c">
			<input type="radio" name="visit_type" value="0" {if $result.visit_type==0 || $result.visit_type==""} checked="checked"{/if}  title="�磺?3/1"/> ��̬���� <input type="radio" name="visit_type" value="1" {if $result.visit_type==1} checked="checked"{/if} title="�磺?article/dongtai/1.html"/> ����html���� ����ע�����ϵͳ����α��̬Ϊ�ǣ���α��̬������
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">title������</div>
		<div class="c">
			<textarea name="title" cols="40" rows="3" id="title">{ $result.title}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ؼ��֣�</div>
		<div class="c">
			<textarea name="keywords" cols="40" rows="3" id="keywords">{ $result.keywords}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ŀ������</div>
		<div class="c">
			 <textarea name="description" cols="40" rows="3" id="textarea2">{ $result.description}</textarea>
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��Ŀ���ݣ�</div>
		<div class="c">
			{editor name="content" value="$result.content"}
		</div>
	</div>
	
	<div class="module_submit"><input type="submit" value=" �� �� "  name="submit_ok" />&nbsp;&nbsp;
					<input name="reset" type="reset"  value=" �� �� " /><input type="hidden" align="absmiddle" name="type_id" value="{ $result.type_id}" /> </div>
			</form>
 </div>
 
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">����</td>
		<td width="" class="main_td">״̬</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$result key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center" >{ $item.id}</td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center" >{ if $item.status ==1}<a href="{$url}{$site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$url}{$site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td class="main_td1" align="center" ><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="id[{$key}]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" >{$item.flagname|default:-}{if $item.litpic!=""}ͼƬ{/if}</td>
		<td class="main_td1" align="center"><a href="{$url}/edit{$site_url}&id={$item.id}" >�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$url}/del{$site_url}&id={$item.id}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="7" class="action">
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
		<div class="floatr">�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()"></div>
		</td>
	</tr>
	<tr>
		<td colspan="7" class="page" >
		{$page} 
		</td>
	</tr>
	</form>	
</table>

  <script>
  var url = '{$url}';
	{literal}
	function sousuo(){
		var keywords = $("#keywords").val();
		location.href=url+"&keywords="+keywords;
	}

  </script>
  {/literal}
{/if}