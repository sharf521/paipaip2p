{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	{if $magic.request.user_id==""}
	<form name="form1" method="post" action="" enctype="multipart/form-data" >
	<div class="module_title"><strong>请输入此信息的用户名或ID</strong></div>
	

	<div class="module_border">
		<div class="l">用户ID：</div>
		<div class="c">
			<input type="text" name="user_id"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			<input type="text" name="username"  class="input_border"  size="20" />
		</div>
	</div>

	<div class="module_submit" >
		<input type="submit"  name="submit" value="确认提交" />
		<input type="reset"  name="reset" value="重置表单" />
	</div>

	</form>
	{else}
	<div class="module_title"><strong>添加用户信息</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" onsubmit="return check_form();" >
	
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			{$_A.user_result.username|default:$_A.borrow_result.username}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款用途：</div>
		<div class="c">
		{linkages nid="borrow_use" value="$_A.borrow_result.use" name="use" default="asd" }
			 <span >说明借款成功后的具体用途。</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款期限：</div>
		<div class="c">
			{linkages nid="borrow_time_limit" value="$_A.borrow_result.time_limit" name="time_limit" type="value" }<span >借款成功后,打算以几个月的时间来还清贷款。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">还款方式：</div>
		<div class="c">
			{linkages nid="borrow_style" value="$_A.borrow_result.style" name="style" type="value" }
		<span >按季度分期还款是指贷款者借款成功后,每月还息，按季还本。</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借贷总金额：</div>
		<div class="c"><input type="text" name="account" value="{$_A.borrow_result.account}"  size="10"/>
<span >借款金额应在500元至50,000元之间。交易币种均为人民币。</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">年利率：</div>
		<div class="c">
			<input type="text" name="apr" value="{$_A.borrow_result.apr}" /> % <span >按季度分期还款是指贷款者借款成功后,每月还息，按季还本。</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">最低投标金额：</div>
		<div class="c">
			{linkages nid="borrow_lowest_account" value="$_A.borrow_result.lowest_account" name="lowest_account" type="value" }
		<span >允许投资者对一个借款标的投标总额的限制。</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">最多投标总额：</div>
		<div class="c">
			{linkages nid="borrow_most_account" value="$_A.borrow_result.most_account" name="most_account" type="value" }
			<span >设置此次借款融资的天数。融资进度达到100%后直接进行网站的复审</span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">有效时间：</div>
		<div class="c">
			{linkages nid="borrow_valid_time" value="$_A.borrow_result.valid_time" name="valid_time" type="value" }
			 <span>设置此次借款融资的天数。融资进度达到100%后直接进行网站的复审 </span>
		</div>
	</div>
	<div class="module_title"><strong>设置奖励</strong></div>
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="0" {if $_A.borrow_result.award==0 || $_A.borrow_result.award==""} checked="checked"{/if}>不设置奖励</div>
		<div class="c">
			 <span>如果您设置了奖励金额，将会冻结您账户中相应的账户余额。如果要设置奖励，请确保您的账户有足够 的账户余额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="1" {if $_A.borrow_result.award==1 } checked="checked"{/if}/>按固定金额分摊奖励：</div>
		<div class="c">
			<input type="text" name="part_account" value="{$_A.borrow_result.part_account}" size="5" />元 <span>不能低于5元,不能高于总标的金额的2%，且请保留到“元”为单位。这里设置本次标的要奖励给所有投标用户的总金额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="2" {if $_A.borrow_result.award==2 } checked="checked"{/if}/>按投标金额比例奖励：</div>
		<div class="c">
			<input type="text" name="funds" value="{$_A.borrow_result.funds}" size="5" />%  <span>范围：0.1%~2% ，这里设置本次标的要奖励给所有投标用户的奖励比例。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="checkbox" name="is_false" value="1" {if $_A.borrow_result.is_false==1 } checked="checked"{/if}/>标的失败时也同样奖励：</div>
		<div class="c">
			  <span>如果您勾选了此选项，到期未满标或复审失败时同样会奖励给投标用户。如果没有勾选，标的失败时会把奖励金额解冻回账户余额。   </span>
		</div>
	</div>

	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>担保奖励</strong></div>
	<div class="module_border">
		<div class="l">担保奖励：</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">指定担保人：</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
	
	<div class="module_title"><strong>账户信息公开</strong></div>
	<div class="module_border">
		<div class="w">公开我的账户资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_account" value="1" {if $_A.borrow_result.open_account==1 } checked="checked"{/if}/> <span> 如果您勾上此选项，将会实时公开您账户的：账户总额、可用余额、冻结总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的借款资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_borrow" value="1" {if $_A.borrow_result.open_borrow==1 } checked="checked"{/if}/> <span>如果您勾上此选项，将会实时公开您账户的：借款总额、已还款总额、未还款总额、迟还总额、逾期总额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的投标资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_tender" value="1" {if $_A.borrow_result.open_tender==1 } checked="checked"{/if}/> <span>如果您勾上此选项，将会实时公开您账户的：投标总额、已收回总额、待收回总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的信用额度情况：</div>
		<div class="c">
			<input type="checkbox" name="open_credit" value="1" {if $_A.borrow_result.open_credit==1 } checked="checked"{/if}/> <span>如果您勾上此选项，将会实时公开您账户的：最低信用额度、最高信用额度。  </span>
		</div>
	</div>
	
	<div class="module_title"><strong>详细信息</strong></div>
	<div class="module_border">
		<div class="l">标题：</div>
		<div class="c">
			<input type="text" name="name" value="{$_A.borrow_result.name}" size="50" /> 
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">信息：</div>
		<div class="c">
			{editor name="content" type="sinaeditor" value="$_A.borrow_result.content"}
		</div>
	</div>
	<!--基本资料 结束-->
		
	<div class="module_submit" >
		{if $_A.query_type == "edit"}<input type="hidden"  name="id" value="{$magic.request.id}" />{/if}
		<input type="hidden" name="status" value="{ $_A.borrow_result.status }" />
		<input type="hidden"  name="user_id" value="{$magic.request.user_id}" />
		<input type="submit"  name="submit" value="确认提交" />
		<input type="reset"  name="reset" value="重置表单" />
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
		errorMsg += '标题必须填写' + '\n';
	  }
	   if (award ==1 && part_account<5) {
		errorMsg += '奖励金额不能小于5元' + '\n';
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
	<div class="module_title"><strong>审核借款标</strong></div>


	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
		<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.user_result.username|default:$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">发标分站：</div>
		<div class="c">
			{$_A.borrow_result.sitename}
		</div>
	</div>
	<div class="module_border">
		<div class="l">状态：</div>
		<div class="c">
			{if $_A.borrow_result.status==0}发布审批中{elseif $_A.borrow_result.status==1}正在募集{elseif $_A.borrow_result.status==2}审核失败{elseif $_A.borrow_result.status==3}已满标{elseif $_A.borrow_result.status==4}满标审核失败{elseif $_A.borrow_result.status==5}撤回{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款用途：</div>
		<div class="c">
			{$_A.borrow_result.use|linkage:"borrow_use"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款期限：</div>
		<div class="c">
		{ if $_A.borrow_result.isday ==1}{$_A.borrow_result.time_limit_day}天{ else}{$_A.borrow_result.time_limit}个月{/if}
		</div>
	</div>

	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">还款方式：</div>
		<div class="c">
			{if $_A.borrow_result.isday==1 } 
                到期全额还款
                {else}
                {$_A.borrow_result.style|linkage:"borrow_style"}
                {/if}
		</div>
	</div>
	{/if}
	<div class="module_border">
		<div class="l">借贷总金额：</div>
		<div class="c">
				{$_A.borrow_result.account}<input type="hidden" name="account" value="{$_A.borrow_result.account}" /> 元
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">年利率：</div>
		<div class="c">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">最低投标金额：</div>
		<div class="c">
			{$_A.borrow_result.lowest_account|linkage:"borrow_lowest_account"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">最多投标总额：</div>
		<div class="c">
			{$_A.borrow_result.most_account|linkage:"borrow_most_account"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.status==1}
	<div class="module_border">
		<div class="l">审核时间：</div>
		<div class="c">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i"}
		</div>
	</div>
	<div class="module_border">
		<div class="l">审核人：</div>
		<div class="c">
			{$_A.borrow_result.verify_username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">审核备注：</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	
	{/if}
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">有效时间：</div>
		<div class="c">
			{$_A.borrow_result.valid_time|linkage:"borrow_valid_time"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.biao_type=='circulation'}
	<!-- liukun add for bug 115 begin -->
	<div class="module_title"><strong>流转设置</strong></div>
	<div class="module_border">
		<div class="l">每次新增月份时间：</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_month_num}个月
		</div>
		
		<div class="l">每月增加年利率：</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_apr}%
		</div>
		
		<div class="l">最低认购期限：</div>
		<div class="c">
			{$_A.borrow_additional_info.begin_month_num}个月
		</div>
		
		<div class="l">每份价格：</div>
		<div class="c">
			{$_A.borrow_additional_info.unit_price}元
		</div>
		
		<div class="l">最小认购份数：</div>
		<div class="c">
			{$_A.borrow_additional_info.min_unit_num}
		</div>
		
		<div class="l">最大认购份数：</div>
		<div class="c">
			{$_A.borrow_additional_info.max_unit_num}
		</div>								
		
	</div>
	<!-- liukun add for bug 115 end -->
	{/if}
	{if $_A.blacklist_info.user_id != ""}
	<div class="module_title"><strong>本平台内逾期信息</strong></div>
	<div class="module_border">
		<div class="l">逾期金额：</div>
		<div class="c">
		{$_A.blacklist_info.late_amount}元
		</div>
		<div class="l">逾期笔数：</div>
		<div class="c">
		{$_A.blacklist_info.late_num}
		</div>
		<div class="l">最大逾期天数：</div>
		<div class="c">
		{$_A.blacklist_info.late_day_num}
		</div>
		<div class="l">网站代还金额：</div>
		<div class="c">
		{$_A.blacklist_info.advance_amount}元
		</div>
		<div class="l">网站代还笔数：</div>
		<div class="c">
		{$_A.blacklist_info.advance_num}
		</div>
	</div>
	<div class="module_title"><strong>其它平台内逾期信息</strong></div>
	<div class="module_border">
		<div class="l">逾期金额：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_amount}元
		</div>
		<div class="l">逾期笔数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_num}
		</div>
		<div class="l">最大逾期天数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_day_num}
		</div>
		<div class="l">网站代还金额：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_amount}元
		</div>
		<div class="l">网站代还笔数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_num}
		</div>
	</div>	
	{/if}
	<div class="module_title"><strong>设置奖励</strong></div>
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="0" {if $_A.borrow_result.award==0 || $_A.borrow_result.award==""} checked="checked"{/if} disabled="disabled">不设置奖励</div>
		<div class="c">
			 <span>如果您设置了奖励金额，将会冻结您账户中相应的账户余额。如果要设置奖励，请确保您的账户有足够 的账户余额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="1" {if $_A.borrow_result.award==1 } checked="checked"{/if} disabled="disabled"/>按固定金额分摊奖励：</div>
		<div class="c">
			<input type="text" name="part_account" value="{$_A.borrow_result.part_account}" size="5" disabled="disabled"/>元 <span>不能低于5元,不能高于总标的金额的2%，且请保留到“元”为单位。这里设置本次标的要奖励给所有投标用户的总金额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="2" {if $_A.borrow_result.award==2 } checked="checked"{/if} disabled="disabled"/>按投标金额比例奖励：</div>
		<div class="c">
			<input type="text" name="funds" value="{$_A.borrow_result.funds}" size="5" disabled="disabled"/>%  <span>范围：0.1%~2% ，这里设置本次标的要奖励给所有投标用户的奖励比例。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="checkbox" name="is_false" value="1" {if $_A.borrow_result.is_false==1 } checked="checked"{/if}  disabled="disabled"/>标的失败时也同样奖励：</div>
		<div class="c">
			  <span>如果您勾选了此选项，到期未满标或复审失败时同样会奖励给投标用户。如果没有勾选，标的失败时会把奖励金额解冻回账户余额。   </span>
		</div>
	</div>
	
	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>担保奖励</strong></div>
	<div class="module_border">
		<div class="l">担保奖励：</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">指定担保人：</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
	<div class="module_title"><strong>账户信息公开</strong></div>
	<div class="module_border">
		<div class="w">公开我的账户资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_account" value="1" {if $_A.borrow_result.open_account==1 } checked="checked"{/if} disabled="disabled"/> <span> 如果您勾上此选项，将会实时公开您账户的：账户总额、可用余额、冻结总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的借款资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_borrow" value="1" {if $_A.borrow_result.open_borrow==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：借款总额、已还款总额、未还款总额、迟还总额、逾期总额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的投标资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_tender" value="1" {if $_A.borrow_result.open_tender==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：投标总额、已收回总额、待收回总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的信用额度情况：</div>
		<div class="c">
			<input type="checkbox" name="open_credit" value="1" {if $_A.borrow_result.open_credit==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：最低信用额度、最高信用额度。  </span>
		</div>
	</div>
	<div class="module_border">
		<div class="l">添加时间/IP:</div>
		<div class="c">
			{ $_A.borrow_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.borrow_result.addip}</div>
	</div>
	<div class="module_title"><strong>分站审核</strong></div>
	
	
	<div class="module_border" >
		<div class="l">审核意见:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="45" rows="5">{ $_A.borrow_result.subsite_remark}</textarea>
		</div>
	</div>	
	{ if $_A.borrow_result.status!=1}
	<div class="module_title"><strong>审核此借款</strong></div>
	
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
		<input type="radio" name="status" value="1"/>审核通过 <input type="radio" name="status" value="2"  checked="checked"/>审核不通过 </div>
		
	</div>
	
	<div class="module_border" >
		<div class="l">审核备注:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.borrow_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.borrow_result.user_id }" />
		<input type="hidden" name="name" value="{ $_A.borrow_result.name }" />
		
		<input type="submit"  name="reset" value="审核此借款标" />
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
		 errorMsg += '备注必须填写' + '\n'; 
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
	<div class="module_title"><strong>审核借款标</strong></div>


	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
		<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.user_result.username|default:$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">状态：</div>
		<div class="c">
			{if $_A.borrow_result.status==0}发布审批中{elseif $_A.borrow_result.status==1}正在募集{elseif $_A.borrow_result.status==2}审核失败{elseif $_A.borrow_result.status==3}已满标{elseif $_A.borrow_result.status==4}满标审核失败{elseif $_A.borrow_result.status==5}撤回{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款用途：</div>
		<div class="c">
			{$_A.borrow_result.use|linkage}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款期限：</div>
		<div class="c">
		{$_A.borrow_result.time_limit|linkage:"borrow_time_limit"}
		</div>
	</div>
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">还款方式：</div>
		<div class="c">
			{if $_A.borrow_result.isday==1 } 
                到期全额还款
                {else}
                {$_A.borrow_result.style|linkage:"borrow_style"}
                {/if}
		</div>
	</div>
	{/if}
	<div class="module_border">
		<div class="l">借贷总金额：</div>
		<div class="c">
				{$_A.borrow_result.account}<input type="hidden" name="account" value="{$_A.borrow_result.account}" /> 元
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">年利率：</div>
		<div class="c">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">最低投标金额：</div>
		<div class="c">
			{$_A.borrow_result.lowest_account|linkage:"borrow_lowest_account"}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">最多投标总额：</div>
		<div class="c">
			{$_A.borrow_result.most_account|linkage:"borrow_most_account"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.status==1}
	<div class="module_border">
		<div class="l">审核时间：</div>
		<div class="c">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i"}
		</div>
	</div>
	<div class="module_border">
		<div class="l">审核人：</div>
		<div class="c">
			{$_A.borrow_result.verify_username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">审核备注：</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	
	{/if}
	{if $_A.borrow_result.biao_type!='circulation'}
	<div class="module_border">
		<div class="l">有效时间：</div>
		<div class="c">
			{$_A.borrow_result.valid_time|linkage:"borrow_valid_time"}
		</div>
	</div>
	{/if}
	{if $_A.borrow_result.biao_type=='circulation'}
	<!-- liukun add for bug 115 begin -->
	<div class="module_title"><strong>流转设置</strong></div>
	<div class="module_border">
		<div class="l">每次新增月份时间：</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_month_num}个月
		</div>
		
		<div class="l">每月增加年利率：</div>
		<div class="c">
			{$_A.borrow_additional_info.increase_apr}%
		</div>
		
		<div class="l">最低认购期限：</div>
		<div class="c">
			{$_A.borrow_additional_info.begin_month_num}个月
		</div>
		
		<div class="l">每份价格：</div>
		<div class="c">
			{$_A.borrow_additional_info.unit_price}元
		</div>
		
		<div class="l">最小认购份数：</div>
		<div class="c">
			{$_A.borrow_additional_info.min_unit_num}
		</div>
		
		<div class="l">最大认购份数：</div>
		<div class="c">
			{$_A.borrow_additional_info.max_unit_num}
		</div>								
		
	</div>
	<!-- liukun add for bug 115 end -->
	{/if}
	{if $_A.blacklist_info.user_id != ""}
	<div class="module_title"><strong>本平台内逾期信息</strong></div>
	<div class="module_border">
		<div class="l">逾期金额：</div>
		<div class="c">
		{$_A.blacklist_info.late_amount}元
		</div>
		<div class="l">逾期笔数：</div>
		<div class="c">
		{$_A.blacklist_info.late_num}
		</div>
		<div class="l">最大逾期天数：</div>
		<div class="c">
		{$_A.blacklist_info.late_day_num}
		</div>
		<div class="l">网站代还金额：</div>
		<div class="c">
		{$_A.blacklist_info.advance_amount}元
		</div>
		<div class="l">网站代还笔数：</div>
		<div class="c">
		{$_A.blacklist_info.advance_num}
		</div>
	</div>
	<div class="module_title"><strong>其它平台内逾期信息</strong></div>
	<div class="module_border">
		<div class="l">逾期金额：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_amount}元
		</div>
		<div class="l">逾期笔数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_num}
		</div>
		<div class="l">最大逾期天数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.late_day_num}
		</div>
		<div class="l">网站代还金额：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_amount}元
		</div>
		<div class="l">网站代还笔数：</div>
		<div class="c">
		{$_A.blacklist_otherinfo.advance_num}
		</div>
	</div>	
	{/if}	
	<div class="module_title"><strong>设置奖励</strong></div>
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="0" {if $_A.borrow_result.award==0 || $_A.borrow_result.award==""} checked="checked"{/if} disabled="disabled">不设置奖励</div>
		<div class="c">
			 <span>如果您设置了奖励金额，将会冻结您账户中相应的账户余额。如果要设置奖励，请确保您的账户有足够 的账户余额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="1" {if $_A.borrow_result.award==1 } checked="checked"{/if} disabled="disabled"/>按固定金额分摊奖励：</div>
		<div class="c">
			<input type="text" name="part_account" value="{$_A.borrow_result.part_account}" size="5" disabled="disabled"/>元 <span>不能低于5元,不能高于总标的金额的2%，且请保留到“元”为单位。这里设置本次标的要奖励给所有投标用户的总金额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="radio" name="award" value="2" {if $_A.borrow_result.award==2 } checked="checked"{/if} disabled="disabled"/>按投标金额比例奖励：</div>
		<div class="c">
			<input type="text" name="funds" value="{$_A.borrow_result.funds}" size="5" disabled="disabled"/>%  <span>范围：0.1%~2% ，这里设置本次标的要奖励给所有投标用户的奖励比例。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w"><input type="checkbox" name="is_false" value="1" {if $_A.borrow_result.is_false==1 } checked="checked"{/if}  disabled="disabled"/>标的失败时也同样奖励：</div>
		<div class="c">
			  <span>如果您勾选了此选项，到期未满标或复审失败时同样会奖励给投标用户。如果没有勾选，标的失败时会把奖励金额解冻回账户余额。   </span>
		</div>
	</div>
	
	{if $_A.borrow_result.is_vouch==1}
	<div class="module_title"><strong>担保奖励</strong></div>
	<div class="module_border">
		<div class="l">担保奖励：</div>
		<div class="c">
			{$_A.borrow_result.vouch_award}%
		</div>
	</div>
	<div class="module_border">
		<div class="l">指定担保人：</div>
		<div class="c">
			{$_A.borrow_result.vouch_user }
		</div>
	</div>
	{/if}
	<div class="module_title"><strong>账户信息公开</strong></div>
	<div class="module_border">
		<div class="w">公开我的账户资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_account" value="1" {if $_A.borrow_result.open_account==1 } checked="checked"{/if} disabled="disabled"/> <span> 如果您勾上此选项，将会实时公开您账户的：账户总额、可用余额、冻结总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的借款资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_borrow" value="1" {if $_A.borrow_result.open_borrow==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：借款总额、已还款总额、未还款总额、迟还总额、逾期总额。 </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的投标资金情况：</div>
		<div class="c">
			<input type="checkbox" name="open_tender" value="1" {if $_A.borrow_result.open_tender==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：投标总额、已收回总额、待收回总额。  </span>
		</div>
	</div>
	
	<div class="module_border">
		<div class="w">公开我的信用额度情况：</div>
		<div class="c">
			<input type="checkbox" name="open_credit" value="1" {if $_A.borrow_result.open_credit==1 } checked="checked"{/if} disabled="disabled"/> <span>如果您勾上此选项，将会实时公开您账户的：最低信用额度、最高信用额度。  </span>
		</div>
	</div>
	<div class="module_border">
		<div class="l">添加时间/IP:</div>
		<div class="c">
			{ $_A.borrow_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.borrow_result.addip}</div>
	</div>
	
	{ if $_A.borrow_result.status!=1}
	<div class="module_title"><strong>分站审核</strong></div>
	
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
		<input type="radio" name="subsite_status" value="1"/>审核通过 <input type="radio" name="subsite_status" value="2"  checked="checked"/>审核不通过 </div>
	</div>
	
	<div class="module_border" >
		<div class="l">审核意见:</div>
		<div class="c">
			<textarea name="subsite_remark" cols="45" rows="5">{ $_A.borrow_result.subsite_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.borrow_result.user_id }" />
		<input type="hidden" name="name" value="{ $_A.borrow_result.name }" />
		
		<input type="submit"  name="reset" value="提交审核意见" />
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
		 errorMsg += '备注必须填写' + '\n'; 
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
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="*" class="main_td">用户积分</td>
			<td width="*" class="main_td">发标分站</td>
			<td width="" class="main_td">借款标题</td>
			<td width="" class="main_td">借款金额</td>
			<td width="" class="main_td">利率</td>
			<td width="" class="main_td">借款期限</td>
			<td width="" class="main_td">发布时间</td>
			<td width="" class="main_td">投标进度</td>
			<td width="" class="main_td">担保进度</td>
			<td width="" class="main_td">状态</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}<input type="hidden" name="id[]" value="{ $item.id}" /></td>
			<td class="main_td1" align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}分</td>
			<td align="left">{$item.sitename}</td>
			<td title="{$item.name}" align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a>
</td>
			<td align="left">{$item.account}元</td>
			<td align="left">{$item.apr}%</td>
			<td align="left">{ if $item.isday ==1}{$item.time_limit_day}天{ else}{$item.time_limit}个月{/if}</td>
			<td align="left">{$item.addtime|date_format}</td>
			<td align="left" ><div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>{$item.scale}%</td>
			<td align="left"><div class="rate_tiao" style=" width:{$item.vouch_scale|default:0}px"></div>{$item.vouch_scale}%</td>
			<td align="left">{ if $item.status ==1}审核通过{ elseif $item.status ==0}等待审核{ elseif $item.status ==-1}<font color="#999999">尚未发布</font>{ elseif $item.status ==3}满额成功发布{ elseif $item.status ==4}满额未发布{else}审核未通过{/if} | {if $item.subsite_status==0}分站未审核{elseif $item.subsite_status==1}分站审核通过{else}<font color="#999999">分站审核不通过</font>{/if}</td>
			<td align="left">{ if $item.status ==0 }{if $_A.areaid == 0}<a href="{$_A.query_url}/view{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">审核</a>{/if}{/if} { if $item.status == 1 && $item.isontop == 1 }<a href="{$_A.query_url}/ontop{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">置顶</a>{/if} {if $_A.areaid != 0 && $item.subsite_status == 0 && $item.status ==0}<a href="{$_A.query_url}/subremark{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">审核意见</a>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="14" class="action">
		<!--
		<div class="floatl">
			<input type="submit" value="确定提交" />
		</div>
		-->
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/> 状态<select id="status" ><option value="">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>已通过</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>未通过</option></select> 
			{linkages nid="select_biao_type" value="" name="biao_type" type="value" } 
			<input type="button" value="搜索" / onclick="sousuo('{$_A.query_url}{$_A.site_url}')">
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
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="*" class="main_td" align="left">信用积分</td>
			<td width="*" class="main_td" align="left">发标分站</td>
			<td width="" class="main_td" align="left">借款标题</td>
			<td width="" class="main_td" align="left">借款金额</td>
			<td width="" class="main_td" align="left">年利率</td>
			<td width="" class="main_td" align="left">投标次数</td>
			<td width="" class="main_td" align="left">借款期限</td>
			<td width="" class="main_td" align="left">状态</td>
			<td width="" class="main_td" align="left">操作</td>
			<td width="" class="main_td" align="left">发布时间</td>
			<td width="" class="main_td" align="left">审核时间</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td align="left">{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}</td>
			<td align="left">{$item.sitename}</td>
			<!--<td title="{$item.name}">{$item.name|truncate:10}</td>-->
            <td title="{$item.name}" align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a>
			
			</td>
			<td align="left">{$item.account}元</td>
			<td align="left">{$item.apr}%</td>
			<td align="left">{$item.tender_times|default:0}</td>
			<td align="left">{if $item.isday==1 } 
                {$item.time_limit_day}天
                {else}
                {$item.time_limit}个月
                {/if}</td>
			<td align="left">{if $item.status==3}满额发布成功{elseif $item.status==4}满额发布失败{else}满标审核中{/if}</td>
			<td align="left">{if $_A.areaid==0}{if $item.status!=3}<a href="{$_A.query_url}/full_view{$_A.site_url}&user_id={$item.user_id}&id={$item.id}">审核</a>{/if}{/if}</td>
			<td align="left">{$item.addtime|date_format}</td>
			<td align="left">{$item.verify_time|date_format}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="12" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/>
			标类型：{linkages nid="select_biao_type" value="" name="biao_type" type="value" }
			<!--
			时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>
			-->
			状态<select id="status" ><option value="">全部</option><option value="3" {if $magic.request.status==3} selected="selected"{/if}>满标复审通过</option><option value="4" {if $magic.request.status=="4"} selected="selected"{/if}>满标复审失败</option></select> 
			<input type="button" value="搜索" / onclick="sousuoFull('{$_A.query_url}/full{$_A.site_url}')">
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
	<div class="module_title"><strong>已满额借款标审核</strong></div>
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$_A.borrow_result.user_id}&type=scene",500,230,"true","","true","text");'>	{$_A.borrow_result.username}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">发标分站：</div>
		<div class="c">
			{$_A.borrow_result.sitename}
		</div>
	</div>	
	<div class="module_border">
		<div class="l">标题：</div>
		<div class="c">
			{$_A.borrow_result.name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">借款金额：</div>
		<div class="h">
			￥{$_A.borrow_result.account}
		</div>
		<div class="l">年利率：</div>
		<div class="h">
			{$_A.borrow_result.apr} %
		</div>
	</div>
	<div class="module_border">
		<div class="l">借款期限：</div>
		<div class="h">
			{if $_A.borrow_result.isday==1 } 
                {$_A.borrow_result.time_limit_day}天
                {else}
                {$_A.borrow_result.time_limit}个月
                {/if}
		</div>
		<div class="l">借款用途：</div>
		<div class="h">
			{$_A.borrow_result.use|linkage}
		</div>
	</div>
	<div class="module_border">
	<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">

		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="*" class="main_td" align="left">信用积分</td>
			<td width="" class="main_td" align="left">投资金额</td>
			<td width="" class="main_td" align="left">有效金额</td>
			<td width="" class="main_td" align="left">状态</td>
			<td width="" class="main_td" align="left">投标时间</td>
		</tr>
		{ foreach  from=$_A.borrow_tender_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.credit_jifen}分</td>
			<td align="left">{$item.money}元</td>
			<td align="left"><font color="#FF0000">{$item.tender_account}元</font></td>
			<td align="left">{if $item.money == $item.tender_account}全部通过{else}部分通过{/if}</td>
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
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="" class="main_td" align="left">担保金额</td>
			<td width="" class="main_td" align="left">冻结金额</td>
			<td width="" class="main_td" align="left">状态</td>
			<td width="" class="main_td" align="left">担保时间</td>
		</tr>
		{ foreach  from=$_A.borrow_vouch_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">{$item.account}元</td>
			<td align="left"><font color="#FF0000">{$item.vouch_collection}元</font></td>
			<td align="left">{if $item.vouch_account == $item.account}全部通过{else}部分通过{/if}</td>
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
			<td width="*" class="main_td" align="left">计划还款日</td>
			<td width="*" class="main_td" align="left">预还金额</td>
			<td width="" class="main_td" align="left">本金</td>
			<td width="" class="main_td" align="left">利息</td>
		</tr>
		{ foreach  from=$_A.borrow_repayment key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $key+1}</td>
			<td  align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td align="left">￥{$item.repayment_account}</td>
			<td align="left">￥{$item.capital}</td>
			<td align="left">￥{$item.interest}元</td>
		</tr>
		{ /foreach}
</table>

	</div>
	<div class="module_title"><strong>审核意见</strong></div>
	<div class="module_border">
		<div class="l">分站审核意见：</div>
		<div class="c">
			{$_A.borrow_result.subsite_remark}
		</div>
	</div>
	<div class="module_border">
		<div class="l">初审意见：</div>
		<div class="c">
			{$_A.borrow_result.verify_remark}
		</div>
	</div>
	{ if $_A.borrow_result.status==1}
	<div class="module_title"><strong>审核此借款</strong></div>
	<form name="form1" method="post" action="" >
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
		<input type="radio" name="status" value="3"/>复审通过 <input type="radio" name="status" value="4"  checked="checked"/>复审不通过 </div>
	</div>
	
	<div class="module_border" >
		<div class="l">审核备注:</div>
		<div class="c">
			<textarea name="repayment_remark" cols="45" rows="5">{ $_A.borrow_result.repayment_remark}</textarea>
		</div>
	</div>
	<div class="module_border" >
		<div class="l">验证码:</div>
		<div class="c">
			<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.borrow_result.id }" />
		
		<input type="submit"  name="reset" value="审核此借款标" />
	</div>
	
</form>
	{/if}
	<div class="module_title"><strong>其他详细内容</strong></div>
	<div class="module_border">
		<div class="l">投标奖励：</div>
		<div class="h">
        
        {if $_A.borrow_result.award==0}
			没有奖励<br />
		{elseif  $_A.borrow_result.award==1}
			奖励金额：{$_A.borrow_result.part_account}元	
		{elseif  $_A.borrow_result.award==2}
			奖励比例：{$_A.borrow_result.funds}%		
		{/if}
		</div>
		<div class="l">投标失败是否奖励：</div>
		<div class="h">
			{if $_A.borrow_result.is_false==0}是{else}否{/if}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">添加时间：</div>
		<div class="h">
			{$_A.borrow_result.addtime|date_format:"Y-m-d H:i:s"}
		</div>
		<div class="l">招标时间：</div>
		<div class="h">
			{$_A.borrow_result.verify_time|date_format:"Y-m-d H:i:s"}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">内容：</div>
		<div class="hb">
			<table width="100%"><tr><td align="left">{$_A.borrow_result.content}</td></tr></table>
		</div>
	</div>
	
</div>
<!---已还款--->
{elseif $_A.query_type=="repayment"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">借款人</td>
			<td width="" class="main_td" align="left">借款标题</td>
			<td width="" class="main_td" align="left">期数</td>
			<td width="" class="main_td" align="left">到期时间</td>
			<td width="" class="main_td" align="left">还款金额</td>
			<td width="" class="main_td" align="left">还款时间</td>
			<td width="" class="main_td" align="left">状态</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left">{$item.username}</td>
			<td title="{$item.borrow_name}" align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
			<td align="left">{$item.order+1 }/{$item.time_limit }</td>
			<td align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td align="left">{$item.repayment_account  }元</td>
			<td align="left">{$item.repayment_yestime|date_format:"Y-m-d"|default:-}</td>
			<td align="left">{if $item.status==1}<font color="#006600">已还</font>{else}<font color="#FF0000">未还</font>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/>关键字：
			<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/><select id="status" >
			<option value="">不限</option>
			<option value="1" {if $magic.request.status==1} selected="selected"{/if}>已还</option>
			<option value="0" {if $magic.request.status==0} selected="selected"{/if}>未还</option>
			</select><input type="button" value="搜索" / onclick="sousuo('{$_A.query_url}/repayment{$_A.site_url}')">
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


<!---流标--->
{elseif $_A.query_type=="liubiao"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">借款人</td>
			<td width="*" class="main_td" align="left">发标分站</td>
			<td width="" class="main_td" align="left">借款标题</td>
			<td width="" class="main_td" align="left">借款期限</td>
			<td width="" class="main_td" align="left">借款金额</td>
			<td width="" class="main_td" align="left">已投金额</td>
			<td width="" class="main_td" align="left">开始时间</td>
			<td width="" class="main_td" align="left">结束时间</td>
			<td width="" class="main_td" align="left">状态</td>
		</tr>
		{ foreach  from=$_A.borrow_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td>{ $item.id}</td>
			<td class="main_td1"  align="left">{$item.username}</td>
			<td class="main_td1"  align="left">{$item.sitename}</td>
			<td title="{$item.borrow_name}" align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			
			<a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a></td>
			<td align="left">{$item.time_limit }个月</td>
			<td align="left">{$item.account }元</td>
			<td align="left">{$item.account_yes }元</td>
			<td align="left">{$item.verify_time|date_format:"Y-m-d"}</td>
			<td align="left">{$item.verify_time+$item.valid_time*24*60*60|date_format:"Y-m-d"}</td>
			<td align="left"><a href="{$_A.query_url}/liubiao_edit&id={$item.id}{$_A.site_url}">修改</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/>关键字：<input type="text" name="keywords" id="keywords" value="{$magic.request.keywords}"/><select id="status" >
			<option value="">不限</option>
			<option value="1" {if $magic.request.status==1} selected="selected"{/if}>已还</option>
			<option value="0" {if $magic.request.status==0} selected="selected"{/if}>未还</option>
			</select><input type="button" value="搜索" / onclick="sousuo('{$_A.query_url}/repayment{$_A.site_url}')">
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


<!--额度审核 开始-->
{elseif $_A.query_type=="liubiao_edit"}
<div class="module_title"><strong>流标管理</strong></div>
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="h">
			{$_A.borrow_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">标题：</div>
		<div >
			<a href="/invest/a{$_A.borrow_result.id}.html" target="_blank">{$_A.borrow_result.name}</a>
		</div>
	</div>
	<div class="module_border">
		<div class="l">借款额度：</div>
		<div class="h">
			{$_A.borrow_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">已借额度：</div>
		<div class="h">
			{$_A.borrow_result.account_yes}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">申请时间：</div>
		<div class="h">
			{$_A.borrow_result.verify_time|date_format}
		</div>
	</div>
	<div class="module_border">
		<div class="l">结束时间：</div>
		<div class="h">
			{$_A.borrow_result.verify_time+$_A.borrow_result.valid_time*24*60*60|date_format}
		</div>
	</div>
	<div class="module_title"><strong>审核</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">审核状态：</div>
		<div >
			<input type="radio" name="status" value="1" />流标返回金额<input type="radio" name="status" value="2" checked="checked" />延长借款期限
		</div>
	</div>
	<div class="module_border">
		<div class="l">延长天数：</div>
		<div >
			<input type="text" name="days" value="{$_A.borrow_amount_result.account}" size="5" value="0" />天
		</div>
	</div>
	
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="确定审核" />
		</div>
	</div>
	</form>

<!--额度管理 开始-->
{elseif $_A.query_type=="amount"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="" class="main_td" align="left">申请类型</td>
			<td width="" class="main_td" align="left">原来额度</td>
			<td width="" class="main_td" align="left">申请额度</td>
			<td width="" class="main_td" align="left">新额度</td>
			<td width="" class="main_td" align="left">申请时间</td>
			<td width="" class="main_td" align="left">内容</td>
			<td width="" class="main_td" align="left">备注</td>
			<td width="" class="main_td" align="left">状态</td>
			<td width="" class="main_td" align="left">操作</td>
		</tr>
		{ foreach  from=$_A.borrow_amount_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td width="80" align="left">
				{if $item.type =="tender_vouch"}<a href="{$_A.query_url}/amount&type=tender_vouch">投资担保额度</a>
				{elseif $item.type =="borrow_vouch"}<a href="{$_A.query_url}/amount&type=borrow_vouch">借款担保额度</a>
				<!-- liukun add for bug 48 begin -->
				{elseif $item.type =="restructuring"}<a href="{$_A.query_url}/amount&type=restructuring">债务重组额度</a>
				<!-- liukun add for bug 48 end -->
				{else}<a href="{$_A.query_url}/amount&type=credit">借款信用额度</a>{/if}
			</td>
			<td width="70" align="left">{$item.account_old}元</td>
			<td width="70"  align="left">{$item.account}元</td>
			<td  align="left">{$item.account_new}元</td>
			<td  align="left">{ $item.addtime|date_format}</td>
			<td  align="left">{ $item.content}</td>
			<td  align="left">{ $item.remark}</td>
			<td  width="50" align="left">{if $item.status==2}<font color="#6699CC">审核中</font>{elseif  $item.status==1} 成功 {else}<font color="#FF0000">失败</font>{/if}</td>
			<td  width="70" align="left">{if $item.status==2}<a href="{$_A.query_url}/amount_view{$_A.site_url}&id={$item.id}">审核</a> |<a href="{$_A.query_url}/amount_subsite{$_A.site_url}&id={$item.id}">分站审核{/if} </td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/> 状态<select id="status" ><option value="">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>已通过</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>未通过</option></select> <input type="button" value="搜索" / onclick="sousuo('{$_A.query_url}/amount{$_A.site_url}')">
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
<!--额度管理 结束-->


<!--逾期 开始-->
{elseif $_A.query_type=="lateFast"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">借款人</td>
			<td width="*" class="main_td" align="left">借款标题</td>
			<td width="" class="main_td" align="left">期数</td>
			<td width="" class="main_td" align="left">应还时间</td>
			<td width="" class="main_td" align="left">应还金额</td>
			<td width="" class="main_td" align="left">操作</td>
		</tr>
		{ foreach  from=$_A.borrow_repayment_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td  align="left">{ $item.username}</td>
			
			<td align="left">
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name}</a></td>
			
			<td align="left">{$item.order+1 }/{$item.time_limit}</td>
			<td  align="left">{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td  align="left">{$item.repayment_account }元</td>
			<td  align="left">{if $item.status==2}<font color="#FF0000">已代还</font>{else}{if $item.late_days>0}<a href="{$_A.query_url}/late_repay{$_A.site_url}&id={$item.id}">还款</a>{else}-{/if}{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/> 包含天标：<select name="isday" ><option value="2">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>天标</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>月标</option></select> <input type="submit" value="搜索" >
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
<!--逾期 结束-->

<!--抵押标到期 开始-->
{elseif $_A.query_type=="late"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">借款人</td>
			<td width="*" class="main_td">借款标题</td>
			<td width="" class="main_td">期数</td>
			<td width="" class="main_td">应还时间</td>
			<td width="" class="main_td">应还金额</td>
			<td width="" class="main_td">逾期天数</td>
			<td width="" class="main_td">罚金</td>
			<td width="" class="main_td">担保人已垫付额</td>
			<td width="" class="main_td">操作</td>
		</tr>
                <?php  $showtime=date("y-m-d");?>
		{ foreach  from=$_A.borrow_repayment_list key=key item=item}

		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1" align="center"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td align="left">
			
			{if $item.isurgent == 1}<span style="color:#FF0000">【加急】</span>{/if}
			{if $item.biao_type == 'credit'}<span style="color:#FF0000">【信用标】</span>{/if}
			{if $item.biao_type == 'zhouzhuan'}<span style="color:#FF0000">【周转标】</span>{/if}
			{if $item.biao_type == 'restructuring'}<span style="color:#FF0000">【债务重组标】</span>{/if}
			{if $item.biao_type == 'vouch'}<span style="color:#FF0000">【担保标】</span>{/if}
			{if $item.biao_type == 'jin'}<span style="color:#FF0000">【净值标】</span>{/if}
			{if $item.biao_type == 'miao'}<span style="color:#FF0000">【秒标】</span>{/if}
			{if $item.biao_type == 'fast'}<span style="color:#FF0000">【抵押标】</span>{/if}
			{if $item.biao_type == 'pledge'}<span style="color:#FF0000">【质押标】</span>{/if}
			{if $item.biao_type == 'love'}<span style="color:#FF0000">【爱心标】</span>{/if}
			{if $item.biao_type == 'circulation'}<span style="color:#FF0000">【流转标】</span>{/if}
			
			<a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name}</a></td>
			<td>{$item.order+1 }/{$item.time_limit}</td>
			<td >{$item.repayment_time|date_format:"Y-m-d"}</td>
			<td >{$item.repayment_account|default:0}元</td>
			<td >{$item.late_days|default:0}天</td>
			<td >{$item.late_interest|default:0}</td>
			<td >{if $item.biao_type == 'vouch' || $item.biao_type == 'restructuring'}{$item.vouch_advance|default:0}{else}-{/if}</td>
			<td >{if $item.status==2}<font color="#FF0000">已代还</font>{else}{if $item.late_days>=0}<a href="{$_A.query_url}/late_repay{$_A.site_url}&id={$item.id}" onclick="return confirm('确定要垫付吗？')">还款</a>{else}-{/if}{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">

		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username}"/> 包含天标：<select name="isday" ><option value="2">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>天标</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>月标</option></select> <input type="submit" value="搜索" >
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
<!--抵押标到期 结束-->

<!--额度审核 开始-->
{elseif $_A.query_type=="amount_view"}
<div class="module_title"><strong>额度审核</strong></div>
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="h">
			{$_A.borrow_amount_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">额度类型：</div>
		<div class="h">
			{if $_A.borrow_amount_result.type=="tender_vouch"}<font color="#FF0000">投资担保额度</font>{elseif $_A.borrow_amount_result.type=="borrow_vouch"}<font color="#FF0000">借款担保额度</font>{elseif $_A.borrow_amount_result.type=="restructuring"}<font color="#FF0000">债务重组额度</font>{else}<font color="#FF0000">信用额度</font>{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">原来额度：</div>
		<div class="h">
			{$_A.borrow_amount_result.account_old|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">申请额度：</div>
		<div class="h">
			{$_A.borrow_amount_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">内容：</div>
		<div class="h">
			{$_A.borrow_amount_result.content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="h">
			{$_A.borrow_amount_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">申请时间：</div>
		<div class="h">
			{$_A.borrow_amount_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>分站审核</strong></div>
	<div class="module_border">
		<div class="l">分站审核意见：</div>
		<div class="h">
			{$_A.borrow_amount_result.subsite_remark}
		</div>
	</div>
	<div class="module_title"><strong>审核</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">审核状态：</div>
		<div class="h">
			<input type="radio" name="status" value="1" />通过  <input type="radio" name="status" value="0" checked="checked" />不通过
		</div>
	</div>
	<div class="module_border">
		<div class="l">通过额度：</div>
		<div class="h">
			<input type="text" name="account" value="{$_A.borrow_amount_result.account}" />
			<input type="hidden" name="type" value="{ $_A.borrow_amount_result.type}" />
		</div>
	</div>

	<div class="module_border">
		<div class="l">审核备注：</div>
		<div class="h">
			<textarea name="verify_remark" rows="5" cols="40" ></textarea>
		</div>
	</div>
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="确定审核" />
		</div>
	</div>
	</form>

{elseif $_A.query_type=="amount_subsite"}
<div class="module_title"><strong>额度审核</strong></div>
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="h">
			{$_A.borrow_amount_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">额度类型：</div>
		<div class="h">
			{if $_A.borrow_amount_result.type=="tender_vouch"}<font color="#FF0000">投资担保额度</font>{elseif $_A.borrow_amount_result.type=="borrow_vouch"}<font color="#FF0000">借款担保额度</font>{else}信用额度{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">原来额度：</div>
		<div class="h">
			{$_A.borrow_amount_result.account_old|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">申请额度：</div>
		<div class="h">
			{$_A.borrow_amount_result.account}
		</div>
	</div>
	<div class="module_border">
		<div class="l">内容：</div>
		<div class="h">
			{$_A.borrow_amount_result.content}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="h">
			{$_A.borrow_amount_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">申请时间：</div>
		<div class="h">
			{$_A.borrow_amount_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>审核</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">分站审核意见：</div>
		<div class="h">
			<textarea name="subsite_remark" rows="5" cols="40" >{$_A.borrow_amount_result.subsite_remark}</textarea>
		</div>
	</div>
	<div class="module_border">
		<div class="l"></div>
		<div class="h">
			<input type="submit" value="提交" />
		</div>
	</div>
	</form>

<!--统计 开始-->
{elseif $_A.query_type=="tongji"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="*" class="main_td">类型</td>
			<td width="*" class="main_td">总额</td>
		</tr>
		<tr  class="tr2">
			<td >成功借出总额</td>
			<td >￥{$_A.borrow_tongji.success_num}</td>
		</tr>
		<tr  >
			<td >己还款总额</td>
			<td >￥{$_A.borrow_tongji.success_num1}</td>
		</tr>
		<tr  class="tr2">
			<td >未还款总额</td>
			<td >￥{$_A.borrow_tongji.success_num0}</td>
		</tr>
		<tr  >
			<td >逾期总额</td>
			<td >{$_A.borrow_tongji.laterepay}</td>
		</tr>
		<tr  class="tr2">
			<td >逾期己还款总额</td>
			<td >￥{$_A.borrow_tongji.success_laterepay}</td>
		</tr>
		<tr >
			<td >逾期未还款总额</td>
			<td >￥{$_A.borrow_tongji.false_laterepay}</td>
			
		</tr>
		
	</form>	
</table>
<!--统计 结束-->

<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
	  {foreach from="$_A.account_tongji" key=key  item="item"}
		<tr >
			<td width="*" class="main_td">类型名称</td>
			<td width="*" class="main_td">{$key}</td>
			<td width="" class="main_td">金额</td>
		</tr>
		{foreach from="$item" key="_key" item="_item"}
		<tr  class="tr2">
			<td >{$_item.type_name}</td>
			<td >{$_item.type}</td>
			<td >￥{$_item.num}</td>
		</tr>
		{/foreach}
	{/foreach}
	</form>	
</table>
<!--统计 结束-->
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