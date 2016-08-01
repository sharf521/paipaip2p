{if $_A.query_type == "new" || $_A.query_type == "edit"}


{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">用户名</td>
			<td width="*" class="main_td">所属分站</td>
			<td width="" class="main_td">真实姓名</td>
			<td width="" class="main_td">总余额</td>
			<td width="" class="main_td">可用余额</td>
			<td width="" class="main_td">冻结金额</td>
			<td width="" class="main_td">待收金额</td>
                        <td width="" class="main_td">待还金额</td>
                        <td width="" class="main_td">净资产</td>
		</tr>
		{ foreach  from=$_A.account_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.sitename}</td>
			<td >{$item.realname}</td>
			<td >{$item.total|default:0}</td>
			<td >{$item.use_money|default:0}</td>
			<td >{$item.no_use_money|default:0}</td>
			<td >{$item.collection|default:0}</td>
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                        <td >
                        {$acc.wait_payment|default:0}
                        </td>
                        <td >
                        {$acc.jinAmount|default:0}
                        </td>
                        {/article}
                         
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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




{elseif $_A.query_type=="ticheng"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">时间</td>
			<td width="*" class="main_td">用户名</td>
			<td width="" class="main_td">好友投资总额(月)</td>
		</tr>
		{ foreach  from=$_A.account_ticheng key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.addtimes}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.usernames}
                        </td>
			<td >{$item.money}</td>
			
			
		</tr>
		{ /foreach}
		<tr>
		<td colspan="4" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}/ticheng&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="4" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>        




        
{elseif $_A.query_type=="vipTC"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">推广者用户名</td>	
                         <td width="" class="main_td">下线用户名</td>
			<td width="*" class="main_td">真实姓名</td>
			<td width="" class="main_td">注册时间</td>
			<td width="" class="main_td">提成收入列表</td>

		</tr>
		{foreach  from=$_A.vipTC_list key=key item=item}
		<tr >
                                        <td>{$item.inviteUserName}</td>			
                                         <td>{$item.username}</td>
                                        <td>{$item.realname}</td>
					<td>{$item.addtime|date_format}</td>
                                        <td><a href="{$_A.query_url}/tcList&a=cash&username2={$item.username}">点击查看</a></td>
		</tr>
		{/foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			介绍人用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        下线人用户名：<input type="text" name="username2" id="username2" value="{$magic.request.username2|urldecode}"/>
                        <input type="button" value="搜索" onclick="sousuo()">
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
{elseif $_A.query_type=="tcList"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">推广者用户名</td>	
                         <td width="" class="main_td">下线用户名</td>
			<td width="*" class="main_td">真实姓名</td>
			<td width="*" class="main_td">提成类型</td>
			<td width="" class="main_td">支付时间</td>
			<td width="" class="main_td">提成收入</td>

		</tr>
		{foreach  from=$_A.tichen_list key=key item=item}
		<tr >
                                        <td>{$item.invite_username}</td>			
                                         <td>{$item.username}</td>
                                        <td>{$item.realname}</td>
                                        <td>{$item.remark}</td>
					<td>{$item.addtime|date_format}</td>
                                        <td>{$item.money}元</td>
		</tr>
		{/foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			介绍人用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        下线人用户名：<input type="text" name="username2" id="username2" value="{$magic.request.username2|urldecode}"/>
                        <input type="button" value="搜索" onclick="sousuo()">
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

{elseif $_A.query_type=="moneyCheck"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
                        <td width="" class="main_td">用户名</td>	
			<!--<td width="*" class="main_td">真实姓名</td>-->
			<td width="" class="main_td">资金总额</td>
			<td width="" class="main_td">可用资金</td>
			<td width="" class="main_td">冻结资金</td>
			<td width="" class="main_td">待收资金(1)</td>
                        <td width="" class="main_td">待收资金(2)</td>
                        <td width="" class="main_td">充值资金(1)</td>
                        <td width="" class="main_td">充值资金(2)</td>
                        <td width="" class="main_td">其中：线上</td>
                        <td width="" class="main_td">其中：线下1</td>
                        <td width="" class="main_td">其中：线下2</td>
                        <td width="" class="main_td">成功提现金额</td>
                        <td width="" class="main_td">提现实际到账</td>
                        <td width="" class="main_td">提现费用</td>
                        <td width="" class="main_td">投标奖励金额</td>
                        <td width="" class="main_td">投标已收资金</td>
                        <td width="" class="main_td">投标已收利息</td>
                        <td width="" class="main_td">投标待收利息</td>
                        <td width="" class="main_td">借款总金额</td>
                        <td width="" class="main_td">借款标奖励</td>
                        <td width="" class="main_td">借款管理费</td>
                        <td width="" class="main_td">待还本金</td>
                        <td width="" class="main_td">待还利息</td>
                        <td width="" class="main_td">借款已还利息</td>
                        <td width="" class="main_td">系统扣费</td>
                        <td width="" class="main_td">推广奖励</td>
                        <td width="" class="main_td">VIP扣费</td>
                        <td width="" class="main_td">资金总额1</td>
                        <td width="" class="main_td">资金总额2</td>

		</tr>
		{foreach  from=$_A.moneyCheck_list key=key item=item}
		<tr >
                                        <td>{$item.username}</td>
                                        <!--<td>{$item.realname}</td>-->
                                        <td>{$item.total}</td>
                                        <td>{$item.use_money}</td>
                                        <td>{$item.no_use_money}</td>
                                        <td>{$item.collection}</td>
                                        <td>{$item.collection2}</td>
                                        <td>{$item.reMoney}</td>
                                        <td>{$item.reMoney2}</td>
                                        <td>{$item.reMoney_1}</td>
                                        <td>{$item.reMoney_2}</td>
                                        <td>{$item.reMoney_3}</td>
                                        <td>{$item.txTotal}</td>
                                        <td>{$item.txCredited}</td>
                                        <td>{$item.txFee}</td>
                                        <td>{$item.awardAdd}</td>
                                        <td>{$item.collecdMoney}</td>
                                        <td>{$item.interestYes}</td>
                                        <td>{$item.interestWait}</td>
                                        <td>{$item.accountBorrow}</td>
                                        <td>{$item.borrowAward}</td>
                                        <td>{$item.borrowMgrFee}</td>
                                        <td>{$item.waitMoney_money}</td>
                                        <td>{$item.waitMoney_interest}</td>
                                        <td>
 <script>
     document.write({$item.repayment_yesaccount|default:0});
</script>
                                            </td>
                                        <td>{$item.feeSystem}</td>
                                        <td>{$item.invite_money}</td>
                                        <td>{$item.vipMoney}</td>
                                        <td>{$item.total1}</td>
                                        <td>{$item.total2}</td>
                                         
		</tr>
		{/foreach}
		<tr>
		<td colspan="24" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}/moneyCheck&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>
                        <input type="button" value="搜索" onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="24" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>  
                        
{elseif $_A.query_type=="cashCK"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">用户名</td>
			<td width="" class="main_td">真实姓名</td>
			<td width="" class="main_td">投资担保额度</td>
			<td width="" class="main_td">使用的信用额度（X）</td>
			<td width="" class="main_td">净资产(W)</td>
			<td width="" class="main_td">待收利息(E)</td>
                        <td width="" class="main_td">提现标准（W+1.1X-E）</td>
		</tr>
		{ foreach  from=$_A.account_cashCK_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td>
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.tender_vouch|default:0}</td>
			<td >
                        
                         <script>
                             document.write({$item.credit|default:0}-{$item.credit_use|default:0}+{$item.borrow_vouch|default:0}-{$item.borrow_vouch_use|default:0});
                         </script>
                         
                        </td>
			<td >
                            
                            {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                            <script>
                                document.write({$item.total|default:0}-{$acc.wait_payment|default:0});
                            </script>

                            {/article}
                            
                        </td>
			<td >
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
                            {$acc.collection_interest0|default:0}
                                                       
                        {/article}
                        </td>
                         <td >
                        {article module="borrow" function="GetUserLog" user_id=$item.user_id var="acc"}
          
                       
                        
                         <script>
                             document.write({$item.credit|default:0}*1.1-{$item.credit_use|default:0}*1.1+{$item.borrow_vouch|default:0}*1.1-{$item.borrow_vouch_use|default:0}*1.1+{$item.total|default:0}-{$acc.wait_payment|default:0}-{$acc.collection_interest0|default:0});
                         </script>
                        
                        {/article}
                        </td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
                   
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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
                        
<!--提现记录列表 开始-->
{elseif $_A.query_type=="cash"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">用户名称</td>
			<td width="*" class="main_td">真实姓名</td>
			<td width="" class="main_td">提现账号</td>
			<td width="" class="main_td">提现银行</td>
			<td width="" class="main_td">支行</td>
			<td width="" class="main_td">提现总额</td>
			<td width="" class="main_td">到账金额</td>
			<td width="" class="main_td">手续费</td>
			<!--<td width="" class="main_td">红包抵扣</td>-->
			<td width="" class="main_td">提现时间</td>
			<td width="" class="main_td">状态</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.account_cash_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/cash&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.realname}</td>
			<td >{ $item.account}</td>
			<td >{ $item.bank_name}</td>
			<td >{ $item.branch}</td>
			<td >{ $item.total}</td>
			<td >{ $item.credited}</td>
			<td >{ $item.fee}</td>	
			<!--<td >{ $item.hongbao}</td>-->
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td >{if $item.status==0}审核中{elseif  $item.status==1} 已通过 {elseif $item.status==2}被拒绝{/if}</td>
			<td ><a href="{$_A.query_url}/cash_view{$_A.site_url}&id={$item.id}">审核/查看</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
                    <A href="?{$_A.query_string}&type=excel">导出当前报表</A>

		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> 状态<select id="status" ><option value="">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>已通过</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>未通过</option></select> <input type="button" value="搜索" / onclick="sousuo()">
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
<!--提现记录列表 结束-->


<!--提现审核 开始-->
{elseif $_A.query_type == "cash_view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>提现审核/查看</strong></div>

	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			{ $_A.account_cash_result.username}
		</div>
	</div>

	<div class="module_border">
		<div class="l">提现银行：</div>
		<div class="c">
			{ $_A.account_cash_result.bank_name }
		</div>
	</div>

	<div class="module_border">
		<div class="l">提现支行：</div>
		<div class="c">
			{ $_A.account_cash_result.branch }
		</div>
	</div>

	<div class="module_border">
		<div class="l">提现账号：</div>
		<div class="c">
			{ $_A.account_cash_result.account }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">提现总额：</div>
		<div class="c">
			{ $_A.account_cash_result.total }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">到账金额：</div>
		<div class="c">
			{ $_A.account_cash_result.credited }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">费率：</div>
		<div class="c">
			{ $_A.account_cash_result.fee }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">状态：</div>
		<div class="c">
		{if $_A.account_cash_result.status==0}提现审核中{elseif  $_A.account_cash_result.status==1} 提现已通过 {elseif $_A.account_cash_result.status==2}提现被拒绝{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">添加时间/IP:</div>
		<div class="c">
			{ $_A.account_cash_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.account_cash_result.addip}</div>
	</div>
	
	{if $_A.account_cash_result.status==0}
	<div class="module_title"><strong>审核此提现信息</strong></div>
	
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
		<input type="radio" name="status" value="1" />审核通过 <input type="radio" name="status" value="2"/>审核不通过 </div>
	</div>
	
	<div class="module_border" >
		<div class="l">提现手续费:</div>
		<div class="c">
			<input type="text" name="fee" value="{ $_A.account_cash_result.fee}" size="5">
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">审核备注:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.account_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.account_cash_result.id }" />
		<input type="hidden" name="user_id" value="{ $_A.account_cash_result.user_id }" />
		<input type="submit"  name="reset" value="审核此提现信息" />
	</div>
	{else}
	<div class="module_border">
		<div class="l">审核信息：</div>
		<div class="c">
			审核人：{ $_A.account_cash_result.verify_username },审核时间：{ $_A.account_cash_result.verify_time|date_format:"Y-m-d H:i" },审核备注：{ $_A.account_cash_result.verify_remark}
		</div>
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
	 if(frm.elements['status'][0].checked==false && frm.elements['status'][1].checked==false)
	 {
		 errorMsg += '请选择审核状态！' + '\n';			
	 }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}


<!--充值记录列表 开始-->
{elseif $_A.query_type=="recharge"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
                        <td width="*" class="main_td">流水号</td>
			<td width="*" class="main_td">用户名称</td>
			<td width="*" class="main_td">真实姓名</td>
			<td width="" class="main_td">类型</td>
			<td width="" class="main_td">所属银行</td>
			<td width="" class="main_td">充值金额</td>
			<td width="" class="main_td">费用</td>
			<td width="" class="main_td">到账金额</td>
			<!--<td width="" class="main_td">奖励红包</td>-->
			<td width="" class="main_td">充值奖励</td>
			<td width="" class="main_td">充值时间</td>
			<td width="" class="main_td">状态</td>
			<td width="" class="main_td">银行返回</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.account_recharge_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
                        <td >{ $item.trade_no}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.realname}</td>
			<td >{ if $item.type==1}网上充值{else}线下充值{/if}</td>
			<td >{if $item.payment==0}手动充值{else}{ $item.payment_name}{/if}</td>
			<td >{ $item.money}元</td>
			<td >{ $item.fee}元</td>
			<td ><font color="#FF0000">{$item.total}元</font></td>
			<!--<td >{ $item.hongbao}元</td>-->
			<td >{ $item.award}元</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td >{if $item.status==0 || $item.status== -1 }<font color="#6699CC">审核</font>{elseif  $item.status==1} 成功 {else}<font color="#FF0000">失败</font>{/if}</td>
               <td >{  if $item.return==""&& $item.type==1  }<span style="color:#F00">线上未到帐</span>{elseif $item.return<>""&& $item.type==1} 线上已到账{else}线下核对{/if}</td>

			<td ><a href="{$_A.query_url}/recharge_view{$_A.site_url}&id={$item.id}">审核/查看</a></td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		 <A href="?{$_A.query_string}&type=excel">导出当前报表</A>
		</div>
		<div class="floatr">
		充值时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>	
                    用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> 状态<select id="status" ><option value="-1" {if $magic.request.status=="-1"} selected="selected"{/if}>未审核</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>审核成功</option><option value="2" {if $magic.request.status=="2"} selected="selected"{/if}>审核失败</option></select> <input type="button" value="搜索" / onclick="sousuo()">
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
<!--充值记录列表 结束-->
<!--提现审核 开始-->
{elseif $_A.query_type == "recharge_view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>充值查看</strong></div>

	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			<!--
			<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.query_url}/view&user_id={$_A.account_recharge_result.user_id}&type=scene",500,230,"true","","true","text");'></a>
			-->
			{ $_A.account_recharge_result.username}
		</div>
	</div>

	<div class="module_border">
		<div class="l">充值类型：</div>
		<div class="c">
			{if $_A.account_recharge_result.type==1}网上充值{else}线下充值{/if}
		</div>
	</div>

	<div class="module_border">
		<div class="l">支付方式：</div>
		<div class="c">
			{ $_A.account_recharge_result.payment_name}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">充值总额：</div>
		<div class="c">
			{ $_A.account_recharge_result.money }元
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">费用：</div>
		<div class="c">
			{ $_A.account_recharge_result.fee }元
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">实际到账：</div>
		<div class="c">
			{ $_A.account_recharge_result.total }元
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">用户备注：</div>
		<div class="c">
		{ $_A.account_recharge_result.remark }
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">流水号：</div>
		<div class="c">
		{ $_A.account_recharge_result.remark }
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">状态：</div>
		<div class="c">
		{if $_A.account_recharge_result.status==0}等待审核{elseif  $_A.account_recharge_result.status==1} 充值成功 {elseif $_A.account_recharge_result.status==2}充值失败{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">添加时间/IP:</div>
		<div class="c">
			{ $_A.account_recharge_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.account_recharge_result.addip}</div>
	</div>
	
	{if $_A.account_recharge_result.status==0  }
	<div class="module_title"><strong>审核此充值信息</strong></div>
	
	<div class="module_border">
		<div class="l">状态:</div>
		<div class="c">
	<input type="radio" name="status" value="1"/>充值成功   <input type="radio" name="status" value="2"  checked="checked"/>充值失败 </div>
	</div>
	
	<div class="module_border" >
		<div class="l">到账金额:</div>
		<div class="c">
			<input type="text" name="total" value="{ $_A.account_recharge_result.total }" size="15" readonly="">（一旦审核通过将不可再进行修改）
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">审核备注:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.account_recharge_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.account_recharge_result.id }" />
		
		<input type="submit"  name="reset" value="审核此充值信息" />
	</div>
	{else}
		{if $_A.account_recharge_result.type==2 }
	<div class="module_border">
		<div class="l">审核信息：</div>
		<div class="c">
			审核人：{ $_A.account_result.verify_username },审核时间：{ $_A.account_result.verify_time|date_format:"Y-m-d H:i" },审核备注：{ $_A.account_result.verify_remark}
		</div>
	</div>
	{/if}
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



<!--添加充值记录 开始-->
{elseif $_A.query_type == "recharge_new"}

<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>添加充值</strong></div>

	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			<input type="text" name="username" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">类型：</div>
		<div class="c">
			线下充值<input type="hidden" name="type" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">金额：</div>
		<div class="c">
			<input type="text" name="money" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="c">
			<input type="text" name="remark" />
		</div>
	</div>
	
	<div class="module_submit" >
		
		<input type="submit"  name="reset" value="确认充值" />
	</div>
</form>
</div>

<!--添加充值记录 结束-->




<!--添加充值记录 开始-->
{elseif $_A.query_type == "deduct"}

<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>费用扣除</strong></div>

	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="c">
			<input type="text" name="username" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">类型：</div>
		<div class="c">
			<select name="type">
				<!--
				<option value="scene_account">现场认证费用</option>
				<option value="vouch_advanced">担保垫付扣费</option>
				<option value="borrow_kouhui">借款人罚金扣回</option>
				-->
				<option value="account_other">其他</option>
			</select>
		</div>
	</div>
	<div class="module_border">
		<div class="l">金额：</div>
		<div class="c">
			<input type="text" name="money" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="c">
			<input type="text" name="remark" />比如，现场费用扣除200元
		</div>
	</div>
	<div class="module_border">
		<div class="l">验证码：</div>
		<div class="c"><input  class="user_aciton_input"  name="valicode" type="text" size="8" maxlength="4" style=" padding-top:4px; height:16px; width:70px;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
		</div>
	</div>
	<div class="module_submit" >
		
		<input type="submit"  name="reset" value="确定扣除" />
	</div>
</form>
</div>

<!--添加充值记录 结束-->

<!--资金使用记录列表 开始-->
{elseif $_A.query_type=="log"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">用户名称</td>
			<td width="" class="main_td">类型</td>
			<td width="" class="main_td">总金额</td>
			<td width="" class="main_td">操作金额</td>
			<td width="" class="main_td">可用金额</td>
			<td width="" class="main_td">冻结金额</td>
			<td width="" class="main_td">待收金额</td>
			<td width="" class="main_td">交易对方</td>
			<td width="" class="main_td">记录时间</td>
            <td width="" class="main_td">备注</td>
            <td width="" class="main_td">记录分站</td>
            <td width="" class="main_td">相关借款标</td>
		</tr>
		{ foreach  from=$_A.account_log_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			<td >{ $item.use_money}</td>
			<td >{ $item.no_use_money|default:0}</td>
			<td >{ $item.collection|default:0}</td>
			<td >{ $item.to_username|default:admin}</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            <td >{ $item.sitename}</td>
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">导出当前报表</A>
		</div>
		<div class="floatr">
			时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="全部" } 用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> 状态<select id="status" ><option value="">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>已通过</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>未通过</option></select> <input type="button" value="搜索" / onclick="sousuo()">
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
<!--资金使用记录列表 结束-->

<!--分站资金列表 开始-->
{elseif $_A.query_type=="site"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">网站名称</td>
			<td width="" class="main_td">域名</td>
			<td width="" class="main_td">总金额</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.subsite_money key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td>{$item.sitename}</td>
			<td align="left">{ $item.website}</td>
			<td >{ $item.jiesuan_money}</td>
            <td ><a href="{$_A.query_url}/site_changemoney&subsite_id={$item.id}&a=cash">更改保证金</a>&nbsp;&nbsp;
            <a href="{$_A.query_url}/site_moneylog&subsite_id={$item.id}&a=cash">查看记录</a>
            </td>
		</tr>
		{ /foreach}
 		</form>
 </table>
{elseif $_A.query_type=="site_moneylog"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
            <td width="" class="main_td">记录分站</td>
			<td width="*" class="main_td">用户名称</td>
			<td width="" class="main_td">类型</td>
			<td width="" class="main_td">总金额</td>
			<td width="" class="main_td">操作金额</td>

			<td width="" class="main_td">记录时间</td>
            <td width="" class="main_td">备注</td>
            
            <td width="" class="main_td">相关借款标</td>
		</tr>
		{ foreach  from=$_A.subsite_moneylog key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
            <td >{ $item.sitename}</td>
			<td><a href="{$_A.query_url}/log&a=cash&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">导出当前报表</A>
		</div>
		<div class="floatr">
        共计：{$_A.account}元&nbsp;&nbsp;
			时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>  
         <select name="subsite_id" id="subsite_id">
         <option value="">全部</option>
        {foreach  from=$_A.subsite_money key=key item=item}
		<option value="{$item.id}" {if $magic.request.subsite_id== $item.id}selected{/if}>{$item.sitename}</option>
		{/foreach}
        </select>
             
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="全部" } 用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>  <input type="button" value="搜索" / onclick="sousuo()">
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

{elseif $_A.query_type=="site_changemoney"}
<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data">
	<div class="module_title"><strong>添加保证金</strong></div>

	<div class="module_border">
		<div class="l">分站名称：</div>
		<div class="c">
			{$_A.subsite_name}
            <input type="hidden" name="subsite_id" value="{$magic.request.subsite_id}">
		</div>
	</div>
	<div class="module_border">
		<div class="l">类型：</div>
		<div class="c">
			<input type="radio" name="type" checked="checked" value="1">添加保证金
            <input type="radio" name="type" value="2">减少保证金
		</div>
	</div>
	<div class="module_border">
		<div class="l">金额：</div>
		<div class="c">
			<input type="text" name="money">
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="c">
            <textarea cols="30" rows="3" name="remark"></textarea>
		</div>
	</div>
	<div class="module_submit">
		<input type="submit" name="reset" value="确认添加">
	</div>
</form>


<!--分站资金列表 结束-->


<!--资金使用记录列表 开始-->
{elseif $_A.query_type=="logtender"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td">用户名称</td>
			<td width="" class="main_td">类型</td>
			<td width="" class="main_td">总金额</td>
			<td width="" class="main_td">操作金额</td>
			<td width="" class="main_td">可用金额</td>
			<td width="" class="main_td">冻结金额</td>
			<td width="" class="main_td">待收金额</td>
			<td width="" class="main_td">交易对方</td>
			<td width="" class="main_td">记录时间</td>
            <td width="" class="main_td">备注</td>
            <td width="" class="main_td">记录分站</td>
            <td width="" class="main_td">相关借款标</td>
		</tr>
		{ foreach  from=$_A.account_log_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td><a href="{$_A.query_url}/recharge&username={$item.username}">{$item.username}</a></td>
			<td >{ $item.type|linkage:"account_type"}</td>
			<td >{ $item.total}</td>
			<td >{ $item.money}</td>
			<td >{ $item.use_money}</td>
			<td >{ $item.no_use_money|default:0}</td>
			<td >{ $item.collection|default:0}</td>
			<td >{ $item.to_username|default:admin}</td>
			<td >{ $item.addtime|date_format:"Y-m-d H:i"}</td>
            <td >{ $item.remark}</td>
            <td >{ $item.sitename}</td>
            <td >{ $item.borrow_name}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
<A href="?{$_A.query_string}&typeaction=excel">导出当前报表</A>
		</div>
		<div class="floatr">
			时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>
			分站：<select name="subsite_id" id="subsite_id">
			{foreach from=$_A.subsite_list item=item}
			<option  value="{ $item.id}" {if $item.id==$magic.request.subsite_id} selected="selected"{/if} />{ $item.sitename}</option>
			
			{/foreach}
			</select>   
		 用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/>  <input type="button" value="搜索" / onclick="sousuo()">
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
<!--资金使用记录列表 结束-->

{elseif $_A.query_type=="wsfl_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">用户ID</td>
			<td width="" class="main_td">ProcessID</td>
			<td width="*" class="main_td">用户名</td>
			<td width="" class="main_td">真实姓名</td>
			<td width="" class="main_td">返利积分</td>
			<td width="" class="main_td">返利金额</td>
			<td width="" class="main_td">返利状态</td>
			<td width="" class="main_td">webservice user_id</td>
			<td width="" class="main_td">返利时间</td>
		</tr>
		{ foreach  from=$_A.wsfl_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td >{ $item.process_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.mony}</td>
			<td >{$item.loaner_money|default:0}</td>
			<td >{if $item.process==0}未入帐{else}已入帐{/if}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.fl_time}</td>
                       
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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

{elseif $_A.query_type=="wsfl_get_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">用户ID</td>
			<td width="" class="main_td">ProcessID</td>
			<td width="*" class="main_td">用户名</td>
			<td width="" class="main_td">真实姓名</td>
			<td width="" class="main_td">返利积分</td>
			<td width="" class="main_td">返利金额</td>
			<td width="" class="main_td">返利状态</td>
			<td width="" class="main_td">webservice user_id</td>
			<td width="" class="main_td">返利时间</td>
		</tr>
		{ foreach  from=$_A.wsfl_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.user_id}</td>
			<td >{ $item.process_id}</td>
			<td><!--<a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?index.php?admin&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'></a>-->
                        {$item.username}
                        </td>
			<td >{$item.realname}</td>
			<td >{$item.mony}</td>
			<td >{$item.loaner_money|default:0}</td>
			<td >{if $item.process==0}未入帐{else}已入帐{/if}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.fl_time}</td>
                       
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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

{elseif $_A.query_type=="wsfl_cash_report"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">处理日期</td>
			<td width="" class="main_td">返利积分总和</td>
			<td width="" class="main_td">返利金额总和</td>
			<td width="" class="main_td">处理状态</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.wsfl_cash_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.fl_time}</td>
			<td >{$item.total_mony|default:0}</td>
			<td >{$item.total_loaner_money|default:0}</td>
			<td >{if $item.process==0}未入帐{else}已入帐{/if}</td>
			<td >{if $item.process==0}<a href="{$_A.query_url}/wsfl_cash{$_A.site_url}&fl_time={$item.fl_time}">返利入帐</a>{/if}</td>                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="导出列表" />
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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

{elseif $_A.query_type=="wsfl_queue_list" || $_A.query_type=="wsfl_queue_query" || $_A.query_type=="wsfl_queue_close"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">用户ID</td>
			<td width="" class="main_td">用户名</td>
			<td width="" class="main_td">真实姓名</td>
			<td width="" class="main_td">webservice userid</td>
			<td width="" class="main_td">队列ID</td>
			<td width="" class="main_td">缴纳</td>
			<td width="" class="main_td">应该返还</td>
			<td width="" class="main_td">已经返还</td>
			<td width="" class="main_td">状态</td>
			<td width="" class="main_td">操作</td>
		</tr>
		{ foreach  from=$_A.wsfl_queue_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.user_id}</td>
			<td >{$item.username}</td>
			<td >{$item.realname}</td>
			<td >{$item.ws_user_id}</td>
			<td >{$item.ws_queue_id}</td>
			<td >{$item.out_money|default:0}</td>
			<td >{$item.in_should_money|default:0}</td>
			<td >{$item.in_ed_money|default:0}</td>
			<td >{if $item.status==0}正常{else}关闭{/if}</td>
			<td ><a href="{$_A.query_url}/wsfl_queue_close{$_A.site_url}&id={$item.ws_queue_id}">结束队列</a> | <a href="{$_A.query_url}/wsfl_queue_query{$_A.site_url}&id={$item.ws_queue_id}">查询返还积分</a></td>                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		<input type="button" onclick="javascript:location.href='{$_A.query_url}&type=excel'" value="导出列表" />
        <input type="button" value="计算返利" onclick="javascript:location.href='{$_A.query_url}/wsfl_queue_call';this.disabled = true;"/>
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> <input type="button" value="搜索" onclick="sousuo()">
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

{elseif $_A.query_type=="wsfl_rebate_list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">用户ID</td>
			<td width="" class="main_td">用户名</td>
			<td width="" class="main_td">加入时间</td>
			<td width="" class="main_td">webservice userid</td>
			<td width="" class="main_td">队列ID</td>
            <td width="" class="main_td">类型</td>
			<td width="" class="main_td">缴纳</td>
			<td width="" class="main_td">应该返还</td>
			<td width="" class="main_td">已经返还</td>
			<td width="" class="main_td">状态</td>
            <td width="" class="main_td">结束时间</td>
            
		</tr>
		{ foreach  from=$_A.wsfl_rebate_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{$item.user_id}</td>
			<td >{$item.user_name}</td>
			<td >{$item.addtime}</td>
			<td >{$item.web_id}</td>
			<td >{$item.listid}</td>
            <td >{$item.type}</td>
			<td >{$item.inmoney|default:0}</td>
			<td >{$item.money|default:0}</td>
			<td >{$item.RebatesMoney|default:0}</td>
			<td >{$item.RebatesStatus}</td>
            <td >{$item.Aside4}</td>
			                        
		</tr>
		{ /foreach}
		<tr>
		<td colspan="10" class="action">
		<div class="floatl">
		
        <input type="button" value="计算返利" onclick="javascript:location.href='{$_A.query_url}/wsfl_queue_call';this.disabled = true;"/>
		</div>
		
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
            {literal}
            <style type="text/css">
.p_bar {
clear:both;
margin:15px 0;
}
.p_bar a {
font-size:12px;
text-decoration:none;
padding:2px 5px;
}
.p_bar a:hover {
background:#F5FBFF;
border:1px solid #86B9D6;
text-decoration:none;
}
.p_info {
background:#F5FBFF;
border:1px solid #86B9D6;
margin-right:1px;
padding:2px 5px;
}
.p_num {
background:#FFF;
border:1px solid #DEDEB8;
margin-right:1px;
}
.p_redirect {
background:#FFF;
border:1px solid #DEDEB8;
margin-right:1px;
font-weight:700;
font-size:12px;
}
.p_curpage {
margin-right:1px;
border:1px solid #DEDEB8;
background:#FFFFD9;
color:#92A05A;
font-weight:700;
padding:2px 5px;
}
			</style>{/literal}
			{$_A.page1} 
			</td>
		</tr>
	</form>	
</table>

<!--额度管理 开始-->
{elseif $_A.query_type=="stock"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="" class="main_td">ID</td>
			<td width="*" class="main_td" align="left">用户名称</td>
			<td width="" class="main_td" align="left">申请类型</td>
			<td width="" class="main_td" align="left">申请数量</td>
			<td width="" class="main_td" align="left">交易金额</td>
			<td width="" class="main_td" align="left">申请时间</td>
			<td width="" class="main_td" align="left">备注</td>
			<td width="" class="main_td" align="left">状态</td>
			<td width="" class="main_td" align="left">操作</td>
		</tr>
		{ foreach  from=$_A.stock_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td >{ $item.id}</td>
			<td class="main_td1"  align="left"><a href="javascript:void(0)" onclick='tipsWindown("用户详细信息查看","url:get?{$_A.admin_url}&q=module/user/view&user_id={$item.user_id}&type=scene",500,230,"true","","true","text");'>	{$item.username}</a></td>
			<td width="80" align="left">
				{if $item.optype =="0"}购买
				{else}售出{/if}
			</td>
			<td width="70" align="left">{$item.num}</td>
			<td width="70"  align="left">{$item.trade_account}元</td>
			<td  align="left">{ $item.addtime|date_format}</td>
			<td  align="left">{ $item.remark}</td>
			<td  width="50" align="left">{if $item.status==0}正在审核{elseif $item.status==1}审核通过{else}审核不通过{/if}</td>
			<td  width="70" align="left">{if $item.status==0}<a href="{$_A.query_url}/stock_view{$_A.site_url}&id={$item.id}">审核</a>{/if}</td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="11" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			用户名：<input type="text" name="username" id="username" value="{$magic.request.username|urldecode}"/> 状态<select id="status" ><option value="">全部</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>已通过</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>未通过</option></select> <input type="button" value="搜索" / onclick="sousuo('{$_A.query_url}/amount{$_A.site_url}')">
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


<!--自动投标 开始-->
{elseif $_A.query_type=="autolist"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
			  <form action="" method="post">
				<tr>
                	<td class="main_td">用户编号</td>
                    <td class="main_td">用户名</td>
                    <td class="main_td">姓名</td>
                    <td class="main_td">帐户总额</td>
                    <td class="main_td">帐户余额</td>
					<td class="main_td">是否启用</td>
					
					<td class="main_td">投标额度</td>
                    <td class="main_td">还款方式</td>
					<td class="main_td">利率范围</td>
					<td class="main_td">借款期限</td>
					<td class="main_td">标的奖励</td>
					<td class="main_td">投资标种</td>					
				</tr>
				
                { foreach  from=$_A.autolist key=key item=var}
				
				<tr  {if $key%2==1} class="tr2"{/if}>
                	<td>{$var.user_id}</td>
                    <td>{$var.username}</td>
                    <td>{$var.realname}</td>
                    <td>￥{$var.total}</td>
                    <td>￥{$var.use_money}</td>
                    <td >{if $var.status==1}启用{else}未启用{/if}</td>
					<!--<td>{if $var.tender_type==1}按金额投标{else}按比例投标{/if}</td>-->
					<td>￥{$var.tender_account}</td>
                    <td>{if $var.borrow_style_status==1}
                            {if $var.borrow_style=='0'}
                            按月分期还款
                            {elseif $var.borrow_style=='3'}
                            按月付息到期还本
                            {elseif $var.borrow_style=='2'}
                            到期全额还款
                            {/if}
                    {else}不启用{/if}</td>
					<td>{if $var.apr_status==1}{$var.apr_first}% ~ {$var.apr_last}%{else}不启用{/if}</td>
					<td>{if $var.timelimit_status==1}
                    {$var.timelimit_month_first}月 ~ {$var.timelimit_month_last} 月  &nbsp;，&nbsp;
                    {$var.timelimit_day_first}天 ~ {$var.timelimit_day_last} 天
                    {else}不启用{/if}</td>
					
					<!--<td>{if $var.late_status==1}{$var.late_times}{else}不启用{/if}</td>
					<td>{if $var.dianfu_status==1}{$var.dianfu_times}{else}不启用{/if}</td>-->
					<td>{if $var.award_status==1}{$var.award_first}<!--~{$var.award_last}-->{else}不启用{/if}</td>
					<!--<td>{if $var.tuijian_status==1}是{else}不启用{/if}</td>-->
					<!--<td>{if $var.vouch_status==1}是{else}不启用{/if}</td>-->
                                        <td>
                                        {if $var.credit_status==1}信用标{/if}
                                        {if $var.zhouzhuan_status==1}周转标{/if}
                                        	{if $var.jin_status==1}净值标{/if}
                                            {if $var.fast_status==1}抵押标{/if}
                                            {if $var.pledge_status==1}质押标{/if}
                                            </td>
					
				</tr>
				{/foreach}
                <tr><td  colspan="10">有效金额：{$_A.tmoney} &nbsp; 　&nbsp;  
                总可用余额：{$_A.use_money} &nbsp; 　&nbsp;
                 百分比：{$_A.rate}</td></tr>
			</form>	
		</table>
<!--自动投标 结束-->

<!--额度审核 开始-->
{elseif $_A.query_type=="stock_view"}
<div class="module_title"><strong>股份申请审核</strong></div>
	<div class="module_border">
		<div class="l">用户名：</div>
		<div class="h">
			{$_A.stock_result.username}
		</div>
	</div>
	<div class="module_border">
		<div class="l">申请类型类型：</div>
		<div class="h">
			{if $_A.stock_result.optype=="0"}<font color="#FF0000">购买</font>{else}<font color="#FF0000">售出</font>{/if}
		</div>
	</div>
	<div class="module_border">
		<div class="l">份数：</div>
		<div class="h">
			{$_A.stock_result.num|default:0}
		</div>
	</div>
	<div class="module_border">
		<div class="l">交易金额：</div>
		<div class="h">
			{$_A.stock_result.trade_account|default:0}
		</div>
	</div>	
	<div class="module_border">
		<div class="l">备注：</div>
		<div class="h">
			{$_A.stock_result.remark}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">申请时间：</div>
		<div class="h">
			{$_A.stock_result.addtime|date_format}
		</div>
	</div>
	<div class="module_title"><strong>审核</strong></div>
	<form method="post" action="">
	<div class="module_border">
		<div class="l">审核状态：</div>
		<div class="h">
			<input type="radio" name="status" value="1" />通过  <input type="radio" name="status" value="2" checked="checked" />不通过
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

{/if}
<script>
var url = '{$_A.query_url}/{$_A.query_type}{$_A.site_url}';
{literal}
function sousuo(){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	var username2 = $("#username2").val();
	if (username2!=""){
		sou += "&username2="+username2;
	}
	var status = $("#status").val();
	if (status!="" && status!=null){
		sou += "&status="+status;
	}
	var dotime1 = $("#dotime1").val();
	var keywords = $("#keywords").val();
	//var username = $("#username").val();
    //var username2 = $("#username2").val();
	var dotime2 = $("#dotime2").val();
	var type = $("#type").val();
	var subsite_id = $("#subsite_id").val();
	/*
	if (username!=null){
		 sou += "&username="+username;
	}
	if (username2!=null){
		 sou += "&username2="+username2;
	}
	*/
	if (keywords!=null){
		 sou += "&keywords="+keywords;
	}
	if (dotime1!=null){
		 sou += "&dotime1="+dotime1;
	}
	if (dotime2!=null){
		 sou += "&dotime2="+dotime2;
	}
	if (type!=null){
		 sou += "&type="+type;
	}
	if (subsite_id!=null){
		 sou += "&subsite_id="+subsite_id;
	}
	
	if (sou!=""){
	location.href=url+sou;
	}
}

</script>
{/literal}