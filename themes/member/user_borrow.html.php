<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
<div id="main" class="clearfix" style="margin-top:0px;">
<div class="wrap950 ">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			{if $_U.query_type=="repayment" || $_U.query_type=="repaymentplan" || $_U.query_type=="loandetail" || $_U.query_type=="repaymentyes" || $_U.query_type=="repayment_view" }
			<ul id="tab" class="list-tab clearfix">
				<li {if $_U.query_type=="repayment"} class="cur"{/if}><a href="{$_U.query_url}/repayment">���ڻ���Ľ��</a></li>
				<li {if $_U.query_type=="repaymentplan"} class="cur"{/if}><a href="{$_U.query_url}/repaymentplan">������ϸ��</a></li>
				<li {if $_U.query_type=="loandetail"} class="cur"{/if}><a href="{$_U.query_url}/loandetail">�����ϸ��</a></li>
				<li {if $_U.query_type=="repaymentyes"} class="cur"{/if}><a href="{$_U.query_url}/repaymentyes">�ѻ���Ľ��</a></li>
				{if $magic.request.id!=""} 
				<li {if $_U.query_type=="repayment_view"} class="cur"{/if}>��Ļ�����Ϣ</li>
				{/if}
			</ul>
			{elseif $_U.query_type=="succes" || $_U.query_type=="gathered" || $_U.query_type=="gathering" || $_U.query_type=="lenddetail" || $_U.query_type=="succesyes"}
			<ul class="list-tab clearfix">
				<li {if $magic.request.type=="wait" && $_U.query_type=="succes"} class="cur"{/if}><a href="{$_U.query_url}/succes&type=wait">�����տ�Ľ��</a></li>
				<!-- 
				<li {if $magic.request.type=="yes" && $_U.query_type=="succes"} class="cur"{/if}><a href="{$_U.query_url}/succes&type=yes">�տ�����Ľ��</a></li>
				 -->
				<li {if $_U.query_type=="gathered" } class="cur"{/if} ><a href="{$_U.query_url}/gathered">���տ���ϸ��</a></li>
				<li {if $_U.query_type=="gathering" } class="cur"{/if} ><a href="{$_U.query_url}/gathering">δ�տ���ϸ��</a></li>
				<li {if $_U.query_type=="lenddetail"} class="cur"{/if} ><a href="{$_U.query_url}/lenddetail">�����ϸ��</a></li>
			</ul>
			{elseif  $_U.query_type=="bid" || $_U.query_type=="appraisal" || $_U.query_type=="attention" ||  $_U.query_type=="tender_reply"}
			<ul class="list-tab clearfix">
				<li {if $_U.query_type=="bid"} class="cur"{/if}><a href="{$_U.query_url}/bid">����Ͷ��Ľ��</a></li>
				<li {if $_U.query_type=="appraisal"} class="cur"{/if}><a href="{$_U.query_url}/appraisal">�ҵ�����</a></li>
				<li {if $_U.query_type=="tender_reply"} class="cur"{/if}><a href="{$_U.query_url}/tender_reply">�����߻ظ�</a></li>
			</ul>
			{elseif $_U.query_type=="tender_vouch" || $_U.query_type=="tender_vouch_finish" }
			<ul class="list-tab clearfix">
			<li {if $_U.query_type=="tender_vouch"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch">Ͷ��/���󵣱���</a></li>
			<li {if $magic.request.status=="0"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch_finish&status=0">�����еĵ�����</a></li>
			<li {if $magic.request.status=="1"} class="cur"{/if}><a href="{$_U.query_url}/tender_vouch_finish&status=1">�ѻ���ĵ�����</a></li></ul>
			{elseif $_U.query_type=="myuser" || $_U.query_type=="myuserrepay" || $_U.query_type=="myuser_account" }
			<ul class="list-tab clearfix">
				<li ><a href="index.php?user&q=code/user/myuser">�ҵĿͻ�</a></li>
				<li {if $_U.query_type=="myuserrepay" || $_U.query_type=="myuser"} class="cur"{/if}><a href="index.php?user&q=code/borrow/myuser">�ͻ����</a></li>
				<li {if $_U.query_type=="myuser_account"} class="cur"{/if}><a href="index.php?user&q=code/borrow/myuser_account">ͳ����Ϣ</a></li>
			</ul>
			<!--  add for bug 21 begin-->
			{elseif $_U.query_type=="alienate"}<!-- �ҵ�ծȨ�б����б�����ת�÷�����ť -->
			{elseif $_U.query_type=="alienate_detail"}<!-- ѡ��ծȨ��ϸ�� -->
			{elseif $_U.query_type=="alienate_buy_list"}<!-- ծȨ�������־-->
			{elseif $_U.query_type=="alienate_sell_list"}<!-- ծȨ���۵���־-->
			{elseif $_U.query_type=="alienate_market"}<!-- ծȨ�������� -->
			{elseif $_U.query_type=="alienate_buy"}<!-- ����ծȨ -->
			{elseif $_U.query_type=="alienate_myposted"}<!-- �ҷ�����ծȨת�ñ� -->
			<!--  add for bug 21 end-->
			<!--  add for bug 31 begin-->
			{elseif $_U.query_type=="quick_verify"}
			<!--  add for bug 31 end-->
			<!--  add for bug 32 begin-->
			{elseif $_U.query_type=="ontop"}
			<!--  add for bug 32 end-->
			<!--  add for bug 19 begin-->
			{elseif $_U.query_type=="purchased"}<!-- �ҵ���ת���Ϲ���¼ -->
			{elseif $_U.query_type=="buybackconfirm"}<!-- �ҵ���ת���Ϲ���¼ -->
			{elseif $_U.query_type=="purchasing"}<!-- �����Ϲ�����ת���б� -->
			{elseif $_U.query_type=="mycirculation"}<!-- �ҷ�������ת���б� -->
			{elseif $_U.query_type=="mycirculationserial"}<!-- �ҷ�������ת�������б� -->
			{elseif $_U.query_type=="mycirculationbuyback"}<!-- �ҷ�������ת�������б� -->
			<!--  add for bug 19 end-->
			{else}
			<ul class="list-tab clearfix">
				<li {if $_U.query_type=="publish"} class="cur"{/if}><a href="{$_U.query_url}/publish">�����б�Ľ��</a></li>
				<!-- 
				<li {if $_U.query_type=="unpublish"} class="cur"{/if}><a href="{$_U.query_url}/unpublish">��δ�����Ľ��</a></li>
				 -->
				<li {if $_U.query_type=="repayment"} class="cur"{/if}><a href="{$_U.query_url}/repayment">���ڻ���Ľ��</a></li>
				<!-- 
				<li {if $_U.query_type=="borrow_vouch"} class="cur"{/if}><a href="{$_U.query_url}/borrow_vouch">�����Ľ��</a></li>
				 -->
				<li {if $_U.query_type=="loanermsg"} class="cur"{/if}><a href="{$_U.query_url}/loanermsg">Ͷ���߻ظ�</a></li>
				{if in_array("credit", $biaotype_list) }
                <li {if $_U.query_type=="limitapp"} class="cur"{/if}><a href="{$_U.query_url}/limitapp">�������</a></li>
				{/if}
			</ul>
			{/if}
		</div>
		
		<div class="user_right_main">
		
	
		{if $_U.query_type=="publish"}
		<!--�����б� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo('')" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >����</td>
					<td  >���(Ԫ)</td>
					<td  >������</td>
					<td  >����</td>
					<td  >����ʱ��</td>
					<td  >����</td>
					<td  >״̬</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" status="0,1,2,4,5,6" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if} >
					<td width="70"  ><a href="/invest/a{$item.id}.html" title="{$item.name}" target="_blank">{$item.name|truncate:12}</a></td>
					<td  >{$item.biao_type_name}</td>
					<td  >{$item.account}Ԫ</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<td  >
					{if $item.is_vouch==1}
						<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%��Ͷ�꣩</span>
						<br>
					<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.vouch_scale|default:0}px"></div>
						</div><span class="floatl">{$item.vouch_scale}%��������</span>
					{else}	
					<div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%</span>
					{/if}	
					</td>
					<td  >{if $item.status==0}����������{elseif $item.status==1}
					{if $item.is_vouch==1}
					{if $item.account_yes==$item.account && $item.account_yes==$item.vouch_account}���������
					{else}����ļ��
					{/if}
					{else}
					{if $item.account_yes==$item.account}���������
					{else}����ļ��
					{/if}
					{/if}
					{elseif $item.status==2}���ʧ��{elseif $item.status==3}������{elseif $item.status==4}�������ʧ��{elseif $item.status==5}����{/if}</td>
					<td  >
					<!--  -->
					{if $item.status==0 || $item.status==1}<a href="#" onclick="javascript:if(confirm('ȷ��Ҫ���ش��б�')) location.href='{$_U.query_url}/cancel&id={$item.id}'">����</a>{/if}</td>
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
		
		<!--�����б� ����-->
		
		<!--  add for bug 31 begin-->
		<!--����Ӽ���˿�ʼ-->
		{elseif $_U.query_type=="quick_verify"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		�Ӽ������Ҫ����֧�����á�
		����
		��Ҫ֧������
		</div>
		<!--����Ӽ���˽���-->
		<!--  add for bug 31 end-->
		<!--  add for bug 32 begin-->
		<!--����Ӽ���˿�ʼ-->
		{elseif $_U.query_type=="ontop"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		�ö���Ҫ����֧�����á�
		����
		��Ҫ֧������
		�ö�����
		</div>
		<!--����Ӽ���˽���-->
		<!--  add for bug 33 end-->
		
		<!--��δ���� ��ʼ-->
		{elseif $_U.query_type=="unpublish"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >���(Ԫ)</td>
					<td  >������</td>
					<td  >����</td>
					<td  >����ʱ��</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" status="-1"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.name}</td>
					<td  >{$item.account}(Ԫ)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >{$item.addtime|date_format:"Y-m-d"}</td>
					<td  ><a href="/publish/index.html?article_id={$item.id}">�༭</a> <a href="#" onclick="javascript:if(confirm('ȷ��Ҫɾ�����б�')) location.href='{$_U.query_url}/del&id={$item.id}'">ɾ��</a></td>
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
		<!--��δ���� ����-->
		
		{elseif $_U.query_type=="repayment" ||  $_U.query_type=="repaymentyes"}
		<!--���ڻ���Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >Э��</td>
					<td  >�����</td>
					<td  >������</td>
					<td  >��������</td>
					<td  >������Ϣ</td>
					<td  >�ѻ���Ϣ</td>
					<td  >δ����Ϣ</td>
					<td  >����</td>
				</tr>{if $_U.query_type=="repayment"}
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="now" status="3"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.name|truncate:10}</a></td>
					<td  ><a href="/protocol/index.html?borrow_id={$item.id}" target="_blank">�鿴Э��</a></td>
					<td  >{$item.account}(Ԫ)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.repayment_yesaccount|default:0}</td>
					<td  >��{$item.repayment_noaccount}</td>
					<td  ><a href="{$_U.query_url}/repayment_view&id={$item.id}" target="_blank">������ϸ</a></td>
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
					<td  >�鿴Э��</td>
					<td  >{$item.account}(Ԫ)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.repayment_yesaccount|default:0}</td>
					<td  >��{$item.repayment_noaccount}</td>
					<td  ><a href="{$_U.query_url}/repayment_view&id={$item.id}" >������ϸ</a></td>
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
		<!--���ڻ���Ľ�� ����-->
		
		{elseif $_U.query_type=="repaymentplan"}
		<!--������ϸ ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�ڼ���</td>
					<td  >Ӧ��������</td>
					<td  >����Ӧ����Ϣ</td>
					<td  >��Ϣ</td>
					<td  >���ɽ�</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
					<td  >����״̬</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.interest}</td>
					<td  >��{$item.forfeit}</td>
					<td  >��{$item.late_interest}</td>
					<td  >{$item.late_days}��</td>
					<td  >{if $item.status==0}������{elseif $item.status==2}��վ�ȵ渶{else}�ѻ���{/if}</td>
					<td  >{if $item.status==0 || $item.status==2}<a href="#" onclick="javascript:if(confirm('��ȷ��Ҫ�����˽����')) location.href='{$_U.query_url}/repay&id={$item.id}'">����</a>{else}-{/if}</td>
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
		<!--������ϸ ����-->
		
		
		{elseif $_U.query_type=="myuserrepay"}
		<!--�ҵĿͻ� ��ʼ-->
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�ڼ���</td>
					<td  >�����û�</td>
					<td  >Ӧ��������</td>
					<td  >����Ӧ����Ϣ</td>
					<td  >��Ϣ</td>
					<td  >���ɽ�</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
					<td  >����״̬</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRepaymentList" showpage="3" user_id="$magic.request.user_id" keywords="request" kefu_userid= "$_G.user_id" dotime1="request" dotime2="request" order="repayment_time" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  ><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d H:i"}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.interest}</td>
					<td  >��{$item.forfeit}</td>
					<td  >��{$item.late_interest}</td>
					<td  >{$item.late_days}��</td>
					<td  >{if $item.status==0}������{else}�ѻ���{/if}</td>
					<td  >{if $item.status==0}<a href="#" onclick="javascript:if(confirm('��ȷ��Ҫ�����˽����')) location.href='{$_U.query_url}/repay&id={$item.id}'">����</a>{else}-{/if}</td>
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
		<!--�ҵĿͻ� ����-->
		
		
		{elseif $_U.query_type=="loandetail"}
		<!--�����ϸ ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		Ͷ���ߣ�<input type="text" name="username" id="username" size="15" value="{$magic.request.username|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo()" class="btn-action" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >���� </td>
					<td  >Ͷ���� </td>
					<td  >�����ܶ�</td>
					<td  >����ʱ��</td>
					<!-- 
					<td  >�����ܶ�</td>
					<td  >�ѻ���Ϣ</td>
					<td  >�ѻ����ɽ�</td>
					<td  >�����ܶ�</td>
					<td  >������Ϣ</td>
					-->
				</tr>
				{list module="borrow" var="loop" function ="GetTenderUserList" showpage="3" user_id="0" username="request" borrow_status=3}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name}</td>
					<td  >{$item.username}</td>

					<td  ><font color="#FF0000">��{$item.account}</font></td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<!-- 
					<td  >��{$item.repayment_yesaccount|default:0}</td>
					<td  >��{$item.repayment_yesinterest|default:0}</td>
					<td  >��{$item.forfeit|default:0}</td>
					<td  >��{$item.wait_account|default:0 }</td>
					<td  >��{$item.wait_interest|default:0}</td>
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
		<!--�����ϸ ����-->
		
		
		{elseif $_U.query_type=="loanermsg"}
		<!--Ͷ�������� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		�����ڲ鿴����:<select name="status"> <option value="">���лظ�</option> <option value="0">���һظ�</option> <option value="1">�ѻظ�</option></select>
		<input value="����" type="submit" class="btn-action"  class="btn-action" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ı���</td>
					<td  >������</td>
					<td  >��������</td>
					<td  >����ʱ��</td>
					<td  >����״̬</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.name}</td>
					<td  >{$item.account}(Ԫ)</td>
					<td  >{$item.apr} %</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
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
		<!--Ͷ�������� ����-->
		
		
		{elseif $_U.query_type=="limitapp"}
		<!--������� ��ʼ-->
		
		
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
		{article module="borrow" function="GetAmountApplyOne" user_id="0" var="var"}
		<form cur="" method="post">
		<div class="user_right_border">
			<div class="e">�����ߣ�</div>
			<div class="c">
				{$_G.user_result.username}
			</div>
		</div>
		{if $var.status==2}
		<div class="user_right_border">
			<div class="e"> ״̬��</div>
			<div class="c">
				���������
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"> �������ͣ�</div>
			<div class="c">
				{if $var.type=="tender_vouch"}Ͷ�ʵ������{elseif $var.type=="borrow_vouch"}�������{elseif $var.type=="restructuring"}ծ��������{else}������ö��{/if}
			</div>
		</div>
		<div class="user_right_border">
			<div class="e"> �����</div>
			<div class="c">
				{$var.account}
			</div>
		</div>
		<div class="user_right_border">
			<div class="e">��ϸ˵����</div>
			<div class="c">
				{$var.content}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">�����ط������ϸ˵����</div>
			<div class="c">
			{$var.remark}
			</div>
		</div>
		
		{else}
		
		<div class="user_right_border">
			<div class="e"> �������ͣ�</div>
			<div class="c">
				<select name="type"><option value="credit" {if $magic.request.type=="credit"} selected="selected"{/if}>������ö��</option><!--<option value="tender_vouch" {if $magic.request.type=="tender_vouch"} selected="selected"{/if}>Ͷ�ʵ������</option>
<option value="borrow_vouch" {if $magic.request.type=="borrow_vouch"} selected="selected"{/if}>�������</option><option value="restructuring" {if $magic.request.type=="restructuring"} selected="selected"{/if}>ծ��������</option>	-->	
				</select>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e"> �����</div>
			<div class="c">
				<input type="text" name="account" value="" onkeyup="value=value.replace(/[^0-9]/g,'')"/> 
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="e">��ϸ˵����</div>
			<div class="c">
				<textarea rows="5" cols="40" name="content"></textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">�����ط������ϸ˵����</div>
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
		{/if}
		</form>
		
		{/article}
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����ʱ��</td>
					<td  >��������</td>
					<td  >������(Ԫ)</td>
					<td  >ͨ�����(Ԫ)</td>
					<td  >��ע˵��</td>
					<td  >״̬</td>
					<td  >���ʱ��</td>
					<td  >��˱�ע</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAmountApplyList" showpage="3" user_id="0"  }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.addtime|date_format}</td>
					<td width="70">{if $item.type=="tender_vouch"}Ͷ�ʵ������{elseif $item.type=="borrow_vouch"}�������{elseif $item.type=="restructuring"}ծ��������{else}������ö��{/if}</td>
					<td  >{$item.account}</td>
					<td  >{$item.newaccount}</td>
					<td  width="200">{$item.content}</td>
					<td  >{if $item.status==0}��˲�ͨ��{elseif $item.status==1}���ͨ��{else}�������{/if}</td>
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
		* ��ܰ��ʾ���������� ���������Ƿ���׼ �����һ���º�����ٴ����룬ÿ����ֻ������һ����������,����������ϵ
		</div>
		<!--������� ����-->
		{/if}
		
		
				
		{elseif $_U.query_type=="succes" }
		<!--�ɹ�Ͷ�� ��ʼ-->
		<!-- 
		{article module="borrow" function="GetUserLog" user_id="0"}
		<div class="alert alert-block">���ͳ�ƣ�����ܶ{$var.success_account|default:0} �����ܶ{$var.collection_capital1|default:0} δ���ܶ{$var.collection_capital0|default:0} ������Ϣ��{$var.collection_interest1|default:0} δ����Ϣ��{$var.collection_interest0|default:0} </div>
		{/article}
		 -->
		<div class="well" > 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1"  size="15" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>   �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" />
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�����</td>
					<td  >����߻���</td>
					<td  >���(Ԫ)</td>
					<td  >������</td>
					<td  >����</td>
					<td  >Ӧ�ձ�Ϣ</td>
				</tr>
				{list module="borrow" var="loop" function ="GetBorrowSucces" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request"  type="$magic.request.type"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.username}">{$item.username}</a></td>
					<td  >{$item.credit|credit}{$item.credit}��</td>
					<td  >��{$item.account}</td>
					<td  >{$item.apr}%</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >��{$item.right_account}</td>
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
		<!--�ɹ�Ͷ�� ����-->
		
		{elseif $_U.query_type=="tender_vouch" }
		<!--�ɹ����� ��ʼ-->
		
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�����</td>
					<td  >����ܶ�</td>
					<td  >�������</td>
					<td  >��������</td>
					<td  >�����ܶ�</td>
					<td  >����ʱ��</td>
					<td  >��������</td>
					<td  >״̬</td>
				</tr>
				{list module="borrow" var="loop" function ="GetVouchList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="$magic.request.type" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.borrow_id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.borrow_username}">{$item.borrow_username}</a></td>
					<td  >��{$item.borrow_account}</td>
					<td  >{$item.borrow_period}����</td>
					<td  >��{$item.award_account}</td>
					<td  >��{$item.vouch_account}</td>
					<td  >{$item.addtime|date_format}</td>
					<td  >��{$item.vouch_collection}</td>
					<td  >{if $item.status==1}�ɹ�{elseif $item.status==2}<font color="#FF0000">ʧ��</font>{else}�����{/if}</td>
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
		<!--������ϸ ����-->
		{elseif $_U.query_type=="tender_vouch_finish"}
		
 
</div>
		<div class="well" style="height:30px; padding-top:7px;"> 
		�տ�ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >�����</td>
					<td  >������</td>
					<td  >Ӧ������</td>
					<td  >�ڼ���/������</td>
					<td  >�ܶ�</td>
					<td  >����</td>
					<td  >��Ϣ</td>
					<td  >����״̬</td>
					<td  >�������</td>
					<td  >������ʽ</td>
					<td  >�渶״̬</td>
					<td  >�渶ʱ��</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetVouchRepayList" showpage="3" vouch_userid="$_G.user_id" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status" order="order" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_username}</td>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >��{$item.repayment_account }</td>
					<td  >��{$item.capital  }</td>
					<td  >��{$item.interest  }</td>
					<td  >{if $item.status==1  }<font color="#666666">�ѻ�</font>{else}<font color="#FF0000">δ��</font>{/if}</td>
					<td  >��{$item.vouch_collection  }</td>
					<td  >{if $item.vouch_type=="amount"  }�������{else}�������{/if}</td>
					<td  >{if $item.is_advance==1  }<font color="#666666">�ѵ渶</font>{elseif $item.is_advance==2}<font color="#FF0000">��վǿ�Ƶ渶</font>{else}<font color="#FF0000">δ�渶</font>{/if}</td>
					<td  >{$item.advance_time|date_format:"Y-m-d"}</td>
					<td  >{if $item.is_advance==0 &&  $item.repay_status==0}<a href="index.php?user&q=code/borrow/voucher_advance&id={$item.vouch_id}" onclick="return confirm('ȷ���渶��')">�渶</a>{/if}</td>
					
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
		<!--������ϸ ����-->
		
		{elseif $_U.query_type=="gathered"}
		<!--  
		{article module="account" function="GetAccountAll" user_id="0" }
		<div class="user_help">
		<table class="table alert">
			<tr>
			<td>Ͷ���ܶ��{$var.tender_num|default:0}(�������ڵ�ͳ��) </td>
			<td>�����ܶ��{$var.tender_yesnum|default:0}   </td>
			<td></td>
		</tr>
		<tr>
			<td>�����ܶ��{$var.tender_wait|default:0}</td>
			<td>������Ϣ����{$var.tender_wait_interest|default:0} </td>
			<td>ʵ����Ϣ����{$var.tender_wait_interest*0.9}  </td>
		</tr>
	</table>
		
</div>
    {/article}
 -->
		<div class="well" style="height:30px; padding-top:7px;"> 
		�տ�ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >Ӧ������</td>
					<td  >�����</td>
					<td  >�ڼ���/������</td>
					<td  >�տ��ܶ�</td>
					<td  >Ӧ�ձ���</td>
					<td  >Ӧ����Ϣ</td>
                    <td  >�����</td>
                    <!-- 
                    <td  >ʵ����Ϣ</td>
					 -->
					<td  >��������</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
					<td  >״̬</td>
				</tr>
				{list module="borrow" var="loop" function ="GetCollectionedList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status"  borrow_id="$magic.request.borrow_id" order="repay_time"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repay_time|date_format:"Y-m-d"}</td>
					<td  >{$item.username}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >��{$item.repay_account }</td>
					<td  >��{$item.capital  }</td>
					<td  >��{$item.interest  }</td>
                    <td  >��{$item.interest_fee}</td>
					<td  >{$item.repay_yestime|date_format:"Y-m-d"}</td>
                    <!-- 
                    <td  >��{$item.interest*0.9}</td>
					 -->
					<td  >��{$item.late_interest|default:0  }</td>
					<td  >{$item.late_days|default:0  }��</td>
					<td  >{if $item.status==1  }<font color="#666666">�ѻ�</font>{else}<font color="#FF0000">δ��</font>{/if}</td>
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
		<!--�տ���ϸ ����-->
		
		{elseif $_U.query_type=="gathering"}
		<!-- 
		{article module="account" function="GetAccountAll" user_id="0" }
		<div class="user_help">
		<table class="table alert">
			<tr>
			<td>Ͷ���ܶ��{$var.tender_num|default:0}(�������ڵ�ͳ��) </td>
			<td>�����ܶ��{$var.tender_yesnum|default:0}   </td>
			<td></td>
		</tr>
		<tr>
			<td>�����ܶ��{$var.tender_wait|default:0}</td>
			<td>������Ϣ����{$var.tender_wait_interest|default:0} </td>
			<td>ʵ����Ϣ����{$var.tender_wait_interest*0.9}  </td>
		</tr>
	</table>
		
</div>
    {/article}
  -->
		<div class="well" style="height:30px; padding-top:7px;"> 
		�տ�ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >Ӧ������</td>
					<td  >�����</td>
					<td  >�ڼ���/������</td>
					<td  >�տ��ܶ�</td>
					<td  >Ӧ�ձ���</td>
					<td  >Ӧ����Ϣ</td>
					<!-- 
                    <td  >�����</td>
                    <td  >ʵ����Ϣ</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
                     -->
					<td  >״̬</td>
					
				</tr>
				{list module="borrow" var="loop" function ="GetCollectioningList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status=3 status="$magic.request.status"  borrow_id="$magic.request.borrow_id" order="repay_time"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  ><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:13}</a></td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >{$item.username}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >��{$item.r_total }</td>
					<td  >��{$item.r_capital  }</td>
					<td  >��{$item.r_interest  }</td>
					<!-- 
					<td  >��0</td>
					<td  >0��</td>
					 -->
					<td  >{if $item.status==1  }<font color="#666666">�ѻ�</font>{else}<font color="#FF0000">δ��</font>{/if}</td>
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
		<!--�տ���ϸ ����-->
		<!--  add for bug 21 begin-->
		{elseif $_U.query_type=="alienate_detail"}
		
 
</div>
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/post_alienate">
		ת�ü۸񣨱�����ת�õ�λ������������<input type="text" name="price" id="price" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">��Сת�õ�λ<input type="text" name="unit" id="unit" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">	
		<input type="hidden" name="borrow_right_id" value="{$magic.request.borrow_right_id}">
		<input type="submit" value="ȷ��ת��" class="btn-action">
		</form> 
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�ڼ���</td>
					<td  >Ӧ��������</td>
					<td  >����Ӧ����Ϣ</td>
					<td  >��Ϣ</td>
					<td  >���ɽ�</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
					<td  >����״̬</td>
					<td  >��ռ�ݶ�</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" borrow_right_id="$magic.request.borrow_right_id" isface=1}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.interest}</td>
					<td  >��{$item.forfeit}</td>
					<td  >��{$item.late_interest}</td>
					<td  >{$item.late_days}��</td>
					<td  >{$item._status}</td>
					<td  >{$item.has_percent}%{if $item.has_percent==0}������Ч��{/if}</td>
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

		<!--Ͷ�ʱ��տ�ϸ�ڽ���-->		
		<!--  add for bug 21 end-->
		
		<!--  add for bug 76 begin-->
		{elseif $_U.query_type=="alienate_market"}
		<!--ծȨ�������Ŀ�ʼ-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >ծȨ������</td>
					<td  >ծȨ��ֵ</td>
					<td  >���ϼ���</td>
					<td  >ת�ü۸�</td>
					<td  >ת�õ�λ</td>
					<td  >���ɹ������</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" areaid="$_G.areaid"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.borrow_name|truncate:10}</td>
					<td  >{$item.username}</td>
					<td  >{$item.amount}</td>
					<td  >{if $item.origin_creditor_level==1}VIP������{else}��ͨ�û�����{/if}</td>
					<td  >{$item.price}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.valid_unit_num}</td>
					<td  ><a href="index.php?user&q=code/borrow/alienate_buy&borrow_right_id={$item.borrow_right_id}&right_alienate_id={$item.id}">��������</a></td>
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

		<!--ծȨ�������Ľ���-->		
		<!--  add for bug 76 end-->

		<!--  add for bug 78 begin-->
		{elseif $_U.query_type=="alienate_buy"}
		{article module="borrow" function="GetAlienateDetail" id="$magic.request.right_alienate_id" var="alienate"}
		<!--ծȨ����ʼ-->

		<div class="user_help">

		<table class="table alert">
			<tr>
			<td>ծȨ��ֵ�� ��{$alienate.amount}</td>
			<td>ת�ü۸񣺣� {$alienate.price}</td>
			<td>���ݼ۸񣺣� {$alienate.unit}</td>
			</tr>
			<tr>
			<td>���ɹ�������� {$alienate.valid_unit_num}</td>
			<td>ԭʼծȨ��ռ������{$alienate.right_percent}%</td>
			<td><!--���ϼ��� {if $alienate.origin_creditor_level==1}VIP������{else}��ͨ�û�����{/if}--></td>
			</tr>
		</table>
		
    {/article}
 
</div>
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/buy_alienate">
		�������:<input type="text" name="unit_num" id="unit_num" value="" onkeyup="value=value.replace(/[^0-9]/g,'')">		
		<input type="hidden" name="right_alienate_id" value="{$magic.request.right_alienate_id}" >
		<input type="submit" value="ȷ���ύ" class="btn-action">
		</form> 
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�ڼ���</td>
					<td  >Ӧ��������</td>
					<td  >����Ӧ����Ϣ</td>
					<td  >��Ϣ</td>
					<td  >���ɽ�</td>
					<td  >������Ϣ</td>
					<td  >��������</td>
					<td  >����״̬</td>
				</tr>
				{list module="borrow" var="loop" function ="GetAlienateRepaymentList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" borrow_right_id="$magic.request.borrow_right_id"}
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.order+1}/{$item.time_limit}</td>
					<td  >{$item.repayment_time|date_format:"Y-m-d"}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >��{$item.interest}</td>
					<td  >��{$item.forfeit}</td>
					<td  >��{$item.late_interest}</td>
					<td  >{$item.late_days}��</td>
					<td  >{if $item.status==0}������{elseif $item.status==2}��վ�ȵ渶{else}�ѻ���{/if}</td>
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
		<!--ծȨ�������-->		
		<!--  add for bug 78 end-->		
		
		<!--  add for bug 79 begin-->
		{elseif $_U.query_type=="alienate_myposted"}
		<!--ծȨ�������Ŀ�ʼ-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >ծȨ��ֵ</td>
					<td  >���ϼ���</td>
					<td  >ת�ü۸�</td>
					<td  >ת�õ�λ</td>
					<td  >���ɹ������</td>
					<td  >״̬</td>
					<td  >��Ч</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetMyPostedAlienateList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" order="repayment_time" status="0,2" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</td>
					<td  >{$item.amount}</td>
					<td  > {if $item.origin_creditor_level==1}VIP������{else}��ͨ�û�����{/if}</td>
					<td  >{$item.price}</td>
					<td  >{$item.unit}</td>
					<td  >{$item.valid_unit_num}</td>
					<td  >{if $item.status==0}�ѳ���{elseif $item.status==2}�������{else}����{/if}</td>
					<td  >{if $item.valid==0}��Ч{else}����{/if}</td>
					<td  >{if $item.status==1 && $item.valid==1}<a href="index.php?user&q=code/borrow/cancel_alienate&right_alienate_id={$item.id}">����</a>{/if}</td>
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

		<!--ծȨ�������Ľ���-->		
		<!--  add for bug 79 end-->
		
		<!--  add for bug 83 begin-->
		{elseif $_U.query_type=="alienate_buy_list"}
		<!--�ҹ����ծȨ��¼��ʼ��ʼ-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >�������</td>
					<td  >��λ�۸�</td>
					<td  >����ծȨ����</td>
					<td  >����ծȨ</td>
					<td  >����ʱ��</td>
                    <td  >Э��</td>
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
                    <td><a href="/protocolright/index.html?serial_id={$item.id}" target="_blank">�鿴Э��</a></td>
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

		<!--�ҹ����ծȨ�б����-->		
		<!--  add for bug 83 end-->
		
		<!--  add for bug 84 begin-->
		{elseif $_U.query_type=="alienate_sell_list"}
		<!--���۳���ծȨ��¼��ʼ��ʼ-->

		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >������</td>
					<td  >������</td>
					<td  >�������</td>
					<td  >��λ�۸�</td>
					<td  >����ծȨ����</td>
					<td  >����ծȨ</td>
					<td  >����ʱ��</td>
                    <td  >Э��</td>
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
                    <td><a href="/protocolright/index.html?serial_id={$item.id}" target="_blank">�鿴Э��</a></td>
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

		<!--�ҹ����ծȨ�б����-->		
		<!--  add for bug 84 end-->				
		
		{elseif $_U.query_type=="lenddetail"}
		<!--�����ϸ ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >�����</td>
					<td  >����</td>
					<td  >����ܶ�</td>
					<td  >�����ܶ�</td>
					<td  >Ͷ��ʱ��</td>
					<!-- 
					<td  >�����ܶ�</td>
					<td  >�����ܶ�</td>
					<td  >������Ϣ</td>
					<td  >������Ϣ</td>
					-->
				</tr>
			{list module="borrow" var="loop" function ="GetTenderList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td  >{$item.op_username}</td>
					<td  ><a href="/invest/a{$item.borrow_id}.html">{$item.borrow_name|truncate:14}</a></td>
					<td  >��{$item.tender_account}</td>
					<td  >��{$item.repayment_account}</td>
					<td  >{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					<!-- 
					<td  >��{$item.repayment_yesaccount}</td>
					<td  >��{$item.wait_account  }</td>
					<td  >��{$item.repayment_yesinterest }</td>
					<td  >��{$item.wait_interest  }</td>
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
		<!--�����ϸ ����-->
		
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="purchased"}
		<!--����Ͷ��Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		�Ϲ�ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ת��</td>
					<td  >�����</td>
					<td  >�Ϲ�����</td>
					<td  >��Ϣ��ʼʱ��</td>
					<td  >��Ϣ����ʱ��</td>
					<td  >�·� </td>
					<td  >����</td>
					<td  >��λ�۸�</td>
					<td  >������</td>
					<td  >����</td>
					<td  >��Ϣ</td>
					<td  >����ʽ</td>
					<td  >�Ƿ�ع�</td>
					<td  >����</td>
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
					<td style="line-height:21px;">{if $item.buy_type=="award"}����{else}�ֽ�{/if}</td>
					<td style="line-height:21px;">{if $item.buyback==1}�ѻع�{else}δ�ع�{/if}</td>
					<td style="line-height:21px;">{if $item.buyback==0 && $item.st==0}<a href="index.php?user&q=code/borrow/buybackconfirm&buy_id={$item.id}">�ع�</a>{/if}</td>
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
		<!--����Ͷ��Ľ�� ����-->
		<!--  add for bug 19 end -->
		
		<!--  add for bug 214 begin-->
		{elseif $_U.query_type=="buybackconfirm"}
		<!--ծȨ����ʼ-->

		<div class="user_help">

		��Ϣʱ�䣺{$_U.buyback_info.can_interest_month}�� ������Ϣ{$_U.buyback_info.interest}Ԫ���ջر���{$_U.buyback_info.account_money}Ԫ���Զ�������{if $_U.buyback_info.auto_repurchase == 1}��{else}��{/if}		
 
		</div>
		
		<div class="well" style="height:30px; padding-top:7px;">
		<form method="post" action="/index.php?user&q=code/borrow/buyback">
		�Զ�������<input id="auto_repurchase" type="checkbox" name="auto_repurchase" value="1" {if $_U.buyback_info.auto_repurchase==1} checked="checked"{/if} />��ע�������ǰ�ع�����������ɹ�����<br/>		
		<input type="hidden" name="buy_id" value="{$magic.request.buy_id}" >
		<input type="submit" value="ȷ���ύ" class="btn-action">
		</form> 
		</div>
			
		<!--  add for bug 214 end-->
		
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="purchasing"}
		<!--����Ͷ��Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ת��</td>
					<td  >�Ϲ��ܽ��</td>
					<td  >�Ϲ���ʼ����</td>
					<td  >��С�Ϲ��·� </td>
					<td  >�Ϲ����� </td>
					<td  >ÿ�ݼ۸� </td>
					<td  >������</td>
					<td  >��������Ϣ</td>
					<td  >�ѻع�����</td>
					<td  >�����Ϲ�����</td>
					<td  >�ܷ���</td>
					<td  >����</td>
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
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html?detail=true" target="_blank" >����</a></td>
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
		<!--����Ͷ��Ľ�� ����-->
		
		{elseif $_U.query_type=="mycirculation"}
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ת��</td>
					<td  >����ܽ��</td>
					<td  >�Ϲ���ʼ����</td>
					<td  >��С�Ϲ��·� </td>
					<td  >�Ϲ����� </td>
					<td  >ÿ�ݼ۸� </td>
					<td  >������</td>
					<td  >��������Ϣ</td>
					<td  >�ѻع�����</td>
					<td  >�����Ϲ�����</td>
					<td  >�ܷ���</td>
					<td  >״̬</td>
					<td  >����</td>
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
					<td style="line-height:21px;">{if $item.status==0}�����{elseif $item.status==5}�ѳ���{elseif $item.status==2}���δͨ��{else}����{/if}</td>
					<td style="line-height:21px;">{if $item.status==0 || $item.status==1}<a href="index.php?user&q=code/borrow/cancel&id={$item.borrow_id}" target="_blank" >����</a>{/if}</td>
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
		<!--����Ͷ��Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ת��</td>
					<td  >�Ϲ���</td>
					<td  >�Ϲ�����</td>
					<td  >�·� </td>
					<td  >����</td>
					<td  >��λ�۸�</td>
					<td  >������</td>
					<td  >����</td>
					<td  >��Ϣ</td>
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
		<!--����Ͷ��Ľ�� ����-->
		<!--  add for bug 19 end -->
		<!--  add for bug 19 begin -->		
		{elseif $_U.query_type=="mycirculationbuyback"}
		<!--����Ͷ��Ľ�� ��ʼ-->
		
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >�ع�����</td>
					<td  >����</td>
					<td  >��Ϣ</td>
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
		<!--����Ͷ��Ľ�� ����-->
		<!--  add for bug 19 end -->
		
		{elseif $_U.query_type=="bid"}
		<!--����Ͷ��Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�����</td>
					<td  >Ͷ��/��Ч���</td>
					<td  >���û���/Ͷ��ʱ�� </td>
					<td  >����</td>
					<td  >״̬ </td>
				</tr>
				{list module="borrow" var="loop" function ="GetTenderList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" borrow_status="1" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td style="line-height:21px;"><a href="/invest/a{$item.borrow_id}.html" target="_blank" title="{$item.borrow_name}">{$item.borrow_name|truncate:10}</a> </td>
					<td  style="line-height:21px;">�����:{$item.op_username}</td>
					<td style="line-height:21px;">Ͷ����:��{$item.money}<br />��Ч���:<font color="#FF0000">��{$item.tender_account}</font></td>
					
					<td style="line-height:25px;"><span><img src="{$_G.system.con_credit_picurl}{ $item.credit_pic}" title="{$item.credit_jifen}��"  /></span><br />{$item.addtime|date_format:"Y-m-d H:i:s"}</td>
					
					<td style="line-height:21px;"><div class="rate_bg floatl" align="left">
							<div class="rate_tiao" style=" width:{$item.scale|default:0}px"></div>
						</div><span class="floatl">{$item.scale}%</span></td>
					<td style="line-height:21px;">{if $item.status==0}Ͷ��ʧ��{else}{if $item.tender_account==$item.money}ȫ��ͨ��{else}����ͨ��{/if}{/if}</td>
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
		<!--����Ͷ��Ľ�� ����-->
		
		{elseif $_U.query_type=="appraisal"}
		<!--�ҵ����� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"  class="btn-action"  onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����      </td>
					<td  >�����</td>
					<td  >Ͷ����</td>
					<td  >���ʱ��</td>
					<td  >���۽��</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>���ڽ���ǰ����</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1����</td>
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
		<!--�ҵ����� ����-->
		
		
		{elseif $_U.query_type=="attention"}
		<!--�ҹ�ע�Ľ�� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		<select><option>�����еĽ��</option><option>�ѽ����Ľ��</option></select> ����ʱ�䣺<input type="text" name="dotime1" id="dotime1" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>  �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" /> 
		<input value="����" type="submit" class="btn-action"   onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >ͼƬ                  </td>
					<td  >����</td>
					<td  >���(Ԫ)</td>
					<td  >����</td>
					<td  >����</td>
					<td  >���õȼ�</td>
					<td  >����</td>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>���ڽ���ǰ����</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1����</td>
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
		<!--�ҹ�ע�Ľ�� ����-->
		
		
		{elseif $_U.query_type=="tender_reply"}
		<!--Ͷ�������� ��ʼ-->
		<div class="well" style="height:30px; padding-top:7px;"> 
		�����ڲ鿴����:<select name="status"> <option value="">���лظ�</option> <option value="0">���һظ�</option> <option value="1">�ѻظ�</option></select>
		<input value="����" type="submit" class="btn-action"  />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >��ı���</td>
					<td  >������</td>
					<td  >��������</td>
					<td  >����ʱ��</td>
					<td  >����״̬</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetList" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if}>
					<td ><strong>���ڽ���ǰ����</strong> </td>
					<td  >op6778</td>
					<td><img src="/pic/rank_4.gif" /></td>
					<td  >18%</td>
					<td  >1����</td>
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
		<!--Ͷ�������� ����-->
		
		
		
		{elseif $_U.query_type=="myuser"}
		<!--�ҵĿͻ� ����-->
		<div class="user_help" > 
		{list  module="borrow" function="GetMyuserList" var="loop" user_id="0" showpage=3 epage=20 suser_id = "$magic.request.user_id"}
			
		<strong>�ܽ������</strong> {$loop.total} ��
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >�û���</td>
					<td  >��ʵ����</td>
					<td  >����</td>
					<td  >�����</td>
					<td  >���ʱ��</td>
					<td  >�ɹ����ʱ��</td>
					<td  >״̬</td>
				</tr>
					{foreach from="$loop.list" item="item"}
				<tr >
					<td><a href="/u/{$item.user_id}" target="_blank">{$item.username}</a></td>
					<td><a href="{$_U.query_url}/myuser&user_id={$item.user_id}">{$item.realname}</a> </td>
					<td><a href="/invest/a{$item.id}.html" target="_blank">{$item.name}</a></td>
					<td>��{$item.account}</td>
					<td>{$item.addtime|date_format}</td>
					<td>{$item.success_time|date_format|default:"-"}</td>
					<td>{if $item.status==5}ȡ��{elseif $item.status==3}���ɹ�{elseif $item.status==2}���ʧ��{elseif $item.status==4}�������ʧ��{elseif $item.status==1}�����б���{/if}</td>
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
		<!--�ҵĿͻ� ����-->
		<!--  add for bug 21 begin -->
		{elseif $_U.query_type=="alienate" }
		<!--ծȨת�� ��ʼ-->
		
		<div class="well" > 
		����ʱ�䣺<input type="text" name="dotime1" id="dotime1"  size="15" value="{$magic.request.dotime1}" size="15" onclick="change_picktime()"/> �� <input type="text"  name="dotime2" value="{$magic.request.dotime2}" id="dotime2" size="15" onclick="change_picktime()"/>   �ؼ��֣�<input type="text" name="keywords" id="keywords" size="15" value="{$magic.request.keywords|urldecode}" />
		<input value="����" type="submit" class="btn-action" onclick="sousuo()" />
		</div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >����</td>
					<td  >�����</td>
					<td  >���(Ԫ)</td>
					<td  >������</td>
					<td  >����</td>
					<td  >����黹��Ϣ</td>
					<td  >��ռ����</td>
					
					<td  >���ϼ���</td>
                    <td  >ծȨ��ֵ</td>
					<td  >����</td>
				</tr>
				{list module="borrow" var="loop" function ="GetRightCanAlienate" showpage="3" user_id="0" keywords="request" dotime1="request" dotime2="request" type="$magic.request.type" }
				{foreach from="$loop.list" item="item"}
				<tr {if $key%2==1} class="tr1"{/if} {if $item.amount==0}style="text-decoration:line-through"{/if}>
					<td title="{$item.borrow_name}"><a href="/invest/a{$item.id}.html" target="_blank">{$item.borrow_name|truncate:10}</a></td>
					<td  ><a href="/index.php?user&q=code/message/sent&receive={$item.username}">{$item.username}</a></td>
					<td  >��{$item.account}</td>
					<td  >{$item.apr}%</td>
					<td  >{if $item.isday==1}{$item.time_limit_day}��{else}{$item.time_limit}����{/if}</td>
					<td  >{$item.needrepayment}</td>
					<td  >{$item.has_percent}%</td>
					
					<td  >{if $item.origin_creditor_level==1}VIP������{elseif $item.origin_creditor_level==0}��ͨ�û�����{else}������{/if}</td>
                    <td  >{$item.amount}</td>
					<td  >{if $item.amount==0}
                    ����Ч
                    {else}
                    <a href="index.php?user&q=code/borrow/alienate_detail&borrow_right_id={$item.borrow_right_id}">ծȨת��</a>{/if}</td>
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
		<!--ծȨת�� ����-->
		<!--  add for bug 21 end -->
		
		
		{elseif $_U.query_type=="myuser_account"}
		<!--�ҵĿͻ�ͳ�� ����-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >ʱ��</td>
					<td  >�ɹ����</td>
					<td  >�ɹ�Ͷ��</td>
					<td  >VIP��</td>
				</tr>
					{loop  module="borrow" function="GetMyuserAcount" var="var" user_id="0" }
				<tr >
					<td>{$key|date_format:"Y-m"}</td>
					<td>��{$var.borrow|default:0}</td>
					<td>��{$var.tender|default:0}</td>
					<td>{$var.vip|default:0}��</td>
				</tr>
				{/loop}
			</form>	
		</table>
		{/list}
		<!--�ҵĿͻ�ͳ�� ����-->
		
		
		
		<!--������ϸ ��ʼ-->
		{elseif $_U.query_type=="repayment_view"}
		<div class="user_right_border">
			<div class="l">���⣺</div>
			<div class="c">
				{$_U.borrow_result.name}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> ����</div>
			<div class="rb">
				<font color="#FF0000"><strong>��{$_U.borrow_result.account}</strong></font>
			</div>
			<div class="l"> ������ʣ�</div>
			<div class="rb">
				 {$_U.borrow_result.apr}%
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> ������ޣ�</div>
			<div class="rb">
{if $_U.borrow_result.isday==1}{$_U.borrow_result.time_limit_day}��{else}{$_U.borrow_result.time_limit}����{/if}
			</div>
			<div class="l"> ���ʽ��</div>
			<div class="rb">
				 {$_U.borrow_result.style|linkage:"borrow_style"}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"> ����ʱ�䣺</div>
			<div class="rb">
				 {$_U.borrow_result.addtime|date_format:"Y-m-d H:i:s"}
			</div>
			<div class="l"> ���ʱ�䣺</div>
			<div class="rb">
				 {$_U.borrow_result.verify_time|date_format:"Y-m-d H:i:s"}
			</div>
		</div>
		<!--
		<div class="user_right_border">
			<div class="l"> �´λ���ʱ�䣺</div>
			<div class="rb">
				 {$_U.borrow_result.username}
			</div>
			<div class="l"> �´λ����</div>
			<div class="rb">
				 {$_U.user_result.username}
			</div>
		</div>
		-->
		<!--������ϸ ����-->
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form cur="" method="post">
				<tr class="head" >
					<td  >���</td>
					<td  >�ƻ�������</td>
					<td  >�ƻ����Ϣ</td>
					<td  >ʵ������</td>
					<td  >ʵ����Ϣ</td>
					<td  >���ڷ�Ϣ</td>
					<td  >��������</td>
					<td  >״̬</td>
					<td  >����</td>
				</tr>
				{loop module="borrow" function ="GetRepaymentList" " user_id="0" id="request" limit="all" order="order"}
			
				<tr {if $key%2==1} class="tr1"{/if}>
					<td >{$var.order+1}</td>
					<td>{$var.repayment_time|date_format:"Y-m-d"}</td>
					<td>��{$var.repayment_account}</td>
					<td>{$var.repayment_yestime|date_format:"Y-m-d H:i"|default:-}</td>
					<td>��{$var.repayment_yesaccount}</td>
					<td>��{$var.late_interest|default:0}</td>
					<td>{$var.late_days|default:0}��</td>
					<td>{if $var.status==1}�ѻ�{elseif $var.status==2}���ϵ渶{else}������{/if}</td>
					<td>{if $var.status==1}-{else}<a href="#" onclick="javascript:if(confirm('��ȷ��Ҫ�����˽����')) location.href='{$_U.query_url}/repay&id={$var.id}'">����</a>{/if}</td>
				</tr>
				{/loop}
			</form>	
		</table>
		<div class="user_right_foot">ע�����С�(Ԥ��)����ǵĽ��˵���ý���ʵ�ʻ���Ľ���ֻ�Ǽ����Ե�ǰʱ��Ϊ����ʱ���������û���Ҫ�����ٽ� ���ջ���������ʵ�ʻ�����Ϊ׼����ΪԤ�ƵĽ���ʵ�ʻ���Ľ����ܻ��������졣 һ����ȫ��彫��֧���¸��µ���Ϣ������¼����״̬�������ӻ�����֡�
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
<!--�û����ĵ�����Ŀ ����-->
<script src="/themes/js/modal.js"></script>
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}