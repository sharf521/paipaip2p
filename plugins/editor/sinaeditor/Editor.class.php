<?php
/**
 * Title:���˲��ͱ༭��PHP���װ��
 * coder:gently
 * Date:2007��11��9��
 * Power by ZendStudio.Net
 * http://www.zendstudio.net/
 * ����������ʹ�úʹ��������뱣��������Ϣ��
 *
 */
define('THIS_PATH', dirname(__FILE__));//�ļ�����Ŀ¼
class sinaEditor{
	var $BasePath;
	var $Width;
	var $Height;
	var $eName;
	var $Value;
	var $AutoSave;
	function sinaEditor($eName){
		$this->eName=$eName;
		$this->BasePath=THIS_PATH;
		$this->AutoSave=false;
		$this->Height=460;
		$this->Width=640;
	}
	
	function create(){
		$ReadCookie=$this->AutoSave?1:0;
		return <<<eot
		<textarea name="{$this->eName}" id="{$this->eName}" style="display:none;">{$this->Value}</textarea>
		<iframe src="plugins/editor/sinaeditor/editor.htm?id={$this->eName}&ReadCookie={$ReadCookie}" frameBorder="0" marginHeight="0" marginWidth="0" scrolling="No" width="{$this->Width}" height="{$this->Height}"></iframe>
eot;
	}
}