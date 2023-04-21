<?php
	if(!isset($_SESSION)){ 
		session_start();
	}
	
	// Verifica se houve POST e se o usuário ou a senha não estão vazios
	if (!empty($_POST) AND (empty($_POST['login']) OR empty($_POST['senha']))) {
		header("Location: index.html"); 
		exit;
    }      
		 
    /*realiza a conexão com o banco de dados*/
	include('includes/connect.php');
	
    $login   = $_POST['login'];
    $senha   = $_POST['senha'];
      
    # Query validando no banco de dados os dados de usuário/senha digitados

	try{
		$sql = "select	lg.id_login,
						lg.st_administrador,
						lg.tx_primeiro_nome,
						lg.tx_segundo_nome,
						lg.tx_login
				from tb_login lg
				where lg.tx_login = :login 
				and   lg.tx_senha = md5(:senha) 
				and   lg.st_ativo = 'S' ";

		
		$rs = $db->prepare($sql);
		
		$rs->bindValue(':login', $login);
		$rs->bindValue(':senha', $senha);

		$rs->execute();
	
	}catch (Exception  $e){
		echo "<script language='javascript' type='text/javascript'>alert('Erro:#001 - Entre em contato com o administrador.'); window.location.href='index.html';</script>";
		#print $e->getMessage();
		die;
	}
	
	
	if ($rs->rowCount() !=1) {
		echo "<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos'); window.location.href='index.html';</script>";
        die;
    }else{
	
		$row = $rs->fetch(PDO::FETCH_OBJ);
		
		$_SESSION['sID_LOGIN']         	= $row->id_login;
		$_SESSION['sTX_LOGIN_ADM']    	= $row->st_administrador;
		$_SESSION['sTX_PRIMEIRO_NOME'] 	= $row->tx_primeiro_nome;
		$_SESSION['sTX_SEGUNDO_NOME']  	= $row->tx_segundo_nome;
		$_SESSION['sTX_LOGIN']     	   	= $row->tx_login;
		
		
		$tokenSession1 = 'token1:'.$_SERVER['REMOTE_ADDR'];
		$tokenSession2 = 'token2:'.$_SERVER['HTTP_USER_AGENT'] ;
		
		$_SESSION['idSESSION'] = md5( $tokenSession1 . $tokenSession2 );
		
		header("Location: principal.php"); 
	
	}

     	 
?>









