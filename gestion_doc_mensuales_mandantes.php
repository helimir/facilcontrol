<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==2  ) { 
include('config/config.php');


$_SESSION['active']="list_contratistas";

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$year=date('Y');

$mandante=$_SESSION['mandante'];

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Gestión Documentos Mensuales</title>
    <link href="assets/img/favicon.png" rel="icon">   
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />

    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script> 

    <script src="js\jquery-3.1.1.min.js"></script> 

 

    
<script>

$(document).ready(function(){
        $('#menu-doc-mensuales').attr('class','active');       
             
    });

function selcontratista(id,id2) {
    var contrato=$('#contrato').val();
    if (id!="") {
        contratista=id;
    } else {
        contratista=id2;
    }
   //alert(contrato);
        $.post("sel_contratistas_dm.php", { idcontratista: contratista,contrato:contrato }, function(data){
            $("#contrato").html(data);
        }); 
    if (id==0) {
        window.location.href='gestion_doc_mensuales_mandantes.php'; 
    }    
}

function selcontrato(contrato){
    
    var contratista=$('#contratista').val();
    $.post("sesion/contrato_acreditados_dm.php", { contrato:contrato}, function(data){
        window.location.href='gestion_doc_mensuales_mandantes.php';
    }); 
   }

function selcontratistass(id){
    //alert(id); 
    if (id==0) {
        swal({
            title: "Selecciona una Contratista a consultar",
            //text: "Un Documento no validado esta sin comentario",
            type: "warning"
         });  
    } else {
        $.post("sesion/contratista_dm.php", { id: id }, function(data){
            window.location.href='gestion_doc_mensuales_mandantes.php';
        }); 
    }    
} 

function selcontratoss(id){    
    $.post("sesion/contrato_dm.php", { id: id }, function(data){
            window.location.href='gestion_doc_mensuales_mandantes.php';
    }); 
} 

 function deshabilitar(i) {
        var isChecked = $('#verificar_doc'+i).prop('checked');
        if  (isChecked) {
             //document.getElementById("mensaje"+i).value ="";
            //document.getElementById("mensaje"+i).disabled = true;
             $("#mensaje"+i).attr("readonly","readonly");
        } else {
            //document.getElementById("mensaje"+i).disabled = false;
            $("#mensaje"+i).removeAttr("readonly");
        }    
 }
 
function deshabilitar_m(i) {
        var isChecked = $('#verificar_doc_m'+i).prop('checked');
        if  (isChecked) {
             $("#mensaje_m"+i).attr("readonly","readonly");
        } else {
            $("#mensaje_m"+i).removeAttr("readonly");
        }    
 }
       
 function enviar(total) {
        var control=$('#control').val();
        var arreglo_veri=[]; // verificados
        var arreglo_obs=[]; // observaciones
        var arreglo_doc=[]; // id documentos
        var arreglo_id_mensual=[]; // id documentos mensuales
        var arreglo_id_trabajador=[]; // id trabajadores
        var arreglo_mes=[]; // mes
        var falta_revisar=false;
        var no_chequeado=0;
        var mensaje=0;
        
        for (i=0;i<=total-1;i++) {
            //si verificado esta seleccionado
            var isChecked = $('#verificar_doc'+i).prop('checked');
            if (isChecked) {
                var valor_veri=document.getElementById("verificar_doc"+i).value = "1";
                var valor_obs=$('#mensaje'+i).val();
                arreglo_veri.push(valor_veri);
                arreglo_obs.push(valor_obs);
                
                var valor_doc=$('#doc'+i).val();
                arreglo_doc.push(valor_doc); 
                
                if (valor_obs!='') {
                    mensaje++;
                }
            } else {
                var valor_veri=document.getElementById("verificar_doc"+i).value = "0";
                var valor_obs=$('#mensaje'+i).val();
                var isDisabled = $('#verificar_doc'+i).prop('disabled');
                //if (valor==0 && valor2=="" && isDisabled==false) {
                if (valor_veri==0) {
                    var falta_revisar=true;
                }
                var valor_doc=$('#doc'+i).val();
                arreglo_doc.push(valor_doc); 
                
                arreglo_veri.push(valor_veri);
                arreglo_obs.push(valor_obs);
            
                no_chequeado++;
                
                if (valor_obs!='') {
                    mensaje++;
                }
            }
            var valor_id_mensual=$('#id_mensual'+i).val();
            arreglo_id_mensual.push(valor_id_mensual); 

            var valor_id_trabajador=$('#id_trabajador'+i).val();
            arreglo_id_trabajador.push(valor_id_trabajador); 

            var valor_mes=$('#id_mes'+i).val();
            arreglo_mes.push(valor_mes); 

        }
        //alert(arreglo_mes);
        if (no_chequeado==total && mensaje==0) { 
            swal({ 
                title:"Seleccionar al menos un Documentos o Enviar una nueva Observacion.",
                //text: "Debe selecionar al menos un documento",
                type: "warning"
            });          
        
        } else {    
               var existe_acreditado=false;
               var existe_sin_obs=false;
               for (i=0;i<=total-1;i++) {
                    //si verificado esta seleccionado
                    var isChecked = $('#verificar_doc'+i).prop('checked');
                    if (isChecked) {
                        var v1=document.getElementById("verificar_doc"+i).value = "1";
                        var v2=$('#mensaje'+i).val();
                        if (v2=='Acreditado') {
                           existe_acreditado=true; 
                        }
                        
                    } else {
                        var v1=document.getElementById("verificar_doc"+i).value = "0";
                        var v2=$('#mensaje'+i).val();
                        if (v2=='') {
                           existe_sin_obs=true; 
                        }
                    }
                } 
                
                if (existe_acreditado && existe_sin_obs ) {
                    swal({ 
                        title:"Seleccionar al menos un Documentos o Enviar una nueva Observacion.",
                        //text: "Debe selecionar al menos un documento",
                        type: "warning"
                    }); 
                
                } else {    
                    
                        var formData = new FormData();  
                                 
                        var json_veri=JSON.stringify(arreglo_veri);
                        formData.append('verificado', json_veri );
                        
                        var json_obs=JSON.stringify(arreglo_obs);
                        formData.append('obs', json_obs );
                        
                        var json_doc=JSON.stringify(arreglo_doc);
                        formData.append('doc', json_doc );
                        
                        var json_id_mensual=JSON.stringify(arreglo_id_mensual);
                        formData.append('id_mensual', json_id_mensual );

                        var json_id_trabajador=JSON.stringify(arreglo_id_trabajador);
                        formData.append('id_trabajador', json_id_trabajador);

                        var json_mes=JSON.stringify(arreglo_mes);
                        formData.append('mes', json_mes);
                        
                        //alert(json_id_trabajador)
                        $.ajax({
              			    method: "POST",
                            url: "enviar_observacion_doc_mensual.php", 
                 		    type: 'post',
                            data:formData,
                            contentType: false,
                            processData: false,
                  			success: function(data) {                        
                                 //alert(data);
                                 //$('#modal_cargar_procesar').modal('hide');
                                 if (data==0) {
                                        swal({
                                            title: "Documentos Procesados.",
                                            //text: "Documentos sin validar",
                                            type: "warning"
                                        });
                                        window.location.href='gestion_doc_mensuales_mandantes.php';           
                                 }
                                 if (data==3) {
                                        swal({
                                            title: "Documentos Procesados.",
                                            //text: "Documentos sin validar",
                                            type: "warning"
                                        });
                                        window.location.href='gestion_doc_mensuales_mandantes.php';           
                                 } 
                                 if (data==1) {
                                      swal({ 
                                            title: "Error de Sistema",
                                            text: "Por favor Vuelva a intentar",
                                            type: "error"
                                       });
                                 }
                                 if (data==2) {
                                        swal({
                                            title: "Observacion Enviada.",
                                            //text: "Documentos sin validar",
                                            type: "success"
                                        });
                                        window.location.href='gestion_doc_mensuales_mandantes.php';           
                                 }
                             }
                        });
                        
               }     
          } 
   }
      
    
      
   function poner_cero(id){
      $("#verificar_doc"+id).prop('checked', true);
      document.getElementById("verificar_doc"+id).value = "0";
      
   }      
   

    function crear_doc_mensual(cant) {
    
    var contador=0;
    for (i=0;i<=cant-1;i++) {
        var seleccionado=document.getElementById('doc_mensuales_dm'+i);
        if (seleccionado.checked) {
           contador++;
        };
    }

    if(contador==0){
            swal({
                title: "Lista Vacia",
                text: "Debe seleccionar al menos un documento",
                type: "warning"
            });   
        
        
    } else {   
                                                                 
                    var valores=$('#frmMensualDoc').serialize();
                    $.ajax({
                        method: "POST",
                        url: "add/addmensual.php",
                        data: valores,
                        beforeSend: function(data){
                            $('#modal_cargar_procesar').modal('show');
          			    },
             			success: function(data){			  
                            if (data==4) {                        
                                swal({
                                    title: "Documentos Mensual Actualizado",
                                    //text: "You clicked the button!", 
                                    type: "success"
                                });
                                window.location.href='gestion_doc_mensuales_mandantes.php';;
                            }                                                                                                                                                    
                            if (data==1) { 
                                swal("Error de Sistema", "Solicitud no procesada. Vuelva a Intentar.", "error");                            
                            }
             			},
                         complete:function(data){
                            $('#modal_cargar_procesar').modal('hide');
                            
                        }, 
                        error: function(data){
                            alert('error');
                            $('#modal_cargar_procesar').modal('hide');
                        }                
                    }); 
        }
 };

</script>

   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 12px;
        	height: 12px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 12px;
        	height: 12px;
        	margin: 0.5em 0.5em 0 0;
        }
        
        input[type=checkbox]
        {
          /* Doble-tama�o Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari y Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
        .checkboxtexto
        {
          /* Checkbox texto */
          font-size: 80%;
          display: inline;
        }
        
.loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 10px;
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

.hijo {
  width: 50px;
  height: 50px;
  background-color: red;
  /* centrar vertical y horizontalmente */
  position: absolute;
  top: 50%;
  left: 50%;
  margin: -25px 0 0 -25px; /* aplicar a top y al margen izquierdo un valor negativo para completar el centrado del elemento hijo */
}
    
    </style>

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Documentos Mensuales <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
        
        
               
               
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                         <div class="ibox-title">
                             <div class="form-group row">
                               <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                       <a class="btn btn-sm btn-success btn-submenu" href="crear_doc_extra.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Documento Extraordinario</a>
                                       <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                       
                                 </div>
                              </div>    
                              <?php include('resumen.php') ?>
                                   
                        </div>   
                        
                        
                        <div class="ibox-content">

                        <div class="row">             
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;"  class="col-2 col-form-label"><b>Contratistas </b></label>
                                                <div class="col-sm-6">
                                                    <select name="contratista" id="contratista" class="form-control" onchange="selcontratista(this.value,<?php echo $_SESSION['contratista'] ?>)">
                                                        <?php                                                
                                                        
                                                        if ($_SESSION['contratista']=="" or $_SESSION['contratista']==0) {
                                                            echo '<option value="0" selected="" >Todas las Contratista</option>';
                                                            $contratistas2=mysqli_query($con,"SELECT c.* from contratistas as c Left Join contratistas_mandantes as m On m.contratista=c.id_contratista  where m.mandante='".$_SESSION['mandante']."'  ");
                                                            foreach ($contratistas2 as $row) {
                                                                echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                            }

                                                        } else {
                                                            

                                                            $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c  Left join contratistas_mandantes as a On a.contratista=c.id_contratista where a.mandante='".$_SESSION['mandante']."'  ");
                                                            
                                                            $query=mysqli_query($con,"select * from contratistas where id_contratista='".$_SESSION['contratista']."' ");
                                                            $result=mysqli_fetch_array($query);
                                                            echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                            #echo '<option value="0" >Todas las contratistas</option>';
                                                        }    
                                                        
                                                        foreach ($contratistas as $row) {
                                                           echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                        }  
                                                             
                                                          ?>                                           
                                                    </select>
                                               </div> 
                                            </div> 
                                             
                                           <div class="row">                                         
                                              <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929"  class="col-2 col-form-label"><b>Contratos </b></label>
                                             <div class="col-sm-6">   
                                                <select name="contrato" id="contrato" class="form-control" onchange="selcontrato(this.value)">
                                                    <?php
                                                        if ($_SESSION['contratista']=="" or $_SESSION['contratista']==0) {
                                                    ?>
                                                                <option value="0" selected="" >Todos los Contrato</option>;
                                                    <?php
                                                        } else {
                                                                $query_con=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista']."' and mandante='".$_SESSION['mandante']."' and id_contrato='".$_SESSION['contrato']."'  ");
                                                                $result_con=mysqli_fetch_array($query_con);
                                                                $hay_contratos=mysqli_num_rows($query_con);
                                                      
                                                                if ($_SESSION['contrato']!=0) {
                                                                    echo '<option value="'.$result_con['id_contrato'].'" select="" >'.$result_con['nombre_contrato'].'</option>';
                                                                    $query_con2=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista']."' and mandante='".$_SESSION['mandante']."' and id_contrato!='".$_SESSION['contrato']."'  ");    
                                                                    foreach ($query_con2 as $row) {                                                        
                                                                        echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                    
                                                                    }
                                                                } else {
                                                                    if ($_SESSION['sincontrato']!=0) {
                                                                        echo '<option value="0" select="" >Seleccionar contrato</option>';
                                                                        $query_con2=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista']."' and mandante='".$_SESSION['mandante']."' and id_contrato!='".$_SESSION['contrato']."'  ");    
                                                                        foreach ($query_con2 as $row) {                                                        
                                                                            echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                        
                                                                        }
                                                                    } else {
                                                                        echo '<option value="0" select="" >Sin contratos</option>';
                                                                    }    
                                                                }           
                                                    }
                                                    ?>

                                                </select>
                                             </div>
                                    
                                            </div>                      
                                <div style="margin-top:2%" class="row">                            
                                    <div class="col-12">
                                        
                                    <?php
                                        if ($_SESSION['contratista']!="" and $_SESSION['contrato']!="") {
                                    ?>
                                        <div class="ibox">
                                            <div style="background:#e9eafb;color:#282828" class="ibox-title">
                                                <h5>Listado de Documentos Mensuales</h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="background:" class="ibox-content">
                                                    <table class="table">
                                                        <tbody>
                                                        <?php 
                                                                # seleccionar documentos de mensuales mientras su estado no sea inactivo
                                                                $query_dm=mysqli_query($con,"select * from mensuales where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' and contrato='".$_SESSION['contrato']."' and estado!='2' ");
                                                                $result_dm=mysqli_fetch_array($query_dm);
                                                                $existe_dm=mysqli_num_rows($query_dm);

                                                                $lista=unserialize($result_dm['documentos']);
                                                                $cantidad_dm=count($lista);
                                                                $i=0;
                                                                for ($i=0;$i<=$cantidad_dm-1;$i++) {
                                                                    $query_dm2=mysqli_query($con,"select documento from doc_mensuales where id_dm='".$lista[$i]."' and estado='0' ");
                                                                    $result_dm2=mysqli_fetch_array($query_dm2);
                                                                    $item=$i+1;
                                                                    if ($existe_dm!=0) {    
                                                            ?>
                                                                        <tr style="border-bottom:1px #eee solid">
                                                                            <td style="border-bottom:1px #eee solid;width:5%" ><?php echo $item ?></td>
                                                                            <td style="border-bottom:1px #eee solid;width:95%" ><?php echo $result_dm2['documento']; ?></td>
                                                                        </tr>
                                                            <?php
                                                                    } else { ?>
                                                                        <tr style="border-bottom:1px #eee solid">
                                                                            <td style="border-bottom:1px #eee solid;width:5%" >Sin documentos</td>
                                                                        </tr>                

                                                            <?php   }
                                                                }
                                                            ?>    
                                                        </tbody>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-12">       
                                                             <?php
                                                                if ($existe_dm!=0) {
                                                             ?>
                                                                    <button class="btn btn-md btn-success" onclick="modal_mensual(<?php echo $_SESSION['contratista'] ?>,<?php echo $_SESSION['mandante'] ?>,3,<?php echo $_SESSION['contrato'] ?>,'<?php echo $result['razon_social'] ?>','<?php echo $result_con['nombre_contrato'] ?>')">Editar Solicitud</button>       
                                                             <?php
                                                                } else {
                                                             ?>
                                                                    <button class="btn btn-md btn-success" disabled="">Editar Solicitud</button>       
                                                             <?php
                                                                } 
                                                             ?>       

                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    <?php
                                    }                                    
                                    ?>



                                    </div>                   
                                </div> 
                                 <div style="margin-top: ;" class="row"> 
                                    <div class="col-12">                       
                                                   <form  method="post" id="frmObs">                   
                                                         <div class="row">                            
                                                              <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar...">
                                                              <div class="table table-responsive">  
                                                                <table class="footable table" data-page-size="25" data-filter="#filter">
                                                                <thead class="cabecera_tabla">
                                                                    <tr>                                                                       
                                                                        <th style="width: 25%;border-right:1px #fff solid">Documento</th>
                                                                        <th style="width: 20%;border-right:1px #fff solid">Trabajador</th>
                                                                        <th style="width: 10%;border-right:1px #fff solid">RUT</th>
                                                                        <th style="width: 5%;border-right:1px #fff solid">Mes</th>
                                                                        <th style="width: 10%;border-right:1px #fff solid">Validar</th>
                                                                        <th style="width: 20%;border-right:1px #fff solid">Observaciones</th>
                                                                        <th style="width: 10%;text-align: center;border-right:1px #fff solid">Estado</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                    
                                                                   <tbody>
                                                                    
                                                                    <?php  

                                                                        $query_doc=mysqli_query($con,"select m.*, t.nombre1, t.apellido1, t.rut, t.idtrabajador, d.documento from mensuales_trabajador as m left join trabajador as t On t.idtrabajador=m.trabajador left join doc_mensuales as d On d.id_dm=m.doc left join mensuales as e On e.id_m=m.id_m where m.contratista='".$_SESSION['contratista']."' and m.mandante='".$_SESSION['mandante']."' and m.contrato='".$_SESSION['contrato']."' and  m.enviado=1 ");
                                                                        $result_doc=mysqli_fetch_array($query_doc); 
                                                                        $cantidad_de=mysqli_num_rows($query_doc);

                                                                       $query_obs=mysqli_query($con,"select * from doc_comentarios_extra where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' and leer_contratista=0 ");
                                                                       $result_obs=mysqli_fetch_array($query_obs);

                                                                     if ($cantidad_de!=0) {
                                                                        
                                                                         $i=0; 
                                                                         $cont_veri=0;
                                                                         $cont_doc=0;
                                                                          $estado=array();
                                                                         $num=1; 
                                                                         foreach ($query_doc as $row) {

                                                                            switch ($row['mes']) {
                                                                                case '01':$mes='Enero';break;
                                                                                case '02':$mes='Febrero';break;
                                                                                case '03':$mes='Marzo';break;
                                                                                case '04':$mes='Abril';break;
                                                                                case '05':$mes='Mayo';break;
                                                                                case '06':$mes='Junio';break;
                                                                                case '07':$mes='Julio';break;
                                                                                case '08':$mes='Agosto';break;                                            
                                                                                case '09':$mes='Septiembre';break;
                                                                                case '10':$mes='Octubre';break;
                                                                                case '11':$mes='Noviembre';break;
                                                                                case '12':$mes='Diciembre';break;
                                                                              }   

                                                                            $query_com=mysqli_query($con,"select * from doc_comentarios_mensual where id_doc='".$row['doc']."' and trabajador='".$row['trabajador']."' and documento='".$row['documento']."' and mes='".$row['mes']."' and estado=0 order by id_cm desc ");
                                                                            $result_com=mysqli_fetch_array($query_com);

                                                                            $query_t=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$row['trabajador']."' and contrato='".$row['contrato']."' ");
                                                                            $result_t=mysqli_fetch_array($query_t);
                                
                                                                            $query_d=mysqli_query($con,"select * from doc_mensuales where id_dm='".$row['doc']."' ");
                                                                            $result_d=mysqli_fetch_array($query_d);  
                                                                            
                                                                           # doc no acreditado 
                                                                           if ($row['verificado']==0) {                                                                                
                                                                                $carpeta = 'doc/temporal/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'_'.$row['mes'].'_'.$row['year'].'.pdf';
                                                                           # doc acreditado  
                                                                           } else {
                                                                                $carpeta = 'doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'_'.$row['mes'].'_'.$row['year'].'.pdf';

                                                                           }
                                                                            
                                                                           
                                                                            ?>
                                                                            
                                                                             <tr>
                                                                                
                                                                               <!-- # 
                                                                                <td style="text-align:center;background:#eee;border-bottom:1px #fff solid"><?php echo $num ?></td>-->

                                                                                <!-- documento -->
                                                                                <td  style=""><a href="<?php echo $carpeta ?>" target="_blank" ><?php echo $row['documento'] ?></a></td>
                                                                                <input type="hidden" id="doc<?php echo $i ?>" name="doc[]" value="<?php echo $row['doc'] ?>" />

                                                                                <!-- trabajador -->
                                                                                <td style=""><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>

                                                                                <td style=""><?php echo $row['rut'] ?></td>

                                                                                <td style=""><?php echo $mes ?></td>
                                                                             
                                                                                <?php                                                                                         
                                                                                     if ($row['verificado']==0) { ?>
                                                                                           <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) "   /></td>
                                                                                <?php   } else { ?>
                                                                                           <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" checked="" disabled="" title="Contratista No Acreditada" /></td> 
                                                                                <?php } ?>
                                                                                    <td>
                                                                                        <div class="btn-group"> 
                                                                                        <?php if ($row['verificado']==0) { ?>
                                                                                                    <textarea cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $result_com['comentarios'] ?></textarea>
                                                                                        <?php   } else { ?> 
                                                                                                    <textarea cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly="" ></textarea>
                                                                                        <?php } ?>

                                                                                            <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row['id_de'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                            </div>
                                                                                    </td>
                                                                                    
                                                                                
                                                                                    <td style="text-align:center">
                                                                                                                                                                                
                                                                                        <?php if ($row['enviado']==1) { ?>
                                                                                            <div style="font-size: 12px;" class="bg-warning p-xxs text-default "><b>EN PROCESO</b></div>
                                                                                        <?php } ?>
                                                                                        
                                                                                        <?php if ($row['enviado']==2) { ?>
                                                                                            <div style="font-size: 12px;" class="bg-warning p-xxs text-default "><b>EN PROCESO</b></div>
                                                                                        <?php } ?>
                                                                                        
                                                                                        <?php if ($row['enviado']==3) { ?>
                                                                                            <div style="font-size: 12px;" class="bg-success p-xxs text-default "><b>VALIDADO</b></div>
                                                                                        <?php } ?>
                                                                                     </td> 
                                                                           </tr>
                                                                             
                                                                   <?php   
                                                                        echo '<input type="hidden" id="id_mensual'.$i.'" name="id_mensual[]" value='.$row['id_tm'].' />';
                                                                        echo '<input type="hidden" id="id_trabajador'.$i.'" name="id_trabajador[]" value='.$row['idtrabajador'].' />';
                                                                        echo '<input type="hidden" id="id_mes'.$i.'" name="id_mes[]" value='.$row['mes'].' />';
                                                                        $i++;$num++; 
                                                                         } ?>
                                                                         
                                                                      
                                                                    <!--<tr>
                                                                        <td colspan="4"></td>    
                                                                        <td colspan="2"><button id="btnenviar" class="btn btn-md btn-success btn-block font-bold" disabled="" type="button" onclick="enviar(<?php echo $i ?>)" >Procesar Documentos <?php #echo $result_contratista['acreditada'] ?> </button></td>

                                                                    </tr>-->
                                                                      
                                                                    <?php } else { ?>
                                                                        
                                                                        <tr>
                                                                            <td colspan="5"><strong>Sin Documentos Mensuales para procesar</strong> </td>
                                                                        </tr>
                                                                    
                                                                    <?php } ?>
                                                                      
                                                                  </tbody>
                                                               </table>  
                                                              </div>   
                                                             </div>
                                                           <input type="hidden" id="control" value="<?php echo $result_obs['control'] ?>" />

                                                           <!--<div class="row">                                                            
                                                            <div class="col-3">
                                                                <?php if ($cantidad_de!=0) { ?>
                                                                        <button id="btnenviar" class="btn btn-md btn-success btn-block font-bold" type="button" onclick="enviar(<?php echo $i ?>)" >Procesar Documentos <?php #echo $result_contratista['acreditada'] ?> </button>
                                                                <?php } ?>
                                                            </div>
                                                          </div>-->
                                                       </form>  
                                               </div>        
                                            </div>           
                                            
                                            <div style="border:1px #c0c0c0 solid;border-radius:5px;padding: 0.5% 0%" class="row">
                                                <div  class="col-12">
                                                    <?php if ($cantidad_de!=0) { ?>
                                                        <button id="btnenviar" class="btn btn-md btn-success btn-block font-bold col-4"  type="button" onclick="enviar(<?php echo $i ?>)" >PROCESAR DOCUMENTOS <?php ?> </button>                    
                                                    <?php } else { ?>    
                                                        <button id="btnenviar" class="btn btn-md btn-success btn-block font-bold col-4"  type="button" disabeld >PROCESAR DOCUMENTOS <?php ?> </button>                    
                                                    <?php }  ?>    
                                                </div>    
                                            </div>    

                                                     
                             </div>
                        </div>
                      </div>
                   </div> 
                 </div>
                 
                 
                                                        <script>
                                                               function modal_ver_obs(id) {
                                                                     //alert(id);
                                                                    $('.body').load('selid_ver_obs_doc_extra.php?doc='+id,function(){
                                                                                $('#modal_ver_obs').modal({show:true});
                                                                    });
                                                                }


                                                                function modal_mensual(contratista,mandante,condicion,contrato,nom_contratista,nom_contrato) {
                                                                        //alert(nom_contrato);
                                                                        $('#modal_doc_mensual input[name=contratista_dm]').val(contratista);
                                                                        $('#modal_doc_mensual input[name=mandante_dm]').val(mandante);
                                                                        $('#modal_doc_mensual input[name=condicion_dm]').val(condicion);
                                                                        $('#modal_doc_mensual input[name=contrato_dm]').val(contrato);
                                                                        $('#modal_doc_mensual input[name=nom_contratista]').val(nom_contratista);
                                                                        $('#modal_doc_mensual input[name=nom_contrato]').val(nom_contrato);
                                                                        $('#modal_doc_mensual').modal({show:true});
                                                                        
                                                                } 

                                                        </script> 


                                                            <div class="modal fade" id="modal_doc_mensual" tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog modal-md">
                                                                        <div class="modal-content">
                                                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i>Actualizar Documentos Mensuales</h3>
                                                                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">x</span></button>
                                                                        </div>
                                                                        <div class="body">
                                                                        <style>
                                                                                .estilo2 {
                                                                                        display: inline-block;
                                                                                        content: "";
                                                                                        width: 12x;
                                                                                        height: 12px;
                                                                                        margin: 0.5em 0.5em 0 0;
                                                                                        background-size: cover;
                                                                                    }
                                                                                    .estilo2:checked  {
                                                                                        content: "";
                                                                                        width: 12px;
                                                                                        height: 12px;
                                                                                        margin: 0.5em 0.5em 0 0;
                                                                                    }
                                                                            </style>
                                                                            

                                                                                <form  method="post" id="frmMensualDoc">    
                                                                                <div class="modal-body">

                                                                                    <div class="row form-group">
                                                                                        <label  class="col-3 col-form-label"><b>Contratista:</b></label>
                                                                                        <input  class="col-9 col-form-control" type="text" id="nom_contratista" name="nom_contratista"  >
                                                                                    </div>
                                                                                    <div class="row form-group">
                                                                                        <label  class="col-3 col-form-label"><b>Contrato:</b></label>
                                                                                        <input  class="col-9 col-form-control" type="text" id="nom_contrato" name="nom_contrato"  >
                                                                                    </div>
                                                                                
                                                                                    <div class="row" style="" >
                                                                                        <div class="col-12">
                                                                                            <table style="overflow-y: auto;" class="table table-stripped">
                                                                                                <thead style="background:#e9eafb;color:#282828">
                                                                                                    <tr>
                                                                                                        <th style="width: ;border-right:1px #fff solid">Documento</th>
                                                                                                        <th class="text-rigth" style="width: ;text-align:center">Seleccionar</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody> 
                                                                                                    <?php $i=0; 
                                                                                                        $query=mysqli_query($con,"select * from doc_mensuales "); 
                                                                                                        $query_doc=mysqli_query($con,"select documentos from mensuales where contrato='".$_SESSION['contrato']."' ");
                                                                                                        $result_doc=mysqli_fetch_array($query_doc);
                                                                                                        foreach ($query as $row) { 
                                                                                                            $existe=in_array($row['id_dm'],unserialize($result_doc['documentos']));
                                                                                                            if ($existe) {
                                                                                                               $chk=1;     
                                                                                                            } else {
                                                                                                                $chk=0;     
                                                                                                            }
                                                                                                    ?>
                                                                                                        <tr>
                                                                                                            <td><label class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                                                                            <?php
                                                                                                                if ($chk==0) {
                                                                                                                    echo '<td style="text-align:center"><input class="estilo2" id="doc_mensuales_dm'.$i.'" name="doc_mensuales_dm[]" type="checkbox" value="'.$row['id_dm'].'" /></td>';    
                                                                                                                } else {
                                                                                                                    echo '<td style="text-align:center"><input class="estilo2" id="doc_mensuales_dm'.$i.'" name="doc_mensuales_dm[]" type="checkbox" checked="" value="'.$row['id_dm'].'" /></td>';
                                                                                                                }    
                                                                                                            ?>
                                                                                                                

                                                                                                        </tr>
                                                                                                    <?php $i++; } ?>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            
                                                                                            <div class="row">
                                                                                                <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                                                                                    <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" >Documentos faltantes enviar a <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                                                                                </div>
                                                                                            </div>   
                                                                                            
                                                                                        </div>   
                                                                                    </div>                                                  
                                                                                </div> 
                                                                                
                                                                                                                        
                                                                                <div class="modal-footer">
                                                                                    <button class="btn btn-secondary btn-sm" title="Cerrar Ventana" data-dismiss="modal" >Cancelar </button>                    
                                                                                    <button class="btn btn-success btn-sm" type="button" onclick="crear_doc_mensual(<?php echo $i ?>)" >Actualizar</button>  
                                                                                </div> 
                                                                                
                                                                                <input type="hidden" id="contratista_dm" name="contratista_dm"  />
                                                                                <input type="hidden" id="mandante_dm" name="mandante_dm" />
                                                                                <input type="hidden" id="condicion_dm" name="condicion_dm" />
                                                                                <input type="hidden" id="contrato_dm" name="contrato_dm"  />
                                                                                    
                                                                                </form>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        
                                                        <div class="modal fade" id="modal_ver_obs" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                                  <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Historial de Observaciones</h3>
                                                                  <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                                </div>
                                                                        <div class="body">
                                                                         
                                                                              
                                                                        </div>                                    
                                                               </div>
                                                            </div>
                                                        </div>  
                                                        
                                                        <!-- modal cargando--->
                                                        <div class="modal fade" id="modal_cargar_procesar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-body text-center">
                                                                <div class="loader"></div>
                                                                  <h3>Procesando documentos, por favor espere un momento</h3>
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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>

     <!-- FooTable -->
     <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>




</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
