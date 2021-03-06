﻿<?php
	//PHP处理函数
    function ubbReplace($str){
        $str = str_replace("<",'&lt;',$str);
        $str = str_replace(">",'&gt;',$str);
        $str = str_replace("\n",'<br/>',$str);
		$str = preg_replace("[\[/表情([0-9]*)\]]","<img src=\"face/$1.gif\" />",$str);
        return $str;
    }

	//处理表情
	$_POST['content'] = ubbReplace($_POST['content']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QQ表情 jQuery 插件</title>
<link href="qqFace.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="jquery.qqFace.min.js"></script>

<style type="text/css">
.t{
	font-size:12px;
	color:#666666;
	line-height:20px;
}
h1{
	color:#000000;
	border-bottom:1px #ccc solid;
}
.tools{
	width:510px;
	display:inline-block;
	background:#ebeff8;
	border:1px #d4d7e6 solid;
	padding:5px;
}
.faceBtn{
	color:#656565;
	font-size:12px;
	width:80px;
	height:25px;
	line-height:25px;
	padding-left:25px;
	background:url(face.gif) 4px 4px no-repeat;
	cursor:pointer;
}
</style>

<script type="text/javascript">
//实例化表情插件
$(function(){
	$('#face1').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'content1', //给那个控件赋值
		path:'face/'	//表情存放的路径
	});
	$('#face2').qqFace({
		id : 'facebox2',
		assign:'content2',
		path:'face/'
	});
});

//查看结果
function view(id){

	var str = $('#'+id).val();

	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>');
	str = str.replace(/\[\/表情([0-9]*)\]/g,'<img src="face/$1.gif" border="0" />');
		alert($('#result').html() + str);
	$('#result').html($('#result').html() + str);
}
</script>
</head>

<body>
<h1>QQ表情jQuery插件</h1>




<br />
<br />


<div class="tools">
<div id="face1" class="faceBtn">添加表情</div>
<textarea id="content1" style="width:500px;height:100px;"></textarea><br />
</div>

<br />
<input type="button" value="提交" onclick="view('content1');" />


<br />
<br />


<div class="tools">
<div id="face2" class="faceBtn">添加表情</div>
<textarea id="content2" style="width:500px;height:100px;"></textarea>
</div>

<br />
<input type="button" value="提交" onclick="view('content2');" />

<textarea id="result" style="width:500px;height:100px;"></textarea>
</div>
</body>
</html>
