<?php
include('sesion_manager.php');
session_start();
if (isset($_SESSION['usuario']) ) { 
    
include('config/config.php');

$mandante=$_SESSION['mandante'];
if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

$contratos=mysqli_query($con,"SELECT * from contratos where estado=1 and contratista='".$_SESSION['contratista']."' ");

$query_cuadrilla=mysqli_query($con,"select t.nombre1, t.apellido1, t.rut, m.razon_social,m.rut_empresa, c.* from cuadrillas as c Left Join mandantes as m On m.id_mandante=c.mandante left join trabajador as t On t.idtrabajador=c.lider left join contratos as o On id_contrato=c.contrato where c.contratista='".$_SESSION['contratista']."'");
$existe=mysqli_num_rows($query_cuadrilla);

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');



?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Crear Cuadrillas</title> 
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">   
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />

    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

  
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>


    $(document).ready(function(){
        $('#menu-cuadrillas').attr('class','active');
        $('.footable').footable();
             
    });

    function selcontrato(nombre_contrato) {
        //alert(nombre_contrato)
        $('#nombre_contrato').val(nombre_contrato);
    }

    function trabajadores(contratista) {
        var cuadrilla=$('#nombre').val();
        var contrato=$('#contrato').val();
       //alert(cuadrilla+' '+contrato)
        if (cuadrilla!='') {
                if (contrato!='0') {                    
                    $('.body').load('selid_trabajadores_cuadrilla.php?contrato='+contrato,function(){  
                        $('#modal_trabajadores_cuadrilla #input_cuadrilla').val(cuadrilla);
                        $('#modal_trabajadores_cuadrilla').modal({show:true})
                    });                    
                } else {
                    swal({
                        title: "Debe seleccionar un Contrato",
                        type: "warning"
                    });        
                }
        } else {
            swal({
                title: "Falta nombre del documento",
                type: "warning"
            });            
        }    
    }

    function listado (cuadrilla,nombre,lider) {
        $('.body').load('selid_lista_cuadrilla.php?cuadrilla='+cuadrilla,function(){              
            $('#modal_lista_cuadrilla #nombre_cuadrilla').html(nombre)
            $('#modal_lista_cuadrilla #lider_cuadrilla').html(lider)
            $('#modal_lista_cuadrilla').modal({show:true})
        });
    }

    
    


    
    function gestionar(contrato,contratista,tipo) {
        //alert(contrato+' '+contratista+' '+tipo)
        $.ajax({
            method: "POST",
            url: "add/gestionar.php",
            data: 'contratista='+contratista+'&tipo='+tipo+'&contrato='+contrato,
            success: function(data){			
                if (tipo==1)  {
                    window.location.href='gestion_doc_extradordinarios_mandante.php';
                }
                if (tipo==2)  {
                    window.location.href='gestion_doc_extradordinarios_mandante_contrato.php';
                }                
            }
        });                             
    }

 





    
</script>

<style>


.texto {
    color:#282828;
}

.loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
}  

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }


@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

</style>

    <script>
        $(document).ready(function () {
            $("#de_contratistas").CreateMultiCheckBox({ width: '230px', defaultText : 'Select Below', height:'250px' });
        });
    </script>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
       <div style="" class="row wrapper white-bg "> 
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"> Crear Cuadrillas <?php #echo $_SESSION['mandante']   ?> </h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="form-group row"> 
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratistas_mandantes.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i>Reporte de Contratistas</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php"><i class="fa fa-chevron-right" aria-hidden="true"></i>Reportes Contratos</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                        </div>
                        <div class="ibox-content">
                            <div class="row form-group" >
                                <div class="col-lg-12"> 
                                    <h3 class="form-label">Crear Nueva Cuadrilla</h3>
                                </div>
                            </div>
                            
                                                
                                <div class="row form-group">
                                  
                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            
                                            <!-- nombre del documento -->            
                                            <div class="row"> 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Nombre</label>                                                            
                                                <div class="col-sm-3">
                                                    <input style="border:1px solid #969696" class="form-control" type="text" name="nombre" id="nombre" placeholder="" onblur="validar(1)"  required="">
                                                </div>
                                            </div>
                                                         
                                          <!-- tipo del documento -->              
                                          </br>
                                          <div class="row"> 
                                                    <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Contratos </label>                                                 
                                                    <div class="col-sm-3">
                                                        <div class="form-wrap">
                                                            <select style="border:1px solid #969696" name="contrato" id="contrato" class="form-control">
                                                                <option value="0" selected="">Seleccione Contrato</option>
                                                                <?php foreach ($contratos as $row) { ?>
                                                                    <option value="<?php echo $row['id_contrato'] ?>" ><?php echo $row['nombre_contrato'] ?></option>    
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>                                                                                               
                                            </div>

                                             <!-- seleccionar trabajadores -->
                                             <div id="div_contratos" style="margin-top:1.5%" class="row">                                                 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Trabajadores</label>                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                   <button class="btn btn-success btn-block" type="button" onclick="trabajadores(<?php echo $_SESSION['contratista'] ?>)">Seleccionar Trabajadores</button>
                                                </div>                                                                                               
                                            </div>

                                              
                                        
                                                   
                                    </div>           
                                    <input type="hidden" name="mandante" id="mandante" value="<?php echo $_SESSION['mandante'] ?>" />                                                                                                              
                                    <input type="hidden" name="nombre_contrato" id="nombre_contrato" />
                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-wrap">
                                                <button name="" id="creardoc" class="btn btn-success btn-md" type="button" onclick="crear_doc()" value="" >Crear Documento</button>
                                            </div>
                                        </div>
                                    </div>-->
                                    
                                    
                                  </div>

                                                                      
                                </div>

                       
                        <hr>             
<!----------------------------------- reporte doc extras ---------------------------------------------------------------------------->                               
                        <div class="row form-group" >
                            <div class="col-lg-12"> 
                                 <h3 class="form-label">Reporte de Cuadrillas</h3>
                            </div>
                        </div>                        
                        <div class="row form-group" >
                           <div class="col-lg-12"> 
                                <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una Cuarilla">
                                <div class="table-responsive">
                                    <table style="width:100%;" class="table footable table-hover" data-page-size="8" data-filter="#filter">
                                       <thead class="cabecera_tabla">
                                            <tr style="font-size: 12px;">
                                                <!--<th style="width: 10%;border-right:1px #fff solid" >Acción</th>--> 
                                                <th style="width: 20%;border-right:1px #fff solid" >Cuadrilla</th>
                                                <th style="width: 20%;border-right:1px #fff solid" >Líder</th>
                                                <th style="width: 20%;border-right:1px #fff solid" >Contrato</th>                                                
                                                <th style="width: 10%;border-right:1px #fff solid" >Mandante</th>
                                                <th style="width: 10%;border-right:1px #fff solid" >Fecha</th>
                                                <th style="width: 10%;border-right:1px #fff solid" >Trabajadores</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($existe>0) {  
                                                foreach ($query_cuadrilla as $row) { 
                                                    
                                                    $fecha=substr($row['creado'],0,10);
                                                    $query_lider=mysqli_query($con,"select nombre1, apellido1, rut from trabajador where idtrabajador='".$row['lider']."' ");    
                                                    $result_lider=mysqli_fetch_array($query_lider);
                                                    $lider=$result_lider['nombre1'].' '.$result_lider['apellido1'].' '.$result_lider['rut'];
                                                    ?>   
                                                    <tr>
                                                        <!--<td style="background:;text-align: center;" ><button style="width:100%; " title="Borrar Cuadrilla" class="btn btn-danger btn-xs" type="button" disabeld ><small>BORRAR</small></button></td>                                                        -->
                                                        <td><?php echo $row['cuadrilla'] ?></td>
                                                        <td><?php echo $lider ?></td>
                                                        <td><?php echo $row['nombre_contrato'] ?></td>                                                        
                                                        <td><?php echo $row['razon_social'] ?></td>
                                                        <td><?php echo $fecha ?></td>
                                                        <td><button onclick="listado(<?php echo $row['id_cuadrilla'] ?>,'<?php echo $row['cuadrilla'] ?>','<?php echo $lider ?>')" class="btn btn-info btn-sm">TRABAJADORES</button></td>
                                                    </tr>


                                            <?php
                                                } 
                                            } else { ?>    
                                                <tr>
                                                    <td colspan="7">NO HAY CUADRILLAS CREADAS</td>
                                                </tr>
                                            <?php
                                            }  ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                            
                            
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
            
            
        
      

        <div class="modal inmodal" id="modal_trabajadores_cuadrilla" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                        <h4  class="modal-title">Seleccionar Trabajadores</h4>
                        <label>Selecciones trabajadores del Contrato</label>
                    </div>                    
                    <input type="hidden" id="input_cuadrilla" name="input_cuadrilla" />
                    <div class="body">                                    
                        
                    </div> 
                </div>
            </div>
        </div>

        <div class="modal inmodal" id="modal_lista_cuadrilla" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                        <h4  class="modal-title">Cuadrilla <span id="nombre_cuadrilla"></span></h4>
                        <label style="font-size:18px">Lider: <span id="lider_cuadrilla"></span> </label>
                    </div>                    
                    <div class="body">                                    
                        
                    </div> 
                </div>
            </div>
        </div>
        
            
            
            
            <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando Cuadrilla, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
            </div>
            
            
        </div>
        <div class="footer">
            <div class="float-right">
                Versi&oacute;n <strong>1.0</strong>.
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

     <!-- FooTable -->
     <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    

</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
