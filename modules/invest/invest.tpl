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
	<div class="module_title"><strong>����û���Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrow_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����;��</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=use&nid=borrow_use&value={$_A.borrow_result.use}"></script> <span >˵�����ɹ���ľ�����;��</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ޣ�</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=time_limit&nid=borrow_time_limit&isid=false&value={$_A.borrow_result.time_limit}"></script> <span >���ɹ���,�����Լ����µ�ʱ���������� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=style&nid=borrow_style&value={$_A.borrow_result.style}"></script> <span >�����ȷ��ڻ�����ָ�����߽��ɹ���,ÿ�»�Ϣ������������</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ܽ�</div>
		<div class="c">
				<input type="text" name="account" value="{$_A.borrow_result.account}" /> <span >�����Ӧ��500Ԫ��50,000Ԫ֮�䡣���ױ��־�Ϊ����ҡ����ɹ���, ���2���� ,��ȡ��ǰ�����2%�Ĺ����,������������ϵ�ÿ������0.2%�����,����10%��Ϊ��֤��,�����������,��վ�ⶳ10%�ı�֤��,��֤�������������21.6%�������û������꾡����Ϣ��鿴������վ �շѹ��� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ʣ�</div>
		<div class="c">
			<input type="text" name="apr" value="{$_A.borrow_result.apr}" /> % <span >�����ȷ��ڻ�����ָ�����߽��ɹ���,ÿ�»�Ϣ������������</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ͷ���</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=lowest_account&nid=borrow_lowest_account&isid=false&value={$_A.borrow_result.lowest_account}"></script> <span >����Ͷ���߶�һ�������Ͷ���ܶ�����ơ�</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ͷ���ܶ</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=most_account&nid=borrow_most_account&isid=false&value={$_A.borrow_result.most_account}"></script> <span >���ô˴ν�����ʵ����������ʽ��ȴﵽ100%��ֱ�ӽ�����վ�ĸ���</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Чʱ�䣺</div>
		<div class="c">
			<script src="/plugins/index.php?q=linkage&name=valid_time&nid=borrow_valid_time&isid=false&value={$_A.borrow_result.valid_time}"></script> <span>���ô˴ν�����ʵ����������ʽ��ȴﵽ100%��ֱ�ӽ�����վ�ĸ��� </span>
		</div>
	</div>
	<div class="module_title"><strong>���ý���</strong></div>
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="0" {if $_A.borrow_result.award==0 || $_A.borrow_result.award==""} checked="checked"{/if}>�����ý���</div>
		<div class="c">
			 <span>����������˽��������ᶳ�����˻�����Ӧ���˻������Ҫ���ý�������ȷ�������˻����㹻 ���˻��� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="1" {if $_A.borrow_result.award==1 } checked="checked"{/if}/>���̶�����̯������</div>
		<div class="c">
			<input type="text" name="part_account" value="{$_A.borrow_result.part_account}" size="5" />Ԫ <span>���ܵ���5Ԫ,���ܸ����ܱ�Ľ���2%�����뱣������Ԫ��Ϊ��λ���������ñ��α��Ҫ����������Ͷ���û����ܽ�  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="2" {if $_A.borrow_result.award==2 } checked="checked"{/if}/>��Ͷ�������������</div>
		<div class="c">
			<input type="text" name="funds" value="{$_A.borrow_result.funds}" size="5" />%  <span>��Χ��0.1%~2% ���������ñ��α��Ҫ����������Ͷ���û��Ľ���������  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="checkbox" name="is_false" value="1" {if $_A.borrow_result.is_false==1 } checked="checked"{/if}/>���ʧ��ʱҲͬ��������</div>
		<div class="c">
			  <span>�������ѡ�˴�ѡ�����δ�������ʧ��ʱͬ���ά����Ͷ���û������û�й�ѡ�����ʧ��ʱ��ѽ������ⶳ���˻���   </span>
		</div>
	</div>
	
	<div class="module_title"><strong>�˻���Ϣ����</strong></div>
	<div class="module_border">
		<div class="w">�����ҵ��˻��ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_account" value="1" {if $_A.borrow_result.open_account==1 } checked="checked"{/if}/> <span> ��������ϴ�ѡ�����ʵʱ�������˻��ģ��˻��ܶ�����������ܶ  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵĽ���ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_borrow" value="1" {if $_A.borrow_result.open_borrow==1 } checked="checked"{/if}/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�����ܶ�ѻ����ܶδ�����ܶ�ٻ��ܶ�����ܶ </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵ�Ͷ���ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_tender" value="1" {if $_A.borrow_result.open_tender==1 } checked="checked"{/if}/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�Ͷ���ܶ���ջ��ܶ���ջ��ܶ  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵ����ö�������</div>
		<div class="c">
			<input type="checkbox" name="open_credit" value="1" {if $_A.borrow_result.open_credit==1 } checked="checked"{/if}/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�������ö�ȡ�������ö�ȡ�  </span>
		</div>
	</div>
	
	<div class="module_title"><strong>��ϸ��Ϣ</strong></div>
	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			<input type="text" name="name" value="{$_A.borrow_result.name}" size="50" /> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ϣ��</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.borrow_result.content"}
		</div>
	</div>
	<!--�������� ����-->
		
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
{elseif $_A.query_type == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>֤���鿴</strong></div>


	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrow_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����;��</div>
		<div class="c">
			{$_A.borrow_result.use|linkage}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ޣ�</div>
		<div class="c">
		{$_A.borrow_result.time_limit|linkage:"borrow_time_limit"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			{$_A.borrow_result.style|linkage}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ܽ�</div>
		<div class="c">
				{$_A.borrow_result.account} Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ʣ�</div>
		<div class="c">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ͷ���</div>
		<div class="c">
			{$_A.borrow_result.lowest_account|linkage:"borrow_lowest_account"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ͷ���ܶ</div>
		<div class="c">
			{$_A.borrow_result.most_account|linkage:"borrow_most_account"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Чʱ�䣺</div>
		<div class="c">
			{$_A.borrow_result.valid_time|linkage:"borrow_valid_time"}
		</div>
	</div>
	<div class="module_title"><strong>���ý���</strong></div>
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="0" {if $_A.borrow_result.award==0 || $_A.borrow_result.award==""} checked="checked"{/if} disabled="disabled">�����ý���</div>
		<div class="c">
			 <span>����������˽��������ᶳ�����˻�����Ӧ���˻������Ҫ���ý�������ȷ�������˻����㹻 ���˻��� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="1" {if $_A.borrow_result.award==1 } checked="checked"{/if} disabled="disabled"/>���̶�����̯������</div>
		<div class="c">
			<input type="text" name="part_account" value="{$_A.borrow_result.part_account}" size="5" disabled="disabled"/>Ԫ <span>���ܵ���5Ԫ,���ܸ����ܱ�Ľ���2%�����뱣������Ԫ��Ϊ��λ���������ñ��α��Ҫ����������Ͷ���û����ܽ�  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="2" {if $_A.borrow_result.award==2 } checked="checked"{/if} disabled="disabled"/>��Ͷ�������������</div>
		<div class="c">
			<input type="text" name="funds" value="{$_A.borrow_result.funds}" size="5" disabled="disabled"/>%  <span>��Χ��0.1%~2% ���������ñ��α��Ҫ����������Ͷ���û��Ľ���������  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="checkbox" name="is_false" value="1" {if $_A.borrow_result.is_false==1 } checked="checked"{/if}  disabled="disabled"/>���ʧ��ʱҲͬ��������</div>
		<div class="c">
			  <span>�������ѡ�˴�ѡ�����δ�������ʧ��ʱͬ���ά����Ͷ���û������û�й�ѡ�����ʧ��ʱ��ѽ������ⶳ���˻���   </span>
		</div>
	</div>
	
	<div class="module_title"><strong>�˻���Ϣ����</strong></div>
	<div class="module_border">
		<div class="w">�����ҵ��˻��ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_account" value="1" {if $_A.borrow_result.open_account==1 } checked="checked"{/if} disabled="disabled"/> <span> ��������ϴ�ѡ�����ʵʱ�������˻��ģ��˻��ܶ�����������ܶ  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵĽ���ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_borrow" value="1" {if $_A.borrow_result.open_borrow==1 } checked="checked"{/if} disabled="disabled"/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�����ܶ�ѻ����ܶδ�����ܶ�ٻ��ܶ�����ܶ </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵ�Ͷ���ʽ������</div>
		<div class="c">
			<input type="checkbox" name="open_tender" value="1" {if $_A.borrow_result.open_tender==1 } checked="checked"{/if} disabled="disabled"/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�Ͷ���ܶ���ջ��ܶ���ջ��ܶ  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">�����ҵ����ö�������</div>
		<div class="c">
			<input type="checkbox" name="open_credit" value="1" {if $_A.borrow_result.open_credit==1 } checked="checked"{/if} disabled="disabled"/> <span>��������ϴ�ѡ�����ʵʱ�������˻��ģ�������ö�ȡ�������ö�ȡ�  </span>
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.attestation_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.attestation_result.addip}</div>
	</div>
	
	
	<div class="module_title"><strong>��˴˽��</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="0" {if $_A.attestation_result.status==0} checked="checked"{/if} />�ȴ����  <input type="radio" name="status" value="1" {if $_A.attestation_result.status==1} checked="checked"{/if}/>���ͨ�� <input type="radio" name="status" value="2" {if $_A.attestation_result.status==2} checked="checked"{/if}/>��˲�ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">ͨ����Ӧ�Ļ���:</div>
		<div class="c">
			<input type="text" name="jifen" value="{ $_A.attestation_result.jifen}" size="5">
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.attestation_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.attestation_result.id }" />
		
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
			<td width="" class="main_td">������</td>
			<td width="" class="main_td">�����</td>
			<td width="" class="main_td">�ͷ���Ա</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center" >{ $item.id}</td>
			<td class="main_td1" align="center"><a href="{$_A.query_url}&username={$item.username}">{$item.username}</a></td>
			<td class="main_td1" align="center" >{$item.name}</td>
			<td class="main_td1" align="center" >{$item.account}</td>
			<td class="main_td1" align="center" >{$item.kefu_username}</td>
			<td class="main_td1" align="center" >{ if $item.status ==1}���ͨ��{ elseif $item.status ==0}�ȴ����{else}���δͨ��{/if}</td>
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/view{$site_url}&user_id={$item.user_id}&id={$item.id}">���</a> <a href="{$_A.query_url}/edit{$site_url}&user_id={$item.user_id}&id={$item.id}">�޸�</a></td>
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


{/if}