<?php
include('../config/config.php');
require("lib/FlowApi.class.php");

$params = array(
	#"subscriptionId"=> "sus_jda874dd5b",
	"planId"=> "F-DIARIOCL",
	"limit"=> 100,
	#"status"=> 1,
);
$serviceName = "subscription/list";
$flowApi = new FlowApi;
$response = $flowApi->send($serviceName, $params,"GET");

$dates=$response['data'];

foreach($dates as $date) {
    $consulta=mysqli_query($con,"SELECT * FROM suscripciones WHERE subscriptionId='".$date['subscriptionId']."' ");
    $existe=mysqli_num_rows($consulta);
    if ($existe==0) {
        $params2 = array(
            "subscriptionId"=> $date['subscriptionId'],
            "planId"=> $date['planId'],	
        );
    
        $serviceName2 = "subscription/get";	
        $response2 = $flowApi->send($serviceName2, $params2,"GET");
    
        $query_sus=mysqli_query($con,"INSERT INTO suscripciones (subscriptionId,custorm_id,plan,inicio,fin,periodo_inicio,periodo_fin,proxima_factura,periodo_prueba,prueba_inicio,prueba_fin,cancelar_al_fin_periodo,numero_periodos,dias_hasta_vencimiento,morosidad,idplan,idplannombre,creado,estado) VALUES ('".$date['subscriptionId']."','".$date['customerId']."','Diario','".$date['subscription_start']."','".$date['subscription_end']."','".$date['period_start']."','".$date['period_end']."','".$date['next_invoice_date']."','".$date['trial_period_days']."','".$date['period_start']."','".$date['period_end']."','".$date['cancel_at_period_end']."','".$response2['periods_number']."','".$response2['days_until_due']."','".$date['morose']."','".$date['planId']."','".$date['planExternalId']."','".$date['created']."','".$date['status']."'  ) ");
    }
}

$query=mysqli_query($con,"SELECT s.*, r.nombre,r.metodo, p.monto FROM suscripciones as s LEFT JOIN registro as r ON r.id_custorm=s.custorm_id LEFT JOIN plan_suscripcion as p ON p.plan=s.plan ");

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>PerflopPerfect-Suscripciones</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Plataforma administrativa de PerflopPerfect" name="description">
        <meta content="Coderthemes" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets\images\favicon.ico">

        <!-- Footable css -->
        <link href="assets\libs\footable\footable.core.min.css" rel="stylesheet" type="text/css">

        <!-- App css -->
        <link href="assets\css\bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets\css\icons.min.css" rel="stylesheet" type="text/css">
        <link href="assets\css\app.min.css" rel="stylesheet" type="text/css">

    </head>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include ('header.php') ?>             

            <!-- ========== Left Sidebar Start ========== -->
            <?php include ('nav.php') ?>             

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content"> 

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <!--<div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Minton</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>-->
                                    <h4 class="page-title">Suscripciones</h4>
                                </div>
                            </div>
                        </div>     
                         <!--end page title --> 

                         <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">
                                    <!--<h4 class="header-title">Registros de Clientes</h4>
                                    <p class="sub-header">
                                        Trigger certain FooTable actions.
                                    </p>-->

                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline">
                                                <div class="form-group mr-2">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Mostrar todos</option>
                                                        <option value="pagada">Pagadas</option>
                                                        <option value="vencida">Vencidas</option>
                                                        <option value="por vencer">Por vencer</option>
                                                        <option value="Diario">Diarias</option>
                                                        <option value="Mensual">Mensuales</option>
                                                        <option value="Anual">Anuales</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Buscar" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="25">
                                        <thead style="background-color: #343C49;color: #ffffff">
                                        <tr>
                                            <th style="font-weight:bold !important" data-toggle="true">Suscripcion</th>
                                            <th style="font-weight:bold !important" data-hide="phone">Cliente</th>
                                            <th style="font-weight:bold !important"> Plan </th>                                            
                                            <th style="font-weight:bold !important" data-hide="phone"> Monto </th>
                                            <th style="font-weight:bold !important" data-hide="phone"> Metodo </th>
                                            <th style="font-weight:bold !important" data-hide="phone"> Prox.Factura </th>
                                            <th style="font-weight:bold !important" data-hide="phone"> Estado </th>
                                                                                       

                                            <th data-hide="all"> IdPlan</th>
                                            <th data-hide="all"> Nombre</th>
                                            <th data-hide="all"> Inicio Período</th>
                                            <th data-hide="all"> Fin Período</th>
                                            <th data-hide="all"> Creado</th>
                                        </tr>
                                        </thead>
                                        <tbody style="font-size:14px">
                                            <?php foreach ($query as $row) { 
                                                
                                                ?>                                                                                           
                                                <tr>
                                                    <td><?php echo $row['subscriptionId'] ?></td>
                                                    <td><?php echo $row['nombre'] ?></td>
                                                    <td><?php echo $row['plan'] ?></td>
                                                    <td><?php echo $row['monto'] ?></td>
                                                    <td><?php echo $row['metodo'] ?></td>                                                    
                                                    <td><?php echo $row['proxima_factura'] ?></td>

                                                    <?php   if ($row['estado']==0) { ?>
                                                                <td><span style="font-size:14px" class="badge label-table badge-danger">INACTIVA</span></td>
                                                    <?php }
                                                            if ($row['estado']==1) {  ?>
                                                                <td><span style="font-size:14px" class="badge label-table badge-primary">ACTIVA</span></td>
                                                    <?php } 
                                                            if ($row['estado']==4) {?>
                                                                <td><span style="font-size:14px" class="badge label-table badge-info">CANCELADA</span></td>
                                                    <?php } ?>

                                                    <td><?php echo $row['idplan'] ?></td>
                                                    <td><?php echo $row['idplannombre'] ?></td>
                                                    <td><?php echo substr($row['periodo_inicio'],0,10) ?></td>
                                                    <td><?php echo substr($row['periodo_fin'],0,10) ?></td>                                                                                                        
                                                    <td><?php echo $row['creado'] ?></td>
                                                </tr>
                                            <?php } ?>    
                                        </tbody>
                                        <tfoot>
                                            <tr class="active">
                                                <td colspan="7">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                    </table>
                                </div> <!-- end card-box -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                        

                       

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                               2024 &copy; PerflopPerfect  
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-right footer-links d-none d-sm-block">
                                    <a href="javascript:void(0);">Nosotros</a>
                                    <a href="javascript:void(0);">Ayuda</a>
                                    <a href="javascript:void(0);">Contacto</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="fe-x noti-icon"></i>
                </a>
                <h4 class="m-0 text-white">Settings</h4>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets\images\users\avatar-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">Nik G. Patel</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <ul class="nav nav-pills bg-light nav-justified">
                    <li class="nav-item">
                        <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            General
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                            Chat
                        </a>
                    </li>
                </ul>
                <div class="tab-content pl-3 pr-3">
                    <div class="tab-pane" id="home1">
                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Notifications</h5>
                                <p class="text-muted"><small>Do you need them?</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="tabswitch1">
                                    <label class="custom-control-label" for="tabswitch1"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">API Access</h5>
                                <p class="text-muted"><small>Enable/Disable access</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" checked="" id="tabswitch2">
                                    <label class="custom-control-label" for="tabswitch2"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Auto Updates</h5>
                                <p class="text-muted"><small>Keep up to date</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" id="tabswitch3">
                                    <label class="custom-control-label" for="tabswitch3"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="row mb-2">
                            <div class="col">
                                <h5 class="m-0 font-15">Online Status</h5>
                                <p class="text-muted"><small>Show your status to all</small></p>
                            </div> <!-- end col-->
                            <div class="col-auto">
                                <div class="custom-control custom-switch mb-2">
                                    <input type="checkbox" class="custom-control-input" checked="" id="tabswitch4">
                                    <label class="custom-control-label" for="tabswitch4"></label>
                                </div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="alert alert-success alert-dismissible fade mt-3 show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">�</span>
                            </button>
                            <h5>Unlimited Access</h5>
                            Upgrade to plan to get access to unlimited reports
                            <br>
                            <a href="javascript: void(0);" class="btn btn-outline-success mt-3 btn-sm">Upgrade<i class="ml-1 mdi mdi-arrow-right"></i></a>
                        </div>
                
                    </div>
                    <div class="tab-pane show active" id="messages1">
                        <div>
                            <div class="inbox-widget">
                                <h5 class="mt-0">Recent</h5>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-2.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-3.jpg" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-4.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                </div>
        
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-5.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-6.jpg" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>

                                <hr>
                                <h5>Favorite <span class="float-right badge badge-pill badge-danger">18</span></h5>
                                <hr>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-7.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kennith</a></p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-3.jpg" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-10.jpg" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kimberling</a></p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                </div>
        
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-4.jpg" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                </div>
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets\images\users\avatar-9.jpg" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                                    <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Leonareade</a></p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                </div>

                                <div class="text-center mt-2">
                                    <a href="javascript:void(0);" class="text-muted"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                                </div>

                            </div> <!-- end inbox-widget -->
                        </div> <!-- end .p-3-->
                    </div>
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets\js\vendor.min.js"></script>

        <script src="assets\libs\jquery-knob\jquery.knob.min.js"></script>
        <script src="assets\libs\peity\jquery.peity.min.js"></script>

        <!-- Sparkline charts -->
        <script src="assets\libs\jquery-sparkline\jquery.sparkline.min.js"></script>

        <!-- init js -->
        <script src="assets\js\pages\dashboard-1.init.js"></script>

        <!-- App js -->
        <script src="assets\js\app.min.js"></script>

        <!-- Footable js -->
        <script src="assets\libs\footable\footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets\js\pages\foo-tables.init.js"></script>
        
    </body>
</html>