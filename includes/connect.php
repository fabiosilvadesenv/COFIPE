<?php
	include_once 'includes/config.php';
	
	try{
		$cnxHost     = VG_HOST;
		$cnxDatabase = VG_DATABASE;
		$cnxUser 	 = VG_USER;
		$cnxPassword = VG_PASSWORD;
		$cnxSchema   = VG_SCHEMA;
		
		$db = new PDO("pgsql:host=$cnxHost dbname=$cnxDatabase user=$cnxUser password=$cnxPassword");
		
		#A instância do PDO está configurada para que o tratamento de erros seja feito através de exceptions (PDO::ATTR_ERRMODE =  PDO::ERRMODE_EXCEPTION)
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		#$this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
		
		/*seta o schema*/
		$comm = $db->prepare("SET SEARCH_PATH TO $cnxSchema");
		$comm->execute();
		/*Seta o tipo encoding*/
		$comm = $db->prepare("SET client_encoding = 'UTF8' ");
		$comm->execute();
	}catch (Exception  $e){
		print $e->getMessage();
	}

/*
****$conex = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'usuario', 'senha');
try {
   #codigo#
} catch (PDOException $e) {
    // Entrará aqui caso ocorra algum erro de query
} catch (UserAlreadyExistsException $e) {
   // Entrará aqui caso já exista algum usuário criado com o login "teste"
} catch (Exception $e) {
   // Entrará aqui caso seja lançada qualquer outra Exception
}
	try{

	}catch (Exception  $e){
		echo "<script language='javascript' type='text/javascript'>alert('Error:#001 - Entre em contato com o administrador.'); window.location.href='index.html';</script>";
		#print $e->getMessage();
		die;
	}

*/

?>