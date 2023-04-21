<?php
	include_once("includes/valida_sessao.php");
	include_once("class/conta-receita-saldo-class.php");

	if ( (isset($_POST["codigocontasaldo"])) and (isset($_POST["codigoconta"])) )  
	{
		#tb_conta_receita_saldo (id_conta_receita, dt_data, tx_descricao, vl_valor)	
		#variáveis oriundas método post
		$id_conta_receitaSaldo	= $_POST["codigocontasaldo"];
		$id_conta_receita		= $_POST["codigoconta"];
		$dt_data 		 		= $_POST["data"];
		$tx_descricao	 		= $_POST["descricaosaldo"];
		$vl_valor		 		= $_POST["valor"];
		
		#instância a classe de acordo com o tipo de ação
		if ($id_conta_receitaSaldo == 0){
			#Instância a classe.
			$conta = new dml_tbl_conta;		
			#Se for cadastro.
			$conta->cadastrarContaSaldo
				( 	  $id_conta_receita 	
					, $dt_data 
					, $tx_descricao
					, $vl_valor
				);
		}
		
		if ($id_conta_receitaSaldo != 0){
			#Instância a classe.
			$conta = new dml_tbl_conta;
			#Se for cadastro.
			$conta->atualizarContaSaldo
				( 	  $id_conta_receitaSaldo
					, $dt_data 	
					, $tx_descricao 
					, $vl_valor
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
		$conta->desativarContaSaldo
			( $id_codigo );

	}

?>