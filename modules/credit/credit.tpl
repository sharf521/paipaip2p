{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td class="main_td">�û�ID</td>
		<td class="main_td">�û���</td>
		<td class="main_td">��ʵ����</td>
		<td class="main_td">�ܻ���</td>
		<td class="main_td">������ʱ��</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.credit_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td>{ $item.user_id}</td>
		<td>{ $item.username}</td>
		<td >{ $item.realname}</td>
		<td >{ $item.value}�� <img src="{$_G.system.con_credit_picurl}{ $item.pic}"  /></td>
		<td >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		<td><a href="{$_A.query_url}/log{$_A.site_url}&user_id={$item.user_id}" >�鿴��ϸ</a>
		{if $_A.areaid==0} 
		<a href="{$_A.admin_url}&q=module/attestation/jifen&user_id={$item.user_id}&a=userinfo" >�޸Ļ���</a>
		{/if}
		</td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="7" class="action">
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="7"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var username = $("#username").val();
	location.href=url+"&username="+username;
}

</script>
{/literal}


{elseif $_A.query_type == "log"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">�û���</td>
		<td class="main_td">��ʵ����</td>
		<td class="main_td">��������</td>
		<td class="main_td">�䶯����</td>
		<td class="main_td">�䶯��ֵ</td>
		<td class="main_td">����ʱ��</td>
	</tr>
	{ foreach  from=$_A.credit_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td>{ $item.id}</td>
		<td>{ $item.username}</td>
		<td>{ $item.realname}</td>
		<td >{ $item.type_name}</td>
		<td >{if $item.op==1}����{else}����{/if}</td>
		<td >{ $item.value}</td>
		<td >{$item.addtime|date_format:"Y-m-d"}</td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="7"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var username = $("#username").val();
	location.href=url+"&username="+username;
}

</script>
{/literal}

{elseif $_A.query_type == "rank"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td class="main_td">�ȼ�����</td>
		<td class="main_td">�ȼ�</td>
		<td class="main_td">��ʼ��ֵ</td>
		<td class="main_td">����ֵ</td>
		<td class="main_td">ͼƬ</td>
		<td class="main_td">ͼƬ����</td>
		<td class="main_td">����</td>
	</tr>
	<form name="form1" method="post" action=""  enctype="multipart/form-data">
	{ foreach  from=$_A.credit_rank_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td><input type="text" name="name[]" value="{ $item.name}" size="15" /></td>
		<td><input type="text" name="rank[]" value="{ $item.rank}"size="15" /></td>
		<td><input type="text" name="point1[]" value="{ $item.point1}" size="15" /></td>
		<td><input type="text" name="point2[]" value="{ $item.point2}" size="15" /></td>
		<td><input type="text" name="pic[]" value="{ $item.pic}" size="15" /><input type="hidden" name="id[]" value="{$item.id}" /></td>
		<td><img src="{$_G.system.con_credit_picurl}{ $item.pic}" alt="û�б�ʾͼƬ����ȷ" /> </td>
		<td><a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/rank_del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	
	<tr>
	<td colspan="7"  class="action" >
		 <input type="submit" value="ȷ�ϲ���" /> 
		</td>
	</tr>
	</form>
	<tr >
		<td class="main_td" colspan="7" align="left" >&nbsp;���</td>
	</tr>
	<form name="form1" method="post" action="{$_A.query_url}/rank_new" enctype="multipart/form-data">
	<tr class="tr2">
		<td >�ȼ�����</td>
		<td >�ȼ�</td>
		<td >��ʼ��ֵ</td>
		<td >����ֵ</td>
		<td colspan="3" >ͼƬ</td>
	</tr>
	<tr >
		<td><input type="text" name="name"  /></td>
		<td><input type="text" name="rank" /></td>
		<td><input type="text" name="point1" /></td>
		<td><input type="text" name="point2" /></td>
		<td colspan="3" ><input type="text" name="pic" /></td>
	</tr>
	
	<tr>
		<td colspan="7"  class="action" >
		 <input type="submit" value="��ӵȼ�" /> 
		</td>
	</tr>
	</form>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var username = $("#username").val();
	location.href=url+"&username="+username;
}

</script>
{/literal}
{elseif $_A.query_type == "type_new" || $_A.query_type == "type_edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��������</strong></div>
	
	<div class="module_border">
		<div class="l">�����������ƣ�</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.credit_type_result.name}" size="20" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���ִ��룺</div>
		<div class="c">
			<input type="text" name="nid"  class="input_border" value="{ $_A.credit_type_result.nid}" size="20" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">����ֵ��</div>
		<div class="c">
			<input type="text" name="value"  class="input_border" value="{ $_A.credit_type_result.value}" size="10" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ڣ�</div>
		<div class="c">
			<input type="radio" name="cycle" value="1" {if 1==$_A.credit_type_result.cycle}checked{/if} /> һ��
			<input type="radio" name="cycle" value="2" {if 2==$_A.credit_type_result.cycle}checked{/if} /> ÿ��
			<input type="radio" name="cycle" value="3" {if 3==$_A.credit_type_result.cycle}checked{/if} /> ʱ����
			<input type="radio" name="cycle" value="4" {if 4==$_A.credit_type_result.cycle}checked{/if} /> ����
		</div>
	</div>

	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			<input type="text" name="award_times"  class="input_border" value="{ $_A.credit_type_result.award_times}" size="8" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">ʱ������</div>
		<div class="c">
			<input type="text" name="interval"  class="input_border" value="{ $_A.credit_type_result.interval}" size="8" /> ����
		</div>
	</div>

	<div class="module_submit border_b" >
		{ if $_A.query_type == "type_edit" }<input type="hidden" name="id" value="{ $_A.credit_type_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var name = frm.elements['name'].value;
	 var nid = frm.elements['nid'].value;
	 var errorMsg = '';
	  if (name.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if (nid.length == 0 ) {
		errorMsg += '�����ʾ��������д' + '\n';
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
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td class="main_td">ID</td>
		<td class="main_td">������������</td>
		<td class="main_td">���ִ���</td>
		<td class="main_td">����</td>
		<td class="main_td">����</td>
		<td class="main_td">��������</td>
		<td class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.credit_type_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td>{ $item.id}</td>
		<td>{ $item.name}</td>
		<td >{ $item.nid}</td>
		<td >{ $item.value}</td>
		<td>{if 1==$item.cycle}һ��{elseif 2==$item.cycle}ÿ��{elseif 3==$item.cycle}ÿ{$item.interval}����{else}����{/if}</td>
		<td >{if 0==$item.award_times}����{else}{$item.award_times}��{/if}</td>
		<td><a href="{$_A.query_url}/type_edit{$_A.site_url}&id={$item.id}" >�޸�</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}</form>
	<tr>
		<td colspan="7" class="action">
		<div class="floatr">
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="7"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
	</form>
</table>

<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var username = $("#username").val();
	var keywords = $("#keywords").val();
	location.href=url+"&username="+username+"&keywords="+keywords;
}

</script>
{/literal}
{/if}