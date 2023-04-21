<?PHP
	include("includes/valida_sessao.php");
	include('includes/connect.php');
	include('includes/function.php');

    if(!isset($_SESSION)){
		session_start(); 
	}

	
	$login   		= $_SESSION['sID_LOGIN'];
	$loginNome		= $_SESSION['sTX_LOGIN'];
	$loginTipo   	= $_SESSION['sTX_LOGIN_ADM'];
	$primeiroNome   = $_SESSION['sTX_PRIMEIRO_NOME'];
	$segundoNome    = $_SESSION['sTX_SEGUNDO_NOME'];
	
	
	/*realiza a conexão com o banco de dados*/
	include('includes/connect.php');
	
	#***************************************************************************************************************
	#*********************************** Início Prilégio ***********************************************************
	#***************************************************************************************************************

    /*Perfil Administrador*/
    if ($loginTipo == 'S') {
        $acaoNovo    = 1;
        $acaoEditar  = 1;
        $acaoExcluir = 1;
    /*Perfil Usuário*/   
    }elseif($loginTipo =='N'){
        $acaoNovo    = 0;
        $acaoEditar  = 0;
        $acaoExcluir = 0;
    }

    #***************************************************************************************************************
	#*********************************** Fim Prilégio **************************************************************
	#***************************************************************************************************************
	 
?> 
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="Controle Financeiro Pessoal">
        <meta name="author" content="fabio.oliveira">

        <link rel="shortcut icon" href="assets/images/cofipe.ico">

        <title>COFIPE</title>

		<!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/modernizr.min.js"></script>

        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" 				rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" 						rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" 						rel="stylesheet" type="text/css">

    </head>

    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="principal.php" class="logo"><i class="fa fa-home"></i> <span>COFIPE</span></a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item notification-list hide-phone">
                            <a class="nav-link waves-light waves-effect" href="#" id="btn-fullscreen">
                                <i class="mdi mdi-crop-free noti-icon"></i>
                            </a>
                        </li>

                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="assets/images/user.png" alt="user" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Bem vindo ! <?php  echo $primeiroNome; ?></small> </h5>
                                </div>

                                <!-- item-->
                                <a href="form-atualizar-senha.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-lock-open"></i> <span>Trocar Senha</span>
                                </a>

                                <!-- item-->
                                <a href="logout.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout"></i> <span>Sair</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="mdi mdi-menu"></i>
                            </button>
                        </li>
                    </ul>

                </nav>

            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="principal.php" class="waves-effect waves-primary">
								<i class="ti-home"></i><span> Principal </span></a>
                            </li>

                            <!--- Monta menu de acordo com o tipo de permissão do usuário no banco de dados -->
                            <?php							
								/*Perfil Administrador*/
								if ($loginTipo == 'S') {
								  include("menu_admin.php");
								/*Perfil Usuário*/   
								}elseif($loginTipo =='N'){
								  include("menu_usuario.php");   
								}								
							?>					
							
                        </ul>

                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Conta(s) Receita(s)</h4>
                                    <ol class="breadcrumb float-right">
                                        <!-- breadcrumb --> 
										<li class="breadcrumb-item"><a href="principal.php">Principal</a></li>                                       
										<li class="breadcrumb-item active">Login</li>									
                                    </ol>
                                    <div class="clearfix"></div>									
                                </div>
                            </div>
                        </div>
						<!-- conteudo -->
						
						<div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
								
                                    <div class="row">
									
										<p class="text-muted font-10 m-b-7">
											<?php if ($acaoNovo == 1){ ?>
												<button class="btn btn-success waves-effect waves-light btn-sm m-b-1" onclick="location.href='form-conta-receita-cadastro.php';"  >
													<i class="fa fa-plus"></i>
													<span>Nova Conta</span>					
												</button>
											<?php } ?>									
										</p>
							
										<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
													<thead>
														<tr>
															<th>Nome</th> 
															<th>Descrição</th> 
															<th>Data Cadastro</th> 
															<th>Ativo</th> 
															<th>Qtde. Lançamento(s)</th> 
															<th>Ação</th>
														</tr>
													</thead>
													<tbody>													
														<?php
															
														try{
															$sql = "SELECT 	cr.id_conta_receita, 
                                                                            cr.tx_nome, 
                                                                            cr.tx_descricao,
                                                                            cr.dt_cadastro, 
                                                                            fnc_dominio_s_n(cr.st_ativo) as st_ativo, 
                                                                            count(lc.id_lancamento) as qt_lancamentos
                                                                    FROM public.tb_conta_receita cr
                                                                        left join tb_lancamento lc on lc.id_conta_receita = cr.id_conta_receita 
                                                                    where st_excluido = 'N'
                                                                    group by cr.id_conta_receita, 
                                                                            cr.tx_nome, 
                                                                            cr.tx_descricao,
                                                                            cr.dt_cadastro, 
                                                                            cr.st_ativo"; 
  																		
																	$rs = $db->prepare($sql);
																	$rs->execute();
															
															#Loop inserir as linhas retornadas banco para tbody datatable.
															if($rs->execute()){
																if($rs->rowCount() > 0){
																	while($row = $rs->fetch(PDO::FETCH_OBJ)){														
																		#Início bloco linhas tbody datatable.
																		echo "<tr>";
																		echo "	<td>$row->tx_nome</td>";
																		echo "	<td>$row->tx_descricao</td>";
																		echo "	<td>$row->dt_cadastro</td>";
																		echo "	<td>$row->st_ativo</td>";
																		echo "	<td>$row->qt_lancamentos</td>";																		
																		echo "	<td class=\"actions\">";
																				if ($acaoEditar == 1){																	
																					echo "		<button title=\"Editar Login!\"	onClick='javascript:editar(\"$row->id_conta_receita\")'	class=\"btn btn-icon waves-effect waves-light btn-warning m-b-1\"> 	<i class=\"fa fa-pencil\"></i> 		</button>";
																				}
																				if ($acaoExcluir == 1){
																					echo "		<button title=\"Excluir Login!\" onClick='javascript:apagar(\"$row->id_conta_receita\",\"$row->tx_nome\")' class=\"btn btn-icon waves-effect waves-light btn-danger m-b-1\"> 	<i class=\"fa fa fa-trash-o\"></i> 	</button>";
																				}	
                                                                                if ($acaoEditar == 1){
																					echo "		<button title=\"Incluir/Editar Saldo!\"	onClick='javascript:saldo(\"$row->id_conta_receita\")'	class=\"btn btn-secondary waves-effect waves-light btn-secondary  m-b-1\"> 	<i class=\"fa fa-money\"></i> 		</button>";
                                                                                }																
																		echo "	</td>";
																		#is_numeric($id)
																		#$parametro = mysql_real_escape_string($_GET['nome']); sha1() 
																		#fim bloco linhas tbody datatable.
																		echo"</tr> ";
																	}
																}       
															}																						
															
														}catch (Exception  $e){
															print $e->getMessage();
															#echo "<script language='javascript' type='text/javascript'>alert('Error:#001 - Entre em contato com o administrador.');</script>";
														}											
														?>
													</tbody>
										</table>

                                    </div>
                                </div>
                            </div>
                        </div>
						
                    </div> <!-- end container -->
                </div><!-- end content -->                

                <footer class="footer">
                    2023 © COFIPE <span class="hide-phone">- Controle Financeiro Pessoal</span>
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

       <script>
            var resizefunc = [];
        </script>

        <!-- Plugins  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script><!-- Popper for Bootstrap -->
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/plugins/switchery/switchery.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<script src="assets/pages/defaultdatatableinitlistap.js"></script>

        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

		<!-- Parsleyjs -->
        <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js" charset="utf-8"></script>

			
        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	

        <script type="text/javascript">
			
			TableManageButtons.init();
			
			function apagar(codigo, nome){
				if (window.confirm('Deseja apagar a conta: "' + nome +'"?')) {  
				  $.ajax({  url: 'conta-receita-cadastro-u.php?act=d&rd='+codigo,
					type:'GET',
						data: $('#form').serialize(),  
						success: function(result){
								if (result!=''){ 
									alert(result);
								}else{
									location.href = "form-conta-receita-lista.php";
								}
						}
					}); 
				}
			}	

			function editar(codigo){
				location.href = 'form-conta-receita-cadastro.php?codigo='+codigo ;
			}
	
            function saldo(codigo){
				location.href = 'form-conta-receita-saldo-lista.php?codigo='+codigo ;
			}
        
		</script>

    </body>
</html>