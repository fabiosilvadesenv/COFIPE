<?php
	include("includes/valida_sessao.php");

	class dml_tbl_conta{
	 		
		#cadastra login
		public function cadastrarConta
		( 	  $in_tx_nome 	
			, $in_tx_descricao 			
			, $in_st_ativo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "INSERT INTO tb_conta_Despesa
							(	tx_nome, 
								tx_descricao, 
								st_ativo) 
						VALUES (
							:tx_nome, 
							:tx_descricao, 
							:st_ativo );";
				
				$rs = $db->prepare($sql);
				
				$rs->bindValue(':tx_nome'	  , $in_tx_nome);
				$rs->bindValue(':tx_descricao', $in_tx_descricao);
				$rs->bindValue(':st_ativo'	  , $in_st_ativo);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#atualiza login
		public function atualizarConta
		( 	  $in_id_conta
			, $in_tx_nome 	
			, $in_tx_descricao 			
			, $in_lo_ativo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_conta_Despesa 
							set  tx_nome 		= :tx_nome
								,tx_descricao   = :tx_descricao
								,st_ativo 		= :st_ativo
						where id_conta_Despesa = :id_conta_Despesa ";

				$rs = $db->prepare($sql);
				$rs->bindValue(':tx_nome'	      , $in_tx_nome);
				$rs->bindValue(':tx_descricao'	  , $in_tx_descricao);
				$rs->bindValue(':st_ativo'	  	  , $in_lo_ativo);
				$rs->bindValue(':id_conta_Despesa', $in_id_conta); 
				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#apaga login
		public function desativarConta
		( 	  $in_id_conta
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_conta_Despesa 
							set  st_ativo    = 'N'
							    ,st_excluido = 'S'
						where id_conta_Despesa = :id_conta_Despesa ";

				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_conta_Despesa', $in_id_conta); 

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}


		
	}  
	   
?>