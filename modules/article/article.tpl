{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����</strong></div>
	

	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.code_result.name}" size="30" />  
			<input type="checkbox" onclick="jump_url()" {if $_A.code_result.is_jump=="1"} checked="checked"{/if} name="is_jump" value="1"/> ��ת
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
			{$_A.code_result.flag|flag:"input"}
		</div>
	</div>

	<div class="module_border" id="jump_url" style="{if $_A.code_result.is_jump!=1}display:none{/if}">
		<div class="l">��ת��ַ��</div>
		<div class="c">
			<input type="text" name="jumpurl"  class="input_border" value="{ $_A.code_result.jumpurl}" size="30" /></div>
	</div>

	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<select name="site_id"><option value="0">Ĭ������</option>{foreach from=$_A.site_code_list item=item key=key}
<option value="{ $item.site_id}" {if $_A.code_result.site_id == $item.site_id || $magic.request.site_id == $item.site_id } selected="selected"{/if} >-{$item.name}</option>
{ /foreach}</select></div>
	</div>

	<div class="module_border"  {if $_A.show_fields.source==false}style="display:none"{/if}>
		<div class="l">������Դ��</div>
		<div class="c">
			<input type="text" name="source"  class="input_border" value="{ $_A.code_result.source}" size="30" /></div>
	</div>

	<div class="module_border" {if $_A.show_fields.author==false}style="display:none"{/if}>
		<div class="l">���ߣ�</div>
		<div class="c">
			<input type="text" name="author"  class="input_border" value="{ $_A.code_result.author}" size="30" /></div>
	</div>

	
	<div class="module_border"  {if $_A.show_fields.publish==false}style="display:none"{/if}>
		<div class="l">����ʱ�䣺</div>
		<div class="c">
			<input type="text" name="publish"  class="input_border" value="{ $_A.code_result.publish|default:"nowdate"}" size="30" onclick="change_picktime('yyyy-MM-dd HH:mm:ss')" readonly=""/></div>
	</div>

	<div id="jump_id"  style="{if $_A.code_result.is_jump==1}display:none{/if}">
	{if $_A.admin_type_id == 1}
	<div class="module_border">
		<div class="l">������վ��</div>
		<div class="c">
			<select name="areaid">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.code_result.areaid} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>
	{else}
	<input type="hidden" name="areaid" value={$_A.areaid} /> 
	{/if}	

	<div class="module_border" {if $_A.show_fields.litpic==false}style="display:none"{/if} id="jump_url">
		<div class="l">����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.code_result.litpic!=""}<a href="./{ $_A.code_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearlitpic" value="1" />ȥ������ͼ{/if}</div>
	</div>

	<div class="module_border" {if $_A.show_fields.status==false}style="display:none"{/if}>
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.code_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.code_result.status ==1 ||$_A.code_result.status ==""}checked="checked"{/if}/>��ʾ </div>
	</div>

	<div class="module_border" {if $_A.show_fields.order==false}style="display:none"{/if}>
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.code_result.order|default:10}" size="10" />
		</div>
	</div>

	

	<div class="module_border" {if $_A.show_fields.summary==false}style="display:none"{/if}>
		<div class="l">���ݼ��:</div>
		<div class="c">
			<textarea name="summary" cols="45" rows="5">{ $_A.code_result.summary}</textarea>
		</div>
	</div>
    


	<div class="module_border" {if $_A.show_fields.content==false}style="display:none"{/if}>
		<div class="l">����:</div>
		<div class="c">
<script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="gbk" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<script id="content" name="content" type="text/plain" style="width:800px; height:300px;">{$_A.code_result.content}</script>
{literal}
<script type="text/javascript">	
	var ue = UE.getEditor('content',{
		serverUrl:"/plugins/ueditor/php/controller.php?type=admin"
	})
</script>
{/literal}
		</div>
	</div>

	{foreach from=$_A.code_input item=item}
	<div class="module_border">
		<div class="l">{$item.0}:</div>
		<div class="c">
			{$item.1}
		</div>
	</div>
	{/foreach}
	
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.code_result.id }" />{/if}
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
{elseif $_A.query_type == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="{$_A.query_url}/{ if $_A.query_type == "edit" }update{else}add{/if}{$_A.site_url}" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>���ݲ鿴</strong></div>

	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			{ $_A.code_result.name}
		</div>
	</div>
{ if $_A.code_result.jumpurl!=""}
	<div class="module_border">
		<div class="l">��ת��ַ��</div>
		<div class="c">
			{ $_A.code_result.jumpurl}</div>
	</div>
{/if}
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			{ $_A.code_result.site_name|default:"Ĭ����Ŀ" }</select>
		</div>
	</div>

{ if $_A.code_result.flag!=""}
	<div class="module_border">
		<div class="l">���ԣ�</div>
		<div class="c">
			{ $_A.code_result.flag|flag}</div>
	</div>
{/if}
	{if $_A.code_result.is_jump!=1}
	{if $_A.code_result.litpic!=""}
	<div class="module_border">
		<div class="l">����ͼ��</div>
		<div class="c">
			{if $_A.code_result.litpic!=""}<a href="./{ $_A.code_result.litpic}" target="_blank" title="����鿴��ͼ" ><img src="./{ $_A.code_result.litpic}" border="0" width="100" alt="����鿴��ͼ" title="����鿴��ͼ" /></a>{/if}</div>
	</div>

	{/if}
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{ if $_A.code_result.status == 0 }����{else}��ʾ{/if}
		 </div>
	</div>

	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{ $_A.code_result.order|default:10}
		</div>
	</div>
{ if $_A.code_result.source!=""}
	<div class="module_border">
		<div class="l">������Դ:</div>
		<div class="c">
			{ $_A.code_result.source}</div>
	</div>
	{/if}
{ if $_A.code_result.author!=""}
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{ $_A.code_result.author}</div>
	</div>
{/if}
{ if $_A.code_result.summary!=""}
	<div class="module_border">
		<div class="l">���ݼ��:</div>
		<div class="c">
			{ $_A.code_result.summary}</div>
	</div>
{/if}
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<table><tr><td align="left">{ $_A.code_result.content}</td></tr></table></div>
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
			{ $_A.code_result.hits}/{ $_A.code_result.comment}</div>
	</div>

	{/if}
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.code_result.addtime|date_format:'Y-m-d'}/{ $_A.code_result.addip}</div>
	</div>

	<div class="module_border">
		<div class="l">�����:</div>
		<div class="c">
			{ $_A.code_result.username}</div>
	</div>

	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.code_result.id }" />{/if}
		<input type="button"  name="submit" value="������һҳ" onclick="javascript:history.go(-1)" />
		<input type="button"  name="reset" value="�޸�����" onclick="javascript:location.href('{$_A.query_url}/edit{$_A.site_url}&id={ $_A.code_result.id}')"/>
	</div>
	</form>
</div>

{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="{$_A.query_url}/action{$_A.site_url}" method="post">
		<tr >
			<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">����</td>
			<td width="*" class="main_td">������վ</td>
			<td width="" class="main_td">��Ŀ����</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.code_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" ><input type="checkbox" name="aid[]" id="aid[]" value="{$item.id}"/></td>
			<td class="main_td1" align="center" >{ $item.id}</td>
			<td class="main_td1" align="center">{$item.name|truncate:34}{if $item.is_jump==1}<font color="#CCCCCC">[��ת]</font>{/if}</td>
			<td class="main_td1" align="center">{ $item.sitename}</td>
			<td class="main_td1" align="center" >{$item.site_name|default:-}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
			<td class="main_td1" align="center" ><input type="text" name="order[]" value="{$item.order}" size="3" /><input type="hidden" name="id[]" value="{$item.id}" /><input type="hidden" name="flag[]" value="{$item.flag}" /></td>
			<td class="main_td1" align="center" >{$item.flagname|default:-}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/view{$_A.site_url}&id={$item.id}">�鿴</a> <a href="{$_A.query_url}/edit{$_A.site_url}&id={$item.id}">�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
		</tr>
		{ /foreach}
		<tr>
			<td colspan="8"  class="action" >
			<div class="floatl"><select name="type">
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
			
			</div>
			</td>
		</tr>
		<tr>
			<td colspan="8" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
{/if}