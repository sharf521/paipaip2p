{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">�û���</td>
		<td width="*" class="main_td">��ʵ����</td>
		<td width="*" class="main_td">�Ա�</td>
		<td width="*" class="main_td">����</td>
		<td width="*" class="main_td">QQ</td>
		<td width="*" class="main_td">�ֻ�</td>
		<td width="*" class="main_td">���ڵ�</td>
		<td width="*" class="main_td">���֤</td>
		<th width="" class="main_td">���ʱ��</th>
		<th width="" class="main_td">״̬</th>
		<th width="" class="main_td">�û�����</th>
		<th width="" class="main_td">webservice userid</th>
		<!--<th width="" class="main_td">��¼����</th>-->
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.user_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.user_id}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center">{if $item.sex==1}��{else}Ů{/if}</td>
		<td class="main_td1" align="center">{$item.email}</td>
		<td class="main_td1" align="center">{$item.qq}</td>
		<td class="main_td1" align="center">{$item.phone}</td>
		<td class="main_td1" align="center">{$item.area|area}</td>
		<td class="main_td1" align="center">{$item.card_id}</td>
		<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td class="main_td1" align="center" >{ if $item.status ==1}��ͨ{else}����{/if}</td>
		<td class="main_td1" align="center" >{$item.typename}</td>
		<td class="main_td1" align="center" >{$item.ws_user_id}</td>
		<!--<td class="main_td1" align="center">{$item.logintime}</td>-->
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&user_id={$item.user_id}{$_A.site_url}">�޸�</a></td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="11" class="action">
			<div class="floatl">
			<script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var username = $("#username").val();
			var email = $("#email").val();
			var keywords = $("#keywords").val();
			var realname = $("#realname").val();
			location.href=url+"&keywords="+keywords+"&email="+email+"&realname="+realname;
		}
	  
	  </script>
	  {/literal}
			</div>
			<div class="floatr">
				�û�����<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords|urldecode}"/>  ���䣺<input type="text" name="email" id="email" value="{$magic.request.email}"/>  ��ʵ������<input type="text" name="realname" id="realname" value="{$magic.request.realname|urldecode}"/> <input type="button" value="����" / onclick="sousuo()">
			</div>
			</td>
		</tr>
	<tr>
		<td colspan="7" class="page">
		{$_A.showpage}
		</td>
	</tr>
</table>

{elseif $_A.query_type == "typechange"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">�û���</td>
		<td width="*" class="main_td">��ʵ����</td>
		<td width="*" class="main_td">ԭ��������</td>
		<td width="*" class="main_td">����������</td>
		<td width="*" class="main_td">����ԭ��</td>
		<td width="*" class="main_td">״̬</td>
		<th width="" class="main_td">���ʱ��</th>
		<th width="" class="main_td">���Ip</th>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.user_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.id}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center">{$item.old_typename}</td>
		<td class="main_td1" align="center">{$item.new_typename}</td>
		<td class="main_td1" align="center">{$item.content}</td>
		<td class="main_td1" align="center">{if $item.status==0}�����{elseif $item.status==1}�ɹ�{else}ʧ��{/if}</td>
		<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td class="main_td1" align="center" >{$item.addip}</td>
		<td class="main_td1" align="center">{if $item.status==0}<a href="#" onClick="javascript:if(confirm('�������ɣ�{$item.content}/ȷ��Ҫ���ͨ����')) location.href='{$_A.query_url}/typechange&status=1&id={$item.id}{$_A.site_url}'">ͨ�� </a>| <a href="#" onClick="javascript:if(confirm('�������ɣ�{$item.content}/ȷ����˲�ͨ����')) location.href='{$_A.query_url}/typechange&status=2&id={$item.id}{$_A.site_url}'">��ͨ��</a>{else}-{/if}</td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="11" class="action">
			<div class="floatl">
			<script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var username = $("#username").val();
			var email = $("#email").val();
			var keywords = $("#keywords").val();
			var realname = $("#realname").val();
			location.href=url+"&keywords="+keywords+"&email="+email+"&realname="+realname;
		}
	  
	  </script>
	  {/literal}
			</div>
			<div class="floatr">
				�û�����<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords|urldecode}"/>  ���䣺<input type="text" name="email" id="email" value="{$magic.request.email}"/>  ��ʵ������<input type="text" name="realname" id="realname" value="{$magic.request.realname|urldecode}"/> <input type="button" value="����" / onclick="sousuo()">
			</div>
			</td>
		</tr>
	<tr>
		<td colspan="7" class="page">
		{$_A.showpage}
		</td>
	</tr>
</table>


{elseif $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form_user" method="post" action="" { if $_A.query_type == "new" }onsubmit="return check_user();"{/if} >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}�û�</strong></div>
	
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
		<input type="radio" name="sex" value="1" { if $_A.user_result.sex==1 } checked="checked" { /if} />
		��&nbsp;&nbsp;
		<input type="radio" name="sex" value="2"  { if $_A.user_result.sex==2 } checked="checked" { /if}/>
	  Ů&nbsp;&nbsp; 
		</div>
	</div>
	
	  <div class="module_border">
		<div class="l">���գ�</div>
		<div class="c">
		<input type="text" name="birthday"  class="input_border" value="{ $_A.user_result.birthday|date_format:"Y-m-d"}" size="20" onclick="change_picktime()"/> 
			
		</div>
	</div>
	<!--
	 <div class="module_border">
			<div class="l">�����ͷ���</div>
			<div class="c">
			<select name="kefu_userid">
			<option value="0">��</option>
				{loop module ="user" function = "GetList" type_id="7,3" limit="all"}
			<option value="{$var.user_id}" {if $_A.user_result.kefu_userid==$var.user_id} selected="selected"{/if}>{$var.username}</option>
				{/loop}
				</select>
			</div>
		</div>
	-->
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
	
	 <div class="module_border" style="display:none">
			<div class="l">�Ƿ���Է������꣺</div>
			<div class="c">
				<input type="radio" name="borrow_vouch" value="0" {if $_A.user_result.borrow_vouch==0} checked="checked"{/if}/>�� <input type="radio" name="borrow_vouch" value="1" {if $_A.user_result.borrow_vouch==1} checked="checked"{/if}/>����
			</div>
		</div>
	  <div class="module_border" style="display:none">
		<div class="l">���ͣ� </div>
		<div class="c">
		<input type="hidden" name="type_id" value="2" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƿ�������</div>
		<div class="c">
			 <input name="islock" type="radio" value="0"   { if $_A.user_result.islock=="0"} checked="checked"{/if}/>��ͨ<input name="islock" type="radio" value="1" { if $_A.user_result.islock==1 || $_A.user_result.islock==""} checked="checked"{/if}/>����
		</div>
	</div>
                
	<div class="module_border">
		<div class="l">������ID��</div>
		<div class="c">
			 <input name="invite_userid" id="invite_userid"  value="{ $_A.user_result.invite_userid }" type="text" />
		</div>
	</div>
                
	<div class="module_border">
		<div class="l">�ƹ���ɷ��ã�</div>
		<div class="c">
			 <input name="invite_money" id="invite_money" value="{ $_A.user_result.invite_money }" type="text" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			 <input name="status" type="radio" value="0"   { if $_A.user_result.status=="0"} checked="checked"{/if}/>�ر�<input name="status" type="radio" value="1" { if $_A.user_result.status==1 || $_A.user_result.status==""} checked="checked"{/if}/>��ͨ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.user_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	
		<div class="module_border">
			<div class="l">֤�����ͣ�</div>
			<div class="c">
				<select name="card_type">
					<option value="1" {if $_A.user_result.card_type==1} selected="selected"{/if}>���֤</option>
					<option value="2" {if $_A.user_result.card_type==2} selected="selected"{/if}>����֤</option>
					<option value="3" {if $_A.user_result.card_type==3} selected="selected"{/if}>̨��֤</option>
				</select>
				<input name="card_id" type="text" value="{ $_A.user_result.card_id }" class="input_border" />
			</div>
		</div>
		
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
	{ if $_A.query_type == "edit" }<input type="hidden" name="user_id" value="{ $magic.request.user_id }" />{/if}
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
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}�û�����</strong></div>
	
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
{elseif $_A.query_type == "vip"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">�û���</td>
		<td width="*" class="main_td">��ʵ����1</td>
		<th width="" class="main_td">���ʱ��</th>
		<th width="" class="main_td">״̬</th>
		<th width="" class="main_td">�û�����</th>
		<th width="" class="main_td">��¼����</th>
		<th width="" class="main_td">״̬</th>
		<th width="" class="main_td">�Ƿ�ɷ�</th>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.user_vip_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.user_id}</td>
		<td class="main_td1" align="center">{ $item.realname}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center" >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td class="main_td1" align="center" >{ if $item.status ==1}��ͨ{else}����{/if}</td>
		<td class="main_td1" align="center" >{$item.typename}</td>
		<td class="main_td1" align="center">{$item.logintime}</td>
		<td class="main_td1" align="center">{if $item.isvip==-1}vip���{else}VIP��Ա{/if}</td>
		<td class="main_td1" align="center">{if $item.vip_money==""}��{else}{$item.vip_money}Ԫ{/if}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/vipview&user_id={$item.user_id}{$_A.site_url}">��˲鿴</a> </td>
	</tr>
	{ /foreach}
	<tr>
			<td colspan="10" class="action">
			<div class="floatl">
			<script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var username = $("#username").val();
			var keywords = $("#keywords").val();
			location.href=url+"&keywords="+keywords;
		}
	  
	  </script>
	  {/literal}
			</div>
			<div class="floatr">
				�û�����<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
			</div>
			</td>
		</tr>
	<tr>
		<td colspan="10" class="page">
		{$_A.showpage}
		</td>
	</tr>
</table>
{ elseif $_A.query_type == "vipview"  }
<div class="module_add">
	
	<form enctype="multipart/form-data" name="form1" method="post" action="" onsubmit="return check_form();"  >
	<div class="module_title"><strong>VIP��˲鿴</strong></div>
	
	<div class="module_border">
		<div class="l">�û���:</div>
		<div class="c">
			{$_A.user_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���:</div>
		<div class="c">
			<input type="radio" value="1" name="isvip" />���ͨ�� <input type="radio" value="0" name="isvip" checked="checked" />��˲�ͨ�� 
		</div>
	</div>
	<div class="module_border">
		<div class="l">��ע:</div>
		<div class="c">
			{$_A.user_result.vip_remark}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="vip_veremark" cols="55" rows="6" >{$_A.user_result.vip_veremark}</textarea>
		</div>
	</div>
	
	<div class="module_submit" >
	<input type="hidden" name="user_id" value="{$_A.user_result.user_id}" />
		<input type="submit" value="ȷ���ύ" />
		<input type="reset" name="reset" value="���ñ�" />
	</div>
	</form>
{/if}