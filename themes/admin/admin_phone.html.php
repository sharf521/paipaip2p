<?php
!defined('IN_TEMPLATE') && exit('Access Denied');
?>
<div class="module_add">
			<form action="" method="post"  enctype="multipart/form-data" >
			<div class="module_title"><strong>�ֻ�������״̬</strong></div>
			
			<div class="module_border">
			<div class="d">�û�����</div>
				<div class="c">
						<input type="text" name="phone_uid" value="{$uid}" /> 
				</div>
			</div>
			
		<div class="module_border">
			<div class="d">���룺</div>
			<div class="c">
					<input type="text" name="phone_pass" value="{$pass}" />
			</div>
		</div>
		
		<div class="module_border">
			<div class="d">��ǰʹ��״̬</div>
		</div>
		
		<div class="module_border">
			<div class="c" id="sms_state">������...<script language="javascript" src="http://www.jingpai2010.com/sms/user_p.php?uid={$uid}&pwd={$pass}"></script></div>
		</div>
		
		<div class="module_submit"><input type="submit" value="ȷ���޸�"  /></div>
			</form>
</div>