<?php

function select_box_simples_sm($sql,$default,$nome,$id,$validade=null,$onchange=NULL)
{ 

	/*realiza a conexão com o banco de dados*/
	include 'includes/connect.php';
	
	#echo $default;

	try{	
		echo "<select name='$nome' id='$id' class='form-control form-control-sm' $validade onchange=\"$onchange\" >";
	   
		echo "<option value=''></option>";
	   
		$rs = $db->prepare($sql);
		
		if($rs->execute()){
			if($rs->rowCount() > 0){
				while($row = $rs->fetch(PDO::FETCH_OBJ)){
					
					$codigo    = $row->codigo;
					$descricao = $row->descricao;
					
					if ($codigo==$default){ 
					   echo "<option selected value='$codigo'>$descricao</option>"; 
					} 
					 else{ 
					   echo "<option value='$codigo'>$descricao</option>"; 
					}#if 
					
				}#while
			}#if       
		}#if 	
	}catch (Exception  $e){
		print $e->getMessage();
		die;
	}

   echo "</select>"; 

};

function select_box_simples($sql,$default,$nome,$id,$validade=null,$onchange=NULL)
{ 

	/*realiza a conexão com o banco de dados*/
	include 'includes/connect.php';
	
	#echo $default;

	try{	
		echo "<select name='$nome' id='$id' class='form-control' $validade onchange=\"$onchange\" >";
	   
		echo "<option value=''></option>";
	   
		$rs = $db->prepare($sql);
		
		if($rs->execute()){
			if($rs->rowCount() > 0){
				while($row = $rs->fetch(PDO::FETCH_OBJ)){
					
					$codigo    = $row->codigo;
					$descricao = $row->descricao;
					
					if ($codigo==$default){ 
					   echo "<option selected value='$codigo'>$descricao</option>"; 
					} 
					 else{ 
					   echo "<option value='$codigo'>$descricao</option>"; 
					}#if 
					
				}#while
			}#if       
		}#if 	
	}catch (Exception  $e){
		print $e->getMessage();
		die;
	}

   echo "</select>"; 

};

function select_box_vazio($nome,$id,$validade=null,$onchange=NULL)
{ 

	echo "<select name='$nome' id='$id' class='form-control' $validade onchange=\"$onchange\" >";
	echo "<option value=''></option>";
	echo "</select>"; 

};


function select_box_value($sql)
{ 

	/*realiza a conexão com o banco de dados*/
	include 'includes/connect.php';
	
	#echo $default;

	try{		   
		echo "<option value=''></option>";
	   
		$rs = $db->prepare($sql);
		
		if($rs->execute()){
			if($rs->rowCount() > 0){
				while($row = $rs->fetch(PDO::FETCH_OBJ)){
					
					$codigo    = $row->codigo;
					$descricao = $row->descricao;
					
					echo "<option value='$codigo'>$descricao</option>"; 
					
				}#while
			}#if       
		}#if 	
	}catch (Exception  $e){
		print $e->getMessage();
		die;
	}


};

function select_2($sql,$default,$nome,$id,$validade=null,$onchange=NULL)
{ 


	/*realiza a conexão com o banco de dados*/
	include 'includes/connect.php';
	
	#echo $default;

	try{	
		echo "<select name='$nome' id='$id' class='form-control select2' $validade onchange=\"$onchange\" >";
	   
		echo "<option value=''></option>";
	   
		$rs = $db->prepare($sql);
		
		if($rs->execute()){
			if($rs->rowCount() > 0){
				while($row = $rs->fetch(PDO::FETCH_OBJ)){
					
					$codigo    = $row->codigo;
					$descricao = $row->descricao;
					$optgroup  = $row->grupo;
					
					if ($codigo==$default){ 
						echo "<optgroup label=\"$optgroup\">";	
						echo "	<option selected value='$codigo'>$descricao</option>";
						echo "</optgroup>";
					} 
					 else{
						echo "<optgroup label=\"$optgroup\">";							 
						echo "	<option value='$codigo'>$descricao</option>"; 
						echo "</optgroup>";
					}#if 
					
				}#while
			}#if       
		}#if 	
	}catch (Exception  $e){
		print $e->getMessage();
		die;
	}

   echo "</select>"; 

};

function select_2_value($sql)
{ 

	/*realiza a conexão com o banco de dados*/
	include 'includes/connect.php';
	
	#echo $default;

	try{	
	   
		echo "<option value=''></option>";
	   
		$rs = $db->prepare($sql);
		
		if($rs->execute()){
			if($rs->rowCount() > 0){
				while($row = $rs->fetch(PDO::FETCH_OBJ)){
					
					$codigo    = $row->codigo;
					$descricao = $row->descricao;
					$optgroup  = $row->grupo;
					
					echo "<optgroup label=\"$optgroup\">";							 
					echo "	<option value='$codigo'>$descricao</option>"; 
					echo "</optgroup>";
					
				}#while
			}#if       
		}#if 	
	}catch (Exception  $e){
		print $e->getMessage();
		die;
	}

};




?>