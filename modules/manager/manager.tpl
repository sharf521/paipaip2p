{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">����Ա��</td>
		<th width="" class="main_td">���ʱ��</th>
		<th width="" class="main_td">״̬</th>
		<th width="" class="main_td">����Ա����</th>
		<th width="" class="main_td">������վ</th>
		<th width="" class="main_td">��¼����</th>
		<th width="" class="main_td">����</th>
		<td width="" class="main_td">����</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.user_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.user_id}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td class="main_td1" align="center" >{ if $item.status ==1}��ͨ{else}����{/if}</td>
		<td class="main_td1" align="center" >{$item.typename}</td>
		<td class="main_td1" align="center" >{$item.sitename}</td>
		<td class="main_td1" align="center">{$item.logintime}</td>
		<td class="main_td1" align="center"><input type="text" name="order[]" size="4" value="{$item.order|default:10}" /><input type="hidden" value="{$item.user_id}" name="user_id[]" /></td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&user_id={$item.user_id}{$_A.site_url}">�޸�</a> / <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&user_id={$item.user_id}{$_A.site_url}'">ɾ��</a>{if $magic.session.usertype==1} / <a href="{$_A.admin_url}&q=module/user/edit&user_id={$item.user_id}{$_A.site_url}">��ͨ�û�</a>{/if} </td>
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
	
	<form name="form_user" method="post" action="" { if $_A.query_type == "new" }onsubmit="return check_user();"{/if} >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����Ա</strong></div>
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{ if $_A.query_type != "edit" }<input name="username" type="text"  class="input_border" />{else}{ $_A.user_result.username}<input name="username" type="hidden"  class="input_border" value="{$_A.user_result.username}" />{/if} <font color="#FF0000">*</font>
		</div>
	</div>
	<div class="module_border">
		<div class="l">��¼���룺</div>
		<div class="c">
			<input name="password" type="password" class="input_border" />{ if $_A.query_type == "edit" } ���޸���Ϊ��{/if} <font color="#FF0000">*</font>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ȷ�����룺</div>
		<div class="c">
			<input name="password1" type="password" class="input_border" />{ if $_A.query_type == "edit" } ���޸���Ϊ��{/if} <font color="#FF0000">*</font>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʵ������</div>
		<div class="c">
			<input name="realname" type="text" value="{ $_A.user_result.realname }" class="input_border" />
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">�ԡ��� </div>
		<div class="c">
			<input type="radio" name="sex" value="0" { if $_A.user_result.sex==0 || $_A.user_result.sex==""} checked="checked" { /if}/>
		����&nbsp;&nbsp;
		<input type="radio" name="sex" value="1" { if $_A.user_result.sex==1 } checked="checked" { /if} />
		��&nbsp;&nbsp;
		<input type="radio" name="sex" value="2"  { if $_A.user_result.sex==2 } checked="checked" { /if}/>
	  Ů&nbsp;&nbsp; 
		</div>
	</div>
	
	  <div class="module_border">
		<div class="l">���գ�</div>
		<div class="c">
		<input type="text" name="birthday"  class="input_border" value="{ $_A.user_result.birthday}" size="20" onclick="change_picktime()"/> 
			
		</div>
	</div>
	 
	  <div class="module_border">
		<div class="l">���ͣ� </div>
		<div class="c">
			{html_options name="type_id" options=$list_type selected=$_A.user_result.type_id}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			 <input name="status" type="radio" value="0"   { if $_A.user_result.status=="0"} checked="checked"{/if}/>�ر�<input name="status" type="radio" value="1" { if $_A.user_result.status==1 || $_A.user_result.status==""} checked="checked"{/if}/>��ͨ
		</div>
	</div>
	
	{if $_A.admin_type_id == 1}
	<div class="module_border">
		<div class="l">������վ��</div>
		<div class="c">
			<select name="areaid">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$_A.user_result.areaid} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>
		</div>
	</div>
	{else}
	<input type="hidden" name="areaid" value="{ $_A.areaid }" />
	{/if}	
	
	<div class="module_border">
		<div class="l">�����ʼ���ַ�� </div>
		<div class="c">
			<input name="email" value="{ $_A.user_result.email }" type="text"  class="input_border" /> <font color="#FF0000">*</font>
		</div>
	</div>
	<div class="module_border">
		<div class="l">QQ��</div>
		<div class="c">
			<input name="qq" type="text" value="{ $_A.user_result.qq }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������</div>
		<div class="c">
			<input name="wangwang" type="text" value="{ $_A.user_result.wangwang }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ͥ�绰��</div>
		<div class="c">
			<input name="tel" type="text" value="{ $_A.user_result.tel }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ֻ���</div>
		<div class="c">
			<input name="phone" type="text" value="{ $_A.user_result.phone }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϸ��ַ��</div>
		<div class="c">
			<input name="address" type="text" value="{ $_A.user_result.address }" class="input_border" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">�������к�SN��</div>
		<div class="c">
			<input name="serial_id" type="text" value="{ $_A.user_result.serial_id }" class="input_border" />
		</div>
	</div>
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="user_id" value="{ $_A.user_result.user_id }" />{/if}
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
{elseif $_A.query_type == "type"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
		<td class="main_td">��������</td>
		<td class="main_td">��Ҫ</td>
		<td class="main_td">��ע</td>
		<td class="main_td">����</td>
		<td class="main_td">״̬</td>
		<td class="main_td">����</td>
	</tr>
	<form action="{$_A.query_url}/type_order" method="post">
	{ foreach from = $_A.user_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td bgcolor="#ffffff" >{$item.name}</td>
		<td bgcolor="#ffffff" >{$item.summary}</td>
		<td bgcolor="#ffffff">{$item.remark}</td>
		<td bgcolor="#ffffff"><input name="order[]" size="2" value="{ $item.order}"type="text" ><input name="type_id[]" type="hidden" size="2" value="{ $item.type_id}" ></td>
		<td  bgcolor="#ffffff" >{ if $item.status==1}��ͨ{else}<font color=red>�ر�</font>{/if}</td>
		<td bgcolor="#ffffff"><a href="{$_A.query_url}/type_edit&type_id={$item.type_id}">�޸�</a>/<a href="#" onclick="javascript:if(confirm('ȷ��Ҫɾ����?������')) location.href='{$_A.query_url}/type_del&type_id={$item.type_id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td   colspan="6" class="action"><input type="button" onclick="javascript:location.href='{$_A.query_url}/type_new{$_A.site_url}'" value="�������" />  <input type="submit" value="�޸�����" /> </td>
	</tr>
	</form>
</table>
{ elseif $_A.query_type == "type_new" || $_A.query_type == "type_edit" }
<div class="module_add">
	
	<form enctype="multipart/form-data" name="form1" method="post" action="" onsubmit="return check_form();"  >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}����Ա����</strong></div>
	
	<div class="module_border">
		<div class="l">��������:</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $result.name}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $result.status == 0 }checked="checked"{/if}/> �ر�<input type="radio" name="status" value="1"  { if $result.status ==1 ||$result.status ==""}checked="checked"{/if}/>��ͨ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ҫ˵��:</div>
		<div class="c">
			<textarea name="summary" cols="55" rows="6" >{ $result.summary}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע:</div>
		<div class="c">
			<textarea name="remark" cols="55" rows="6" >{ $result.remark}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ȩ��:</div>
		<div class="c">
			{literal}
				<script>
				var checkflag = false;
				function changeAll(field,id) { 
					var chkArray = document.all(field);
					var checkflag = document.getElementById(id).checked;
					if (checkflag == true) { 
						for (i = 0; i < chkArray.length; i++) { 
							chkArray[i].checked = true; 
						}  
					} else { 
						for (i = 0; i < chkArray.length; i++) { 
							chkArray[i].checked = false;
						} 
					}
				}
				</script>
				{/literal}
				{foreach from = $_A.user_purview key=key item=item}
					<div style="height:auto; width:90%" class="floatr">
					{ foreach from=$item key=_key item=_item}
					 <div style="width:97%; border-bottom:1px dashed #CCCCCC; height:28px; padding-top:5px"><strong>{$_key}</strong>
					 <input type="checkbox" title="ȫѡ" onclick="changeAll('{$key}','_{$key}')" id="_{$key}"/></div>
					 <div style="width:97%;border-bottom:1px solid #CCCCCC;  padding-top:5px">
						{ foreach from=$_item key=__key item=__item}
						<div style="float:left; width:140px; height:25px;" title="{$__key}"><input type="checkbox" value="{$__key}" name="purview[]" id="{ $key}" {if $_A.query_type == "type_edit" }{$__key|checked:$result.purview}{/if}  /> {$__item}</div>
						{/foreach}
					</div>
					{/foreach}
					</div>
				{/foreach}
			</div>
	</div>
	<div class="module_submit" >
	{ if $_A.query_type == "type_edit" }<input type="hidden" name="type_id" value="{ $result.type_id }" />{/if}
		<input type="submit" value="ȷ���ύ" />
		<input type="reset" name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '�������Ʊ�����д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
{/literal}
</script>

{/if}