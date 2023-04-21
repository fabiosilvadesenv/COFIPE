<?php
	include("includes/valida_sessao.php");

	class dml_tbl_conta{
	 		
		#cadastra login
		public function cadastrarContaSaldo
		( 	  $in_id_conta_receita
			, $in_dt_data
			, $in_tx_descricao		
			, $in_vl_valor
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			

						#tb_conta_receita_saldo (id_conta_receita, dt_data, tx_descricao, vl_valor)
				$sql = "INSERT INTO tb_conta_receita_saldo
							(	id_conta_receita, 
								dt_data, 
								tx_descricao,
								vl_valor) 
						VALUES (
								:id_conta_receita, 
								:dt_data, 
								:tx_descricao, 
								:vl_valor );";
				
				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_conta_receita'	, $in_id_conta_receita);
				$rs->bindValue(':dt_data'	  		, $in_dt_data);
				$rs->bindValue(':tx_descricao'		, $in_tx_descricao);
				$rs->bindValue(':vl_valor'	  		, $in_vl_valor);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#atualiza login
		public function atualizarContaSaldo
		( 	  $in_id_conta_receita_saldo
			, $in_dt_data
			, $in_tx_descricao		
			, $in_vl_valor
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_conta_receita_saldo
						set  dt_data		  =	:dt_data	
							,tx_descricao	  = :tx_descricao
							,vl_valor		  =	:vl_valor
						where id_conta_receita_saldo = :id_conta_receita_saldo ";

				$rs = $db->prepare($sql);

				$rs->bindValue(':dt_data'	  			, $in_dt_data);
				$rs->bindValue(':tx_descricao'			, $in_tx_descricao);
				$rs->bindValue(':vl_valor'	  			, $in_vl_valor);
				$rs->bindValue(':id_conta_receita_saldo', $in_id_conta_receita_saldo);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#apaga login
		public function desativarContaSaldo
		( 	  $in_id_conta_receita_saldo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "delete from tb_conta_receita_saldo 
						where id_conta_receita_saldo = :id_conta_receita_saldo ";

				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_conta_receita_saldo', $in_id_conta_receita_saldo);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}


		
	}  
	   
?>