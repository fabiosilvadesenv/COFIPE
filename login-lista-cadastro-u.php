<?php
	include_once("includes/valida_sessao.php");
	include_once("class/login-cadatro-class.php");

	if ( (isset($_POST["codigo"])) and (isset($_POST["codigo"])) )  
	{

		#variáveis oriundas método post
		$sq_codigo_login	= $_POST["codigo"];
		$tx_login_tipo 		= $_POST["logintipo"];
		$tx_primeiro_nome	= $_POST["primeironome"];
		$tx_segundo_nome   	= $_POST["segundonome"];
		$tx_login   		= $_POST["usuario"];
		$tx_senha   		= $_POST["edtsenha"];
		$lo_ativo			= $_POST["ativo"];
		
		#instância a classe de acordo com o tipo de ação
		if ($sq_codigo_login == 0){
			#Instância a classe.
			$login = new dml_tbl_login;		
			#Se for cadastro.
			$login->cadastrarLogin
				( 	  $tx_primeiro_nome 	
					, $tx_segundo_nome 
					, $tx_login
					, $tx_senha
					, $tx_login_tipo
					, $lo_ativo
				);
		}
		
		if ($sq_codigo_login != 0){
			#Instância a classe.
			$login = new dml_tbl_login;		
			#Se for cadastro.
			$login->atualizarLogin
				( 	  $sq_codigo_login
					, $tx_primeiro_nome 	
					, $tx_segundo_nome 
					, $tx_login
					, $tx_senha
					, $tx_login_tipo
					, $lo_ativo
				);

		}
	}
	
	#apagar login
	if(isset($_GET["act"]))  
	{
		$sq_codigo_login	= $_GET["rd"];
		$lo_ativo			= 'N';

		#Instância a classe.
		$login = new dml_tbl_login;		
		#Se for cadastro.
		$login->desativarLogin
			( 	  $sq_codigo_login 				
				, $lo_ativo
			);

	}

?>