<?php
	include("includes/valida_sessao.php");

	/**
	 * Summary of dml_tbl_lancamento
	 */
	class dml_tbl_lancamento{
	 		
		#cadastra login
		public function cadastrarLancamento
		( 	 $id_conta_receita 		
			,$id_conta_despesa 		
			,$id_login 		
			,$dt_data 
			,$vl_valor 
			,$tx_observacao
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "INSERT INTO tb_lancamento 
						(	id_conta_receita, 
							id_conta_despesa, 
							id_login, 
							dt_data, 
							vl_valor, 
							tx_observacao	) 
						values
						(	:id_conta_receita, 
							:id_conta_despesa, 
							:id_login, 
							:dt_data, 
							:vl_valor, 
							:tx_observacao	)";
				
				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_conta_receita', $id_conta_receita);
				$rs->bindValue(':id_conta_despesa', $id_conta_despesa);
				$rs->bindValue(':id_login', 		$id_login);
				$rs->bindValue(':dt_data', 			$dt_data);
				$rs->bindValue(':vl_valor', 		$vl_valor);
				$rs->bindValue(':tx_observacao', 	$tx_observacao);
				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#atualiza login
		/**
		 * Summary of atualizarLancamento
		 * @param mixed $lancamanto
		 * @param mixed $id_conta_receita
		 * @param mixed $id_conta_despesa
		 * @param mixed $id_login
		 * @param mixed $dt_data
		 * @param mixed $vl_valor
		 * @param mixed $tx_observacao
		 * @return void
		 */
		public function atualizarLancamento
		( 	 $lancamanto
			,$id_conta_receita 		
			,$id_conta_despesa 		
			,$id_login 		
			,$dt_data 
			,$vl_valor 
			,$tx_observacao
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_lancamento 
							SET
								id_conta_receita  = :id_conta_receita 
								,id_conta_despesa = :id_conta_despesa 
								,id_login         = :id_login 
								,dt_data          = :dt_data 
								,vl_valor         = :vl_valor 
								,tx_observacao	  = :tx_observacao 
						where id_lancamento = :id_lancamento ";

				$rs = $db->prepare($sql);
				$rs->bindValue(':id_conta_receita', $id_conta_receita);
				$rs->bindValue(':id_conta_despesa', $id_conta_despesa);
				$rs->bindValue(':id_login', 		$id_login);
				$rs->bindValue(':dt_data', 			$dt_data);
				$rs->bindValue(':vl_valor', 		$vl_valor);
				$rs->bindValue(':tx_observacao', 	$tx_observacao);
				$rs->bindValue(':id_lancamento',    $lancamanto); 
				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#apaga login
		public function excluirLancamento
		( 	  $lancamanto
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "delete from tb_lancamento 
						where id_lancamento = :id_lancamento";

				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_lancamento', $lancamanto); 

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}


		
	}  
	   
?>