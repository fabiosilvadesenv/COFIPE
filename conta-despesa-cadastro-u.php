<?php
	include_once("includes/valida_sessao.php");
	include_once("class/conta-Despesa-class.php");

	if ( (isset($_POST["codigo"])) and (isset($_POST["codigo"])) )  
	{

		#variáveis oriundas método post
		$codigoConta     = $_POST["codigo"];
		$tx_nome 		 = $_POST["nome"];
		$tx_descricao	 = $_POST["descricao"];
		$lo_ativo		 = $_POST["ativo"];
		
		#instância a classe de acordo com o tipo de ação
		if ($codigoConta == 0){
			#Instância a classe.
			$conta = new dml_tbl_conta;		
			#Se for cadastro.
			$conta->cadastrarConta
				( 	  $tx_nome 	
					, $tx_descricao 
					, $lo_ativo
				);
		}
		
		if ($codigoConta != 0){
			#Instância a classe.
			$conta = new dml_tbl_conta;
			#Se for cadastro.
			$conta->atualizarConta
				( 	  $codigoConta
					, $tx_nome 	
					, $tx_descricao 
					, $lo_ativo
				);

		}
	}

	#apagar login
	if(isset($_GET["act"]))  
	{
		$id_codigo	= $_GET["rd"];

		#Instância a classe.
		$conta = new dml_tbl_conta;		
		#Se for cadastro.
		$conta->desativarConta
			( $id_codigo );

	}

?>