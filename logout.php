<?php
	#Inicia a Sessão
	session_start(); 
	#Destrói a sessão limpando todos os valores salvos
	session_destroy(); 
	#Redireciona o usuário para a página principal
	header("Location: index.html"); 
	exit; // Redireciona o visitante     
?>