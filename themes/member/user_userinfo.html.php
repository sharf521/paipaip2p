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
			<ul id="tab" class="list-tab-narrow clearfix">
				<li {if $_U.query_type=="building"} class="cur"{/if}><a href="{$_U.query_url}/building">��������</a></li>
				<li {if $_U.query_type=="company"} class="cur"{/if}><a href="{$_U.query_url}/company">��λ����</a></li>
				<li {if $_U.query_type=="firm"} class="cur"{/if}><a href="{$_U.query_url}/firm">˽Ӫҵ��</a></li>
				<li {if $_U.query_type=="finance"} class="cur"{/if}><a href="{$_U.query_url}/finance">����״��</a></li>
				<li {if $_U.query_type=="contact"} class="cur"{/if}><a href="{$_U.query_url}/contact">��ϵ��ʽ</a></li>
				<li {if $_U.query_type=="mate"} class="cur"{/if}><a href="{$_U.query_url}/mate">��ż����</a></li>
				<li {if $_U.query_type=="edu"} class="cur"{/if}><a href="{$_U.query_url}/edu">��������</a></li>
				<li {if $_U.query_type=="mall"} class="cur"{/if}><a href="{$_U.query_url}/mall">�̳���Ϣ</a></li>
				<li {if $_U.query_type=="job"} class="cur"{/if}><a href="{$_U.query_url}/job">����</a></li>
			</ul>
		</div>
		
		<div class="user_right_main">
		
		<form action="" name="form1" method="post" >
		{if $_U.query_type=="list"}
		<!--�������� ��ʼ-->
			<div class="user_right_border">
				<div class="l">�˻���</div>
				<div class="c">
					{$_G.user_result.email}
				</div>
			</div>
				
			<div class="user_right_border">
				<div class="l">�� �ƣ�</div>
				<div class="c">
					{$_G.user_result.username}
				</div>
			</div>
                
                        <div class="user_right_border">
                                <div class="l">��ʵ������</div>
                                <div class="c">
                                    {if $_G.user_result.real_status==1} 
                                    {$_G.user_result.realname}(����ͨ��ʵ����֤���������޸���ʵ����)
                                    {else}
                                        <input  name="realname" value="{$_G.user_result.realname}" />
                                    {/if}
                                </div>
                        </div>
			
			<div class="user_right_border">
				<div class="l">�� ��</div>
				<div class="c">
					
                                          <input type="radio" name="sex" value="1" {if $_G.user_result.sex==1 || $_G.user_result.sex==""}  checked="checked"  {/if} />��
                                          <input type="radio" name="sex" value="2" {if $_G.user_result.sex==2}  checked="checked"  {/if} />Ů
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�ֻ����룺</div>
				<div class="c">
                                    {if $_G.user_result.phone_status==1} 
                                    {$_G.user_result.realname}(����ͨ���ֻ���֤���������޸��ֻ�����)
                                    {else}
                                       <input type="text" name="phone" value="{if $_G.user_result.phone_status==0 ||  $_G.user_result.phone_status==1}{$_G.user_result.phone}{else}{$_G.user_result.phone_status}{/if}" />  
				    {/if}
                                </div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���᣺</div>
				<div class="c">
                                    {if $_G.user_result.real_status==1} 
                                    {$_G.user_result.area|area}(����ͨ��ʵ����֤���������޸ļ���)
                                    {else}
                                        <script src="/plugins/index.php?q=area&area={$_G.user_result.area}"  type="text/javascript" ></script> <font color="#FF0000">*</font> 
				{/if}
                                </div>
			</div>
                
			<div class="user_right_border">
				<div class="l">����״����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=marry&nid=user_marry&value={$_U.userinfo_result.marry}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�� Ů��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=child&nid=user_child&value={$_U.userinfo_result.child}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">ѧ ����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=education&nid=user_education&value={$_U.userinfo_result.education}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�����룺</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=income&nid=user_income&value={$_U.userinfo_result.income}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�� ����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=shebao&nid=user_shebao&value={$_U.userinfo_result.shebao}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�籣���Ժţ�</div>
				<div class="c">
					<input type="text" size="30" name="shebaoid" value="{$_U.userinfo_result.shebaoid}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">ס��������</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=housing&nid=user_housing&value={$_U.userinfo_result.housing}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�Ƿ񹺳���</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=car&nid=user_car&value={$_U.userinfo_result.car}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���ڼ�¼��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=late&nid=user_late&value={$_U.userinfo_result.late}"></script>
				</div>
			</div>
			
			<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
                        </div>
		<!--�������� ����-->
		<!--�˺ų�ֵ ��ʼ-->
		{elseif $_U.query_type=="building"}
		<div class="alert user_help">����д����˵ķ������������Ϣ</div>
		
		<div class="user_right_border">
				<div class="l">������ַ��</div>
				<div class="c">
					<input type="text" size="30" name="house_address" value="{$_U.userinfo_result.house_address}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���������</div>
				<div class="c">
					<input type="text" size="25" name="house_area" value="{$_U.userinfo_result.house_area}"/> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">������ݣ�</div>
				<div class="c">
					<input type="text" size="25" name="house_year" value="{$_U.userinfo_result.house_year}" onclick="change_picktime()" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">����״����</div>
				<div class="c">
					<input type="text" size="25" name="house_status" value="{$_U.userinfo_result.house_status}" /> Ԫ
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">����Ȩ��1��</div>
				<div class="c">
					<input type="text" size="25" name="house_holder1" value="{$_U.userinfo_result.house_holder1}" /> ��Ȩ�ݶ<input type="text" size="25" name="house_right1" value="{$_U.userinfo_result.house_right1}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">����Ȩ��2��</div>
				<div class="c">
					<input type="text" size="25" name="house_holder2" value="{$_U.userinfo_result.house_holder2}" /> ��Ȩ�ݶ<input type="text" size="25" name="house_right2" value="{$_U.userinfo_result.house_right2}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="e">���������ڰ�����, ����д</div>
				<div class="c">
					�������ޣ�<input type="text" size="10" name="house_loanyear" value="{$_U.userinfo_result.house_loanyear}" />ÿ�¹��<input type="text" size="10" name="house_loanprice" value="{$_U.userinfo_result.house_loanprice}" /> Ԫ
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">��Ƿ������</div>
				<div class="c">
					<input type="text" size="25" name="house_balance" value="{$_U.userinfo_result.house_balance}" /> Ԫ
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">�������У�</div>
				<div class="c">
					<input type="text" size="25" name="house_bank" value="{$_U.userinfo_result.house_bank}" /> 
				</div>
			</div>
		
		{literal}
		<script>
			function change_type(type){
				if (type==2){
					$("#type_net").addClass("dishide");
					$("#type_now").removeClass();
				}else{
					$("#type_now").addClass("dishide");
					$("#type_net").removeClass();
				}
				
			}
		
		</script>
		{/literal}
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--�˺ų�ֵ ����-->
		
		<!--��λ���� ��ʼ-->
		{elseif $_U.query_type=="company"}
		<div class="user_help alert">����д����˵�����ĵ�λ����</div>
		 <form action="" method="post">
		<div class="user_right_border">
			<div class="l">��λ���ƣ�</div>
			<div class="c">
				<input type="text" size="25" name="company_name" value="{$_U.userinfo_result.company_name}" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��λ���ʣ�</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=company_type&nid=user_company_type&value={$_U.userinfo_result.company_type}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��λ��ҵ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=company_industry&nid=user_company_industry&value={$_U.userinfo_result.company_industry}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��������</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=company_jibie&nid=user_company_jibie&value={$_U.userinfo_result.company_jibie}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ְ λ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=company_office&nid=user_company_office&value={$_U.userinfo_result.company_office}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">����ʱ�䣺</div>
			<div class="c">
				<input type="text" size="25" name="company_worktime1" value="{$_U.userinfo_result.company_worktime1}" onclick="change_picktime()" />  �� <input type="text" size="25" name="company_worktime2" value="{$_U.userinfo_result.company_worktime2}" onclick="change_picktime()" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�������ޣ�</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=company_workyear&nid=user_company_workyear&value={$_U.userinfo_result.company_workyear}"></script>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�����绰��</div>
			<div class="c">
				<input type="text" size="25" name="company_tel" value="{$_U.userinfo_result.company_tel}" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��˾��ַ��</div>
			<div class="c">
				<input type="text" size="25" name="company_address" value="{$_U.userinfo_result.company_address}" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��˾��վ��</div>
			<div class="c">
				<input type="text" size="25" name="company_weburl" value="{$_U.userinfo_result.company_weburl}" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��ע˵����</div>
			<div class="c">
				<textarea  cols="50" rows="6"name="company_reamrk"  >{$_U.userinfo_result.company_reamrk}</textarea>
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--��λ���� ����-->
		
		
		
		<!--˽Ӫҵ������  ��ʼ-->
		{elseif $_U.query_type=="firm"}
		<div class="user_help alert">����д������ҵ������</div>
		 <form action="" method="post">
			 <div class="user_right_border">
				<div class="l">˽Ӫ��ҵ���ͣ�</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=private_type&nid=user_company_industry&value="></script> 
				</div>
			</div>
			
			 <div class="user_right_border">
				<div class="l">�������ڣ�</div>
				<div class="c">
					<input type="text" size="25" name="private_date" value="{$_U.userinfo_result.private_date}" onclick="change_picktime()"/> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">��Ӫ������</div>
				<div class="c">
					<input type="text" size="25" name="private_place" value="{$_U.userinfo_result.private_place}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���</div>
				<div class="c">
					<input type="text" size="25" name="private_rent" value="{$_U.userinfo_result.private_rent}" /> Ԫ
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���ڣ�</div>
				<div class="c">
					<input type="text" size="25" name="private_term" value="{$_U.userinfo_result.private_term}" /> ��
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">˰���ţ�</div>
				<div class="c">
					<input type="text" size="25" name="private_taxid" value="{$_U.userinfo_result.private_taxid}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">���̵ǼǺţ�</div>
				<div class="c">
					<input type="text" size="25" name="private_commerceid" value="{$_U.userinfo_result.private_commerceid}" /> 
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">ȫ��ӯ��/����</div>
				<div class="c">
					<input type="text" size="25" name="private_income" value="{$_U.userinfo_result.private_income}" /> Ԫ����ȣ�
				</div>
			</div>
			
			<div class="user_right_border">
				<div class="l">��Ա������</div>
				<div class="c">
					<input type="text" size="25" name="private_employee" value="{$_U.userinfo_result.private_employee}" /> ��
				</div>
			</div>
		 
		 <div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		
		<div class="user_right_foot alert">
		* ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--˽Ӫҵ������  ����-->
		 
		 
		 <!--����״��  ����-->
		 {elseif $_U.query_type=="firm"}
		<div class="user_help alert">����д������ҵ������</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l">ÿ���޵�Ѻ�����</div>
			<div class="c">
				<input type="text" size="15" name="finance_repayment" value="{$_U.userinfo_result.finance_repayment}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">���з�����</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=finance_property&nid=user_finance_property&value={$_U.userinfo_result.finance_property}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ÿ�·��ݰ��ҽ�</div>
			<div class="c">
				<input type="text" size="15" name="finance_amount" value="{$_U.userinfo_result.finance_amount}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">����������</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=finance_car&nid=user_finance_car&value={$_U.userinfo_result.finance_car}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ÿ���������ҽ�</div>
			<div class="c">
				<input type="text" size="15" name="finance_caramount" value="{$_U.userinfo_result.finance_caramount}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ÿ�����ÿ������</div>
			<div class="c">
				<input type="text" size="15" name="finance_creditcard" value="{$_U.userinfo_result.finance_creditcard}" /> Ԫ
			</div>
		</div>
		
		 <div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--����״��  ����-->
		 
		<!--��ϵ��ʽ   ��ʼ-->
		{elseif $_U.query_type=="finance"}
		<div class="user_help alert">����д������״��</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="e">ÿ���޵�Ѻ�����</div>
			<div class="c">
				<input type="text" size="15" name="finance_repayment" value="{$_U.userinfo_result.finance_repayment}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">���з�����</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=finance_property&nid=user_finance_property&value={$_U.userinfo_result.finance_property}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">ÿ�·��ݰ��ҽ�</div>
			<div class="c">
				<input type="text" size="15" name="finance_amount" value="{$_U.userinfo_result.finance_amount}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">����������</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=finance_car&nid=user_finance_car&value={$_U.userinfo_result.finance_car}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">ÿ���������ҽ�</div>
			<div class="c">
				<input type="text" size="15" name="finance_caramount" value="{$_U.userinfo_result.finance_caramount}" /> Ԫ
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="e">ÿ�����ÿ������</div>
			<div class="c">
				<input type="text" size="15" name="finance_creditcard" value="{$_U.userinfo_result.finance_creditcard}" /> Ԫ
			</div>
		</div>
		 <div class="user_right_border">
			<div class="e"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		<!--����״�� ����-->
		
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--��ϵ��ʽ   ����-->
		
		
		<!--��ϵ��ʽ   ��ʼ-->
		{elseif $_U.query_type=="contact"}
		<div class="user_help alert">����д����ϵ��ʽ</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l">��ס�ص绰��</div>
			<div class="c">
				<input type="text" size="25" name="tel" value="{$_U.userinfo_result.tel}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ֻ����룺</div>
			<div class="c">
				<input type="text" size="25" name="phone" value="{$_U.userinfo_result.phone}" />
			</div>
		</div>

		<div class="user_right_border">
			<div class="l">MSN��</div>
			<div class="c">
				<input type="text" size="25" name="msn" value="{$_U.userinfo_result.msn}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">QQ��</div>
			<div class="c">
				<input type="text" size="25" name="qq" value="{$_U.userinfo_result.qq}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������</div>
			<div class="c">
				<input type="text" size="25" name="wangwang" value="{$_U.userinfo_result.wangwang}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��ס����ʡ�У�</div>
			<div class="c">
				<script src="/plugins/index.php?q=area&area={$_U.userinfo_result.area}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��ס���ʱࣺ</div>
			<div class="c">
				<input type="text" size="25" name="post" value="{$_U.userinfo_result.post}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�־�ס��ַ��</div>
			<div class="c">
				<input type="text" size="25" name="address" value="{$_U.userinfo_result.address}" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ڶ���ϵ��������</div>
			<div class="c">
				<input type="text" size="25" name="linkman1" value="{$_U.userinfo_result.linkman1}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ڶ���ϵ�˹�ϵ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=relation1&nid=user_relation&value={$_U.userinfo_result.relation1}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ڶ���ϵ�˵绰��</div>
			<div class="c">
				<input type="text" size="25" name="tel1" value="{$_U.userinfo_result.tel1}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ڶ���ϵ���ֻ���</div>
			<div class="c">
				<input type="text" size="25" name="phone1" value="{$_U.userinfo_result.phone1}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ��������</div>
			<div class="c">
				<input type="text" size="25" name="linkman2" value="{$_U.userinfo_result.linkman2}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ�˹�ϵ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=relation2&nid=user_relation&value={$_U.userinfo_result.relation2}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ�˵绰��</div>
			<div class="c">
				<input type="text" size="25" name="tel2" value="{$_U.userinfo_result.tel2}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ���ֻ���</div>
			<div class="c">
				<input type="text" size="25" name="phone2" value="{$_U.userinfo_result.phone2}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ��������</div>
			<div class="c">
				<input type="text" size="25" name="linkman3" value="{$_U.userinfo_result.linkman3}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ�˹�ϵ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=relation3&nid=user_relation&value={$_U.userinfo_result.relation3}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ�˵绰��</div>
			<div class="c">
				<input type="text" size="25" name="tel3" value="{$_U.userinfo_result.tel3}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������ϵ���ֻ���</div>
			<div class="c">
				<input type="text" size="25" name="phone3" value="{$_U.userinfo_result.phone3}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--��ϵ��ʽ   ����-->
		
		<!--��ż����   ��ʼ-->
		{elseif $_U.query_type=="mate"}
		<div class="user_help alert">����д����ϵ��ʽ</div>
		<form action="" method="post">
		
		<div class="user_right_border">
			<div class="l">��ż������</div>
			<div class="c">
				<input type="text" size="25" name="mate_name" value="{$_U.userinfo_result.mate_name}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ÿ��н��</div>
			<div class="c">
				<input type="text" size="25" name="mate_salary" value="{$_U.userinfo_result.mate_salary}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�ƶ��绰��</div>
			<div class="c">
				<input type="text" size="25" name="mate_phone" value="{$_U.userinfo_result.mate_phone}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��λ�绰��</div>
			<div class="c">
				<input type="text" size="25" name="mate_tel" value="{$_U.userinfo_result.mate_tel}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">������λ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=mate_type&nid=user_company_industry&value={$_U.userinfo_result.mate_type}"></script> 
			</div>
		</div>
		
		
		<div class="user_right_border">
			<div class="l">ְλ��</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=mate_office&nid=user_company_office&value={$_U.userinfo_result.mate_office}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">��λ��ַ��</div>
			<div class="c">
				<input type="text" size="25" name="mate_address" value="{$_U.userinfo_result.mate_address}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">�����룺</div>
			<div class="c">
				<input type="text" size="25" name="mate_income" value="{$_U.userinfo_result.mate_income}" />
			</div>
		</div>
			
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--��ż����   ����-->
		
		
		<!--��������   ��ʼ-->
		{elseif $_U.query_type=="edu"}
		<div class="user_help alert">����д����������</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l">���ѧ����</div>
			<div class="c">
				<script src="/plugins/index.php?q=linkage&name=education_record&nid=user_education&value={$_U.userinfo_result.education_record}"></script> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">���ѧ��ѧУ��</div>
			<div class="c">
				<input type="text" size="25" name="education_school" value="{$_U.userinfo_result.education_school}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">רҵ��</div>
			<div class="c">
				<input type="text" size="25" name="education_study" value="{$_U.userinfo_result.education_study}" />
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">ʱ�䣺</div>
			<div class="c">
				<input type="text" size="25" name="education_time1" value="{$_U.userinfo_result.education_time1}" onclick="change_picktime()" /> 
				�� 
				<input type="text" size="25" name="education_time2" value="{$_U.userinfo_result.education_time2}" onclick="change_picktime()" /> 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		
		<!--��������   ����-->
		
		<!--��������   ��ʼ-->
		{elseif $_U.query_type=="job"}
		<div class="user_help alert">����д����������</div>
		<form action="" method="post">
		<div class="user_right_border">
			<div class="l">����������</div>
			<div class="c">
				<textarea rows="7" cols="50" name="ability">{$_U.userinfo_result.ability}</textarea><br />���������������֯Э�������������� 
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">���˰��ã�</div>
			<div class="c">
				<textarea rows="7" cols="50" name="interest">{$_U.userinfo_result.interest}</textarea><br />��ͻ���Լ��ĸ��ԣ�����̬�Ȼ����˶��Լ������۵ȣ�
			</div>
		</div>
		
		<div class="user_right_border">
			<div class="l">����˵����</div>
			<div class="c">
				<textarea rows="7" cols="50" name="others">{$_U.userinfo_result.others}</textarea><br />
				
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		<!--��������   ����-->
<!--��������   ��ʼ-->
		{elseif $_U.query_type=="mall"}
		<div class="user_help alert">����д�����̳���Ϣ</div>
		<form action="" method="post" enctype="multipart/form-data">
		<div class="user_right_border">
		<script charset="utf-8" src="/plugins/editor/kindeditor/kindeditor-min.js"></script>
		<script charset="utf-8" src="/plugins/editor/kindeditor/lang/zh_CN.js"></script>
			<div class="c">
				<textarea name="mallinfo" id="mallinfo" style="width:700px;height:200px;visibility:hidden;" >
				{$_U.userinfo_result.mallinfo}
				</textarea>
<script>
{literal}
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="mallinfo"]', {
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : true,
					items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link']
				});
			});
			</script>
			{/literal}
			</div>
		</div>
		<div class="user_right_border">
			<div class="l"></div>
			<div class="c">
				<input type="submit" class="btn-action"  name="name"  value="ȷ���ύ" size="30" /> 
			</div>
		</div>
		<div class="user_right_foot alert">
		 * ��ܰ��ʾ�����ǽ������е���Ϣ���б���
		</div>
		<!--��������   ����-->		
		{/if}
		<input type="hidden" name="type" value="1" />
		</form>
	</div>
</div>
</div>
</div>
<!--�û����ĵ�����Ŀ ����-->
<script src="/themes/js/tab.js"></script>
<script src="/themes/js/alert.js"></script>
<script src="/themes/js/transition.js"></script>
{include file="user_footer.html"}