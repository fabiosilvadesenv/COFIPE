<?php
	include_once("includes/valida_sessao.php");
	include_once("class/conta-lancamento-class.php");

	if ( (isset($_POST["codigo"])) and (isset($_POST["codigo"])) )  
	{

		#variáveis oriundas método post
		$lancamanto      	= $_POST["codigo"];
		$id_conta_receita 	= $_POST["conta_receita"];
		$id_conta_despesa	= $_POST["conta_despesa"];
		$dt_data		 	= $_POST["data"];
		$vl_valor	 		= $_POST["valor"];
		$tx_observacao		= $_POST["observacao"];
		$id_login 			= $_SESSION['sID_LOGIN'];

		#instância a classe de acordo com o tipo de ação
		if ($lancamanto == 0){
			#Instância a classe.
			$conta = new dml_tbl_lancamento;		
			#Se for cadastro.
			$conta->cadastrarLancamento
				( 	 $id_conta_receita 		
					,$id_conta_despesa 		
					,$id_login 		
					,$dt_data 
					,$vl_valor 
					,$tx_observacao
				);
		}
		
		if ($lancamanto != 0){
			#Instância a classe.
			$conta = new dml_tbl_lancamento;
			#Se for cadastro.
			$conta->atualizarLancamento
			( 	 $lancamanto
				,$id_conta_receita 		
				,$id_conta_despesa 		
				,$id_login 		
				,$dt_data 
				,$vl_valor 
				,$tx_observacao
		);

		}
	}

	#apagar login
	if(isset($_GET["act"]))  
	{
		$lancamanto	= $_GET["rd"];

		#Instância a classe.
		$conta = new dml_tbl_lancamento;		
		#Se for cadastro.
		$conta->excluirLancamento
			( $lancamanto );

	}

?>