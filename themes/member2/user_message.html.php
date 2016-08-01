<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="user_header.html"}
<link href="{$tempdir}/media/css/modal.css" rel="stylesheet" type="text/css" />
<link href="{$tempdir}/media/css/user_new.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/themes/js/jquery.js"></script>
<script type="text/javascript" src="/themes/js/base.js"></script>

 <div id="main" class="clearfix">
<!--�û����ĵ�����Ŀ ��ʼ-->
<div class="wrap950 mar10">
	<!--��ߵĵ��� ��ʼ-->
	<div class="user_left">
		{include file="user_menu.html"}
	</div>
	<!--��ߵĵ��� ����-->
	
	<!--�ұߵ����� ��ʼ-->
	<div class="user_right">
		<div class="user_right_menu">
			<ul class="list-tab clearfix">
				<li {if $_U.query_type=="list" || $_U.query_type=="view"} class="cur"{/if}><a href="{$_U.query_url}">�ռ���</a></li>
				<li {if $_U.query_type=="sented" || $_U.query_type=="viewed"} class="cur"{/if}><a href="{$_U.query_url}/sented">�ѷ���</a></li>
				<li {if $_U.query_type=="sent"} class="cur"{/if}><a href="{$_U.query_url}/sent">����Ϣ</a></li>
			</ul>
		</div>
		
		
		
		<!--�ռ��� ��ʼ-->
		{if $_U.query_type=="list"}
		<div class="user_main_title1" style="margin-top:5px; margin-bottom:5px" >
		<input style="background:#FFFFCC; color:#CC3300; border:1px solid #FFCC00; width:50px; height:23px;" type="button"  value="ɾ��" onclick="on_submit('{$_G.query_url}/sented',1)" /> 
		<input type="button" style="background:#f3f3f3; border:1px solid #ccc; width:65px; height:23px;"  value="����Ѷ�" onclick="on_submit('{$_G.query_url}/sented',2)"/> 
		<input type="button"  value="���δ��" style="background:#f3f3f3; border:1px solid #ccc; width:65px; height:23px;" onclick="on_submit('{$_G.query_url}/sented',3)"/></div>
		<div class="user_right_main">
			<table  border="0"  cellspacing="0" class="table table-striped  table-condensed">
			<form action="" method="post" id="form1">
				<tr class="head" >
				<td><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/><input type="hidden" name="type" id="type" value="0" /></td>
				<td><div class="icon_xin_no"></div></td>
				<td>������ </td>
				<td>����</td>
				<td>����ʱ�� </td>
				</tr>
				{ foreach  from=$_U.message_list key=key item=item}
                                <tr  {if $key%2==1} class="tr1_1"{/if}>
				<td><input type="checkbox" name="id[{$key}]" value="{$item.id}"/></td>
				<td>{if $item.status==1}<div class="icon_xin_yes"></div>{else}<div class="icon_xin_no"></div>{/if}</td>
				<td>{ $item.sent_username|default:"admin"}</td>
                                <td><a href="{$_U.query_url}/view&id={$item.id}">{if $item.status==0}<strong>{ $item.name}</strong>{else}{ $item.name}{/if}</a></td>
				<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="5" class="page">
						<div class="user_list_page">{$_U.show_page}</div>
					</td>
				</tr>
			</form>	
			</table>
			<!--�ռ��� ����-->
		</div>
		
		<!--������ ��ʼ-->
		{elseif $_U.query_type=="sented"}
		<div class="user_main_title1" style="margin-top:5px; margin-bottom:5px;" ><input type="button" style="background:#FFFFCC; color:#CC3300; border:1px solid #FFCC00; width:50px; height:23px;"  value="ɾ��" onclick="on_submit('{$_G.query_url}/sented',1)" /></div>
		<form action="" method="post" id="form1">
		<div class="user_right_main">
			<table  border="0"  cellspacing="0" class="table table-striped  table-condensed">
				<tr class="head" >
				<td><input type="checkbox" name="allcheck" onclick="checkFormAll(this.form)"/></td>
				<td>�ռ��� </td>
				<td>����</td>
				<td>����ʱ�� </td>
				</tr>
				{ foreach  from=$_U.message_list key=key item=item}
				<tr  {if $key%2==1} class="tr1"{/if}>
				<td><input type="checkbox" name="id[{$key}]" value="{$item.id}"/></td>
				<td>{ $item.receive_username|default:"admin"}</td>
				<td><a href="{$_U.query_url}/viewed&id={$item.id}">{ $item.name}</a></td>
				<td>{ $item.addtime|date_format:"Y-m-d H:i"}</td>
				</tr>
				{ /foreach}
				<tr >
					<td colspan="5" class="page">
						<div class="user_list_page">{$_U.show_page}</div>
					</td>
				</tr>
				<input type="hidden" name="type" id="type" value="0" />
			</form>	
			</table>
			<!--������ ����-->
		</div>
		<!--������ ��ʼ-->
		{elseif $_U.query_type=="sent"}
		<form method="post" action="" >
		<div class="user_right_border">
			<div class="l">�����ˣ�</div>
			<div class="c">
				{$_G.user_result.username}<!-- ({$_G.user_result.realname})-->
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">�ռ��ˣ�</div>
			<div class="c">
				<input type="text" name="receive_user" value="{$magic.request.receive}" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���⣺</div>
			<div class="c">
				<input type="text" name="name"  />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���ݣ�</div>
			<div class="c">
				<textarea name="content" rows="7" cols="50"></textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input name="sented" type="checkbox" value="1" />���浽������
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action"   value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����Ҫ�͹���Ա������Ϣ�������뷢����admin
		</div>
                
		{elseif $_U.query_type=="forward"}
		<form method="post" action="" >
		<div class="user_right_border">
			<div class="l">�����ˣ�</div>
			<div class="c">
				{$_G.user_result.username}<!-- ({$_G.user_result.realname})-->
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">�ռ��ˣ�</div>
			<div class="c">
				<input type="text" name="receive_user" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���⣺</div>
			<div class="c">
                            <input type="text" name="name" value="[ת��]:{$_U.message_result.name}" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���ݣ�</div>
			<div class="c">
				<textarea name="content" rows="7" cols="50">{$_U.message_result.content}[������ԭ��������]</textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input name="sented" type="checkbox" value="1" />���浽������
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
                            <input type="hidden" name="id" value="{$_U.message_result.id}" />
				<input type="submit"  class="btn-action"   value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����Ҫ�͹���Ա������Ϣ�������뷢����admin
		</div>
{elseif $_U.query_type=="jubao"}
		<form method="post" action="" >
		<div class="user_right_border">
			<div class="l">�����ˣ�</div>
			<div class="c">
				{$_G.user_result.username} <!--({$_G.user_result.realname})-->
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">�ռ��ˣ�</div>
			<div class="c">
				<input type="text" name="receive_user" value="admin" disabled />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���⣺</div>
			<div class="c">
                            <input type="text" name="name" value="[�ٱ�]:{$_U.message_result.name}" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l">���ݣ�</div>
			<div class="c">
				<textarea name="content" rows="7" cols="50">{$_U.message_result.content}[������ԭ��������]</textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��֤�룺</div>
			<div class="c">
				<input name="valicode" type="text" size="11" maxlength="4"  tabindex="3"/>&nbsp;<img src="/plugins/index.php?q=imgcode" alt="���ˢ��" onClick="this.src='/plugins/index.php?q=imgcode&t=' + Math.random();" align="absmiddle" style="cursor:pointer" />
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input name="sented" type="checkbox" value="1" />���浽������
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
                            <input type="hidden" name="id" value="{$_U.message_result.id}" />
				<input type="submit"  class="btn-action"   value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		</form>
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����Ҫ�͹���Ա������Ϣ�������뷢����admin
		</div>
		<!--�鿴 ��ʼ-->
		{elseif $_U.query_type=="view"}
		<div class="user_main_title1" >
                    <input type="button" onclick="javascript:location.href='{$_U.query_url}'" value="<<����" /> 
                    <input type="button" value="ת��" onclick="javascript:location.href='{$_U.query_url}/forward&id={$_U.message_result.id}'"/>
                    <input type="button" value="ɾ��" onclick="javascript:location.href='{$_U.query_url}/del&id={$_U.message_result.id}'"/>
                    <input type="button" value="�ٱ�" onclick="javascript:location.href='{$_U.query_url}/jubao&id={$_U.message_result.id}'"/>
               
                </div>
		<form method="post" action="" >
		<div class="user_right_border"style=" background-color:#FCF4EA ">
			<div class="l"></div>
			<div class="c" style=" color: red">
				<strong>{$_U.message_result.name}</strong>
			</div>
		</div>
		
		<div class="user_right_border"style=" background-color:#FCF4EA ">
			<div class="l">�����ˣ�</div>
                        <div class="c" style=" color: red">
				{$_U.message_result.sent_username|default:"admin"}
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����ʱ�䣺{$_U.message_result.addtime|date_format:"Y-m-d H:i"}
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="/u/{$_U.message_result.sent_user|default:0}" target="_blank">�鿴��������Ϣ</a>  
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A 
onclick='tipsWindown("��Ϊ����","url:get?/index.php?user&amp;q=code/user/addfriend&amp;username={$_U.message_result.sent_username|default:admin}",400,230,"true","","true","text");' 
href="javascript:void(0)">��Ϊ����</A> </a>
			</div>
		</div>

                    <div class="user_right_border" >
			<div class="l"></div>
			<div class="c">
                            <br>
				{$_U.message_result.content}
                                <br>
                                <br>
                                <br>
			</div>
		</div>
		
		<div class="user_right_border"style=" background-color:#FCF4EA ">
			<div class="l"></div>
			<div class="c">
				<textarea name="content" rows="7" cols="50"></textarea>
                                
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit"  class="btn-action"  value="�ظ�"  />
				<input type="hidden" name="id" value="{$_U.message_result.id}" />
			</div>
		</div>
		</form>
		<!--�鿴 ����-->
		
		<!--�鿴 ��ʼ-->
		{elseif $_U.query_type=="viewed"}
		<div class="user_main_title1" ><input type="button" onclick="javascript:location.href='{$_U.query_url}/sented'" value="����" /> <input type="button" value="ɾ��" onclick="javascript:location.href='{$_U.query_url}/deled&id={$_U.message_result.id}'"/></div>
		<div class="user_right_border">
			<div class="l">���⣺</div>
			<div class="c">
				{$_U.message_result.name}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ռ��ˣ�</div>
			<div class="c">
				{$_U.message_result.receive_username|default:"admin"}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">����ʱ�䣺</div>
			<div class="c">
				{$_U.message_result.addtime|date_format:"Y-m-d H:i"}
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�������ݣ�</div>
			<div class="c">
				{$_U.message_result.content}
			</div>
		</div>
		
		<!--�鿴 ����-->
		
		{/if}
	</div>
</div>
<!--�û����ĵ�����Ŀ ����-->
</div>
<script type="text/javascript" src="/themes/js/tipswindown.js"></script>
<link href="{$tempdir}/media/css/tipswindown.css" rel="stylesheet" type="text/css" />
{include file="user_footer.html"}