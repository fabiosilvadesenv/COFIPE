<?php
	include_once("includes/valida_sessao.php");
	include_once("class/login-class.php");

	
	if(isset($_POST["login"]))  
	{

		$login = $_POST["login"];
		$senha = $_POST["edtsenha"];	

		#Instância a classe.
		$login_1 = new Login;		
		#Atualiza a senha.
		$login_1->atualizarLogin($login, $senha);
	
	}

?>