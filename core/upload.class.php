<?
/**
 *  ����ͼƬ�����������ͼƬ���룬ˮӡ���
 *  ��ˮӡͼ����Ŀ��ͼƬ�ߴ�ʱ��ˮӡͼ���Զ���ӦĿ��ͼƬ����С
 *  ˮӡͼ�������ø������ĺϲ���
 *
 *  Copyright(c) 2010 by dwcms. All rights reserved
 *
*/

class upload
{
    var $dst_img;// Ŀ���ļ�
    var $h_src; // ͼƬ��Դ���
    var $h_dst;// ��ͼ���
    var $h_mask;// ˮӡ���
    var $img_create_quality = 100;// ͼƬ��������
    var $img_display_quality = 100;// ͼƬ��ʾ����,Ĭ��Ϊ75
    var $img_scale = 0;// ͼƬ���ű���
    var $dst_w = 0;// ��ͼ�ܿ��
    var $dst_h = 0;// ��ͼ�ܸ߶�
    var $fill_w;// ���ͼ�ο�
    var $fill_h;// ���ͼ�θ�
    var $copy_w;// ����ͼ�ο�
    var $copy_h;// ����ͼ�θ�
    var $src_x = 0;// ԭͼ������ʼ������
    var $src_y = 0;// ԭͼ������ʼ������
    var $start_x;// ��ͼ������ʼ������
    var $start_y;// ��ͼ������ʼ������
    var $mask_word;// ˮӡ����
    var $mask_img;// ˮӡͼƬ
    var $mask_pos_x = 0;// ˮӡ������
    var $mask_pos_y = 0;// ˮӡ������
    var $mask_offset_x = 5;// ˮӡ����ƫ��
    var $mask_offset_y = 5;// ˮӡ����ƫ��
    var $font_w;// ˮӡ�����
    var $font_h;// ˮӡ�����
    var $mask_w;// ˮӡ��
    var $mask_h;// ˮӡ��
    var $mask_font_color = "#ffffff";// ˮӡ������ɫ
    var $mask_font = 2;// ˮӡ����
    var $font_size;// �ߴ�
    var $mask_position = 0;// ˮӡλ��
    var $mask_img_pct = 50;// ͼƬ�ϲ��̶�,ֵԽ�󣬺ϲ�����Խ��
    var $mask_txt_pct = 50;// ���ֺϲ��̶�,ֵԽС���ϲ�����Խ��
    var $img_border_size = 0;// ͼƬ�߿�ߴ�
    var $img_border_color;// ͼƬ�߿���ɫ
    var $_flip_x=0;// ˮƽ��ת����
    var $_flip_y=0;// ��ֱ��ת����
	var $pic_w;// �ϴ�ͼƬ�Ŀ��
    var $pic_h;// �ϴ�ͼƬ�ĸ߶�
    var $file_upname;// �ϴ�ͼƬ�ĸ߶�
	var $src_w = "";
	var $src_h = "";
	var $file_name="";// �ϴ�ͼƬ����
	var $file_maxsize="300";// �ϴ�ͼƬ���Ĵ�С
	var $file_dir="data/upfiles";// �ϴ����ļ���
	var $file_type = array('jpg','gif','bmp','png');//�ϴ�ͼƬ
	var $file_quality = "100";//�������
	
	var $cut_width="";// ��ͼ���
	var $cut_height="";//��ͼ�߶�
	var $cut_scale="50";//��ͼ����
	var $cut_type = "";//��ͼ����

    var $img_type;// �ļ�����
    // �ļ����Ͷ���,��ָ�������ͼƬ�ĺ���
    var $all_type = array(
        "jpg"  => array("output"=>"imagejpeg"),
        "gif"  => array("output"=>"imagegif"),
        "png"  => array("output"=>"imagepng"),
        "wbmp" => array("output"=>"image2wbmp"),
        "jpeg" => array("output"=>"imagejpeg"));

	 /**
     * ���캯��
     */
    function upload() {
        $this->mask_font_color = "#ffffff";
        $this->font = 2;
        $this->font_size = 12;
    }
	

	
	//������ص�����
	function setData($data = array()){
		if (isset($data['file_newname']) && $data['file_newname']!=""){
			$this->setDstImg($data['file_newname']);//�����µ�ͼƬ
		}
		$this->file_dir = isset($data['file_dir'])?$data['file_dir']:"data/upfiles/images/";//����ͼƬ�ϴ���·��
		$this->file_dir .= date("Y-m",time())."/".date("d",time())."/";
		$this->file_type = isset($data['file_type'])?$data['file_type']:array('jpg','gif','bmp','png');//����ͼƬ
		$this->file_size = isset($data['file_size'])?$data['file_size']:"2048";//����ͼƬ
		$this->file_quality = isset($data['file_quality'])?$data['file_quality']:"80";//����ͼƬ
		$this->file_newname = (isset($data['user_id'])?$data['user_id']:"0")."_".(isset($data['code'])?$data['code']:"system")."_".time().rand(0,9);//���ļ���
		$this->cut_status = isset($data['cut_status'])?$data['cut_status']:"";//��ͼ����
		if ($this->cut_status==1){
			$this->cut_type = isset($data['cut_type'])?$data['cut_type']:"";//��ͼ����
			$this->cut_scale = isset($data['cut_scale'])?$data['cut_scale']:"";//ͼƬ���ű���
			$this->cut_width = isset($data['cut_width'])?$data['cut_width']:"";//��ͼ�Ŀ��
			$this->cut_height = isset($data['cut_height'])?$data['cut_height']:"";//��ͼ�Ŀ��
			$this->cut_quality = isset($data['cut_quality'])?$data['cut_quality']:"";//ͼƬ������
		}
		
		$this->mask_status = isset($data['mask_status'])?$data['mask_status']:"";//��ͼ����
		if ($this->mask_status==1){
			$this->mask_word = isset($data['mask_word'])?$data['mask_word']:"";//ˮӡ������
			$this->mask_font_color = isset($data['mask_color'])?$data['mask_color']:"#ffffff";//ˮӡ��������ɫ
			$this->font_size = isset($data['mask_size'])?$data['mask_size']:"";//ˮӡ�Ĵ�С
			$this->font = isset($data['mask_font'])?$data['mask_font']:"";//ˮӡ������
			$this->mask_img = isset($data['mask_img'])?$data['mask_img']:"";//ˮӡ��ͼƬ
			$this->mask_position = isset($data['mask_position'])?$data['mask_position']:"1";//ˮӡ��λ��
		}
	}
	
	/*
	 *$error:-1:�ļ��������ڣ�-2���ļ�������,-3:ͼƬ���Ͳ���ȷ��-4:����ͼƬ���ͣ�-5:ͼƬ�ߴ����
	
	*/
	
	function upfile($data = array()){
		global $mysql;
		$error = "";
		if (!isset($data['file'])) return "";//
		$filename = isset($data['filename'])?$data['filename']:"";
		$file = $data['file'];
		if(!isset($_FILES[$file]['name'])) return "";
		
		//$dateFile = date("Y-m",time());
		$this->setData($data);
		$newDir = ROOT_PATH.$this->file_dir;
		//�ϴζ��ͼƬ
		$err_var = array("-2"=>"�ļ�������","-3"=>"ͼƬ���Ͳ���ȷ","-4"=>"����ͼƬ����","-5"=>"�ϴ�ͼƬ����");
		//�ж��ǲ�������
		if (is_array($_FILES[$file]['name'])){
			$_result = array();
			foreach($_FILES[$file]['name'] as $i => $value){
				if ($value!=""){
					
					
					if(exif_imagetype($_FILES[$file]['name'][$i])<1)
					{
						continue;
					}
					$this->img_type = strtolower(substr($_FILES[$file]['name'][$i],-3,3));
					if ($_FILES[$file]['size'][$i]==0)	$error = -2;//�ļ�������
// 					if(!in_array($this->img_type,$this->file_type)) $error = -3;
// 					if(strpos($_FILES[$file]['type'][$i],'image')===false) $error = -4;
					if($_FILES[$file]['size'][$i] > $this->file_size*1024) $error = -5;
					if($_FILES[$file]['error'][$i] !=0 ) $error = -2;
					$this->_mkdirs($this->file_dir);//�����ļ���
					
					$newFile = $this->file_newname.$i.substr($_FILES[$file]['name'][$i],-4,4);//���ļ���
					$oldFile = $_FILES[$file]['name'][$i];//���ļ���
					$allFile = $newDir.$newFile; //
					if ($error<0){
						echo "<script>alert('".$err_var[$error]."');history.go(-1);</script>";
						exit;
					}
					if(function_exists('move_uploaded_file')){
						$result = move_uploaded_file($_FILES[$file]['tmp_name'][$i],$allFile);
					}else{
						@copy($_FILES[$file]['tmp_name'][$i],$allFile);
					}
					
					$this->setSrcImg($allFile);//����ͼƬ����·��
					$this->setCutimg();//��ȡ������
					$this->setDstImg($allFile);
					//$this->_createMask();
					$this->_output();
					
					if ($error==""){
						$sql = "insert into  {upfiles}  set code='{$data['code']}',aid='{$data['aid']}',user_id='{$data['user_id']}',`name`='{$_name}',filesize='{$_FILES[$file]['size'][$i]}',filetype='{$this->img_type}',fileurl='".$this->file_dir.$newFile."',filename='".$newFile."',`addtime` = '".time()."', `updatetime` = '".time()."',`addip` = '".ip_address()."',`updateip` = '".ip_address()."'";
						$mysql ->db_query($sql);
						$upfiles_id = $mysql->db_insert_id();
						$_result[$i]['filename'] = $this->file_dir.$newFile;
						$_result[$i]['upfiles_id'] = $upfiles_id;
					}else{
						echo "<script>alert('".$err_var[$error]."');history.go(-1);</script>";
						exit;
					}
				}
			}
			return $_result;
		}else{			
			$this->img_type = strtolower(substr($_FILES[$file]['name'],-3,3));
			if ($_FILES[$file]['size']==0)	return "";//�ļ�������
// 			if(!in_array($this->img_type,$this->file_type)) $error = -3;
// 			if(strpos($_FILES[$file]['type'],'image')===false) $error = -4;
			if($_FILES[$file]['size'] > $this->file_size*1024) $error = -5;
			if($_FILES[$file]['error'] !=0 ) $error = -2;
			$this->_mkdirs($this->file_dir);//�����ļ���
	
			$newFile = $this->file_newname.substr($_FILES[$file]['name'],-4,4);//���ļ���
			$oldFile = $_FILES[$file]['name'];//���ļ���
			$allFile = $newDir.$newFile; //

			if(exif_imagetype($_FILES[$file]['tmp_name'])<1)
			{						
				if(! in_array($data['file'],array('logoimg')))
				{
					ob_start();
					ob_get_clean();
					ob_clean();
					die("���ּ�ⷢ�ֿ����ϴ��ļ� ��");
					exit;
				}
			}
		
			if ($error!=""){
				echo "<script>alert('".$err_var[$error]."');history.go(-1);</script>";
				exit;
			}
			
			
			
			if(function_exists('move_uploaded_file')){
				$result = move_uploaded_file($_FILES[$file]['tmp_name'],$allFile);
			}else{
				@copy($_FILES[$file]['tmp_name'],$allFile);
			}

			//$this->setSrcImg($allFile);//����ͼƬ����·��
			
			$this->setCutimg();//��ȡ������
			
			$this->setDstImg($allFile);
			
			//$this->_createMask();
			
			$this->_output();
			
		
			if ($error==""){
				$sql = "insert into  {upfiles}  set code='{$data['code']}',aid='{$data['aid']}',user_id='{$data['user_id']}',`name`='{$data['file']}',filesize='{$_FILES[$file]['size']}',filetype='{$this->img_type}',fileurl='".$this->file_dir.$newFile."',filename='".$newFile."',`addtime` = '".time()."', `updatetime` = '".time()."',`addip` = '".ip_address()."',`updateip` = '".ip_address()."'";
				$mysql ->db_query($sql);
				$upfiles_id = $mysql->db_insert_id();
				return array("filename"=>$this->file_dir.$newFile,"upfiles_id"=>$upfiles_id);
			}
			return "";
		}
		//�ϴε���ͼƬ
	}
	function litpic ($data = array()){
		$this->img_type = strtolower(substr($data['url'],-3,3));
		$this->setData($data);
		$this->setSrcImg(ROOT_PATH.$data['url']);//����ͼƬ����·��
		$this->setCutimg();//��ȡ������
		$this->setDstImg(ROOT_PATH.$data['new_url']);
		$this->_createMask();
		$this->_output();
	}
	
	function UpfileSwfupload($data = array()){
		global $mysql;
		$error = "";
		$file = $data['file'];
		$dateFile = date("Y-m",time());
		$this->setData($data);
		$newDir = ROOT_PATH.$this->file_dir;
		$count = $num = 0;
		$error_msg = array();
		//�ϴζ��ͼƬ
		$err_var = array("-2"=>"�ļ�������","-3"=>"ͼƬ���Ͳ���ȷ","-4"=>"����ͼƬ����","-5"=>"�ϴ�ͼƬ����");
		//�ж��ǲ�������
		$_result = array();
		$this->img_type = strtolower(substr($_FILES[$file]['name'],-3,3));
		if ($_FILES[$file]['size']==0)	$error = -2;//�ļ�������
		//if(!in_array($this->img_type,$this->file_type)) $error = -3;
		//if(strpos($_FILES[$file]['type'],'image')===false) $error = -4;
		if($_FILES[$file]['size'] > $this->file_size*1024) $error = -5;
		//if($_FILES[$file]['error'] !=0 ) $error = -2;
		
		if ($error<0) return;
		$this->_mkdirs($this->file_dir);//�����ļ���
		
		$newFile = $data['user_id']."_".$data['data_type']."_".time().rand(110,999).substr($_FILES[$file]['name'],-4,4);//���ļ���
		$oldFile = $_FILES[$file]['name'];//���ļ���
		$allFile = $newDir.$newFile; //
		
		if(exif_imagetype($_FILES[$file]['tmp_name'])<1)
		{
			ob_start();
			ob_get_clean();
			ob_clean();
			die("���ּ�ⷢ�ֿ����ϴ��ļ� ��");
			exit;
		}
		
		if(function_exists('move_uploaded_file')){
			$result = move_uploaded_file($_FILES[$file]['tmp_name'],$allFile);
		}else{
			@copy($_FILES[$file]['tmp_name'],$allFile);
		}
		
		$this->setSrcImg($allFile);//����ͼƬ����·��
		$this->setCutimg();//��ȡ������
		$this->setDstImg($allFile);
		$this->_createMask();
		$this->_output();
		
		if($data['aid']==""){
			$sql = "select * from  {upfiles}  where user_id='{$data['user_id']}' order by id desc";
			$result = $mysql->db_fetch_array($sql);
			$data['aid'] = $result['aid'];
		}
		$sql = "insert into  {upfiles}  set 	
		code='{$data['code']}',aid='{$data['aid']}',user_id='{$data['user_id']}',
		`name`='{$data['name']}',filesize='{$_FILES[$file]['size']}',
		filetype='{$this->img_type}',fileurl='".$this->file_dir.$newFile."',
		filename='".$newFile."',`addtime` = '".time()."', `updatetime` = '".time()."',
		`addip` = '".ip_address()."',`updateip` = '".ip_address()."'";
		$mysql ->db_query($sql);
		$upfiles_id = $mysql->db_insert_id();
		$sql = "select * from  {upfiles}  where code = '{$data['code']}' and aid = '{$data['aid']}' and if_cover = 1";
		$result = $mysql->db_fetch_array($sql);
		if($result==false){
			$sql = "update  {upfiles}  set if_cover=1 where id= {$upfiles_id}";
			$mysql->db_query($sql);
		}
		return array("filename"=>$this->file_dir.$newFile,"upfiles_id"=>$upfiles_id);
	}
	
	
	//�ϴ����ͼƬ
	function upfiles($data = array()){
		global $mysql;
		$error = "";
		$file = $data['file'];
		$dateFile = date("Y-m",time());
		$this->setData($data);
		$newDir = ROOT_PATH.$this->file_dir;
		$count = $num = 0;
		$error_msg = array();
		//�ϴζ��ͼƬ
		$err_var = array("-2"=>"�ļ�������","-3"=>"ͼƬ���Ͳ���ȷ","-4"=>"����ͼƬ����","-5"=>"�ϴ�ͼƬ����");
		//�ж��ǲ�������
		$_result = array();
		foreach($_FILES[$file]['name'] as $i => $value){
			if ($value!=""){
				$count ++;
				$this->img_type = strtolower(substr($_FILES[$file]['name'][$i],-3,3));
				if ($_FILES[$file]['size'][$i]==0)	$error = -2;//�ļ�������
// 				if(!in_array($this->img_type,$this->file_type)) $error = -3;
// 				if(strpos($_FILES[$file]['type'][$i],'image')===false) $error = -4;
				if($_FILES[$file]['size'][$i] > $this->file_size*1024) $error = -5;
				if($_FILES[$file]['error'][$i] !=0 ) $error = -2;
				$this->_mkdirs($this->file_dir);//�����ļ���
				
				$newFile = md5(time().rand(1,9)).$i.substr($_FILES[$file]['name'][$i],-4,4);//���ļ���
				$oldFile = $_FILES[$file]['name'][$i];//���ļ���
				$allFile = $newDir.$newFile; //
				if ($error<0){
					$error_msg[] = $oldFile.$err_var[$error];
				}else{
					if(exif_imagetype($_FILES[$file]['tmp_name'][$i])<1)
					{
						ob_start();
						ob_get_clean();
						ob_clean();
						die("���ּ�ⷢ�ֿ����ϴ��ļ� ��");
						exit;
					}
					
					
					if(function_exists('move_uploaded_file')){
						$result = move_uploaded_file($_FILES[$file]['tmp_name'][$i],$allFile);
					}else{
						@copy($_FILES[$file]['tmp_name'][$i],$allFile);
					}
					$this->setSrcImg($allFile);//����ͼƬ����·��
					$this->setCutimg();//��ȡ������
					$this->setDstImg($allFile);
					$this->_createMask();
					$this->_output();
					if($data['name'][$i]==""){
						$_name = $oldFile;
					}else{
						$_name = $data['name'][$i];
					}
					$sql = "insert into  {upfiles}  set code='{$data['code']}',aid='{$data['aid']}',user_id='{$data['user_id']}',`name`='{$_name}',filesize='{$_FILES[$file]['size'][$i]}',filetype='{$this->img_type}',fileurl='".$this->file_dir.$newFile."',filename='".$newFile."',`addtime` = '".time()."', `updatetime` = '".time()."',`addip` = '".ip_address()."',`updateip` = '".ip_address()."'";
					$mysql ->db_query($sql);
					$file_id = $mysql->db_insert_id();
					$num++;
				}
			}
		}
		//��Ϊ����
		if ($num>0){
			$sql = "select * from  {upfiles}  where code = '{$data['code']}' and aid = '{$data['aid']}' and if_cover = 1";
			$result = $mysql->db_fetch_array($sql);
			if($result==false){
				$sql = "update  {upfiles}  set if_cover=1 where id= {$file_id}";
				$mysql->db_query($sql);
			}
		}
		$display = "��{$count}����Ƭ�ϴ�������{$num}�ϴ��ɹ���".join(",",$error_msg);
		return $display;
	}
	
	function UpdateMore($data = array()){
		global $mysql;
		foreach ($data['id'] as $key => $value){
			$sql = "update  {upfiles}  set `name` = '{$data['name'][$key]}' where `id` = '{$value}' and user_id = '{$data['user_id']}'";
			$mysql->db_query($sql);
		}
	
	}
	
	//��õ�����Ƭ����Ϣ
	function GetOne($data = array()){
		global $mysql;
		$_sql = "where 1=1 ";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and  p1.user_id='{$data['user_id']}'";
		}
		if (isset($data['id']) && $data['id']!=""){
			$_sql .= " and  p1.id='{$data['id']}'";
		}
		$sql = "select * from  {upfiles}  as p1 {$_sql}";
		return $mysql->db_fetch_array($sql);
	}
	
	//ɾ����Ƭ
	function Delete($data = array()){
		global $mysql;
		$_sql = "where id={$data['id']}";
		if (isset($data['user_id']) && $data['user_id']!=""){
			$_sql .= " and user_id = '{$data['user_id']}'";
		}
		$sql = "select * from  {upfiles}   {$_sql}";
		$result = $mysql->db_fetch_array($sql);
		if ($result!=false){
			$_dir = explode($result['filename'],$result['fileurl']);
			self::DelPic($_dir[0],$result['filename']);
			$sql = "delete from  {upfiles}  {$_sql}" ;
			$mysql ->db_query($sql);
		}
	}
	
	function  DelPic($dir,$filename){
		$_filename = substr($filename,0,strlen($filename)-4);
		if (is_dir($dir)) { 
			$dh=opendir($dir);//��Ŀ¼ //�г�Ŀ¼�е������ļ���ȥ�� . �� .. 
			while (false !== ( $file = readdir ($dh))) { 
				if($file!="." && $file!="..") {
					$fullpath=$dir."/".$file;
					$_url = explode($_filename,$file);
					if(!is_dir($fullpath) && isset($_url[0]) && $_url[0]=="") { 
						unlink($fullpath);
					} 
				}
			}
			closedir($dh); 
		} 
	
	}
	
	  /**
     * ͼƬ���
     */
    function _output(){
        $img_type  = $this->img_type;
		if ($img_type!=""){
			$func_name = $this->all_type[$img_type]['output'];
			
			if(function_exists($func_name))        {
				// �ж������,����IE�Ͳ�����ͷ
				if(isset($_SERVER['HTTP_USER_AGENT']))            {
					$ua = strtoupper($_SERVER['HTTP_USER_AGENT']);
					if(!preg_match('/^.*MSIE.*\)$/i',$ua))                {
						header("Content-type:$img_type");
					}
				}
				@$func_name($this->h_dst, $this->dst_img, $this->file_quality);
			}
			else{
				return false;
			}
		}else{
			return false;
		}
    }
	
	function cutImg(){	
		$this->src_w = $this->getImgWidth($this->h_src);
        $this->src_h = $this->getImgHeight($this->h_src);
		 // ������ͼ������
        $this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
	}
	
	  /**
     * ����ͼƬ����·��
     *
     * @param    string    $src_img   ͼƬ����·��
     */
    function setSrcImg($src_img, $img_type=null)  {
        if(!file_exists($src_img))   return -1 ;//die("ͼƬ������");

		//��ȡ�ļ�����
		if(!empty($img_type)){
			$this->img_type = $img_type;
		}
		else{
			$img_info = $this->getImgInfo($src_img);
	
		}

		$this->h_src =$img_info['img_src'];
		$this->src_w = $img_info['img_width'];
		$this->src_h = $img_info['img_height'];

    }
	
	
	function setCutimg(){
		
		if ($this->cut_status==1){
		
			//������������С
			if ($this->cut_type==1){
				$this->fill_w = round($this->src_w * $this->cut_scale / 100) - $this->img_border_size*2;
				$this->fill_h = round($this->src_h * $this->cut_scale / 100) - $this->img_border_size*2;
	
				// Դ�ļ���ʼ����
				$this->src_x  = 0;
				$this->src_y  = 0;
				
				$this->copy_w = $this->src_w;
				$this->copy_h = $this->src_h;
	
				// Ŀ��ߴ�
				$this->dst_w   = $this->fill_w + $this->img_border_size*2;
				$this->dst_h   = $this->fill_h + $this->img_border_size*2;
			
			}
			
			elseif ($this->cut_type==2){
				$fill_w   = (int)$this->cut_width - $this->img_border_size*2;
				$fill_h   = (int)$this->cut_height - $this->img_border_size*2;
				
				if($fill_w < 0 || $fill_h < 0){
					return -8 ;//ͼƬ�߿�����ѳ�����ͼƬ�Ŀ��;
				}
				
				$rate_w = $this->src_w/$fill_w;
				$rate_h = $this->src_h/$fill_h;
				
				// ���ԭͼ��������ͼ��������С��������С
				if($rate_w < 1 && $rate_h < 1){
					$this->fill_w = (int)$this->src_w;
					$this->fill_h = (int)$this->src_h;
				}
				else{
					if($rate_w >= $rate_h)	{
						$this->fill_w = (int)$fill_w;
						$this->fill_h = round($this->src_h/$rate_w);
					}
					else{
						$this->fill_w = round($this->src_w/$rate_h);
						$this->fill_h = (int)$fill_h;
					}
				}
				
				$this->src_x  = 0;
				$this->src_y  = 0;
	
				$this->copy_w = $this->src_w;
				$this->copy_h = $this->src_h;
	
				// Ŀ��ߴ�
				$this->dst_w   = $this->fill_w + $this->img_border_size*2;
				$this->dst_h   = $this->fill_h + $this->img_border_size*2;
				
			}
			
			// ���ͼƬ����С���вŽ��в���
			elseif ($this->cut_type==3){
			
				$fill_w   = (int)$this->cut_width - $this->img_border_size*2;
				$fill_h   = (int)$this->cut_height - $this->img_border_size*2;
				
				if($fill_w < 0 || $fill_h < 0){
					return -8 ;//ͼƬ�߿�����ѳ�����ͼƬ�Ŀ��;
				}
				
				$rate_w = $this->src_w/$fill_w;
				$rate_h = $this->src_h/$fill_h;
			
				// ���ͼƬ����С���вŽ��в���
				if($rate_w >= 1 && $rate_h >=1){
					if($this->src_w > $this->src_h)	{
						$src_x = round($this->src_w-$this->src_h)/2;
						
						$this->src_x  = $src_x;
						$this->src_y  = 0;
						
						$this->fill_w = $this->fill_h;
						$this->fill_h = $this->fill_h;
	
						$this->copy_w = $this->src_h;
						$this->copy_h = $this->src_h;
						
					}
					elseif($this->src_w < $this->src_h){
						$src_y = round($this->src_h-$this->src_w)/2;
						
						$this->src_x  = 0;
						$this->src_y  = $src_y;
						
						$this->fill_w = $this->fill_w;
						$this->fill_h = $this->fill_h;
	
						$this->copy_w = $this->src_w;
						$this->copy_h = $this->src_w;
					}
					else{
						$this->src_x  = 0;
						$this->src_y  = 0;
						
						$this->copy_w = $this->src_w;
						$this->copy_h = $this->src_w;
						
						$this->fill_w = $this->fill_w;
						$this->fill_h = $this->fill_h;
					}
				}
				else{
					$this->src_x  = 0;
					$this->src_y  = 0;
					
					$this->fill_w = $this->src_w;
					$this->fill_h = $this->src_h;
	
					$this->copy_w = $this->src_w;
					$this->copy_h = $this->src_h;
					
				}
				
				// Ŀ��ߴ�
				$this->dst_w   = $this->fill_w + $this->img_border_size*2;
				$this->dst_h   = $this->fill_h + $this->img_border_size*2;
	
			}
			
			// �ֶ���ͼ����ض��پͶ���
			elseif ($this->cut_type==4){
			
				$fill_w   = $this->cut_width - $this->img_border_size*2;
				$fill_h   = $this->cut_height - $this->img_border_size*2;
				
				if($fill_w < 0 || $fill_h < 0){
					return -8 ;//ͼƬ�߿�����ѳ�����ͼƬ�Ŀ��;
				}
				
				$this->copy_w = $fill_w;
				$this->copy_h = $fill_h;
	
				// Ŀ��ߴ�
				$this->dst_w   = $fill_w + $this->img_border_size*2;
				$this->dst_h   = $fill_h + $this->img_border_size*2;	
				
				$this->fill_w = $fill_w;
				$this->fill_h = $fill_h;
			
			}
		}else{
			$this->src_x  = 0;
			$this->src_y  = 0;
			
			$this->fill_w = $this->src_w;
			$this->fill_h = $this->src_h;

			$this->copy_w = $this->src_w;
			$this->copy_h = $this->src_h;
			
			// Ŀ��ߴ�
			$this->dst_w   = $this->fill_w + $this->img_border_size*2;
			$this->dst_h   = $this->fill_h + $this->img_border_size*2;
		
		}
		 // Ŀ���ļ���ʼ����
        $this->start_x = $this->img_border_size;
        $this->start_y = $this->img_border_size;
	}
	
	
	
	
	/**
     * ����ͼƬ����·��
     *
     * @param    string    $dst_img   ͼƬ����·��
     */
    function setDstImg($dst_img)    {
        $arr  = explode('/',$dst_img);
        $last = array_pop($arr);
        $path = implode('/',$arr);
        $this->_mkdirs(ROOT_PATH.$path);
        $this->dst_img = $dst_img;
    }
	
	
	function getImgInfo($src_img){
		if ($src_img=="") return -1;	
		 if(function_exists("file_get_contents"))   {
            $src = file_get_contents($src_img);
        }
        else {
            $handle = fopen ($src_img, "r");
            while (!feof ($handle))
            {
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($src))   {
            return -1;//die("ͼƬԴΪ��");
        }
        $h_src = @ImageCreateFromString($src);
		$img_info = @getimagesize ($src_img);
		
		return array("img_width"=>$img_info[0],"img_height"=>$img_info[1],"img_type"=>$img_info[2],"img_src"=>$h_src);
		
	}
	
	 /**
     * ���ͼƬ�����Ƿ�Ϸ�,������array_key_exists�������˺���Ҫ��
     * php�汾����4.1.0
     *
     * @param    string     $img_type    �ļ�����
     */
    function _checkValid($img_type)
    {
        if(!array_key_exists($img_type, $this->all_type))
        {
            return false;
        }
    }
	
	 /**
     * ��ָ��·������Ŀ¼
     *
     * @param    string     $path    ·��
     */
    function _mkdirs($path)  {
        $adir = explode('/',$path);
        $dirlist = '';
        $rootdir = array_shift($adir);
        if(($rootdir!='.'||$rootdir!='..')&&!file_exists($rootdir))
        {
            @mkdir($rootdir);
        }
        foreach($adir as $key=>$val)
        {
            if($val!='.'&&$val!='..')
            {
                $dirlist .= "/".$val;
                $dirpath = $rootdir.$dirlist;
                if(!file_exists($dirpath))
                {
                    @mkdir($dirpath);
                    @chmod($dirpath,0777);
                }
            }
        }
    }
	/**
     * ������ɫ
     *
     * @param    string     $color    ʮ��������ɫ
     */
    function _parseColor($color)
    {
        $arr = array();
        for($ii=1; $ii<strlen($color); $ii++)
        {
            $arr[] = hexdec(substr($color,$ii,2));
            $ii++;
        }

        Return $arr;
    }

    /**
     * �����λ������
     */
    function _countMaskPos()
    {
        if($this->_isFull())
        {
            switch($this->mask_position)
            {
                case 1:
                    // ����
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 2:
                    // ����
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;

                case 3:
                    // ����
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 4:
                    // ����
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;

                default:
                    // Ĭ�Ͻ�ˮӡ�ŵ�����,ƫ��ָ������
                    $this->mask_pos_x = $this->src_w - $this->mask_w - $this->mask_offset_x;
                    $this->mask_pos_y = $this->src_h - $this->mask_h - $this->mask_offset_y;
                    break;
            }
        }
        else
        {
            switch($this->mask_position)
            {
                case 1:
                    // ����
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 2:
                    // ����
                    $this->mask_pos_x = $this->mask_offset_x + $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;

                case 3:
                    // ����
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->mask_offset_y + $this->img_border_size;
                    break;

                case 4:
                    // ����
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;

                default:
                    // Ĭ�Ͻ�ˮӡ�ŵ�����,ƫ��ָ������
                    $this->mask_pos_x = $this->dst_w - $this->mask_w - $this->mask_offset_x - $this->img_border_size;
                    $this->mask_pos_y = $this->dst_h - $this->mask_h - $this->mask_offset_y - $this->img_border_size;
                    break;
            }
        }
    }
	
	/**
     * ����ˮӡ,����������ˮӡ���ֺ�ˮӡͼƬ��������
     */
    function _createMask(){
		
		 if($this->mask_status!=1 || (empty($this->mask_word) && empty($this->mask_img)))  {
            $this->h_dst = @imagecreatetruecolor($this->dst_w, $this->dst_h);
            $white = @imageColorAllocate($this->h_dst,255,255,255);
            @imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// ��䱳��ɫ
            $this->_drawBorder();

            @imagecopyresampled( $this->h_dst, $this->h_src,
                        $this->start_x, $this->start_y,
                        $this->src_x, $this->src_y,
                        $this->fill_w, $this->fill_h,
                        $this->copy_w, $this->copy_h);
						
        }else {
			if($this->mask_word!="") {
				// ��ȡ������Ϣ
				$this->_setFontInfo();
				
				if($this->_isFull()) {
					//die("ˮӡ���ֹ���");
				}
				else{
					$this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
					$white = ImageColorAllocate($this->h_dst,255,255,255);
					imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// ��䱳��ɫ
					$this->_drawBorder();
					imagecopyresampled( $this->h_dst, $this->h_src,
										$this->start_x, $this->start_y,
										$this->src_x, $this->src_y,
										$this->fill_w, $this->fill_h,
										$this->copy_w, $this->copy_h);
					$this->_createMaskWord($this->h_dst);
				}
				
			}else if($this->mask_img){
				$this->_loadMaskImg();//����ʱ��ȡ�ÿ��
				if($this->_isFull()) {
				   $this->h_dst = @imagecreatetruecolor($this->dst_w, $this->dst_h);
				$white = @imageColorAllocate($this->h_dst,255,255,255);
				@imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// ��䱳��ɫ
				$this->_drawBorder();
	
				@imagecopyresampled( $this->h_dst, $this->h_src,
							$this->start_x, $this->start_y,
							$this->src_x, $this->src_y,
							$this->fill_w, $this->fill_h,
							$this->copy_w, $this->copy_h);
				}else{
					// ������ͼ������
					$this->h_dst = imagecreatetruecolor($this->dst_w, $this->dst_h);
					$white = ImageColorAllocate($this->h_dst,255,255,255);
					imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$white);// ��䱳��ɫ
					$this->_drawBorder();
					imagecopyresampled( $this->h_dst, $this->h_src,
										$this->start_x, $this->start_y,
										$this->src_x, $this->src_y,
										$this->fill_w, $this->fill_h,
										$this->copy_w, $this->copy_h);
					$this->_createMaskImg($this->h_dst);
				}
			}
        }

       
    }
  /**
     * ����������Ϣ
     */
    function _setFontInfo()
    {
        if(is_numeric($this->font)) {
            $this->font_w  = imagefontwidth($this->font);
            $this->font_h  = imagefontheight($this->font);

            // ����ˮӡ������ռ���
            $word_length   = strlen($this->mask_word);
            $this->mask_w  = $this->font_w*$word_length;
            $this->mask_h  = $this->font_h;
        }
        else{
            $arr = imagettfbbox ($this->font_size,0, $this->font,$this->mask_word);
            $this->mask_w  = abs($arr[0] - $arr[2]);
            $this->mask_h  = abs($arr[7] - $arr[1]);
        }
    }

    /**
     * ���߿�
     */
    function _drawBorder()
    {
        if(!empty($this->img_border_size))
        {
            $c = $this->_parseColor($this->img_border_color);
            $color = ImageColorAllocate($this->h_src,$c[0], $c[1], $c[2]);
            imagefilledrectangle($this->h_dst,0,0,$this->dst_w,$this->dst_h,$color);// ��䱳��ɫ
        }
    }

    /**
     * ����ˮӡ����
     */
    function _createMaskWord($src)
    {
        $this->_countMaskPos();
        $result = $this->_checkMaskValid();
		if ($result != false){
			$c = $this->_parseColor($this->mask_font_color);
			$color = imagecolorallocatealpha($src, $c[0], $c[1], $c[2], $this->mask_txt_pct);
	
			if(is_numeric($this->font)){
				imagestring($src,
							$this->font,
							$this->mask_pos_x, $this->mask_pos_y,
							$this->mask_word,
							$color);
							
			}
			else{
				imagettftext($src,
							$this->font_size, 0,
							$this->mask_pos_x, $this->mask_pos_y,
							$color,
							$this->font,
							$this->mask_word);
			}
		}
    }

    /**
     * ����ˮӡͼ
     */
    function _createMaskImg($src) {
        $this->_countMaskPos();
		$result = $this->_checkMaskValid();
		if ($result != false){
			imagecopymerge($src,
							$this->h_mask,
							$this->mask_pos_x ,$this->mask_pos_y,
							0, 0,
							$this->mask_w, $this->mask_h,
							$this->mask_img_pct);
			imagedestroy($this->h_mask);
		}
    }

    /**
     * ����ˮӡͼ
     */
    function _loadMaskImg(){
        $mask_type = $this->_getImgType($this->mask_img);
        $this->_checkValid($this->img_type);

        // file_get_contents����Ҫ��php�汾>4.3.0
        $src = '';
        if(function_exists("file_get_contents")){
            $src = file_get_contents(ROOT_PATH.$this->mask_img);
        } else {
            $handle = fopen ($this->mask_img, "r");
            while (!feof ($handle)){
                $src .= fgets($fd, 4096);
            }
            fclose ($handle);
        }
        if(empty($this->mask_img))  {
           return false;
        }else{
			$this->h_mask = ImageCreateFromString($src);
			$this->mask_w = $this->getImgWidth($this->h_mask);
			$this->mask_h = $this->getImgHeight($this->h_mask);
		}
    }
	
	 /**
     * ȡ��ͼƬ����
     *
     * @param    string     $file_path    �ļ�·��
     */
    function _getImgType($file_path){
        $type_list = array("1"=>"gif","2"=>"jpg","3"=>"png","4"=>"swf","5" => "psd","6"=>"bmp","15"=>"wbmp");
        if(file_exists($file_path)){
            $img_info = @getimagesize ($file_path);
            if(isset($type_list[$img_info[2]])){
                return $type_list[$img_info[2]];
            }
        } else{
            return  false;
        }
    }
	
	/**
     * ���ˮӡͼ�Ƿ�������ɺ��ͼƬ���
     */
    function _isFull()
    {
        Return (   $this->mask_w + $this->mask_offset_x > $this->fill_w
                || $this->mask_h + $this->mask_offset_y > $this->fill_h)
                   ?true:false;
    }
	
	 /**
     * ���ˮӡͼ�Ƿ񳬹�ԭͼ
     */
    function _checkMaskValid()
    {
        if($this->mask_w + $this->mask_offset_x > $this->src_w
            || $this->mask_h + $this->mask_offset_y > $this->src_h)
        {
           return false;
        }else{
			return true;
		}
    }
	  /**
     * ȡ��ͼƬ�Ŀ�
     */
    function getImgWidth($src)
    {
        return imagesx($src);
    }

    /**
     * ȡ��ͼƬ�ĸ�
     */
    function getImgHeight($src)
    {
        return imagesy($src);
    }
}
?>