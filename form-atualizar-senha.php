<?PHP
	include("includes/valida_sessao.php");
	include('includes/function.php');
	include('includes/connect.php');
	
	
	$login   		= $_SESSION['sID_LOGIN'];
	$loginNome		= $_SESSION['sTX_LOGIN'];
	$loginTipo   	= $_SESSION['sTX_LOGIN_ADM'];
	$primeiroNome   = $_SESSION['sTX_PRIMEIRO_NOME'];
	$segundoNome    = $_SESSION['sTX_SEGUNDO_NOME'];
	
	$httpRef     = $_SERVER['HTTP_REFERER'];	#isset($_POST['referer']) ? trim($_POST['referer']) : (isset($_SERVER['HTTP_REFERER']) ? base64_encode($_SERVER['HTTP_REFERER']) : false); 	$referrer = strip_tags($_GET['referrer']);							
	$httpRetorno = substr($httpRef,strripos($httpRef,'/')+1);

 
	#Redireciona caso não esteja logado!
	if (!isset($_GET['codigo'])) {
		$loginAtualizacao = $login; 
	}
    else{
        $loginAtualizacao = $_GET["codigo"];
    }	
	
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
                                    <h4 class="page-title">Atualizar Senha</h4>
                                    <ol class="breadcrumb float-right">
                                        <!-- breadcrumb --> 
										<li class="breadcrumb-item"><a href="principal.php">Principal</a></li>                                       
										<li class="breadcrumb-item active">Atualizar Senha</li>									
                                    </ol>									
                                    <div class="clearfix"></div>									
                                </div>
                            </div>
                        </div>
						<!-- conteudo -->
							<div class="row">
								<div class="col-lg-6">
									<div class="card-box">
										<h4 class="m-t-0 header-title"><b><?php  echo $loginNome; ?> </b></h4>										
										<form id="form" method='post' action='' class="form-horizontal" role="form"  data-parsley-validate novalidate>											
											
											<div class="form-group">
												<label for="hori-pass1" class="col-sm-4 control-label">Senha*</label>
												<div class="col-sm-7">
													<input name="edtsenha" id="edtsenha" type="password" placeholder="senha" required class="form-control">
												</div>
											</div>
											
											<div class="form-group">
												<label for="hori-pass2"class="col-sm-4 control-label">Confirmar Senha *</label>
												<div class="col-sm-7">
													<input data-parsley-equalto="#edtsenha" type="password" required placeholder="confirmar senha" class="form-control" id="hori-pass2">
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-4 col-sm-8">
													<button type="submit" class="btn btn-primary waves-effect waves-light">Salvar</button>
													<button type="button" onClick="retornar()" class="btn btn-default waves-effect waves-light m-l-5">Cancel</button>
													<input  type="hidden" id="login"  name="login"  value="<?php echo $loginAtualizacao; ?>" />
												</div>
											</div>
											
										</form>
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

        
		<!-- Parsleyjs -->
        <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley-ptbr.js" charset="utf-8"></script>
			
        <!-- App js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	

        <script type="text/javascript">
			
			$("#form").on('submit', function(e) {
				const $form = $(this);

				e.preventDefault();

				$form.parsley().validate();

				if ($form.parsley().isValid()) {
				  validaForm();
				}
			});
			
			function validaForm(){
				$.ajax({url: 'atualizar-senha.php',
						type:'POST',
						data: $('#form').serialize(),  
						success: function(result){
							if ((result)!=''){ 
								alert(result);
							}else{
								retornar();
							}
						}
				});       
			}
			
			function retornar(){
				<?php echo "location.href = \"$httpRetorno\";" ?>	
			} 	
        
		</script>

    </body>
</html>