<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<!--�û����ĵ�����Ŀ ��ʼ-->
<div id="main" class="clearfix">
<div class="wrap950 mar10">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			
			<ul>
				<li class="title"><a href="{$_U.query_url}" style="color:red;"><strong>�������� </strong></a></li>
			</ul>
		</div>
		
		<div class="user_right_main">
		
		<!--�������� ��ʼ-->
		<div class="user_help alert">�빴ѡ��������ȡ������Ҫ����Ϣ���ѡ�
Ϊ�����Ľ��װ�ȫ��������Ҫ��Ϣ����ȡ�����ա� </div>
		<table  border="0"  cellspacing="1" class="table table-striped  table-condensed" style="width:98%">
			  <form action="" method="post">
			  {foreach from= $_U.remind_list item="item"}
				<tr class="head" >
					<td  colspan="4" class="well" style="text-align:center;"><strong>{$item.name}</strong></td>
				</tr>
				{foreach from=$item.list item="var"}
				<tr  >
					<td>{$var.name}</td>
					<td>
						{if $var.message==1 || $var.message==2}<input type="hidden"  {if $var.message==1 }checked="checked"{/if} name="message_{$var.nid}"  value="1" /><span disabled>{else}<span>{/if}
						<input type="checkbox"  {if $var.message==1 || $var.message==3}checked="checked"{/if} name="message_{$var.nid}" id="message_{$var.nid}" value="1" />
						<label for=message_{$var.nid}>վ��������</label></span> 
					</td>
					<td>
					{if $var.email==1 || $var.email==2}<input type="hidden"  {if $var.email==1 }checked="checked"{/if} name="email_{$var.nid}" value="1" /><span disabled>{else}<span>{/if}
						<input type="checkbox"  {if $var.email==1 || $var.email==3}checked="checked"{/if} name="email_{$var.nid}" id="email_{$var.nid}" value="1" />
						<label for=email_{$var.nid}>�ʼ����� </label></span> </td>
					<!-- 
					{if $var.phone==1 || $var.phone==2}<input type="hidden"  {if $var.phone==1 }checked="checked"{/if} name="phone_{$var.nid}"  value="1" /><span disabled>{else}<span>{/if}
						<input type="checkbox"  {if $var.phone==1 || $var.phone==3}checked="checked"{/if} name="phone_{$var.nid}" id="phone_{$var.nid}" value="1" />
						<label for=phone_{$var.nid}>�ֻ�����</label></span> </td>
					 -->	
				</tr>
				{/foreach}
			{/foreach }
				
		</table>
		<div class="user_submit" align="center">
				<input type="hidden" name="type" value="1" />
				<input type="submit" class="btn-action" name="name"  value="ȷ���ύ" size="30" /> 
			
		</div>
		</form>
		
		<div class="user_right_foot alert">
		* ��ܰ��ʾ������ֻ����Ź���û�յĻ������еĶ��Ź��ܽ�����ʹ��
		</div>
		<!--�������� ����-->
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