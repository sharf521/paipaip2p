<!--VIP������-->
{if 'ct' == $_A.query_type} 
<div class="module_add">
	<form action="{$_A.query_url}/{if $magic.request.id!=""}uct{else}act{/if}{$_A.site_url}" method="post">
	<div class="module_title"><strong>{if $magic.request.id!=""}�޸�<input type="hidden" name="id" value="{$result.id}" />{else}���{/if}��ֵ������</strong></div>
	
	<div class="module_border">
		<div class="l">�� �ͣ�</div>
		<div class="c">
			<input name="type" type="text" maxlength="20" value="{$result.name}" /> <span class="red">*</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�� ����</div>
		<div class="c">
			<input name="month_num" type="text" value="{$result.month_num}" /> <span style="color:red;">*</span>
		</div>
	</div>
	
	<div class="module_submit" >
		<input name="submit" type="submit" value="�� ��" class="btn" />
	</div>
	</form>

	<div class="module_title"><strong>��ӳ�ֵ�������б�</strong></div>
</div>
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		
		<tr >
			<td align="center" class="main_td">�� ��</td>
			<td align="center" class="main_td">�� ��</td>
			<td align="center" class="main_td">�� ��</td>
		</tr>
		{foreach from=$rows item=result}
		<tr {if $key%2==1}class="tr2"{/if}>
			<td>{$result.name}</td>
			<td>{$result.month_num}</td>
			<td align="center"><a href="{$_A.query_url}/ct&id={$result.id}">�༭</a>  <a href="javascript:if(confirm('ȷʵҪɾ����?'))location='{$_A.query_url}/dct&id={$result.id}';">ɾ��</a></td>
		</tr>
		{/foreach}
	</table>

<!--/VIP������-->


<!--VIP��-->
    <!--����¿�-->
{elseif 'ac' == $_A.query_type}
<div class="module_add">
	 <form action="" method="post">
	<div class="module_title"><strong>����¿�</strong></div>
	
	<div class="module_border">
		<div class="l">���ڳ��У�</div>
		<div class="c">
			<script src="/plugins/index.php?q=area&type=p,c"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ѧ�ڣ�</div>
		<div class="c">
			<select name="year">
					{foreach from=$years item=item}
						<option value="{$item}">{$item}</option>
					{/foreach}
				</select>
				<select name="semester">
						<option value="A" {if 'A'==$semester}selected{/if}>��ѧ��</option>
						<option value="B" {if 'B'==$semester}selected{/if}>��ѧ��</option>
				</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���������</div>
		<div class="c">
			<input name="number" type="text" /> <span style="color:red;">*</span> һ�����ֻ������100��
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����λ����</div>
		<div class="c">
			<select name="pwd_word_num">
					<option value="4">��λ��</option>
					<option value="5">��λ��</option>
					<option value="6" selected>��λ��</option>
					<option value="7">��λ��</option>
					<option value="8">��λ��</option>
			</select>
		</div>
	</div>
	
	<div class="module_submit" >
		<input name="step" type="hidden" value="2" />
		<input type="submit" name="submit" value="����" class="btn" />
	</div>
</form>
</div>
    <!--/����¿�-->
    <!--��ֵ���б�-->
{elseif 'lc' == $_A.query_type}

<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/delcard" method="post">
    <tr>
		<td class="main_td" align="center"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
        <td class="main_td" align="center">����</td>
        <td class="main_td" align="center">����</td>
        <td class="main_td" align="center">����</td>
        <td class="main_td" align="center">��ֵ��ע</td>
        <td class="main_td" align="center">��ֵʱ��</td>
        <td class="main_td" align="center">����ʱ��</td>
		<td class="main_td" align="center">VIP����</td>
		<td class="main_td" align="center">������</td>
        <td class="main_td" align="center" width="140px">�� ��</td>
    </tr>
   {foreach from=$rows key=key item=item}
        <tr  {if $key%2==1}class="tr2"{/if}>
			<td><input type="checkbox" name="aid[{$key}]" value="{$item.serial_number}"/></td>
			<td>{$item.serial_number}</td>
			<td>{$item.password}</td>
			<td>{$item.city}</td>
			<td>{if $item.realname}<a href="index.php?admin&q=module/schoolresume/preview&id={$item.re_id}">{$item.realname}</a>{else}δ��ֵ{/if}</td>
			<td>{$item.open_time|date_format:'Y-m-d'|default:"-"}</td>
			<td>{$item.end_date|date_format:'Y-m-d'|default:"-"}</td>
			<td>{$item.vct_name|default:"-"}</td>
			<td>{$item.create_user}</td>
			<td><a href="{$_A.query_url}/history&id={$item.id}">{$item.status_name}</a> | <a href="{$_A.query_url}/editcard&id={$item.id}">�༭</a> | <a href="{$_A.query_url}/preview&id={$item.id}">�鿴</a></td>
        </tr>
   {/foreach}
	<tr>
		<td colspan="12"  class="action" >
			<div class="floatl"> <select name="type">
			<option value="6">ɾ��</option>&nbsp;&nbsp;&nbsp;
			</select> <input type="submit" value="ȷ�ϲ���" />
			</div>
			<div class="floatr">
			״ ̬��<select name="status" id="status">
            <option value="7" {if 7==$magic.request.status}selected{/if}>ȫ��</option>
            <option value="0" {if 0==$magic.request.status}selected{/if}>δ����</option>
            <option value="1" {if 1==$magic.request.status}selected{/if}>����</option>
			<option value="5" {if 5==$magic.request.status}selected{/if}>����</option>
			<option value="6" {if 6==$magic.request.status}selected{/if}>����</option>
            <option value="2" {if 2==$magic.request.status}selected{/if}>����</option>
            <option value="3" {if 3==$magic.request.status}selected{/if}>ͣ��</option>
            <option value="4" {if 4==$magic.request.status}selected{/if}>����</option>
        </select>&nbsp&nbsp;
        VIP���ţ�<input type="text" name="serial_number" id="serial_number" value="{$magic.request.serial_number}" maxlength="15" />
        &nbsp;&nbsp;<input type="button" value="����" / onclick="sousuo()">&nbsp;<input type="button" value="������ֵ��" / onclick="javascript:location.href='{$_A.query_url}/lc&export=1'">
			</div>
			</td>
		</tr>
    <tr bgcolor='#FFFFFF'><td colspan='11' class="page">{$page}</td></tr>
</form>
</table>
<script>
var url = '{$_A.query_url}/lc/';
{literal}
function sousuo(){
	var status = $("#status").val();
	var serial_number = $("#serial_number").val();
	location.href=url+"&status="+status+"&serial_number="+serial_number+"&export=0";
}

</script>
{/literal}
 <!--/��ֵ���б�-->
 
<!--�鿴VIP����Ϣ-->
{elseif 'preview' == $_A.query_type}
<div class="module_add">
	<div class="module_title"><strong>�鿴VIP����Ϣ</strong></div>
	
	
	
	<div class="module_border">
		<div class="l">�û���:</div>
		<div class="c">
			{$result.username|default:"-"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�� ��:</div>
		<div class="c">
			{$result.serial_number}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��������:</div>
		<div class="c">
			{$result.batch}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�� ��:</div>
		<div class="c">
			{$result.password}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ��:</div>
		<div class="c">
			{$result.create_time}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ч��:</div>
		<div class="c">
			{$result.start_date|default -} �� {$result.end_date|default -}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�� ��:</div>
		<div class="c">
			{$result.vct_name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ч����:</div>
		<div class="c">
			{$result.month_num}
		</div>
	</div>

	<div class="module_border">
		<div class="l">����ʱ��:</div>
		<div class="c">
			{$result.open_time|default -}
		</div>
	</div>

	<div class="module_border">
		<div class="l">״ ̬:</div>
		<div class="c">
			{$result.status_name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��������:</div>
		<div class="c">
			{$result.freeze_day}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ��:</div>
		<div class="c">
			{$result.freeze_time|default -}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���������:</div>
		<div class="c">
			{$result.freeze_times|default 0}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ͣ������:</div>
		<div class="c">
			{$result.stop_day}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ͣ��ʱ��:</div>
		<div class="c">
			{$result.stop_time|default -}
		</div>
	</div>
	
	<div class="module_submit" >
		<input name="bk" type="button" value="�� ��" onclick="javascript:history.back(-1);" />
		<input name="bk" type="button" value="�� ��" onclick="javascript:window.location.href='{$_A.query_url}/editcard&id={$result.id}';" />
	</div>
</div>
    <!--�༭/VIP����Ϣ-->
<!--/VIP��-->
{elseif 'usercard' == $_A.query_type}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
		<tr >
			<!-- <td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td> -->
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">����</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$result key=key item=item}
		<tr >
			<!-- <td class="main_td1" align="center" width="40"><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td> -->
			<td class="main_td1" align="center" width="30">{ $item.id}</td>
			<td class="main_td1" align="center">{$item.name|truncate:34}</td>
			<td class="main_td1" align="center" width="50">{ if $item.status ==1}<a href="{$_A.query_url}{$_A.site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$_A.site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
			<td class="main_td1" align="center" width="50"><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="id[{$key}]" value="{$item.id}" /></td>
			<td class="main_td1" align="center" width="70">{$item.flagname|default:-}{if $item.litpic!=""}ͼƬ{/if}</td>
			<td class="main_td1" align="center" width="130"><a href="{$_A.query_url}/edit{$_A.site_url}&id={$item.id}" >�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
		</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
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
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
			</div>
			</td>
		</tr> 
		<tr>
			<td colspan="8"  class="page" >
			{$page}
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
{elseif 'nvipuser' == $_A.query_type}
<div class="module_add">
	<form action="{$_A.query_url}/nvipuser" method="post">
	<div class="module_title"><strong>����VIP��Ա</strong></div>
	<div class="module_border">
		<div class="l">��Ա�˺�:</div>
		<div class="c">
			<input name="user_name" type="text" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">VIP���ͣ�</div>
		<div class="c">
			<select name="vct_id">
					{foreach from=$vct item=item}
					<option value="{$item.id}">{$item.name}</option>
					{/foreach}
				</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">VIP���ţ�</div>
		<div class="c">
			<input name="serial_number" type="text" value="{$serial_number}" />
		</div>
	</div>
	
	<div class="module_submit" >
		 <input name="step" type="hidden" value="2" />
		 <input type="submit" name="submit" value="����" class="btn" />
	</div>
	</form>
</div>

{elseif 'editcard' == $_A.query_type}
<div class="module_add">
	<form acton="{$_A.query_url}/editcard" method="post">
	<div class="module_title"><strong>����VIP��Ա</strong></div>
	<div class="module_border">
		<div class="l">��Чʱ��:</div>
		<div class="c">
			{$result.start_date|date_format:'Y-m-d'}��{$result.end_date|date_format:'Y-m-d'}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ʹ��״̬��</div>
		<div class="c">
			<input name="status" id="jy" value="jy" type="radio" {if 4==$result.status}checked="true"{/if} onclick="javascript:displayTime('none');" /><label for="jy">���ô˿�</label>
			<input name="status" id="jh" value="jh" type="radio" {if 1==$result.status}checked="true"{/if} onclick="javascript:displayTime('none');" /><label for="jh">����˿�</label>
			<input name="status" id="tz" value="tz" type="radio" {if 3==$result.status}checked="true"{/if} onclick="javascript:displayTime('');" /><label for="tz">ֹͣ�˿�</label>
			<input name="status" id="dj" value="dj" type="radio" {if 2==$result.status}checked="true"{/if} onclick="javascript:displayTime('');" /><label for="dj">����˿�</label>
			<input name="status" id="yq" value="yq" type="radio" {if 5==$result.status}checked="true"{/if} onclick="javascript:displayTime('');" /><label for="yq">���ڴ˿�</label>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ѡ��ʱ�䣺</div>
		<div class="c">
			<select name="year">
				<option value="0">����</option>
				<option value="1">һ��</option>
				<option value="2">����</option>
				<option value="3">����</option>
			</select>
			<select name="month">
			<option value="0">�����</option>
			<option value="1">һ����</option>
			<option value="2">������</option>
			<option value="3">������</option>
			<option value="4">�ĸ���</option>
			<option value="5">�����</option>
			<option value="6">������</option>
			<option value="7">�߸���</option>
			<option value="8">�˸���</option>
			<option value="9">�Ÿ���</option>
			<option value="10">ʮ����</option>
			<option value="11">ʮһ����</option>
			<option value="12">ʮ������</option>
		</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ԭ��</div>
		<div class="c">
			<a href="javascript:display('remark');">�����Ӳ���ԭ��</a>&nbsp;&nbsp;<input name="remark" id="remark" size="50" style="display:none;"></input>
		</div>
	</div>
	
	<div class="module_submit" >
		 <input name="id" type="hidden" value="{$result.id}" />
		<input type="submit" name="submit" value="ȷ��" />
		<input type="button" value="����" onclick="javascript:history.back(-1);" />
	</div>
	</form>
</div>
{literal}
<script>
	function display(id) {
		status = 'none';
		if (document.getElementById(id).style.display==status) {
			status = '';
		}
		document.getElementById(id).style.display = status;
	}

	function displayTime(status) {
		document.getElementById('time').style.display = status;
	}
</script>
{/literal}
{elseif 'history' == $_A.query_type}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
	<tr >
		<td width="*" class="main_td">����</td>
		<td width="" class="main_td">��������</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����ԭ��</td>
		<td width="" class="main_td">������</td>
		<td width="" class="main_td">����ʱ��</td>
		<td width="" class="main_td">����IP</td>
	</tr>
	{ foreach  from=$result key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.serial_number}</td>
		<td class="main_td1" align="center">{$item.op}</td>
		<td class="main_td1" align="center">{$item.expire|default 0}����</td>
		<td class="main_td1" align="center">{$item.remark}</td>
		<td class="main_td1" align="center">{$item.username}</td>
		<td class="main_td1" align="center">{$item.optime}</td>
		<td class="main_td1" align="center">{$item.optip}</td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="7" class="page">
		{$page}
		</td>
	</tr>
	</form>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var username = $("#user_name").val();
	var keywords = $("#serial_number").val();
	location.href=url+"&user_name="+username+"&serial_number="+keywords;
}

</script>
{/literal}
{elseif 'getjob' == $_A.query_type}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr>
		<td width="*" class="main_td">����</td>
		<td width="" class="main_td">VIP����/��ע</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">�Ա�</td>
		<td width="" class="main_td">���</td>
		<td width="" class="main_td">�绰</td>
		<td width="" class="main_td">ѧУ</td>
		<td width="" class="main_td">У��</td>
		<td width="" class="main_td">רҵ</td>
		<td width="" class="main_td">�꼶</td>
		<td width="" class="main_td">���г�</td>
		<td width="" class="main_td">����֤</td>
		</tr>
	<tr class="tr2">
		<td class="main_td1" align="center">{$vip_user.serial_number}</td>
		<td class="main_td1" align="center">{$vip_user.vct_name}/{$vip_user.status_name}</td>
		<td class="main_td1" align="center">{$vip_user.realname}</td>
		<td class="main_td1" align="center">{if 1==$vip_user.sex}��{elseif 2==$vip_user.sex}Ů{else}��{/if}</td>
		<td class="main_td1" align="center">{$vip_user.height}</td>
		<td class="main_td1" align="center">{$vip_user.phone_number}</td>
		<td class="main_td1" align="center">{$vip_user.school}</td>
		<td class="main_td1" align="center">{$vip_user.school_area}</td>
		<td class="main_td1" align="center">{$vip_user.professional}</td>
		<td class="main_td1" align="center">{$vip_user.grade}</td>
		<td class="main_td1" align="center">{if 1==$vip_user.bike}��{elseif 2==$vip_user.bike}�ɽ�{else}��{/if}</td>
		<td class="main_td1" align="center">{if 1==$vip_user.health_certificate}��{elseif 2==$vip_user.health_certificate}�ɰ���{else}��{/if}</td>
	</tr>
</table><br />

<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<!-- <tr>
			<td colspan="16" bgcolor="#ffffff" class="main_td1" height="40">
			��λ��ţ�<input type="text" name="number" id="number" value="{$magic.request.number}"/>
			�̼����ƣ�<input type="text" name="company" id="company" value="{$magic.request.company}"/>
				<input type="button" value="����" / onclick="sousuo()">
			</td>
		</tr> -->
		<form action="{$_A.query_url}/action{$_A.site_url}" method="post">
		<tr >
			<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">��λ���</td>
			<td width="" class="main_td">�̼�����</td>
			<td width="" class="main_td">������λ</td>
			<td width="" class="main_td">��λ����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�Ա�Ҫ��</td>
			<td width="" class="main_td">��н</td>
			<td width="" class="main_td">���</td>
			<td width="" class="main_td">����֤</td>
			<td width="" class="main_td">���г�</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����|��Ա|����</td>

		</tr>
		{ foreach  from=$result key=key item=item}
		<tr {if $key%2==1}class="tr2"{/if}>
			<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
			<td class="main_td1" align="center" >{ $item.id}</td>
			<td class="main_td1" align="center">{$item.number}</td>
			<td class="main_td1" align="center" >{$item.company}</td>
			<td class="main_td1" align="center" >{$item.gangwei}</td>
			<td class="main_td1" align="center" >{$item.type}</td>
			<td class="main_td1" align="center" >{$item.apply_man+$item.apply_male+$item.apply_female}</td>
			<td class="main_td1" align="center" >{if $item.apply_man>0}��{else}��{$item.apply_male}��|Ů{$item.apply_female}��{/if}</td>
			<td class="main_td1" align="center">{$item.pay}</td>
			<td class="main_td1" align="center" >{if $item.is_award}��{else}��{/if}</td>
			<td class="main_td1" align="center" >{if $item.is_health_certificate}��Ҫ{else}����Ҫ{/if}</td>
			<td class="main_td1" align="center">{if $item.is_bike}��Ҫ{else}����Ҫ{/if}</td>
			<td class="main_td1" align="center" >{if $item.need_interview}��Ҫ{else}����Ҫ{/if}</td>
			<td class="main_td1" align="center">{$item.end_time|date_format 'Y-m-d H:i:s'}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}��ʾ{else}����{/if}</td>
			<td class="main_td1" align="center" >{if !$is_working}<a href="{$_A.query_url}/admit&uid={$user_id}&jid={$item.id}" >����</a>|{/if}<a href="index.php?admin&q=module/jianzhi/view{$_A.site_url}&id={$item.id}" >�鿴</a></td>
		</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
		{ /foreach}
		<tr>
			<td colspan="13" class="action" >
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
			</td>
		</tr>
		<tr>
			<td colspan="16" class="page">
			{$page}
			</td>
		</tr>
	</form>
</table>
	  <script>
	  var url = '{$_A.query_url}';
	    {literal}
	  	function sousuo(){
			var company = $("#company").val();
			var number = $("#number").val();
			location.href=url+"&company="+company+"&number="+number;
		}

	  </script>
	  {/literal}
{else}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="*" class="main_td">����</td>
		<td width="" class="main_td">VIP����/��ע</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">�Ա�</td>
		<td width="" class="main_td">���</td>
		<td width="" class="main_td">�绰</td>
		<td width="" class="main_td">ѧУ</td>
		<td width="" class="main_td">У��</td>
		<td width="" class="main_td">רҵ</td>
		<td width="" class="main_td">�꼶</td>
		<td width="" class="main_td">���г�</td>
		<td width="" class="main_td">����֤</td>
		<td width="" class="main_td">״̬/����/����</td>
	</tr>
	{ foreach  from=$_A.vipuser_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.serial_number}</td>
		<td class="main_td1" align="center">{$item.vct_name}/<a href="{$_A.query_url}/editcard&id={$item.id}" title="�༭">{$item.status_name}</a></td>
		<td class="main_td1" align="center">{$item.realname}</td>
		<td class="main_td1" align="center">{if 1==$item.sex}��{elseif 2==$item.sex}Ů{else}��{/if}</td>
		<td class="main_td1" align="center">{$item.height}</td>
		<td class="main_td1" align="center">{$item.phone_number}</td>
		<td class="main_td1" align="center">{$item.school}</td>
		<td class="main_td1" align="center">{$item.school_area}</td>
		<td class="main_td1" align="center">{$item.professional}</td>
		<td class="main_td1" align="center">{$item.grade}</td>
		<td class="main_td1" align="center">{if 1==$item.bike}��{elseif 2==$item.bike}�ɽ�{else}��{/if}</td>
		<td class="main_td1" align="center">{if 1==$item.health_certificate}��{elseif 2==$item.health_certificate}�ɰ���{else}��{/if}</td>
		<td class="main_td1" align="center" width="130">{if $item.lq_status}������{else}δ���� <a href="{$_A.query_url}/getjob&id={$item.user_id}{$_A.site_url}">����</a>{/if} <a href="#">�鿴</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="13" class="action" >
		<div class="floatl">
		
		</div>
		<div class="floatr">������<input type="text" name="realname" id="realname" value="{$magic.request.realname}"/> VIP���ţ�<input type="text" name="serial_number" id="serial_number" value="{$magic.request.serial_number}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="13" class="page" >
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}{$_A.site_url}';
{literal}
function sousuo(){
	var realname = $("#realname").val();
	var keywords = $("#serial_number").val();
	location.href=url+"&realname="+realname+"&serial_number="+keywords;
}

</script>
{/literal}
{/if}