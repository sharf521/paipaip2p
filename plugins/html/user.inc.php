<? 
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

//�ж��û��Ƿ��Ѿ���¼
if ( (!isset($_SESSION['logintype']) || $_SESSION['logintype']!="admin"  || $_G['user_id']=="" || ($_G['user_result']['type']!="1" && $_A['query_type']!="dbbackup"))  && $_A['query_sort']!="login"){
	die("No!");
}

$data['page'] = isset($_REQUEST['page'])?$_REQUEST['page']:"";
$data['epage'] = 7;
if (isset($_REQUEST['realname'])){
	$data['realname'] = $_REQUEST['realname'];
	$data['username'] = $_REQUEST['username'];
	$data['type_id'] = $_REQUEST['type_id'];
}
$result = userClass::GetList($data);

$pages->is_ajax = true;
$pages->ajax_action_name = "change_ajax_action";
$pages->set_data($result);
$showpage = $pages->show(3);
$user_type = userClass::GetTypeList();
?>
<div>
<div class="user_ajax_title">
�û�����<input type="text" value="<? echo $_REQUEST['username'];?>" size="10" id="username"/>��ʵ������<input type="text" value="<? echo $_REQUEST['realname'];?>"size="10" id="realname"/>�û�����:<select id="type_id"><option value="">����</option><? foreach ($user_type as $key => $value){
	echo "<option value={$value['type_id']}>{$value['name']}</option>";
}?></select><input type="button" value="����" onclick="change_user_list()" />
</div>
<div class="user_ajax">
<table  border="0"  cellspacing="1"  width="100%">
		<tr >
			<td width="" class="main_td" align="center">�û���</td>
			<td width="" class="main_td" align="center">��ʵ����</td>
			<td width="" class="main_td" align="center">�Ա�</td>
			<td width="" class="main_td" align="center">�û�����</td>
		</tr>
		<? foreach ($result['list'] as $key => $value){?>
		<tr class="tr2">
			<td width=""  align="center"><a href="javascript:void(0)" onclick="change_user_ajax('<? echo !empty($value['username'])?$value['username']:$value['realname'];?>','<? echo $value['user_id'];?>')" title="�������" ><? echo !empty($value['username'])?$value['username']:$value['realname'];?></a></td>
			<td width="" align="center"><? echo empty($value['realname'])?"-":$value['realname'];?></td>
			<td width="" align="center"><? echo empty($value['sex'])?"-":$value['sex'];?></td>
			<td width="" align="center"><? echo $value['typename'];?></td>
		</tr>
		<? }?>
		<tr>
			<td colspan="4" class="page" align="center" >
			<? echo $showpage;?>
			</td>
		</tr>
</table>
</div>
<IFRAME 
style="Z-INDEX: -1; FILTER: progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0); LEFT: 0px; VISIBILITY: inherit; WIDTH: 400px; POSITION: absolute; TOP: 0px; HEIGHT: 300px;border:none " 
src=""></IFRAME>
</div>

<script>
function del_user_ajax(user_id){
$("#userajax"+user_id).remove();
}
function change_user_ajax(username,user_id){
	var input_id = '<? echo $_REQUEST['name'];?>input'+user_id;
	<? if (isset($_REQUEST['type']) && $_REQUEST['type']=="list"){?>
	var display = "<span id='userajax"+user_id+"' style='float:left'>["+username+"(<a href='javascript:del_user_ajax("+user_id+")'>x</a>)]<input type='hidden' name='<? echo $_REQUEST['name'];?>' id='"+input_id+"' value='"+user_id+"'></span>";
	var  disval = $("#<? echo $_REQUEST['id'];?>").html();
	if (disval=="��ѡ��..."){
		disval = "";
	}
	del_user_ajax(user_id);
	$("#<? echo $_REQUEST['id'];?>").html(disval+display);
	<? }elseif (isset($_REQUEST['type']) && $_REQUEST['type']=="input"){?>
		$("#<? echo $_REQUEST['id'];?>").val(username);
		$("#windownbg").remove();
		$("#windown-box").fadeOut("slow",function(){$(this).remove();});
	<? }else{?>
	var display = "<input type='hidden' name='<? echo $_REQUEST['name'];?>' value='"+user_id+"'>";
	$("#<? echo $_REQUEST['id'];?>").html(username+display);
	$("#windownbg").remove();
	$("#windown-box").fadeOut("slow",function(){$(this).remove();});
	<? }?>
}
function change_user_list(){
	var username = $("#username").val();
	var realname = $("#realname").val();
	var type_id = $("#type_id").val();
	tipsWindown("ѡ���û�","url:get?plugins/index.php?q=user&name=<? echo $_REQUEST['name'];?>&id=<? echo $_REQUEST['id'];?>&username="+username+"&realname="+realname+"&type_id="+type_id,500,300,"true","","true","text");

}
function change_ajax_action(url){
	tipsWindown("ѡ���û�","url:get?"+url,500,300,"false","","true","text");
}
</script>
<? exit;?>