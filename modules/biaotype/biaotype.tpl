{if $_A.query_type == "list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	<tr >
		<td width="" class="main_td">ID</td>
		<td width="*" class="main_td">识别码</td>
		<td width="*" class="main_td">标种名称</td>
		<td width="*" class="main_td">是否有效</td>
		<td width="*" class="main_td">最小借款金额</td>
		<td width="*" class="main_td">最大借款金额</td>
		<td width="*" class="main_td">最小利率</td>
		<td width="*" class="main_td">最大利率</td>
		<td width="*" class="main_td">垫付时间</td>
		<td width="*" class="main_td">逾期利率</td>
		<td width="*" class="main_td">借款费率</td>
		<td width="*" class="main_td">利息管理费</td>
		<td width="*" class="main_td">借款冻结比例</td>
		<td width="*" class="main_td">操作</td>
	</tr>
	<form action="" method="post">
	{ foreach  from=$_A.biao_type_list key=key item=item}
	<tr {if $key%2==1} class="tr2"{/if}>
		<td class="main_td1" align="center">{$item.id}</td>
		<td class="main_td1" align="center">{$item.biao_type_name}</td>
		<td class="main_td1" align="center">{$item.show_name}</td>
		<td class="main_td1" align="center">{if $item.available==1}有效{else}无效{/if}</td>
		<td class="main_td1" align="center">{$item.min_amount}</td>
		<td class="main_td1" align="center">{$item.max_amount}</td>
		<td class="main_td1" align="center">{$item.min_interest_rate}</td>
		<td class="main_td1" align="center">{$item.max_interest_rate}</td>
		<td class="main_td1" align="center">{$item.advance_time}</td>
		<td class="main_td1" align="center">{$item.late_interest_rate}</td>
		<td class="main_td1" align="center">{$item.borrow_fee_rate}</td>
		<td class="main_td1" align="center">{$item.interest_fee_rate}</td>
		<td class="main_td1" align="center">{$item.frost_rate}</td>
		<td class="main_td1" align="center"><a href="{$_A.query_url}/edit&type_id={$item.id}{$_A.site_url}">修改</a></td>
	</tr>
	{ /foreach}
	<tr>
		<td colspan="8" class="page">
		<input type="submit" value="修改排序" /
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
	<div class="module_title"><strong>基本信息</strong></div>
	
	<div class="module_border">
		<div class="l">标识别码：</div>
		<div class="c">
			{ $_A.biao_type_result.biao_type_name }<input type="hidden" name="biao_type_name" value="{ $_A.biao_type_result.biao_type_name }" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">标种名称：</div>
		<div class="c">
			<input name="show_name" type="text" value="{ $_A.biao_type_result.show_name }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">标种说明：</div>
		<div class="c">
			<input name="type_desc" type="text" value="{ $_A.biao_type_result.type_desc }" class="input_border" />（注：这里会显示为借款标页面图标的文字浮动提示，请不要超过32个汉字。）
		</div>
	</div>
	<div class="module_border">
		<div class="l">标种说明页面URL：</div>
		<div class="c">
			<input name="type_desc_url" type="text" value="{ $_A.biao_type_result.type_desc_url }" class="input_border" />（注：填写绝对地址，没有请为空或者‘/’。）
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">是否有效：</div>
		<div class="c">
			<input type="checkbox" name="available" value="1" {if $_A.biao_type_result.available==1} checked="checked"{/if} />（注：这里的优先级高于分站）
		</div>
	</div>
	<div class="module_title"><strong>特殊模式</strong></div>
	<div class="module_border">
		<div class="l">支持定向标模式：</div>
		<div class="c">
			<input type="checkbox" name="password_model" value="1" {if $_A.biao_type_result.password_model==1} checked="checked"{/if} />
		</div>
		<div class="l">支持开心模式：</div>
		<div class="c">
			<input type="checkbox" name="happy_model" value="1" {if $_A.biao_type_result.happy_model==1} checked="checked"{/if} />
		</div>
		<div class="l">支持天标模式：</div>
		<div class="c">
			<input type="checkbox" name="day_model" value="1" {if $_A.biao_type_result.day_model==1} checked="checked"{/if} />
		</div>		
	</div>
	<div class="module_title"><strong>投标限制设置</strong></div>
	<div class="module_border">
	<div class="l">投标待收限制：</div>
		<div class="c">
			<input name="tender_collection_limit_amount" type="text" value="{ $_A.biao_type_result.tender_collection_limit_amount}" class="input_border" />（注：大于0才生效）
		</div>
		<div class="l">投标IP限制分钟数：</div>
		<div class="c">
			<input name="tender_ip_limit_minutes" type="text" value="{ $_A.biao_type_result.tender_ip_limit_minutes}" class="input_border" />（注：大于0才生效）
		</div>
		<div class="l">投标IP限制次数：</div>
		<div class="c">
			<input name="tender_ip_limit_nums" type="text" value="{ $_A.biao_type_result.tender_ip_limit_nums}" class="input_border" />（注：大于0才生效）
	</div>	
	</div>
	<div class="module_title"><strong>发标认证管理</strong></div>
	<div class="module_border">
		<div class="l">发标需要实名认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_real_status" value="1" {if $_A.biao_type_result.biao_real_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要邮箱认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_email_status" value="1" {if $_A.biao_type_result.biao_email_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要电话认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_phone_status" value="1" {if $_A.biao_type_result.biao_phone_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要视频认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_video_status" value="1" {if $_A.biao_type_result.biao_video_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要现场认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_scene_status" value="1" {if $_A.biao_type_result.biao_scene_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要征信认证：</div>
		<div class="c">
			<input type="checkbox" name="biao_credit_status" value="1" {if $_A.biao_type_result.biao_credit_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要上传头像：</div>
		<div class="c">
			<input type="checkbox" name="biao_avatar_status" value="1" {if $_A.biao_type_result.biao_avatar_status==1} checked="checked"{/if} />
		</div>
		<div class="l">发标需要是VIP会员：</div>
		<div class="c">
			<input type="checkbox" name="biao_vip_status" value="1" {if $_A.biao_type_result.biao_vip_status==1} checked="checked"{/if} />
		</div>
	</div>
	
	<div class="module_title"><strong>审核管理</strong></div>
	<div class="module_border">
		<div class="l">自动初审：</div>
		<div class="c">
			<input type="checkbox" name="auto_verify" value="1" {if $_A.biao_type_result.auto_verify==1} checked="checked"{/if} />
		</div>
		<div class="l">自动满标复审：</div>
		<div class="c">
			<input type="checkbox" name="auto_full_verify" value="1" {if $_A.biao_type_result.auto_full_verify==1} checked="checked"{/if} />
		</div>
	</div>

	<div class="module_title"><strong>还款方式管理</strong></div>
	<div class="module_border">
		<div class="l">按月分期还款：</div>
		<div class="c">
			<input type="checkbox" name="repay_month" value="1" {if $_A.biao_type_result.repay_month==1} checked="checked"{/if} />
		</div>
		<div class="l">按月付息到期还本：</div>
		<div class="c">
			<input type="checkbox" name="repay_monthinterest" value="1" {if $_A.biao_type_result.repay_monthinterest==1} checked="checked"{/if} />
		</div>
		<div class="l">到期全额还款：</div>
		<div class="c">
			<input type="checkbox" name="repay_total" value="1" {if $_A.biao_type_result.repay_total==1} checked="checked"{/if} />
		</div>
		<div class="l">提前付息到期还本：</div>
		<div class="c">
			<input type="checkbox" name="repay_monthearly" value="1" {if $_A.biao_type_result.repay_monthearly==1} checked="checked"{/if} />
		</div>
	</div>	
	
	<div class="module_title"><strong>金额、费率管理</strong></div>
	<div class="module_border">
		<div class="l">最小借款金额：</div>
		<div class="c">
			<input name="min_amount" type="text" value="{ $_A.biao_type_result.min_amount }" class="input_border" />
		</div>
		<div class="l">最大借款金额：</div>
		<div class="c">
			<input name="max_amount" type="text" value="{ $_A.biao_type_result.max_amount }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">最小借款利率：</div>
		<div class="c">
			<input name="min_interest_rate" type="text" value="{ $_A.biao_type_result.min_interest_rate }" class="input_border" />
		</div>
		<div class="l">最大借款利率：</div>
		<div class="c">
			<input name="max_interest_rate" type="text" value="{ $_A.biao_type_result.max_interest_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">起始借款费率：</div>
		<div class="c">
			<input name="borrow_fee_rate_start" type="text" value="{ $_A.biao_type_result.borrow_fee_rate_start }" class="input_border" />
		</div>
		<div class="l">起始借款费率包含月份数：</div>
		<div class="c">
			<input name="borrow_fee_rate_start_month_num" type="text" value="{ $_A.biao_type_result.borrow_fee_rate_start_month_num }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款费率：</div>
		<div class="c">
			<input name="borrow_fee_rate" type="text" value="{ $_A.biao_type_result.borrow_fee_rate }" class="input_border" />
		</div>
		<div class="l">借款费率（天标）：</div>
		<div class="c">
			<input name="borrow_day_fee_rate" type="text" value="{ $_A.biao_type_result.borrow_day_fee_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">利息管理费：</div>
		<div class="c">
			<input name="interest_fee_rate" type="text" value="{ $_A.biao_type_result.interest_fee_rate }" class="input_border" />
		</div>
		<div class="l">借款冻结比例：</div>
		<div class="c">
			<input name="frost_rate" type="text" value="{ $_A.biao_type_result.frost_rate }" class="input_border" />
		</div>
	</div>
	
	
	<div class="module_title"><strong>逾期管理</strong></div>
	<div class="module_border">
		<div class="l">逾期垫付时间：</div>
		<div class="c">
			<input name="advance_time" type="text" value="{ $_A.biao_type_result.advance_time }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">逾期垫付范围：</div>
		<div class="c">
			<input name="advance_scope" type="radio" value="0"  {if $_A.biao_type_result.advance_scope==0} checked="checked"{/if}/><label for="">不垫付</label> 
			<input name="advance_scope" type="radio" value="1"  {if $_A.biao_type_result.advance_scope==1} checked="checked"{/if}/><label for="">垫付本金</label> 
			<input name="advance_scope" type="radio" value="2"  {if $_A.biao_type_result.advance_scope==2} checked="checked"{/if}/><label for="">垫付本息</label> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">逾期垫付范围（VIP）：</div>
		<div class="c">
			<input name="advance_vip_scope" type="radio" value="0"  {if $_A.biao_type_result.advance_vip_scope==0} checked="checked"{/if}/><label for="">不垫付</label> 
			<input name="advance_vip_scope" type="radio" value="1"  {if $_A.biao_type_result.advance_vip_scope==1} checked="checked"{/if}/><label for="">垫付本金</label> 
			<input name="advance_vip_scope" type="radio" value="2"  {if $_A.biao_type_result.advance_vip_scope==2} checked="checked"{/if}/><label for="">垫付本息</label> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">逾期垫付比例：</div>
		<div class="c">
			<input name="advance_rate" type="text" value="{ $_A.biao_type_result.advance_rate }" class="input_border" />
		</div>
		<div class="l">逾期垫付比例（VIP）：</div>
		<div class="c">
			<input name="advance_vip_rate" type="text" value="{ $_A.biao_type_result.advance_vip_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">逾期利率：</div>
		<div class="c">
			<input name="late_interest_rate" type="text" value="{ $_A.biao_type_result.late_interest_rate }" class="input_border" />
		</div>
		<div class="l">借款逾期投资人所得逾期利率：</div>
		<div class="c">
			<input name="late_customer_interest_rate" type="text" value="{ $_A.biao_type_result.late_customer_interest_rate }" class="input_border" />
		</div>
	</div>
	
	<div class="module_title"><strong>投标管理</strong></div>	
	<div class="module_border">
		<div class="l">单个投资人最大投标次数：</div>
		<div class="c">
			<input name="max_tender_times" type="text" value="{ $_A.biao_type_result.max_tender_times }" class="input_border" />
		</div>
	</div>
	
	<div class="module_title" style="display:none"><strong>本金保障</strong></div>
	<div class="module_border" style="display:none">
		<div class="l">可以缴纳本金保障费：</div>
		<div class="c">
			<input type="checkbox" name="can_pay_insurance" value="1" {if $_A.biao_type_result.can_pay_insurance==1} checked="checked"{/if} />
		</div>
		<div class="l">最小本金保障费率：</div>
		<div class="c">
			<input name="min_insurance_rate" type="text" value="{ $_A.biao_type_result.min_insurance_rate }" class="input_border" />
		</div>
		<div class="l">最大本金保障费率：</div>
		<div class="c">
			<input name="max_insurance_rate" type="text" value="{ $_A.biao_type_result.max_insurance_rate }" class="input_border" />
		</div>
	</div>	
	
	<div class="module_submit border_b" >
	{ if $_A.query_type == "edit" }<input type="hidden" name="type_id" value="{ $_A.biao_type_result.id }" />{/if}
	<input type="submit" value="确认提交" />
	<input type="reset" name="reset" value="重置表单" />
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
		errorMsg += '用户名不能为空' + '\n';
	  }
	   if (username.length<4) {
		errorMsg += '用户名长度不能少于4位' + '\n';
	  }
	  if (password.length==0) {
		errorMsg += '密码不能为空' + '\n';
	  }
	  if (password.length<6) {
		errorMsg += '密码长度不能小于6位' + '\n';
	  }
	   if (password.length!=password1.length) {
		errorMsg += '两次密码不一样' + '\n';
	  }
	   if (email.length==0) {
		errorMsg += '邮箱不能为空' + '\n';
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