<?
if (!defined('ROOT_PATH'))  die('���ܷ���');//��ֱֹ�ӷ���

$url = $_REQUEST['url'];
$picurl =  Url2Key($url,"@imgurl@");
$pic = $picurl[1];

//$pic="../data/upfiles/images/user.jpg";
if (!file_exists(ROOT_PATH.$pic)){
	echo "no pic";exit;
}

//��չ��
/*$ext=strtolower( strrchr( ROOT_PATH.$pic , '.' ) );
if(!in_array($ext,array('.jpg','.jpeg','.gif','.png','.bmp')))
{
	ob_start();
	ob_get_clean();
	ob_clean();
	die("imgerror");
	exit;
}*/

//add by weego for 0306 oday 
if(exif_imagetype(ROOT_PATH.$pic)<1){
	ob_start();
	ob_get_clean();
	ob_clean();
	die("���ּ�ⷢ�ֿ�������  �����ڶܰ�ȫ��ʿ");
	exit;
}




$fp = fopen(ROOT_PATH.$pic,"r");
$size = filesize(ROOT_PATH.$pic);
$image = fread($fp,$size);
$nowtime=time();
$ExpDate = gmdate ("D, d M Y H:i:s", $nowtime + 3600 * 24 * 15 ); // ����15�����
header("Expires: $ExpDate GMT");    // Date in the past
header("Last-Modified: " . gmdate ("D, d M Y H:i:s", $nowtime) . " GMT"); // always modified
header("Cache-Control: public"); // HTTP/1.1
header("Pragma: Pragma");          // HTTP/1.0
header("Content-type: image/JPEG",true);
echo $image;

?> 