<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--用户中心的主栏目 开始-->
<div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 ">
	<!--左边的导航 开始-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--左边的导航 结束-->
	
	<!--右边的内容 开始-->
	<div class="user_right">
		<div class="user_right_menu">
			{if $_U.query_type=="repayment" || $_U.query_type=="repaymentplan" || $_U.query_type=="loandetail" || $_U.query_type=="repaymentyes" || $_U.query_type=="repayment_view" }
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="repayment"} class="cur"{/if}><a href="{$_U.query_url}/repayment">正在还款的借款</a></li>
				<li {if $_U.query_type=="repaymentplan"} class="cur"{/if}><a href="{$_U.query_url}/repaymentplan">还款明细账</a></li>
				<li {if $_U.query_type=="loandetail"} class="cur"{/if}><a href="{$_U.query_url}/loandetail">借款明细账</a></li>
				<li {if $_U.query_type=="repaymentyes"} class="cur"{/if}><a href="{$_U.query_url}/repaymentyes">已还完的借款</a></li>
				{if $magic.request.id!=""} 
				<li {if $_U.query_type=="repayment_view"} class="cur"{/if}>标的还款信息</li>
				{/if}
			</ul>
			{elseif $_U.query_type=="succes" || $_U.query_type=="gathered" || $_U.query_type=="gathering" || $_U.query_type=="lenddetail" || $_U.query_type=="succesyes"}
			<ul class="list-tab clearfix">
				<li {if $magic.request.type=="wait" && $_U.query_type=="succes"} class="cur"{/if}><a href="{$_U.query_url}/succes&type=wait">正在收款的借款</a></li>
				<!-- 
				<li {if $magic.request.type=="yes" && $_U.query_type=="succes"} class="cur"{/if}><a href="{$_U.query_url}/succes&type=yes">收款结束的借款</a></li>
				 -->
				<li {if $_U.query_type=="gathered" } class="cur"{/if} ><a href="{$_U.query_url}/gathered">已收款明细账</a></li>
				<li {if $_U.query_type=="gathering" } class="cur"{/if} ><a href="{$_U.query_url}/gathering">未收款明细账</a></li>
				<li {if $_U.query_type=="lenddetail"} class="cur"{/if} ><a href="{$_U.query_url}/lenddetail">借出明细账</a></li>
			</ul>
			{elseif  $_U.query_type=="bid" || $_U.query_type=="appraisal" || $_U.query_type=="attention" ||  $_U.query_type=="tender_reply"}
			<ul class="list-tab clearfix">
				<li {if $_U.query_type=="bid"} class="cur"{/if}><a href="{$_U.query_url}/bid">正在投标的借款</a></li>
				<li {if $_U.query_type=="appraisal"} class="cur"{/if}><a href="{$_U.query_url}/appraisal">我的评价</a></li>
				<li {if $_U.query_type=="tender_reply"} class="cur"{/if}><a href="{$_U.query_url}/tender_reply">贷款者回复</a></li>
			</ul>
			{elseif $_U.query_type=="tender_vouch" || $_U.query_type=="tender_vouch_finish" }
			<ul class="list-tab clearfix">
			<li {if $_U.query_type=="tender_vouch"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch">投标/复审担保标</a></li>
			<li {if $magic.request.status=="0"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch_finish&status=0">还款中的担保标</a></li>
			<li {if $magic.request.status=="1"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch_finish&status=1">已还完的担保标</a></li></ul>
			{elseif $_U.query_type=="myuser" || $_U.query_type=="myuserrepay" || $_U.query_type=="myuser_account" }
			<ul class="list-tab clearfix">
				<li ><a href="index.php?user&q=code/user/myuser">我的客户</a></li>
				<li {if $_U.query_type=="myuserrepay" || $_U.query_type=="myuser"} class="cur"{/if}><a href="index.php?user&q=code/borrow/myuser">客户借款</a></li>
				<li {if $_U.query_type=="myuser_account"} class="cur"{/if}><a href="index.php?user&q=code/borrow/myuser_account">统计信息</a></li>
			</ul>
			<!--  add for bug 21 begin-->
			{elseif $_U.query_type=="alienate"}<!-- 我的债权列表，在列表中有转让发布按钮 -->
			{elseif $_U.query_type=="alienate_detail"}<!-- 选定债权的细节 -->
			{elseif $_U.query_type=="alienate_buy_list"}<!-- 债权购买的日志-->
			{elseif $_U.query_type=="alienate_sell_list"}<!-- 债权出售的日志-->
			{elseif $_U.query_type=="alienate_market"}<!-- 债权交易中心 -->
			{elseif $_U.query_type=="alienate_buy"}<!-- 购买债权 -->
			{elseif $_U.query_type=="alienate_myposted"}<!-- 我发布的债权转让标 -->
			<!--  add for bug 21 end-->
			<!--  add for bug 31 begin-->
			{elseif $_U.query_type=="quick_verify"}
			<!--  add for bug 31 end-->
			<!--  add for bug 32 begin-->
			{elseif $_U.query_type=="ontop"}
			<!--  add for bug 32 end-->
			<!--  add for bug 19 begin-->
			{elseif $_U.query_type=="purchased"}<!-- 我的流转标认购记录 -->
			{elseif $_U.query_type=="buybackconfirm"}<!-- 我的流转标认购记录 -->
			{elseif $_U.query_type=="purchasing"}<!-- 正在认购的流转标列表 -->
			{elseif $_U.query_type=="mycirculation"}<!-- 我发布的流转标列表 -->
			{elseif $_U.query_type=="mycirculationserial"}<!-- 我发布的流转标销售列表 -->
			{elseif $_U.query_type=="mycirculationbuyback"}<!-- 我发布的流转标销售列表 -->
			<!--  add for bug 19 end-->
			{else}
			<ul class="list-tab clearfix">
				<li {if $_U.query_type=="publish"} class="cur"{/if}><a href="{$_U.query_url}/publish">正在招标的借款</a></li>
				<!-- 
				<li {if $_U.query_type=="unpublish"} class="cur"{/if}><a href="{$_U.query_url}/unpublish">尚未发布的借款</a></li>
				 -->
				<li {if $_U.query_type=="repayment"} class="cur"{/if}><a href="{$_U.query_url}/repayment">正在还款的借款</a></li>
				<!-- 
				<li {if $_U.query_type=="borrow_vouch"} class="cur"{/if}><a href="{$_U.query_url}/borrow_vouch">担保的借款</a></li>
				 -->
				<li {if $_U.query_type=="loanermsg"} class="cur"{/if}><a href="{$_U.query_url}/loanermsg">投资者回复</a></li>
				{if in_array("credit", $biaotype_list) }
                <li {if $_U.query_type=="limitapp"} class="cur"{/if}><a href="{$_U.query_url}/limitapp">额度申请</a></li>
				{/if}
			</ul>
			{/if}
		</div>
		
		<div class="user_right_main">
		
	
		{if $_U.query_type=="publish"}
		<!--正在招标 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo('')" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >类型</td>
					<td  >金额(元)</td>
					<td  >年利率</td>
					<td  >期限</td>
					<td  >发布时间</td>
					<td  >进度</td>
					<td  >状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" status="0,1,2,4,5,6" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if} >
					<td width="70"  ><a href="/invest/a{$item.id}.html" title="{$item.name}" target="_blank">{$item.name|truncate:12}</a></td>
					<td  >{$item.biao_type_name}</td>
					<td  >{$item.account}元</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<td  >
					{if $item.is_vouch==1}
						<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%（投标）</span>
						<br>
					<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.vouch_scale|default:0}px"></div>
						</div><span class="floatl">{$item.vouch_scale}%（担保）</span>
					{else}	
					<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%</span>
					{/if}	
					</td>
					<td  >{if $item.status==0}发布审批中{elseif $item.status==1}
					{if $item.is_vouch==1}
					{if $item.account_yes==$item.account && $item.account_yes==$item.vouch_account}满标审核中
					{else}正在募集
					{/if}
					{else}
					{if $item.account_yes==$item.account}满标审核中
					{else}正在募集
					{/if}
					{/if}
					{elseif $item.status==2}审核失败{elseif $item.status==3}已满标{elseif $item.status==4}满标审核失败{elseif $item.status==5}撤回{/if}</td>
					<td  >
					<!--  -->
					{if $item.status==0 || $item.status==1}<a href="#" onclick="javascript:if(confirm('确定要撤回此招标')) location.href='{$_U.query_url}/cancel&id={$item.id}'">撤回</a>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		
		<!--正在招标 结束-->
		
		<!--  add for bug 31 begin-->
		<!--申请加急审核开始-->
		{elseif $_U.query_type=="quick_verify"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		加急审核需要额外支付费用。
		借款标
		需要支付费用
		</div>
		<!--申请加急审核结束-->
		<!--  add for bug 31 end-->
		<!--  add for bug 32 begin-->
		<!--申请加急审核开始-->
		{elseif $_U.query_type=="ontop"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		置顶需要额外支付费用。
		借款标
		需要支付费用
		置顶天数
		</div>
		<!--申请加急审核结束-->
		<!--  add for bug 33 end-->
		
		<!--尚未发布 开始-->
		{elseif $_U.query_type=="unpublish"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >金额(元)</td>
					<td  >年利率</td>
					<td  >期限</td>
					<td  >发布时间</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" status="-1"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.name}</td>
					<td  >{$item.account}(元)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >{$item.addtime|date_format:"Y-m-d"}</td>
					<td  ><a href="/publish/index.html?article_id={$item.id}">编辑</a> <a href="#" onclick="javascript:if(confirm('确定要删除此招标')) location.href='{$_U.query_url}/del&id={$item.id}'">删除</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--尚未发布 结束-->
		
		{elseif $_U.query_type=="repayment" ||  $_U.query_type=="repaymentyes"}
		<!--正在还款的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >协议</td>
					<td  >借款金额</td>
					<td  >年利率</td>
					<td  >还款期限</td>
					<td  >偿还本息</td>
					<td  >已还本息</td>
					<td  >未还本息</td>
					<td  >操作</td>
				</tr>{if $_U.query_type=="repayment"}
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="now" status="3"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a></td>
					<td  ><a href="/protocol/index.html?borrow_id={$item.id}" target="_blank">查看协议</a></td>
					<td  >{$item.account}(元)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.repayment_yesaccount|default:0}</td>
					<td  >￥{$item.repayment_noaccount}</td>
					<td  ><a href="{$_U.query_url}/repayment_view&id={$item.id}" target="_blank">还款明细</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				{else}
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="yes" status="3"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a></td>
					<td  >查看协议</td>
					<td  >{$item.account}(元)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.repayment_yesaccount|default:0}</td>
					<td  >￥{$item.repayment_noaccount}</td>
					<td  ><a href="{$_U.query_url}/repayment_view&id={$item.id}" >还款明细</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				{/if}
			</form>	
		</table>
		<!--正在还款的借款 结束-->
		
		{elseif $_U.query_type=="repaymentplan"}
		<!--还款明细 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >第几期</td>
					<td  >应还款日期</td>
					<td  >本期应还本息</td>
					<td  >利息</td>
					<td  >滞纳金</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
					<td  >还款状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.interest}</td>
					<td  >￥{$item.forfeit}</td>
					<td  >￥{$item.late_interest}</td>
					<td  >{$item.late_days}天</td>
					<td  >{if $item.status==0}待还款{elseif $item.status==2}网站先垫付{else}已还款{/if}</td>
					<td  >{if $item.status==0 || $item.status==2}<a href="#" onclick="javascript:if(confirm('你确定要偿还此借款吗？')) location.href='{$_U.query_url}/repay&id={$item.id}'">还款</a>{else}-{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="10" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--还款明细 结束-->
		
		
		{elseif $_U.query_type=="myuserrepay"}
		<!--我的客户 开始-->
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >第几期</td>
					<td  >所属用户</td>
					<td  >应还款日期</td>
					<td  >本期应还本息</td>
					<td  >利息</td>
					<td  >滞纳金</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
					<td  >还款状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRepaymentList" showpage="3" user_id="$magic.request.user_id" keywords="request" kefu_userid= "$_G.user_id" dotime1="request" dotime2="request" order="repayment_time" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  ><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d H:i"}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.interest}</td>
					<td  >￥{$item.forfeit}</td>
					<td  >￥{$item.late_interest}</td>
					<td  >{$item.late_days}天</td>
					<td  >{if $item.status==0}待还款{else}已还款{/if}</td>
					<td  >{if $item.status==0}<a href="#" onclick="javascript:if(confirm('你确定要偿还此借款吗？')) location.href='{$_U.query_url}/repay&id={$item.id}'">还款</a>{else}-{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--我的客户 结束-->
		
		
		{elseif $_U.query_type=="loandetail"}
		<!--借款明细 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		投资者：<input type="text" name="username" id="username" size="15" value="{$magic.request.username|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo()" class="btn-action" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标 </td>
					<td  >投资者 </td>
					<td  >借入总额</td>
					<td  >借入时间</td>
					<!-- 
					<td  >还款总额</td>
					<td  >已还利息</td>
					<td  >已还滞纳金</td>
					<td  >待还总额</td>
					<td  >待还利息</td>
					-->
				</tr>
				{list module="borrow" var="loop" function ="GetTenderUserList" showpage="3" user_id="0" username="request" borrow_status=3}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name}</td>
					<td  >{$item.username}</td>

					<td  ><font color="#FF0000">￥{$item.account}</font></td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<!-- 
					<td  >￥{$item.repayment_yesaccount|default:0}</td>
					<td  >￥{$item.repayment_yesinterest|default:0}</td>
					<td  >￥{$item.forfeit|default:0}</td>
					<td  >￥{$item.wait_account|default:0 }</td>
					<td  >￥{$item.wait_interest|default:0}</td>
					-->
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--借款明细 结束-->
		
		
		{elseif $_U.query_type=="loanermsg"}
		<!--投资者留言 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		您现在查看的是:<select name="status"> <option value="">所有回复</option> <option value="0">等我回复</option> <option value="1">已回复</option></select>
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标的标题</td>
					<td  >留言者</td>
					<td  >留言内容</td>
					<td  >留言时间</td>
					<td  >留言状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.name}</td>
					<td  >{$item.account}(元)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >{$item.addtime|date_format:"Y-m-d"}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--投资者留言 结束-->
		
		
		{elseif $_U.query_type=="limitapp"}
		<!--额度申请 开始-->
		
		
		{if $_G.user_result.real_status!=1}
			<div align="center"><font color="#FF0000"><br />
		<br />
		{$_G.system.con_webname}提醒你：</font>你还没有通过实名认证，请先通过<a href="/index.php?user&q=code/user/realname"><strong>实名认证!</strong></a>
		</div><br />
                    {elseif $_G.user_result.vip_status!=1}
                            <div align="center"><font color="#FF0000">
                    <br />
                    {$_G.system.con_webname}提醒你：</font>你还不是VIP会员，请先成为<a href="/vip/index.html"><strong>VIP会员</strong></a>。</div><br /><br /><br />
                    
		{else}
		{article module="borrow" function="GetAmountApplyOne" user_id="0" var="var"}
		<form cur="" method="post">
		<div class="user_right_border">
			<div class="e">申请者：</div>
			<div class="c">
				{$_G.user_result.username}
			</div>
		</div>
		{if $var.status==2}
		<div class="user_right_border">
			<div class="e"> 状态：</div>
			<div class="c">
				正在审核中
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"> 申请类型：</div>
			<div class="c">
				{if $var.type=="tender_vouch"}投资担保额度{elseif $var.type=="borrow_vouch"}借款担保额度{elseif $var.type=="restructuring"}债务重组额度{else}借款信用额度{/if}
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"> 申请金额：</div>
			<div class="c">
				{$var.account}
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">详细说明：</div>
			<div class="c">
				{$var.content}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">其它地方借款详细说明：</div>
			<div class="c">
			{$var.remark}
			</div>
		</div>
		
		{else}
		
		<div class="user_right_border">
			<div class="e"> 申请类型：</div>
			<div class="c">
				<select name="type"><option value="credit" {if $magic.request.type=="credit"} selected="selected"{/if}>借款信用额度</option><!--<option value="tender_vouch" {if $magic.request.type=="tender_vouch"} selected="selected"{/if}>投资担保额度</option>
<option value="borrow_vouch" {if $magic.request.type=="borrow_vouch"} selected="selected"{/if}>借款担保额度</option><option value="restructuring" {if $magic.request.type=="restructuring"} selected="selected"{/if}>债务重组额度</option>	-->	
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> 申请金额：</div>
			<div class="c">
				<input type="text" name="account" value="" onkeyup="value=value.replace(/[^0-9]/g,'')"/> 
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="e">详细说明：</div>
			<div class="c">
				<textarea rows="5" cols="40" name="content"></textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">其它地方借款详细说明：</div>
			<div class="c">
			<textarea rows="5" cols="40" name="remark"></textarea>
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  class="btn-action" value="确认提交" size="30" /> 
			</div>
		</div>
		{/if}
		</form>
		
		{/article}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >申请时间</td>
					<td  >申请类型</td>
					<td  >申请金额(元)</td>
					<td  >通过金额(元)</td>
					<td  >备注说明</td>
					<td  >状态</td>
					<td  >审核时间</td>
					<td  >审核备注</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAmountApplyList" showpage="3" user_id="0"  }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.addtime|date_format}</td>
					<td width="70">{if $item.type=="tender_vouch"}投资担保额度{elseif $item.type=="borrow_vouch"}借款担保额度{elseif $item.type=="restructuring"}债务重组额度{else}借款信用额度{/if}</td>
					<td  >{$item.account}</td>
					<td  >{$item.newaccount}</td>
					<td  width="200">{$item.content}</td>
					<td  >{if $item.status==0}审核不通过{elseif $item.status==1}审核通过{else}正在审核{/if}</td>
					<td  >{$item.verify_time|date_format} </td>
					<td  >{$item.verify_remark}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<div class="user_right_foot">
		* 温馨提示：额度申请后 无论申请是否批准 必须隔一个月后才能再次申请，每个月只能申请一次如有问题,请与我们联系
		</div>
		<!--额度申请 结束-->
		{/if}
		
		
				
		{elseif $_U.query_type=="succes" }
		<!--成功投资 开始-->
		<!-- 
		{article module="borrow" function="GetUserLog" user_id="0"}
		<div class="alert alert-block">结果统计：借出总额￥{$var.success_account|default:0} 已收总额￥{$var.collection_capital1|default:0} 未收总额￥{$var.collection_capital0|default:0} 已收利息￥{$var.collection_interest1|default:0} 未收利息￥{$var.collection_interest0|default:0} </div>
		{/article}
		 -->
		<div class="well" > 
		发布时间：<input type="text" name="dotime1" id="dotime1"  size="15" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>   关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" />
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >借款者</td>
					<td  >借款者积分</td>
					<td  >金额(元)</td>
					<td  >年利率</td>
					<td  >期限</td>
					<td  >应收本息</td>
				</tr>
				{list module="borrow" var="loop" function ="GetBorrowSucces" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request"  type="$magic.request.type"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.username}">{$item.username}</a></td>
					<td  >{$item.credit|credit}{$item.credit}分</td>
					<td  >￥{$item.account}</td>
					<td  >{$item.apr}%</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >￥{$item.right_account}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="7" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--成功投资 结束-->
		
		{elseif $_U.query_type=="tender_vouch" }
		<!--成功担保 开始-->
		
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >借款者</td>
					<td  >借款总额</td>
					<td  >借款期限</td>
					<td  >担保奖励</td>
					<td  >担保总额</td>
					<td  >担保时间</td>
					<td  >担保冻结</td>
					<td  >状态</td>
				</tr>
				{list module="borrow" var="loop" function ="GetVouchList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="$magic.request.type" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.borrow_username}">{$item.borrow_username}</a></td>
					<td  >￥{$item.borrow_account}</td>
					<td  >{$item.borrow_period}个月</td>
					<td  >￥{$item.award_account}</td>
					<td  >￥{$item.vouch_account}</td>
					<td  >{$item.addtime|date_format}</td>
					<td  >￥{$item.vouch_collection}</td>
					<td  >{if $item.status==1}成功{elseif $item.status==2}<font color="#FF0000">失败</font>{else}待审核{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--担保明细 结束-->
		{elseif $_U.query_type=="tender_vouch_finish"}
		
 
</div>
		<div class="well" style="height:30px; padding-top:7px;"> 
		收款时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款者</td>
					<td  >借款标题</td>
					<td  >应还日期</td>
					<td  >第几期/总期数</td>
					<td  >总额</td>
					<td  >本金</td>
					<td  >利息</td>
					<td  >还款状态</td>
					<td  >担保金额</td>
					<td  >担保方式</td>
					<td  >垫付状态</td>
					<td  >垫付时间</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetVouchRepayList" showpage="3" vouch_userid="$_G.user_id" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status" order="order" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_username}</td>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >￥{$item.repayment_account }</td>
					<td  >￥{$item.capital  }</td>
					<td  >￥{$item.interest  }</td>
					<td  >{if $item.status==1  }<font color="#666666">已还</font>{else}<font color="#FF0000">未还</font>{/if}</td>
					<td  >￥{$item.vouch_collection  }</td>
					<td  >{if $item.vouch_type=="amount"  }担保额度{else}可用余额{/if}</td>
					<td  >{if $item.is_advance==1  }<font color="#666666">已垫付</font>{elseif $item.is_advance==2}<font color="#FF0000">网站强制垫付</font>{else}<font color="#FF0000">未垫付</font>{/if}</td>
					<td  >{$item.advance_time|date_format:"Y-m-d"}</td>
					<td  >{if $item.is_advance==0 &&  $item.repay_status==0}<a href="index.php?user&q=code/borrow/voucher_advance&id={$item.vouch_id}" onclick="return confirm('确定垫付吗？')">垫付</a>{/if}</td>
					
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--担保明细 结束-->
		
		{elseif $_U.query_type=="gathered"}
		<!--  
		{article module="account" function="GetAccountAll" user_id="0" }
		<div class="user_help">
		<table class="table alert">
			<tr>
			<td>投资总额：￥{$var.tender_num|default:0}(包含逾期的统计) </td>
			<td>已收总额：￥{$var.tender_yesnum|default:0}   </td>
			<td></td>
		</tr>
		<tr>
			<td>待收总额：￥{$var.tender_wait|default:0}</td>
			<td>待收利息：￥{$var.tender_wait_interest|default:0} </td>
			<td>实得利息：￥{$var.tender_wait_interest*0.9}  </td>
		</tr>
	</table>
		
</div>
    {/article}
 -->
		<div class="well" style="height:30px; padding-top:7px;"> 
		收款时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >应收日期</td>
					<td  >借款者</td>
					<td  >第几期/总期数</td>
					<td  >收款总额</td>
					<td  >应收本金</td>
					<td  >应收利息</td>
                    <td  >管理费</td>
                    <!-- 
                    <td  >实得利息</td>
					 -->
					<td  >还款日期</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
					<td  >状态</td>
				</tr>
				{list module="borrow" var="loop" function ="GetCollectionedList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status"  borrow_id="$magic.request.borrow_id" order="repay_time"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repay_time|date_format:"Y-m-d"}</td>
					<td  >{$item.username}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >￥{$item.repay_account }</td>
					<td  >￥{$item.capital  }</td>
					<td  >￥{$item.interest  }</td>
                    <td  >￥{$item.interest_fee}</td>
					<td  >{$item.repay_yestime|date_format:"Y-m-d"}</td>
                    <!-- 
                    <td  >￥{$item.interest*0.9}</td>
					 -->
					<td  >￥{$item.late_interest|default:0  }</td>
					<td  >{$item.late_days|default:0  }天</td>
					<td  >{if $item.status==1  }<font color="#666666">已还</font>{else}<font color="#FF0000">未还</font>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="12" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--收款明细 结束-->
		
		{elseif $_U.query_type=="gathering"}
		<!-- 
		{article module="account" function="GetAccountAll" user_id="0" }
		<div class="user_help">
		<table class="table alert">
			<tr>
			<td>投资总额：￥{$var.tender_num|default:0}(包含逾期的统计) </td>
			<td>已收总额：￥{$var.tender_yesnum|default:0}   </td>
			<td></td>
		</tr>
		<tr>
			<td>待收总额：￥{$var.tender_wait|default:0}</td>
			<td>待收利息：￥{$var.tender_wait_interest|default:0} </td>
			<td>实得利息：￥{$var.tender_wait_interest*0.9}  </td>
		</tr>
	</table>
		
</div>
    {/article}
  -->
		<div class="well" style="height:30px; padding-top:7px;"> 
		收款时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >应收日期</td>
					<td  >借款者</td>
					<td  >第几期/总期数</td>
					<td  >收款总额</td>
					<td  >应收本金</td>
					<td  >应收利息</td>
					<!-- 
                    <td  >管理费</td>
                    <td  >实得利息</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
                     -->
					<td  >状态</td>
					
				</tr>
				{list module="borrow" var="loop" function ="GetCollectioningList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status"  borrow_id="$magic.request.borrow_id" order="repay_time"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >{$item.username}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >￥{$item.r_total }</td>
					<td  >￥{$item.r_capital  }</td>
					<td  >￥{$item.r_interest  }</td>
					<!-- 
					<td  >￥0</td>
					<td  >0天</td>
					 -->
					<td  >{if $item.status==1  }<font color="#666666">已还</font>{else}<font color="#FF0000">未还</font>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="12" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--收款明细 结束-->
		<!--  add for bug 21 begin-->
		{elseif $_U.query_type=="alienate_detail"}
		
 
</div>
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/post_alienate">
		转让价格（必须是转让单位的整数倍）：<input type="text" name="price" id="price" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">最小转让单位<input type="text" name="unit" id="unit" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">	
		<input type="hidden" name="borrow_right_id" value="{$magic.request.borrow_right_id}">
		<input type="submit" value="确认转让" class="btn-action">
		</form> 
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >第几期</td>
					<td  >应还款日期</td>
					<td  >本期应还本息</td>
					<td  >利息</td>
					<td  >滞纳金</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
					<td  >还款状态</td>
					<td  >所占份额</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" borrow_right_id="$magic.request.borrow_right_id" isface=1}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.interest}</td>
					<td  >￥{$item.forfeit}</td>
					<td  >￥{$item.late_interest}</td>
					<td  >{$item.late_days}天</td>
					<td  >{$item._status}</td>
					<td  >{$item.has_percent}%{if $item.has_percent==0}（己无效）{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="11" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>

		<!--投资标收款细节结束-->		
		<!--  add for bug 21 end-->
		
		<!--  add for bug 76 begin-->
		{elseif $_U.query_type=="alienate_market"}
		<!--债权交易中心开始-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >债权所有者</td>
					<td  >债权价值</td>
					<td  >保障级别</td>
					<td  >转让价格</td>
					<td  >转让单位</td>
					<td  >还可购买份数</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" areaid="$_G.areaid"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name|truncate:10}</td>
					<td  >{$item.username}</td>
					<td  >{$item.amount}</td>
					<td  >{if $item.origin_creditor_level==1}VIP级别保障{else}普通用户保障{/if}</td>
					<td  >{$item.price}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.valid_unit_num}</td>
					<td  ><a href="index.php?user&q=code/borrow/alienate_buy&borrow_right_id={$item.borrow_right_id}&right_alienate_id={$item.id}">立即购买</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>

		<!--债权交易中心结束-->		
		<!--  add for bug 76 end-->

		<!--  add for bug 78 begin-->
		{elseif $_U.query_type=="alienate_buy"}
		{article module="borrow" function="GetAlienateDetail" id="$magic.request.right_alienate_id" var="alienate"}
		<!--债权购买开始-->

		<div class="user_help">

		<table class="table alert">
			<tr>
			<td>债权价值： ￥{$alienate.amount}</td>
			<td>转让价格：￥ {$alienate.price}</td>
			<td>单份价格：￥ {$alienate.unit}</td>
			</tr>
			<tr>
			<td>还可购买份数： {$alienate.valid_unit_num}</td>
			<td>原始债权所占比例：{$alienate.right_percent}%</td>
			<td><!--保障级别： {if $alienate.origin_creditor_level==1}VIP级别保障{else}普通用户保障{/if}--></td>
			</tr>
		</table>
		
    {/article}
 
</div>
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/buy_alienate">
		购买份数:<input type="text" name="unit_num" id="unit_num" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">		
		<input type="hidden" name="right_alienate_id" value="{$magic.request.right_alienate_id}" >
		<input type="submit" value="确认提交" class="btn-action">
		</form> 
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >第几期</td>
					<td  >应还款日期</td>
					<td  >本期应还本息</td>
					<td  >利息</td>
					<td  >滞纳金</td>
					<td  >逾期利息</td>
					<td  >逾期天数</td>
					<td  >还款状态</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" borrow_right_id="$magic.request.borrow_right_id"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >￥{$item.interest}</td>
					<td  >￥{$item.forfeit}</td>
					<td  >￥{$item.late_interest}</td>
					<td  >{$item.late_days}天</td>
					<td  >{if $item.status==0}待还款{elseif $item.status==2}网站先垫付{else}已还款{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--债权购买结束-->		
		<!--  add for bug 78 end-->		
		
		<!--  add for bug 79 begin-->
		{elseif $_U.query_type=="alienate_myposted"}
		<!--债权交易中心开始-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >债权价值</td>
					<td  >保障级别</td>
					<td  >转让价格</td>
					<td  >转让单位</td>
					<td  >还可购买份数</td>
					<td  >状态</td>
					<td  >有效</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetMyPostedAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.amount}</td>
					<td  > {if $item.origin_creditor_level==1}VIP级别保障{else}普通用户保障{/if}</td>
					<td  >{$item.price}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.valid_unit_num}</td>
					<td  >{if $item.status==0}已撤销{elseif $item.status==2}出售完毕{else}正常{/if}</td>
					<td  >{if $item.valid==0}无效{else}正常{/if}</td>
					<td  >{if $item.status==1 && $item.valid==1}<a href="index.php?user&q=code/borrow/cancel_alienate&right_alienate_id={$item.id}">撤回</a>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>

		<!--债权交易中心结束-->		
		<!--  add for bug 79 end-->
		
		<!--  add for bug 83 begin-->
		{elseif $_U.query_type=="alienate_buy_list"}
		<!--我购入的债权记录开始开始-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >购买份数</td>
					<td  >单位价格</td>
					<td  >购买到债权比例</td>
					<td  >购买到债权</td>
					<td  >购买时间</td>
                    <td  >协议</td>
				</tr>
				{list module="borrow" var="loop" function ="GetMyBuyAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name}</td>
					<td  >{$item.unit_num}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.bought_right_percent_f}%</td>
					<td  >{$item.bought_right}</td>
					<td  >{$item.buy_time|date_format:"Y-m-d"}</td>
                    <td><a href="/protocolright/index.html?serial_id={$item.id}" target="_blank">查看协议</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>

		<!--我购入的债权列表结束-->		
		<!--  add for bug 83 end-->
		
		<!--  add for bug 84 begin-->
		{elseif $_U.query_type=="alienate_sell_list"}
		<!--我售出的债权记录开始开始-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款标题</td>
					<td  >购买人</td>
					<td  >购买份数</td>
					<td  >单位价格</td>
					<td  >购买到债权比例</td>
					<td  >购买到债权</td>
					<td  >购买时间</td>
                    <td  >协议</td>
				</tr>
				{list module="borrow" var="loop" function ="GetMySellAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name}</td>
					<td  >{$item.username}</td>
					<td  >{$item.unit_num}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.bought_right_percent_f}%</td>
					<td  >{$item.bought_right}</td>
					<td  >{$item.buy_time|date_format:"Y-m-d"}</td>
                    <td><a href="/protocolright/index.html?serial_id={$item.id}" target="_blank">查看协议</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>

		<!--我购入的债权列表结束-->		
		<!--  add for bug 84 end-->				
		
		{elseif $_U.query_type=="lenddetail"}
		<!--借出明细 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >借款者</td>
					<td  >借款标</td>
					<td  >借出总额</td>
					<td  >收益总额</td>
					<td  >投标时间</td>
					<!-- 
					<td  >已收总额</td>
					<td  >待收总额</td>
					<td  >已收利息</td>
					<td  >待收利息</td>
					-->
				</tr>
			{list module="borrow" var="loop" function ="GetTenderList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.op_username}</td>
					<td  ><a href="/invest/a{$item.borrow_id}.html">{$item.borrow_name|truncate:14}</a></td>
					<td  >￥{$item.tender_account}</td>
					<td  >￥{$item.repayment_account}</td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<!-- 
					<td  >￥{$item.repayment_yesaccount}</td>
					<td  >￥{$item.wait_account  }</td>
					<td  >￥{$item.repayment_yesinterest }</td>
					<td  >￥{$item.wait_interest  }</td>
					-->
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--借出明细 结束-->
		
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="purchased"}
		<!--正在投标的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		认购时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >流转标</td>
					<td  >借款者</td>
					<td  >认购日期</td>
					<td  >计息开始时间</td>
					<td  >计息结束时间</td>
					<td  >月份 </td>
					<td  >份数</td>
					<td  >单位价格</td>
					<td  >年利率</td>
					<td  >本金</td>
					<td  >利息</td>
					<td  >购买方式</td>
					<td  >是否回购</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetPurchasedList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.circulation_name}">{$item.circulation_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">{$item.seller_name}</td>
					<td  style="line-height:21px;">{$item.buytime|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.begin_interest_time|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.end_interest_time|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.buy_month_num}</td>
					<td style="line-height:21px;">{$item.unit_num}</td>
					<td style="line-height:21px;">{$item.unit_price}</td>
					<td style="line-height:21px;">{$item.buy_apr}</td>
					<td style="line-height:21px;">{$item.capital}</td>
					<td style="line-height:21px;">{$item.interest}</td>
					<td style="line-height:21px;">{if $item.buy_type=="award"}奖励{else}现金{/if}</td>
					<td style="line-height:21px;">{if $item.buyback==1}已回购{else}未回购{/if}</td>
					<td style="line-height:21px;">{if $item.buyback==0 && $item.st==0}<a href="index.php?user&q=code/borrow/buybackconfirm&buy_id={$item.id}">回购</a>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="14" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		<!--正在投标的借款 结束-->
		<!--  add for bug 19 end -->
		
		<!--  add for bug 214 begin-->
		{elseif $_U.query_type=="buybackconfirm"}
		<!--债权购买开始-->

		<div class="user_help">

		计息时间：{$_U.buyback_info.can_interest_month}月 所得利息{$_U.buyback_info.interest}元，收回本金{$_U.buyback_info.account_money}元，自动续购：{if $_U.buyback_info.auto_repurchase == 1}是{else}否{/if}		
 
		</div>
		
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/buyback">
		自动续购：<input id="auto_repurchase" type="checkbox" name="auto_repurchase" value="1" {if $_U.buyback_info.auto_repurchase==1} checked="checked"{/if} />（注：如果提前回购，续购不会成功。）<br/>		
		<input type="hidden" name="buy_id" value="{$magic.request.buy_id}" >
		<input type="submit" value="确认提交" class="btn-action">
		</form> 
		</div>
			
		<!--  add for bug 214 end-->
		
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="purchasing"}
		<!--正在投标的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >流转标</td>
					<td  >认购总金额</td>
					<td  >认购开始日期</td>
					<td  >最小认购月份 </td>
					<td  >认购档期 </td>
					<td  >每份价格 </td>
					<td  >年利率</td>
					<td  >增加月利息</td>
					<td  >已回购份数</td>
					<td  >还可认购份数</td>
					<td  >总份数</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetPurchasingList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" >{$item.circulation_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">{$item.account_circu}</td>
					<td  style="line-height:21px;">{$item.verify_time|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.begin_month_num}</td>
					<td style="line-height:21px;">{$item.increase_month_num}</td>
					<td style="line-height:25px;">{$item.unit_price}</td>
					<td style="line-height:21px;">{$item.begin_apr}%</td>
					<td style="line-height:21px;">{$item.increase_apr}%</td>
					<td style="line-height:21px;">{$item.circulated_num}</td>
					<td style="line-height:21px;">{$item.valid_unit_num}</td>
					<td style="line-height:21px;">{$item.total_unit_num}</td>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html?detail=true" target="_blank" >购买</a></td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="10" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		<!--正在投标的借款 结束-->
		
		{elseif $_U.query_type=="mycirculation"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >流转标</td>
					<td  >借款总金额</td>
					<td  >认购开始日期</td>
					<td  >最小认购月份 </td>
					<td  >认购档期 </td>
					<td  >每份价格 </td>
					<td  >年利率</td>
					<td  >增加月利息</td>
					<td  >已回购份数</td>
					<td  >还可认购份数</td>
					<td  >总份数</td>
					<td  >状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetMyCirculationList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" >{$item.circulation_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">{$item.account_circu}</td>
					<td  style="line-height:21px;">{$item.verify_time|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.begin_month_num}</td>
					<td style="line-height:21px;">{$item.increase_month_num}</td>
					<td style="line-height:25px;">{$item.unit_price}</td>
					<td style="line-height:21px;">{$item.begin_apr}%</td>
					<td style="line-height:21px;">{$item.increase_apr}%</td>
					<td style="line-height:21px;">{$item.circulated_num}</td>
					<td style="line-height:21px;">{$item.valid_unit_num}</td>
					<td style="line-height:21px;">{$item.total_unit_num}</td>
					<td style="line-height:21px;">{if $item.status==0}审核中{elseif $item.status==5}已撤销{elseif $item.status==2}审核未通过{else}正常{/if}</td>
					<td style="line-height:21px;">{if $item.status==0 || $item.status==1}<a href="index.php?user&q=code/borrow/cancel&id={$item.borrow_id}" target="_blank" >撤销</a>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="13" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		
		<!--  add for bug 19 end -->
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="mycirculationserial"}
		<!--正在投标的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >流转标</td>
					<td  >认购者</td>
					<td  >认购日期</td>
					<td  >月份 </td>
					<td  >份数</td>
					<td  >单位价格</td>
					<td  >年利率</td>
					<td  >本金</td>
					<td  >利息</td>
				</tr>
				{list module="borrow" var="loop" function ="GetCirculationSellList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.circulation_name}">{$item.circulation_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">{$item.buyer_name}</td>
					<td  style="line-height:21px;">{$item.buytime|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.buy_month_num}</td>
					<td style="line-height:21px;">{$item.unit_num}</td>
					<td style="line-height:21px;">{$item.unit_price}</td>
					<td style="line-height:21px;">{$item.buy_apr}</td>
					<td style="line-height:21px;">{$item.capital}</td>
					<td style="line-height:21px;">{$item.interest}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		<!--正在投标的借款 结束-->
		<!--  add for bug 19 end -->
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="mycirculationbuyback"}
		<!--正在投标的借款 开始-->
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >回购日期</td>
					<td  >本金</td>
					<td  >利息</td>
				</tr>
				{list module="borrow" var="loop" function ="GetBuybackList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  style="line-height:21px;">{$item.end_interest_time|date_format:"Y-m-d"}</td>
					<td  style="line-height:21px;">{$item.need_capital}</td>
					<td style="line-height:21px;">{$item.need_interest}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="9" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		<!--正在投标的借款 结束-->
		<!--  add for bug 19 end -->
		
		{elseif $_U.query_type=="bid"}
		<!--正在投标的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >借款者</td>
					<td  >投标/有效金额</td>
					<td  >信用积分/投标时间 </td>
					<td  >进度</td>
					<td  >状态 </td>
				</tr>
				{list module="borrow" var="loop" function ="GetTenderList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">借款者:{$item.op_username}</td>
					<td style="line-height:21px;">投标金额:￥{$item.money}<br />有效金额:<font color="#FF0000">￥{$item.tender_account}</font></td>
					
					<td style="line-height:25px;"><span><img src="{$_G.system.con_credit_picurl}{ $item.credit_pic}" title="{$item.credit_jifen}分"  /></span><br />{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					
					<td style="line-height:21px;"><div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%</span></td>
					<td style="line-height:21px;">{if $item.status==0}投标失败{else}{if $item.tender_account==$item.money}全部通过{else}部分通过{/if}{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="10" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
				
			</form>	
		</table>
		<!--正在投标的借款 结束-->
		
		{elseif $_U.query_type=="appraisal"}
		<!--我的评价 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"  class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题      </td>
					<td  >借款者</td>
					<td  >投标金额</td>
					<td  >完成时间</td>
					<td  >评价结果</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>短期借款，提前还款</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1个月</td>
					<td  >50</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--我的评价 结束-->
		
		
		{elseif $_U.query_type=="attention"}
		<!--我关注的借款 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		<select><option>进行中的借款</option><option>已结束的借款</option></select> 发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="搜索" type="submit" class="btn-action"   onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >图片                  </td>
					<td  >标题</td>
					<td  >金额(元)</td>
					<td  >进度</td>
					<td  >期限</td>
					<td  >信用等级</td>
					<td  >操作</td>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>短期借款，提前还款</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1个月</td>
					<td  >50</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--我关注的借款 结束-->
		
		
		{elseif $_U.query_type=="tender_reply"}
		<!--投资者留言 开始-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		您现在查看的是:<select name="status"> <option value="">所有回复</option> <option value="0">等我回复</option> <option value="1">已回复</option></select>
		<input value="搜索" type="submit" class="btn-action"  />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标的标题</td>
					<td  >留言者</td>
					<td  >留言内容</td>
					<td  >留言时间</td>
					<td  >留言状态</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>短期借款，提前还款</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1个月</td>
					<td  >50</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="8" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--投资者留言 结束-->
		
		
		
		{elseif $_U.query_type=="myuser"}
		<!--我的客户 结束-->
		<div class="user_help" > 
		{list  module="borrow" function="GetMyuserList" var="loop" user_id="0" showpage=3 epage=20 suser_id = "$magic.request.user_id"}
			
		<strong>总借款数：</strong> {$loop.total} 个
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >用户名</td>
					<td  >真实姓名</td>
					<td  >标题</td>
					<td  >借款金额</td>
					<td  >借款时间</td>
					<td  >成功借款时间</td>
					<td  >状态</td>
				</tr>
					{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td><a href="{$_U.query_url}/myuser&user_id={$item.user_id}">{$item.realname}</a> </td>
					<td><a href="/invest/a{$item.id}.html" target="_blank">{$item.name}</a></td>
					<td>￥{$item.account}</td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.success_time|date_format|default:"-"}</td>
					<td>{if $item.status==5}取消{elseif $item.status==3}借款成功{elseif $item.status==2}审核失败{elseif $item.status==4}满标审核失败{elseif $item.status==1}正在招标中{/if}</td>
				</tr>
				{/loop}
				<tr >
					<td colspan="8" class="page">
						<div class="list_table_page">{$loop.showpage}</div>
					</td>
				</tr>
			</form>	
		</table>
		{/list}
		<!--我的客户 结束-->
		<!--  add for bug 21 begin -->
		{elseif $_U.query_type=="alienate" }
		<!--债权转让 开始-->
		
		<div class="well" > 
		发布时间：<input type="text" name="dotime1" id="dotime1"  size="15" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>   关键字：<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" />
		<input value="搜索" type="submit" class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >标题</td>
					<td  >借款者</td>
					<td  >金额(元)</td>
					<td  >年利率</td>
					<td  >期限</td>
					<td  >还需归还本息</td>
					<td  >所占比例</td>
					
					<td  >保障级别</td>
                    <td  >债权价值</td>
					<td  >操作</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRightCanAlienate" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="$magic.request.type" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if} {if $item.amount==0}style="text-decoration:line-through"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.username}">{$item.username}</a></td>
					<td  >￥{$item.account}</td>
					<td  >{$item.apr}%</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}天{else}{$item.time_limit}个月{/if}</td>
					<td  >{$item.needrepayment}</td>
					<td  >{$item.has_percent}%</td>
					
					<td  >{if $item.origin_creditor_level==1}VIP级别保障{elseif $item.origin_creditor_level==0}普通用户保障{else}不保障{/if}</td>
                    <td  >{$item.amount}</td>
					<td  >{if $item.amount==0}
                    己无效
                    {else}
                    <a href="index.php?user&q=code/borrow/alienate_detail&borrow_right_id={$item.borrow_right_id}">债权转让</a>{/if}</td>
				</tr>
				{/foreach}
				<tr >
					<td colspan="11" class="page">
						{$loop.showpage}
					</td>
				</tr>
				{/list}
			</form>	
		</table>
		<!--债权转让 结束-->
		<!--  add for bug 21 end -->
		
		
		{elseif $_U.query_type=="myuser_account"}
		<!--我的客户统计 结束-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >时间</td>
					<td  >成功借款</td>
					<td  >成功投资</td>
					<td  >VIP数</td>
				</tr>
					{loop  module="borrow" function="GetMyuserAcount" var="var" user_id="0" }
				<tr >
					<td>{$key|date_format:"Y-m"}</td>
					<td>￥{$var.borrow|default:0}</td>
					<td>￥{$var.tender|default:0}</td>
					<td>{$var.vip|default:0}个</td>
				</tr>
				{/loop}
			</form>	
		</table>
		{/list}
		<!--我的客户统计 结束-->
		
		
		
		<!--还款明细 开始-->
		{elseif $_U.query_type=="repayment_view"}
		<div class="user_right_border">
			<div class="l">标题：</div>
			<div class="c">
				{$_U.borrow_result.name}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> 借款金额：</div>
			<div class="rb">
				<font color="#FF0000"><strong>￥{$_U.borrow_result.account}</strong></font>
			</div>
			<div class="l"> 借款利率：</div>
			<div class="rb">
				 {$_U.borrow_result.apr}%
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> 借款期限：</div>
			<div class="rb">
{if $_U.borrow_result.isday==1}{$_U.borrow_result.time_limit_day}天{else}{$_U.borrow_result.time_limit}个月{/if}
			</div>
			<div class="l"> 还款方式：</div>
			<div class="rb">
				 {$_U.borrow_result.style|linkage:"borrow_style"}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> 发布时间：</div>
			<div class="rb">
				 {$_U.borrow_result.addtime|date_format:"Y-m-d H:i:s"}
			</div>
			<div class="l"> 借款时间：</div>
			<div class="rb">
				 {$_U.borrow_result.verify_time|date_format:"Y-m-d H:i:s"}
			</div>
		</div>
		<!--
		<div class="user_right_border">
			<div class="l"> 下次还款时间：</div>
			<div class="rb">
				 {$_U.borrow_result.username}
			</div>
			<div class="l"> 下次还款金额：</div>
			<div class="rb">
				 {$_U.user_result.username}
			</div>
		</div>
		-->
		<!--还款明细 结束-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >序号</td>
					<td  >计划还款日</td>
					<td  >计划还款本息</td>
					<td  >实还日期</td>
					<td  >实还本息</td>
					<td  >逾期罚息</td>
					<td  >逾期天数</td>
					<td  >状态</td>
					<td  >操作</td>
				</tr>
				{loop module="borrow" function ="GetRepaymentList" " user_id="0" id="request" limit="all" order="order"}
			
				<tr {if $key%2==1} class="tr1"{/if}>
					<td >{$var.order+1}</td>
					<td>{$var.repayment_time|date_format:"Y-m-d"}</td>
					<td>￥{$var.repayment_account}</td>
					<td>{$var.repayment_yestime|date_format:"Y-m-d H:i"|default:-}</td>
					<td>￥{$var.repayment_yesaccount}</td>
					<td>￥{$var.late_interest|default:0}</td>
					<td>{$var.late_days|default:0}天</td>
					<td>{if $var.status==1}已还{elseif $var.status==2}网上垫付{else}待还款{/if}</td>
					<td>{if $var.status==1}-{else}<a href="#" onclick="javascript:if(confirm('你确定要偿还此借款吗？')) location.href='{$_U.query_url}/repay&id={$var.id}'">还款</a>{/if}</td>
				</tr>
				{/loop}
			</form>	
		</table>
		<div class="user_right_foot">注：带有“(预计)”标记的金额说明该金额并非实际还款的金额，它只是假设以当前时间为还款时间的情况下用户将要还多少金额。 最终还款金额请以实际还款金额为准，因为预计的金额跟实际还款的金额可能会有所差异。 一次性全额还清将多支付下个月的利息。不记录还款状态，不增加还款积分。
		</div>
		{/if}
		<script>
var url = "{$_U.query_url}/{$_U.query_type}";
var type = "{$magic.request.type}";
var status = "{$magic.request.status}";
{literal}
function sousuo(){

	var _url = "";
	var dotime1 = jQuery("#dotime1").val();

	var keywords = jQuery("#keywords").val();
	var username = jQuery("#username").val();
	var dotime2 = jQuery("#dotime2").val();
	if (username!=null){
		 _url += "&username="+username;
	}
	if (keywords!=null){
		 _url += "&keywords="+keywords;
	}
	if (dotime1!=null){
		 _url += "&dotime1="+dotime1;
	}
	if (dotime2!=null){
		 _url += "&dotime2="+dotime2;
	}
        if(type!=""){
            _url += "&type="+type;
        }
        if(status!=""){
            _url += "&status="+status;
        }
        
	location.href=url+_url;
 
}

</script>
{/literal}
</div>
</div>
</div>
</div>
<!--用户中心的主栏目 结束-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}