{if $_A.query_type == "new" || $_A.query_type == "edit"}
<div class="module_add">
	{if $magic.request.id==""}
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>���������Ϣ���û�����ID</strong></div>
	

	<div class="module_border">
		<div class="l">�û�ID��</div>
		<div class="c">
			<input type="text" name="user_id"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			<input type="text" name="username"  class="input_border"  size="20" />
		</div>
	</div>
	
	<div class="module_submit" >
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	{else}
	<div class="module_title"><span id="user_info_menu"> <a href="javascript:void(0)" class="current"  tab="1"  >��������</a>  <a href="javascript:void(0)"  tab="2">������ϸ����</a>  <a href="javascript:void(0)" tab="3">��������</a>  <a href="javascript:void(0)" tab="4">��λ����</a>  <a href="javascript:void(0)" tab="5">˽Ӫҵ������</a>   <a href="javascript:void(0)" tab="6">����״��</a>   <a href="javascript:void(0)" tab="7">��ϵ��ʽ</a>    <a href="javascript:void(0)" tab="8">��ż����</a>    <a href="javascript:void(0)" tab="9">��������</a>     <a href="javascript:void(0)" tab="11">������Ϣ</a> </span><strong>����û���Ϣ</strong></div>
	
	<form name="form1" method="post" action=""  enctype="multipart/form-data" >
	<div id="user_info_menu_tab">
		<!--�������� ��ʼ-->
		<div id="user_info_menu_1">
			<div class="module_border">
				<div class="l">�û���</div>
				<div class="c">
					{$_A.userinfo_result.username} (ID:{$_A.userinfo_result.user_id})
				</div>
			</div>
			<div class="module_border">
				<div class="l">��ʵ������</div>
				<div class="c">
					{$_A.userinfo_result.realname} 
				</div>
			</div>
			<div class="module_border">
				<div class="l">���䣺</div>
				<div class="c">
					{$_A.userinfo_result.email} 
				</div>
			</div>
			
			<div class="module_border">
				
				<div class="c">
					������һ�����������ύ
				</div>
			</div>
			
		</div>
		<!--�������� ����-->
		
		<!--�������� ��ʼ-->
		<div id="user_info_menu_2" class="hide">
			
			<div class="module_border">
				<div class="w">����״����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=marry&nid=user_marry&value={$_A.userinfo_result.marry}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�� Ů��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=child&nid=user_child&value={$_A.userinfo_result.child}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ѧ ����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=education&nid=user_education&value={$_A.userinfo_result.education}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�����룺</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=income&nid=user_income&value={$_A.userinfo_result.income}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�� ����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=shebao&nid=user_shebao&value={$_A.userinfo_result.shebao}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�籣���Ժţ�</div>
				<div class="c">
					<input type="text" size="30" name="shebaoid" value="{$_A.userinfo_result.shebaoid}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ס��������</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=housing&nid=user_housing&value={$_A.userinfo_result.housing}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�Ƿ񹺳���</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=car&nid=user_car&value={$_A.userinfo_result.car}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���ڼ�¼��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=late&nid=user_late&value={$_A.userinfo_result.late}"></script>
				</div>
			</div>
		</div>
		<!--�������� ��ʼ-->
		
		<!--�������� ��ʼ-->
		<div id="user_info_menu_3" class="hide">
			
			<div class="module_border">
				<div class="w">������ַ��</div>
				<div class="c">
					<input type="text" size="30" name="house_address" value="{$_A.userinfo_result.house_address}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���������</div>
				<div class="c">
					<input type="text" size="15" name="house_area" value="{$_A.userinfo_result.house_area}"/> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ݣ�</div>
				<div class="c">
					<input type="text" size="15" name="house_year" value="{$_A.userinfo_result.house_year}" onclick="change_picktime()" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">����״����</div>
				<div class="c">
					<input type="text" size="15" name="house_status" value="{$_A.userinfo_result.house_status}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">����Ȩ��1��</div>
				<div class="c">
					<input type="text" size="15" name="house_holder1" value="{$_A.userinfo_result.house_holder1}" /> ��Ȩ�ݶ�<input type="text" size="15" name="house_right1" value="{$_A.userinfo_result.house_right1}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">����Ȩ��2��</div>
				<div class="c">
					<input type="text" size="15" name="house_holder2" value="{$_A.userinfo_result.house_holder2}" /> ��Ȩ�ݶ�<input type="text" size="15" name="house_right2" value="{$_A.userinfo_result.house_right2}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���������ڰ�����, ����д��</div>
				<div class="c">
					�������ޣ�<input type="text" size="10" name="house_loanyear" value="{$_A.userinfo_result.house_loanyear}" />ÿ�¹���<input type="text" size="10" name="house_loanprice" value="{$_A.userinfo_result.house_loanprice}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��Ƿ������</div>
				<div class="c">
					<input type="text" size="15" name="house_balance" value="{$_A.userinfo_result.house_balance}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�������У�</div>
				<div class="c">
					<input type="text" size="15" name="house_bank" value="{$_A.userinfo_result.house_bank}" /> 
				</div>
			</div>
		</div>
		<!--�������� ����-->
		
		<!--��λ���� ��ʼ-->
		<div id="user_info_menu_4" class="hide">
			
			<div class="module_border">
				<div class="w">��˾���ƣ�</div>
				<div class="c">
					<input type="text" size="15" name="company_name" value="{$_A.userinfo_result.company_name}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��˾���ʣ�</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=company_type&nid=user_company_type&value={$_A.userinfo_result.company_type}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��˾��ҵ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=company_industry&nid=user_company_industry&value={$_A.userinfo_result.company_industry}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��������</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=company_jibie&nid=user_company_jibie&value={$_A.userinfo_result.company_jibie}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ְ λ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=company_office&nid=user_company_office&value={$_A.userinfo_result.company_office}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">����ʱ�䣺</div>
				<div class="c">
					<input type="text" size="15" name="company_worktime1" value="{$_A.userinfo_result.company_worktime1}" onclick="change_picktime()" />  �� <input type="text" size="15" name="company_worktime2" value="{$_A.userinfo_result.company_worktime2}" onclick="change_picktime()" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�������ޣ�</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=company_workyear&nid=user_company_workyear&value={$_A.userinfo_result.company_workyear}"></script>
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�����绰��</div>
				<div class="c">
					<input type="text" size="15" name="company_tel" value="{$_A.userinfo_result.company_tel}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��˾��ַ��</div>
				<div class="c">
					<input type="text" size="15" name="company_address" value="{$_A.userinfo_result.company_address}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��˾��վ��</div>
				<div class="c">
					<input type="text" size="15" name="company_weburl" value="{$_A.userinfo_result.company_weburl}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��ע˵����</div>
				<div class="c">
					<textarea  cols="50" rows="6"name="company_reamrk"  >{$_A.userinfo_result.company_reamrk}</textarea>
				</div>
			</div>
		</div>
		<!--��λ���� ����-->
		
		
		<!--˽Ӫҵ������ ��ʼ-->
		<div id="user_info_menu_5" class="hide">
			
			<div class="module_border">
				<div class="w">˽Ӫ��ҵ���ͣ�</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=private_type&nid=user_company_industry&value={$_A.userinfo_result.private_type}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�������ڣ�</div>
				<div class="c">
					<input type="text" size="15" name="private_date" value="{$_A.userinfo_result.private_date}" onclick="change_picktime()"/> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��Ӫ������</div>
				<div class="c">
					<input type="text" size="15" name="private_place" value="{$_A.userinfo_result.private_place}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���</div>
				<div class="c">
					<input type="text" size="15" name="private_rent" value="{$_A.userinfo_result.private_rent}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���ڣ�</div>
				<div class="c">
					<input type="text" size="15" name="private_term" value="{$_A.userinfo_result.private_term}" /> ��
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">˰���ţ�</div>
				<div class="c">
					<input type="text" size="15" name="private_taxid" value="{$_A.userinfo_result.private_commerceid}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���̵ǼǺţ�</div>
				<div class="c">
					<input type="text" size="15" name="private_commerceid" value="{$_A.userinfo_result.private_commerceid}" /> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ȫ��ӯ��/����</div>
				<div class="c">
					<input type="text" size="15" name="private_income" value="{$_A.userinfo_result.private_income}" /> Ԫ����ȣ�
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��Ա������</div>
				<div class="c">
					<input type="text" size="15" name="private_employee" value="{$_A.userinfo_result.private_employee}" /> ��
				</div>
			</div>
		</div>
		<!--˽Ӫҵ������ ����-->
		
		<!--����״�� ��ʼ-->
		<div id="user_info_menu_6" class="hide">
			
			<div class="module_border">
				<div class="w">ÿ���޵�Ѻ�����</div>
				<div class="c">
					<input type="text" size="15" name="finance_repayment" value="{$_A.userinfo_result.finance_repayment}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">���з�����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=finance_property&nid=user_finance_property&value={$_A.userinfo_result.finance_property}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ÿ�·��ݰ��ҽ�</div>
				<div class="c">
					<input type="text" size="15" name="finance_amount" value="{$_A.userinfo_result.finance_amount}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">����������</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=finance_car&nid=user_finance_car&value={$_A.userinfo_result.finance_car}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ÿ���������ҽ�</div>
				<div class="c">
					<input type="text" size="15" name="finance_caramount" value="{$_A.userinfo_result.finance_caramount}" /> Ԫ
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">ÿ�����ÿ������</div>
				<div class="c">
					<input type="text" size="15" name="finance_creditcard" value="{$_A.userinfo_result.finance_creditcard}" /> Ԫ
				</div>
			</div>
		</div>
		<!--����״�� ����-->
		
		<!--��ż���� ��ʼ-->
		<div id="user_info_menu_7" class="hide">
			
			<div class="module_border">
				<div class="w">��ס�ص绰��</div>
				<div class="c">
					<input type="text" size="20" name="tel" value="{$_A.userinfo_result.tel}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�ֻ����룺</div>
				<div class="c">
					<input type="text" size="20" name="phone" value="{$_A.userinfo_result.phone}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��ס����ʡ�У�</div>
				<div class="c">
					<script src="/plugins/index.php?q=area&area={$_A.userinfo_result.area}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">��ס���ʱࣺ</div>
				<div class="c">
					<input type="text" size="20" name="post" value="{$_A.userinfo_result.post}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�־�ס��ַ��</div>
				<div class="c">
					<input type="text" size="20" name="address" value="{$_A.userinfo_result.address}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�ڶ���ϵ��������</div>
				<div class="c">
					<input type="text" size="20" name="linkman1" value="{$_A.userinfo_result.linkman1}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�ڶ���ϵ�˹�ϵ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=relation1&nid=user_relation&value={$_A.userinfo_result.relation1}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�ڶ���ϵ����ϵ�绰��</div>
				<div class="c">
					<input type="text" size="20" name="tel1" value="{$_A.userinfo_result.tel1}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">�ڶ���ϵ����ϵ�ֻ���</div>
				<div class="c">
					<input type="text" size="20" name="phone1" value="{$_A.userinfo_result.phone1}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ��������</div>
				<div class="c">
					<input type="text" size="20" name="linkman2" value="{$_A.userinfo_result.linkman2}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ�˹�ϵ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=relation2&nid=user_relation&value={$_A.userinfo_result.relation2}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ����ϵ�绰��</div>
				<div class="c">
					<input type="text" size="20" name="tel2" value="{$_A.userinfo_result.tel2}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ����ϵ�ֻ���</div>
				<div class="c">
					<input type="text" size="20" name="phone2" value="{$_A.userinfo_result.phone2}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ��������</div>
				<div class="c">
					<input type="text" size="20" name="linkman3" value="{$_A.userinfo_result.linkman3}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ�˹�ϵ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=relation3&nid=user_relation&value={$_A.userinfo_result.relation3}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ����ϵ�绰��</div>
				<div class="c">
					<input type="text" size="20" name="tel3" value="{$_A.userinfo_result.tel3}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������ϵ����ϵ�ֻ���</div>
				<div class="c">
					<input type="text" size="20" name="phone3" value="{$_A.userinfo_result.phone3}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">MSN��</div>
				<div class="c">
					<input type="text" size="20" name="msn" value="{$_A.userinfo_result.msn}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">QQ��</div>
				<div class="c">
					<input type="text" size="20" name="qq" value="{$_A.userinfo_result.qq}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="w">������</div>
				<div class="c">
					<input type="text" size="20" name="wangwang" value="{$_A.userinfo_result.wangwang}" />
				</div>
			</div>
		</div>
		<!--��ż���� ����-->
		
		<!--��ż���� ��ʼ-->
		<div id="user_info_menu_8"  class="hide">
			
			<div class="module_border">
				<div class="l">��ż������</div>
				<div class="c">
					<input type="text" size="20" name="mate_name" value="{$_A.userinfo_result.mate_name}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">ÿ��н��</div>
				<div class="c">
					<input type="text" size="20" name="mate_salary" value="{$_A.userinfo_result.mate_salary}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">�ƶ��绰��</div>
				<div class="c">
					<input type="text" size="20" name="mate_phone" value="{$_A.userinfo_result.mate_phone}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">��λ�绰��</div>
				<div class="c">
					<input type="text" size="20" name="mate_tel" value="{$_A.userinfo_result.mate_tel}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">������λ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=mate_type&nid=user_company_industry&value={$_A.userinfo_result.mate_type}"></script> 
				</div>
			</div>
			
			
			<div class="module_border">
				<div class="l">ְλ��</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=mate_office&nid=user_company_office&value={$_A.userinfo_result.mate_office}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">��λ��ַ��</div>
				<div class="c">
					<input type="text" size="20" name="mate_address" value="{$_A.userinfo_result.mate_address}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">�����룺</div>
				<div class="c">
					<input type="text" size="20" name="mate_income" value="{$_A.userinfo_result.mate_income}" />
				</div>
			</div>
			
		</div>
		<!--��ż���� ����-->
		
		<!--�������� ��ʼ-->
		<div id="user_info_menu_9"  class="hide">
			
			<div class="module_border">
				<div class="l">���ѧ����</div>
				<div class="c">
					<script src="/plugins/index.php?q=linkage&name=education_record&nid=user_education&value={$_A.userinfo_result.education_record}"></script> 
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">���ѧ��ѧУ��</div>
				<div class="c">
					<input type="text" size="20" name="education_school" value="{$_A.userinfo_result.education_school}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">רҵ��</div>
				<div class="c">
					<input type="text" size="20" name="education_study" value="{$_A.userinfo_result.education_study}" />
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">ʱ�䣺</div>
				<div class="c">
					<input type="text" size="20" name="education_time1" value="{$_A.userinfo_result.education_time1}" onclick="change_picktime()" /> �� <input type="text" size="20" name="education_time2" value="{$_A.userinfo_result.education_time2}" onclick="change_picktime()" /> 
				</div>
			</div>
		</div>
		<!--�������� ����-->
		
		<!--�������� ��ʼ-->
		<div id="user_info_menu_10" class="hide">
			
			<div class="module_border">
				<div class="l">����������</div>
				<div class="c">
					<textarea rows="7" cols="50" name="ability">{$_A.userinfo_result.ability}</textarea><br />���������������֯Э�������������� 
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">���˰��ã�</div>
				<div class="c">
					<textarea rows="7" cols="50" name="interest">{$_A.userinfo_result.interest}</textarea><br />��ͻ���Լ��ĸ��ԣ�����̬�Ȼ����˶��Լ������۵ȣ�
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">����˵����</div>
				<div class="c">
					<textarea rows="7" cols="50" name="others">{$_A.userinfo_result.others}</textarea><br />
					
				</div>
			</div>
		</div>
		<!--�������� ����-->
		
		<!--������Ϣ ��ʼ-->
		<div id="user_info_menu_11" class="hide">
			
			<div class="module_border">
				<div class="l">����������</div>
				<div class="c">
					<textarea rows="7" cols="50" name="ability">{$_A.userinfo_result.ability}</textarea><br />���������������֯Э�������������� 
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">���˰��ã�</div>
				<div class="c">
					<textarea rows="7" cols="50" name="interest">{$_A.userinfo_result.interest}</textarea><br />��ͻ���Լ��ĸ��ԣ�����̬�Ȼ����˶��Լ������۵ȣ�
				</div>
			</div>
			
			<div class="module_border">
				<div class="l">����˵����</div>
				<div class="c">
					<textarea rows="7" cols="50" name="others">{$_A.userinfo_result.others}</textarea><br />
				</div>
			</div>
		</div>
		<!--������Ϣ ����-->
	</div>
	<div class="module_submit" >
		<input type="hidden"  name="user_id" value="{$magic.request.id}" />
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
	</form>
	
	
	{/if}
</div>
{literal}
<script>
change_menu_tab("user_info_menu");

function check_form(){
	 var frm = document.forms['form1'];
	 var name = frm.elements['name'].value;
	 var content = frm.elements['content'].value;
	 var errorMsg = '';
	  if (name.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type == "view"}
<div class="module_add">
	
	<form name="form1" method="post" action="" onsubmit="return check_form();" enctype="multipart/form-data" >
	<div class="module_title"><strong>֤���鿴</strong></div>

	<div class="module_border">
		<div class="l">�û�����</div>
		<div class="c">
			{ $_A.attestation_result.username}
		</div>
	</div>


	<div class="module_border">
		<div class="l">������Ŀ��</div>
		<div class="c">
			{ $_A.attestation_result.type_name }
		</div>
	</div>


	<div class="module_border">
		<div class="l">֤��ͼƬ��</div>
		<div class="c">
			<a href="{ $_A.attestation_result.litpic|imgurl_format }" ><img src="{ $_A.attestation_result.litpic|imgurl_format }" width="100" height="100" /></a>
		</div>
	</div>
	
	<div class="module_border">
		<div class="l">���:</div>
		<div class="c">
			{ $_A.attestation_result.content}</div>
	</div>

	<div class="module_border">
		<div class="l">���ʱ��/IP:</div>
		<div class="c">
			{ $_A.attestation_result.addtime|date_format:'Y-m-d H:i:s'}/{ $_A.attestation_result.addip}</div>
	</div>
	
	
	<div class="module_title"><strong>��˴�֤��</strong></div>
	
	<div class="module_border">
		<div class="l">״̬:</div>
		<div class="c">
		<input type="radio" name="status" value="0" {if $_A.attestation_result.status==0} checked="checked"{/if} />�ȴ����  <input type="radio" name="status" value="1" {if $_A.attestation_result.status==1} checked="checked"{/if}/>���ͨ�� <input type="radio" name="status" value="2" {if $_A.attestation_result.status==2} checked="checked"{/if}/>��˲�ͨ�� </div>
	</div>
	
	<div class="module_border" >
		<div class="l">ͨ����Ӧ�Ļ���:</div>
		<div class="c">
			<input type="text" name="jifen" value="{ $_A.attestation_result.jifen}" size="5">
		</div>
	</div>
	
	<div class="module_border" >
		<div class="l">��˱�ע:</div>
		<div class="c">
			<textarea name="verify_remark" cols="45" rows="5">{ $_A.attestation_result.verify_remark}</textarea>
		</div>
	</div>

	<div class="module_submit" >
		<input type="hidden" name="id" value="{ $_A.attestation_result.id }" />
		
		<input type="submit"  name="reset" value="��˴�֤��" />
	</div>
	</form>
</div>
{literal}
<script>
function check_form(){
	 var frm = document.forms['form1'];
	 var verify_remark = frm.elements['verify_remark'].value;
	 var errorMsg = '';
	  if (verify_remark.length == 0 ) {
		errorMsg += '��ע������д' + '\n';
	  }
	  
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
}

</script>
{/literal}
{elseif $_A.query_type=="list"}
<table  border="0"  cellspacing="1" bgcolor="#CCCCCC" width="100%">
	  <form action="" method="post">
		<tr >
			<td width="*" class="main_td">�û�����</td>
			<td width="*" class="main_td">��ʵ����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">��λ����</td>
			<td width="" class="main_td">˽Ӫҵ������</td>
			<td width="" class="main_td">����״��</td>
			<td width="" class="main_td">��ϵ��ʽ</td>
			<td width="" class="main_td">��ż����</td>
			<td width="" class="main_td">��������</td>
			<td width="" class="main_td">������Ϣ</td>
			<td width="" class="main_td">����</td>
		</tr>
		{ foreach  from=$_A.userinfo_list key=key item=item}
		<tr  {if $key%2==1} class="tr2"{/if}>
			<td class="main_td1" align="center">{$item.username}</td>
			<td class="main_td1" align="center">{$item.realname}</td>
			<td class="main_td1" align="center" >{if $item.building_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.company_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.firm_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.finance_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.contact_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.mate_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.edu_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			<td class="main_td1" align="center" >{if $item.job_status==1}��Ϣ����{else}��Ϣ������{/if}</td>
			
			<td class="main_td1" align="center" ><a href="{$_A.query_url}/new&id={$item.user_id}{$_A.site_url}">�޸�</a> </td>
		</tr>
		{ /foreach}
		<tr>
		<td colspan="15" class="action">
		<div class="floatl">
		
		</div>
		<div class="floatr">
			�û�����<input type="text" name="username" id="username" value="{$magic.request.username}"/> ״̬<select id="status" ><option value="">ȫ��</option><option value="1" {if $magic.request.status==1} selected="selected"{/if}>��ͨ��</option><option value="0" {if $magic.request.status=="0"} selected="selected"{/if}>δͨ��</option></select> <input type="button" value="����" / onclick="sousuo()">
		</div>
		</td>
	</tr>
		<tr>
			<td colspan="9" class="page">
			{$_A.showpage} 
			</td>
		</tr>
	</form>	
</table>
<script>
var url = '{$_A.query_url}';
{literal}
function sousuo(){
	var sou = "";
	var username = $("#username").val();
	if (username!=""){
		sou += "&username="+username;
	}
	var status = $("#status").val();
	if (status!=""){
		sou += "&status="+status;
	}
	if (sou!=""){
	location.href=url+sou;
	}
}
</script>
{/literal}


{/if}