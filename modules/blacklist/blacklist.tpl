{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action=""  enctype="multipart/form-data" >
	<div class="module_title"><strong>�ϴ�������</div>
	
	<div class="module_border">
		<div class="l">�������ϴ�:</div>
		<div class="c">
			<input type="file" name="logoimg"  class="input_border" size="20" />
		</div>
	</div>
	

	
	<div class="module_submit" >
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
		</div>
	</div>
	</form>
</div>

{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var webname = frm.elements['webname'].value;
	 var url = frm.elements['url'].value;
	 var errorMsg = '';
	  if (webname.length == 0 ) {
		errorMsg += '��վ���������д' + '\n';
	  }
	  if (url.length == 0 ) {
		errorMsg += '���ӵ�ַ����Ϊ��' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}

</form>
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
  
	<tr >
		<td width="" class="main_td">ƽ̨</td>
		<td width="" class="main_td">ע����</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">�Ա�</td>
		<td width="" class="main_td">���֤</td>
		<td width="" class="main_td">�ֻ�</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">���ڵ�</td>
		<td width="" class="main_td">�־�ס��</td>
		<td width="" class="main_td">���ڽ��</td>
		<td width="" class="main_td">���ڱ���</td>
		<td width="" class="main_td">��վ�������</td>
		<td width="" class="main_td">��վ��������</td>
		<td width="" class="main_td">��������</td>
		<td width="" class="main_td">ͳ��ʱ��</td>
		<td width="" class="main_td">����</td>
	</div>
	{ foreach  from=$_A.blacklist_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{ $item.platform}</td>
		<td class="main_td1" align="center">{ $item.username}</td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center" >{ if $item.sex ==1}��{else}Ů{/if}</td>
		<td class="main_td1" align="center" >{$item.card_id }</td>
		<td class="main_td1" align="center" >{$item.phone }</td>
		<td class="main_td1" align="center" >{$item.email }</td>
		<td class="main_td1" align="center" >{$item.huhou_addr }</td>
		<td class="main_td1" align="center" >{$item.live_addr }</td>
		<td class="main_td1" align="center" >{$item.late_amount }</td>
		<td class="main_td1" align="center" >{$item.late_num }</td>
		<td class="main_td1" align="center" >{$item.advance_amount }</td>
		<td class="main_td1" align="center" >{$item.advance_num }</td>
		<td class="main_td1" align="center" >{$item.late_day_num }</td>
		<td class="main_td1" align="center" >{$item.count_date }</td>
		<td class="main_td1" align="center" ><a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del&id={$item.id}{$_A.site_url}'">ɾ��</a></td>
		
	</div>
	{ /foreach}

	<tr>
		<td colspan="15" class="action">
		<form action="{$_A.query_url}/list" method="post">
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/>  ������<input type="text" name="realname" id="realname" value="{$magic.request.realname}"/>  
			���֤�ţ�<input type="text" name="card_id" id="card_id" value="{$magic.request.card_id}"/>  �ֻ��ţ�<input type="text" name="phone" id="phone" value="{$magic.request.phone}"/>  
			���䣺<input type="text" name="email" id="email" value="{$magic.request.email}"/>  <input type="submit" value="����" >
		</div>
	</form>	
		</td>
	</tr>
	<tr >
		<td colspan="15" class="page">
			{$_A.showpage}
		</td>
	</tr>

	
</table>
{/if}