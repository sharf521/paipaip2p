{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">ʶ����</td>
		<td width="*" class="main_td">��������</td>
		<td width="*" class="main_td">�Ƿ���Ч</td>
		<td width="*" class="main_td">��С�����</td>
		<td width="*" class="main_td">�������</td>
		<td width="*" class="main_td">��С����</td>
		<td width="*" class="main_td">�������</td>
		<td width="*" class="main_td">�渶ʱ��</td>
		<td width="*" class="main_td">��������</td>
		<td width="*" class="main_td">������</td>
		<td width="*" class="main_td">��Ϣ�����</td>
		<td width="*" class="main_td">�������</td>
		<td width="*" class="main_td">����</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.biao_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center">{$item.biao_type_name}</td>
		<td class="main_td1" align="center">{$item.show_name}</td>
		<td class="main_td1" align="center">{if $item.available==1}��Ч{else}��Ч{/if}</td>
		<td class="main_td1" align="center">{$item.min_amount}</td>
		<td class="main_td1" align="center">{$item.max_amount}</td>
		<td class="main_td1" align="center">{$item.min_interest_rate}</td>
		<td class="main_td1" align="center">{$item.max_interest_rate}</td>
		<td class="main_td1" align="center">{$item.advance_time}</td>
		<td class="main_td1" align="center">{$item.late_interest_rate}</td>
		<td class="main_td1" align="center">{$item.borrow_fee_rate}</td>
		<td class="main_td1" align="center">{$item.interest_fee_rate}</td>
		<td class="main_td1" align="center">{$item.frost_rate}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&type_id={$item.id}{$_A.site_url}">�޸�</a></td>
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
	<form name="form_user" method="post" action="" { if $_A.query_type == "new" }{/if} >
	<div class="module_title"><strong>������Ϣ</strong></div>
	
	<div class="module_border">
		<div class="l">��ʶ���룺</div>
		<div class="c">
			{ $_A.biao_type_result.biao_type_name }<input type="hidden" name="biao_type_name" value="{ $_A.biao_type_result.biao_type_name }" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ƣ�</div>
		<div class="c">
			<input name="show_name" type="text" value="{ $_A.biao_type_result.show_name }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����˵����</div>
		<div class="c">
			<input name="type_desc" type="text" value="{ $_A.biao_type_result.type_desc }" class="input_border" />��ע���������ʾΪ����ҳ��ͼ������ָ�����ʾ���벻Ҫ����32�����֡���
		</div>
	</div>
	<div class="module_border">
		<div class="l">����˵��ҳ��URL��</div>
		<div class="c">
			<input name="type_desc_url" type="text" value="{ $_A.biao_type_result.type_desc_url }" class="input_border" />��ע����д���Ե�ַ��û����Ϊ�ջ��ߡ�/������
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�Ƿ���Ч��</div>
		<div class="c">
			<input type="checkbox" name="available" value="1" {if $_A.biao_type_result.available==1} checked="checked"{/if} />��ע����������ȼ����ڷ�վ��
		</div>
	</div>
	<div class="module_title"><strong>����ģʽ</strong></div>
	<div class="module_border">
		<div class="l">֧�ֶ����ģʽ��</div>
		<div class="c">
			<input type="checkbox" name="password_model" value="1" {if $_A.biao_type_result.password_model==1} checked="checked"{/if} />
		</div>
		<div class="l">֧�ֿ���ģʽ��</div>
		<div class="c">
			<input type="checkbox" name="happy_model" value="1" {if $_A.biao_type_result.happy_model==1} checked="checked"{/if} />
		</div>
		<div class="l">֧�����ģʽ��</div>
		<div class="c">
			<input type="checkbox" name="day_model" value="1" {if $_A.biao_type_result.day_model==1} checked="checked"{/if} />
		</div>		
	</div>
	<div class="module_title"><strong>Ͷ����������</strong></div>
	<div class="module_border">
	<div class="l">Ͷ��������ƣ�</div>
		<div class="c">
			<input name="tender_collection_limit_amount" type="text" value="{ $_A.biao_type_result.tender_collection_limit_amount}" class="input_border" />��ע������0����Ч��
		</div>
		<div class="l">Ͷ��IP���Ʒ�������</div>
		<div class="c">
			<input name="tender_ip_limit_minutes" type="text" value="{ $_A.biao_type_result.tender_ip_limit_minutes}" class="input_border" />��ע������0����Ч��
		</div>
		<div class="l">Ͷ��IP���ƴ�����</div>
		<div class="c">
			<input name="tender_ip_limit_nums" type="text" value="{ $_A.biao_type_result.tender_ip_limit_nums}" class="input_border" />��ע������0����Ч��
	</div>	
	</div>
	<div class="module_title"><strong>������֤����</strong></div>
	<div class="module_border">
		<div class="l">������Ҫʵ����֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_real_status" value="1" {if $_A.biao_type_result.biao_real_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ������֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_email_status" value="1" {if $_A.biao_type_result.biao_email_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ�绰��֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_phone_status" value="1" {if $_A.biao_type_result.biao_phone_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ��Ƶ��֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_video_status" value="1" {if $_A.biao_type_result.biao_video_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ�ֳ���֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_scene_status" value="1" {if $_A.biao_type_result.biao_scene_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ������֤��</div>
		<div class="c">
			<input type="checkbox" name="biao_credit_status" value="1" {if $_A.biao_type_result.biao_credit_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ�ϴ�ͷ��</div>
		<div class="c">
			<input type="checkbox" name="biao_avatar_status" value="1" {if $_A.biao_type_result.biao_avatar_status==1} checked="checked"{/if} />
		</div>
		<div class="l">������Ҫ��VIP��Ա��</div>
		<div class="c">
			<input type="checkbox" name="biao_vip_status" value="1" {if $_A.biao_type_result.biao_vip_status==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_title"><strong>��˹���</strong></div>
	<div class="module_border">
		<div class="l">�Զ�����</div>
		<div class="c">
			<input type="checkbox" name="auto_verify" value="1" {if $_A.biao_type_result.auto_verify==1} checked="checked"{/if} />
		</div>
		<div class="l">�Զ����긴��</div>
		<div class="c">
			<input type="checkbox" name="auto_full_verify" value="1" {if $_A.biao_type_result.auto_full_verify==1} checked="checked"{/if} />
		</div>
	</div>

	<div class="module_title"><strong>���ʽ����</strong></div>
	<div class="module_border">
		<div class="l">���·��ڻ��</div>
		<div class="c">
			<input type="checkbox" name="repay_month" value="1" {if $_A.biao_type_result.repay_month==1} checked="checked"{/if} />
		</div>
		<div class="l">���¸�Ϣ���ڻ�����</div>
		<div class="c">
			<input type="checkbox" name="repay_monthinterest" value="1" {if $_A.biao_type_result.repay_monthinterest==1} checked="checked"{/if} />
		</div>
		<div class="l">����ȫ��</div>
		<div class="c">
			<input type="checkbox" name="repay_total" value="1" {if $_A.biao_type_result.repay_total==1} checked="checked"{/if} />
		</div>
		<div class="l">��ǰ��Ϣ���ڻ�����</div>
		<div class="c">
			<input type="checkbox" name="repay_monthearly" value="1" {if $_A.biao_type_result.repay_monthearly==1} checked="checked"{/if} />
		</div>
	</div>	
	
	<div class="module_title"><strong>�����ʹ���</strong></div>
	<div class="module_border">
		<div class="l">��С����</div>
		<div class="c">
			<input name="min_amount" type="text" value="{ $_A.biao_type_result.min_amount }" class="input_border" />
		</div>
		<div class="l">������</div>
		<div class="c">
			<input name="max_amount" type="text" value="{ $_A.biao_type_result.max_amount }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��С������ʣ�</div>
		<div class="c">
			<input name="min_interest_rate" type="text" value="{ $_A.biao_type_result.min_interest_rate }" class="input_border" />
		</div>
		<div class="l">��������ʣ�</div>
		<div class="c">
			<input name="max_interest_rate" type="text" value="{ $_A.biao_type_result.max_interest_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ʼ�����ʣ�</div>
		<div class="c">
			<input name="borrow_fee_rate_start" type="text" value="{ $_A.biao_type_result.borrow_fee_rate_start }" class="input_border" />
		</div>
		<div class="l">��ʼ�����ʰ����·�����</div>
		<div class="c">
			<input name="borrow_fee_rate_start_month_num" type="text" value="{ $_A.biao_type_result.borrow_fee_rate_start_month_num }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�����ʣ�</div>
		<div class="c">
			<input name="borrow_fee_rate" type="text" value="{ $_A.biao_type_result.borrow_fee_rate }" class="input_border" />
		</div>
		<div class="l">�����ʣ���꣩��</div>
		<div class="c">
			<input name="borrow_day_fee_rate" type="text" value="{ $_A.biao_type_result.borrow_day_fee_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ϣ����ѣ�</div>
		<div class="c">
			<input name="interest_fee_rate" type="text" value="{ $_A.biao_type_result.interest_fee_rate }" class="input_border" />
		</div>
		<div class="l">���������</div>
		<div class="c">
			<input name="frost_rate" type="text" value="{ $_A.biao_type_result.frost_rate }" class="input_border" />
		</div>
	</div>
	
	
	<div class="module_title"><strong>���ڹ���</strong></div>
	<div class="module_border">
		<div class="l">���ڵ渶ʱ�䣺</div>
		<div class="c">
			<input name="advance_time" type="text" value="{ $_A.biao_type_result.advance_time }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ڵ渶��Χ��</div>
		<div class="c">
			<input name="advance_scope" type="radio" value="0"  {if $_A.biao_type_result.advance_scope==0} checked="checked"{/if}/><label for="">���渶</label> 
			<input name="advance_scope" type="radio" value="1"  {if $_A.biao_type_result.advance_scope==1} checked="checked"{/if}/><label for="">�渶����</label> 
			<input name="advance_scope" type="radio" value="2"  {if $_A.biao_type_result.advance_scope==2} checked="checked"{/if}/><label for="">�渶��Ϣ</label> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ڵ渶��Χ��VIP����</div>
		<div class="c">
			<input name="advance_vip_scope" type="radio" value="0"  {if $_A.biao_type_result.advance_vip_scope==0} checked="checked"{/if}/><label for="">���渶</label> 
			<input name="advance_vip_scope" type="radio" value="1"  {if $_A.biao_type_result.advance_vip_scope==1} checked="checked"{/if}/><label for="">�渶����</label> 
			<input name="advance_vip_scope" type="radio" value="2"  {if $_A.biao_type_result.advance_vip_scope==2} checked="checked"{/if}/><label for="">�渶��Ϣ</label> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ڵ渶������</div>
		<div class="c">
			<input name="advance_rate" type="text" value="{ $_A.biao_type_result.advance_rate }" class="input_border" />
		</div>
		<div class="l">���ڵ渶������VIP����</div>
		<div class="c">
			<input name="advance_vip_rate" type="text" value="{ $_A.biao_type_result.advance_vip_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�������ʣ�</div>
		<div class="c">
			<input name="late_interest_rate" type="text" value="{ $_A.biao_type_result.late_interest_rate }" class="input_border" />
		</div>
		<div class="l">�������Ͷ���������������ʣ�</div>
		<div class="c">
			<input name="late_customer_interest_rate" type="text" value="{ $_A.biao_type_result.late_customer_interest_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_title"><strong>Ͷ�����</strong></div>	
	<div class="module_border">
		<div class="l">����Ͷ�������Ͷ�������</div>
		<div class="c">
			<input name="max_tender_times" type="text" value="{ $_A.biao_type_result.max_tender_times }" class="input_border" />
		</div>
	</div>
	
	<div class="module_title" style="display:none"><strong>������</strong></div>
	<div class="module_border" style="display:none">
		<div class="l">���Խ��ɱ����Ϸѣ�</div>
		<div class="c">
			<input type="checkbox" name="can_pay_insurance" value="1" {if $_A.biao_type_result.can_pay_insurance==1} checked="checked"{/if} />
		</div>
		<div class="l">��С�����Ϸ��ʣ�</div>
		<div class="c">
			<input name="min_insurance_rate" type="text" value="{ $_A.biao_type_result.min_insurance_rate }" class="input_border" />
		</div>
		<div class="l">��󱾽��Ϸ��ʣ�</div>
		<div class="c">
			<input name="max_insurance_rate" type="text" value="{ $_A.biao_type_result.max_insurance_rate }" class="input_border" />
		</div>
	</div>	
	
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="type_id" value="{ $_A.biao_type_result.id }" />{/if}
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
{/if}