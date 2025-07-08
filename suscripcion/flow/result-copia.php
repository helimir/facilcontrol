<?php
session_start(); 
include('config.php');
require(__DIR__ . "/lib/FlowApi.class.php");
$error=FALSE;


date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$query_cliente=mysqli_query($con,"select * from clientes where id_cliente='".$_GET['cliente']."' ");
$result_cliente=mysqli_fetch_array($query_cliente);

$query_ingresos=mysqli_query($con,"select * from ingresos where cliente='".$_GET['cliente']."' ");
$result_ingresos=mysqli_fetch_array($query_ingresos);

$query_resd_edad=mysqli_query($con,"select * from residencia_edad where cliente='".$_GET['cliente']."' ");
$result_resd_edad=mysqli_fetch_array($query_resd_edad);

$query_servicios=mysqli_query($con,"select * from servicios where cliente='".$_GET['cliente']."' ");
$result_servicios=mysqli_fetch_array($query_servicios);

$query_educacion=mysqli_query($con,"select * from educacion where cliente='".$_GET['cliente']."' ");
$result_educacion=mysqli_fetch_array($query_educacion);

$query_salud=mysqli_query($con,"select * from salud where cliente='".$_GET['cliente']."' ");
$result_salud=mysqli_fetch_array($query_salud);

$query_recreacion=mysqli_query($con,"select * from recreacion where cliente='".$_GET['cliente']."' ");
$result_recreacion=mysqli_fetch_array($query_recreacion);

$query_vestuario=mysqli_query($con,"select * from vestuario where cliente='".$_GET['cliente']."' ");
$result_vestuario=mysqli_fetch_array($query_vestuario);


$sueldo_minimo=460000;
$monto=350;

if ($result_ingresos['arriendo']==0) {
    $arriendo=0;    
} else {
    $arriendo=$result_ingresos['arriendo']/$result_ingresos['total_personas'];    
}

if ($result_servicios['gastos_comunes']==0) {
    $gastos_comunes=0;
} else {
    $gastos_comunes=$result_servicios['gastos_comunes']/$result_ingresos['total_personas'];
}


# alimentacion
if ($result_servicios['supermercado']==0) {
    $supermercado=0;
} else {
    $supermercado=$result_servicios['supermercado']/$result_ingresos['total_personas'];
}

if ($result_servicios['ferias']==0) {
    $ferias=0;
} else {
    $ferias=$result_servicios['ferias']/$result_ingresos['total_personas'];
}

if ($result_servicios['almacen']==0) {
    $almacen=0;
} else {
    $almacen=$result_servicios['almacen']/$result_ingresos['total_personas'];
}

# servicios
if ($result_servicios['electricidad']==0) {
    $electricidad=0;
} else {
    $electricidad=$result_servicios['electricidad']/$result_ingresos['total_personas'];
}

if ($result_servicios['agua']==0) {
    $agua=0;
} else {
    $agua=$result_servicios['agua']/$result_ingresos['total_personas'];
}

if ($result_servicios['internet']==0) {
    $internet=0;
} else {
    $internet=$result_servicios['internet']/$result_ingresos['total_personas'];
}

if ($result_servicios['celular']==0) {
    $celular=0;
} else {
    $celular=$result_servicios['celular']/($result_ingresos['total_hijos']+1);
}

if ($result_servicios['tv']==0) {
    $tv=0;
} else {
    $tv=$result_servicios['tv']/$result_ingresos['total_personas'];
}
if ($result_servicios['calefaccion']==0) {
    $calefaccion=0;
} else {
    $calefaccion=$result_servicios['calefaccion']/$result_ingresos['total_personas'];
}
if ($result_servicios['gas']==0) {
    $gas=0;
} else {
    $gas=$result_servicios['gas']/$result_ingresos['total_personas'];
}


# cuidados
if ($result_servicios['asesora']==0) {
    $asesora=0;
} else {
    $asesora=$result_servicios['asesora']/$result_ingresos['total_personas'];
}
if ($result_servicios['cuidadora']==0) {
    $cuidadora=0;
} else {
    $cuidadora=$result_servicios['cuidadora'];
}

#educacion
# hijo 1
if ($result_educacion['matricula_anual_1']==0) {
    $matricula_1=0;
} else {
    $matricula_1=$result_educacion['matricula_anual_1']/12;
}
if ($result_educacion['cuota_jardin_1']=='0') {
    $cuota_jardin_1=0;
 } else {
    $cuota_jardin_1=$result_educacion['cuota_jardin_1'];
 }
 if ($result_educacion['cuota_escuela_1']=='0') {
    $escuela_1=0;
 } else {
    $escuela_1=$result_educacion['cuota_escuela_1'];
 }
 if ($result_educacion['cuota_univ_1']=='0') {
    $univ_1=0;
 } else {
    $univ_1=$result_educacion['cuota_univ_1'];
 }

if ($result_educacion['material_1']==0) {
    $material_1=0;
} else {
    $material_1=$result_educacion['material_1']/12;
}

if ($result_educacion['uniforme_1']==0) {
    $uniforme_1=0;
} else {
    $uniforme_1=$result_educacion['uniforme_1']/12;
}

if ($result_educacion['transporte_escolar_1']==0) {
    $transporte_escolar_1=0;
} else {
    $transporte_escolar_1=$result_educacion['transporte_escolar_1'];
}

if ($result_educacion['activ_extra_1']==0) {
    $activ_extra_1=0;
} else {
    $activ_extra_1=$result_educacion['activ_extra_1'];
}

#vestuario
if ($result_vestuario['ropa_1']==0) {
    $ropa_1=0;
} else {
    $ropa_1=$result_vestuario['ropa_1']/12;
}

if ($result_vestuario['zapatos_1']==0) {
    $zapatos_1=0;
} else {
    $zapatos_1=$result_vestuario['zapatos_1']/12;
}


#salud
if ($result_salud['cotizacion_salud_padre']==0) {
    $cotizacion_salud_padre=0;
} else {
    $cotizacion_salud_padre=$result_salud['cotizacion_salud_padre'];
}
if ($result_salud['cotizacion_salud_madre']==0) {
    $cotizacion_salud_madre=0;
} else {
    $cotizacion_salud_madre=$result_salud['cotizacion_salud_madre'];
}
if ($result_salud['seguro_complementario_1']==0) {
    $seguro_complementario_1=0;
} else {
    $seguro_complementario_1=$result_salud['seguro_complementario_1'];
}
if ($result_salud['medicamentos_1']==0) {
    $medicamentos_1=0;
} else {
    $medicamentos_1=$result_salud['medicamentos_1'];
}

 

 # recreacion
 if ($result_recreacion['pasajes_1']==0) {
    $pasajes_1=0;
 } else {
    $pasajes_1=$result_recreacion['pasajes_1'];
 }
 if ($result_recreacion['entradas_1']==0) {
    $entradas_1=0;
 } else {
    $entradas_1=$result_recreacion['entradas_1'];
 }
 if ($result_recreacion['colaciones_1']==0) {
    $colaciones_1=0;    
 } else {
    $colaciones_1=$result_recreacion['colaciones_1'];
 }
 if ($result_recreacion['vacaciones_1']==0) {
    $vacaciones_1=0;    
 } else {
    $vacaciones_1=$result_recreacion['vacaciones_1']/12;
 }



$salario_padre=$result_ingresos['sueldo_padre']+$result_ingresos['otros_ingresos_padre']+$result_ingresos['bonos_padre'];
$salario_madre=$result_ingresos['sueldo_madre']+$result_ingresos['otros_ingresos_madre']+$result_ingresos['bonos_madre'];


$ingresos_padre=$result_ingresos['sueldo_padre']+$result_ingresos['bonos_padre']+$result_ingresos['otros_ingresos_padre'];
$ingresos_madre=$result_ingresos['sueldo_madre']+$result_ingresos['bonos_madre']+$result_ingresos['otros_ingresos_madre'];
$ingresos_total=$ingresos_padre+$ingresos_madre;


?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mediacion&Abogados | Form Process</title>

    <link href="..\inspina\css\bootstrap.min.css" rel="stylesheet">
    <link href="..\inspina\font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="..\inspina\css\animate.css" rel="stylesheet">
    <link href="..\inspina\css\style.css" rel="stylesheet">

      <!-- Sweet Alert -->
      <link href="..\inspina\css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

   

   

  <style>
    .borde {
        border:1px solid;
        color: #C0C0C0;
    }

    .texto {
        color: #282828;
    }

  </style>

</head>

<body class="top-navigation">

    <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
            <div style="background:#000935;padding:1%" class="row border-bottom white-bg">
                    <a href="../index.php" style="background:#E1AF12;border:1px #E1AF12;color:#282828;font-weight:800" class="btn btn-default"><i class="fa fa-home" aria-hidden="true"></i> Madiacion&Abogados <?php ?></a> 
            </div>
        <div class="wrapper wrapper-content">
            <div class="container">

                <div class="row campo">

                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="ibox-content">
                                  


                                 <div style="margin-top:2%" class="form-group row"> 
                                        <div style="background:#D3D5DE;border-bottom:2px #000935 solid" class="col-sm-12">
                                            <h4 style="font-size: 16px;color:#000935"><strong><i class="fa fa-user-circle" aria-hidden="true"></i> Informaci&oacute;n del Cliente <?php  ?> </strong></h4>
                                        </div>        
                                    </div>

                                    <div class="row">
                                            <label style="font-size: 16px;font-weight:700" class="col-sm-1 col-form-label texto"> Cliente:</label>
                                            <label style="font-size: 16px;font-weight:700" class="col-sm-2 col-form-label texto "><?php echo $result_cliente['nombre'] ?></label>                                            
                                    </div>
                                    <div class="row">
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-1 col-form-label texto"> RUT:</label>
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-2 col-form-label texto "><?php echo $result_cliente['rut'] ?></label>                                            
                                    </div>
                                    <div class="row">
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-1 col-form-label texto"> Email:</label>
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-2 col-form-label texto "><?php echo $result_cliente['email'] ?></label>                                            
                                    </div>
                                    <div class="row">
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-1 col-form-label texto"> Telefono:</label>
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-3 col-form-label texto "><?php echo $result_cliente['fono'] ?></label>                                            
                                    </div>
                                    <div class="row">
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-1 col-form-label texto"> Usuario:</label>
                                            <label style="font-size: 14px;font-weight:700" class="col-sm-2 col-form-label texto "><?php echo $result_cliente['tipo'] ?></label>                                            
                                    </div>
                                    <br> 
                                    <?php 

                                        include('informe_seccion_consideraciones_generales.php');

                                         switch ($_SESSION['resd_hijo_1']) { 
                                                case 'Madre':$mensaje='el padre debe';break;
                                                case 'Padre':$mensaje='la Madre debe';break;
                                                case 'Otro':$mensaje='los Padres deben';break;
                                         } ?>
                                       
                                        <?php include('informe_seccion_ingresos.php') ?>
                                        <?php include('informe_seccion_arriendo.php') ?>
                                        <?php include('informe_seccion_servicios.php') ?>
                                        <?php include('informe_seccion_alimentacion.php') ?>    
                                        <?php include('informe_seccion_salud.php') ?> 
                                        <?php include('informe_seccion_educacion.php') ?> 
                                        <?php include('informe_seccion_vestuario.php') ?>
                                        <?php include('informe_seccion_recreacion.php') ?>
                                        <?php include('informe_seccion_cuidados.php') ?>
                                        <?php include('informe_seccion_gastos.php') ?>
    

                                    <hr>
                                    <div style="margin-top: 1%"  class="form-group  row">
                                        <div class="col-sm-4"></div> 
                                        <div class="col-sm-4">
                                            <a style="font-size:18px;padding:2%" class="btn btn-success btn-sm btn-block" href="informe_pdf.php" target="_BLACK" ><i class="fa fa-pdf" aria-hidden="true"></i> Descargar en PDF</a>                                                
                                        </div>                        
                                        <div class="col-sm-4"></div>          
                                    </div>   
                                    
                                    <div class="row text-center">
                                        <div class="col-sm-12">
                                            <h3><a href="index.php"><u><i class="fa fa-home" aria-hidden="true"></i> Madiacion&Abogados</a></u></h3>
                                        </div>
                                    </div>
<hr>                
                            

                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
        <!--</from>-->

        </div>
        <div class="footer">
            <div class="float-left">
               <strong>Mediacion&Abogados</strong>.
            </div>
            <div>
                <!--<strong>Copyright</strong> Example Company &copy; 2014-2018-->
            </div>
        </div>

    </div>
</div>


    <!-- Mainly scripts -->
    <script src="..\inspina\js\jquery-3.1.1.min.js"></script>
    <script src="..\inspina\js\popper.min.js"></script>
    <script src="..\inspina\js\bootstrap.js"></script>
    <script src="..\inspina\js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="..\inspina\js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="..\inspina\js\inspinia.js"></script>
    <script src="..\inspina\js\plugins\pace\pace.min.js"></script>

    <!-- Sweet alert -->
    <script src="..\inspina\js\plugins\sweetalert\sweetalert.min.js"></script>

    <!-- ChartJS-->
    <script src="..\inspina\js\plugins\chartJs\Chart.min.js"></script>

    


    <script>


function regresar() {         
    window.location.href='../index.php';
}    

    </script>

</body>

</html>