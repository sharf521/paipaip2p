
<? 
	
	session_cache_limiter('no-cache');
	
	if ($_U['query_type'] == "list"){
		$result =  applyClass::GetApplyList(array("id"=>$_REQUEST['id'],"code"=>$_U['query_class'],"limit"=>"all"));
		$display ='';
		if($result !=false){
			foreach ($result as $key => $value){
				$avatar = get_avatar(array("user_id"=>$value['user_id'],"size"=>"small"));
				$display .='<li><div ><a href="" target=_blank><img src="'.$avatar.'" width=48 height=48 class="picborder" /></a></div><a href="">'.$value['realname'].'</a></li>';
			}
		}
		echo "document.write('$display')";
		exit;
	
	}

	elseif ($_U['query_type']=="apply"){
		$result = applyClass::Check(array("code"=>$_U['query_class'],"id"=>$_REQUEST['id'],"user_id"=>$_G['user_id']));
		if ($result!==true){
			echo "<br><br><strong>�ܱ�Ǹ��֪ͨ����</strong>";
			echo "<br><br><br>{$result}<br><br><br>";
			echo "<input type='button' value='�ر�' onclick='closeW();'>";
			exit;
		}else{
	
		?>
		
		
		<div style="background-color:#FCF7CB; border-bottom:1px solid #FFCC33; text-align:center; line-height:30px; font-size:13px; overflow:hidden;margin:0 10px;">����ʵ��д���µ�����</div>
		<form action="/index.php?user&q=apply/<? echo $_U['query_class']?>/add" method="post" onsubmit="return Apply('<? echo $_U['query_class']?>')" >
		<div style="text-align:left; margin:0 10px; overflow:hidden" id="apply_div">
			<div style="line-height:30px; "><strong>������</strong><? echo $_G['user_result']['realname']?><input type="hidden" name="realname" value="<? echo $_G['user_result']['realname']?>" /></div>
			<div style="line-height:30px; padding-top:5px;"><strong>�ֻ���</strong><input type="text" name="phone" id="20" value="<? echo  $_G['user_result']['phone']?>" /></div>
			<div style="line-height:30px;padding-top:10px;"><strong>���䣺</strong><input type="text" name="email" id="email" value="<? echo $_G['user_result']['email']?>" /></div>
			<div style="line-height:30px;padding-top:10px;"><strong>Q Q��</strong><input type="text" name="qq" id="qq" value="<? echo $_G['user_result']['qq']?>"></div>
			<div style="line-height:30px;padding-top:10px; text-align:center"><input type="submit" value="ȷ������" /></div>
			<input type="hidden" name="id" value="<? echo $_REQUEST['id'];?>" />
		</div>
		</form>
		
		<?
		exit;
		}

	}
	
	elseif ($_U['query_type']=="add"){
		
		if(!isset($_POST['id'])){
			$msg = array("���Ĳ�������");
		}else{
			$result = applyClass::Apply(array("code"=>$_U['query_class'],"id"=>$_POST['id'],"realname"=>$_POST['realname'],"phone"=>$_POST['phone'],"email"=>$_POST['email'],"qq"=>$_POST['qq'],"user_id"=>$_G['user_id'],"username"=>$_G['user_result']['username']));
			if ($result!==true){
				$msg = array($result);
			}else{
				$msg = array("�����ɹ�");
			}
		}
	}
?>
