<?

if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

require_once(ROOT_PATH.'plugins/editor/ubbeditor/ubb.class.php');//Ubb�༭��

require_once 'dwbbs.class.php';

//��̳������
$_G['bbs_setting'] = dwbbsClass::ActionSettings(array("action"=>"lists"));

//��̳�Ļ���

$_G['bbs_cache_result'] = dwbbsClass::GetBbsCache();

if ($_G['system']['con_rewrite']==true){
	$html_t = "/bbs/index.html?";	
}else{
	$html_t = "?bbs&";
}

$q = isset($_REQUEST['q'])?$_REQUEST['q']:"";

//�������Ӵ���
if ( $q == "postmanager"){
	$data['id'] = $_REQUEST['tid'];
	if(empty($_REQUEST['tid'])){
		$data['id'] = $_REQUEST['postid'];
		$_G['bbs_post_result'] = dwbbsClass::GetPostsOne($data);
	}else{
		$_G['bbs_post_result'] = dwbbsClass::GetTopicsOne($data);
	}
	if($_REQUEST['action'] == "movePost"){
		$result = dwbbsClass::ActionForum();
		if ($result !=false){
			$_result = "";
			foreach ($result as $key => $value){
				if ($value['pid']==0){
					$_result .= "<optgroup label='{$value['name']}'></optgroup>";
				}else{
					$_result .= "<option value='{$value['id']}'>{$value['aname']}</option>";
				}
			}
			$magic->assign("_result",$_result);
		}
	}
	
	
	$template  = "bbs_postmanager.html";
	$magic->assign("_G",$_G);
	$magic->display($template);
	exit;
}

//�������
elseif ( $q == "topicsmanager"){
	$data['reason'] = $_POST['reason'];
	$data['tid'] = $_POST['tid'] ;
	$data['postid'] = $_POST['postid'] ;
	$data['fid'] = $_POST['fid'] ;
	$data['action'] = $_REQUEST['action'] ;
	$data['value'] = isset($_POST['value'])?$_POST['value']:"";
	
	if(!empty($data['tid'])){
		$topic_result =  dwbbsClass::GetTopicsOne(array("id"=>$data['tid']));
		if($topic_result == false){
			exit("���Ӳ����ڡ�");
		}
	}
	if ($data['action'] == "highlightPost"){
		$data['highlight']['fontC'] = isset($_POST['highlightfontC'])?$_POST['highlightfontC']:"";
		$data['highlight']['fontB'] =isset($_POST['highlightfontB'])?intval($_POST['highlightfontB']):"";
		$data['highlight']['fontI'] =isset($_POST['highlightfontI'])?intval($_POST['highlightfontI']):"";
		$data['highlight']['fontU'] =isset($_POST['highlightfontU'])?intval($_POST['highlightfontU']):"";
	}
	
	
	$result = dwbbsClass::ActionTopics($data);
	if ($result===true){
		exit('_Y_');
	}
	exit($result);

}

//�����Ӻ��޸�
elseif ( $q == "post" || $q == "edit"){
	
	$fid = isset($_REQUEST['fid'])?$_REQUEST['fid']:"";
	if ($q == "edit"){
		$tid = $_REQUEST['tid'];
		$data['id'] = $tid;
		$_G['bbs_topics_result'] = dwbbsClass::GetTopicsOne($data);
		$fid = $_G['bbs_topics_result']['fid'];
	}
	if ($_G['user_id']==""){
		echo "<script>location.href='/index.php?user'</script>";
	}
   
	/*if ($_G['user_result']['real_status']==0){
		$_G['bbs_msg_title'] = "����û�о���ʵ����֤,������֤���ٷ�����ظ�";
		$_G['bbs_msg_content'] = "<a href='/index.php?user&q=code/user/realname' >����ʵ����֤</a>";
		$template  = "bbs_msg.html";
	}else*/
        if (isset($_POST['name']) && $_POST['name']!=""){
		$var = array("fid","name","content");
		$data = post_var($var);
                //echo "test:";
                //echo $data["content"];
                //exit;
                $tmpConent=$data["content"];
                $tmpConent = stripslashes($tmpConent);
                $data["content"]=htmlspecialchars($tmpConent);
                
		if ($q == "post" ){
			$data['username']  = $_G['user_result']['username'];
			$data['last_replytime'] = time();
			$data['last_replyuser'] =  $_G['user_id'];
			$data['last_replyusername'] =  $_G['user_result']['username'];
			$tid = dwbbsClass::AddTopics($data);
			$tname = "����";
		}else{
			$tid = $_POST['tid'];
			$data['id'] =$tid;
			dwbbsClass::UpdateTopics($data);
			$tname = "�༭";
		}
		if ($tid>0){
			$_G['bbs_msg_title'] = "����{$tname}�ɹ���";
			$_G['bbs_msg_content'] = '<img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="'.$html_t.'q=forums&fid='.$data["fid"].'"><u>���������б�</u></a><br /><img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="'.$html_t.'q=view&tid='.$tid.'"><u>�鿴'.$tname.'�ɹ�������</u></a>';
		}else{
			$_G['bbs_msg_title'] = "����{$tname}ʧ�ܡ�";
			$_G['bbs_msg_content'] = "<a href='#' onclick='javascript:history.go(-1)'>����</a>";
		}
		$template  = "bbs_msg.html";
	}else{
		//ȡ�õ�ǰ������Ϣ
		$data['id'] = $fid;
		$data['action'] = "view";
		$_G['bbs_forum_result'] = dwbbsClass::ActionForum($data);
		$template  = "bbs_post.html";
	}
}


//����鿴�ͻظ�
elseif ($q == "view"){
	$tid =$_REQUEST['tid'];
	$result = dwbbsClass::GetTopicsOne(array("id"=>$tid));
	$fid = $result['fid'];
	$data['id'] = $result['fid'];
	$data['action'] = "view";
	$_G['bbs_forum_result'] = dwbbsClass::ActionForum($data);
	if($result['islock']==1 && !dwbbsClass::isForumAdmin(array("fid"=>$result['fid']))){
		$_G['msg'] = array("�������ѹرջ����Ѿ�ɾ��","<a href='/bbs/index.html'>������̳��ҳ</a>");
	}else{
		if (isset($_POST['content']) && $_POST['content']!=""){
			if ($_G['user_id']==""){
				$_G['msg'] = array("�㻹û�е�¼�����ȵ�¼","<a href='/index.php?user&q=action/login'>���ص�¼ҳ��</a>");
			}else{	
				$post['name'] = isset($_POST['name'])?$_POST['name']:"RE:{$result['name']}";
				$post['content'] = $_POST['content'];
				$post['istopic']=0;
				$post['user_id'] = $_G['user_id'];
				$post['username'] = $_G['user_result']['username'];
				$post['tid'] = $tid;
				$post['fid'] = $fid;
				$post['isverify'] = $_G['bbs_forum_result']['isverify']==1?1:0;
				$result = dwbbsClass::AddPosts($post);
				$_G['msg'] = array("���ѳɹ��ظ�������",'<img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="'.$html_t.'q=forums&fid='.$fid.'"><u>���������б�</u></a><br /><img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="'.$html_t.'q=view&tid='.$tid.'"><u>���ز鿴����</u></a>');
			}
		}else{
			$_G['bbs_topics_result'] = dwbbsClass::GetTopicsOne(array("id"=>$tid,"click"=>true));
			if (isset($_G['bbs_forum_result']) && $_G['bbs_forum_result']['pid']!=0){
				$data['id'] = $_G['bbs_forum_result']['pid'];
				$_G['bbs_forum_presult'] = dwbbsClass::ActionForum($data);
			}
			$template  = "bbs_view.html";
		}
	}
}

//����ظ�
elseif ($q == "reply"){
	$tid = isset($_REQUEST['tid'])?$_REQUEST['tid']:"";
	if ($tid==""){
		$postid = isset($_REQUEST['postid'])?$_REQUEST['postid']:"";
		$_G['bbs_posts_result'] = dwbbsClass::GetPostsOne(array("id"=>$postid));
		$tid = $_G['bbs_posts_result']['tid'];
	}
	$_G['bbs_topics_result'] = dwbbsClass::GetTopicsOne(array("id"=>$tid));
	$fid = $_G['bbs_topics_result']['fid'];
	
	if (isset($_POST['pid']) && $_POST['pid']!=""){
		$var = array("name","content");
		$data = post_var($var);
		$data['id'] =$_POST['pid'];
		dwbbsClass::UpdatePosts($data);
		$_G['msg'] = array("���ѳɹ��޸�������",'<img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="/bbs/index.html?q=forums&fid='.$fid.'"><u>���������б�</u></a><br /><img src="'.$_G['tpldir'].'/images/bbs_ico_msgp1.gif" border="0" align="absmiddle" alt="" /> <a href="/bbs/index.html?q=view&tid='.$tid.'"><u>���ز鿴����</u></a>');
	
	}else{
		$data['id'] = $_G['bbs_topics_result']['fid'];
		$data['action'] = "view";
		$_G['bbs_forum_result'] = dwbbsClass::ActionForum($data);
		if (isset($_REQUEST['action'])){
			if ($_REQUEST['action'] == "quote"){
				$_G['reply_content'] = "[quote]{$_G['bbs_topics_result']['content']}
	[color=#999999]{$_G['bbs_topics_result']['username']} ������ ".date("Y-m-d",$_G['bbs_topics_result']['addtime'])." [/color][/quote]

";
			}elseif($_REQUEST['action'] == "reply"){
				$_G['reply_content'] = "[color=#333333][b]�ظ� #{$_REQUEST['f']} [i]{$_G['bbs_topics_result']['username']}[/i][/b][/color]\n\r\n\r";
			}
		
		}
		
		$template  = "bbs_reply.html";
	}

}

else{

	//����б�ҳ
	if (isset($_REQUEST['fid']) && $_REQUEST['fid']>0){
		$fid = $_REQUEST['fid'];
		$data['id'] = $fid;
		//ȡ�õ�ǰ������Ϣ
		$data['action'] = "view";
		$_G['bbs_forum_result'] = dwbbsClass::ActionForum($data);
		if ($_G['bbs_forum_result']!=false){
			if ( $_G['bbs_forum_result']['pid']!=0){
				$data['id'] = $_G['bbs_forum_result']['pid'];
				$_G['bbs_forum_presult'] = dwbbsClass::ActionForum($data);
			}
		
			//����Ӱ��
			$_G['bbs_forum_sublist'] = dwbbsClass::GetForumSub(array("fid"=>$fid));
			
			$template  = "bbs_forum.html";
		}else{
			$_G['msg'] = array("�벻Ҫ��������","������ҳ","/bbs/index.html");
		}
	}
	
	
	
	
	
	else{
		$_G['bbs_forum_list'] = dwbbsClass::ActionForum(array("action"=>"menu"));
		$template  = "bbs_list.html";
	}
}

if (!isset($template) ){
	$template = "bbs_msg.html";
}
?>