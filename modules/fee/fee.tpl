
<div class="module_add">
<form name="form1" method="post" action=""  enctype="multipart/form-data">
	<div class="module_title"><strong>���ù���</strong></div>
	
	<div class="module_border">
		<div class="w">�����߳�ֵ�ķ��ã�</div>
		<div class="c">
		��ֵ�ķ���Ϊ <input type="text" value="2" name="" size="10" />%  ���� <input type="text" value="5000" name=""  size="10" />Ԫ����Ϊ<input type="text" value="50" name="50"  size="10" /> Ԫ
		
			</div>
	</div>
	
	<div class="module_border">
		<div class="w">��������ã�</div>
		<div class="c">
		��������¹����Ϊ����<input type="text" value="1" name="" size="5" />% ÿ����һ���¼��չ����<input type="text" value="1" name="" size="5" /> %��
		������ò���Ϣ�����˻����ڽ������ֱ�ӿ۳���
			</div>
	</div>
	
	<div class="module_border">
		<div class="w">VIP��Ա����</div>
		<div class="c">
		���ϻ��ִﵽ <input type="text" value="1" name="" size="5" />�ֿ�������vip��vip�ķ���Ϊ��<input type="text" value="5000" name=""  size="10" />Ԫ/�� ����֤�𰴱���<input type="text" value="1" name="" size="5" />%�����ڸ����˻����û�����ȫ���󣬽ⶳ��֤���ڽ��ɹ��Ժ��ٿ۳������ɹ����շ�
		
			</div>
	</div>
	
	
	<div class="module_border">
		<div class="w">���ƻ�Ա����</div>
		<div class="c">
		���ϻ��ִﵽ <input type="text" value="500" name="" size="5" />�����н���û�ȫ�����ֱ���ﵽ<input type="text" value="300" name="" size="5" />�֣���û�гٻ�������ڻ�����û���ϵͳ�Զ�Ϊ��������Ϊ���ƻ�Ա
		
			</div>
	</div>
	
	
	<div class="module_submit" >
		{ if $_A.query_type == "edit" }<input type="hidden" name="id" value="{ $_A.luqu_result.id }" />{/if}
		<input type="submit"  name="submit" value="ȷ���ύ" />
		<input type="reset"  name="reset" value="���ñ�" />
	</div>
</div>
</form>
{literal}
<script>
function check_form(){
/*
	 var frm = document.forms['form1'];
	 var title = frm.elements['name'].value;
	 var errorMsg = '';
	  if (title.length == 0 ) {
		errorMsg += '���������д' + '\n';
	  }
	  if (errorMsg.length > 0){
		alert(errorMsg); return false;
	  } else{  
		return true;
	  }
	  */
}

</script>
{/literal}
