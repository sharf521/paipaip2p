{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}</strong></div>
	
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<select name="site_id"><option value="0">Ĭ������</option>{foreach from=$_A.site_list item=item key=key}
<option value="{ $item.site_id}" {if $result.site_id == $item.site_id} selected="selected"{/if} >-{$item.aname}</option>
{ /foreach}</select></div>
	</div>
	
	<div class="module_border" >
		<div class="l">���ڵأ�</div>
		<div class="c">
			<script src="./plugins/index.php?&q=area&area={ $_A.home_result.area}" type='text/javascript' language="javascript"></script> </div>
	</div>

	<div class="module_border" >
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.home_result.name}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�û�ID��</div>
		<div class="c">
			<input type="text" name="user_id"  class="input_border" value="{ $_A.home_result.user_id}" size="10" />
		</div>
	</div>
	

	<div class="module_border" >
		<div class="l">�ϴ�����ͼ��</div>
		<div class="c">
			<input type="file" name="litpic" size="30" class="input_border"/>{if $_A.home_result.litpic!=""}<a href="./{ $_A.home_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}</div>
	</div>

	<div class="module_border">
		<div class="l">�������ԣ�</div>
		<div class="c">
			{foreach from="$_A.flag_list" item="var"}<input type="checkbox" name="flag[]" value="{$var.nid}" {$var.nid|checked:$_A.code_result.flag } />{$var.name} {/foreach}
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.home_result.order|default:10}" size="10" />
		</div>
	</div>
	
	<div class="module_title"><strong>������ϸ</strong></div>
	
	<div class="module_border" >
		<div class="l">��������:</div>
		<div class="c">
			<input type="radio" name="chuzuleixing"  class="input_border" value="1" { if $_A.home_result.chuzuleixing==1 ||  $_A.home_result.chuzuleixing==''} checked="checked"{/if} /> ����
			<input type="radio" name="chuzuleixing"  class="input_border" value="2" { if $_A.home_result.chuzuleixing==2} checked="checked"{/if} /> ����
			<input type="radio" name="chuzuleixing"  class="input_border" value="3" { if $_A.home_result.chuzuleixing==3} checked="checked"{/if} /> ��λ
		</div>
	</div>	
	
	<div class="module_border" >
		<div class="l">����С��:</div>
		<div class="c">
			<input type="text" name="xiaoqu"  class="input_border" value="{ $_A.home_result.xiaoqu}" size="30" />
		</div>
	</div>	
	
	
	<div class="module_border" >
		<div class="l">���׻���:</div>
		<div class="c">
			<input type="text" name="shi"  class="input_border" value="{ $_A.home_result.shi}" size="5" /> ��
			<input type="text" name="ting"  class="input_border" value="{ $_A.home_result.ting}" size="5" /> ��
			<input type="text" name="wei"  class="input_border" value="{ $_A.home_result.wei}" size="5" /> ��
			&nbsp;&nbsp;&nbsp;��
			<input type="text" name="louceng"  class="input_border" value="{ $_A.home_result.louceng}" size="5" /> �� 
			��
			<input type="text" name="zonglouceng"  class="input_border" value="{ $_A.home_result.zonglouceng}" size="5" /> �� 
		</div>
	</div>	
	
	
	<div class="module_border" >
		<div class="l">���:</div>
		<div class="c">
			<input type="text" name="mianji"  class="input_border" value="{ $_A.home_result.mianji}" size="5" /> ƽ�� &nbsp;&nbsp;
			<script src="/plugins/index.php?q=linkage&name=leixing&nid=home_leixing&value={$_A.home_result.leixing}"></script>
			<script src="/plugins/index.php?q=linkage&name=zhuangxiu&nid=home_zhuangxiu&value={$_A.home_result.zhuangxiu}"></script>
			<script src="/plugins/index.php?q=linkage&name=chaoxiang&nid=home_chaoxiang&default=ѡ����&value={$_A.home_result.chaoxiang}"></script>
		</div>
	</div>	
	
	
	<div class="module_border" >
		<div class="l">���:</div>
		<div class="c">
			<input type="text" name="mianji"  class="input_border" value="{ $_A.home_result.mianji}" size="5"   />   Ԫ/��  &nbsp;&nbsp;
			<script src="/plugins/index.php?q=linkage&name=zujin&nid=home_zujin&value={$_A.home_result.zujin}"></script>
		</div>
	</div>	
	
	<div class="module_border" >
		<div class="l">��������:</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=peizhi&nid=home_peizhi&type=checkbox&value={$_A.home_result.peizhi}"></script>
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">����˵��:</div>
		<div class="c">
			<textarea name="content" cols="45" rows="5">{ $_A.home_result.content}</textarea>
		</div>
	</div>
	
	
	
	<div class="module_title"><strong>��ϵ��ʽ</strong></div>

	
	<div class="module_border">
		<div class="l">��ϵ�ˣ�</div>
		<div class="c">
			<input type="text" name="lianxiren"  class="input_border" value="{ $_A.home_result.lianxiren}"  size="30" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">�ֻ���绰��</div>
		<div class="c">
			<input type="text" name="dianhua"  class="input_border" value="{ $_A.home_result.dianhua}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">QQ��</div>
		<div class="c">
			<input type="text" name="qq"  class="input_border" value="{ $_A.home_result.qq}" size="30" />
		</div>
	</div>
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.home_result.id }" />{/if}
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

</script>
{/literal}
{elseif $_A.query_type == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>֤���鿴</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{ $_A.home_result.username}
		</div>
	</div>


	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			{ $_A.home_result.type_name }
		</div>
	</div>


	<div class="module_border">
		<div class="l">֤��ͼƬ��</div>
		<div class="c">
			<a href="{ $_A.home_result.litpic|imgurl_format }" ><img src="{ $_A.home_result.litpic|imgurl_format }" width="100" height="100" /></a>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���:</div>
		<div class="c">
			{ $_A.home_result.content}</div>
	</div>

	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.home_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.home_result.addip}</div>
	</div>
	
	
	<div class="module_title"><strong>��˴�֤��</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="0" {if $_A.home_result.status==0} checked="checked"{/if} />�ȴ����  <input type="radio" name="status" value="1" {if $_A.home_result.status==1} checked="checked"{/if}/>���ͨ�� <input type="radio" name="status" value="2" {if $_A.home_result.status==2} checked="checked"{/if}/>��˲�ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">ͨ����Ӧ�Ļ���:</div>
		<div class="c">
			<input type="text" name="jifen" value="{ $_A.home_result.jifen}" size="5">
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.home_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.home_result.id }" />
		
		<input type="submit"  name="reset" value="��˴�֤��" />
	</div>
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var verify_remark = frm.elements['verify_remark'].value;
	 var errorMsg = '';
	  if (verify_remark.length == 0 ) {
		errorMsg += '��ע������д' + '\n';
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
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="" class="main_td">��֤����</td>
			<td width="" class="main_td">��֤ͼƬ</td>
			<td width="" class="main_td">��֤״̬</td>
			<td width="" class="main_td">��֤����</td>
			<td width="" class="main_td">��֤���</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.home_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" >{ $item.id}</td>
			<td class="main_td1" align="center"><a href="{$_A.query_url}&username={$item.username}">{$item.username}</a></td>
			<td class="main_td1" align="center" >{$item.type_name}</td>
			<td class="main_td1" align="center" ><a href="{ $item.litpic|imgurl_format }" target="_blank" ><img src="{ $item.litpic|imgurl_format }" width="50" height="50" style="border:1px solid #CCCCCC" /></a></td>
			<td class="main_td1" align="center" >{ if $item.status ==1}���ͨ��{ elseif $item.status ==0}�ȴ����{else}���δͨ��{/if}</td>
			<td class="main_td1" align="center" >{$item.jifen}</td>
			<td class="main_td1" align="center" >{$item.content}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/view{$site_url}&id={$item.id}">���</a> <a href="{$_A.query_url}/edit{$site_url}&id={$item.id}">�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$site_url}&id={$item.id}'">ɾ��</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	var status = $("#status").val();
	if (status!=""){
		sou += "&status="+status;
	}
	if (sou!=""){
	location.href=url+sou;
	}
}
</script>
{/literal}
{elseif $_A.query_type == "type_list"}
<table width="100%" border="0" cellpadding="5" cellspacing="1" >
	<tr>
		<td class="main_td">��������</td>
		<td class="main_td">����</td>
		<td class="main_td">��Ҫ</td>
		<td class="main_td">��ע</td>
		<td class="main_td">����</td>
		<td class="main_td">״̬</td>
		<td class="main_td">����</td>
	</tr>
	<form action="{$_A.query_url}/type_order" method="post">
	{ foreach from = $_A.home_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td bgcolor="#ffffff" >{$item.name}</td>
		<td bgcolor="#ffffff" >{$item.jifen}</td>
		<td bgcolor="#ffffff" >{$item.summary}</td>
		<td bgcolor="#ffffff">{$item.remark}</td>
		<td bgcolor="#ffffff"><input name="order[]" size="2" value="{ $item.order}"type="text" ><input name="type_id[]" type="hidden" size="2" value="{ $item.type_id}" ></td>
		<td  bgcolor="#ffffff" >{ if $item.status==1}��ͨ{else}<font color=red>�ر�</font>{/if}</td>
		<td bgcolor="#ffffff"><a href="{$_A.query_url}/type_edit&type_id={$item.type_id}">�޸�</a>/<a href="#" onclick="javascript:if(confirm('ȷ��Ҫɾ����?������')) location.href='{$_A.query_url}/type_del&type_id={$item.type_id}'">ɾ��</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td   colspan="7" class="action"><input type="button" onclick="javascript:location.href='{$_A.query_url}/type_new{$_A.site_url}'" value="�������" />  <input type="submit" value="�޸�����" /> </td>
	</tr>
	</form>
</table>
{ elseif $_A.query_type == "type_new" || $_A.query_type == "type_edit" }
<div class="module_add">
	
	<form enctype="multipart/form-data" name="form1" method="post" action="" onsubmit="return check_form();"  >
	<div class="module_title"><strong>{ if $_A.query_type == "edit" }�༭{else}���{/if}��֤����</strong></div>
	
	<div class="module_border">
		<div class="l">��������:</div>
		<div class="c">
			<input type="text" name="name"  class="input_border" value="{ $_A.home_type_result.name}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">
			<input type="text" name="order"  class="input_border" value="{ $_A.home_type_result.order|default:10}" size="30" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
			<input type="radio" name="status" value="0"  { if $_A.home_type_result.status == 0 }checked="checked"{/if}/> �ر�<input type="radio" name="status" value="1"  { if $_A.home_type_result.status ==1 ||$_A.home_type_result.status ==""}checked="checked"{/if}/>��ͨ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">Ĭ�ϻ���:</div>
		<div class="c">
			<input type="text" name="jifen" value="{ $_A.home_type_result.jifen|default:2}" /
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ҫ˵��:</div>
		<div class="c">
			<textarea name="summary" cols="55" rows="6" >{ $_A.home_type_result.summary}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע:</div>
		<div class="c">
			<textarea name="remark" cols="55" rows="6" >{ $_A.home_type_result.remark}</textarea>
		</div>
	</div>
	
	<div class="module_submit" >
	{ if $_A.query_type == "type_edit" }<input type="hidden" name="type_id" value="{ $_A.home_type_result.type_id }" />{/if}
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