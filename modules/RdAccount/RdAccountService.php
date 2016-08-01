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



require_once 'RdAccount.class.php';
// Enciende el servidor o despliega WSDL
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST') {
	$servidorSoap = new SoapServer('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'].'?wsdl');
	
	$servidorSoap->setClass('RdAccount');
	$servidorSoap->handle();
}
else {
	require_once 'SoapDiscovery.class.php';

	// Crea el servidor de descubrimiento
	$disco = new SoapDiscovery('RdAccount','Rd_WS');
    header("Content-type: text/xml");
	if (isset($_SERVER['QUERY_STRING']) && strcasecmp($_SERVER['QUERY_STRING'],'wsdl')==0) {
		echo $disco->getWSDL();
	}
	else {
		echo $disco->getDiscovery();
	}
}

?>