<?php
!defined('IN_TEMPLATE') && exit('Access Denied');

?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
 <div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 mar10">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="list"} class="cur"{/if}><a href="{$_U.query_url}">�˻�����</a></li>
				<li {if $_U.query_type=="bank"} class="cur"{/if}><a href="{$_U.query_url}/bank">�����˺�</a></li>
				<li {if $_U.query_type=="recharge_new"} class="cur"{/if}><a href="{$_U.query_url}/recharge_new">�˻���ֵ</a></li>
				<li {if $_U.query_type=="recharge"} class="cur"{/if}><a href="{$_U.query_url}/recharge">��ֵ��¼</a></li>
				<li {if $_U.query_type=="cash_new"} class="cur"{/if}><a href="{$_U.query_url}/cash_new">�˻�����</a></li>
				<li {if $_U.query_type=="cash"} class="cur"{/if}><a href="{$_U.query_url}/cash">���ּ�¼</a></li>
				<li {if $_U.query_type=="log"} class="cur"{/if}><a href="{$_U.query_url}/log">�ʽ���ϸ</a></li>
				<!--<li {if $_U.query_type=="l2m"} class="cur"{/if}><a href="{$_U.query_url}/l2m">�˻�ת��</a></li>
				<li {if $_U.query_type=="awardlog"} class="cur"{/if}><a href="{$_U.query_url}/awardlog">������־</a></li>-->
				{if $_G.system.con_stock_valid=="1"}
				<li {if $_U.query_type=="stock_manage"} class="cur"{/if}><a href="{$_U.query_url}/stock_manage">�ɷݹ���</a></li>
				{/if}
			</ul>
		</div>
		
		<div class="user_right_main">
		
		<!--�ʽ�ʹ�ü�¼�б� ��ʼ-->
		{if $_U.query_type=="log"}
		<div class="user_main_title well" style="height:60px; padding-top:7px;"> 
		��¼ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="ȫ��" } <input value="����" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" /> 
                <br>
			<div class="alert">������ˮ�ܼƣ���{$_U.account_num|default:0} (��ע���˽����˻��ܶֻ���˻���ʷ���н����漰�ʽ��ܺͣ�)</div>	
		</div>	
			<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			  <form action="" method="post">
				<tr class="head">
					<td>����</td>
					<td>�������</td>
					<td>�ܽ��</td>
					<td>���ý��</td>
					<td>������</td>
					<td>���ս��</td>
					<td>���׶Է�</td>
					<td>��¼ʱ��</td>
					<td width="130">��ע��Ϣ</td>
				</tr>
				{ foreach  from=$_U.account_log_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.type|linkage:"account_type"}</td>
					<td>��{ $item.money}</td>
					<td>��{ $item.total}</td>
					<td>��{ $item.use_money}</td>
					<td>��{ $item.no_use_money|default:0}</td>
					<td>��{ $item.collection}</td>
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
		<!--�ʽ�ʹ�ü�¼�б� ����-->
		<!--�ʽ�ʹ�ü�¼�б� ��ʼ-->
		{elseif $_U.query_type=="awardlog"}
		<div class="user_main_title well" style="height:60px; padding-top:7px;"> 
		��¼ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		{linkages nid="account_type" value="$magic.request.type" name="type" type="value" default="ȫ��" } <input value="����" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" /> 
                <br>
		</div>	
			<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			  <form action="" method="post">
				<tr class="head">
					<td>����</td>
					<td>�������</td>
					<td>��¼ʱ��</td>
					<td width="130">��ע��Ϣ</td>
				</tr>
				{ foreach  from=$_U.award_log_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.type|linkage:"award_type"}</td>
					<td>��{ $item.award}</td>
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
		<!--�ʽ�ʹ�ü�¼�б� ����-->
		{elseif $_U.query_type=="stock_manage"}
		<!--�ɷݹ��� ��ʼ-->
		
		<div class="user_help alert" style="text-align:left;text-indent :24px;">��ǰ���{$_U.account_result.use_money}Ԫ���ɷ���{$_U.account_result.stock}��
		</div>
		{if $_G.user_result.real_status!=1}
			<div align="center"><font color="#FF0000"><br />
		<br />
		{$_G.system.con_webname}�����㣺</font>�㻹û��ͨ��ʵ����֤������ͨ��<a href="/index.php?user&q=code/user/realname"><strong>ʵ����֤!</strong></a>
		</div><br />
                    {elseif $_G.user_result.vip_status!=1}
                            <div align="center"><font color="#FF0000">
                    <br />
                    {$_G.system.con_webname}�����㣺</font>�㻹����VIP��Ա�����ȳ�Ϊ<a href="/vip/index.html"><strong>VIP��Ա</strong></a>��</div><br /><br /><br />
                    
		{else}
		<form cur="" method="post">
		<div class="user_right_border">
			<div class="e">�����ߣ�</div>
			<div class="c">
				{$_G.user_result.username}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> �������ͣ�</div>
			<div class="c">
				<select name="optype">
				<option value="0" {if $magic.request.optype=="0"} selected="selected"{/if}>����</option>
				<option value="1" {if $magic.request.optype=="1"} selected="selected"{/if}>�۳�</option>
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> ���������</div>
			<div class="c">
				<input type="text" name="num" value="" onkeyup="value=value.replace(/[^0-9]/g,'')"/> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> �ɷݼ۸�</div>
			<div class="c">
				{$_G.system.con_stock_price}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">��ϸ˵����</div>
			<div class="c">
				<textarea rows="5" cols="40" name="remark"></textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  class="btn-action" value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����ʱ��</td>
					<td  >��������</td>
					<td  >�������</td>
					<td  >���׽��</td>
					<td  >��ע˵��</td>
					<td  >״̬</td>
					<td  >���ʱ��</td>
					<td  >��˱�ע</td>
				</tr>
				{list module="account" var="loop" function ="GetStockApplyList" showpage="3" user_id="0"  }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.addtime|date_format}</td>
					<td width="70">{if $item.optype=="0"}����{elseif $item.optype=="1"}�۳�{/if}</td>
					<td  >{$item.num}</td>
					<td  >{$item.trade_account}</td>
					<td  width="200">{$item.remark}</td>
					<td  >{if $item.status==0}�������{elseif $item.status==1}���ͨ��{else}��˲�ͨ��{/if}</td>
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
		
		<!--�ɷݹ��� ����-->
		{/if}
		<!--��ֵ��¼�б� ��ʼ-->
		{elseif $_U.query_type=="recharge"}
		<!-- 
		<div class="user_help alert">�ɹ���ֵ{$_U.account_log.recharge_success|default:0}Ԫ�����ϳɹ���ֵ{$_U.account_log.recharge_online|default:0}Ԫ�����³ɹ���ֵ{$_U.account_log.recharge_downline|default:0}Ԫ,���ֶ��ɹ���ֵ{$_U.account_log.recharge_shoudong|default:0}Ԫ
</div>
		 -->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
		<form action="" method="post">
			<tr class="head" >
			<td>����</td>
			<td>֧����ʽ</td>
			<td>��ֵ���</td>
			<!-- 
			<td>�������</td>
			 -->
			<td>��ע</td>
			<td>��ֵʱ��</td>
			<td>״̬</td>
			<td>����ע</td>
			</tr>
			{list module="account" function="GetRechargeList" showpage="3" var="loop" status="1" user_id="0" epage=20}
			{ foreach  from=$loop.list key=key item=item}
			<tr  {if $key%2==1} class="tr1"{/if}>
			<td>{if $item.type==1}���ϳ�ֵ{else}���³�ֵ{/if}</td>
			<td>{ $item.payment_name|default:"�ֶ���ֵ"}</td>
			<td><font color="#FF0000">��{ $item.money}</font></td>
			<!-- 
			<td>{ $item.hongbao}</td>
			 -->
			<td>{ $item.remark}</td>
			<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
			<td>{if $item.status==0}�����{elseif  $item.status==1} ��ֵ�ɹ� {elseif $item.status==2}��ֵʧ��{/if}</td>
			
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
		<!--��ֵ��¼�б� ����-->
		
		<!--���ּ�¼�б� ��ʼ-->
		{elseif $_U.query_type=="cash"}
		<div class="user_help alert">�ɹ�����{$_U.cash_log.cash_success.money|default:0}Ԫ�����ֵ���{$_U.cash_log.cash_success.credited|default:0}Ԫ��������{$_U.cash_log.cash_success.fee|default:0}Ԫ
</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" >
			<form action="" method="post">
				<tr class="head">
					<td>��������</td>
					<td>�����˺�</td>
					<td>�����ܶ�</td>
					<td>���˽��</td>
					<td>������</td>
					<td>����ʱ��</td>
					<td>״̬</td>
					<td>����</td>
				</tr>
				{ foreach  from=$_U.account_cash_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
					<td>{ $item.bank_name}</td>
					<td>{ $item.account}</td>
					<td>��{ $item.total|default:0}</td>
					<td>��{ $item.credited|default:0}</td>
					<td>��{ $item.fee|default:0}</td>	
					<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
					<td>{if $item.status==0}�����{elseif  $item.status==1} ���ֳɹ� {elseif $item.status==2}����ʧ�� {elseif $item.status==3}�û�ȡ��{/if}</td>
					<td>{if $item.verify_remark!=""}{$item.verify_remark}{else}{if $item.status==0}<a href="#" onclick="javascript:if(confirm('ȷ��Ҫȡ������������')) location.href='{$_U.query_url}/cash_cancel&id={$item.id}'">ȡ������</a>{else}-{/if}{/if}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="11" class="page">
						{$_U.show_page}
					</td>
				</tr>
			</form>	
		</table>
		<!--���ּ�¼�б� ����-->
		
		<!--�˺ų�ֵ ��ʼ-->
		{elseif $_U.query_type=="recharge_new"}
		<div class="user_help alert">
                    * ��ܰ��ʾ���������г�ֵ�����������ĵȴ�,��ֵ�ɹ����벻Ҫ�ر������,��ֵ�ɹ��󷵻�{$_G.system.con_webname},
                    ��ֵ�����ܴ��������˺š�
                    <br>* <font color="red">���߳�ֵ��������ȫ��Ŷ��</font>


</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ʵ������</div>
			<div class="c">
				{$_G.user_result.realname}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ϵEmail��</div>
			<div class="c">
				{$_G.user_result.email}
			</div>
		</div>
		<form action="" method="post" name="form1"  onsubmit = "return check();" target="_blank">
		<div id="returnpay">
		<div class="user_right_border" style="display:none">
			<div class="l" style="font-weight:bold;">��ֵ��ʽ��</div>
			<div class="c">
				<input type="radio" name="type"  id="type"  class="input_border" checked="checked" onclick="change_type(1)" value="1"  /> ���ϳ�ֵ
                <input type="radio" name="type"  id="type" class="input_border"  value="2"  onclick="change_type(2)" /> ���³�ֵ 
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ֵ��</div>
			<div class="c">
                       
				<input type="text" name="money"  class="input_border" value="" size="10" onkeyup="commit(this);" maxlength="9" id="txt_money"/> Ԫ <span id="realacc">ʵ�����ˣ�<font color="#FF0000" id="real_money">0</font> Ԫ</span>
			</div>
		</div>
                    <div id="type_net" class="disnone">
			<div class="user_right_border">
				<div class="l" style="font-weight:bold;">��ֵ���ͣ�</div>
				<div class="c">
						<font color="red">����������ʹ�ø�����������֧����ֻ�迪ͨ�����������м���!</font>
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
         <!--����-˫Ǭ֧��
         <table width="100%">
         <tr>
           <td><input type="radio" name="payment1" value="shuangq" />
           <img src="../data/bank/shq.png" border="0"/>˫Ǭ֧����������֧����֧�ָ������У��������ѣ���</td>
         </tr>
         <tr>
           <td><input type="radio" name="payment1" value="" />
           <img src="../data/bank/hch.png" border="0"/>�㳱֧����������֧����֧�ָ������У��������ѣ���</td>
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
                                
				<div class="l" style="font-weight:bold;">��ֵ���У�
                                </div>
                                
				<div class="c">
                                    <div>
                                <font color="red">���³�ֵ���������⣬��������ͷ���ϵ��<br>
��1��<strong><font color="blue">��Ч��ֵ�Ǽ�ʱ��Ϊ:��һ�������9:30��16:00</font></strong>����ֵ�ɹ�������ǵĿͷ���ϵ��<br>
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
				<div class="l" style="font-weight:bold;">���³�ֵ��ע��</div>
				<div class="c">
					<input type="text" name="remark"  class="input_border" value="" size="30" /><br>����ע�������û�����ת�����п��ź�ת����ˮ�ţ��Լ�ת��ʱ�䣬лл��ϣ�
				</div>
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold; float:left;">��֤�룺</div>
			<div class="c" >
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"  style="float:left;width:100px;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();"  style="cursor:pointer;width:50px;" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
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
					alert('��ѡ���ֵ������');
					return false;
				}*/
				var recharge2_remark = document.getElementById("recharge2_remark").value;
				if(recharge2_remark == ""){
					alert('���³�ֵ��ע������д��');
					return false;
				}
			}
			else
			{
				var txt_money_v = document.getElementById("txt_money").value;
				txt_money_v=parseFloat(txt_money_v); 
				if(txt_money_v < 0 )
				{
					alert('���ʳ�ֵ���ܵ���80Ԫ��');
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
				$("#returnpay").html("<font color='red'>�뵽�򿪵���ҳ���ֵ</font>");
				
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
		{$_G.system.con_webname}��ֹ���ÿ����֡���ٽ��׵���Ϊ,һ�����ֽ����Դ���,�����������ڣ������տ�����˻�������ֹͣ����,���п���Ӱ��������ü�¼��<br />
        	���ʳ�ֵ���ܵ���80Ԫ��
		</div>
		
		<!--�˺ų�ֵ ����-->
		
		
		<!--�����˺� ��ʼ-->
		{elseif $_U.query_type=="bank"}
		<div class="user_help alert" style="text-align:left;text-indent :24px;">{$_G.system.con_webname}��ֹ���ÿ����֡���ٽ��׵���Ϊ,һ�����ֽ����Դ���,�����������ڣ������տ�����˻�������ֹͣ����,���п���Ӱ��������ü�¼��
</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ʵ������</div>
			<div class="c">
				{$_U.account_bank_result.realname}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��½�û�����</div>
			<div class="c">
				{$_U.account_bank_result.username}
			</div>
		</div>
		
		{if $_U.account_bank_result.bank!=""}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�������У�</div>
			<div class="c">
				{$_U.account_bank_result.bank|linkage}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">���������ƣ�</div>
			<div class="c">
				{$_U.account_bank_result.branch}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�����˺ţ�</div>
			<div class="c">
				{$_U.account_bank_result.account_view}
			</div>
		</div>
		{/if}
		<div class="user_right_foot">
		</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�������У�</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=bank&nid=account_bank&value={$_U.account_bank_result.bank}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">���������ƣ�</div>
			<div class="c">
				<input type="text" name="branch" value="" data-content="**����**֧��**������Ӫҵ��(�磺�Ϻ���������֧�пؽ�·����),
		    ������޷�ȷ��,�������µ����Ŀ������пͷ�����ѯ�ʡ� " id="infokaih" />
			</div>

		</div>
		
		<div class="user_right_border" style="margin-left:0px">
			<div class="l" style="font-weight:bold;">�����˺ţ�</div>
			<div class="c">
				<input type="text" name="account" value="" onkeyup="value=value.replace(/[^0-9]/g,'')" id="infoyhzh" data-content="�ر����ѣ��������п��ŵĿ�������������Ϊ��{$_U.account_bank_result.realname}��, ���������˺ű�����д��ȷ,������������ʽ𽫴��ڷ��ա�
                    ���Ҫ�޸ĵĻ�����Ҫ��ȫ, �����κ�ʱ���޸��������������������п��š�" />
			</div>
			<div class="l" style="font-weight:bold;"></div>

		</div>
		
		{if $_G.sms_available == 1}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�ֻ���֤��</div>
			<div class="c">
				<input type="text" name="mobilecode"  maxlength="6"  />&nbsp;&nbsp;<input id="codetime" name="codetime" type="button" value="������֤��"/>
			</div>
		</div>
		{/if}		
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="hidden" name="user_id" value="{$_G.user_id}" />
				<input type='hidden' name='oid' value='<?php echo date('YmdHis');?>'/> 
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ����ֹ���ÿ�����
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
													$("#codetime").attr({"value":"���·���"});	
											}
									} ,
							 error: function (xmlHttpRequest, error) {
							     alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				 

				});
				//��ʱ���ȥ1�룬�����졢ʱ���֡��� 
				  function SetRemainTime() { 
				   if (SysSecond > 0) { 
				    SysSecond = SysSecond - 1; 
				    var second = Math.floor(SysSecond % 60);             // ������     
				    var minite = Math.floor((SysSecond / 60) % 60);      //����� 
				    var hour = Math.floor((SysSecond / 3600) % 24);      //����Сʱ 
				    var day = Math.floor((SysSecond / 3600) / 24);        //������ 
					$("#codetime").attr({"value":minite+"��"+second+"��"});
				   } else {
				    window.clearInterval(InterValObj); 
					$("#codetime").attr({"value":"���·���"});	
						$("#codetime").removeAttr("disabled");

				   } 
				  } 
				    
				</script>
		{/literal}
		<!--�����˺� ����-->

		<!--���̳�ת�� ��ʼ-->
		{elseif $_U.query_type=="l2m"}
		<div class="user_help alert" style="text-align:left;text-indent :24px;">��ǰ��ת���{$_U.account_bank_result.tran_amount}Ԫ����ת��ֵ������Ϣ{$_U.account_bank_result.award_interest}Ԫ��
		</div>
		
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">ת���̳ǣ�</div>
			<div class="c">
				<input type="radio" name="malltype"  id="malltype"  class="input_border" checked="checked"  value="gx"  /> �����̳�<input type="radio" name="malltype"  id="malltype" class="input_border" {if $_U.malltype == 'jf'}checked="checked"{/if} value="jf"  /> �����̳� 
			</div>
		</div>		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">ת�����ͣ�</div>
			<div class="c">
				<input type="radio" name="trantype"  id="trantype"  class="input_border" {if $_U.trantype == 'amount'}checked="checked"{/if} value="amount"  /> �������<input type="radio" name="trantype"  id="trantype" class="input_border" {if $_U.trantype == 'award'}checked="checked"{/if} value="award"  /> ��ֵ������׬��Ϣ 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">ת�˽�</div>
			<div class="c">
				<input type="text" name="amount" onkeyup="value=value.replace(/[^0-9.]/g,'')" />
			</div>
		</div>

		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�������룺</div>
			<div class="c">
				{if $_U.account_bank_result.paypassword==""}<a href="{$_U.query_url}&q=code/user/paypwd"><font color="#FF0000">��������һ��֧������</font></a>{else}<input type="password" name="paypassword" />{/if}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<!--���̳�ת�� ����-->		
		
		<!--���� ��ʼ-->
		{elseif $_U.query_type=="cash_new"}
                
                



		<div class="user_help alert" style="text-align:left;">
		{article module="dynacontent" function="GetOneBytype" var="dynac" areaid="$_G.areaid" type_id="3"}
        {$dynac.content}
		{/article}
		</div>
		<form action="" method="post" onsubmit="return check_form()" name="form1">
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ʵ������</div>
			<div class="c">
				{$_G.user_result.realname}
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">���ֵ����У�</div>
			<div class="c">
				{$_U.account_bank_result.bank|linkage} {$_U.account_bank_result.branch} {$_U.account_bank_result.account_view} 
			</div>
		</div>
                    
		{article module="borrow" function="GetCashMaxAmount"  user_id="$_G.user_id"  article_id="0"}
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">������</div>
			<div class="c">
				{$var.use_money|default:0}Ԫ
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�������ֽ�</div>
			<div class="c">
				{$var.nocash_money|default:0}Ԫ
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��ʹ�÷����ֳ�ֵ������</div>
			<div class="c">
				{$var.used_award|default:0}Ԫ
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�����������֣�</div>
			<div class="c">
				{$var.cashingAmount|default:0}Ԫ
			</div>
		</div>
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">���������������֣�</div>
			<div class="c">
				{$var.maxCashAmount|default:0}Ԫ
			</div>
		</div>
                
        <input type="hidden" name="maxCashAmount" id="maxCashAmount" value="{$var.maxCashAmount}">
		{/article}
                
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�������룺</div>
			<div class="c">
				{if $_U.account_bank_result.paypassword==""}<a href="{$_U.query_url}&q=code/user/paypwd"><font color="#FF0000">��������һ��֧������</font></a>{else}<input type="password" name="paypassword" />{/if}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">���ֽ�</div>
			<div class="c">
				<input type="text" name="money"   onkeyup="value=value.replace(/[^0-9.]/g,'')" />
			</div>
		</div>
		{if $_G.sms_available == 1}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">�ֻ���֤��</div>
			<div class="c">
				<input type="text" name="mobilecode"  maxlength="6"  />&nbsp;&nbsp;<input id="codetime" name="codetime" type="button" value="������֤��"/>
			</div>
		</div>		
		{/if}
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;">��̬����(��ѡ)��</div>
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
													$("#codetime").attr({"value":"���·���"});	
											}
									} ,
							 error: function (xmlHttpRequest, error) {
							     alert(xmlHttpRequest+"("+error+")");  
							 }
						     });
				 

				});
				//��ʱ���ȥ1�룬�����졢ʱ���֡��� 
				  function SetRemainTime() { 
				   if (SysSecond > 0) { 
				    SysSecond = SysSecond - 1; 
				    var second = Math.floor(SysSecond % 60);             // ������     
				    var minite = Math.floor((SysSecond / 60) % 60);      //����� 
				    var hour = Math.floor((SysSecond / 3600) % 24);      //����Сʱ 
				    var day = Math.floor((SysSecond / 3600) / 24);        //������ 
					$("#codetime").attr({"value":minite+"��"+second+"��"});
				   } else {
				    window.clearInterval(InterValObj); 
					$("#codetime").attr({"value":"���·���"});	
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
                    alert("���ã������ʽ��ܵ���100Ԫ����50000Ԫ");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }else if(userMoney >=300000 && (inputValue<300000 && inputValue>50000)){
                    alert("���ã���������ʽ������30��~50��֮�� ");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }else if(userMoney >=300000 && inputValue > 500000){
                    alert("���ã���������ʽ��ܴ���50�� ");
                    obj.value=0;
                    document.getElementById("real_money").innerText = 0 ;
                    return;
                }

             // add by alpha for bug 12 begin �޸Ŀ����ֽ��
             	var maxCashAmount = document.getElementById("maxCashAmount").value;
             	if (inputValue > maxCashAmount){
             		alert("���ã������ʽ��ܴ��ڿ����ֽ�");
                }
             // add by alpha for bug 12 end �޸Ŀ����ֽ��
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
			<div class="l" style="font-weight:bold;">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4" style="float:left;"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();"  style="cursor:pointer;" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l" style="font-weight:bold;"></div>
			<div class="c">
				<input type="hidden" name="user_id" value="{$_G.user_id}" />
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ����ֹ���ÿ�����
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
		errorMsg += '���������Ľ�������' + '\n';
	  }
	  if (money.length == 0 ) {
		errorMsg += '������������ֽ��' + '\n';
	  }
	 if (money <0 || money >cash_maxamount) {
		errorMsg += '���ֽ��Ҫ����' + cash_maxamount + '\n';
	  }
	 
	 if (parseFloat(money) > parseFloat(maxCashAmount)) {
		errorMsg += '�������ֽ������������ֶ�' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}
</script>
{/literal}
		<!--���� ����-->
				{else}
				{literal}
				<? $this->magic_vars['day7'] = time()-6*60*60*24;?>
				<? $this->magic_vars['nowtime'] = time();?>
				{/literal}
		<div class="user_main_title" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1|default:"$day7"|date_format:"Y-m-d"}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2|default:"$nowtime"|date_format:"Y-m-d"}" id="dotime2" size="15" onclick="change_picktime()"/>   
		<input value="����" type="submit" class="btn-action"  onclick="sousuo('{$_U.query_url}/publish')" />
		</div>	
		{article module="borrow" function="GetUserLog" user_id="0"}

				<div style="line-height:30px; font-size:15px; font-weight:bold">�����ʽ�����</div>
				<div class="user_right_border">
					<div class="linvest">�˻��ܶ<strong>��{$var.total|default:0}</strong></div>
					
					<div class="linvest">������<font color="#FF0000">��{$var.use_money|default:0}</font></div>
					
					<div class="linvest">�������{$var.no_use_money|default:0}</div>
					
				</div><div class="user_right_border">
					<div class="linvest">Ͷ�궳���ܶ��{$var.tender|default:0}</div>
					<div class="linvest">��ֵ�ɹ��ܶ��{$var.recharge_success|default:0}</div>
					<div class="linvest">���ֳɹ��ܶ��{$var.cash_success.money|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">���߳�ֵ�ܶ��{$var.recharge_online|default:0}</div>
					<div class="linvest">���³�ֵ�ܶ��{$var.recharge_downline|default:0}</div>
					<div class="linvest">�ֶ���ֵ�ܶ��{$var.recharge_shoudong|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">�������ѣ���{$var.fee+$var.recharge_fee|default:0}</div>
					<div class="linvest">��ֵ�����ѣ���{$var.fee|default:0}</div>
					<div class="linvest">���������ѣ���{$var.recharge_fee|default:0}</div>
				</div>
				<div style="line-height:30px; font-size:15px; font-weight:bold">Ͷ���ʽ�����</div>
			
				<div class="user_right_border">
					<div class="linvest">Ͷ���ܶ��{$var.invest_account|round:"2"|default:0}</div>
					<div class="linvest">����ܶ��{$var.success_account|round:"2"|default:0}</div>
					<div class="linvest">���������ܶ��{$var.award_add|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">�������ܶ��{$var.r_collection_total|default:0}</div>
					<div class="linvest">�����ս���{$var.r_collection_capital|default:0}</div>
					<div class="linvest">��������Ϣ����{$var.r_collection_interest|round:"2"|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">�ѻ����ܶ��{$var.collection_yes|default:0}</div>
					<div class="linvest">�ѻ��ս���{$var.collection_capital1|default:0}</div>
					<div class="linvest">�ѻ�����Ϣ����{$var.collection_interest1|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">��վ�渶�ܶ��{$var.num_late_repay_account|default:0}</div>
					<div class="linvest">���ڷ������룺��{$var.late_collection|default:0}</div>
					<div class="linvest">��ʧ��Ϣ�ܶ��{$var.num_late_interes|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">����տ����ڣ�{$var.r_collection_last_time|date_format:"Y-m-d"|default:-}</div>
				</div>
				<div style="line-height:30px; font-size:15px; font-weight:bold">�����ʽ�����</div>
			

				<div class="user_right_border">
					<div class="linvest">����ܶ��{$var.borrow_num|default:0}</div>
					<div class="linvest">�ѻ��ܶ��{$var.borrow_num1|default:0}</div>
					<div class="linvest">δ���ܶ��{$var.wait_payment|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">���������{$var.borrow_times|default:0}</div>
					<div class="linvest">���������{$var.payment_times|default:0}</div>
					<div class="linvest">����������{$var.borrow_repay0|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">����������ڣ�{$var.new_repay_time|date_format:"Y-m-d"}</div>
					<div class="linvest">���Ӧ�������{$var.new_repay_account|default:0}</div>
				</div>
				<!--  add for bug 274 begin -->
 				{if $_G.system.con_circulation=="1"}
				<div style="line-height:30px; font-size:15px; font-weight:bold">��ת������</div>
				<div class="user_right_border">
					<div class="linvest">������ת�걾�𣺣�{$var.circulation_capital_c|default:0}</div>
					<div class="linvest">������ת����Ϣ����{$var.circulation_interest_c|default:0}</div>
				</div>
				<div class="user_right_border">
					<div class="linvest">������ת�걾��{$var.circulation_capital_r|default:0}</div>
					<div class="linvest">������ת����Ϣ��{$var.circulation_interest_r|default:0}</div>
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
					<td>��{ $var.num}</td>
					{/loop}
				</tr>
		</table>
		-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed"  width="300" style="margin-top:20px;">
		<tr class="head"  width="300">
		<td>����</td>
		<td>�ɹ����+</td>
		<td>���������-</td>
		<td>��֤��-</td>
		<td>����-</td>
		<td>Ͷ��-</td>
		<td>�����ܶ�+</td>
		<td>Ͷ�꽱��+</td>
        <td>��������+</td>
        <td>��Ϣ����+</td>
		<td>����-</td>
		<td>��ֵ+</td>
		<td>����-</td>
		</tr>
			{loop module="account" function="GetLogCount" var="var" user_id=0 dotime1="$magic.request.dotime1"  dotime2="$magic.request.dotime2" }
				<tr  {if $var.i%2==1} class="tr1"{/if}>
				
					<td>{ $key}</td>
					<td {if $var.borrow_success!=""} style="color:#FF0000"{/if}>��{ $var.borrow_success|default:0}</td>
					<td {if $var.borrow_fee!=""} style="color:#FF0000"{/if}>��{ $var.borrow_fee|default:0}</td>
					<td {if $var.margin!=""} style="color:#FF0000"{/if}>��{ $var.margin|default:0}</td>
					<td {if $var.award_lower!=""} style="color:#FF0000"{/if}>��{ $var.award_lower|default:0}</td>
					<td {if $var.tender!=""} style="color:#FF0000"{/if}>��{ $var.tender|default:0}</td>
					<td {if $var.collection!=""} style="color:#FF0000"{/if}>��{ $var.collection|default:0}</td>
					<td {if $var.award_add!=""} style="color:#FF0000"{/if}>��{ $var.award_add|default:0}</td>
                    <td >��</td>
                    <td >��</td>
					<td {if $var.invest_repayment!=""} style="color:#FF0000"{/if}>��{ $var.invest_repayment|default:0}</td>
					<td {if $var.recharge!=""} style="color:#FF0000"{/if}>��{ $var.recharge+$var.recharge_online|default:0}</td>
					<td {if $var.recharge_success!=""} style="color:#FF0000"{/if}>��{ $var.recharge_success|default:0}</td>
					
				</tr>
				{/loop}
				
		</table>	
			{/if}
	</div>

	<!--�ұߵ����� ����-->
</div>
<!--�û����ĵ�����Ŀ ����-->
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