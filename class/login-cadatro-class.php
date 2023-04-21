<?php
	include("includes/valida_sessao.php");

	class dml_tbl_login {
	 		
		#cadastra login
		public function cadastrarLogin
		( 	  $in_tx_primeiro_nome 	
			, $in_tx_segundo_nome 	
			, $in_tx_login 			
			, $in_tx_senha
			, $in_tx_login_tipo  			
			, $in_lo_ativo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "INSERT INTO 
						tb_login (
							tx_primeiro_nome, 
							tx_segundo_nome, 
							tx_login, 
							tx_senha, 
							st_administrador, 
							st_ativo )
						VALUES (
							:tx_primeiro_nome, 
							:tx_segundo_nome, 
							:tx_login, 
							md5(:tx_senha), 
							:st_administrador, 
							:st_ativo);";
				
				$rs = $db->prepare($sql);
				
				$rs->bindValue(':tx_primeiro_nome'	, $in_tx_primeiro_nome);
				$rs->bindValue(':tx_segundo_nome'	, $in_tx_segundo_nome);
				$rs->bindValue(':tx_login'			, $in_tx_login);
				$rs->bindValue(':tx_senha'			, $in_tx_senha);
				$rs->bindValue(':st_administrador'	, $in_tx_login_tipo);
				$rs->bindValue(':st_ativo'			, $in_lo_ativo);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#atualiza login
		public function atualizarLogin
		( 	  $in_id_login
			, $in_tx_primeiro_nome 	
			, $in_tx_segundo_nome 	
			, $in_tx_login 			
			, $in_tx_senha
			, $in_tx_login_tipo  			
			, $in_lo_ativo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_login 
							set  tx_primeiro_nome = :tx_primeiro_nome
								,tx_segundo_nome  = :tx_segundo_nome
								,tx_login 		  = :tx_login
								,tx_senha 		  = :tx_senha
								,st_administrador = :st_administrador
								,st_ativo 		  = :st_ativo
						where id_login = :id_login ";

				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_login'			, $in_id_login); 
				$rs->bindValue(':tx_primeiro_nome'	, $in_tx_primeiro_nome);
				$rs->bindValue(':tx_segundo_nome'	, $in_tx_segundo_nome);
				$rs->bindValue(':tx_login'			, $in_tx_login);
				$rs->bindValue(':tx_senha'			, $in_tx_senha);
				$rs->bindValue(':st_administrador'	, $in_tx_login_tipo);
				$rs->bindValue(':st_ativo'			, $in_lo_ativo);

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}

		#apaga login
		public function desativarLogin
		( 	  $in_id_login
			, $in_lo_ativo
		){		
			#Obj conexão
			include('includes/connect.php');
			#
			try{			
				$sql = "update tb_login 
							set  st_ativo    = 'N'
							    ,st_excluido = 'S'
						where id_login = :id_login ";

				$rs = $db->prepare($sql);
				
				$rs->bindValue(':id_login', $in_id_login); 

				$rs->execute();  
			
			}catch(PDOException $e){
				#echo "Erro:#001 - Entre em contato com o administrador.";
				echo 'Error: ' . $e->getMessage();
			}
			
		}


		
	}  
	   
?>