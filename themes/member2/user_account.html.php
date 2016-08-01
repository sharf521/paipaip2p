<?php
!defined('IN_TEMPLATE') && exit('Access Denied');

?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--用户中心的主栏目 开始-->
 <div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 mar10">
	<!--左边的导航 开始-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--左边的导航 结束-->
	
	<!--右边的内容 开始-->
	<div class="user_right">
		<div class="user_right_menu">
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="list"} class="cur"{/if}><a href="{$_U.query_url}">账户详情</a></li>
				<li {if $_U.query_type=="bank"} class="cur"{/if}><a href="{$_U.query_url}/bank">银行账号</a></li>
				<li {if $_U.query_type=="recharge_new"} class="cur"{/if}><a href="{$_U.query_url}/recharge_new">账户充值</a></li>
				<li {if $_U.query_type=="recharge"} class="cur"{/if}><a href="{$_U.query_url}/recharge">充值记录</a></li>
				<li {if $_U.query_type=="cash_new"} class="cur"{/if}><a href="{$_U.query_url}/cash_new">账户提现</a></li>
				<li {if $_U.query_type=="cash"} class="cur"{/if}><a href="{$_U.query_url}/cash">提现记录</a></li>
				<li {if $_U.query_type=="log"} class="cur"{/if}><a href="{$_U.query_url}/log">资金明细</a></li>
				<!--<li {if $_U.query_type=="l2m"} class="cur"{/if}><a href="{$_U.query_url}/l2m">账户转账</a></li>
				<li {if $_U.query_type=="awardlog"} class="cur"{/if}><a href="{$_U.query_url}/awardlog">奖励日志</a></li>-->
				{if $_G.system.con_stock_valid=="1"}
				<li {if $_U.query_type=="stock_manage"} class="cur"{/if}><a href="{$_U.query_url}/stock_manage">股份管理</a></li>
				{/if}
			</ul>
		</div>
		
		<div class="user_right_main">
		
		<!--资金使用记录列表 开始-->
		{if $_U.query_type=="log"}
		<div class="user_main_title well" style="height:60px; padding-top:7px;"> 
		记录时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="全部" } <input value="搜索" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" /> 
                <br>
			<div class="alert">交易流水总计：￥{$_U.account_num|default:0} (备注：此金额非账户总额，只是账户历史所有交易涉及资金总和！)</div>	
		</div>	
			<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			  <form action="" method="post">
				<tr class="head">
					<td>类型</td>
					<td>操作金额</td>
					<td>总金额</td>
					<td>可用金额</td>
					<td>冻结金额</td>
					<td>待收金额</td>
					<td>交易对方</td>
					<td>记录时间</td>
					<td width="130">备注信息</td>
				</tr>
				{ foreach  from=$_U.account_log_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.type|linkage:"account_type"}</td>
					<td>￥{ $item.money}</td>
					<td>￥{ $item.total}</td>
					<td>￥{ $item.use_money}</td>
					<td>￥{ $item.no_use_money|default:0}</td>
					<td>￥{ $item.collection}</td>
					<td><a href="/u/{$item.to_user}" target="_blank">{ $item.to_username|default:admin}</a></td>
					<td>{ $item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<td width="130">{ $item.remark}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="11" class="page">
						{$_U.show_page}
					</td>
				</tr>
			</form>	
		</table>
		<!--资金使用记录列表 结束-->
		<!--资金使用记录列表 开始-->
		{elseif $_U.query_type=="awardlog"}
		<div class="user_main_title well" style="height:60px; padding-top:7px;"> 
		记录时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="全部" } <input value="搜索" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" /> 
                <br>
		</div>	
			<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			  <form action="" method="post">
				<tr class="head">
					<td>类型</td>
					<td>操作金额</td>
					<td>记录时间</td>
					<td width="130">备注信息</td>
				</tr>
				{ foreach  from=$_U.award_log_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.type|linkage:"award_type"}</td>
					<td>￥{ $item.award}</td>
					<td>{ $item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<td width="130">{ $item.remark}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="11" class="page">
						{$_U.show_page}
					</td>
				</tr>
			</form>	
		</table>
		<!--资金使用记录列表 结束-->
		{elseif $_U.query_type=="stock_manage"}
		<!--股份管理 开始-->
		
		<div class="user_help alert" style="text-align:left;text-indent :24px;">当前余额{$_U.account_result.use_money}元。股份数{$_U.account_result.stock}。
		</div>
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
		<form cur="" method="post">
		<div class="user_right_border">
			<div class="e">申请者：</div>
			<div class="c">
				{$_G.user_result.username}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> 申请类型：</div>
			<div class="c">
				<select name="optype">
				<option value="0" {if $magic.request.optype=="0"} selected="selected"{/if}>购买</option>
				<option value="1" {if $magic.request.optype=="1"} selected="selected"{/if}>售出</option>
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> 申请份数：</div>
			<div class="c">
				<input type="text" name="num" value="" onkeyup="value=value.replace(/[^0-9]/g,'')"/> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> 股份价格：</div>
			<div class="c">
				{$_G.system.con_stock_price}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">详细说明：</div>
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
		</form>
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >申请时间</td>
					<td  >申请类型</td>
					<td  >申请份数</td>
					<td  >交易金额</td>
					<td  >备注说明</td>
					<td  >状态</td>
					<td  >审核时间</td>
					<td  >审核备注</td>
				</tr>
				{list module="account" var="loop" function ="GetStockApplyList" showpage="3" user_id="0"  }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.addtime|date_format}</td>
					<td width="70">{if $item.optype=="0"}购买{elseif $item.optype=="1"}售出{/if}</td>
					<td  >{$item.num}</td>
					<td  >{$item.trade_account}</td>
					<td  width="200">{$item.remark}</td>
					<td  >{if $item.status==0}正在审核{elseif $item.status==1}审核通过{else}审核不通过{/if}</td>
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
		
		<!--股份管理 结束-->
		{/if}
		<!--充值记录列表 开始-->
		{elseif $_U.query_type=="recharge"}
		<!-- 
		<div class="user_help alert">成功充值{$_U.account_log.recharge_success|default:0}元，线上成功充值{$_U.account_log.recharge_online|default:0}元，线下成功充值{$_U.account_log.recharge_downline|default:0}元,，手动成功充值{$_U.account_log.recharge_shoudong|default:0}元
</div>
		 -->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
		<form action="" method="post">
			<tr class="head" >
			<td>类型</td>
			<td>支付方式</td>
			<td>充值金额</td>
			<!-- 
			<td>奖励红包</td>
			 -->
			<td>备注</td>
			<td>充值时间</td>
			<td>状态</td>
			<td>管理备注</td>
			</tr>
			{list module="account" function="GetRechargeList" showpage="3" var="loop" status="1" user_id="0" epage=20}
			{ foreach  from=$loop.list key=key item=item}
			<tr  {if $key%2==1} class="tr1"{/if}>
			<td>{if $item.type==1}网上充值{else}线下充值{/if}</td>
			<td>{ $item.payment_name|default:"手动充值"}</td>
			<td><font color="#FF0000">￥{ $item.money}</font></td>
			<!-- 
			<td>{ $item.hongbao}</td>
			 -->
			<td>{ $item.remark}</td>
			<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td>{if $item.status==0}审核中{elseif  $item.status==1} 充值成功 {elseif $item.status==2}充值失败{/if}</td>
			
			<td>{ $item.verify_remark|default:"-"}</td>
			</tr>
			{ /foreach}
			<tr >
				<td colspan="11" class="page">{$loop.showpage}</div>
				</td>
			</tr>
			{/list}
		</form>	
		</table>
		<!--充值记录列表 结束-->
		
		<!--提现记录列表 开始-->
		{elseif $_U.query_type=="cash"}
		<div class="user_help alert">成功提现{$_U.cash_log.cash_success.money|default:0}元，提现到账{$_U.cash_log.cash_success.credited|default:0}元，手续费{$_U.cash_log.cash_success.fee|default:0}元
</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			<form action="" method="post">
				<tr class="head">
					<td>提现银行</td>
					<td>提现账号</td>
					<td>提现总额</td>
					<td>到账金额</td>
					<td>手续费</td>
					<td>提现时间</td>
					<td>状态</td>
					<td>操作</td>
				</tr>
				{ foreach  from=$_U.account_cash_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.bank_name}</td>
					<td>{ $item.account}</td>
					<td>￥{ $item.total|default:0}</td>
					<td>￥{ $item.credited|default:0}</td>
					<td>￥{ $item.fee|default:0}</td>	
					<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
					<td>{if $item.status==0}审核中{elseif  $item.status==1} 提现成功 {elseif $item.status==2}提现失败 {elseif $item.status==3}用户取消{/if}</td>
					<td>{if $item.verify_remark!=""}{$item.verify_remark}{else}{if $item.status==0}<a href="#" onclick="javascript:if(confirm('确定要取消此提现申请')) location.href='{$_U.query_url}/cash_cancel&id={$item.id}'">取消提现</a>{else}-{/if}{/if}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="11" class="page">
						{$_U.show_page}
					</td>
				</tr>
			</form>	
		</table>
		<!--提现记录列表 结束-->
		
		<!--账号充值 开始-->
		{elseif $_U.query_type=="recharge_new"}
		<div class="user_help alert">
                    * 温馨提示：网上银行充值过程中请耐心等待,充值成功后，请不要关闭浏览器,充值成功后返回{$_G.system.con_webname},
                    充值金额才能打入您的账号。
                    <br>* <font color="red">在线充值，手续费全免哦！</font>


</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">真实姓名：</div>
			<div class="c">
				{$_G.user_result.realname}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">联系Email：</div>
			<div class="c">
				{$_G.user_result.email}
			</div>
		</div>
		<form action="" method="post" name="form1"  onsubmit = "return check();" target="_blank">
		<div id="returnpay">
		<div class="user_right_border" style="display:none">
			<div class="l" style="font-weight:bold;">充值方式：</div>
			<div class="c">
				<input type="radio" name="type"  id="type"  class="input_border" checked="checked" onclick="change_type(1)" value="1"  /> 网上充值
                <input type="radio" name="type"  id="type" class="input_border"  value="2"  onclick="change_type(2)" /> 线下充值 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">充值金额：</div>
			<div class="c">
                       
				<input type="text" name="money"  class="input_border" value="" size="10" onkeyup="commit(this);" maxlength="9" id="txt_money"/> 元 <span id="realacc">实际入账：<font color="#FF0000" id="real_money">0</font> 元</span>
			</div>
		</div>
                    <div id="type_net" class="disnone">
			<div class="user_right_border">
				<div class="l" style="font-weight:bold;">充值类型：</div>
				<div class="c">
						<font color="red">以下银行是使用个人网上银行支付，只需开通个人网上银行即可!</font>
<style type="text/css">
{literal}
#ban table td{height:40px; line-height:40px;padding-right:30px;padding-bottom:10px; }
#ban table tr{height:40px; line-height:40px; }
#ban table img{width:125px; height:33px;float:left;}
#ban table input{border:none;width:20px; height:30px;float:left;}
{/literal}
</style>
		<div id="ban">
		
          <table width="100%" cellpadding="3" cellspacing="3">
      
           <tr>
             <td width="160"><input type="radio" name="payment1" value="ICBC_25" checked="checked"/>
             <img src="../data/bank/ICBC_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="ABC_29"/>
             <img src="../data/bank/ABC_OUT.gif" border="0"/></td>
             <td  width="160"><input type="radio" name="payment1" value="CCB_27"/>
             <img src="../data/bank/CCB_OUT.gif" border="0"/></td>
           </tr>
           <tr>
             <td><input type="radio" name="payment1" value="CMB_28"/>
             <img src="../data/bank/CMB_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="CMBC_12"/>
             <img src="../data/bank/CMBC_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="HXBC_13"/>
             <img src="../data/bank/hx.jpg" border="0"/></td>
           </tr>
           <tr>
             <td><input type="radio" name="payment1" value="CITIC_33"/>
             <img src="../data/bank/CITIC_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="CEB_36"/>
             <img src="../data/bank/CEB_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="CIB_09"/>
             <img src="../data/bank/CIB_OUT.gif" border="0"/></td>
           </tr>
           <tr>
             <td><input type="radio" name="payment1" value="PSBC_PSBC"/>
             <img src="../data/bank/yz.jpg" border="0"/></td>
             <td><input type="radio" name="payment1" value="BOC_45">
             <img src="../data/bank/BOC_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="BOCOM_21"/>
             <img src="../data/bank/COMM_OUT.gif" border="0"/></td>
           </tr>
           <tr>
             <td><input type="radio" name="payment1" value="GDB_GDB" />
             <img src="../data/bank/GDB_OUT.gif" border="0"/></td>
             <td><input type="radio" name="payment1" value="SPDB_16">
             <img src="../data/bank/pf.jpg" border="0"/></td>
             <td></td>
           </tr>
         </table>
         <!--今后贷-双乾支付
         <table width="100%">
         <tr>
           <td><input type="radio" name="payment1" value="shuangq" />
           <img src="../data/bank/shq.png" border="0"/>双乾支付（第三方支付，支持更多银行，无手续费！）</td>
         </tr>
         <tr>
           <td><input type="radio" name="payment1" value="" />
           <img src="../data/bank/hch.png" border="0"/>汇潮支付（第三方支付，支持更多银行，无手续费！）</td>
         </tr>
         </table>-->	   
				
		</div>

                  {foreach from=$_U.account_payment_list item="var"}
					{if $var.nid!="offline"}
					<input type="radio" name="payment1"  class="input_border"   value="{$var.id}" id="payment1"  /> {$var.name} <input type="hidden" name="payname{$var.id}" value="{$var.name}" />({$var.description}) <br />
					{/if}
				  {/foreach}                 
				</div>
			</div>
		</div>

		
                    <div id="type_now"  style="display:none">
			<div class="user_right_border">
                                
				<div class="l" style="font-weight:bold;">充值银行：
                                </div>
                                
				<div class="c">
                                    <div>
                                <font color="red">线下充值如遇到问题，请马上与客服联系；<br>
（1）<strong><font color="blue">有效充值登记时间为:周一至周五的9:30到16:00</font></strong>，充值成功请跟我们的客服联系。<br>
								</font></div>
					<div>
					{foreach from=$_U.account_payment_list item="var"}
					{if $var.nid=="offline" && $var.areaid==$_G.areaid}
					<input type="radio" name="payment2"  class="input_border" value="{$var.id}"  checked/><!--{$var.name}  <br />-->{$var.description}<br />
					{/if}
					{/foreach}
					</div>
				</div>
			</div>
			<div class="user_right_border">
				<div class="l" style="font-weight:bold;">线下充值备注：</div>
				<div class="c">
					<input type="text" name="remark"  class="input_border" value="" size="30" /><br>（请注明您的用户名，转账银行卡号和转账流水号，以及转账时间，谢谢配合）
				</div>
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold; float:left;">验证码：</div>
			<div class="c" >
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"  style="float:left;width:100px;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();"  style="cursor:pointer;width:50px;" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		</div>
		
		
		{literal}
		
		<script>
		function check(){
			var aa = "";
			aa = $("input[name=type]:checked").val();
			if(aa == 2)
			{
				/*if (!ctype()){
					alert('请选择充值的银行');
					return false;
				}*/
				var recharge2_remark = document.getElementById("recharge2_remark").value;
				if(recharge2_remark == ""){
					alert('线下充值备注必须填写！');
					return false;
				}
			}
			else
			{
				var txt_money_v = document.getElementById("txt_money").value;
				txt_money_v=parseFloat(txt_money_v); 
				if(txt_money_v < 0 )
				{
					alert('单笔充值金额不能低于80元！');
					return false;	
				}	
			}
		}
			function change_type(type){
          
				if (type==2){
                                    
                                    document.getElementById("type_net").style.display="none";
                                    document.getElementById("type_now").style.display="";
                                    document.getElementById("realacc").style.display="none";
				    //$("#type_net").addClass("dishide");
				    //$("#type_now").removeClass();
				    //$("#realacc").hide();
				}else{
                                    document.getElementById("type_now").style.display="none";
                                    document.getElementById("type_net").style.display="";
                                    document.getElementById("realacc").style.display="";
				    //$("#type_now").addClass("dishide");
				    //$("#type_net").removeClass();
				    //$("#realacc").show();
				}
				
			}
		function payment (){
	 		var type = GetRadioValue("type");
			if (type==1){
				$("#returnpay").html("<font color='red'>请到打开的新页面充值</font>");
				
			}
			
		}
		function ctype(){
		var resualt=false;
		
			for(var i=0;i<document.form1.payment2.length;i++)
			{
				
				if(document.form1.payment2[i].checked)
				{
				  resualt=true;
				}
			}
			return resualt;
		}
        function commit(obj) {
			obj.value=obj.value.replace(/[^0-9.]/g,'');
            if (parseFloat(obj.value) > 0 ) 
            {
//                var realMoney = Math.round(parseFloat(obj.value)) / 100;

//                if (realMoney > 50) realMoney = 50;

//                document.getElementById("hspanReal").innerText = Math.round(parseFloat(obj.value)*10)/10 - realMoney;


                var realMoney=parseFloat(obj.value);
                /*
                if(realMoney>=5000)
                {
                    document.getElementById("real_money").innerText = realMoney - 50;
                }
                else 
                {
                    document.getElementById("real_money").innerText = parseInt(realMoney*0.99*100)/100;
                }
            }else{
				 var realMoney=parseFloat(obj.value);
                 document.getElementById("real_money").innerText = realMoney ;
			}
                        */
                        document.getElementById("real_money").innerText = realMoney ;
            }
        }
    </script>
		{/literal}
		<div class="user_right_foot alert" style="text-align:left; line-height:20px;">
		{$_G.system.con_webname}禁止信用卡套现、虚假交易等行为,一经发现将予以处罚,包括但不限于：限制收款、冻结账户、永久停止服务,并有可能影响相关信用记录。<br />
        	单笔充值金额不能低于80元。
		</div>
		
		<!--账号充值 结束-->
		
		
		<!--银行账号 开始-->
		{elseif $_U.query_type=="bank"}
		<div class="user_help alert" style="text-align:left;text-indent :24px;">{$_G.system.con_webname}禁止信用卡套现、虚假交易等行为,一经发现将予以处罚,包括但不限于：限制收款、冻结账户、永久停止服务,并有可能影响相关信用记录。
</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">真实姓名：</div>
			<div class="c">
				{$_U.account_bank_result.realname}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">登陆用户名：</div>
			<div class="c">
				{$_U.account_bank_result.username}
			</div>
		</div>
		
		{if $_U.account_bank_result.bank!=""}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">开户银行：</div>
			<div class="c">
				{$_U.account_bank_result.bank|linkage}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">开户行名称：</div>
			<div class="c">
				{$_U.account_bank_result.branch}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">银行账号：</div>
			<div class="c">
				{$_U.account_bank_result.account_view}
			</div>
		</div>
		{/if}
		<div class="user_right_foot">
		</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">开户银行：</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=bank&nid=account_bank&value={$_U.account_bank_result.bank}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">开户行名称：</div>
			<div class="c">
				<input type="text" name="branch" value="" data-content="**分行**支行**分理处或营业部(如：上海分行杨浦支行控江路分理处),
		    如果您无法确定,建议您致电您的开户银行客服进行询问。 " id="infokaih" />
			</div>

		</div>
		
		<div class="user_right_border" style="margin-left:0px">
			<div class="l" style="font-weight:bold;">银行账号：</div>
			<div class="c">
				<input type="text" name="account" value="" onkeyup="value=value.replace(/[^0-9]/g,'')" id="infoyhzh" data-content="特别提醒：上述银行卡号的开户人姓名必须为“{$_U.account_bank_result.realname}”, 个人银行账号必须填写正确,否则你的提现资金将存在风险。
                    如果要修改的话必须要补全, 可以任何时候修改以您的姓名开户的银行卡号。" />
			</div>
			<div class="l" style="font-weight:bold;"></div>

		</div>
		
		{if $_G.sms_available == 1}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">手机验证：</div>
			<div class="c">
				<input type="text" name="mobilecode"  maxlength="6"  />&nbsp;&nbsp;<input id="codetime" name="codetime" type="button" value="发送验证码"/>
			</div>
		</div>
		{/if}		
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="hidden" name="user_id" value="{$_G.user_id}" />
				<input type='hidden' name='oid' value='<?php echo date('YmdHis');?>'/> 
				<input type="submit" class="btn-action"  name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* 温馨提示：禁止信用卡套现
		</div>
		{literal}
				<script language="javascript">
				$("#codetime").click(function() {
					
					$.ajax({
							 url: "/index.php?user&q=code/account/cash_new_sms&itype=2&random="+Math.random(),
						     //    timeout: 20000,
										 success: function(msg){  
										//alert(msg);  
											if (msg=="1")
											{
												SysSecond=5*60;
												$("#codetime").attr({"disabled":"disabled"}); 
												InterValObj = window.setInterval(SetRemainTime, 1000); 
											}else
											{
													$("#codetime").attr({"value":"重新发送"});	
											}
									} ,
							 error: function (xmlHttpRequest, error) {
							     alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				 

				});
				//将时间减去1秒，计算天、时、分、秒 
				  function SetRemainTime() { 
				   if (SysSecond > 0) { 
				    SysSecond = SysSecond - 1; 
				    var second = Math.floor(SysSecond % 60);             // 计算秒     
				    var minite = Math.floor((SysSecond / 60) % 60);      //计算分 
				    var hour = Math.floor((SysSecond / 3600) % 24);      //计算小时 
				    var day = Math.floor((SysSecond / 3600) / 24);        //计算天 
					$("#codetime").attr({"value":minite+"分"+second+"秒"});
				   } else {
				    window.clearInterval(InterValObj); 
					$("#codetime").attr({"value":"重新发送"});	
						$("#codetime").removeAttr("disabled");

				   } 
				  } 
				    
				</script>
		{/literal}
		<!--银行账号 结束-->

		<!--向商城转帐 开始-->
		{elseif $_U.query_type=="l2m"}
		<div class="user_help alert" style="text-align:left;text-indent :24px;">当前可转余额{$_U.account_bank_result.tran_amount}元。可转充值奖励利息{$_U.account_bank_result.award_interest}元。
		</div>
		
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">转到商城：</div>
			<div class="c">
				<input type="radio" name="malltype"  id="malltype"  class="input_border" checked="checked"  value="gx"  /> 供销商城<input type="radio" name="malltype"  id="malltype" class="input_border" {if $_U.malltype == 'jf'}checked="checked"{/if} value="jf"  /> 积分商城 
			</div>
		</div>		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">转帐类型：</div>
			<div class="c">
				<input type="radio" name="trantype"  id="trantype"  class="input_border" {if $_U.trantype == 'amount'}checked="checked"{/if} value="amount"  /> 可用余额<input type="radio" name="trantype"  id="trantype" class="input_border" {if $_U.trantype == 'award'}checked="checked"{/if} value="award"  /> 充值奖励已赚利息 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">转账金额：</div>
			<div class="c">
				<input type="text" name="amount" onkeyup="value=value.replace(/[^0-9.]/g,'')" />
			</div>
		</div>

		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">交易密码：</div>
			<div class="c">
				{if $_U.account_bank_result.paypassword==""}<a href="{$_U.query_url}&q=code/user/paypwd"><font color="#FF0000">请先设置一个支付密码</font></a>{else}<input type="password" name="paypassword" />{/if}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		<!--向商城转帐 结束-->		
		
		<!--提现 开始-->
		{elseif $_U.query_type=="cash_new"}
                
                



		<div class="user_help alert" style="text-align:left;">
		{article module="dynacontent" function="GetOneBytype" var="dynac" areaid="$_G.areaid" type_id="3"}
        {$dynac.content}
		{/article}
		</div>
		<form action="" method="post" onsubmit="return check_form()" name="form1">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">真实姓名：</div>
			<div class="c">
				{$_G.user_result.realname}
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">提现的银行：</div>
			<div class="c">
				{$_U.account_bank_result.bank|linkage} {$_U.account_bank_result.branch} {$_U.account_bank_result.account_view} 
			</div>
		</div>
                    
		{article module="borrow" function="GetCashMaxAmount"  user_id="$_G.user_id"  article_id="0"}
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">可用余额：</div>
			<div class="c">
				{$var.use_money|default:0}元
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">限制提现金额：</div>
			<div class="c">
				{$var.nocash_money|default:0}元
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">已使用非提现充值奖励：</div>
			<div class="c">
				{$var.used_award|default:0}元
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">正在申请提现：</div>
			<div class="c">
				{$var.cashingAmount|default:0}元
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">还可申请的最大提现：</div>
			<div class="c">
				{$var.maxCashAmount|default:0}元
			</div>
		</div>
                
        <input type="hidden" name="maxCashAmount" id="maxCashAmount" value="{$var.maxCashAmount}">
		{/article}
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">交易密码：</div>
			<div class="c">
				{if $_U.account_bank_result.paypassword==""}<a href="{$_U.query_url}&q=code/user/paypwd"><font color="#FF0000">请先设置一个支付密码</font></a>{else}<input type="password" name="paypassword" />{/if}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">提现金额：</div>
			<div class="c">
				<input type="text" name="money"   onkeyup="value=value.replace(/[^0-9.]/g,'')" />
			</div>
		</div>
		{if $_G.sms_available == 1}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">手机验证：</div>
			<div class="c">
				<input type="text" name="mobilecode"  maxlength="6"  />&nbsp;&nbsp;<input id="codetime" name="codetime" type="button" value="发送验证码"/>
			</div>
		</div>		
		{/if}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">动态口令(可选)：</div>
			<div class="c">
				<input type="text" name="uchoncode"  maxlength="6"  />
			</div>
		</div>
{literal}
				<script language="javascript">
				$("#codetime").click(function() {
					
					$.ajax({
							 url: "/index.php?user&q=code/account/cash_new_sms&itype=1&random="+Math.random(),
						     //    timeout: 20000,
										 success: function(msg){  
										//alert(msg);  
											if (msg=="1")
											{
												SysSecond=5*60;
												$("#codetime").attr({"disabled":"disabled"}); 
												InterValObj = window.setInterval(SetRemainTime, 1000); 
											}else
											{
													$("#codetime").attr({"value":"重新发送"});	
											}
									} ,
							 error: function (xmlHttpRequest, error) {
							     alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				 

				});
				//将时间减去1秒，计算天、时、分、秒 
				  function SetRemainTime() { 
				   if (SysSecond > 0) { 
				    SysSecond = SysSecond - 1; 
				    var second = Math.floor(SysSecond % 60);             // 计算秒     
				    var minite = Math.floor((SysSecond / 60) % 60);      //计算分 
				    var hour = Math.floor((SysSecond / 3600) % 24);      //计算小时 
				    var day = Math.floor((SysSecond / 3600) / 24);        //计算天 
					$("#codetime").attr({"value":minite+"分"+second+"秒"});
				   } else {
				    window.clearInterval(InterValObj); 
					$("#codetime").attr({"value":"重新发送"});	
						$("#codetime").removeAttr("disabled");

				   } 
				  } 
				    
				</script>
{/literal}			
{literal}
<script language="javascript">
       function commit(obj) {
            if (parseFloat(obj.value) > 0 )
            {
                var realMoney=parseFloat(obj.value);
                var inputValue=parseFloat(obj.value);
					//alert(inputValue);
                if(inputValue<=30000 && inputValue>100){
                    //alert(inputValue);
                    realMoney=parseFloat(inputValue-3);
                }else if(30000<inputValue && inputValue<=50000){
                    //alert("2");
                    realMoney=parseFloat(inputValue-5);
                }else if((userMoney < 300000&&inputValue>50000) || inputValue <100){
                    alert("您好，提现资金不能低于100元高于50000元");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }else if(userMoney >=300000 && (inputValue<300000 && inputValue>50000)){
                    alert("您好，大额提现资金必须是30万~50万之间 ");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }else if(userMoney >=300000 && inputValue > 500000){
                    alert("您好，大额提现资金不能大于50万 ");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }

             // add by alpha for bug 12 begin 修改可提现金额
             	var maxCashAmount = document.getElementById("maxCashAmount").value;
             	if (inputValue > maxCashAmount){
             		alert("您好，提现资金不能大于可提现金额！");
                }
             // add by alpha for bug 12 end 修改可提现金额
                var cashAmount;
                cashAmount = parseFloat(obj.value);
                
                getCashFeeValue(cashAmount);
                //document.getElementById("real_money").innerText = realMoney ;
            }
        }
        
        function getCashFeeValue(cashAmount){
           
                var yValue = document.getElementById("cashGoodAmount").value;
				var hongbao = document.getElementById("hongbao").value;
                var hongbaoUsed = 0;
				
                var caseFee;
                if(cashAmount<=1500 || yValue<=1500){
                    caseFee = 0.002*cashAmount; 
                }else if(yValue >= cashAmount){
                    if(cashAmount>1500 && cashAmount<=30000){
                        caseFee=3;
                    }else{
                        caseFee=5;
                    }
                }else if(yValue < cashAmount){
                    if(yValue>1500 && yValue<=30000){
                        caseFee=3+(cashAmount-yValue)*0.002;
                    }else{
                        caseFee=5+(cashAmount-yValue)*0.002;
                    }
                }
				
				if(caseFee>=hongbao){
					hongbaoUsed=hongbao*1;
				}else{
					hongbaoUsed=caseFee*1;
				}
				
                document.getElementById("real_money").innerText = changeTwoDecimal(cashAmount*1-caseFee*1+hongbaoUsed*1);
				document.getElementById("hongbaoUsed").value = changeTwoDecimal(hongbaoUsed);
				document.getElementById("hongbao_used").innerText = changeTwoDecimal(hongbaoUsed);
				
        }
        
        function changeTwoDecimal(x)
        {
            var f_x = parseFloat(x);
            if (isNaN(f_x))
            {
                alert('function:changeTwoDecimal->parameter error');
                return false;
            }
            var f_x = Math.round(x*100)/100;
            return f_x;
        }
</script>
{/literal}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">验证码：</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4" style="float:left;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="点击刷新" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();"  style="cursor:pointer;" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="hidden" name="user_id" value="{$_G.user_id}" />
				<input type="submit" class="btn-action"  name="name"  value="确认提交" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* 温馨提示：禁止信用卡套现
		</div>
		
<script>

var cash_maxamount = {$_G.system.con_cash_maxamount|default:50000};
{literal}
function check_form(){
	 var frm = document.forms['form1'];
	 var paypassword = frm.elements['paypassword'].value;
	 var money = frm.elements['money'].value;
	 var maxCashAmount = document.getElementById("maxCashAmount").value;
	 var errorMsg = '';
	  if (paypassword.length == 0 ) {
		errorMsg += '请输入您的交易密码' + '\n';
	  }
	  if (money.length == 0 ) {
		errorMsg += '请输入你的提现金额' + '\n';
	  }
	 if (money <0 || money >cash_maxamount) {
		errorMsg += '提现金额要少于' + cash_maxamount + '\n';
	  }
	 
	 if (parseFloat(money) > parseFloat(maxCashAmount)) {
		errorMsg += '您的提现金额大于最大可提现额' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}
		<!--提现 结束-->
				{else}
				{literal}
				<? $this->magic_vars['day7'] = time()-6*60*60*24;?>
				<? $this->magic_vars['nowtime'] = time();?>
				{/literal}
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		发布时间：<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> 到 <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		<input value="搜索" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" />
		</div>	
		{article module="borrow" function="GetUserLog" user_id="0"}

				<div style="line-height:30px; font-size:15px; font-weight:bold">个人资金详情</div>
				<div class="user_right_border">
					<div class="linvest">账户总额：<strong>￥{$var.total|default:0}</strong></div>
					
					<div class="linvest">可用余额：<font color="#FF0000">￥{$var.use_money|default:0}</font></div>
					
					<div class="linvest">冻结金额：￥{$var.no_use_money|default:0}</div>
					
				</div><div class="user_right_border">
					<div class="linvest">投标冻结总额：￥{$var.tender|default:0}</div>
					<div class="linvest">充值成功总额：￥{$var.recharge_success|default:0}</div>
					<div class="linvest">提现成功总额：￥{$var.cash_success.money|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">在线充值总额：￥{$var.recharge_online|default:0}</div>
					<div class="linvest">线下充值总额：￥{$var.recharge_downline|default:0}</div>
					<div class="linvest">手动充值总额：￥{$var.recharge_shoudong|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">总手续费：￥{$var.fee+$var.recharge_fee|default:0}</div>
					<div class="linvest">充值手续费：￥{$var.fee|default:0}</div>
					<div class="linvest">提现手续费：￥{$var.recharge_fee|default:0}</div>
				</div>
				<div style="line-height:30px; font-size:15px; font-weight:bold">投资资金详情</div>
			
				<div class="user_right_border">
					<div class="linvest">投标总额：￥{$var.invest_account|round:"2"|default:0}</div>
					<div class="linvest">借出总额：￥{$var.success_account|round:"2"|default:0}</div>
					<div class="linvest">奖励收入总额：￥{$var.award_add|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">待回收总额：￥{$var.r_collection_total|default:0}</div>
					<div class="linvest">待回收金额：￥{$var.r_collection_capital|default:0}</div>
					<div class="linvest">待回收利息：￥{$var.r_collection_interest|round:"2"|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">已回收总额：￥{$var.collection_yes|default:0}</div>
					<div class="linvest">已回收金额：￥{$var.collection_capital1|default:0}</div>
					<div class="linvest">已回收利息：￥{$var.collection_interest1|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">网站垫付总额：￥{$var.num_late_repay_account|default:0}</div>
					<div class="linvest">逾期罚金收入：￥{$var.late_collection|default:0}</div>
					<div class="linvest">损失利息总额：￥{$var.num_late_interes|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">最近收款日期：{$var.r_collection_last_time|date_format:"Y-m-d"|default:-}</div>
				</div>
				<div style="line-height:30px; font-size:15px; font-weight:bold">贷款资金详情</div>
			

				<div class="user_right_border">
					<div class="linvest">借款总额：￥{$var.borrow_num|default:0}</div>
					<div class="linvest">已还总额：￥{$var.borrow_num1|default:0}</div>
					<div class="linvest">未还总额：￥{$var.wait_payment|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">发标次数：{$var.borrow_times|default:0}</div>
					<div class="linvest">还款标数：{$var.payment_times|default:0}</div>
					<div class="linvest">待还笔数：{$var.borrow_repay0|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">最近还款日期：{$var.new_repay_time|date_format:"Y-m-d"}</div>
					<div class="linvest">最近应还款金额：￥{$var.new_repay_account|default:0}</div>
				</div>
				<!--  add for bug 274 begin -->
 				{if $_G.system.con_circulation=="1"}
				<div style="line-height:30px; font-size:15px; font-weight:bold">流转标详情</div>
				<div class="user_right_border">
					<div class="linvest">待收流转标本金：￥{$var.circulation_capital_c|default:0}</div>
					<div class="linvest">待收流转标利息：￥{$var.circulation_interest_c|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">待还流转标本金：{$var.circulation_capital_r|default:0}</div>
					<div class="linvest">待还流转标利息：{$var.circulation_interest_r|default:0}</div>
				</div>
				{/if}
  				<!--  add for bug 274 end -->
				{/article}
				<!--
			<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
				<tr class="head">
					{loop module="account" function="GetLogGroup" var="var" user_id=0 }
					<td>{ $var.name}</td>
					{/loop}
				</tr>
				
				<tr >
					{loop module="account" function="GetLogGroup" var="var" user_id=0  }
					<td>￥{ $var.num}</td>
					{/loop}
				</tr>
		</table>
		-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed"  width="300" style="margin-top:20px;">
		<tr class="head"  width="300">
		<td>日期</td>
		<td>成功借款+</td>
		<td>借款手续费-</td>
		<td>借款保证金-</td>
		<td>借款奖励-</td>
		<td>投标-</td>
		<td>待收总额+</td>
		<td>投标奖励+</td>
        <td>担保奖励+</td>
        <td>利息收入+</td>
		<td>还款-</td>
		<td>充值+</td>
		<td>提现-</td>
		</tr>
			{loop module="account" function="GetLogCount" var="var" user_id=0 dotime1="$magic.request.dotime1"  dotime2="$magic.request.dotime2" }
				<tr  {if $var.i%2==1} class="tr1"{/if}>
				
					<td>{ $key}</td>
					<td {if $var.borrow_success!=""} style="color:#FF0000"{/if}>￥{ $var.borrow_success|default:0}</td>
					<td {if $var.borrow_fee!=""} style="color:#FF0000"{/if}>￥{ $var.borrow_fee|default:0}</td>
					<td {if $var.margin!=""} style="color:#FF0000"{/if}>￥{ $var.margin|default:0}</td>
					<td {if $var.award_lower!=""} style="color:#FF0000"{/if}>￥{ $var.award_lower|default:0}</td>
					<td {if $var.tender!=""} style="color:#FF0000"{/if}>￥{ $var.tender|default:0}</td>
					<td {if $var.collection!=""} style="color:#FF0000"{/if}>￥{ $var.collection|default:0}</td>
					<td {if $var.award_add!=""} style="color:#FF0000"{/if}>￥{ $var.award_add|default:0}</td>
                    <td >￥</td>
                    <td >￥</td>
					<td {if $var.invest_repayment!=""} style="color:#FF0000"{/if}>￥{ $var.invest_repayment|default:0}</td>
					<td {if $var.recharge!=""} style="color:#FF0000"{/if}>￥{ $var.recharge+$var.recharge_online|default:0}</td>
					<td {if $var.recharge_success!=""} style="color:#FF0000"{/if}>￥{ $var.recharge_success|default:0}</td>
					
				</tr>
				{/loop}
				
		</table>	
			{/if}
	</div>

	<!--右边的内容 结束-->
</div>
<!--用户中心的主栏目 结束-->
</div>
</div>
	<script>
var url = "{$_U.query_url}/{$_U.query_type}";
{literal}
function sousuo(){
	var _url = "";
	var dotime1 = jQuery("#dotime1").val();
	var keywords = jQuery("#keywords").val();
	var username = jQuery("#username").val();
	var dotime2 = jQuery("#dotime2").val();
	var type = jQuery("#type").val();
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
	if (type!=null){
		 _url += "&type="+type;
	}
	location.href=url+_url;
}

</script>
{/literal}
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/tooltip.js"></script>
<script src="/themes/js/popover.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}