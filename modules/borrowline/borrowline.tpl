{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	{if $magic.request.user_id==""}
	<form name="form1" method="post" action="" enctype="multipart/form-data" >
	<div class="module_title"><strong>���������Ϣ���û�����ID</strong></div>
	

	<div class="module_border">
		<div class="l">�û�ID��</div>
		<div class="c">
			<input type="text" name="user_id"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<input type="text" name="username"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_submit" >
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	{else}
	<div class="module_title"><strong>������Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrowline_result.username}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">������;��</div>
		<div class="c">&nbsp;&nbsp;
		{linkages name="borrow_use" nid="borrow_yongtu" value="$_A.borrowline_result.borrow_use"}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�������ޣ�</div>
		<div class="c">&nbsp;&nbsp;
		{linkages name="borrow_qixian" nid="borrow_qixian" value="$_A.borrowline_result.borrow_qixian"}</div>
	</div>
	<div class="module_border">
		<div class="l">�������:</div>
		<div class="c">&nbsp;&nbsp;<script src="/plugins/index.php?q=area&type=p,c&area={$_A.borrowline_result.area}"></script></div>
	</div>
	<div class="module_border">
		<div class="l">������:</div>
		<div class="c">&nbsp;&nbsp;<input type="text" name="account"  class="input_border"  size="6"  value="{ $_A.borrowline_result.account}"/>��Ԫ/���ʣ���δ��һ����дС���磺0.5��</div>
	</div>
	<div class="module_border">
		<div class="l">���޵�Ѻ:</div>
		<div class="c">&nbsp;&nbsp;<input type="radio" name="pawn" value="1" checked="checked" {if $_A.borrowline_result.pawn==1} checked="checked"{/if} />�� <input type="radio" name="pawn" value="0"  {if $_A.borrowline_result.pawn==0} checked="checked"{/if} />�� </div>
	</div>
	<div class="module_border">
		<div class="l">�������:</div>
		<div class="c">&nbsp;&nbsp;<input type="text" name="name"  class="input_border" value="{ $_A.borrowline_result.name}" size="15" />�磺���轨�·��Ӵ���8������8�����֡�����������д��������ϵ��ʽ</div>
	</div>
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">&nbsp;&nbsp;<input type="text" name="xing"  class="input_border" value="{ $_A.borrowline_result.xing}" size="5" /><input type="radio" name="sex" value="1" {if $_A.borrowline_result.sex==1} checked="checked"{/if} />���� <input type="radio" name="sex" value="2" {if $_A.borrowline_result.sex==2} checked="checked"{/if} />Ůʿ Ϊ�˱�֤�����˽����ֻ��Ҫ��д�գ�������������֡��磺��</div>
	</div>
	<div class="module_border">
		<div class="l">��ϵ�绰:</div>
		<div class="c">&nbsp;&nbsp;<input type="text" name="tel"  class="input_border" value="{ $_A.borrowline_result.tel}" size="20" /> Ϊ�˷����ҵ��㣬����д�����ֻ�����</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">&nbsp;&nbsp;<input type="text" name="email"  class="input_border" value="{ $_A.borrowline_result.email}" size="20" /> ��Ϣ��������ø�����Ϊ�˺ŵ�¼�鿴��������״̬</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">����˵��:</div>
		<div class="c">&nbsp;&nbsp;<textarea name="content" class="input_border" style="height:80px;" cols="50" rows="5">{$_A.borrowline_result.content}</textarea></div>
	</div>
	
	<div class="module_submit" >
		{if $_A.query_type == "edit"}<input type="hidden"  name="id" value="{$magic.request.id}" />{/if}
		<input type="hidden"  name="user_id" value="{$magic.request.user_id}" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	
	
	{/if}
</div>
{literal}
<script>


function check_form(){
	 var frm = document.forms['form1'];
	 var name = frm.elements['name'].value;
	 var award = frm.elements['award'].value;
	 var part_account = frm.elements['part_account'].value;
	 var errorMsg = '';
	  if (name.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	   if (award ==1 && part_account<5) {
		errorMsg += '��������С��5Ԫ' + '\n';
	  }
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "view" }
<div class="module_title"><strong>������Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrowline_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������;��</div>
		<div class="c">&nbsp;&nbsp;
		{$_A.borrowline_result.borrow_use|linkage}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�������ޣ�</div>
		<div class="c">&nbsp;&nbsp;
		{$_A.borrowline_result.borrow_qixian|linkage}</div>
	</div>
	<div class="module_border">
		<div class="l">�������:</div>
		<div class="c">&nbsp;&nbsp;{$_A.borrowline_result.area|area:"p,c"}</div>
	</div>
	<div class="module_border">
		<div class="l">������:</div>
		<div class="c">&nbsp;&nbsp;{ $_A.borrowline_result.account}��Ԫ/����</div>
	</div>
	<div class="module_border">
		<div class="l">���޵�Ѻ:</div>
		<div class="c">&nbsp;&nbsp;{if $_A.borrowline_result.pawn==1} ��{else}��{/if} </div>
	</div>
	<div class="module_border">
		<div class="l">�������:</div>
		<div class="c">&nbsp;&nbsp;{ $_A.borrowline_result.name}</div>
	</div>
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">&nbsp;&nbsp;{ $_A.borrowline_result.xing} {if $_A.borrowline_result.sex==1}����{else}Ůʿ{/if}</div>
	</div>
	<div class="module_border">
		<div class="l">��ϵ�绰:</div>
		<div class="c">&nbsp;&nbsp;{ $_A.borrowline_result.tel}</div>
	</div>
	
	<div class="module_border">
		<div class="l">����:</div>
		<div class="c">&nbsp;&nbsp;{ $_A.borrowline_result.email}</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">����˵��:</div>
		<div class="c">&nbsp;&nbsp;{$_A.borrowline_result.content}</div>
	</div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">&nbsp;&nbsp;<input type="radio" name="status" value="1" {if $_A.borrowline_result.status==1} checked="checked"{/if} />ͨ��<input type="radio" name="status" value="2" {if $_A.borrowline_result.status==2} checked="checked"{/if} />��ͨ��</div>
	</div>
	
	<div class="module_border">
		<div class="l">����˵��:</div>
		<div class="c">&nbsp;&nbsp;<textarea name="verify_remark" class="input_border" style="height:80px;" cols="50" rows="5">{$_A.borrowline_result.verify_remark }</textarea></div>
	</div> 
	
	<div class="module_submit" >
		<input type="hidden"  name="id" value="{$magic.request.id}" />
		<input type="hidden"  name="user_id" value="{$magic.request.user_id}" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
</div>

{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td"><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
			<td width="*" class="main_td">�û���</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�����</td>
			<td width="" class="main_td">�绰</td>
			<td width="" class="main_td">���ʱ��</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.borrowline_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" ><input type="checkbox" name="aid[]" id="aid[]" value="{$item.id}"/></td>
			<td class="main_td1" align="center" >{ $item.username}</td>
			<td class="main_td1" align="center" >{$item.xing}{if $item.sex==1}����{else}Ůʿ{/if}</td>
			<td class="main_td1" align="center">{$item.name|truncate:34}</td>
			<td class="main_td1" align="center" >{$item.account}</td>
			<td class="main_td1" align="center" >{$item.tel}</td>
			<td class="main_td1" align="center" >{$item.addtime|date_format}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}���ͨ��{ elseif $item.status ==2}���ʧ��{else}<a href="{$_A.query_url}/view{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">�����</a>{/if}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/edit{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">�޸�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.query_url}/del{$_A.site_url}&id={$item.id}'">ɾ��</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> <input type="button" value="����" / onclick="sousuo()">
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

{/if}