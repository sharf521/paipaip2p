{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��˾</strong></div>
	
	<div class="module_border">
		<div class="l">��˾���ƣ�</div>
		<div class="c">
			<input type="text" name="name" class="input_border" value="{ $_A.company_result.name}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<select name="site_id"><option>Ĭ����Ŀ</option>{foreach from=$site_list item=item key=key}
<option value="{ $item.site_id}" {if $_A.company_result.site_id == $item.site_id} selected="selected"{/if} >-{$item.aname}</option>
{ /foreach}</select>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
			{loop table="flag" order="`order` desc" var="var"}<input type="checkbox" name="flag[]" value="{$var.nid}" {$var.nid|checked:$_A.company_result.flag }/>{$var.name} {/loop}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.company_result.status == 0 }checked="checked"{/if}/>���� <input type="radio" name="status" value="1"  { if $_A.company_result.status ==1 ||$_A.company_result.status ==""}checked="checked"{/if}/>��ʾ 
		</div>
	</div>

	<div class="module_border">
		<div class="l">����</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.company_result.order|default:10}" size="10" />
		</div>
	</div>
	

	<div class="module_border">
		<div class="l">�������ͣ�</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=type&nid=company_type&type=checkbox&value={$_A.company_result.type}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ڰٷֱȣ�</div>
		<div class="c">
			<input name="percentage" type="text" value="{$_A.company_result.percentage}" size="30" align="absmiddle"/>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ʱ���</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=capital&nid=company_ziben&value={$_A.company_result.capital}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ҫ�������ƣ�</div>
		<div class="c">
			<input name="ascendent"  type="text" value="{$_A.company_result.ascendent}" size="30" align="absmiddle"/>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������Σ�</div>
		<div class="c">
			<input name="quality" type="text" value="{$_A.company_result.quality}" size="30" align="absmiddle"/>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">ȫ�����ۣ�</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=sales&nid=company_xs&value={$_A.company_result.sales&nid}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ա������</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=staff&nid=company_man&value={$_A.company_result.staff}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ݣ�</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=foundyear&nid=company_year&value={$_A.company_result.foundyear}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=payment&nid=company_fukuan&value={$_A.company_result.payment}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ҫ�����г���</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=markets_main&nid=company_market&value={$_A.company_result.markets_main}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���������г���</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=markets_other&nid=company_omarket&value={$_A.company_result.markets_other}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��������</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=replace_work&nid=company_daigong&value={$_A.company_result.replace_work}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�з���Ա������</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=rdman&nid=company_yanfa&value={$_A.company_result.rdman}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʦ������</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=engineer&nid=company_gongcheng&value={$_A.company_result.engineer}"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��˾��飺</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.company_result.content"}
		</div>
	</div>
	
	<div class="module_title"><strong>��˾��ϵ��ʽ</strong></div>
	
	
	<div class="module_border">
		<div class="l">��˾���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={$_A.company_result.area}" type='text/javascript' language="javascript"></script>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ϵ�ˣ�</div>
		<div class="c">
			<input type="text" name="linkman"  class="input_border" value="{ $_A.company_result.linkman}"  size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">��ϵ��ַ��</div>
		<div class="c">
			<input type="text" name="address"  class="input_border" value="{ $_A.company_result.address}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ʱࣺ</div>
		<div class="c">
			<input type="text" name="postcode"  class="input_border" value="{ $_A.company_result.postcode}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">�绰��</div>
		<div class="c">
			<input type="text" name="tel"  class="input_border" value="{ $_A.company_result.tel}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���棺</div>
		<div class="c">
			<input type="text" name="fax" class="input_border" value="{ $_A.company_result.fax}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">���䣺</div>
		<div class="c">
			<input type="text" name="email"  class="input_border" value="{ $_A.company_result.email}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">MSN��</div>
		<div class="c">
			<input type="text" name="msn"  class="input_border" value="{ $_A.company_result.msn}" size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">QQ��</div>
		<div class="c">
			<input type="text" name="qq"  class="input_border" value="{ $_A.company_result.qq}" size="30" />
		</div>
	</div>

	{if $input!=""}
	<div class="module_title"><strong>�Զ�������</strong></div>
	{foreach from=$input item=item}
	<div class="module_border">
		<div class="l">{$item.0}:</div>
		<div class="c">
			{$item.1}
		</div>
	</div>
	{/foreach}
	{/if}
	
	
	<div class="module_submit border_b" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.company_result.id }" />{/if}
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
	  if ($("#site_center").val()==""){
		errorMsg += '��ѡ����Ŀ' + '\n';
	}
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}

{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<form action="{$_A.query_url}/action{$site_url}" method="post">
	<tr >
		<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
		<td width="*" class="main_td">��˾����</td>
		<td width="*" class="main_td">���ʱ��</td>
		<td width="" class="main_td">״̬</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
		<td width="" class="main_td">����</td>
	</tr>
	{ foreach  from=$_A.company_list key=key item=item}
	<tr {if $key%2==1}class="tr2"{/if}>
		<td class="main_td1" align="center" ><input type="checkbox" name="aid[{$key}]" value="{$item.id}"/></td>
		<td class="main_td1" align="center">{$item.name|truncate:34}</td>
		<td class="main_td1" align="center">{$item.addtime|date_format:"Y-m-d"}</td>
		<td class="main_td1" align="center" >{ if $item.status ==1}<a href="{$_A.query_url}{$site_url}&status=0&id={ $item.id}">��ʾ</a>{else}<a href="{$_A.query_url}{$site_url}&status=1&id={ $item.id}">����</a>{/if}</td>
		<td class="main_td1" align="center" >{$item.flagname|default:-}</td>
		<td class="main_td1" align="center" ><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="id[{$key}]" value="{$item.id}" /></td>
		<td class="main_td1" align="center" ><a href="{$_A.query_url}/edit{$site_url}&id={$item.id}" >�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$site_url}&id={$item.id}'">ɾ��</a></td>
	</tr><input type="hidden" name="flag[{$key}]" value="{$item.flag}" />
	{ /foreach}
	<tr>
		<td colspan="10" class="action">
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
		<div class="floatr">
			�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
	<tr>
		<td colspan="10"  class="page">
		{$_A.showpage} 
		</td>
	</tr>
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var keywords = $("#keywords").val();
	location.href=url+"&keywords="+keywords;
}

</script>
{/literal}
{/if}