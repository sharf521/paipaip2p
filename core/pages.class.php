<?

class pages{
 	/**
  	* config ,public
  	*/
 	var $page_name="page";//page��ǩ����������urlҳ������˵xxx.php?PB_page=2�е�PB_page
 	var $next_page='��һҳ';//��һҳ
 	var $pre_page='��һҳ';//��һҳ
 	var $first_page='��ҳ';//��ҳ
 	var $last_page='βҳ';//βҳ
 	var $pre_bar='<<';//��һ��ҳ��
 	var $next_bar='>>';//��һ��ҳ��
 	var $format_left='[';
 	var $format_right=']';
 	var $very_page='';
 	var $is_ajax=false;//�Ƿ�֧��AJAX��ҳģʽ 
	var $suffix="";//α��̬�ĺ�׺
	/**
  	* private
  	*
  	*/ 
 	var $pagenum=10;//���Ƽ�¼���ĸ�����
 	var $totalpage=0;//��ҳ��
 	var $ajax_action_name='';//AJAX������
 	var $nowindex=1;//��ǰҳ
 	var $url="";//url��ַͷ
 	var $offset=0;
	var $totalnum = 0;
	var $rewrite = false;
	/**
  	* constructor���캯��
  	*
  	* @param array $array['total'],$array['perpage'],$array['nowindex'],$array['url'],$array['ajax']...
  	*/
 	function set_data($array){
		
  		if(is_array($array)){
     		if(!array_key_exists('total',$array)) $this->error(__FUNCTION__,'need a param of total');//�ж��������Ƿ����
     		$total = intval($array['total']);
     		$perpage=(array_key_exists('epage',$array))?intval($array['epage']):10;//ÿҳ��Ҫ��ʾ������
     		$nowindex=(array_key_exists('page',$array))?intval($array['page']):'';//��ǰ��ҳ��
     		$url=(array_key_exists('url',$array))?$array['url']:'';//url��ַ
     		$page_name= empty($array['page_name'])?"page":$array['page_name'];//
			$rewrite=(array_key_exists('rewrite',$array))?$array['rewrite']:'';//url��ַ
			$very_page=(array_key_exists('very_page',$array))?$array['very_page']:'6';//url��ַ
			$suffix=(array_key_exists('suffix',$array))?$array['suffix']:'';//url��ַ
			$canshu=(array_key_exists('canshu',$array))?$array['canshu']:'';//����
  		}else{
     		$total=$array;
     		$perpage=10;
     		$nowindex='1';
     		$url='';
     		$very_page='6';
     		$page_name='page';
			$rewrite='';
			$suffix="";
			$canshu="";
  		}
		if ($nowindex==0) $nowindex=1; 
		$this->rewrite = empty($rewrite)?$rewrite:false;
  		if((!is_int($total))||($total<0))$this->error(__FUNCTION__,$total.' is not a positive integer!');
  		if((!is_int($perpage))||($perpage<=0))$this->error(__FUNCTION__,$perpage.' is not a positive integer!');
		
		$this->totalnum = $total;
		$this->suffix = $suffix;
		$this->very_page = $very_page;
		$this->page_name = $page_name;
		$this->canshu = $canshu;
  		if(!empty($array['page_name'])) {
			$this->set('page_name',$array['page_name']);//����page_name
		}
  		$this->nowindex  = $this->_set_nowindex($nowindex);//���õ�ǰҳ
  		$this->url       = $this->_set_url($url);//�������ӵ�ַ
  		$this->totalpage = ceil($total/$perpage);//��ȡ��ҳ��
  		$this->offset    = ($this->nowindex-1)*$perpage;//��ȡ��ǰ��������
  		if(!empty($array['ajax']))$this->open_ajax($array['ajax']);//��AJAXģʽ
 	}
	
	/**
  	* �趨����ָ����������ֵ������ı�������������࣬��throwһ��exception
  	*
  	* @param string $var
  	* @param string $value
  	*/
 	function set($var,$value){
  		if(in_array($var,get_object_vars($this))){
    		$this->$var = $value;
  		}else {
   			$this->error(__FUNCTION__,$var." does not belong to PB_Page!");
  		}
 	}
	
	/**
  	* ���õ�ǰҳ��
  	*/
 	function _set_nowindex($nowindex){
  		if(empty($nowindex)){//ϵͳ��ȡ
   			if(isset($_GET[$this->page_name])){
    			$nowindex = intval($_GET[$this->page_name]);
   			}
  		}else{
   			$nowindex = intval($nowindex);//�ֶ�����
  		}
		return $nowindex;
 	}
	
	
	/**
  	* ����urlͷ��ַ
  	* @param: String $url
  	* @return boolean
  	*/
 	function _set_url($url=""){
		
		if($this->rewrite == true || $this->suffix!=""){
			if ($url!=""){
				$url .=$this->page_name;
			}elseif(stristr($_SERVER['REQUEST_URI'],$this->page_name.'=')){
			
				//��ַ����ҳ�����
				$url=str_replace($this->page_name.'='.$this->nowindex,'',$_SERVER['REQUEST_URI']);
				
				$last=$url[strlen($url)-1];
				if($last=='?'||$last=='&'){
					$url.=$this->page_name."=";
				}else{
					$url.='&'.$this->page_name."=";
				}
			}else{
				
				$_url = explode("?",$_SERVER['REQUEST_URI']);
				$url=str_replace($this->page_name.$this->nowindex.$this->suffix,'',$_url[0]);
				
				$url=str_replace($this->page_name.$this->suffix,'',$url);
				$url=str_replace($this->page_name.$this->suffix,'',$url);
				$url .=$this->page_name;
				//var_dump($url);
				//$url = $_SERVER['REQUEST_URI'].'?'.$this->page_name."=";
				
			}
			
			
		}elseif(!empty($url)){//�ֶ�����
			
			$url = $url.((stristr($url,'?'))?'&':'?').$this->page_name."=";
  		}else{          
			
		 //�Զ���ȡ
   			if(empty($_SERVER['QUERY_STRING'])){//������QUERY_STRINGʱ
    			$url=$_SERVER['REQUEST_URI']."?".$this->page_name."=";
   			}else{
    			if(stristr($_SERVER['QUERY_STRING'],$this->page_name.'=')){
				
        			//��ַ����ҳ�����
     				$url=str_replace($this->page_name.'='.$this->nowindex,'',$_SERVER['REQUEST_URI']);
     				$last=$url[strlen($url)-1];
     				if($last=='?'||$last=='&'){
         				$url.=$this->page_name."=";
     				}else{
         				$url.='&'.$this->page_name."=";
     				}
    			}else{
     				$url=$_SERVER['REQUEST_URI'].'&'.$this->page_name.'=';
					
    			}//end if    
   			}//end if
  		}//end if
		return $url;
 	}//end function
	
	
	/**
  	* Ϊָ����ҳ�淵�ص�ֵַ
  	*
  	* @param int $pageno
  	* @return string $url
  	*/
 	function _get_url($pageno=1){
		if ($this->canshu=="" && $this->rewrite == true){
			$_url = explode("?",$_SERVER['REQUEST_URI']);
			if (isset($_url[1])){
				$this->canshu = "?".$_url[1];
			}
		}
  		return $this->url.$pageno.$this->suffix.$this->canshu;
 	}
 	
 
 	/**
  	* ��ȡ��ҳ��ʾ���֣�����˵Ĭ�������_get_text('<a href="">1</a>')������[<a href="">1</a>]
  	*
  	* @param String $str
  	* @return string $url
  	*/ 
 	function _get_text($str){
  		return $this->format_left.$str.$this->format_right;
 	}
 
 	/**
   	* ��ȡ���ӵ�ַ
 	*/
 	function _get_link($url,$text,$style){
  		$style=(empty($style))?'':'class="'.$style.'"';
  		if($this->is_ajax){
			//�����ʹ��AJAXģʽ
   			return '<a '.$style.' href="javascript:'.$this->ajax_action_name.'(\''.$url.'\')">'.$text.'</a>';
  		}else{
   			return '<a '.$style.' href="'.$url.'">'.$text.'</a>';
  		}
 	}
 	
	/**
  	* ��ʾ������Ϣ���� 1��2��3��4��5
  	* 
  	* @param string $vpage
  	* @return string
  	*/
 	function very_page($vpage=6,$position="center",$style=""){
		$str="";
		$vpage = $this->very_page;
		if ($position=="center"){
			$j = intval($this->nowindex-$vpage/2);
			if ($j<=1) $j=1;
			$q = $vpage/2+$this->nowindex;
			if ($q<$vpage) $q=$vpage;
			if ($q>=$this->totalpage) 	$q = $this->totalpage;
 			if ($this->nowindex==1) $j=1;
			for($i=$j;$i<=$q;$i++){
				if ($i == $this->nowindex){
					$str .= $this->now_page('current');
				}else{
					$str .= $this->_get_link($this->_get_url($i),$i,$style);
				}
			}
		
			
		
		}
  		return $str;
 	}
	
	
	/**
  	* ��ȡ��ʾ"��һҳ"�Ĵ���
  	* 
  	* @param string $style
  	* @return string
  	*/
 	function next_page($style=''){
  		if($this->nowindex<$this->totalpage){
   			return $this->_get_link($this->_get_url($this->nowindex+1),$this->next_page,$style);
  		}
  		return '<span class="'.$style.'">'.$this->next_page.'</span>';
 	}
 
 	
 	/**
  	* ��ȡ��ʾ����һҳ���Ĵ���
  	*
  	* @param string $style
  	* @return string
  	*/
 	function pre_page($style=''){
  		if($this->nowindex>1){
   			return $this->_get_link($this->_get_url($this->nowindex-1),$this->pre_page,$style);
  		}
  		return '<span class="'.$style.'">'.$this->pre_page.'</span>';
 	}
 	
 
 	/**
  	* ��ȡ��ʾ����ҳ���Ĵ���
  	*
  	* @return string
  	*/
 	function first_page($style=''){
  		if($this->nowindex==1){
      		return '<span class="'.$style.'">'.$this->first_page.'</span>';
  		}
  		return $this->_get_link($this->_get_url(1),$this->first_page,$style);
 	}
 	
 
 	/**
  	* ��ȡ��ʾ��βҳ���Ĵ���
  	*
  	* @return string
  	*/
 	function last_page($style=''){
  		if($this->nowindex==$this->totalpage){
      		return '<span class="'.$style.'">'.$this->last_page.'</span>';
  		}
  		return $this->_get_link($this->_get_url($this->totalpage),$this->last_page,$style);
 	}
	
	
	/**
  	* ��ǰҳ
  	*
  	* @return string
  	*/
 	function now_page($style=''){
  		return '<span class="'.$style.'">'.$this->nowindex.'</span>';
 	}
 	
	/**
 	 * 
 	 *
 	 * @param String $style
 	 * @param String $nowindex_style
 	 * @return String
 	 */
 	function nowbar($style='',$nowindex_style=''){
  		$plus=ceil($this->pagenum/2);
  		if($this->pagenum-$plus+$this->nowindex>$this->totalpage){
  			$plus=($this->pagenum-$this->totalpage+$this->nowindex);
  		}
  		$begin=$this->nowindex-$plus+1;
  		$begin=($begin>=1)?$begin:1;
  		$return='';
  		for($i=$begin;$i<$begin+$this->pagenum;$i++){
   			if($i<=$this->totalpage){
    			if($i!=$this->nowindex){
        			$return.=$this->_get_text($this->_get_link($this->_get_url($i),$i,$style));
    			}else {
        			$return.=$this->_get_text('<span class="'.$nowindex_style.'">'.$i.'</span>');
    			}
   			}else{
    			break;
   			}
   			$return.="\n";
  		}
  		unset($begin);
  		return $return;
 	}
	
	function show($mode=1,$url=''){
 		if ($this->totalpage < 1) {
 			$this->totalpage = 1;
 		}
  		switch ($mode){
   			case '1':
    			$this->next_page='��һҳ';
    			$this->pre_page='��һҳ';
    			$this->first_page='��ҳ';
    			$this->last_page='βҳ';
    			return $this->first_page().' '.$this->pre_page().' '.$this->next_page().' '.$this->last_page().' ҳ��:<strong>'.$this->nowindex.'</strong>/'.$this->totalpage.'  ��'.$this->input_page().'ҳ';
    			break;
   			case '2':
    			$this->next_page='��һҳ';
    			$this->pre_page='��һҳ';
    			$this->first_page='��ҳ';
    			$this->last_page='βҳ';
    			return $this->first_page().$this->pre_page().'[��'.$this->nowindex.'ҳ]'.$this->next_page().$this->last_page().'��'.$this->select($url).'ҳ';
    			break;
   			case '3':
    			$this->next_page='��һҳ';
    			$this->pre_page='��һҳ';
    			$this->first_page='��ҳ';
    			$this->last_page='βҳ';
    			return "��".$this->totalnum."�� ".$this->first_page().' '.$this->pre_page().' '.$this->next_page().' '.$this->last_page();
    			break;
   			case '4':
    			$this->next_page='��һҳ';
    			$this->pre_page='��һҳ';
    			return $this->pre_page().$this->nowbar().$this->next_page();
    			break;
   			case '5':
				$this->pre_page='<font>��һҳ</font>';
				$this->next_page='<font>��һҳ</font>';
    			return $this->pre_page("disabled").$this->very_page().$this->next_page("disabled");
    			break;
   			case '6':	//�û�������Ʒ�б�ר��
    			$this->next_page='��һҳ';
    			$this->pre_page='��һҳ';
    			$this->first_page='��ҳ';
    			$this->last_page='βҳ';
    			return $this->first_page().' '.$this->pre_page().' '.$this->next_page().' '.$this->last_page().' ҳ��:<strong>'.$this->nowindex.'</strong>/'.$this->totalpage.'  ����' . $this->totalnum . '����¼   ';
    			break;
			case '7':
				$this->pre_page='<font>��һҳ</font>';
				$this->next_page='<font>��һҳ</font>';
    			return $this->pre_page("disabled").$this->very_page(13).$this->next_page("disabled");
    			break;
			
  		}
  
 	}
	
	
 	/**
   	* ������ʽ
 	*/
 	function error($function,$errormsg){
    	die('Error in file <b>'.__FILE__.'</b> ,Function <b>'.$function.'()</b> :'.$errormsg);
 	}
}
?>