<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
include('sesion_manager.php');
session_start();

if (isset($_SESSION['usuario']) ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

if ($_SESSION['mandante']==0) {
   $razon_social="no se ha seleccionado";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante='".$_SESSION['mandante']."' ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

?>



<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Tareas </title> 

     <!-- Favicons -->
     <link href="assets/img/favicon.png" rel="icon">   
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
    
     <!-- Toastr style -->
    <link href="css\plugins\toastr\toastr.min.css" rel="stylesheet">
   
   <script src="js\jquery-3.1.1.min.js"></script> 

   <style>
       
    </style>

   <script>
   
   $(document).ready(function(){

    $('#menu-tareas').attr('class','active');
                
                $("#cargos").change(function () {
                    
					$("#cargos option:selected").each(function () {
						cargo = $(this).val();
                        if (cargo!=0) {
                            $('.body').load('selid_perfil.php?cargo='+cargo,function(){
                                $('#modal_perfil').modal({show:true});
                            });         
                        }    
					});
				})
                
                $('.footable').footable();
                $('.footable2').footable();
    });
   
   </script>

</head>
<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">REPORTE DE TAREAS <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-content">

                        <?php include('resumen.php') ?>
                           <input style="border:1px #c0c0c0 solid" class="form-control form-control-sm m-b-xs mt-3" id="filter" placeholder="Buscar..."> 
                           <div class="table-responsive">
                            <table style="width:100%;overflow-x: auto;" class="table footable table-hover mt-3" data-page-size="30" data-filter="#filter">
                                
                            
                                <tbody>
                                <?php 
                                
                                    if ($_SESSION['nivel']==3)  {
    
                                        $query_notificaciones=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 order by n.idnoti desc    ");
                                        $result_notificaciones=mysqli_fetch_array($query_notificaciones);
                                    }
                                    
                                    if ($_SESSION['nivel']==2)  {
                                        
                                        $query_notificaciones=mysqli_query($con,"select n.*, m.razon_social as remitente,m.id_mandante from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0  order by n.idnoti desc  ");
                                        $result_notificaciones=mysqli_fetch_array($query_notificaciones);
                                    }
                                
                                
                                    foreach ($query_notificaciones as $row) { 
                                      
                                      if ($row['procesada']==0) { 
                                        if (preg_match("/mobile/i", $useragent) ) { ?>
                                            <tr >
                                                <td style="width:10%">
                                                    <a  style="background:#;padding: 2% 0%;font-size:16px" class="btn btn-xs btn-success block btn-submenu" target="_blank" onclick="atender(<?php echo $row['idnoti'] ?>,'<?php echo $row['url'] ?>',<?php echo $row['tipo'] ?>,'<?php echo $row['item'] ?>',<?php  echo $row['mandante'] ?>,<?php echo $row['contratista'] ?>,<?php echo $row['perfil'] ?>,<?php echo $row['cargo'] ?>,<?php echo $row['contrato'] ?>,<?php echo $row['trabajador'] ?>,'<?php echo $row['control'] ?>')"><b style="color: #fff;">ATENDER</b></a>                                                    
                                                    <?php echo $row['mensaje'] ?>
                                                </td>
                                            </tr>

                                        <?php } else { ?>
                                            <tr >
                                                <td style="width:10%">
                                                    <a  style="background:" class="btn btn-xs btn-success block btn-submenu" target="_blank" onclick="atender(<?php echo $row['idnoti'] ?>,'<?php echo $row['url'] ?>',<?php echo $row['tipo'] ?>,'<?php echo $row['item'] ?>',<?php  echo $row['mandante'] ?>,<?php echo $row['contratista'] ?>,<?php echo $row['perfil'] ?>,<?php echo $row['cargo'] ?>,<?php echo $row['contrato'] ?>,<?php echo $row['trabajador'] ?>,'<?php echo $row['control'] ?>')"><b style="color: #fff;">ATENDER</b></a>
                                                    
                                                </td>
                                                <td  >
                                                    <?php echo $row['mensaje'] ?>
                                                </td>
                                            </tr>
                                <?php   } 
                                     } 
                                   } ?>
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <ul class="pagination float-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                
                                <script>
                                    function atender(id,url,tipo,item,mandante,contratista,perfil,cargo,contrato,trabajador,control) {
                                       //alert(control);
                                        
                                        $.ajax({
                                			method: "POST",
                                            url: "add/atender.php",
                                            data: 'id='+id+'&tipo='+tipo+'&mandante='+mandante+'&contratista='+contratista+'&item='+item+'&perfil='+perfil+'&cargo='+cargo+'&contrato='+contrato+'&trabajador='+trabajador+'&url='+url,
                                			success: function(data){			  
                                             if (data==1) {
                                                    window.location.href=url;
                                			  } else {
                                                 swal("Error", "Vuelva a Intentar.", "error");
                                                 setTimeout(window.location.href='notificaciones.php', 3000);
                                			  }
                                			}                
                                       });
                                        
                                    }
                                
                                </script>
                                
                            </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>    
               
               
           </div>
            
            
            
            <div class="footer">
                <div class="float-right">
                    Versi&oacute;n <strong>1.0</strong>
                </div>
                <div>
                    <strong>Copyright</strong> FacilControl &copy; <?php echo $year ?>
                </div>
            </div>

        </div>
        </div>
        


    <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
      <!-- Peity -->
    <script src="js\plugins\peity\jquery.peity.min.js"></script>

    <!-- Peity demo data -->
    <script src="js\demo\peity-demo.js"></script>




</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
