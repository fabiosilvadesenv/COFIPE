<?php
	if(!isset($_SESSION)){
		session_start(); 
	}
	
	#Redireciona caso não esteja logado!
	if (!isset($_SESSION['sID_LOGIN'])) {
		header("Location: index.html"); 
	}	
	
	$tokenSession1 = 'token1:'.$_SERVER['REMOTE_ADDR'];
	$tokenSession2 = 'token2:'.$_SERVER['HTTP_USER_AGENT'];
	
	$tokenSession  = md5( $tokenSession1 . $tokenSession2 );
	
	if($_SESSION['idSESSION'] != $tokenSession ){
		header("Location: index.html"); 	
	}
	
	
?>