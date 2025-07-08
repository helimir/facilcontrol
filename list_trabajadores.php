<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

$mandante=$_SESSION['mandante'];
if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');



$contratistas=mysqli_query($con,"SELECT id_contratista from contratistas where rut='".$_SESSION['usuario']."' ");
$fcontratista=mysqli_fetch_array($contratistas);
$contratista=$_SESSION['contratista'];

$sql_contratos=mysqli_query($con,"select * from contratos where contratista='".$fcontratista['id_contratista']."' ");

if ($_SESSION['nivel']==3) {
    $qtrabajador="select t.* , r.Region, c.Comuna, b.banco, f.afp, s.institucion 
    from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna
    LEFT JOIN bancos b ON b.idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud 
    LEFT JOIN contratistas o On o.id_contratista=t.contratista
    where t.contratista='".$fcontratista['id_contratista']."' and t.eliminar=0  order by t.idtrabajador";
    $ftrabajador=mysqli_query($con,$qtrabajador);
    
}
if ($_SESSION['nivel']==1) {
  $qtrabajador="select i.razon_social, t.estado, t.turno, t.idtrabajador, t.tipocuenta, t.cuenta, t.dia, t.mes, t.ano, t.idtrabajador, t.nombre1,t.nombre2,t.apellido1,t.apellido2,t.rut,t.direccion1,t.direccion2,t.telefono,t.email,t.fnacimiento,t.estadocivil,t.licencia,t.tipolicencia, r.Region, c.Comuna,  b.banco, f.afp, s.institucion 
    from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna
    LEFT JOIN bancos b ON b.idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud 
    where t.estado=1 and t.eliminar=0  order by t.idtrabajador";
    $ftrabajador=mysqli_query($con,$qtrabajador);
} 
  

?>

<!DOCTYPE html>
<html>
<html translate="no">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Reporte Trabajadores </title> 
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">

    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
   
   
   <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    
    <script src="js\jquery-3.1.1.min.js"></script>
    
    
<style>

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
 
</head>


    
  

<script>


$(document).ready(function() {

    $('#menu-trabajadores').attr('class','active');
    $('.footable').footable();
    $('.footable2').footable();
               


});

    function editar(idtrabajador,editar) {
        $.ajax({
			method: "POST",
            url: "sesion/sesion_trabajador.php",
			data:'id='+idtrabajador+'&editar='+editar,
			success: function(data){
			    
               window.location.href='edit_trabajador.php';
			}
            
            
       });
    }
    
   function cargar_desvincular(){ 
               //alert('o');
               var rut=$('#rut_desvincular').val();
               var trabajador=$('#trabajador_desvincular').val();
               var tipo=$('#tipo_desvincular').val();
               //alert(comentarios);
               var fileInput = document.getElementById('archivo_desvincular');
               var filePath = fileInput.files.length;
               if (filePath>0) {
                   var filePath = fileInput.value;
                   //var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   var allowedExtensions =/(.pdf)$/i;
                   if(!allowedExtensions.exec(filePath)){
                        swal({
                            title: "Tipo No Permitido",
                            text: "Solo documentos PDF",
                            type: "warning"
                        });
                        return false;
                   } else {   
                       
                        var formData = new FormData();
                        var files= $('#archivo_desvincular')[0].files[0];
                                           
                        formData.append('archivo_desvincular',files);
                        formData.append('rut',rut);                   
                        formData.append('trabajador',trabajador);
                        formData.append('tipo', tipo);
                        alert(tipo+' '+trabajador+' '+rut)
                        $.ajax({
                                url: 'cargar/cargar_desvincular.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function(){
                                        $('#modal_cargar').modal('show');						
                 			    },
                                success: function(response) {
                                    if (response==0) {
                                        $('#modal_cargar').modal('hide');
                                        swal({
                                                title: "Desvinculacion Enviada",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                        });
                                        if (tipo==1) {
                        	                 window.location.href='list_trabajadores.php';
                                        } else {
                                             window.location.href='trabajadores_asignados_contratista.php';
                                         }
                                    } else {
                                        $('#modal_cargar').modal('hide');
                                        if (response==2) {
                                             swal({
                                                title: "Sin Documento",
                                                text: "Debe seleccionar un archivo",
                                                type: "warning"
                                            });
                                        } else {
                                            swal({
                                                title: "Documeto No Cargado",
                                                text: "Vuelva a intetar",
                                                type: "error"
                                            });
                                        }    
                                    }     
                                },
                        			complete:function(data){
                                         $('#modal_cargar').modal('hide');
                                    }, 
                                    error: function(data){
                                        $('#modal_cargar').modal('hide');
                                    }
                        });
                    } 
               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF",
                        type: "warning"
                    });
               }     
                    
    }
    
 
   

</script>

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
             <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Reporte Trabajadores <?php #echo $_SESSION['contratista']  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                       <div class="ibox-title">
                             
                                <div class="row"> 
                                    <div class="col-12 col-sm-offset-2">
                                        <a style="background:#217346;border:1px  #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_trabajadores.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Trabajadores</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="crear_trabajador.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Trabajador</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                    </div>                           
                                </div>
                                <?php include('resumen.php') ?>
                                <!--
                                    <div style="margin-top:2%" class="row"> 
                                        <div class="col-12 col-sm-offset-2">
                                        
                                        <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">	
                                            <div class="col-12">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Seleccionar Archivo</span>
                                                    <span class="fileinput-exists">Cambiar</span><input type="file" name="file" accept="application/csv" /></span>
                                                    <span class="fileinput-filename"></span>
                                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">x</a>
                                                </div> 
                                                <button type="submit" class="btn btn-warning btn-sm" name="import_data"><i class="fa fa-upload" aria-hidden="true"></i> Importar</button>
                                                <a style="background: #217346;color:#fff" type="type" class="btn btn- btn-sm" href="doc/archivo_trabajadores.csv" target="_blank" ><i class="fa fa-file" aria-hidden="true"></i> Descargar Archivo Base</a>
                                            </div>                                        
                                                <input type="hidden" name="contratista" value="<?php echo $fcontratista['id_contratista'] ?>" />
                                        </form>
                                    </div> 
                                    </div>-->
                            
                          
                         
                        </div>
                        
                        
                        
                        <div class="ibox-content">
                        
                             
                          <?php 
                          
########################### si contratista 
                           if ($_SESSION['nivel']==3) { ?>  
                            
                           
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un trabajador">
                            <br>
                            <table style="width: 100%;" class="footable table table-responsive" data-page-size="25" data-filter="#filter">
                               <thead class="cabecera_tabla">
                                <tr style="font-size: 12px;">
                                    <th style="width: 3%;border-right:1px #fff solid"></th>
                                    <th style="width: 7%;text-align: center;border-right:1px #fff solid;" >Editar</th>                                                
                                    <th style="width: 7%;text-align: center;border-right:1px #fff solid;" >&nbsp;&nbsp;Docs&nbsp;&nbsp;</th>
                                    <th style="width: 7%;text-align: center;border-right:1px #fff solid;font-size:10px" >Bajar</th>
                                    <th style="width: 15%;border-right:1px #fff solid" >Nombres</th>
                                    <th style="width: 15%;border-right:1px #fff solid" >Apellidos</th>
                                    <th  data-hide="phone,table" style="width: 10%;border-right:1px #fff solid" >RUT</th>
                                    <th data-hide="phone,table" style="width: 10%;border-right:1px #fff solid" >Telefono</th>
                                    
                                    
                                    
                                    <th data-hide="all">Turno</th>
                                    <th data-hide="all">Email</th>
                                    <th data-hide="all" >Fecha Nac</th>
                                    <th data-hide="all">Estado Civil</th>                                    
                                    <th data-hide="all">Cargo</th>
                                    <th data-hide="all">Licencia</th>
                                    <th data-hide="all" >Direccion</th>
                                    <th data-hide="all" >Regi&oacute;n</th>
                                    <th data-hide="all" >Comuna</th>
                                    <th data-hide="all" >Banco</th>
                                    <th data-hide="all" >Cuenta</th>
                                    <th data-hide="all" >Tipo</th>
                                    <th data-hide="all" >AFP</th>
                                    <th data-hide="all" >Salud</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php // echo '<td data-toggle="true"></td>';
                                  $condicion="trabajadores";
                                  foreach ($ftrabajador as $row){  
                                    
                                    switch ($row['mes']) {
                                    case 1: $mes="Enero";break;
                                    case 2: $mes="Febrero";break;
                                    case 3: $mes="Marzo";break;
                                    case 4: $mes="Abril";break;
                                    case 5: $mes="Mayo";break;
                                    case 6: $mes="Junio";break;
                                    case 7: $mes="Julio";break;
                                    case 8: $mes="Agosto";break;
                                    case 9: $mes="Septiembre";break;
                                    case 10: $mes="Octubre";break;
                                    case 11: $mes="Noviembre";break;
                                    case 12: $mes="Diciembre";break;  
                                    }
                                    
                                    $query_desvilcular=mysqli_query($con,"select * from desvinculaciones where trabajador='".$row['idtrabajador']."' and verificado=0 and tipo=1 ");
                                    $result_desvincular=mysqli_fetch_array($query_desvilcular);
                                    
                                
                                ?> 
                                <tr>
                                     
                                     <!-- toggle-->   
                                     <td  data-toggle="true"></td>

                                     <?php if ($row['estado']==0) { ?>
                                            
                                            <!-- acciones si estado de trabajaro es 0  -->
                                            <td style="background: ;text-align: center;"><button title="Editar Trabajador" class="btn btn-xs btn-success btn-block" name="editar" id="editar" onclick="editar('<?php echo $row['idtrabajador']?>',1)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td> 
                                            <td style="background: ;text-align: center;"><button title="Documentos" class="btn btn-xs btn-primary btn-block" name="editar" id="editar" onclick="editar('<?php echo $row['idtrabajador']?>',2)" ><i class="fa fa-archive" aria-hidden="true"></i></button></td>                                           
                                            
                                       <?php } else { ?>
                                       
                                            <!-- acciones  -->
                                            <td style="background: ;text-align: center;"><button title="Editar Trabajador" class="btn btn-xs btn-default btn-block" name="editar" id="editar" disabled="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td> 
                                            <td style="background: ;text-align: center;"><button title="Documentos" class="btn btn-xs btn-default btn-block" name="editar" id="editar" disabled="" ><i class="fa fa-archive" aria-hidden="true"></i></button></td>
                                            <!--<td style="background: ;text-align: center;"><button title="Desvincular" class="btn btn-xs btn-danger btn-block" name="desvincular" id="desvincular" onclick="desvincular('<?php echo $row['idtrabajador']?>',1)" ><i class="fa fa-sign-out" aria-hidden="true"></i> </button></td>-->
                                       <?php }   

                                        $rut=$row['rut'];
                                        $dir='doc/trabajadores/'.$contratista.'/'.$rut.'/';
                                        
                                        $carpeta = @scandir($dir);

                                        if (count($carpeta) > 2) { ?>
                                            <td style="text-align: center;"><button style="background:#282828;border:1px #282828 solid;color:#fff;" title="Descargar Documentos" class="btn btn-xs btn-default btn-block" name="Descargar" id="Descargar" onclick="descargar('<?php echo $rut ?>',<?php echo $contratista ?>)" ><i class="fa fa-download" aria-hidden="true"></i></button></td>    
                                        <?php
                                        } else { ?>
                                            <td style="text-align: center;"><button style="background:#282828;border:1px #282828 solid;color:#fff;" title="Descargar Documentos" class="btn btn-xs btn-default btn-block" name="Descargar" id="Descargar" disabled ><i class="fa fa-download" aria-hidden="true"></i></button></td>    
                                        <?php 
                                        } ?>

                                        <!-- nombres  -->
                                        <td><?php echo $row['nombre1']." ".$row['nombre2'] ?></td>
                                        
                                        <!-- apellidos -->
                                        <td><?php echo $row['apellido1']." ".$row['apellido2']  ?></td>
                                        
                                        <!-- rut  -->
                                        <td><?php echo $row['rut'] ?></td>
                                        
                                        <!-- fono  -->
                                        <td><?php echo $row['telefono'] ?></td>
                                                                                
                                      
                                    
                                    <td><?php echo $row['turno'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $row['dia']." ".$mes." ".$row['ano'] ?></td>
                                    <td><?php echo $row['estadocivil'] ?></td>
                                    <td><?php echo  utf8_encode($row['cargo'])." - Tipo: ".$row['tipocargo'] ?></td>
                                    <?php if ($row['licencia']=="NO") {  ?>
                                        <td><?php echo $row['licencia'] ?></td>
                                    <?php } else {  ?>    
                                         <td><?php echo $row['tipolicencia'] ?></td>
                                    <?php }  ?>
                                    
                                    <td><?php echo $row['direccion1']." ".$row['direccion2'] ?></td>                                    
                                    <td><?php echo utf8_encode($row['Region']) ?></td>
                                    <td><?php echo utf8_encode($row['Comuna']) ?></td>                                   
                                    <td><?php echo utf8_encode($row['banco']) ?></td>
                                    <td><?php echo utf8_encode($row['cuenta']) ?></td>
                                    <td><?php echo utf8_encode($row['tipocuenta']) ?></td>
                                    <td><?php echo utf8_encode($row['afp']) ?></td>
                                    <td><?php echo utf8_encode($row['institucion']) ?></td>
                                    
                                    
                                                                        
                                </tr>
                               <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                            
                            <script>
                                 function desvincular(rut,trabajador,tipo) {                                      
                                      $('#modal_desvincular input[name=rut]').val(rut);
                                      $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                      $('#modal_desvincular input[name=tipo]').val(tipo);
                                      $('#modal_desvincular').modal({show:true});
                                  } 
                            </script> 
                         <!-- NIVEL 1 --->
                         <?php } 
                         
############################  si es admin
                         if ($_SESSION['nivel']==1) { ?> 
                            
                             <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Mandante">
                             
                             <div class="table-responsive">   
                                    <table class="table footable" data-page-size="10" data-filter="#filter">
                                       <thead>
                                        <tr>
                                            <th style="width: 3%;"><i style="font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></th>
                                            <th style="width: 4%;">Estado</th>
                                            <th style="width: 5%;" >ID</th>
                                            <th style="width: 15%;" >Nombres</th>
                                            <th style="width: 15%;" >Apellidos</th>
                                            <th  data-hide="phone,table" style="width: 10%;" >RUT</th>
                                            <th data-hide="phone,table" style="width: 10%;" >Telefono</th>
                                            <th style="width: 15%;">Contratista</th>
                                            <th style="width: 15%;">Acciones</th>
                                            <!--<th data-hide="phone" style="width: ;" >Tipo</th>-->
                                            
                                            
                                            <th data-hide="all">Turno</th>
                                            <th data-hide="all">Email</th>
                                            <th data-hide="all" >Fecha Nac</th>
                                            <th data-hide="all">Estado Civil</th>                                    
                                            <th data-hide="all">Cargo</th>
                                            <th data-hide="all">Licencia</th>
                                            <th data-hide="all" >Direccion</th>
                                            <th data-hide="all" >Regi&oacute;n</th>
                                            <th data-hide="all" >Comuna</th>
                                            <th data-hide="all" >Banco</th>
                                            <th data-hide="all" >Cuenta</th>
                                            <th data-hide="all" >Tipo</th>
                                            <th data-hide="all" >AFP</th>
                                            <th data-hide="all" >Salud</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php // echo '<td data-toggle="true"></td>';
                                          $condicion=3;
                                          foreach ($ftrabajador as $row){  
                                            
                                            switch ($row['mes']) {
                                            case 1: $mes="Enero";break;
                                            case 2: $mes="Febrero";break;
                                            case 3: $mes="Marzo";break;
                                            case 4: $mes="Abril";break;
                                            case 5: $mes="Mayo";break;
                                            case 6: $mes="Junio";break;
                                            case 7: $mes="Julio";break;
                                            case 8: $mes="Agosto";break;
                                            case 9: $mes="Septiembre";break;
                                            case 10: $mes="Octubre";break;
                                            case 11: $mes="Noviembre";break;
                                            case 12: $mes="Diciembre";break;  
                                            }
                                        
                                        ?> 
                                        <tr>
                                        
                                             <td data-toggle="true"></td>
                                             
                                               <?php if ($row['estado']==1) { ?>
                                                    <td><button onclick="accion(0,<?php echo $row['idtrabajador'] ?>,4)" title="Habilitada"><i style="font-size:25px" class="fa fa-toggle-on" aria-hidden="true"></i></button>
                                                    <button onclick="eliminar('<?php echo $row['idtrabajador'] ?>','<?php echo $condicion ?>')" title="Eliminar" type="button" ><i style="font-size:25px" class="fa fa-trash" aria-hidden="true"></i></button></td>
                                               <?php } else { ?>
                                                    <td><button onclick="accion(1,<?php echo $row['idtrabajador'] ?>,4)" title="Deshabilitada"><i style="font-size:25px"  class="fa fa-toggle-off" aria-hidden="true"></i></button>
                                                    <button onclick="eliminar('<?php echo $row['idtrabajador'] ?>','<?php echo $condicion ?>')" title="Eliminar" type="button" ><i style="font-size:25px" class="fa fa-trash" aria-hidden="true"></i></button></td>
                                               <?php }  ?>
                                            <td><?php echo $row['idtrabajador'] ?></td>
                                            <td><?php echo $row['nombre1']." ".$row['nombre2'] ?></td>
                                            <td><?php echo $row['apellido1']." ".$row['apellido2']  ?></td>
                                            <td><?php echo $row['rut'] ?></td>
                                            <td><?php echo $row['telefono'] ?></td>
                                            <td><?php echo $row['razon_social'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button title="Editar" class="btn-success btn btn-xs" name="editar" id="editar" onclick="editar(<?php echo $row['idtrabajador']  ?>)" >Editar/Documentos</button>
                                                    <!--<button title="Constancias" class="btn-info btn btn-md" name="constancia" id="constancia" onclick="constancia(<?php echo $row['idtrabajador']  ?>)" >Documentos</button>-->
                                                </div>
                                            </td>
                                            <!--<td><?php echo $row['tipocargo'] ?></td>-->
                                            
                                            
                                            <td><?php echo $row['turno'] ?></td>
                                            <td><?php echo $row['email'] ?></td>
                                            <td><?php echo $row['dia']." ".$mes." ".$row['ano'] ?></td>
                                            <td><?php echo $row['estadocivil'] ?></td>
                                            <td><?php echo  utf8_encode($row['cargo'])." - Tipo: ".$row['tipocargo'] ?></td>
                                            <?php if ($row['licencia']=="NO") {  ?>
                                                <td><?php echo $row['licencia'] ?></td>
                                            <?php } else {  ?>    
                                                 <td><?php echo $row['tipolicencia'] ?></td>
                                            <?php }  ?>
                                            
                                            <td><?php echo $row['direccion1']." ".$row['direccion2'] ?></td>                                    
                                            <td><?php echo utf8_encode($row['Region']) ?></td>
                                            <td><?php echo utf8_encode($row['Comuna']) ?></td>                                   
                                            <td><?php echo utf8_encode($row['banco']) ?></td>
                                            <td><?php echo utf8_encode($row['cuenta']) ?></td>
                                            <td><?php echo utf8_encode($row['tipocuenta']) ?></td>
                                            <td><?php echo utf8_encode($row['afp']) ?></td>
                                            <td><?php echo utf8_encode($row['institucion']) ?></td>
                                            
                                            
                                                                                
                                        </tr>
                                       <?php } ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="9">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                               
                                
                         <?php } ?>
                          
                        </div>
                      </div>
                   </div>
               </div>
               
               
           </div>
           
                   
                    
                           <!-- MODAL desvincular -->
                            <div class="modal fade" id="modal_desvincular" tabindex="-1" role="dialog" aria-hidden="true">
                            <?php  session_start(); ?>
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Desvincular Trabajador de la Contratista  </h3>
                                      <!--<button style="color: #FFFFFF;" type="button" class="close" onclick="window.location.href='list_trabajadores.php'" ><span aria-hidden="true">x</span></button>-->
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">x</span></button>
                                    </div>
                                     <div class="body">
                                       
                                        <div class="modal-body"> 

                                            <form  method="post" name="frmDesvincular" id="frmDesvincular" enctype="multipart/form-data" >    
                                             <div class="modal-body">
                                                <div class="row">                                                  
                                                  <div class="form-group col-12">
                                                    <div style="display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background:#282828; color: #fff;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                            <span  class="fileinput-exists">Cambiar</span>
                                                            <input class="form-control" accept="application/pdf"   type="file" id="archivo_desvincular" name="archivo_desvincular" accept="pdf" />
                                                        </span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                  </div>   
                                                </div>
                                                
                                                <!--<div class="row">
                                                  <div class="form-group col-12">
                                                        <textarea rows="4" class="form-control" name="obs_desvincular" id="obs_desvincular" placeholder="Observaciones (opcional)"></textarea>
                                                  </div>   
                                                </div>-->
                                                
                                                                                               
                                               </div>                      
                                               <div class="modal-footer">
                                                        <button class="btn btn-success btn-xs" type="button" onclick="cargar_desvincular()" ><i class="fa fa-upload"></i> Enviar Desvinculacion</button>  
                                                        <button class="btn btn-danger btn-xs" title="Cerrar Ventana" class="close" data-dismiss="modal" aria-label="Close"  ><i class="fa fa-window-close" ></i> Cancelar </button>
                                               </div> 
                                              
                                               <input type="hidden" name="trabajador" id="trabajador_desvincular" />
                                               <input type="hidden" name="tipo" id="tipo_desvincular" />
                                               <input type="hidden" name="rut" id="rut_desvincular" />
                                              
                                            </form>
                                        </div>
                                   </div>
                                </div>
                             </div>
                           </div>
                           
                           <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Enviando desvinculaci&oacute;n, por favor espere un momento</h3>
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
    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
     <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

     <!-- DROPZONE -->
     <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>

    
        <script>

function descargar (rut,contratista) {
    $.ajax({
        method: "POST",
        url: "add/descargar_trabajador.php",
        data: 'rut='+rut,
        success: function(data){			  
            if (data==0) {
                var url='doc/trabajadores/'+contratista+'/'+rut+'/zip/documentos_trabajador_'+contratista+'_'+rut+'.zip';    
                window.open(url, 'Download');
        	} else {
                swal("Disculpe", "Error de Sistema. Vuelva a Intentar.", "error");
        	}
        }                
    });
}


                                        
function refresh_asignar(){
  window.location.href='list_trabajadores.php';
}   
         
           


function refresh(){
    window.location.href='list_trabajadores.php';
}

function eliminar(id){
           //alert(id+' '+condicion);
     var condicion='trabajadores';  
            swal({
            title: "Confirmar Eliminar Trabajador",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Eliminar",
            cancelButtonText: "No, Eliminar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/eliminar.php",
                    data: 'id='+id+'&condicion='+condicion,
        			success: function(data){			  
                     if (data==0) {
                         swal({
                                title: "Trabajador Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_trabajadores.php', 3000);
        			  } else {
                         swal("Cancelado", "Trabajador No Eliminado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
}


function accion(valor,id,accion){
        //alert(id);
        if (valor===0) {
            swal({
            title: "Confirmar deshabilitar Trabajador",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Deshabilitar!",
            cancelButtonText: "No, Deshabilitar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Trabajador Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Trabajador No Deshabilitado. Vuelva a Intentar.", "error");
                         setTimeout(refresh, 1000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Trabajador",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Habilitar!",
            cancelButtonText: "No, Habilitar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Trabajador Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Trabajador No Hbilitado. Vuelva a Intentar.", "error");
                         setTimeout(refresh, 1000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}



</script>



</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
