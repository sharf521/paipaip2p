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
		{linkages nid="borrow_use" value="$_A.borrow_result.use" name="use" default="asd" }
			 <span >˵�����ɹ���ľ�����;��</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ޣ�</div>
		<div class="c">
			{linkages nid="borrow_time_limit" value="$_A.borrow_result.time_limit" name="time_limit" type="value" }<span >���ɹ���,�����Լ����µ�ʱ���������� </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			{linkages nid="borrow_style" value="$_A.borrow_result.style" name="style" type="value" }
		<span >�����ȷ��ڻ�����ָ�����߽��ɹ���,ÿ�»�Ϣ������������</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ܽ�</div>
		<div class="c"><input type="text" name="account" value="{$_A.borrow_result.account}"  size="10"/>
<span >�����Ӧ��500Ԫ��50,000Ԫ֮�䡣���ױ��־�Ϊ����ҡ�</span>
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
			{linkages nid="borrow_lowest_account" value="$_A.borrow_result.lowest_account" name="lowest_account" type="value" }
		<span >����Ͷ���߶�һ�������Ͷ���ܶ�����ơ�</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���Ͷ���ܶ</div>
		<div class="c">
			{linkages nid="borrow_most_account" value="$_A.borrow_result.most_account" name="most_account" type="value" }
			<span >���ô˴ν�����ʵ����������ʽ��ȴﵽ100%��ֱ�ӽ�����վ�ĸ���</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Чʱ�䣺</div>
		<div class="c">
			{linkages nid="borrow_valid_time" value="$_A.borrow_result.valid_time" name="valid_time" type="value" }
			 <span>���ô˴ν�����ʵ����������ʽ��ȴﵽ100%��ֱ�ӽ�����վ�ĸ��� </span>
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

	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>��������</strong></div>
	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">ָ�������ˣ�</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
	
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
		<input type="hidden" name="status" value="{ $_A.borrow_result.status }" />
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
	<div class="module_title"><strong>��˽���</strong></div>


	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
		<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.user_result.username|default:$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">�����վ��</div>
		<div class="c">
			{$_A.borrow_result.sitename}
		</div>
	</div>
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{if $_A.borrow_result.status==0}����������{elseif $_A.borrow_result.status==1}����ļ��{elseif $_A.borrow_result.status==2}���ʧ��{elseif $_A.borrow_result.status==3}������{elseif $_A.borrow_result.status==4}�������ʧ��{elseif $_A.borrow_result.status==5}����{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����;��</div>
		<div class="c">
			{$_A.borrow_result.use|linkage:"borrow_use"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������ޣ�</div>
		<div class="c">
		{ if $_A.borrow_result.isday ==1}{$_A.borrow_result.time_limit_day}��{ else}{$_A.borrow_result.time_limit}����{/if}
		</div>
	</div>

	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			{if $_A.borrow_result.isday==1 } 
                ����ȫ���
                {else}
                {$_A.borrow_result.style|linkage:"borrow_style"}
                {/if}
		</div>
	</div>
	{/if}
	<div class="module_border">
		<div class="l">����ܽ�</div>
		<div class="c">
				{$_A.borrow_result.account}<input type="hidden" name="account" value="{$_A.borrow_result.account}" /> Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ʣ�</div>
		<div class="c">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	{if $_A.borrow_result.biao_type!='circulation'}
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
	{/if}
	{if $_A.borrow_result.status==1}
	<div class="module_border">
		<div class="l">���ʱ�䣺</div>
		<div class="c">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i"}
		</div>
	</div>
	<div class="module_border">
		<div class="l">����ˣ�</div>
		<div class="c">
			{$_A.borrow_result.verify_username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">��˱�ע��</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	
	{/if}
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">��Чʱ�䣺</div>
		<div class="c">
			{$_A.borrow_result.valid_time|linkage:"borrow_valid_time"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.biao_type=='circulation'}
	<!-- liukun add for bug 115 begin -->
	<div class="module_title"><strong>��ת����</strong></div>
	<div class="module_border">
		<div class="l">ÿ�������·�ʱ�䣺</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_month_num}����
		</div>
		
		<div class="l">ÿ�����������ʣ�</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_apr}%
		</div>
		
		<div class="l">����Ϲ����ޣ�</div>
		<div class="c">
			{$_A.borrow_additional_info.begin_month_num}����
		</div>
		
		<div class="l">ÿ�ݼ۸�</div>
		<div class="c">
			{$_A.borrow_additional_info.unit_price}Ԫ
		</div>
		
		<div class="l">��С�Ϲ�������</div>
		<div class="c">
			{$_A.borrow_additional_info.min_unit_num}
		</div>
		
		<div class="l">����Ϲ�������</div>
		<div class="c">
			{$_A.borrow_additional_info.max_unit_num}
		</div>								
		
	</div>
	<!-- liukun add for bug 115 end -->
	{/if}
	{if $_A.blacklist_info.user_id != ""}
	<div class="module_title"><strong>��ƽ̨��������Ϣ</strong></div>
	<div class="module_border">
		<div class="l">���ڽ�</div>
		<div class="c">
		{$_A.blacklist_info.late_amount}Ԫ
		</div>
		<div class="l">���ڱ�����</div>
		<div class="c">
		{$_A.blacklist_info.late_num}
		</div>
		<div class="l">�������������</div>
		<div class="c">
		{$_A.blacklist_info.late_day_num}
		</div>
		<div class="l">��վ������</div>
		<div class="c">
		{$_A.blacklist_info.advance_amount}Ԫ
		</div>
		<div class="l">��վ����������</div>
		<div class="c">
		{$_A.blacklist_info.advance_num}
		</div>
	</div>
	<div class="module_title"><strong>����ƽ̨��������Ϣ</strong></div>
	<div class="module_border">
		<div class="l">���ڽ�</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_amount}Ԫ
		</div>
		<div class="l">���ڱ�����</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_num}
		</div>
		<div class="l">�������������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_day_num}
		</div>
		<div class="l">��վ������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_amount}Ԫ
		</div>
		<div class="l">��վ����������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_num}
		</div>
	</div>	
	{/if}
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
	
	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>��������</strong></div>
	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">ָ�������ˣ�</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
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
			{ $_A.borrow_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.borrow_result.addip}</div>
	</div>
	<div class="module_title"><strong>��վ���</strong></div>
	
	
	<div class="module_border" >
		<div class="l">������:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="45" rows="5">{ $_A.borrow_result.subsite_remark}</textarea>
		</div>
	</div>	
	{ if $_A.borrow_result.status!=1}
	<div class="module_title"><strong>��˴˽��</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="1"/>���ͨ�� <input type="radio" name="status" value="2"  checked="checked"/>��˲�ͨ�� </div>
		
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.borrow_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.borrow_result.user_id }" />
		<input type="hidden" name="name" value="{ $_A.borrow_result.name }" />
		
		<input type="submit"  name="reset" value="��˴˽���" />
	</div>
	{/if}
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
{elseif $_A.query_type == "subremark"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>��˽���</strong></div>


	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
		<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.user_result.username|default:$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">״̬��</div>
		<div class="c">
			{if $_A.borrow_result.status==0}����������{elseif $_A.borrow_result.status==1}����ļ��{elseif $_A.borrow_result.status==2}���ʧ��{elseif $_A.borrow_result.status==3}������{elseif $_A.borrow_result.status==4}�������ʧ��{elseif $_A.borrow_result.status==5}����{/if}
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
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">���ʽ��</div>
		<div class="c">
			{if $_A.borrow_result.isday==1 } 
                ����ȫ���
                {else}
                {$_A.borrow_result.style|linkage:"borrow_style"}
                {/if}
		</div>
	</div>
	{/if}
	<div class="module_border">
		<div class="l">����ܽ�</div>
		<div class="c">
				{$_A.borrow_result.account}<input type="hidden" name="account" value="{$_A.borrow_result.account}" /> Ԫ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ʣ�</div>
		<div class="c">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	{if $_A.borrow_result.biao_type!='circulation'}
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
	{/if}
	{if $_A.borrow_result.status==1}
	<div class="module_border">
		<div class="l">���ʱ�䣺</div>
		<div class="c">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i"}
		</div>
	</div>
	<div class="module_border">
		<div class="l">����ˣ�</div>
		<div class="c">
			{$_A.borrow_result.verify_username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">��˱�ע��</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	
	{/if}
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">��Чʱ�䣺</div>
		<div class="c">
			{$_A.borrow_result.valid_time|linkage:"borrow_valid_time"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.biao_type=='circulation'}
	<!-- liukun add for bug 115 begin -->
	<div class="module_title"><strong>��ת����</strong></div>
	<div class="module_border">
		<div class="l">ÿ�������·�ʱ�䣺</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_month_num}����
		</div>
		
		<div class="l">ÿ�����������ʣ�</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_apr}%
		</div>
		
		<div class="l">����Ϲ����ޣ�</div>
		<div class="c">
			{$_A.borrow_additional_info.begin_month_num}����
		</div>
		
		<div class="l">ÿ�ݼ۸�</div>
		<div class="c">
			{$_A.borrow_additional_info.unit_price}Ԫ
		</div>
		
		<div class="l">��С�Ϲ�������</div>
		<div class="c">
			{$_A.borrow_additional_info.min_unit_num}
		</div>
		
		<div class="l">����Ϲ�������</div>
		<div class="c">
			{$_A.borrow_additional_info.max_unit_num}
		</div>								
		
	</div>
	<!-- liukun add for bug 115 end -->
	{/if}
	{if $_A.blacklist_info.user_id != ""}
	<div class="module_title"><strong>��ƽ̨��������Ϣ</strong></div>
	<div class="module_border">
		<div class="l">���ڽ�</div>
		<div class="c">
		{$_A.blacklist_info.late_amount}Ԫ
		</div>
		<div class="l">���ڱ�����</div>
		<div class="c">
		{$_A.blacklist_info.late_num}
		</div>
		<div class="l">�������������</div>
		<div class="c">
		{$_A.blacklist_info.late_day_num}
		</div>
		<div class="l">��վ������</div>
		<div class="c">
		{$_A.blacklist_info.advance_amount}Ԫ
		</div>
		<div class="l">��վ����������</div>
		<div class="c">
		{$_A.blacklist_info.advance_num}
		</div>
	</div>
	<div class="module_title"><strong>����ƽ̨��������Ϣ</strong></div>
	<div class="module_border">
		<div class="l">���ڽ�</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_amount}Ԫ
		</div>
		<div class="l">���ڱ�����</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_num}
		</div>
		<div class="l">�������������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_day_num}
		</div>
		<div class="l">��վ������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_amount}Ԫ
		</div>
		<div class="l">��վ����������</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_num}
		</div>
	</div>	
	{/if}	
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
	
	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>��������</strong></div>
	<div class="module_border">
		<div class="l">����������</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">ָ�������ˣ�</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
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
			{ $_A.borrow_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.borrow_result.addip}</div>
	</div>
	
	{ if $_A.borrow_result.status!=1}
	<div class="module_title"><strong>��վ���</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="subsite_status" value="1"/>���ͨ�� <input type="radio" name="subsite_status" value="2"  checked="checked"/>��˲�ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">������:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="45" rows="5">{ $_A.borrow_result.subsite_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.borrow_result.user_id }" />
		<input type="hidden" name="name" value="{ $_A.borrow_result.name }" />
		
		<input type="submit"  name="reset" value="�ύ������" />
	</div>
	{/if}
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
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="*" class="main_td">�û�����</td>
			<td width="*" class="main_td">�����վ</td>
			<td width="" class="main_td">������</td>
			<td width="" class="main_td">�����</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�������</td>
			<td width="" class="main_td">����ʱ��</td>
			<td width="" class="main_td">Ͷ�����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">״̬</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}<input type="hidden" name="id[]" value="{ $item.id}" /></td>
			<td class="main_td1" align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}��</td>
			<td align="left">{$item.sitename}</td>
			<td title="{$item.name}" align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a>
</td>
			<td align="left">{$item.account}Ԫ</td>
			<td align="left">{$item.apr}%</td>
			<td align="left">{ if $item.isday ==1}{$item.time_limit_day}��{ else}{$item.time_limit}����{/if}</td>
			<td align="left">{$item.addtime|date_format}</td>
			<td align="left" ><div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>{$item.scale}%</td>
			<td align="left"><div class="rate_tiao" style=" width:{$item.vouch_scale|default:0}px"></div>{$item.vouch_scale}%</td>
			<td align="left">{ if $item.status ==1}���ͨ��{ elseif $item.status ==0}�ȴ����{ elseif $item.status ==-1}<font color="#999999">��δ����</font>{ elseif $item.status ==3}����ɹ�����{ elseif $item.status ==4}����δ����{else}���δͨ��{/if} | {if $item.subsite_status==0}��վδ���{elseif $item.subsite_status==1}��վ���ͨ��{else}<font color="#999999">��վ��˲�ͨ��</font>{/if}</td>
			<td align="left">{ if $item.status ==0 }{if $_A.areaid == 0}<a href="{$_A.query_url}/view{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">���</a>{/if}{/if} { if $item.status == 1 && $item.isontop == 1 }<a href="{$_A.query_url}/ontop{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">�ö�</a>{/if} {if $_A.areaid != 0 && $item.subsite_status == 0 && $item.status ==0}<a href="{$_A.query_url}/subremark{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">������</a>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="14" class="action">
		<!--
		<div class="floatl">
			<input type="submit" value="ȷ���ύ" />
		</div>
		-->
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> 
			{linkages nid="select_biao_type" value="" name="biao_type" type="value" } 
			<input type="button" value="����" / onclick="sousuo('{$_A.query_url}{$_A.site_url}')">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="14" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>

{elseif $_A.query_type=="full"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="*" class="main_td" align="left">���û���</td>
			<td width="*" class="main_td" align="left">�����վ</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">�����</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">Ͷ�����</td>
			<td width="" class="main_td" align="left">�������</td>
			<td width="" class="main_td" align="left">״̬</td>
			<td width="" class="main_td" align="left">����</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">���ʱ��</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td align="left">{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}</td>
			<td align="left">{$item.sitename}</td>
			<!--<td title="{$item.name}">{$item.name|truncate:10}</td>-->
            <td title="{$item.name}" align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a>
			
			</td>
			<td align="left">{$item.account}Ԫ</td>
			<td align="left">{$item.apr}%</td>
			<td align="left">{$item.tender_times|default:0}</td>
			<td align="left">{if $item.isday==1 } 
                {$item.time_limit_day}��
                {else}
                {$item.time_limit}����
                {/if}</td>
			<td align="left">{if $item.status==3}������ɹ�{elseif $item.status==4}�����ʧ��{else}���������{/if}</td>
			<td align="left">{if $_A.areaid==0}{if $item.status!=3}<a href="{$_A.query_url}/full_view{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">���</a>{/if}{/if}</td>
			<td align="left">{$item.addtime|date_format}</td>
			<td align="left">{$item.verify_time|date_format}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="12" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/>
			�����ͣ�{linkages nid="select_biao_type" value="" name="biao_type" type="value" }
			<!--
			ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>
			-->
			״̬<select id="status" ><option value="">ȫ��</option><option value="3" {if $magic.request.status==3} selected="selected"{/if}>���긴��ͨ��</option><option value="4" {if $magic.request.status=="4"} selected="selected"{/if}>���긴��ʧ��</option></select> 
			<input type="button" value="����" / onclick="sousuoFull('{$_A.query_url}/full{$_A.site_url}')">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="12" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
{elseif $_A.query_type == "full_view" }
<div class="module_add">
	<div class="module_title"><strong>������������</strong></div>
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">�����վ��</div>
		<div class="c">
			{$_A.borrow_result.sitename}
		</div>
	</div>	
	<div class="module_border">
		<div class="l">���⣺</div>
		<div class="c">
			{$_A.borrow_result.name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����</div>
		<div class="h">
			��{$_A.borrow_result.account}
		</div>
		<div class="l">�����ʣ�</div>
		<div class="h">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	<div class="module_border">
		<div class="l">������ޣ�</div>
		<div class="h">
			{if $_A.borrow_result.isday==1 } 
                {$_A.borrow_result.time_limit_day}��
                {else}
                {$_A.borrow_result.time_limit}����
                {/if}
		</div>
		<div class="l">�����;��</div>
		<div class="h">
			{$_A.borrow_result.use|linkage}
		</div>
	</div>
	<div class="module_border">
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">

		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="*" class="main_td" align="left">���û���</td>
			<td width="" class="main_td" align="left">Ͷ�ʽ��</td>
			<td width="" class="main_td" align="left">��Ч���</td>
			<td width="" class="main_td" align="left">״̬</td>
			<td width="" class="main_td" align="left">Ͷ��ʱ��</td>
		</tr>
		{ foreach  from=$_A.borrow_tender_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}��</td>
			<td align="left">{$item.money}Ԫ</td>
			<td align="left"><font color="#FF0000">{$item.tender_account}Ԫ</font></td>
			<td align="left">{if $item.money == $item.tender_account}ȫ��ͨ��{else}����ͨ��{/if}</td>
			<td align="left">{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		</tr>
		{ /foreach}
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
</table>

	</div>
	
	<!-- liukun add for bug 55 begin -->
	<div class="module_border">
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">

		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="" class="main_td" align="left">�������</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">״̬</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
		</tr>
		{ foreach  from=$_A.borrow_vouch_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.account}Ԫ</td>
			<td align="left"><font color="#FF0000">{$item.vouch_collection}Ԫ</font></td>
			<td align="left">{if $item.vouch_account == $item.account}ȫ��ͨ��{else}����ͨ��{/if}</td>
			<td align="left">{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
		</tr>
		{ /foreach}
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</table>

	</div>
	<!-- liukun add for bug 55 end -->
	
	
	<div class="module_border">
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�ƻ�������</td>
			<td width="*" class="main_td" align="left">Ԥ�����</td>
			<td width="" class="main_td" align="left">����</td>
			<td width="" class="main_td" align="left">��Ϣ</td>
		</tr>
		{ foreach  from=$_A.borrow_repayment key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $key+1}</td>
			<td  align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td align="left">��{$item.repayment_account}</td>
			<td align="left">��{$item.capital}</td>
			<td align="left">��{$item.interest}Ԫ</td>
		</tr>
		{ /foreach}
</table>

	</div>
	<div class="module_title"><strong>������</strong></div>
	<div class="module_border">
		<div class="l">��վ��������</div>
		<div class="c">
			{$_A.borrow_result.subsite_remark}
		</div>
	</div>
	<div class="module_border">
		<div class="l">���������</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	{ if $_A.borrow_result.status==1}
	<div class="module_title"><strong>��˴˽��</strong></div>
	<form name="form1" method="post" action="" >
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="3"/>����ͨ�� <input type="radio" name="status" value="4"  checked="checked"/>����ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="repayment_remark" cols="45" rows="5">{ $_A.borrow_result.repayment_remark}</textarea>
		</div>
	</div>
	<div class="module_border" >
		<div class="l">��֤��:</div>
		<div class="c">
			<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		
		<input type="submit"  name="reset" value="��˴˽���" />
	</div>
	
</form>
	{/if}
	<div class="module_title"><strong>������ϸ����</strong></div>
	<div class="module_border">
		<div class="l">Ͷ�꽱����</div>
		<div class="h">
        
        {if $_A.borrow_result.award==0}
			û�н���<br />
		{elseif  $_A.borrow_result.award==1}
			������{$_A.borrow_result.part_account}Ԫ	
		{elseif  $_A.borrow_result.award==2}
			����������{$_A.borrow_result.funds}%		
		{/if}
		</div>
		<div class="l">Ͷ��ʧ���Ƿ�����</div>
		<div class="h">
			{if $_A.borrow_result.is_false==0}��{else}��{/if}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_result.addtime|date_format:"Y-m-d H:i:s"}
		</div>
		<div class="l">�б�ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i:s"}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="hb">
			<table width="100%"><tr><td align="left">{$_A.borrow_result.content}</td></tr></table>
		</div>
	</div>
	
</div>
<!---�ѻ���--->
{elseif $_A.query_type=="repayment"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�����</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">����</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">״̬</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left">{$item.username}</td>
			<td title="{$item.borrow_name}" align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
			<td align="left">{$item.order+1 }/{$item.time_limit }</td>
			<td align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td align="left">{$item.repayment_account  }Ԫ</td>
			<td align="left">{$item.repayment_yestime|date_format:"Y-m-d"|default:-}</td>
			<td align="left">{if $item.status==1}<font color="#006600">�ѻ�</font>{else}<font color="#FF0000">δ��</font>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/>�ؼ��֣�
			<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/><select id="status" >
			<option value="">����</option>
			<option value="1" {if $magic.request.status==1} selected="selected"{/if}>�ѻ�</option>
			<option value="0" {if $magic.request.status==0} selected="selected"{/if}>δ��</option>
			</select><input type="button" value="����" / onclick="sousuo('{$_A.query_url}/repayment{$_A.site_url}')">
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


<!---����--->
{elseif $_A.query_type=="liubiao"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�����</td>
			<td width="*" class="main_td" align="left">�����վ</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">�������</td>
			<td width="" class="main_td" align="left">�����</td>
			<td width="" class="main_td" align="left">��Ͷ���</td>
			<td width="" class="main_td" align="left">��ʼʱ��</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">״̬</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left">{$item.username}</td>
			<td class="main_td1"  align="left">{$item.sitename}</td>
			<td title="{$item.borrow_name}" align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a></td>
			<td align="left">{$item.time_limit }����</td>
			<td align="left">{$item.account }Ԫ</td>
			<td align="left">{$item.account_yes }Ԫ</td>
			<td align="left">{$item.verify_time|date_format:"Y-m-d"}</td>
			<td align="left">{$item.verify_time+$item.valid_time*24*60*60|date_format:"Y-m-d"}</td>
			<td align="left"><a href="{$_A.query_url}/liubiao_edit&id={$item.id}{$_A.site_url}">�޸�</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/>�ؼ��֣�<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/><select id="status" >
			<option value="">����</option>
			<option value="1" {if $magic.request.status==1} selected="selected"{/if}>�ѻ�</option>
			<option value="0" {if $magic.request.status==0} selected="selected"{/if}>δ��</option>
			</select><input type="button" value="����" / onclick="sousuo('{$_A.query_url}/repayment{$_A.site_url}')">
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


<!--������ ��ʼ-->
{elseif $_A.query_type=="liubiao_edit"}
<div class="module_title"><strong>�������</strong></div>
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="h">
			{$_A.borrow_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">���⣺</div>
		<div >
			<a href="/invest/a{$_A.borrow_result.id}.html" target="_blank">{$_A.borrow_result.name}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">����ȣ�</div>
		<div class="h">
			{$_A.borrow_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�ѽ��ȣ�</div>
		<div class="h">
			{$_A.borrow_result.account_yes}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_result.verify_time|date_format}
		</div>
	</div>
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_result.verify_time+$_A.borrow_result.valid_time*24*60*60|date_format}
		</div>
	</div>
	<div class="module_title"><strong>���</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">���״̬��</div>
		<div >
			<input type="radio" name="status" value="1" />���귵�ؽ��<input type="radio" name="status" value="2" checked="checked" />�ӳ��������
		</div>
	</div>
	<div class="module_border">
		<div class="l">�ӳ�������</div>
		<div >
			<input type="text" name="days" value="{$_A.borrow_amount_result.account}" size="5" value="0" />��
		</div>
	</div>
	
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="ȷ�����" />
		</div>
	</div>
	</form>

<!--��ȹ��� ��ʼ-->
{elseif $_A.query_type=="amount"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�û�����</td>
			<td width="" class="main_td" align="left">��������</td>
			<td width="" class="main_td" align="left">ԭ�����</td>
			<td width="" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">�¶��</td>
			<td width="" class="main_td" align="left">����ʱ��</td>
			<td width="" class="main_td" align="left">����</td>
			<td width="" class="main_td" align="left">��ע</td>
			<td width="" class="main_td" align="left">״̬</td>
			<td width="" class="main_td" align="left">����</td>
		</tr>
		{ foreach  from=$_A.borrow_amount_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td width="80" align="left">
				{if $item.type =="tender_vouch"}<a href="{$_A.query_url}/amount&type=tender_vouch">Ͷ�ʵ������</a>
				{elseif $item.type =="borrow_vouch"}<a href="{$_A.query_url}/amount&type=borrow_vouch">�������</a>
				<!-- liukun add for bug 48 begin -->
				{elseif $item.type =="restructuring"}<a href="{$_A.query_url}/amount&type=restructuring">ծ��������</a>
				<!-- liukun add for bug 48 end -->
				{else}<a href="{$_A.query_url}/amount&type=credit">������ö��</a>{/if}
			</td>
			<td width="70" align="left">{$item.account_old}Ԫ</td>
			<td width="70"  align="left">{$item.account}Ԫ</td>
			<td  align="left">{$item.account_new}Ԫ</td>
			<td  align="left">{ $item.addtime|date_format}</td>
			<td  align="left">{ $item.content}</td>
			<td  align="left">{ $item.remark}</td>
			<td  width="50" align="left">{if $item.status==2}<font color="#6699CC">�����</font>{elseif  $item.status==1} �ɹ� {else}<font color="#FF0000">ʧ��</font>{/if}</td>
			<td  width="70" align="left">{if $item.status==2}<a href="{$_A.query_url}/amount_view{$_A.site_url}&id={$item.id}">���</a> |<a href="{$_A.query_url}/amount_subsite{$_A.site_url}&id={$item.id}">��վ���{/if} </td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo('{$_A.query_url}/amount{$_A.site_url}')">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--��ȹ��� ����-->


<!--���� ��ʼ-->
{elseif $_A.query_type=="lateFast"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">�����</td>
			<td width="*" class="main_td" align="left">������</td>
			<td width="" class="main_td" align="left">����</td>
			<td width="" class="main_td" align="left">Ӧ��ʱ��</td>
			<td width="" class="main_td" align="left">Ӧ�����</td>
			<td width="" class="main_td" align="left">����</td>
		</tr>
		{ foreach  from=$_A.borrow_repayment_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td  align="left">{ $item.username}</td>
			
			<td align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name}</a></td>
			
			<td align="left">{$item.order+1 }/{$item.time_limit}</td>
			<td  align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td  align="left">{$item.repayment_account }Ԫ</td>
			<td  align="left">{if $item.status==2}<font color="#FF0000">�Ѵ���</font>{else}{if $item.late_days>0}<a href="{$_A.query_url}/late_repay{$_A.site_url}&id={$item.id}">����</a>{else}-{/if}{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ������꣺<select name="isday" ><option value="2">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>���</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>�±�</option></select> <input type="submit" value="����" >
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<!--���� ����-->

<!--��Ѻ�굽�� ��ʼ-->
{elseif $_A.query_type=="late"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">�����</td>
			<td width="*" class="main_td">������</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">Ӧ��ʱ��</td>
			<td width="" class="main_td">Ӧ�����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">����</td>
			<td width="" class="main_td">�������ѵ渶��</td>
			<td width="" class="main_td">����</td>
		</tr>
                <?php  $showtime=date("y-m-d");?>
		{ foreach  from=$_A.borrow_repayment_list key=key item=item}

		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1" align="center"><a href="javascript:void(0)" onclick='tipsWindown("�û���ϸ��Ϣ�鿴","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">���Ӽ���</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">�����ñ꡿</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">��ծ������꡿</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">�������꡿</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">����ֵ�꡿</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">����꡿</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">����Ѻ�꡿</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">�����ı꡿</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">����ת�꡿</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name}</a></td>
			<td>{$item.order+1 }/{$item.time_limit}</td>
			<td >{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td >{$item.repayment_account|default:0}Ԫ</td>
			<td >{$item.late_days|default:0}��</td>
			<td >{$item.late_interest|default:0}</td>
			<td >{if $item.biao_type == 'vouch' || $item.biao_type == 'restructuring'}{$item.vouch_advance|default:0}{else}-{/if}</td>
			<td >{if $item.status==2}<font color="#FF0000">�Ѵ���</font>{else}{if $item.late_days>=0}<a href="{$_A.query_url}/late_repay{$_A.site_url}&id={$item.id}" onclick="return confirm('ȷ��Ҫ�渶��')">����</a>{else}-{/if}{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">

		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ������꣺<select name="isday" ><option value="2">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>���</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>�±�</option></select> <input type="submit" value="����" >
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="11" class="page">
			{$_A.showpage}
			</td>
		</tr>
	</form>
</table>
<!--��Ѻ�굽�� ����-->

<!--������ ��ʼ-->
{elseif $_A.query_type=="amount_view"}
<div class="module_title"><strong>������</strong></div>
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="h">
			{$_A.borrow_amount_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">������ͣ�</div>
		<div class="h">
			{if $_A.borrow_amount_result.type=="tender_vouch"}<font color="#FF0000">Ͷ�ʵ������</font>{elseif $_A.borrow_amount_result.type=="borrow_vouch"}<font color="#FF0000">�������</font>{elseif $_A.borrow_amount_result.type=="restructuring"}<font color="#FF0000">ծ��������</font>{else}<font color="#FF0000">���ö��</font>{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">ԭ����ȣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.account_old|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�����ȣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="h">
			{$_A.borrow_amount_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_amount_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>��վ���</strong></div>
	<div class="module_border">
		<div class="l">��վ��������</div>
		<div class="h">
			{$_A.borrow_amount_result.subsite_remark}
		</div>
	</div>
	<div class="module_title"><strong>���</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">���״̬��</div>
		<div class="h">
			<input type="radio" name="status" value="1" />ͨ��  <input type="radio" name="status" value="0" checked="checked" />��ͨ��
		</div>
	</div>
	<div class="module_border">
		<div class="l">ͨ����ȣ�</div>
		<div class="h">
			<input type="text" name="account" value="{$_A.borrow_amount_result.account}" />
			<input type="hidden" name="type" value="{ $_A.borrow_amount_result.type}" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">��˱�ע��</div>
		<div class="h">
			<textarea name="verify_remark" rows="5" cols="40" ></textarea>
		</div>
	</div>
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="ȷ�����" />
		</div>
	</div>
	</form>

{elseif $_A.query_type=="amount_subsite"}
<div class="module_title"><strong>������</strong></div>
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="h">
			{$_A.borrow_amount_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">������ͣ�</div>
		<div class="h">
			{if $_A.borrow_amount_result.type=="tender_vouch"}<font color="#FF0000">Ͷ�ʵ������</font>{elseif $_A.borrow_amount_result.type=="borrow_vouch"}<font color="#FF0000">�������</font>{else}���ö��{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">ԭ����ȣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.account_old|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">�����ȣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="h">
			{$_A.borrow_amount_result.content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ע��</div>
		<div class="h">
			{$_A.borrow_amount_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ʱ�䣺</div>
		<div class="h">
			{$_A.borrow_amount_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>���</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">��վ��������</div>
		<div class="h">
			<textarea name="subsite_remark" rows="5" cols="40" >{$_A.borrow_amount_result.subsite_remark}</textarea>
		</div>
	</div>
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="�ύ" />
		</div>
	</div>
	</form>

<!--ͳ�� ��ʼ-->
{elseif $_A.query_type=="tongji"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="*" class="main_td">����</td>
			<td width="*" class="main_td">�ܶ�</td>
		</tr>
		<tr  class="tr2">
			<td >�ɹ�����ܶ�</td>
			<td >��{$_A.borrow_tongji.success_num}</td>
		</tr>
		<tr  >
			<td >�������ܶ�</td>
			<td >��{$_A.borrow_tongji.success_num1}</td>
		</tr>
		<tr  class="tr2">
			<td >δ�����ܶ�</td>
			<td >��{$_A.borrow_tongji.success_num0}</td>
		</tr>
		<tr  >
			<td >�����ܶ�</td>
			<td >{$_A.borrow_tongji.laterepay}</td>
		</tr>
		<tr  class="tr2">
			<td >���ڼ������ܶ�</td>
			<td >��{$_A.borrow_tongji.success_laterepay}</td>
		</tr>
		<tr >
			<td >����δ�����ܶ�</td>
			<td >��{$_A.borrow_tongji.false_laterepay}</td>
			
		</tr>
		
	</form>	
</table>
<!--ͳ�� ����-->

<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
	  {foreach from="$_A.account_tongji" key=key  item="item"}
		<tr >
			<td width="*" class="main_td">��������</td>
			<td width="*" class="main_td">{$key}</td>
			<td width="" class="main_td">���</td>
		</tr>
		{foreach from="$item" key="_key" item="_item"}
		<tr  class="tr2">
			<td >{$_item.type_name}</td>
			<td >{$_item.type}</td>
			<td >��{$_item.num}</td>
		</tr>
		{/foreach}
	{/foreach}
	</form>	
</table>
<!--ͳ�� ����-->
{/if}


<script>

var urls = '{$_A.query_url}';
{literal}
function sousuo(url){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	/*
	var keywords = $("#keywords").val();
	if (keywords!=""){
		sou += "&keywords="+keywords;
	}
	*/
	var biao_type = $("#biao_type").val();
	if (biao_type!=""){
		sou += "&biao_type="+biao_type;
	}
	var status = $("#status").val();
	sou += "&status="+status;
	/*
	if (status!=""){
		sou += "&status="+status;
	}
	*/
	/*
	var is_vouch = $("#is_vouch").val();
	if (is_vouch!=""){
		sou += "&is_vouch="+is_vouch;
	}
	*/
	if (sou!=""){
		
		location.href=url+sou;
	}
}

function sousuoFull(url){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	/*
	var biaoType = $("#biaoType").val();
	if (biaoType!=""){
		sou += "&biaoType="+biaoType;
	}
	*/
	var biao_type = $("#biao_type").val();
	if (biao_type!=""){
		sou += "&biao_type="+biao_type;
	}
	/*
	var is_vouch = $("#is_vouch").val();
	if (is_vouch!=""){
		sou += "&is_vouch="+is_vouch;
	}
	*/
	var status = $("#status").val();
	sou += "&status="+status;
	/*
	if (status!=""){
		sou += "&status="+status;
	}
	*/
	if (sou!=""){
		
		location.href=url+sou;
	}
}
</script>
{/literal}