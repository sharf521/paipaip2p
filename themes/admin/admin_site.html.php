<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
{include file="admin_head.html.php"}

<!--��Ŀ�����б���Թ�����б���ʼ-->
{if $_A.query_class == "loop" }
 <table  border="0"  cellspacing="1" bgcolor="#CCCCCC"  width="100%">
	  <form action="{$_A.admin_url}&q=site/order" method="post" name="form1">
		<tr >
			<td width="" class="main_td" >ȫѡ</td>						
			<td width="" class="main_td" >ID</td>
			<td width="*" class="main_td">��Ŀ����</td>
			<th width="" class="main_td">ʶ��ID</th>
			<th width="" class="main_td">����Ȩ��</th>
			<th width="" class="main_td">����ģ��</th>
			<th width="" class="main_td">����</th>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_G.site_list  item=item }
		<tr  id="id_{$item.pid}_{$item.site_id}" {if $key%2==0}class="tr2"{/if}>
			<td class="main_td1" align="center" width="40">
			{if $item.ppid==1}
			<a href="javascript:void(0);" onclick="change_tr('{ $item.site_id}','{ $item.pid}');"><img src="{$tpldir}/images/ico_open.gif" align="absmiddle" border="0" id="imgopen_{$item.site_id}"  /><img src="{$tpldir}/images/ico_close.gif" align="absmiddle" border="0" id="imgclose_{$item.site_id}"  style="display:none" /></a> 
			{else}
			<img src="{$tpldir}/images/ico_no.gif" />
			{/if}
			<input type="hidden" value="{$item.ppid}" id="ppd_{$item.site_id}" />
			</td>
			<td class="main_td1" align="center" >{ $item.site_id}</td>
			<td class="main_td1" align="left" >{$item.aname}</td>
			<td class="main_td1" align="center">{$item.nid}</td>
			<td class="main_td1" align="center">
			
			{html_checkboxes options="$_A.admin_type_check" name="rank" kname = "$key" checked="$item.rank"}</td>
			<td class="main_td1" align="center" >{$item.module_name}{if $item.code == 'article'} | <a href="{$_A.admin_url}&q=module/article&site_id={$item.site_id}&a=content">���¹���</a>{/if}</td>
			<td class="main_td1" align="center" ><input type="text" name="order[{$key}]" value="{$item.order}" size="3" /><input type="hidden" name="site_id[{$key}]" value="{$item.site_id}" /></td>
			<td class="main_td1" align="center" >
			<!--	<a href="{$_A.admin_url}&q=site/view&site_id={$item.site_id}" target="_blank">Ԥ��</a> -->
			<a href="{$_A.admin_url}&q=site/{$item.code}&site_id={$item.site_id}{$site_url}">����</a> <a href="{$_A.admin_url}&q=site/new&pid={$item.site_id}{$site_url}">���</a> <a href="{$_A.admin_url}&q=site/edit&site_id={$item.site_id}{$site_url}">�޸�</a> <a href="{$_A.admin_url}&q=site/move&site_id={$item.site_id}{$site_url}">�ƶ�</a> <a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.admin_url}&q=site/del&site_id={$item.site_id}{$site_url}'">ɾ��</a></td>
		</tr>
		{ /foreach}
	<tr>
	<td colspan="8" class="submit" >
	<input type="submit" value="�޸�����" /> 
	</td>
</tr>		
</table>
<!--��Ŀ�����б����Թ�����б�����-->
		
			
<!--��Ŀ�����б������˶����Բ鿴����ʼ-->
{elseif $_A.query_class == "list" }
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC"  width="100%">
	<tr >					
		<td width="" class="main_td" >ID</td>
		<td width="" class="main_td">��Ŀ����</td>
		<td width="" class="main_td">���¹���</td>
		<th width="" class="main_td">ʶ��ID</th>
		<th width="" class="main_td">����ģ��</th>
		<th width="" class="main_td">����</th>
	</tr>
	{ foreach  from=$_G.site_list  item=item}
	{if $item.code == 'article'}
	<tr  id="id_{$item.pid}_{$item.site_id}" {if $key%2==0}class="tr2"{/if}>
		
		<td class="main_td1" align="center" >{ $item.site_id}</td>
		<td class="main_td1" align="left" >{$item.aname}</td>
		<td class="main_td1" align="center" ><a href="{$_A.admin_url}&q=module/article&site_id={$item.site_id}&a=content">�����б�</a> | <a href="{$_A.admin_url}&q=module/article/new&site_id={$item.site_id}&a=content">�������</a></td>
		<td class="main_td1" align="center">{$item.nid}</td>
		<td class="main_td1" align="center" >{$item.module_name}</td>
		<td class="main_td1" align="center" >{$item.order}</td>
	
	</tr>
	{/if}
	{ /foreach}	
</table>
<!--��Ŀ�����б������˶����Բ鿴������-->
			
<!--��Ӻ��޸���Ŀ ��ʼ-->
{elseif $_A.query_class == "new" || $_A.query_class == "edit"}
	<div class="module_add">
	
	<form action="" method="post" name="form1" onsubmit="return check_form()" enctype="multipart/form-data">
	<div class="module_title"><span>{if $_A.query_class=="edit"}<a href="{$_A.query_url}&q=site/new&pid={$_A.site_result.site_id}&a=loop">�������Ŀ</a>&nbsp;{/if}</span><strong>{ if $_A.query_class == "edit" }�༭{else}���{/if}��Ŀ</strong></div>
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<strong>{ $_A.site_presult.name|default:$_A.site_result.pname|default:'��Ŀ¼'}
				<input type="hidden" name="pid" value="{$_A.site_presult.site_id|default:$_A.site_result.pid|default:0}" /></strong>
		</div>
	</div>
	
	 <div class="module_border">
		<div class="l">��Ŀ���� ��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="name" value="{$_A.site_result.name}" /> <input type="checkbox" name="isurl" value="1" onclick="jump_url()"  { if $result.isurl=="1"} checked="checked"{ /if}/>��תҳ
		</div>
	</div>
	
	<div class="module_border" style="display:{ if $result.isurl!="1"}none{ /if}" id="jump_url">
		<div class="l">��ת��ַ��</div>
		<div class="c">
			<input type="text" name="url"  class="input_border" value="{$_A.site_result.url}" size="30" />
		</div>
	</div>
	
	
	<div class="module_border" >
		<div class="l">�Զ������ӣ�</div>
		<div class="c">
			<input type="text" name="aurl"  class="input_border" value="{$_A.site_result.aurl}" size="30" />�˴ο�����Ϊ��վ��Ŀ���Զ������ӹ������署ʦ����ֱ������site/peixun/teacher 
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">ʶ��ID(nid)��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="nid"  onkeyup="value=value.replace(/[^a-zA-Z_0-9]/g,'')" value="{$_A.site_result.nid}"/>ֻ��Ϊ ��ĸ���»��ߣ�_��
				
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״&nbsp;&nbsp;&nbsp; ̬ ��</div>
		<div class="c">
			<input type="radio" value="0" name="status" { if $_A.site_result.status==0 || $_A.site_result.status==""}checked="checked"{ /if}/>����
			<input type="radio" value="1" name="status" { if $_A.site_result.status==1 || $_A.site_result.status==""}checked="checked"{ /if} />��ʾ
		</div>
	</div>
	
	
	<div class="module_border" >
		<div class="l">��Ŀ���ͣ�</div>
		<div class="c">
			<input type="radio" value="0" name="style" { if $_A.site_result.style==0 ||$_A.site_result.style==""}checked="checked"{ /if}/>�б�
			<input type="radio" value="1" name="style" { if $_A.site_result.style==1}checked="checked"{ /if}/>��ҳ����
		</div>
	</div>
	
				<!--
			   <div class="module_border">
		<div class="l">����Ȩ�ޣ�</div>
		<div class="c">
			
				{ if $config.type=='edit'}
					{ $pur}
				{ else}
				{ foreach from=$rank key =key item=item}
				<input type="checkbox" value="{ $item.rank}" name="rank[}">{ $item.name} 
				 { /foreach}
				 { /if}
		
				����ѡ���ʾ�����ƣ�
		</div>
	</div>
	
	
			  -->
	 <div class="module_border">
		<div class="l">����˳��</div>
		<div class="c">
				<input type="text" align="absmiddle" name="order"  onkeyup="value=value.replace(/[^0-9]/g,'')" size="5" value="{$_A.site_result.order|default:10}"/>
		</div>
	</div>
	
	 <div class="module_border">
		<div class="l">����ģ�飺</div>
		<div class="c">
				{ if $_A.query_class == "edit"}
					{$_A.site_result.module_name}
				<input type="hidden" name="code" value="{$_A.site_result.code}" />
				{ else}
				<select name="code" id="code" >
				<option value="" >��ѡ��ģ��</option>
				{foreach from="$_A.module_list" item="item"}
				<option value="{$item.code}" >{$item.name}</option>
				{/foreach}
				</select>
				{ /if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ģ�壺</div>
		<div class="c">
			<input name="index_tpl" type="text"  style="width:300px" value="{$_A.site_result.index_tpl|default:"[code].html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�б�ģ�壺</div>
		<div class="c">
			<input name="list_tpl" type="text"  style="width:300px" value="{$_A.site_result.list_tpl|default:"[code]_list.html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">����ģ�壺</div>
		<div class="c">
			<input name="content_tpl" type="text"  style="width:300px" value="{$_A.site_result.content_tpl|default:"[code]_content.html"}" />
		</div>
	</div>
			  
	{ if $_A.query_class=="edit"}
	<div class="module_border">
		<div class="l">ģ���޸ģ�</div>
		<div class="c">
			 <input type="checkbox" value="1" name="update_all" />������Ŀһ���޸� <input type="checkbox" value="1" name="update_brother" />ͬ����Ŀһ���޸�
		</div>
	</div>
	 {/if}
	 
	<div class="module_border">
		<div class="l">�б���������</div>
		<div class="c">
			<input name="list_name" type="text"  style="width:300px" value="{$_A.site_result.list_name|default:"index_[page].html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">������������</div>
		<div class="c">
			<input name="content_name" type="text"  style="width:300px" value="{$_A.site_result.content_name|default:"[id].html"}" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ļ�����Ŀ¼��</div>
		<div class="c">
			<input name="sitedir" type="text"  style="width:300px" value="{$_A.site_result.sitedir|default:"[nid]"}" />
		</div>
	</div>
	<div class="module_border">
		<div class="l">����Ȩ�ޣ�</div>
		<div class="c">
			{html_checkboxes options="$_A.admin_type_check" name="rank" checked="$_A.site_result.rank"} 
		</div>
	</div>
	{ if $_A.query_class=="new"}
	<div class="module_border">
		<div class="l">Ŀ¼���λ�ã�</div>
		<div class="c">
			<input name="referpath" type="radio" value="parent" checked="chekced" />
              �ϼ�Ŀ¼
                            <input name="referpath" type="radio" value="cmspath" />
              CMS��Ŀ¼
		</div>
	</div>
	{/if}
	
	<div class="module_border">
		<div class="l">�ļ��������ͣ�</div>
		<div class="c">
			<input type="radio" name="visit_type" value="0" {if $result.visit_type==0 || $result.visit_type==""} checked="checked"{/if}  title="�磺?3/1"/> ��̬���� <input type="radio" name="visit_type" value="1" {if $result.visit_type==1} checked="checked"{/if} title="�磺?article/dongtai/1.html"/> ����html���� ����ע�����ϵͳ����α��̬Ϊ�ǣ���α��̬������
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">title������</div>
		<div class="c">
			<textarea name="title" cols="40" rows="3" id="title">{$_A.site_result.title}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ؼ��֣�</div>
		<div class="c">
			<textarea name="keywords" cols="40" rows="3" id="keywords">{$_A.site_result.keywords}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ŀ������</div>
		<div class="c">
			 <textarea name="description" cols="40" rows="3" id="textarea2">{$_A.site_result.description}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ĿͼƬ��</div>
		<div class="c">
			 <input type="file" name="litpic" size="30" class="input_border"/>{if $_A.site_result.litpic!=""}<a href="./{$_A.site_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a>{/if}
		</div>
	</div>	
	<div class="module_border">
		<div class="l">��Ŀ���ݣ�</div>
		<div class="c">            
            <script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.config.js"></script>
			<script type="text/javascript" charset="gbk" src="/plugins/ueditor/ueditor.all.min.js"> </script>
            <script type="text/javascript" charset="gbk" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
            <script id="content" name="content" type="text/plain" style="width:800px; height:400px;">{$_A.site_result.content}</script>
            {literal}
            <script type="text/javascript">	
                var ue = UE.getEditor('content',{
                    serverUrl:"/plugins/ueditor/php/controller.php?type=admin"
                })
            </script>
            {/literal}
            
		</div>
	</div>
	
	<div class="module_submit">
		{ if $_A.query_class == "edit" }<input type="hidden" value="{$magic.request.site_id}"  name="site_id" />{/if}
		<input type="submit" value=" �� �� "  name="submit_ok" />&nbsp;&nbsp;
		<input name="reset" type="reset"  value=" �� �� " />
	</div>
			</form>
 </div>
  <script>
//editor add by weego 20120615 for ��ҳ�༭��
	var url = "{$_A.admin_url}&q=site";
	
	{literal}  
	$(function() {
		$("#code").change(function() {
			$.ajax({
			  url: url+"/module&code="+this.value,
			  cache: false,
			  success: function(html){
				var aa = html.split(",");
				$("input[name='index_tpl']").attr("value",aa[0]);
				$("input[name='list_tpl']").attr("value",aa[1]);
				$("input[name='content_tpl']").attr("value",aa[2]);
			  }
			}); 

		})
		;
	});
	</script>
  {/literal}
  
 <!--��Ӻ��޸���Ŀ ����--> 
  	
	
<!--�༭��Ŀ ��ʼ-->
{elseif $_A.query_class == "update"}
	<div class="module_add">
	
	<form action="" method="post" name="form1" onsubmit="return check_form()" enctype="multipart/form-data">
	<div class="module_title"><strong>�༭��Ŀ</strong></div>
	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			<strong>{ $_A.site_presult.name|default:$_A.site_result.pname|default:'��Ŀ¼'}
				<input type="hidden" name="pid" value="{$_A.site_presult.site_id|default:$_A.site_result.pid|default:0}" /></strong>
		</div>
	</div>
	
	 <div class="module_border">
		<div class="l">��Ŀ���� ��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="name" value="{$_A.site_result.name}" />
		</div>
	
	</div>
	
	
	<div class="module_border">
		<div class="l">ʶ��ID(nid)��</div>
		<div class="c">
			<input type="text" align="absmiddle" name="nid"  onkeyup="value=value.replace(/[^a-zA-Z_]/g,'')" value="{$_A.site_result.nid}"/>ֻ��Ϊ ��ĸ���»��ߣ�_��
				
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">״&nbsp;&nbsp;&nbsp; ̬ ��</div>
		<div class="c">
			<input type="radio" value="0" name="status" { if $_A.site_result.status==0 || $_A.site_result.status==""}checked="checked"{ /if}/>����
			<input type="radio" value="1" name="status" { if $_A.site_result.status==1 || $_A.site_result.status==""}checked="checked"{ /if} />��ʾ
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��ĿͼƬ��</div>
		<div class="c">
			 <input type="file" name="litpic" size="30" class="input_border"/>{if $_A.site_result.litpic!=""}<a href="./{$_A.site_result.litpic}" target="_blank" title="��ͼƬ"><img src="{ $tpldir }/images/ico_1.jpg" border="0"  /></a><input type="checkbox" name="clearlitpic" value="1" /> ȥ��ͼƬ{/if}
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���ݣ�</div>
		<div class="c">
			{editor name="content" value="$_A.site_result.content"}
		</div>
	</div>
	
	
	<div class="module_border">
		<div class="l">title������</div>
		<div class="c">
			<textarea name="title" cols="40" rows="3" id="title">{$_A.site_result.title}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�ؼ��֣�</div>
		<div class="c">
			<textarea name="keywords" cols="40" rows="3" id="keywords">{$_A.site_result.keywords}</textarea>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">��Ŀ������</div>
		<div class="c">
			 <textarea name="description" cols="40" rows="3" id="textarea2">{$_A.site_result.description}</textarea>
		</div>
	</div>
	<div class="module_submit">
		<input type="hidden" value="{$magic.request.site_id}"  name="site_id" />
		<input type="submit" value=" �� �� "  name="submit_ok" />&nbsp;&nbsp;
		<input name="reset" type="reset"  value=" �� �� " />
	</div>
			</form>
 </div>
 
  
 <!--��Ӻ��޸���Ŀ ����--> 
 
 	
		  {elseif $_A.query_class == "recycle"  }
			 <table  border="0"  width="100%" cellspacing="1"  bgcolor="#CCCCCC" >
				 
					<tr >
						<td  class="main_td" >��ĿID</td>
						<td width="*" class="main_td">��Ŀ����</td>
						<td  class="main_td">ʶ��ID</td>
						<td  class="main_td">����ģ��</td>
						<td class="main_td" width="30%">����</td>
					</tr>
					{ foreach  from=$result key=key item=item}
					<tr {if $key%2==0}class="tr2"{/if}>
						<td class="main_td1" align="center" >{ $item.site_id}</td>
						<td class="main_td1" align="left">{$item.name}</td>
						<td class="main_td1" align="center">{$item.nid}</td>
						<td class="main_td1" align="center">{$item.module_name}</td>
						<td class="main_td1" align="center" >
							<a href="{$_A.admin_url}&q=site/{$item.code}&site_id={$item.site_id}">����</a> 
							<a href="{$_A.admin_url}&q=site/new&pid={$item.site_id}">���</a> 
							<a href="{$_A.admin_url}&q=site/edit&site_id={$item.site_id}" >�޸�</a> 
							<a href="{$_A.admin_url}&q=site/move&site_id={$item.site_id}">�ƶ�</a> 
							<a href="#" onClick="javascript:if(confirm('ȷ��Ҫɾ����?ɾ���󽫲��ɻָ�')) location.href='{$_A.admin_url}&q=site/del&site_id={$item.site_id}'">ɾ��</a>
						</td>
					</tr>
					{ /foreach}
	      </table>
		 
{elseif $_A.query_class=="move"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%" >
	<tr >
		<td align="left" bgcolor="#FFFFFF" class="main_td">&nbsp;&nbsp;�ƶ���Ŀ</td>
	</tr>
<form action="" method="post">
<tr><td bgcolor="#FFFFFF" align="left" class="main_td1">
<input name="site_id" type="hidden" value="{$_A.site_result.site_id}" />
<font color="#FF0000">�ƶ���Ŀ����ɾ��ԭ�������ݡ�</font>
</td></tr>
<tr><td bgcolor="#FFFFFF" align="left" class="main_td1">
<div style="width:170px; overflow:hidden; float:left" align="left">�ƶ�����Ŀ��</div>{$_A.site_result.name}
<br />
<div style="width:170px; overflow:hidden; float:left"align="left">��ѡ��Ҫ�ƶ�������Ŀ�£�</div><select name="pid">
<option value="0">��Ŀ¼</option>
{site lrnore="$magic.request.site_id"}
<option value="{$var.site_id}" {if $result.pid == $var.site_id} selected="selected"{/if} >-{$var.aname}</option>
{ /site}
</select>
</td></tr>
	<tr   >
		<td  bgcolor="#FFFFFF" >
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" �� �� " class="submitstyle" name="submit_ok" />&nbsp;&nbsp;
		<input name="reset" type="reset" class="submitstyle" value=" �� �� " />
		</td>
	</tr>
</table>
</form>
 {/if}
		
{include file="admin_foot.html"}

