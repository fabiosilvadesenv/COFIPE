<?php
	include_once("includes/valida_sessao.php");
	/*realiza a conexão com o banco de dados*/

	class Login {
		public function atualizarLogin($sq_login, $tx_senha){
			#Obj conexão
			include('includes/connect.php');	
			#
			try{			
				$sql = "UPDATE tb_login 
						SET 
						   tx_senha 	= md5(:tx_senha)
						  ,dt_alteracao = now()
						where id_login  = :id_login";
				
				$isql = $db->prepare($sql);
				
				$isql->bindValue(':id_login', $sq_login);
				$isql->bindValue(':tx_senha', $tx_senha);

				$isql->execute();  
			
			}catch (Exception $e){
				echo "Erro:#001 - Entre em contato com o administrador.";
				#print $e->getMessage();
			}
		} 		
		
	}  
	   
?>