<?

if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

/**
 * �ڶܰ�ȫ��½ģ��  �û���ص�¼��� add by weego 20120608
 */
function areaLoginCheck($user_id)
{
	global $mysql;
	$sql = "select * from  {user}  where user_id = '{$user_id}'";
	$lastmsg = $mysql->db_fetch_array($sql);
	$login_lasttime=$lastmsg['lasttime']; //��һ�ε�¼ʱ��
	$login_lastip=$lastmsg['lastip']; //��һ�ε�¼IP
	$login_nowtime = time(); //��ǰʱ��
	$login_nowip=ip_address();
	//ת��Ϊ��������ʾ��ʱ��
	require_once(ROOT_PATH.'core/iplocation.class.php');
	$IpLocation = new IpLocation();
	$client = $IpLocation->getlocation();
	//����
	$login_nowtime = date('m��d�� H:i',$login_nowtime); //��ǰʱ��
	$login_nowip=$client['ip']; //���ε�¼IP
	$login_nowcountry=$client['country']; //���ε�¼����
	//��һ��
	$client2 = $IpLocation->getlocation($login_lastip);
	$login_lasttime=date('m��d�� H:i',$login_lasttime); //��һ�ε�¼ʱ��
	$login_lastip=$client2['ip']; //��һ�ε�¼IP
	$login_lastcountry=$client2['country']; //��һ�ε�¼����
	$rstmsg="�ϴΣ�{$login_lastcountry} {$login_lasttime}<br/>���Σ�{$login_nowcountry} {$login_nowtime} ";
	return $rstmsg;
	

}

/**
 * �����ύ�Ĳ��� ��վ©�� add by weego 20120415
 */
function htmlgl($str,$isa='0')
{
$str = preg_replace( "@<script(.*?)</script>@is", "hackman", $str ); 
$str = preg_replace( "@<iframe(.*?)</iframe>@is", "hackman", $str ); 
$str = preg_replace( "@<style(.*?)</style>@is", "hackman", $str ); 
if($isa>'0'){
	
}else{
	$str = preg_replace( "@<(.*?)>@is", "hackman", $str ); 
}
$str=hackman($str);
return $str;
}
/**
 * �����ύ�Ĳ��� ע��©�� add by weego 20120415
 */
function safegl($str)
{
$str=trim($str);
$str=str_replace(",","hackman",$str);
$str=str_replace("'","hackman",$str);
$str=str_replace('"',"hackman",$str);
$str=str_replace("%","hackman",$str);
$str=str_replace("<","hackman",$str);
$str=str_replace("?","hackman",$str);
$str=hackman($str);
return $str;
}
/**
 * ����ύ��������¼������IP ��ȫ��� add by weego 20120606
 */
function hackman($str)
{

	$hstat=stristr($str,"hackman");
	if($hstat){
		ob_start();
		ob_get_clean();
		ob_clean();
	 
		die("���ּ�ⷢ�ֿ�������");
		exit;
	}else{
		return $str;
	}
}


/****
  *��̬������֤
 *
 */
function otp_check($uchon_sn_db, $uchon_otp){
	$fp = fsockopen("udp://42.120.11.17", 3344, $errno, $errstr, 5);
	$req = "code=0&id=username&sn={$uchon_sn_db}&otp={$uchon_otp}&svrC=&";
	if(!$fp){
		echo '<script>alert("code:0604-1 �������������Ϣ������߼���(ҫҫ)����Code��˳��ȥ���Ų�Ʊ�����������Ⱳ������Ե��������Ϣ��! ");</script>';
		return "cann't to open file";
	}
	$res = '';
	$i = 0; 
	while(!$res){
		fputs($fp, $req);
		if(20==$i++)break;
		$res = fread($fp, 1024);
	}
	fclose($fp);
	if($errno){
		return $errno. "  errstr:  ".$errstr ."  res:" . $res;
	}
	if($i == 21 && $res=='')return "���������⣬����Ϣһ������ԡ���";
	//id=username&421 OTP_ERROR
	$space = explode(" ",$res);
	$num = explode("&",$space[0]);
	return $num[1];
}
/**
 * ��ȡIP��ַ
 */
function ip_address() {
	if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
		$ip_address = $_SERVER["HTTP_CLIENT_IP"];
	}else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip_address = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
	}else if(!empty($_SERVER["REMOTE_ADDR"])){
		$ip_address = $_SERVER["REMOTE_ADDR"];
	}else{
		$ip_address = '';
	}
	return $ip_address;
}

function get_module_info ($module,$module_dir=""){
	$var = array("code","name","version","description","author","date","type");
	if ($module_dir=="") $module_dir = ROOT_PATH."modules/$module/";
	include ($module_dir."".$module.".info");
	foreach($var as $val){
		$result[$val] = empty($$val)?"":$$val;
	}
	return $result;
}

function editor($fname="content",$value="",$width=630,$height=460){
	require_once(ROOT_PATH ."/plugins/sinaeditor/Editor.class.php");
	$editor=new sinaEditor($fname);
	$editor->Value= $value;
	$editor->BasePath='../libs';
	$editor->Height= $height;
	$editor->Width=$width;
	$editor->AutoSave=false;
	return  $editor->Create();
}


function mk_dir($dir,$dir_perms=0775){
	/* ѭ������Ŀ¼ */
	if (DIRECTORY_SEPARATOR!='/') {
		$dir = str_replace('\\','/', $dir);
	}
	
	
	if (is_dir($dir)){
		return true;
	}
	
	if (@ mkdir($dir, $dir_perms)){
		return true;
	}

	if (!mk_dir(dirname($dir))){
		return false;
	}
	
	return mkdir($dir, $dir_perms);
	
}
function mkdirs($path, $mode = 0777){ 
	$dirs = explode('/',$path); 
	$pos = strrpos($path, "."); 
	if ($pos === false) { 
		$subamount=0; 
	} 
	else { 
		$subamount=1; 
	} 

	for ($c=0;$c < count($dirs) - $subamount; $c++) { 
		$path=""; 
			for ($cc=0; $cc <= $c; $cc++) { 
			$path.=$dirs[$cc].'/'; 
			} 
		if (!file_exists($path)) { 
			mkdir($path,$mode); 
		} 
	} 	
}


function mk_file($dir,$contents){
	$dirs = explode('/',$dir);
	if($dirs[0]==""){
		$dir = substr($dir,1);
	}
	mk_dir(dirname($dir));
	@chmod($dir, 0777);
	if (!($fd = @fopen($dir, 'wb'))) {
		$_tmp_file = $dir . DIRECTORY_SEPARATOR . uniqid('wrt');
		if (!($fd = @fopen($_tmp_file, 'wb'))) {
			trigger_error("ϵͳ�޷�д���ļ�'$_tmp_file'");
			return false;
		}
	}
	fwrite($fd, $contents);
	fclose($fd);
	@chmod($dir, 0777);
	return true;
}


function get_file($dir,$type='dir'){
	$result = "";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)){
			while (($file = readdir($dh)) !== false){
				$_file = $dir."/".$file;
				if ($file !="." && $file != ".." && filetype($_file)==$type ){
					$result[] = $file;
				}
			}
			closedir($dh);
		}
	}
	return $result;
}
//ɾ��ָ��Ŀ¼���ļ��У��е������ļ����� 
function del_file($dir) { 
	if (is_dir($dir)) { 
		$dh=opendir($dir);//��Ŀ¼ //�г�Ŀ¼�е������ļ���ȥ�� . �� .. 
		while (false !== ( $file = readdir ($dh))) { 
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file; 
				if(!is_dir($fullpath)) { 
					unlink($fullpath);
				} else { 
					del_file($fullpath); 
				} 
			}
		}
		closedir($dh); 
	} 
} 
function read_file($filename) {
        if ( file_exists($filename) && is_readable($filename) && ($fd = @fopen($filename, 'rb')) ) {
            $contents = '';
            while (!feof($fd)) {
                $contents .= fread($fd, 8192);
            }
            fclose($fd);
            return $contents;
        } else {
            return false;
        }
    }
	
	
function fields_input($input=""){
	$_input = array("text"=>"�����ı�",
	"multitext"=>"�����ı�",
	"password"=>"��������",
	"htmltext"=>"HTML�ı�",
	"datetime"=>"ʱ������",
	"image"=>"ͼƬ����",
	"color"=>"��ɫ����",
	"annex"=>"��������",
	"site"=>"վ����Ŀ",
	"year"=>"���ѡ��",
	"select"=>"select������",
	"checkbox"=>"checkbox��ѡ��",
	"radio"=>"radio��ѡ��");
	if ($input==""){
		return $_input;
	}else{
		return $_input['input'];
	}
}
function fields_type($type=""){
	$_type = array("varchar"=>"�ַ���[varchar]",
	"int"=>"��ֵ��[int]",
	"text"=>"һ���ı�[text]",
	"mediumtext"=>"�����ı�[mediumtext]",
	"longtext"=>"�����ı�[longtext]");
	if ($type==""){
		return $_type;
	}else{
		return $_type['type'];
	}
}

function UpfileImage($data = array()){
	$error = "";
	
	//�ļ���
	$file = isset($data['file'])?$data['file']:"";
	if ($file=="") $error = -1;;
	
	$upfileDir = isset($data['upfile_dir'])?$data['upfile_dir']:"/data/upfiles/images/";//�����ϴ����ļ�����
	$fileType = isset($data['upfile_type'])?$data['upfile_type']:array('jpg','gif','bmp','png');//�ϴ�ͼƬ
	$maxSize = isset($data['upfile_size'])?$data['upfile_size']:"300";//��λ��KB
	$newDir = ROOT_PATH."/".$upfileDir;
	
	$cutWidth = isset($data['upfile_width'])?$data['upfile_width']:"300";//��ͼ�Ŀ�
	$cutHeight = isset($data['upfile_height'])?$data['upfile_height']:"300";//��ͼ�ĸ�
	$cutType = isset($data['cuttype'])?$data['cuttype']:"";//��ͼ������
	$min_width = 10;//��ͼ��С�Ŀ��
	$min_height = 10;//��ͼ��С�ĸ߶�
	
	//�ж��ǲ�������
	if (is_array($_FILES[$file]['name'])){
		$_result = array();
		foreach($_FILES[$file]['name'] as $i => $value){
			
			if ($value!=""){
				if ($_FILES[$file]['size'][$i]==0)	$error = -1;//�ļ�������
				if(!in_array(strtolower(substr($_FILES[$file]['name'][$i],-3,3)),$fileType)) $error = -1;
				if(strpos($_FILES[$file]['type'][$i],'image')===false) $error = -1;
				if($_FILES[$file]['size'][$i] > $maxSize*1024) $error = -2;
				if($_FILES[$file]['error'][$i] !=0 ) $error = -3;
			
				//mkdirs($upfileDir,777);//�����ļ���
				
				$newFile = md5(time().rand(1,9)).$i.substr($_FILES[$file]['name'][$i],-4,4);//���ļ���
				$oldFile = $_FILES[$file]['name'][$i];//���ļ���
				$allFile = $newDir.$newFile; //
				
				if(function_exists('move_uploaded_file')){
					$result = move_uploaded_file($_FILES[$file]['tmp_name'][$i],$allFile);
					
				}else{
					@copy($_FILES[$file]['tmp_name'][$i],$allFile);
				}
				
				/*�Ƿ��ͼ ��ʼ*/
				if ($cutType==1){
					/*��ȡͼƬ����Ϣ ��ʼ*/
					$pic_info = @getimagesize($allFile);
					if($pic_info[0]<$min_width || $pic_info[1]<$min_heigth){
						$error = -4;
					}else{
						//��ȡͼƬҪѹ���ı���
						$re_scal = 1;
						if($pic_info[0]>$cutWidth){
							$re_scal = ($cutWidth / $pic_info[0]);
						}elseif($pic_info[1]>$cutHeight){
							$re_scal = ($cutHeight / $pic_info[1]);
						}
						
						if ($re_scal>0){
							$re_width = round($pic_info[0] * $re_scal);
							$re_height = round($pic_info[1] * $re_scal);
						}else{
							$re_width = $cutWidth;
							$re_height = $cutHeight;
						}
						
						/*������ͼ�� ��ʼ*/
						$new_pic = @imagecreatetruecolor($re_width,$re_height);
						if(!$new_pic){
							$error = -4;
						}else{
							//����ͼ��
							if(function_exists("file_get_contents")){
								$src = file_get_contents($allFile);
							}else{
								$handle = fopen ($allFile, "r");
								while (!feof ($handle)){
									$src .= fgets($fd, 4096);
								}
								fclose ($handle);
							}
							
							/*�����ļ� ��ʼ*/
							if(!empty($src)){
								$pic_creat = @ImageCreateFromString($src);
								if(!@imagecopyresampled($new_pic,$pic_creat,0,0,0,0,$re_width,$re_height,$pic_info[0],$pic_info[1])){
									$error = -5;
								}else{
									//����ļ�
									$out_file = '';
									switch($pic_info['mime']){
										case 'image/jpeg':
												$out_file = @imagejpeg($new_pic,$allFile);
												break;
										case 'image/gif':
												$out_file = @imagegif($new_pic,$allFile);
												break;
										case 'image/png':
												$out_file = @imagepng($new_pic,$allFile);
												break;
										case 'image/wbmp':
												$out_file = @imagewbmp($new_pic,$allFile);
												break;
										default:
											$error = 6;
											break;
									}
								}
							}
							/*�����ļ� ����*/
						}
						/*������ͼ�� ����*/
					}
					/*��ȡͼƬ����Ϣ ��ʼ*/
				}
				/*�Ƿ��ͼ ����*/
				if ($error==""){
					$_result[] = $upfileDir.$newFile;
				}
			}
		}
				
		return $_result;
	}
	else{
	
	
	}
}


/**
 * �ϴ�ͼƬ
 *
 * @return Boolean
 */
function upload($file,$type="",$fileType="",$upfileDir="",$maxSize=""){
	
	if ($_FILES[$file]['size']==0)	return 0;
	if ($fileType=="")	$fileType=array('jpg','gif','bmp','png');//�����ϴ����ļ�����
	if ($upfileDir=="")	$upfileDir='/data/upfiles/litpics/'; //�ϴ�ͼƬ
	if ($maxSize=="") $maxSize=300; //��λ��KB
	
	if(!in_array(strtolower(substr($_FILES[$file]['name'],-3,3)),$fileType)) return -1;
	if(strpos($_FILES[$file]['type'],'image')===false) return -1;
	if($_FILES[$file]['size']> $maxSize*1024) return -2;
	if($_FILES[$file]['error'] !=0 ) return -3;
	
	$newDir = dirname(__FILE__)."/..".$upfileDir;
	
	$_upfileDir = explode("/",$upfileDir);
	foreach ($_upfileDir as $key => $value){
		if ($value!="")
		$fileDir[] = $value;
	}
	/*
	foreach ($fileDir as $key => $value){
		$_fileDir = "";
		for($i=0;$i<=$key;$i++){
			$_fileDir .= $fileDir[$i]."/"; 
		}
		if (!is_dir("../".$_fileDir)){
			mkdir("../".$_fileDir,0777); 
		}
	}
	*/
	$newFile=date('Ymd').time().substr($_FILES[$file]['name'],-4,4);
	$oldFile = $_FILES[$file]['name'];
	$allFile=$newDir.$newFile;
	
	if(function_exists('move_uploaded_file')){
		 $result = move_uploaded_file($_FILES[$file]['tmp_name'],$allFile);
		 return array($upfileDir.$newFile,$type,$newFile,$oldFile,$_FILES[$file]['size']);
	}else{
		@copy($_FILES[$file]['tmp_name'],$allFile);
		return array($upfileDir.$newFile,$type,$newFile,$oldFile,$_FILES[$file]['size']);
	}
}


/**
 * ���Ȩ��
 *
 * @param Varchar $purview (��ʾ���ļ�������Ȩ�ޣ�����other_all)
 * @param Varchar $admin_purview (����Ա��Ȩ��ֵ)
 * @return Bollen
 */
function check_rank($purview){
	global $_G;
	$_admin_purview = empty($_SESSION['purview'])?"other_all":$_SESSION['purview'];
	
	$admin_purview = explode(",",$_admin_purview);
	$_purview = explode("_",$purview);
	
	if (in_array("other_all",$admin_purview) || $_G['user_result']['type_id']==1){
		return true;
	}else if (!in_array($purview,$admin_purview)){
		echo "<script>alert('��û��Ȩ��');history.go(-1);</script>";exit;
	}
}

function post_maketime($name){
	
	$var = array("year","month","date","hour","min");
	foreach ($var as $val){
		$$val = !isset($_POST[$name."_".$val])?"0":$_POST[$name."_".$val];
	}
	return mktime($hour,$min,0,$month,$date,$year);

}

function post_area($nid = ""){
	$pname = $nid."procvince";
	$cname = $nid."city";
	$aname = $nid."area";
	
	if (isset($_POST[$aname]) && $_POST[$aname]!=""){
		if ($_POST[$cname]==""){
			$area = $_POST[$pname];
		}else{
			$area = $_POST[$aname];
		}
	}else{
		if (isset($_POST[$cname]) && $_POST[$cname]!=""){
			$area = $_POST[$cname];
		}else{
			$area = isset($_POST[$pname])?$_POST[$pname]:"";
		}
	}
	return  $area;
}
function post_fields($fields){
	$_fields = "";
	if (is_array($fields)){
		foreach($fields as $key => $value){
			$_fields[$value['nid']] = empty($_POST[$value['nid']])?"":$_POST[$value['nid']];
		}	
	}
	return  $_fields;
}
function post_var($var,$type=""){
	if ($type=="module"){
		$var = array("name","status","code","order","default_field","description","index_tpl","list_tpl","content_tpl","article_status","onlyone","visit_type","title_name","issent","version","author","type");
		
	}
	if (is_array($var)){
		foreach ($var as $key =>$val){
			$_val = (isset($_POST[$val]) && $_POST[$val]!="")?$_POST[$val]:"";
			if ($_val==""){
				$_val=NULL;
			}elseif (!is_array($_val) ){
				if ($val!="content"){
					$_val = nl2br($_val);
				}
			}else{
				$_val = join(",",$_val);
			}
			$result[$val] = $_val;
			
			if($val=="area"){//����
				$result[$val] = post_area();
			}elseif($val=="flag"){//����
				$result[$val] = !isset($_POST["flag"])?NULL:join(",",$_POST["flag"]);
			}elseif ($val=="clearlitpic"){
				if ($result["clearlitpic"]!="" && $result["clearlitpic"]==1){
					$result['litpic'] = NULL;
				}
				unset($result["clearlitpic"]);
			}elseif($val=="updatetime"){//����
				$result[$val] = time();
			}elseif($val=="updateip"){//����
				$result[$val] = ip_address();
			}elseif($_val == "content"){
				$result[$val] = htmlspecialchars($result[$val]);
			}elseif($_val == "mallinfo"){
				$result[$val] = htmlspecialchars($result[$val]);
			}
		}
		
		return $result;
	}else{
		return (!isset($_POST[$var]) || $_POST[$var]=="")?NULL:$_POST[$var];
	}
}

function  gdversion() {  
	static   $gd_version_number  = null;  
	if ( $gd_version_number  === null) {  
		ob_start();  
		phpinfo(8);  
		$module_info  = ob_get_contents();  
		ob_end_clean();  
		if (preg_match( "/\bgd\s+version\b[^\d\n\r]+?([\d\.]+)/i" ,  $module_info , $matches )) {
			 $gdversion_h  =  $matches [1]; 
		 }else {
			 $gdversion_h  = 0; 
		 } 
	 }
	return  $gdversion_h;
}
function arc_page($total,$nowindex,$url){
	$result = "<div class='hycms_pages'><ul><li><a>��".$total."ҳ: </a></li>";
	for($i=1;$i<=$total;$i++){
		if ($i == $nowindex){
		$result.= "</li><li class='thisclass'><a href='#'>$i</a></li>";
		}else{
		$result.= "<li><a href='".format_url("$url/$i")."'>$i</a></li>";
		}
	}
	
	$result.= "</ul></div>";
	return $result;

}
function get_mktime($mktime){
	if ($mktime=="") return "";
	$dtime = trim(ereg_replace("[ ]{1,}"," ",$mktime));
	$ds = explode(" ",$dtime);
	$ymd = explode("-",$ds[0]);
	if (isset($ds[1]) && $ds[1]!=""){
		$hms = explode(":",$ds[1]);
		$mt = mktime(empty($hms[0])?0:$hms[0],!isset($hms[1])?0:$hms[1],!isset($hms[2])?0:$hms[2],!isset($ymd[1])?0:$ymd[1],!isset($ymd[2])?0:$ymd[2],!isset($ymd[0])?0:$ymd[0]);
	}else{
		$mt = mktime(0,0,0,!isset($ymd[1])?0:$ymd[1],!isset($ymd[2])?0:$ymd[2],!isset($ymd[0])?0:$ymd[0]);
	}
	
	return $mt;
}

/**
 * ��ʽ��·��
 */
function format_url($url,$type="",$isurl="",$tplname=""){
	global $system;
	if (is_array($isurl) && $isurl[0]==1){
		return "http://".str_replace("http://","",$isurl[1]);
	}
	if ($system['con_rewrite']==1){
		$url = str_replace("?","",$url);
		$_url = explode("/",$url);
		if (!isset($_url[1])){
			$reurl = "list_".$_url[0];
			if ($type!="sitelist" && isset($_REQUEST['page'])){
				$reurl .= "_".$_REQUEST['page'];
			}
		}else{
			$reurl = "content_".$_url[0]."_".$_url[1];
			if (isset($_url[2])){
				$reurl .= "_".$_url[2];
			}
		}
		$reurl .= ".html";
		return $reurl;
	}elseif ($system['con_rewrite']==2){
		
	
	}else{
		return $url;
	}
	

}

/**
 * ��ʽ��·��
 */
function format_tpl($tpl,$var){
	if ($tpl=="") return "";
	if (isset($var['code'])){
		$tpl = str_replace("[code]",$var['code'],$tpl);
	}
	if (isset($var['site_id'])){
		$tpl = str_replace("[site_id]",$var['site_id'],$tpl);
	}
	if (isset($var['id'])){
		$tpl = str_replace("[id]",$var['id'],$tpl);
	}
	if (isset($var['nid'])){
		$tpl = str_replace("[nid]",$var['nid'],$tpl);
	}
	$page = !isset($_REQUEST['page'])?1:$_REQUEST['page'];
	$tpl = str_replace("[page]",$page,$tpl);
	
	return trim($tpl);

}
function get_ip_place(){   
	$ip=file_get_contents("http://fw.qq.com/ipaddress");   
	$ip=str_replace('"',' ',$ip);   
	$ip2=explode("(",$ip);   
	$a=substr($ip2[1],0,-2);   
	$b=explode(",",$a);   
	return $b;   
}   
function gbk2utf8($str){
  return iconv("GBK", "UTF-8", $str);
}


function maketime($name){
	
	$var = array("year","month","date","hour","min");
	foreach ($var as $val){
		$$val = !isset($_POST[$name."_".$val])?"0":$_POST[$name."_".$val];
	}
	return mktime($hour,$min,0,$month,$date,$year);

}

/**
 * ��ȡ�����׸�ƴ����ĸ
 * @param $input �����ַ� eg:�й�
 */
function getCnFirstChar($input){

	$arr_input = array();
	$input = trim($input);
	$len = strlen($input);
	$str = '';
	for ($i = 0; $i < $len; $i++) {

		$str .= substr($input, $i, 1);
		if ($i % 2) {
			if ($str) {
				array_push($arr_input, $str);
			}
			$str = '';
		}
	}
	if(empty ($arr_input)) {
		return '';
	}

	$word = '';
	foreach ($arr_input as $input) {

		$code = '';
		$asc = ord(substr($input, 0, 1)) * 256 + ord(substr($input, 1, 1)) - 65536;
		if($asc>=-20319 and $asc<=-20284) $code = "A";
		if($asc>=-20283 and $asc<=-19776) $code = "B";
		if($asc>=-19775 and $asc<=-19219) $code = "C";
		if($asc>=-19218 and $asc<=-18711) $code = "D";
		if($asc>=-18710 and $asc<=-18527) $code = "E";
		if($asc>=-18526 and $asc<=-18240) $code = "F";
		if($asc>=-18239 and $asc<=-17923) $code = "G";
		if($asc>=-17922 and $asc<=-17418) $code = "H";
		if($asc>=-17417 and $asc<=-16475) $code = "J";
		if($asc>=-16474 and $asc<=-16213) $code = "K";
		if($asc>=-16212 and $asc<=-15641) $code = "L";
		if($asc>=-15640 and $asc<=-15166) $code = "M";
		if($asc>=-15165 and $asc<=-14923) $code = "N";
		if($asc>=-14922 and $asc<=-14915) $code = "O";
		if($asc>=-14914 and $asc<=-14631) $code = "P";
		if($asc>=-14630 and $asc<=-14150) $code = "Q";
		if($asc>=-14149 and $asc<=-14091) $code = "R";
		if($asc>=-14090 and $asc<=-13319) $code = "S";
		if($asc>=-13318 and $asc<=-12839) $code = "T";
		if($asc>=-12838 and $asc<=-12557) $code = "W";
		if($asc>=-12556 and $asc<=-11848) $code = "X";
		if($asc>=-11847 and $asc<=-11056) $code = "Y";
		if($asc>=-11055 and $asc<=-10247) $code = "Z";

		$word .= $code;
	}
	
	return strtoupper($word);
}

//����excel��ʽ��
function exportData($filename,$title,$data){
	header("Content-type: application/vnd.ms-excel");
	header("Content-disposition: attachment; filename="  . $filename . ".xls");
	if (is_array($title)){
		foreach ($title as $key => $value){
			echo $value."\t";
		}
	}
	echo "\n";
	if (is_array($data)){
		foreach ($data as $key => $value){
			foreach ($value as $_key => $_value){
				echo $_value."\t";
			}
			echo "\n";
		}
	}
}


/**
 * ��ȡ���Ե��б�
 *
 * @param Array $fields_id 
 * @param Array $order 
 * @return Integer
 */
function getFlagName($data = array()){
	$result = $data['result'];
	$flag = $data['flag'];
	$_flag = "";
	if (is_array($result)){
		foreach($result as $key => $value){
			$flagres[$value['nid']] = $value['name'];
		}
		$flags = explode(",",$flag);
		foreach ($flags as $_key => $_value){
			if ($_value!=""){
				$_flag .= $flagres[$_value]." ";
			}
		}
	}
	return $_flag;
}



/**
 * ��IDת��ΪURL��ʽ
 *
 * @param Integer $goods_id
 * @param String(eg:goods_vps/goods_hire) $goods_type
 * @return String
 */
function Key2Url($key,$type) {
	return  base64_encode ($type .$key ) ;
}

/**
 * ��URL��ʽ���ַ���ת��ΪID
 *
 * @param String $str
 * @return Array(goods_type, goods_id)
 */
function Url2Key($key,$type) {
	$key = base64_decode ( urldecode ( $key ) );
	return explode ($type, $key );
}
/**
 * ���ܼ�������
 * @param $id
 * @return String
 */
 function EnActionCode ($id,$key) {
	
	return base64_encode((string)($id * 3 + $key));
}

/**
 * ���ܼ�������
 * @param $id
 * @return String
 */
 function DeActionCode ($id,$key) {
	return (base64_decode($id) - $key) / 3;
}

function RegEmailMsg($data = array()){
	global $mysql;
	$user_id = $data['user_id'];
	$username = $data['username'];
	$webname = $data['webname'];
	$email = $data['email'];
	$query_url = isset($data['query_url'])?$data['query_url']:"action/active";
	$active_id = urlencode(authcode($user_id.",".time(),"ENCODE"));
	$_url = "http://{$_SERVER['HTTP_HOST']}/?user&q={$query_url}&id={$active_id}";
	$user_url = "http://{$_SERVER['HTTP_HOST']}";
	$send_email_msg = '


	<div style=" font-size:14px;  ">
	<div style="padding: 10px 0px;">

		<div style="padding: 2px 20px 30px;">
			<p>�װ��� <span style="color: rgb(196, 0, 0);">'.$username.'</span> , ���ã�</p>
			<p>��л��ע��'.$webname.'����ȷ�����������˺�Ϊ <strong style="font-size: 16px;">'.$email.'</strong></p>
			<p>������������Ӽ�����ɼ���:</p>
			<p style="overflow: hidden; width: 100%; word-wrap: break-word;"><a title="������ע��" href="'.$_url.'" target="_blank" swaped="true">'.$_url.'</a>
			<br><span style="color: rgb(153, 153, 153);">(��������޷�������뽫��������������ĵ�ַ����)</span></p>
			<p style="text-align: right;"><br>'.$webname.'�û����� ����</p>
		</div>
		
	</div>
</div>
		';
	return $send_email_msg;

}

function GetpwdMsg($data = array()){
	global $mysql,$_G;
	$user_id = $data['user_id'];
	$username = $data['username'];
	$webname = $data['webname'];
	$email = $data['email'];
	$active_id = urlencode(authcode($user_id.",".time(),"ENCODE"));
	$_url = "http://{$_SERVER['HTTP_HOST']}/?user&q=action/updatepwd&id={$active_id}";
	$user_url = "http://{$_SERVER['HTTP_HOST']}";
	$send_email_msg = '


	<div style="font-size:14px; ">
	<div style="padding: 10px 0px;">
		<h1 style="padding: 0px 15px; margin: 0px;">
			<a title="'.$webname.'�û�����" href="http://'.$_SERVER['HTTP_HOST'].'/" target="_blank" swaped="true">
			<img style="border-width: 0px; padding: 0px; margin: 0px;" alt="'.$webname.'�û�����" src="http://'.$_SERVER['HTTP_HOST'].'/'.$_G['sitelogo'].'" height="58">		</a>
		</h1>

		<div style="padding: 2px 20px 30px;">
			<p>�װ��� <span style="color: rgb(196, 0, 0);">'.$username.'</span> , ���ã�</p>
			<p>������������������޸����롣</p>
			<p style="overflow: hidden; width: 100%; word-wrap: break-word;"><a title="������ע��" href="'.$_url.'" target="_blank" swaped="true">'.$_url.'</a>
			<br><span style="color: rgb(153, 153, 153);">(��������޷�������뽫��������������ĵ�ַ����)</span></p>
			
			<p style="text-align: right;"><br>'.$webname.'�û����� ����</p>
			<p><br>��Ϊ�Զ������ʼ�������ֱ�ӻظ����������κ����ʣ�����<a title="�����ϵ����" style="color: rgb(15, 136, 221);" href="http://'.$_SERVER['HTTP_HOST'].'/linekefu/index.html" target="_blank" >��ϵ����</a></p>
		</div>
	</div>
</div>
		';
	return $send_email_msg;

}

//����û���ͷ��
function get_avatar($data = array()) {
	$uid = isset($data['user_id'])?$data['user_id']:"";
	$size = isset($data['size'])?$data['size']:"big";
	$type = isset($data['type'])?$data['type']:"";
	
	$istrue = isset($data['istrue'])?$data['istrue']:false;
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'big';
	$uid = abs(intval($uid));
	
	$typeadd = $type == 'real' ? '_real' : '';
	if (is_file('data/avatar/'.$uid.$typeadd."_avatar_$size.jpg")){
		if ($istrue) return true;
		return '/data/avatar/'.$uid.$typeadd."_avatar_$size.jpg";
	}else{
		if ($istrue) return false;
		return "/data/images/avatar/noavatar_{$size}.gif";
	}
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	// ��̬�ܳ׳��ȣ���ͬ�����Ļ����ɲ�ͬ���ľ���������̬�ܳ�
	$ckey_length = 4;
	// �ܳ�
	$key = md5($key ? $key : "jsiw982sjwo29swoir8743652dnapfmfka");
	// �ܳ�a�����ӽ���
	$keya = md5(substr($key, 0, 16));
	// �ܳ�b��������������������֤
	$keyb = md5(substr($key, 16, 16));
	// �ܳ�c���ڱ仯���ɵ�����
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	// ����������ܳ�
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	// ���ģ�ǰ10λ��������ʱ���������ʱ��֤������Ч�ԣ�10��26λ��������$keyb(�ܳ�b)������ʱ��ͨ������ܳ���֤����������
	// ����ǽ���Ļ�����ӵ�$ckey_lengthλ��ʼ����Ϊ����ǰ$ckey_lengthλ���� ��̬�ܳף��Ա�֤������ȷ
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	
	// �����ܳײ�
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	
	// �ù̶����㷨�������ܳײ�����������ԣ�����ܸ��ӣ�ʵ���϶Բ������������ĵ�ǿ��
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	
	// ���ļӽ��ܲ���
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		// ���ܳײ��ó��ܳ׽��������ת���ַ�
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	
	
	if($operation == 'DECODE') {
		// substr($result, 0, 10) == 0 ��֤������Ч��
		// substr($result, 0, 10) - time() > 0 ��֤������Ч��
		// substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) ��֤����������
		// ��֤������Ч�ԣ��뿴δ�������ĵĸ�ʽ
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		// �Ѷ�̬�ܳױ������������Ҳ��Ϊʲôͬ�������ģ�������ͬ���ĺ��ܽ��ܵ�ԭ��
		// ��Ϊ���ܺ�����Ŀ�����һЩ�����ַ������ƹ��̿��ܻᶪʧ��������base64����
		return $keyc.str_replace('=', '', base64_encode($result));
	}
} 



function show_pages($data = array()){
	$total= (int)$data['total'];
	$page= (int)$data['page'];
	$epage= (int)$data['epage'];
	if ($total==0){
		return "û����Ϣ";
	}
	if($total % $epage){  
		$page_num=(int)($total / $epage)+1;} 
	else { 
		$page_num=$total / $epage; 
	}
	//�ж��ж���ҳ
	if($page==""){
		$page=1;
	}
	$action = strstr($_SERVER['REQUEST_URI'],"?");

/* 	$a = explode("&",$action);

	$vs=false;
	foreach($a as $key=>$v){
		if(is_numeric(strpos($v,"type"))) $vs=$v;
	}
	
	if($vs){
		$action = (is_numeric(strpos($vs,"?")))?$vs:"?".$vs;
	}else{
		$action="";
	} */
	
	
	$first_url  = "index.html".$action; 
	$up_url  = "index".($page-1).".html".$action; 
	$last_url  = "index".$page_num.".html".$action; 
	$down_url  = "index".($page+1).".html".$action; 
	
	if ($page!=1 && $page>$page_num){
		header("location:index{$page_num}.html");
	}
	
	$display = "<b>��".$total."��</b>";
	
	$display .= " {$epage}��/ҳ<span class='page_line'>|</span>��{$page}/{$page_num}ҳ";
	
/* 	//��һҳ
	if($page==1){
		$display .= ' <span class="no_page"><font face="webdings" title="��һҳ">��һҳ</font></span>';
	}else{
		$display .= " <a href='{$first_url}'><font face='webdings' title='��һҳ'>��һҳ</font></a>";
	}
	
	//��һҳ
	if($page==1){
		$display .= ' <span class="no_page"><font face="webdings" title="��һҳ">��һҳ</font></span>';
	}else{
		$display .= " <a href='{$up_url}'><font face='webdings' title='��һҳ'>��һҳ</font></a>";
	}
	 */
	if ($page_num>5){
		if ($page<3){
			$j = 1;
			$n = 5;
		}else{
			if($page +2>$page_num){
				$j = $page_num-4;
				if ($j<=0) $j=1;
				$n = $page_num;
			}else{
				$j = $page-2;
				if ($j<=0) $j=1;
				$n =  $page+2;
			}
		}
	}else{
		$j = $page-2;
		if ($j<=0) $j=1;
		$n =  $page+2;
		if ($n>$page_num) $n=$page_num;
	}
	
	for($i=$j;$i<=$n;$i++){
		if($i==$page){
			$display .= " <span class='this_page'>{$i}</span>";
		}else{
			$display .= " <a href='index{$i}.html{$action}'>$i</a>";
		}
	}
	
	
/* 	//��һҳ
	if($page==$page_num){
		$display .= ' <span class="no_page"><font face="webdings" title="��һҳ">��һҳ</font></span>';
	}else{
		$display .= " <a href='{$down_url}'><font face='webdings' title='��һҳ'>��һҳ</font></a>";
	}
	
	//���һҳ
	if($page==$page_num){
		$display .= ' <span class="no_page"><font face="webdings" title="���һҳ">���һҳ</font></span>';
	}else{
		$display .= " <a href='{$last_url}'><font face='webdings' title='���һҳ'>���һҳ</font></a>";
	} */
	$display .=' <span class="page_go">ת��<input type="text" id="page_text" size="4" onkeydown="if (event.keyCode==13){location.href =\'index\'+this.value+\'.html'.$action.'\'}"  value="'.$page.'"  onfocus="this.select()" />ҳ</span>';
	$display .='<input type="button" value="ȷ��" onclick="var pageId;pageId=document.getElementById(\'page_text\').value;location.href =\'index\'+pageId+\'.html'.$action.'\';">';
        
        return $display;
}


function nltobr($string = ""){
	if($string=="") return "";
	$string = str_replace(" ","&nbsp;",$string);
	$string = nl2br($string);
	return $string;
}


//ȥ����Ӧ�Ĳ���
function url_format($url, $format = ''){
	if ($url=="") return "?";
	$_url =  explode("?",$url);
	$_url_for = "";
	if (isset($_url[1]) && $_url[1]!=""){
		$request = $_url[1];
		if ($request != ""){
			$_request = explode("&",$request);
			foreach ($_request as $key => $value){
				$_value = explode("=",$value);
				if (trim($_value[0])!=$format){
					$_url_for ="&" .$value;
				}
			}
		}
		$_url_for = substr($_url_for, 1,strlen($_url_for)); 
	}
	return "?".$_url_for;
}

//���ʱ������
function get_times($data=array()){
	if (isset($data['time']) && $data['time']!=""){
		$time = $data['time'];//ʱ��
	}elseif (isset($data['date']) && $data['date']!=""){
		$time = strtotime($data['date']);//����
	}else{
		$time = time();//����ʱ��
	}
	if (isset($data['type']) && $data['type']!=""){ 
		$type = $data['type'];//ʱ��ת�����ͣ���day week month year
	}else{
		$type = "month";
	}
// 	if (isset($data['num']) && $data['num']!=""){ 
// 		$num = $data['num'];
// 	}else{
// 		$num = 1;
// 	}
	$num = $data['num'];
	
	if ($type=="month"){
		$month = date("m",$time);
		$year = date("Y",$time);
		$_result = strtotime("$num month",$time);
		$_month = (int)date("m",$_result);
		if ($month+$num>12){
			$_num = $month+$num-12;
			$year = $year+1;
		}else{
			$_num = $month+$num;
		}
		
		if ($_num!=$_month){
		
			$_result = strtotime("-1 day",strtotime("{$year}-{$_month}-01"));
		}
	}else{
		$_result = strtotime("$num $type",$time);
	}
	if (isset($data['format']) && $data['format']!=""){ 
		return date($data['format'],$_result);
	}else{
		return $_result;
	}

}

//�����ʽת��
function diconv($str, $in_charset, $out_charset = CHARSET, $ForceTable = FALSE) {
	global $_G;

	$in_charset = strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);
	if($in_charset != $out_charset) {
		require_once ROOT_PATH.'core/chinese.class.php';
		$chinese = new Chinese($in_charset, $out_charset, $ForceTable);
		$strnew = $chinese->Convert($str);
		if(!$ForceTable && !$strnew && $str) {
			$chinese = new Chinese($in_charset, $out_charset, 1);
			$strnew = $chinese->Convert($str);
		}
		return $strnew;
	} else {
		return $str;
	}
}

/*function isIdCard($number) {



    //��Ȩ���� 
    $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //У���봮 
    $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    //��˳��ѭ������ǰ17λ 
    for ($i = 0;$i < 17;$i++) { 
        //��ȡǰ17λ������һλ��������������תΪʵ�� 
        $b = (int) $number{$i}; 
 
        //��ȡ��Ӧ�ļ�Ȩ���� 
        $w = $wi[$i]; 
 
        //�Ѵ����֤��������ȡ��һλ���ֺͼ�Ȩ������ˣ����ۼ� 
        $sigma += $b * $w; 
    }
    //������� 
    $snumber = $sigma % 11; 
 
    //������Ŵ�У���봮����ȡ��Ӧ���ַ��� 
    $check_number = $ai[$snumber];
 
    if ($number{17} == $check_number) {
        return true;
    } else {
        return false;
    }
}
*/

/*/
# CopyRight: zxing
# Document: ������ GB11643-1999 ��׼�����֤�������ȷ��
# File:gb11643_1999.func.php Fri Mar 28 09:42:41 CST 2008 zxing
# Updated:Fri Mar 28 09:42:41 CST 2008
# Note: ���ú��� check_id();
#/*///

#/*/
/*/
# �������ܣ��������֤�����еļ�У��
# �������ƣ�idcard_verify_number
# ������ ��string $idcard_base ���֤�����ǰʮ��λ
# ����ֵ ��string ��У��
# ����ʱ�䣺Fri Mar 28 09:50:19 CST 2008
/*/
function idcard_verify_number($idcard_base){
if (strlen($idcard_base) != 17){
   return false;
}
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); //debug ��Ȩ����
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); //debug У�����Ӧֵ
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++){
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}
/*/
# �������ܣ���15λ���֤������18λ
# �������ƣ�idcard_15to18
# ������ ��string $idcard ʮ��λ���֤����
# ����ֵ ��string
# ����ʱ�䣺Fri Mar 28 09:49:13 CST 2008
/*/
function idcard_15to18($idcard){
    if (strlen($idcard) != 15){
        return false;
    }else{// ������֤˳������996 997 998 999����Щ��Ϊ�����������˵��������
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
        }else{
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
        }
    }
    $idcard = $idcard . idcard_verify_number($idcard);
    return $idcard;
}
/*/
# �������ܣ�18λ���֤У������Ч�Լ��
# �������ƣ�idcard_checksum18
# ������ ��string $idcard ʮ��λ���֤����
# ����ֵ ��bool
# ����ʱ�䣺Fri Mar 28 09:48:36 CST 2008
/*/
function idcard_checksum18($idcard){
    if (strlen($idcard) != 18){ return false; }
    $idcard_base = substr($idcard, 0, 17);
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
        return false;
    }else{
        return true;
    }
}
/*/
# �������ܣ����֤������ӿں���
# �������ƣ�check_id
# ������ ��string $idcard ���֤����
# ����ֵ ��bool �Ƿ���ȷ
# ����ʱ�䣺Fri Mar 28 09:47:43 CST 2008
/*/
function isIdCard($idcard) {
if(strlen($idcard) == 15 || strlen($idcard) == 18){
   if(strlen($idcard) == 15){
    $idcard = idcard_15to18($idcard);
   }
   if(idcard_checksum18($idcard)){
    return true;
   }else{
    return false;
   }
}else{
   return false;
}
}

/*
*@ Date         2010.10.31
*@ Author       lzhhand 
*@ ���Žӿڴ���
$sms_type  em,normal
*/
/*
function sendSMS($uid,$pwd,$mobile,$content,$time='',$mid='')
{
	$http = 'http://www.jingpai2010.com/sms/sms.php';
	$data = array
		(
		'uid'=>$uid,					
		'pwd'=>$pwd,	
		'mobile'=>$mobile,				
		'content'=>$content,			
		'time'=>$time,		
		'mid'=>$mid						
		);
	$re= postSMS($http,$data);			//POST��ʽ�ύ
	
	if( trim($re) == '100' )
	{
		return '100';
	}
	else 
	{
		return 'error';
	}
}



function postSMS($url,$data='')
{
	$port='';
	$post='';
	$row = parse_url($url);
	if(!isset($row['port'])) $row['port']=80;
	$host = $row['host'];
	$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	if (!$fp) {
		if(isset($errstr)&&isset($errno)) return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;		
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}
*/

/*
function json_encode($arr)
{
    $json_str = "";
    if(is_array($arr))
    {
        $pure_array = true;
        $array_length = count($arr);
        for($i=0;$i<$array_length;$i++)
        {
            if(! isset($arr[$i]))
            {
                $pure_array = false;
                break;
            }
        }
        if($pure_array)
        {
            $json_str ="[";
            $temp = array();
            for($i=0;$i<$array_length;$i++)
            {
                $temp[] = sprintf("%s", json_encode($arr[$i]));
            }
            $json_str .= implode(",",$temp);
            $json_str .="]";
        }
        else
        {
            $json_str ="{";
            $temp = array();
            foreach($arr as $key => $value)
            {
                $temp[] = sprintf("\"%s\":%s", $key, json_encode($value));
            }
            $json_str .= implode(",",$temp);
            $json_str .="}";
        }
    }
    else
    {
        if(is_string($arr))
        {
            $json_str = "\"". json_encode_string($arr) . "\"";
        }
        else if(is_numeric($arr))
        {
            $json_str = $arr;
        }
        else
        {
            $json_str = "\"". json_encode_string($arr) . "\"";
        }
    }
    
	
    return $json_str;
}

 

function json_encode_string($in_str)
{
    mb_internal_encoding("UTF-8");
    $convmap = array(0x80, 0xFFFF, 0, 0xFFFF);
    $str = "";
    for($i=mb_strlen($in_str)-1; $i>=0; $i--)
    {
        $mb_char = mb_substr($in_str, $i, 1);
        if(mb_ereg("&#(\\d+);", mb_encode_numericentity($mb_char, $convmap, "UTF-8"), $match))
        {
            $str = sprintf("\\u%04x", $match[1]) . $str;
        }
        else
        {
            $str = $mb_char . $str;
        }
    }
    return $str;
}
 
*/

/*
 *@ Date         2010.10.31
*@ Author       lzhhand
*@ ���Žӿڴ���
$sms_type  em,normal
*/function sendSMS($userid,$content,$system=0)
{
	//print_r($system);
	global $_G,$mysql;
	require_once ROOT_PATH . 'core/user.class.php';
	if ($_G['system']['con_issms']==1)
	{
		if ($system==0)
		{
			$_results = userClass::GetSmsOnes(array("userid"=>$userid));
			if ($_results)
			{
				$time1=strtotime($_results["end_time"]);
				$time2=time();
				if (DateDiff("d",$time2,$time1)<0)
				{
					return false;
				}
				else
				{
					$mobile=$_results["mobile"];
				}
			}
		}
		else
		{
			$_results = userClass::GetOnes(array("user_id"=>$userid));
			//print_r($_results);
			if ($_results)
			{
				$mobile=$_results["phone"];
			}
		}
		//print_r($mobile);
		$http = $_G['system']['con_smsurl'];
		$data = array
		(
				'username'=>$_G['system']['con_smsusername'],
				'password'=>$_G['system']['con_smspassword'],
				'mobile'=>$mobile,
				'content'=>$content
				//'time'=>$time,
				//'mid'=>$mid
		);
		$sql="insert into {sms_log}(userid,msgcontent,mobile,spnumber,addtime) values(".$userid.",'".$content."','".$mobile."','1069800000091717',now())";
		$mysql->db_query($sql);
		$myid=$mysql->db_insert_id();
		$re= getSend($http,$data);			//POST��ʽ�ύ
		//$re= getSend($http,$data);				//GET��ʽ�ύ
		if( trim($re) == '1' )
		{
			$sql="update {sms_log} set issend=1,reportmsg='".$re."',updatetime=now() where id=".$myid;
			$mysql->db_query($sql);
			return true;
		}
		else
		{
			$sql="update {sms_log} set issend=2,reportmsg='".$re."',updatetime=now() where id=".$myid;
			$mysql->db_query($sql);
			return false;
		}
	}
}


function postSend($url,$param){

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function getSend($url,$data)
{
	while (list($k,$v) = each($data))
	{
		$param .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
	}
	//	$output = uc_fopen($url,'',$param);

	$ch = curl_init($url."?".$param);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;

	$output = curl_exec($ch);
	if (curl_errno($ch)) {
		echo '<pre><b>����:</b><br />('.$url."?".$param.')'.curl_error($ch);
	}
	curl_close($curl);
	//$output=file_get_contents($url."?".$param);
	return $output;
}


function DateDiff($interval, $date1, $date2) {

	// @See: It gets the number of the seconds in the one of the 2nd period day interval.
	$time_difference = $date2 - $date1;
	switch ($interval) {
		 
		case "w": $retval = bcdiv($time_difference, 604800); break;
		case "d": $retval = bcdiv($time_difference, 86400);   break;
		case "h": $retval = bcdiv($time_difference, 3600);    break;
		case "n": $retval = bcdiv($time_difference, 60);      break;
		case "s": $retval = $time_difference;                 break;
	}

	return $retval;

}

function outer_call($func, $params=null)
{
	include_once("uc_client/client.php");
    restore_error_handler();

    $res = call_user_func_array($func, $params);

    set_error_handler('exception_handler');

    return $res;
}
//����С��λ
function round_money($money,$type=1)
{
	$money=(float)$money;
	if($type==1)//��ȥ��3λ
	{	
		//$pri=substr(sprintf("%.3f", $money), 0, -1);			
		$_arr=explode('.',$money);
		if(isset($_arr[1]))
		{
			$_a=substr($_arr[1],0,2);
			$pri=$_arr[0].'.'.$_a;
		}
		else
		{
			$pri=$_arr[0];	
		}		
	}
	else
	{
		$pri=ceil($money*100)/100;	
	}
	return $pri;
}

/**
	*���ֽ��ת�������Ĵ�д���ĺ���
**/
function get_amount_da($ns) { 
    static $cnums=array("��","Ҽ","��","��","��","��","½","��","��","��"), 
        $cnyunits=array("Բ","��","��"), 
        $grees=array("ʰ","��","Ǫ","��","ʰ","��","Ǫ","��"); 
    list($ns1,$ns2)=explode(".",$ns,2); 
    $ns2=array_filter(array($ns2[1],$ns2[0])); 
    $ret=array_merge($ns2,array(implode("",_cny_map_unit(str_split($ns1),$grees)),"")); 
    $ret=implode("",array_reverse(_cny_map_unit($ret,$cnyunits))); 
    return str_replace(array_keys($cnums),$cnums,$ret); 
} 
function _cny_map_unit($list,$units) { 
    $ul=count($units); 
    $xs=array(); 
    foreach (array_reverse($list) as $x) { 
        $l=count($xs); 
        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]); 
        else $n=is_numeric($xs[0][0])?$x:''; 
        array_unshift($xs,$n); 
    } 
    return $xs; 
}
?>
