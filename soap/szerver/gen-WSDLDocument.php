<?php
	//error_reporting(0);
	require 'cukraszda.php';
	require 'WSDLDocument/WSDLDocument.php';
	$wsdl = new WSDLDocument('Cukraszda', "http://localhost/webprog2_cukraszda/szerver/szerver.php", "http://localhost/webprog2_cukraszda/szerver/");
	$wsdl->formatOutput = true;
	$wsdlfile = $wsdl->saveXML();
	echo $wsdlfile;
	file_put_contents ("cukraszda.wsdl" , $wsdlfile);
?>
