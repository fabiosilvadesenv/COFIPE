<?PHP
	include("includes/valida_sessao.php");
    include('includes/connect.php');
	include('includes/function.php');
	
	$login   		= $_SESSION['sID_LOGIN'];
	$loginNome		= $_SESSION['sTX_LOGIN'];
	$loginTipo   	= $_SESSION['sTX_LOGIN_ADM'];
	$primeiroNome   = $_SESSION['sTX_PRIMEIRO_NOME'];
	$segundoNome    = $_SESSION['sTX_SEGUNDO_NOME'];


	#recebe mes-ano filtro. Se não houver, pega o mês atual
	if(isset($_GET["mesano"])){
		$mesano	= $_GET["mesano"];
    }else{
        $mesano  = date_format (new DateTime(), 'Ym'); #'202304';# 
    }

	try{
		$sql = "select 	TO_CHAR(lc.dt_data, 'yyyymm') mesano, 
						sd.vl_total_receita, 
						sum(lc.vl_valor) as vl_total_despesa,
						sd.vl_total_receita - sum(lc.vl_valor) as vl_total_diferenca,
						round((sum(lc.vl_valor) / sd.vl_total_receita ) * 100 , 0) as pc_despesa,
						100 - round((sum(lc.vl_valor) / sd.vl_total_receita ) * 100 , 0) as pc_receita
				FROM public.tb_lancamento lc
					left join tb_conta_despesa 			ds on ds.id_conta_despesa = lc.id_conta_despesa 
					left join tb_login 					lg on lg.id_login 		  = lc.id_login
					left join ( select TO_CHAR(rs.dt_data, 'yyyymm') mesano, sum(rs.vl_valor) as vl_total_receita 
								from tb_conta_receita cr
									inner join tb_conta_receita_saldo rs on rs.id_conta_receita = cr.id_conta_receita 
								group by TO_CHAR(rs.dt_data, 'yyyymm') ) sd on sd.mesano = 	TO_CHAR(lc.dt_data, 'yyyymm')
				where TO_CHAR(lc.dt_data, 'yyyymm') = :anomes
				group by TO_CHAR(lc.dt_data, 'yyyymm'), sd.vl_total_receita"; 
					
				$rs = $db->prepare($sql);

				$rs->bindValue(':anomes', $mesano);

				$rs->execute();

                if ($rs->rowCount() ==1) {

                    $row = $rs->fetch(PDO::FETCH_OBJ);
                    $totalReceita   = $row->vl_total_receita;
                    $totalDespesa   = $row->vl_total_despesa;
                    $totalDiferenca = $row->vl_total_diferenca;
                    $pcCredito      = $row->pc_despesa;
                    $pcDebito       = $row->pc_receita;

                }else{
                    $totalReceita   = '0';
                    $totalDespesa   = '0';
                    $totalDiferenca = '0';
                    $pcCredito      = '0';
                    $pcDebito       = '0';
                }																					
		
	}catch (Exception  $e){
		print $e->getMessage();
		#echo "<script language='javascript' type='text/javascript'>alert('Error:#001 - Entre em contato com o administrador.');</script>";
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
  
        <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <script src="assets/js/modernizr.min.js"></script>

        <script src="assets/js/modernizr.min.js"></script>
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

                <!-- ============================================================== -->
                <!-- Button mobile view to collapse sidebar menu -->
                <!-- ============================================================== -->
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

            <!-- ============================================================== -->
            <!-- ========== Left Sidebar Start ========== -->
            <!-- ============================================================== -->
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
                                    <h4 class="page-title">Principal</h4>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
						<!-- conteudo -->

                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-box">
                                        <form  id="form" name="form" method='GET' action='' class="form-horizontal" role="form"  data-parsley-validate novalidate>
                                            <div class="form-group">
                                                <div class="form-group row">
                                                    <label class="col-md-1 control-label" for="ativo"></label>
                                                    <div class="col-sm-6">
                                                        <?php 
                                                            
                                                            select_box_simples("select distinct TO_CHAR(dt_data, 'yyyymm') codigo , TO_CHAR(dt_data, 'mm/yyyy') descricao
                                                                                from tb_lancamento", "$mesano",'mesano','mesano','required');
                                                        ?>
                                                       <!--  <span class="font-13 text-muted">Mes/Ano</span> -->
                                                    </div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Atualizar</button>
                                                </div>	
                                            </div>
                                        </form>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="widget-simple text-center card-box">
                                    <h3 class="text-success counter font-bold mt-0">R$ <span class="counter"><?php  echo $totalReceita; ?></span></h3>
                                    <p class="text-muted mb-0">Total de Receitas</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="widget-simple text-center card-box">
                                    <h3 class="text-pink font-bold mt-0">R$ <span class="counter"><?php  echo $totalDespesa; ?></span></h3>
                                    <p class="text-muted mb-0">Total de Despesas</p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="widget-simple text-center card-box">
                                    <h3 class="text-inverse font-bold mt-0">R$ <span class="counter"><?php  echo $totalDiferenca; ?></span></h3>
                                    <p class="text-muted mb-0">Diferença</p>
                                </div>
                            </div>
                        </div> <!-- primeira linha conteudo -->
                    
                        <div class="row">

                            <div class="col-xl-3">
                                <div class="card-box">
                                    <h4 class="text-dark header-title m-t-0 m-b-30">Resultado</h4>

                                    <div class="widget-chart text-center">
                                        <div id="sparkline3"></div>
                                        <ul class="list-inline m-t-15 mb-0">
                                            <li>
                                                <h5 class="text-muted m-t-20">Crédito(s)</h5>
                                                <h4 class="text-success font-bold mt-0"><?php  echo $totalReceita; ?></h4>
                                            </li>
                                            <li>
                                                <h5 class="text-muted m-t-20">Débito(s)</h5>
                                                <h4 class="text-pink font-bold mt-0"><?php  echo $totalDespesa; ?></h4>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
 
                            <div class="col-xl-9">
                                <div class="card-box">
                                    <table id="responsive-datatable2" name="responsive-datatable2"  class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="10" width="100%">
										<thead>
											<tr>
												<th>Data</th> 
												<th>Conta Receita</th> 
												<th>Conta Despesa</th> 
												<th>Valor</th> 
												<th>Descrição</th>
											</tr>
										</thead>
										<tbody>													
											<?php															
                                                try{
                                                    $sql = "SELECT 	lc.id_lancamento, 
                                                                    lc.id_conta_receita, 
                                                                    rc.tx_nome tx_nome_conta_receita,
                                                                    lc.id_conta_despesa, 
                                                                    ds.tx_nome tx_nome_conta_despesa,
                                                                    lc.id_login, 
                                                                    concat(lg.tx_primeiro_nome,' ',lg.tx_segundo_nome) as tx_login_nome,
                                                                    concat('Código:', lc.id_lancamento , ' na Data: ', lc.dt_data::date , ' R$: ', lc.vl_valor   ) as tx_observacao_informativo,
                                                                    lc.tx_observacao, 
                                                                    dt_data,
                                                                    lc.vl_valor    
                                                            FROM public.tb_lancamento lc
                                                                inner join tb_conta_receita 		rc on rc.id_conta_receita = lc.id_conta_receita
                                                            --	left  join tb_conta_receita_saldo 	sd on sd.id_conta_receita = rc.id_conta_receita 
                                                                inner join tb_conta_despesa 		ds on ds.id_conta_despesa = lc.id_conta_despesa 
                                                                inner join tb_login 				lg on lg.id_login 		  = lc.id_login 
                                                            where TO_CHAR(dt_data, 'yyyymm') = :anomes"; 
                                                                
                                                            $rs = $db->prepare($sql);

                                                            $rs->bindValue(':anomes', $mesano);

                                                            $rs->execute();
                                                    
                                                    #Loop inserir as linhas retornadas banco para tbody datatable.
                                                    if($rs->execute()){
                                                        if($rs->rowCount() > 0){
                                                            while($row = $rs->fetch(PDO::FETCH_OBJ)){														
                                                                #Início bloco linhas tbody datatable.
                                                                echo "<tr>";
                                                                echo "	<td>$row->dt_data</td>";
                                                                echo "	<td>$row->tx_nome_conta_receita</td>";
                                                                echo "	<td>$row->tx_nome_conta_despesa</td>";
                                                                echo "	<td>$row->vl_valor</td>";		
                                                                echo "	<td>$row->tx_observacao</td>";																		
                                                                
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

                        
                        </div> <!-- Segunda linha conteudo -->



                    <!-- fim conteudo -->
                    </div> <!-- end container container-fluid -->
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

        <!-- Custom main Js -->
        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>

        <!-- circliful Chart -->
        <script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

         <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<script src="assets/pages/defaultdatatableinitlistap.js"></script>

        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

		<!-- Parsleyjs -->
        <script type="text/javascript" src="assets/plugins/parsleyjs/dist/parsley.min.js" charset="utf-8"></script>

        <!-- Page js  -->
        <!--<script src="assets/pages/jquery.dashboard.js"></script>-->


        <script type="text/javascript">

            $( document ).ready(function() {

                var DrawSparkline = function() {

                    $('#sparkline3').sparkline([<?php  echo $pcCredito; ?>, <?php  echo $pcDebito; ?>], {
                        type:   'pie',
                        width:  '200',
                        height: '200',
                        offset: -90,
                        sliceColors: ['#FF0000','#008000']
                    });
                };

                DrawSparkline();
            });

			$("#form").on('submit', function(e) {
				const $form = $(this);

				e.preventDefault();

				$form.parsley().validate();

				if ($form.parsley().isValid()) {
				  retornar();
				}
			});
			
			function retornar(){
				location.href = "principal.php?mesano="+$('#mesano').val()
			}

        </script>


    </body>
</html>