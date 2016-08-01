{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>����</strong></div>
	
	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="title"  class="input_border" value="{ $_A.liuyan_result.title}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���</div>
		<div class="c">
			<select name="type">
			{foreach from=$_A.liuyan_type_list item=item}
			<option value="{$item}" {if $item==$_A.liuyan_result.type} selected="selected"{/if}>{$item}</option>
		
		{/foreach}
		</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.liuyan_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.liuyan_result.status ==1 ||$_A.liuyan_result.status ==""}checked="checked"{/if}/>��ʾ </div>
	</div>
	
	<div class="module_border">
		<div class="l">������</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.liuyan_result.name}" size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">EMAIL:</div>
		<div class="c">
			<input type="text" name="email"  class="input_border" value="{ $_A.liuyan_result.email}" size="20" /></div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾:</div>
		<div class="c">
			<input type="text" name="company"  class="input_border" value="{ $_A.liuyan_result.company}" size="20" /></div>
	</div>
	
	<div class="module_border">
		<div class="l">�绰:</div>
		<div class="c">
			<input type="text" name="tel"  class="input_border" value="{ $_A.liuyan_result.tel}" size="20" /></div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="fax"  class="input_border" value="{ $_A.liuyan_result.fax}" size="20" /></div>
	</div>
	
	<div class="module_border">
		<div class="l">��ַ:</div>
		<div class="c">
			<input type="text" name="address"  class="input_border" value="{ $_A.liuyan_result.address}" size="20" /></div>
	</div>
	
	<div class="module_border">
		<div class="l">ͼƬ:</div>
		<div class="c">
			<input type="file" name="litpic"  class="input_border" size="20" />{if $_A.liuyan_result.litpic!=""}<a href="./{$_A.liuyan_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<textarea name="content" cols="45" rows="5">{$_A.liuyan_result.content}</textarea></div>
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.liuyan_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</div>
</form>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['title'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if (content.length == 0 ) {
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
{elseif $_A.query_type == "set"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	
	<div class="module_title"><strong>��������</strong></div>
	
	<div class="module_border">
		<div class="l">���Ա��⣺</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.liuyan_set.name}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			<input type="text" name="type"  class="input_border" value="{ $_A.liuyan_set.type}" size="30" />  ����������� | ����
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʾҳ����</div>
		<div class="c">
			<input type="text" name="page"  class="input_border" value="{ $_A.liuyan_set.page}" size="30" />  
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.liuyan_set.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.liuyan_result.status ==1 ||$_A.liuyan_result.status ==""}checked="checked"{/if}/>��ʾ </div>
	</div>
	
	<div class="module_submit">
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	
</div>
{elseif $_A.query_type == "view"}
<form name="form1" method="post" action="" >
<div class="module_add">
	
	<div class="module_title"><strong>���Բ鿴</strong></div>
	
	<div class="module_border">
		<div class="l">���Ա��⣺</div>
		<div class="c">
			{ $_A.liuyan_result.name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���</div>
		<div class="c">
			{ $_A.liuyan_result.type}</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{ if $_A.liuyan_result.status ==1 ||$_A.liuyan_result.status ==""}����{else}��ʾ{/if} </div>
	</div>
	
	<div class="module_border">
		<div class="l">������</div>
		<div class="c">
			{ $_A.liuyan_result.name}</div>
	</div>
	
	<div class="module_border">
		<div class="l">EMAIL:</div>
		<div class="c">
			{ $_A.liuyan_result.email}</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾:</div>
		<div class="c">
			{ $_A.liuyan_result.company}</div>
	</div>
	
	<div class="module_border">
		<div class="l">�绰:</div>
		<div class="c">
			{ $_A.liuyan_result.tel}</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{ $_A.liuyan_result.fax}</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ַ:</div>
		<div class="c">
			{ $_A.liuyan_result.address}</div>
	</div>
	
	<div class="module_border">
		<div class="l">ͼƬ:</div>
		<div class="c">
			{if $_A.liuyan_result.litpic!=""}<a href="./{$_A.liuyan_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			{$_A.liuyan_result.content}</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{$_A.liuyan_result.addtime|date_format:'Y-m-d'}/{$_A.liuyan_result.addip}</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ظ�:</div>
		<div class="c">
			<textarea name="reply" cols="40" rows="6">{$_A.liuyan_result.reply}</textarea></div>
	</div>
	
	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.liuyan_result.id }" />
		<input type="submit"   value="ȷ�ϻظ�"/>
		<input type="button"  name="reset" value="�޸�����" onclick="javascript:location.href('{$_A.query_url}/edit&id={$_A.liuyan_result.id}')"/>
		
	</div>
</div>
</form>
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="{$_A.query_url}/order" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
		<td class="main_td">״̬</td>
		<td class="main_td">���ʱ��</td>
		<td class="main_td">�Ƿ�ظ�</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.liuyan_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td>{ $item.id}</td>
		<td>{$item.title}</td>
		<td>{$item.type}</td>
		<td>{ if $item.status ==1}��ʾ{else}����{/if}</td>
		<td>{$item.addtime|date_format:"Y-m-d"}</td>
		<td >{if $item.reply == ""}<font color="#FF0000">δ�ظ�</font>{else}�ѻظ�{/if}</td>
		<td><a href=" {$_A.query_url}/view&id={$item.id}">�ظ�</a> / <a href="{$_A.query_url}/edit&id={$item.id}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url} /del&id={$item.id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="8"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</form>	
</table>
{/if}