<?php
	require("cukraszda.php");
	$server = new SoapServer("cukraszda.wsdl");
	$server->setClass('Cukraszda');
	$server->handle();
?>
