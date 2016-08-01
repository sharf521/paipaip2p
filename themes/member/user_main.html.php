<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--用户中心的主栏目 开始-->
 <div id="main" class="clearfix" style="margin-top:5px;">
<div class="wrap950 " >
	<!--左边的导航 开始-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--左边的导航 结束-->
	{article module="borrow" function="GetUserAllAccountInfo" user_id=0 var="acc"}
	<!--右边的内容 开始-->
	<div class="user_right ">

		<div class="user_right_l ">
		{if $_G.user_result.real_status==0}
		<div class="alert alert-error" id="user_amange">
		 <a class="close" data-dismiss="alert">×</a>
			{$_G.system.con_webname}提醒你：你还没有进行实名认证。
			<a href="/index.php?user&q=code/user/realname"><strong>请先进行实名认证</strong>
			</a>
			</div>
		{/if}
		{if $_G.user_result.is_restructuring==1}
		<div class="alert alert-error" id="user_amange">
		 <a class="close" data-dismiss="alert">×</a>
		您当前处于债务重组状态，不能发普通标，不能投标，不能担保，不能提现。当您在平台所有债务偿还完毕后，此状态自动取消。
		</div>
		{/if}
			<div class="user_right_lmain">
				<div class="user_right_img">
					<img src="{$_G.user_id|avatar}" height="97" width="97" class="picborder" style="border:1px dashed #000" />
					<a href="index.php?user&q=code/user/avatar" ><font color="#FF0000">[更换头像]</font></a>
				</div>
				<div class="user_right_txt">
					<ul>
                                            <li class="user_right_txt_a"><div class="floatl"><span >信用等级：</span></div><a style="float: left;" href="/index.php?user&q=code/user/credit">{$_U.user_cache.credit|credit}</a><font color="red">{$_U.user_cache.credit}分</font>
                                            {article module="user" function="GetOne" user_id="0"}
                                            {$var.typename}
                                            {/article}
											 
                                            </li>
						<li style="overflow:hidden">
							<div class="floatl" ><span> 认&nbsp;&nbsp;&nbsp;   证：</span></div> 
							<a href="/index.php?user&q=code/user/realname"><div class="credit_pic_card_{$_G.user_result.real_status|default:0}" title="{if $_G.user_result.real_status==1}实名已认证{else}未实名认证{/if}"></div></a>
                            <a href="/index.php?user&q=code/user/phone_status" ><div class="credit_pic_phone_{if $_G.user_result.phone_status==1}1{else}0{/if}" title="{if $_G.user_result.phone_status==1}手机已认证{else}手机未认证{/if}"></div></a>
							<a href="/index.php?user&q=code/user/email_status"><div class="credit_pic_email_{$_G.user_result.email_status|default:0}" title="{if $_G.user_result.email_status==1}邮箱已认证{else}邮箱未认证{/if}"></div></a>
							<a href="/index.php?user&q=code/user/video_status"><div class="credit_pic_video_{$_G.user_result.video_status|default:0}" title="{if $_G.user_result.video_status==1}视频已认证{else}视频未认证{/if}"></div></a>
							<a href="/vip/index.html"><div class="credit_pic_vip_{if $_G.user_result.vip_status==1}1{else}0{/if}" title="{if $_G.user_result.vip_status==1}VIP{else}普通会员{/if}"></div></a>
							<a href="/index.php?user&q=code/user/scene_status"><div class="credit_pic_scene_{$_G.user_result.scene_status|default:0}" title="{if $_G.user_result.scene_status==1}已通过现场认证{else}未通过现场认证{/if}"></div></a>
							<a href="/index.php?user&q=code/account/stock_manage"><div class="credit_pic_stock_{if $_G.user_result.stock > 0}1{else}0{/if}" ></div></a>
							<a href="/index.php?user&q=code/attestation/one&type=3"><div class="credit_pic_credit_{$_G.user_result.credit_status|default:0}" ></div></a>
							
						</li>

						<li>   
                                                    <!--
                                                    <a href="/index.php?user&q=code/borrow/limitapp&type=credit"><font color="#FF0000">申请信用额度</font></a>
                                                    <a href="/index.php?user&q=code/borrow/limitapp&type=vouch"><font color="#FF0000">申请担保额度</font></a> -->
                                                    
                                                    <span style="color:red"> 信用额度：<font size="2">￥{$acc.credit|default:0}</font>    </span>
                                                   <!--<span style="color:red"> 借款担保额度：<font size="2">￥{$acc.borrow_vouch|default:0}</font>    </span>
                                                   <span style="color:red"> 投资担保额度：<font size="2">￥{$acc.tender_vouch|default:0}</font>    </span>-->
              

                                                </li>
						<li><span>VIP 期限： <a href="/vip/index.html">{if $_G.user_result.vip_status==1}
                                                            {$_G.user_result.vip_verify_time|date_format:"Y-m-d"} 到 
						{$_G.user_result.vip_verify_time+60*60*24*365|date_format:"Y-m-d"}
                                                
                                                            {elseif $_G.user_result.vip_status==-1}VIP审核中{else}<font color="#999999">不是VIP</font></font>{/if}</a></li>
						<li><span>系统告知：</span><a href="/index.php?user&q=code/message"><font color="#FF0000">{$_U.user_cache.message}</font> 封未读信息</a>&nbsp; &nbsp; <a href="/index.php?user&q=code/user/request">{$_U.user_cache.friends_apply} 个好友邀请</a>
                                                <a href="/index.php?user&q=code/account/recharge_new"><font color="#FF0000">[账号充值]</font></a>
                                                {if in_array("credit", $biaotype_list) }   
                                                <a href="/index.php?user&q=code/borrow/limitapp&type=credit"><font color="#FF0000">[额度申请]</font></a>
                                                {/if}
                                                </li>
					</ul>
				</div>
			</div>
			<div style=" margin-top:10px; line-height:22px; display:none">上次登录IP：{$_G.user_result.upip}  <br />
            							上次登录时间：{$_G.user_result.uptime|date_format:"Y-m-d H:i"}</div>
			<div class="user_right_li">
				<div class="title">

                                    <a href="/index.php?user&q=code/account">账号详情</a> {if $_G.user_result.vip_status==1}{else}(<a href="/vip/index.html"><font color="#FF0000">申请成为VIP会员</font></a></font>){/if}</div>
				<div class="content">
				
					
<table >
  <tr>
    <td width="33%"> 账户总额：<font>￥{$acc.total|default:0}</font></td>
    <td width="65%"><a href="index.php?user&amp;q=code/account/log">资金明细</a> | <a href="index.php?user&amp;q=code/account">账户资金详情</a> </td>
  </tr>
  <tr>
    <td>可用余额：<font>￥{$acc.use_money|default:0}</font></td>
    <td width="65%"><a href="index.php?user&amp;q=code/account/cash_new"><font style="font-size:12px;" ><strong>提现</strong></font></a> <a href="index.php?user&amp;q=code/account/recharge_new"><font style="font-size:12px;" ><strong>充值</strong></font> </a> <a href="/index.php?user&amp;q=code/account/bank">
            
            &nbsp;银行账户设置 </a> <a href="/index.php?user&amp;q=code/account/recharge">
                &nbsp;充值记录查询 </a>
        &nbsp;<a href="/index.php?user&amp;q=code/account/cash">提现记录查询 </a> </td>
  </tr>
  <tr>
    <td>冻结总额：<font>￥{$acc.no_use_money|default:0}</font></td>
    <td width="65%"><a href="/index.php?user&amp;q=code/borrow/bid">正在进行的投标</a> <a href="/index.php?user&amp;q=code/account/cash">正在申请的提现</a> 
    <?php  /*
    <a href="index.php?user&q=code/account/l2m&trantype=amount"><strong><font color="red">向商城转帐</font></strong></a> */ ?></td>
  </tr>
  <tr>
    <td>限制提现总额：<font>￥{$acc.nocash_money|default:0}</font></td>
    <td width="65%">&nbsp;</td>
  </tr>
  <!--  add for bug 493 begin -->
  {if $_G.system.con_stock_valid=="1"}
  <tr>
    <td>当前拥有的股份数：<font>{$acc.stock|default:0}</font></td>
    <td width="65%">股份价值：<font>￥{$acc.stock_value|default:0}</font>&nbsp;<a href="/index.php?user&q=code/account/stock_manage"><strong><font color="red">股份管理</font></strong></a></td>
  </tr>
  {/if}
  </table>
  <div class="title">待收待还详情</div>
  <table>
  <tr>
    <td width="50%">待收总额：<font>￥{$acc.r_collection_total|default:0}</font></td>
    <td width="250px">待收利息：<font>￥{$acc.r_collection_interest|default:0}</font></td>
  </tr>
  <tr>
    <td>最近待收金额：<font>{$acc.r_collection_total_last|default:0}</font></td>
    <td width="65%">最近待收时间：<font>{$acc.r_collection_last_time|date_format:"Y-m-d"}</font>
    <a href="index.php?user&q=code/borrow/gathering&status=0"><strong><font color="red">我要收款</font></strong></a></td>
  </tr>
  <tr>
    <td>已赚利息：<font>￥{$acc.ed_interest|default:0}</font> </td>
    <td width="65%">已赚奖励：<font>￥{$acc.award_add|default:0}</font><!--待扣会费：<font>￥{if $_U.user_cache.vip_money=="" && $_G.user_result.vip_status==1}{$_G.system.con_vip_money}{else}0{/if}</font>--></td>
  </tr>
  <tr>
    <td>借款总额：<font>￥{$acc.borrow_num|default:0}</font></td>
    <td width="65%">待还总额：<font>￥{$acc.wait_payment|default:0}</font> </td>
  </tr>
  <tr>
    <td>最近待还金额：<font>￥{$acc.new_repay_account|default:0}</font></td>
    <td width="65%">最近待还时间：<font>{$acc.new_repay_time|date_format:"Y-m-d"|default:""}</font>
    <a href="index.php?user&q=code/borrow/repaymentplan"><strong><font color="red">我要还款</font></strong></a></td>
  </tr>
  </table>
  <!--  add for bug 274 begin -->
  {if $_G.system.con_circulation=="1"}
  <div class="title">流转标详情</div>
  <table>
  <tr>
    <td width="50%">待回购流转标：<font>￥{$acc.circulation_capital_c|default:0}</font></td>
    <td width="250px">待收流转标利息：<font>￥{$acc.circulation_interest_c|default:0}</font></td>
  </tr>
  <tr>
    <td>待偿还流转标：<font>￥{$acc.circulation_capital_r|default:0}</font></td>
    <td width="65%">待偿还流转标利息：<font>￥{$acc.circulation_interest_r|default:0}</font></td>
  </tr>
  </table>
  {/if}
  <!--  add for bug 274 end -->
  <div class="title">额度详情</div>
  <table>
  <tr>
    <td width="50%">信用额度：<font>￥{$acc.credit|default:0}</font> </td>
    <td width="250px">可用信用额度：<font>￥{$acc.credit_use|default:0}</font></td>
  </tr>
  <!--<tr>
    <td>借款担保额度：<font>￥{$acc.borrow_vouch|default:0}</font></td>
    <td width="65%">可用借款担保额度：<font>￥{$acc.borrow_vouch_use|default:0}</font> </td>
  </tr>
  <tr>
    <td>投资担保额度：<font>￥{$acc.tender_vouch|default:0}</font></td>
    <td width="65%">可用投资担保额度：<font>￥{$acc.tender_vouch_use|default:0}</font></td>
  </tr>
  <tr>
    <td>债务重组额度：<font>￥{$acc.restructuring|default:0}</font></td>
    <td width="65%">可用债务重组额度：<font>￥{$acc.restructuring_use|default:0}</font></td>
  </tr>-->
  </table>
  <!--  add for bug 274 begin -->
  {if $_G.system.con_recharge_activity=="1"}
  <div class="title">充值奖励详情</div>
  <table>
  <tr>
    <td width="50%">充值奖励：<font>￥{$acc.award|default:0}</font></td>
    <td width="250px">可用充值奖励：<font>￥{$acc.use_award|default:0}</font></td>
  </tr>
  <tr>
    <td>充值奖励已赚利息：<font>￥{$acc.award_interest|default:0}</font></td>
    <td width="65%"><a href="index.php?user&q=code/account/l2m&trantype=award"><strong><font color="red">向商城转帐</font></strong></a> <a href="index.php?user&amp;q=code/account/awardlog">奖励日志</a></td>
  </tr>
</table>
{/if}
<!--  add for bug 274 end -->
  
  <?php
  /*
  
  <div class="title">供销商城信息</div>
  <table>
  <tr>
    <td width="50%"><i style="float:left;font-style:normal;">资金：</i><span  id="gx_mall_money" style="color:red"></span></td>
    <td width="250px"><i style="float:left;font-style:normal;">冻结资金：</i><span  id="gx_mall_money_dj" style="color:red"></span>
    </td>
  </tr>
  <tr>
    <td><i style="float:left;font-style:normal;">积分：</i><span  id="gx_mall_jifen" style="color:red"></span></td>
    <td width="65%"><i style="float:left;font-style:normal;">冻结积分：</i><span  id="gx_mall_jifen_dj" style="color:red"></span></td>
  </tr>
</table>
  <div class="title">积分商城信息</div>
  <table>
  <tr>
    <td width="50%"><i style="float:left;font-style:normal;">资金：</i><span  id="jf_mall_money" style="color:red"></span></td>
    <td width="250px"><i style="float:left;font-style:normal;">冻结资金：</i><span  id="jf_mall_money_dj" style="color:red"></span>
    </td>
  </tr>
  <tr>
    <td><i style="float:left;font-style:normal;">积分：</i><span  id="jf_mall_jifen" style="color:red"></span></td>
    <td width="65%"><i style="float:left;font-style:normal;">冻结积分：</i><span  id="jf_mall_jifen_dj" style="color:red"></span></td>
    <span style="display: none"><input id="codetime" name="codetime" type="button" value="发送验证码"/></span>
  </tr>
</table>
{literal}
				<script language="javascript">
				$("#codetime").click(function() {
					
					$.ajax({
							 url: "/index.php?user&q=code/account/get_mall_info",
						     //    timeout: 20000,
										 success: function(data){
										 var obj = $.parseJSON(data);
										 
										 document.getElementById('gx_mall_money').innerHTML="￥"+obj.mallinfo.mall_money;
										 document.getElementById('gx_mall_money_dj').innerHTML="￥"+obj.mallinfo.mall_money_dj;
										 document.getElementById('gx_mall_jifen').innerHTML=obj.mallinfo.mall_jifen;
										 document.getElementById('gx_mall_jifen_dj').innerHTML=obj.mallinfo.mall_jifen_dj;
										 
										 document.getElementById('jf_mall_money').innerHTML="￥"+obj.jf_mallinfo.mall_money;
										 document.getElementById('jf_mall_money_dj').innerHTML="￥"+obj.jf_mallinfo.mall_money_dj;
										 document.getElementById('jf_mall_jifen').innerHTML=obj.jf_mallinfo.mall_jifen;
										 document.getElementById('jf_mall_jifen_dj').innerHTML=obj.jf_mallinfo.mall_jifen_dj;
										//alert(msg);  
											
									} ,
							 error: function (xmlHttpRequest, error) {
							     //alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				});
				//将时间减去1秒，计算天、时、分、秒
				</script>
{/literal}		
{literal}
<script>
$("#codetime").click();	
</script>
{/literal}
  
  */
  ?>
  
  
  <div class="title">返还信息</div>
  <table>
  <tr>
    <td width="50%">缴纳费用合计：<font>￥{$acc.ws_out_money|default:0}</font></td>
    <td width="250px">已获得返还合计：<font>￥{$acc.ws_in_money|default:0}</font></td>
  </tr>
</table>
				</div>
			</div>
				{/article}

			<?php
			/*<div class="user_right_li">
				<div class="title">好友动态</div>
				<div class="content">
					<ul>
						{loop module="user" function="GetUserTrend" limit="15" user_id="0"}
						<li><a href="/u/{$var.receive_user}" target="_blank"><font color="#FF0000">【{$var.username}】</font></a> {$var.name}-{$var.addtime|date_format:"Y-m-d H:i:s"} </li>
						{/loop}
					</ul>
				</div>
			</div>*/
			?>
           
		</div>
		
		<div class="user_right_r">
			{article module="borrow" function="Getkf"}
			{if $var.username}
			<div class="user_right_info">
				<div class="title">您的专属客服在您身边
                                </div>
				<div class="content">
					<ul>
						<li><img src="{$var.kefu_userid|avatar:'big'}" border="0" class="picborder" width="150px" height="160px"/></li>
						<li>客服名称：{$var.username}</li>
						<li>客服QQ：
                                                
                                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=1&uin={$var.qq}&site=qq&menu=yes" >
                                                       <img border="0" src="http://wpa.qq.com/pa?p=1:{$var.qq}:1" alt="点击这里给我发消息" title="点击这里给我发消息">
                                                   </a>
                                                </li>
						<li>客服电话：{$var.phone}</li>
					</ul>
				</div>
			</div>
						{/if}
						{/article}

			<div class="list_2 clearfix">
				<div class="title">个人资料完成率</div> 
				<div  class="content">
				<ul>
				{article module="userinfo" function="GetOne" user_id="0"}
					<li><span><a href="/index.php?user&q=code/userinfo/building">{if $var.building_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>房产资料</li>
					<li><span><a href="/index.php?user&q=code/userinfo/company">{if $var.company_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>单位资料</li>
					<li><span><a href="/index.php?user&q=code/userinfo/firm">{if $var.firm_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>私营业主</li>
					<li><span><a href="/index.php?user&q=code/userinfo/finance">{if $var.finance_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>财务状况</li>
					<li><span><a href="/index.php?user&q=code/userinfo/contact">{if $var.contact_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>联系方式</li>
					<li><span><a href="/index.php?user&q=code/userinfo/edu">{if $var.edu_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>教育背景</li>
					<li><span><a href="/index.php?user&q=code/userinfo/mall">{if $var.mall_status==1}<font color="#009900">已填写</font>{else}<font color="#FF0000">未填写</font>{/if}</a></span>商城信息</li>
				</ul>
				{/article}
				</div>
			</div>
			
			<div class="list_2">
				<div class="title">网站公告</div>
				<div class="content">
					<ul>
						{loop module="article" function="GetList" status=1  limit="6" site_id="22" areaid="$_G.areaid"}
						<li><a href="/{$var.site_nid}/a{$var.id}.html" target="_blank">{$var.name|truncate:14}</a></li>
						{/loop}
					</ul>
				</div>
			</div>
			
			<div class="mt10">
            	<!--type_id="6" type_id="7" type_id="8"-->
				{loop module="scrollpic" function="GetList" areaid="$_G.areaid" var="var"  limit="1" type_id="6"}
	                <a href="{$var.url}"><img src="/{$var.pic}" height="100" width="185"></a>
	            {/loop}
			</div>
		
		</div>
		
	</div>
	<!--右边的内容 结束-->
</div>
</div>
<!--用户中心的主栏目 结束-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}