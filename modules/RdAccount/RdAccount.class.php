<?php
  
/**
 * 
 * Copyright (c) 2005, Braulio Jos�Solano Rojas
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 * 
 * 	Redistributions of source code must retain the above copyright notice, this list of
 * 	conditions and the following disclaimer. 
 * 	Redistributions in binary form must reproduce the above copyright notice, this list of
 * 	conditions and the following disclaimer in the documentation and/or other materials
 * 	provided with the distribution. 
 * 	Neither the name of the Solsoft de Costa Rica S.A. nor the names of its contributors may
 * 	be used to endorse or promote products derived from this software without specific
 * 	prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND
 * CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 * NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 *
 * @version $Id$
 * @copyright 2005 
 */


/**
 * HelloWorld Class that implements the typical first example of programming in every language.
 * 
 * @package SoapDiscovery
 * @author Braulio Jos�Solano Rojas
 * @copyright Copyright (c) 2005 Braulio Jos�Solano Rojas
 * @version $Id$
 * @access public
 **/
require_once("core/config.inc.php");

class RdAccount {
	private $nombre = '';
	
	/**
	 * HelloWorld::__construct() HelloWorld class Constructor.
	 * 
	 * @param string $nombre
	 * @return string
	 **/
	public function __construct($name = 'World') {
		$this->name = $name;
	}
	
	/**
	 * HelloWorld::greet() Greets the World xor $this->name xor $name if $name is not empty.
	 * 
	 * @param string $nombre
	 * @return string
	 **/
	public function greet($name = '') {
		$name = $name?$name:$this->name;
		return 'Hello '.$name.'.';
	}
	
	/**
	 * HelloWorld::servidorEstampillaDeTiempo() Returns server timestamp.
	 * 
	 * @return string 
	 **/
	public function serverTimestamp() {
		return time();
	} 
	
	public function getUserAccountInfo($data){
		return "user_id is ".$data['ws_user_id']."sadf:".$data['ws_user_type'];
	}
	
	public function accountM2L($data){
		return "operate:m2L :user_id is ".$data['ws_user_id']."money:".$data['money'];
	}
	
	public function accountL2M($data){
		return "operate:l2m :user_id is ".$data['ws_user_id']."money:".$data['money'];
	}
	
	public function awardL2M($data){
		$alienate_fee_rate = isset($_G['system']['con_right_alienate_fee'])?$_G['system']['con_right_alienate_fee']:"0.03";
		return "ROOT_PATH:".$ROOT_PATH."operate:awardL2M :user_id is ".$data['ws_user_id']."money:".$data['money']." con_right_alienate_fee:".$alienate_fee_rate;
	}
}

?>