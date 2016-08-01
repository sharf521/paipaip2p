<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>{$_A.list_name|default:"管理中心"}_{$_G.system.con_webname}管理后台</title>
<link href="{$tpldir}/admin.css" rel="stylesheet" type="text/css" />
<link href="{$tpldir}/css/tipswindown.css" rel="stylesheet" type="text/css" />
<script src="{$tpldir}/js/jquery.js" type="text/javascript"></script>
<script src="{$tpldir}/js/tipswindown.js" type="text/javascript"></script>
<script src="plugins/timepicker/WdatePicker.js" type="text/javascript"></script>
<script src="{$tpldir}/js/base.js" type="text/javascript"></script>
</head>

<body>
<div class="main top">
	<div class="logo ">
	<b style="line-height:82px; font-size:26px; color:#fff; text-shadow:1px 1px #333; padding-left:18px; font-family:'微软雅黑'">{$_G.sitename}业务系统管理后台</b></div>
	<div class="banner">
		<div class="banner_top">
			<span>
			 <a href="{$_A.admin_url}">后台首页</a> | 您好，<font color="#FF0000">{$_G.user_result.realname}</font> [{$_G.user_result.typename}] &nbsp; &nbsp;
			<a href="{$_A.admin_url}&q=logout">退出</a>
		 </span>  <a href="/" target="_blank">查看网站首页</a></div>
 

	</div>
	<div class="banner_position">
 
		<ul class="aNavContent">
			{if $_A.pur_header.borrow_list==1}<li class=""><a href="{$_A.admin_url}&q=module/borrow&site_id=8&a=borrow">贷款管理</a></li>{/if}
			{if $_A.pur_header.attestation_list==1}<li class=""><a href="{$_A.admin_url}&q=module/attestation/all&site_id=26&a=attestation">认证管理</a></li>{/if} 
			{if $_A.pur_header.account_list==1}<li class=""><a href="{$_A.admin_url}&q=module/account/list&a=cash">资金管理</a></li>{/if} 
			{if $_A.pur_header.userinfo_list==1}<li class=""><a href="{$_A.admin_url}&q=module/userinfo&site_id=46&a=userinfo">客户管理</a></li>{/if} 
			{if $_A.pur_header.article_list==1}<li class=""><a href="{$_A.admin_url}&q=content&a=content">内容管理</a></li>{/if} 
			{if $_A.pur_header.site_all==1}<li class=""><a href="{$_A.admin_url}&q=site/loop&a=loop">栏目管理</a></li>{/if} 
            {if $_A.pur_header.module_all==1}<li class=""><a href="{$_A.admin_url}&q=module">模块管理</a></li>{/if}
			{if $_A.pur_header.system_all==1}<li class=""><a href="{$_A.admin_url}&q=system">系统设置</a></li>{/if} 
 
		</ul>
	</div>
</div><br />

<div class="main">
	<div class="main_left">
		{if $magic.request.a=="control" || $_A.query_class == "control"}
			{include file="admin_control_menu.html"}
		{elseif $magic.request.a=="loop" || $_A.query_class == "loop"}
			{include file="admin_loop_menu.html"}
		{elseif $magic.request.a == "site"  || $_A.query_class == "site"}
			{include file="admin_site_menu.html"}
		{elseif $magic.request.a == "borrow"  || $_A.query_class == "borrow"}
			{include file="admin_borrow_menu.html"}
		{elseif $magic.request.a == "cash"  || $_A.query_class == "cash"}
			{include file="admin_cash_menu.html"}
		{elseif $magic.request.a == "userinfo"  || $_A.query_class == "userinfo"}
			{include file="admin_userinfo_menu.html"}
		{elseif $magic.request.a == "attestation"  || $_A.query_class == "attestation"}
			{include file="admin_attestation_menu.html"}
		{elseif $magic.request.a == "content"  || $_A.query_class == "content"}
			{include file="admin_content_menu.html"}
		{elseif $magic.request.a=="system" || $_A.query_sort == "system"}
			{include file="admin_system_menu.html"}
		{elseif $magic.request.a == "module" || $_A.query_sort == "module"}
			{include file="admin_system_menu.html"}
			
		{else}
			{include file="admin_site_menu.html"}
		
		{/if}
	</div>
	<div class="main_right">
 
		<div class="main_site">
			<ul>
				
				<li class="site_sub">{$_A.list_menu}</li>
				<li class="title">{$_A.list_name} <span>/ {if $_A.site_result.name!=""}{$_A.site_result.name}{else}{$_A.list_title} {/if}</span></li>
				
			</ul>
		</div>
		<div class="main_content">
			
		 