<?
session_register("valicode");
$width=50;    //�ȶ���ͼƬ�ĳ����� 
$height= isset($_REQUEST['height'])?$_REQUEST['height']:18;
$rand_str = "";
 $codeSet = '346789ABCDEFGHJKLMNPQRTUVWXY';  
 $fontSize = 25;     // ��֤�������С(px)  
 $useCurve = true;   // �Ƿ񻭻�������  
 $useNoise = true;   // �Ƿ�����ӵ�   
 $imageH = 0;        // ��֤��ͼƬ��  
 $imageL = 0;        // ��֤��ͼƬ��  
 $length = 4;        // ��֤��λ��  

for($i=0;$i<4;$i++){
	$rand_str .= chr(mt_rand(48,57));
}
if(function_exists("imagecreate")){

	$_SESSION["valicode"]=strtolower($rand_str);//ע��session
	
	$img = imagecreate($width,$height);//����ͼƬ
    imagecolorallocate($img, 255,255,255);  //ͼƬ��ɫ��ImageColorAllocate��1�ζ�����ɫPHP����Ϊ�ǵ�ɫ�� 
//    $black = imagecolorallocate($img,127,157,185);        
	$black = imagecolorallocate($img, 0,0,0);     //��������������Ϊ���õ���ɫ
	$white = imagecolorallocate($img, 255,255,255);
	$gray = imagecolorallocate($img, 200,200,200);
	$red = imagecolorallocate($img, 255, 0, 0);
	
 
	
  	for($i = 0; $i < 10; $i++){  
          //�ӵ���ɫ  
           $noiseColor = imagecolorallocate($img,mt_rand(150,190),mt_rand(150,180), mt_rand(150,180));  
           for($j = 0; $j < 5; $j++) {  
               // ���ӵ�  
       	 imagestring($img,$j,mt_rand(-10,$height), mt_rand(-20,$width),$codeSet[mt_rand(0, 27)],$noiseColor);  
			
			// �ӵ��ı�Ϊ�������ĸ������  
                 
           }  
      }  
	   
	   
	   
	for($i=0;$i<4;$i++){ //��������
		imagestring($img, mt_rand(3,6), $i*10+6, mt_rand(2,5), $rand_str[$i],imagecolorallocate($img,mt_rand(0,89),mt_rand(0,89),mt_rand(0,89)));
	 }


	
  //	imagerectangle($img,0,0,$width-1,$height-1,$black);//�ȳ�һ��ɫ�ľ��ΰ�ͼƬ��Χ
	
	if(function_exists("imagejpeg")){
		header("content-type:image/jpeg\r\n"); imagejpeg($img); 
	}else{ 
		header("content-type:image/png\r\n"); imagepng($img); 
	}
	
	imagedestroy($img);
	
}else{
	$_SESSION["valicode"]="1234";
	header("content-type:image/jpeg\r\n");
	$fp = fopen("./valicode.bmp","r");
	echo fread($fp,filesize("./validate.bmp"));
	fclose($fp);
}

?>
