<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2 ) {
    
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$id=$_SESSION['trabajador'];
$idcargo=$_SESSION['cargo'];
$contrato=$_SESSION['contrato'];
$mandante=$_SESSION['mandante'];
$perfil=$_SESSION['perfil'];
$contratista=$_SESSION['contratista'];

#$query_trabajador=mysqli_query($con,"select * from trabajador where idtrabajador='".$_SESSION['trabajador']."' ");
#$result_trabajador=mysqli_fetch_array($query_trabajador);

$query_trabajador=mysqli_query($con,"select a.url_foto as foto, t.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador where t.idtrabajador='".$_SESSION['trabajador']."' and a.contrato='$contrato' ");
$result_trabajador=mysqli_fetch_array($query_trabajador);
$rut=$result_trabajador['rut'];

$query_perfil_cargo=mysqli_query($con,"select * from perfiles_cargos where contrato='".$_SESSION['contrato']."' ");
$result_perfil_cargo=mysqli_fetch_array($query_perfil_cargo);

$query_contratista=mysqli_query($con,"select d.acreditada, c.* from contratistas as c left join contratistas_mandantes as d On d.contratista=c.id_contratista where c.id_contratista='".$_SESSION['contratista']."' ");
$result_contratista=mysqli_fetch_array($query_contratista);

$query_contrato=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato']."' ");
$result_contrato=mysqli_fetch_array($query_contrato);

$query_cargos=mysqli_query($con,"select * from cargos where idcargo='".$_SESSION['cargo']."' ");
$result_cargo=mysqli_fetch_array($query_cargos);

$cargos=unserialize($result_perfil_cargo['cargos']);
$perfiles=unserialize($result_perfil_cargo['perfiles']);

$query_obs=mysqli_query($con,"select * from observaciones where mandante='".$_SESSION['mandante']."' and contrato='".$_SESSION['contrato']."' and trabajador='".$_SESSION['trabajador']."' and estado!='2' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);

$query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='$id' and contrato='".$_SESSION['contrato']."' and mandante='".$_SESSION['mandante']."' and estado!='2' ");
$result_ta=mysqli_fetch_array($query_ta);
$doc_ta=unserialize($result_ta['documentos']);
$existe_acreditado=mysqli_num_rows($query_ta);

$contador=0;
foreach ($cargos as $row) {    
    if ($row==$idcargo) {
            $posicion_cargo=$contador;
            break;
        }    
    $contador++;
}

$contador=0;
foreach ($perfiles as $row) {    
    if ($contador==$posicion_cargo) {
            //$perfil=$row;
            break;
        }    
    $contador++;
}


$query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
$result_doc=mysqli_fetch_array($query_doc); 

$documentos=unserialize($result_doc['doc']);

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    
     <title>FacilControl | Documentos del Trabajador</title>
     <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
   
   <script src="js\jquery-3.1.1.min.js"></script>
   
    <?php if ($result_obs['estado']==1 and $result_obs['fecha']=="") { ?>
        <script>
           // $(document).ready(function () {
           //     $('#modal_fecha_val').modal('show');
           // });
        </script>
    
    <?php } ?>
    
    <script>
    
     function deshabilitar_fecha() {
        var isChecked = $('#indefinido').prop('checked');
        if (isChecked) {  
            document.getElementById("fecha_val").value = "";
            document.getElementById("fecha_val").disabled = true;
        } else {
            document.getElementById("fecha_val").disabled = false;
        }          
     }
    
     function deshabilitar(i) {        
        var total_doc=Number($('#total_doc').val())+Number(1);         
        var j=0;
        var contador=0;
        var isChecked = $('#verificar_doc'+i).prop('checked');
        if  (isChecked) {
             document.getElementById("mensaje"+i).value ="";
             $("#mensaje"+i).attr("readonly","readonly");
             
        } else {
            //document.getElementById("mensaje"+i).disabled = false;
            $("#mensaje"+i).removeAttr("readonly");
        }
        // se han seleccionado
        
            for (j=0;j<=total_doc-1;j++) {
                 var isChecked = $('#verificar_doc'+j).prop('checked');
                 if  (isChecked) {
                     contador=contador+1;
                }   
            }
            //alert(contador+' '+total_doc)
            if (contador==total_doc) {
                document.getElementById('acreditacion').style.display= '';
            } else {
                document.getElementById('indefinido').checked=false;
                document.getElementById("fecha_val").disabled = false; 
                document.getElementById('acreditacion').style.display= 'none';
            }    
           
    }     
      
    function enviar(total,mandante,contratista) {
        var total_doc=Number($('#total_doc').val())+Number(1);
        var total=total+Number(1);
        var rut=$('#rut').val();
        var j=0;
        var contador=0;
        var mensaje=0;
        //alert(rut);
        for (j=0;j<=total_doc-1;j++) {
            var isChecked = $('#verificar_doc'+j).prop('checked');
            if  (isChecked) {
                contador=contador+1;
            }   
            var valor_mensaje=$('#mensaje'+j).val();
            if (valor_mensaje!=''){
                mensaje=mensaje+1;
            }
        } 
        
        // sino hay seleccionados para procesar
        if (contador==0 && mensaje==0 ) {
            swal({ 
                title:"Seleccionar al menos un Documentos o Enviar una Observacion.",
                //text: "Debe selecionar al menos un documento",
                type: "warning"
            });  
        } else {
                // sino estan todos selecionados
                if (contador!=total_doc) {
            
                                var arreglo=[];
                                var arreglo2=[];
                                var arreglo3=[];
                                var falta_revisar=false;
                                for (i=0;i<=total-1;i++) {
                                    var isChecked = $('#verificar_doc'+i).prop('checked');
                                    if (isChecked) {
                                        var valor=document.getElementById("verificar_doc"+i).value = "1";
                                        var valor2=$('#mensaje'+i).val();
                                        arreglo.push(valor);
                                        arreglo2.push(valor2);
                                        
                                        var valor3=$('#doc'+i).val();
                                        arreglo3.push(valor3);
                                    } else {
                                        var valor=document.getElementById("verificar_doc"+i).value = "0";
                                        var valor2=$('#mensaje'+i).val();
                                        var isDisabled = $('#verificar_doc'+i).prop('disabled');
                                        if (valor==0) {
                                            var falta_revisar=true;
                                        }
                                        var valor3=$('#doc'+i).val();
                                        arreglo3.push(valor3); 
                                        
                                        arreglo.push(valor);
                                        arreglo2.push(valor2);
                                    }
                                }
                                    
                                    var json=JSON.stringify(arreglo);
                                    var json2=JSON.stringify(arreglo2);
                                    var json3=JSON.stringify(arreglo3);
                                    $.ajax({
                          			    method: "POST",
                                        url: "enviar_observacion.php",
                             		    data: {data:json,data2:json2,data3:json3,contratista:contratista,rut:rut},
                                        cache: false,
                                        beforeSend: function(){
                                            const progressBar = document.getElementById('myBar');
                                            const progresBarText = progressBar.querySelector('.progress-bar-text');
                                            let percent = 0;
                                            progressBar.style.width = percent + '%';
                                            progresBarText.textContent = percent + '%';
                                                                
                                            let progress = setInterval(function() {
                                                if (percent >= 100) {
                                                    clearInterval(progress);                                                                                                       
                                                } else {
                                                    percent = percent + 1; 
                                                    progressBar.style.width = percent + '%';
                                                    progresBarText.textContent = percent + '%';
                                                }
                                            }, 100);
                                            $('#modal_cargar').modal('show');						
                              			},
                              			success: function(data){
                            	            if (data==0) {
                            	                $('#modal_cargar').modal('hide');
                                                if (falta_revisar==true) {
                                                    //swal({
                                                    //        title: "Documento(s) Procesado(s)",
                                                            //text: "Documentos sin validar",
                                                    //        type: "warning"
                                                    // });
                                                     window.location.href='verificar_documentos_trabajador_mandante.php';
                                                } else {                                                    
                                                    //swal({
                                                    //    title: "Trabajador Validado",
                                                        //text: "Un Documento no validado esta sin comentario",
                                                    //    type: "success"
                                                    //    });
                                                    window.location.href='verificar_documentos_trabajador_mandante.php';
                                                }                        
                                            } else {
                                                $('#modal_cargar').modal('hide');
                                	            if (falta_revisar==true) {
                                                    //swal({
                                                    //        title: "Documento(s) Actualizado(s)",
                                                            //text: "Documentos sin validar",
                                                    //        type: "warning"
                                                    // });
                                                     window.location.href='verificar_documentos_trabajador_mandante.php';
                                                } else {
                                                    //swal({
                                                    //    title: "Trabajador Validado",
                                                        //text: "Un Documento no validado esta sin comentario",
                                                    //    type: "success"
                                                    //});
                                                  window.location.href='verificar_documentos_trabajador_mandante.php';
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
        
        // si todos estan seleccionados
        } else {
                    var fecha_val=$('#fecha_val').val()
                    var isChecked_indefinido = $('#indefinido').prop('checked');
                    
                    // sino esta seleccionada la fecha de validacion
                    if (fecha_val=='' && !isChecked_indefinido) {
                        swal("Seleccionar Fecha", "falta fecha de validacion", "warning");
                    // si esta seleccionada fecha de validacion    
                    } else {

                            if (fecha_val=='') {
                                fecha_val='Indefinido';
                            }
                                
                            if (fecha_val=='') {                                
                                swal({
                                    title: "Confirmar Validez Indefinida",
                                    //text: "Your will not be able to recover this imaginary file!",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#1D84C6",
                                    confirmButtonText: "Aceptar",
                                    cancelButtonText: "Cancelar",
                                    closeOnConfirm: false,
                                    closeOnCancel: true },            
                                    function (isConfirm) {
                                    if (isConfirm) {                
                                        var arreglo=[];
                                        var arreglo2=[];
                                        var arreglo3=[];
                                        var arreglo4=[];
                                        var falta_revisar=false;
                                        for (i=0;i<=total-1;i++) {
                                            var isChecked = $('#verificar_doc'+i).prop('checked');
                                            if (isChecked) {
                                                var valor=document.getElementById("verificar_doc"+i).value = "1";
                                                var valor2=$('#mensaje'+i).val();
                                                arreglo.push(valor);
                                                arreglo2.push(valor2);
                                                
                                                var valor3=$('#doc'+i).val();
                                                arreglo3.push(valor3);
                                            } else {
                                                var valor=document.getElementById("verificar_doc"+i).value = "0";
                                                var valor2=$('#mensaje'+i).val();
                                                var isDisabled = $('#verificar_doc'+i).prop('disabled');
                                                if (valor==0) {
                                                    var falta_revisar=true;
                                                }
                                                var valor3=$('#doc'+i).val();
                                                arreglo3.push(valor3); 
                                                
                                                arreglo.push(valor);
                                                arreglo2.push(valor2);
                                            }
                                            
                                            // id documentos
                                            var valor4=$('#id_doc'+i).val();
                                            arreglo4.push(valor4);
                                            
                                        }
                                            //alert(arreglo3+'-'+arreglo4)
                                            var json=JSON.stringify(arreglo);
                                            var json2=JSON.stringify(arreglo2);
                                            var json3=JSON.stringify(arreglo3);
                                            var id_doc=JSON.stringify(arreglo4);
                                            $.ajax({
                                                method: "POST",
                                                url: "enviar_observacion.php",
                                                data: {data:json,data2:json2,data3:json3,contratista:contratista,fecha_val:fecha_val,id_doc:id_doc,control_foto:control_foto,rut:rut},
                                                cache: false,
                                                beforeSend: function(){
                                                    const progressBar = document.getElementById('myBar');
                                                    const progresBarText = progressBar.querySelector('.progress-bar-text');
                                                    let percent = 0;
                                                    progressBar.style.width = percent + '%';
                                                    progresBarText.textContent = percent + '%';
                                                                        
                                                    let progress = setInterval(function() {
                                                        if (percent >= 100) {
                                                            clearInterval(progress);                                                                                                       
                                                        } else {
                                                            percent = percent + 1; 
                                                            progressBar.style.width = percent + '%';
                                                            progresBarText.textContent = percent + '%';
                                                        }
                                                    }, 100);
                                                    $('#modal_cargar').modal('show');						
                                                },
                                                success: function(data){
                                                    if (data==0) {
                                                        $('#modal_cargar').modal('hide');
                                                        if (falta_revisar==true) {
                                                            swal({
                                                                    title: "Procesado",
                                                                    text: "Documentos sin validar",
                                                                    type: "warning"
                                                            });
                                                            window.location.href='verificar_documentos_trabajador_mandante.php';
                                                        } else {
                                                            $('#modal_cargar').modal('hide');
                                                            swal({
                                                                title: "Trabajador Validado",
                                                                //text: "Un Documento no validado esta sin comentario",
                                                                type: "success"
                                                                });
                                                            window.location.href='verificar_documentos_trabajador_mandante.php';
                                                        }                        
                                                    } else {
                                                        $('#modal_cargar').modal('hide');
                                                        if (falta_revisar==true) {
                                                            swal({
                                                                    title: "Actualizado",
                                                                    text: "Documentos sin validar",
                                                                    type: "warning"
                                                            });
                                                            window.location.href='verificar_documentos_trabajador_mandante.php';
                                                        } else {
                                                            $('#modal_cargar').modal('hide'); 
                                                            swal({
                                                                    title: "Trabajador Validado",
                                                                    //text: "Un Documento no validado esta sin comentario",
                                                                    type: "success"
                                                            });
                                                            window.location.href='verificar_documentos_trabajador_mandante.php';    
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
                                    } else {
                                        swal("Cancelado", "Accion Cancelada", "error");
                                    }
                                });
                                
                            } else {
                                    var arreglo=[];
                                    var arreglo2=[];
                                    var arreglo3=[];
                                    var arreglo4=[];                
                                    var falta_revisar=false;
                                    for (i=0;i<=total-1;i++) {
                                        var isChecked = $('#verificar_doc'+i).prop('checked');
                                        if (isChecked) {
                                            var valor=document.getElementById("verificar_doc"+i).value = "1";
                                            var valor2=$('#mensaje'+i).val();
                                            arreglo.push(valor);
                                            arreglo2.push(valor2);
                                            
                                            var valor3=$('#doc'+i).val();
                                            arreglo3.push(valor3);
                                        } else {
                                            var valor=document.getElementById("verificar_doc"+i).value = "0";
                                            var valor2=$('#mensaje'+i).val();
                                            var isDisabled = $('#verificar_doc'+i).prop('disabled');
                                            if (valor==0) {
                                                var falta_revisar=true;
                                            }
                                            var valor3=$('#doc'+i).val();
                                            arreglo3.push(valor3); 
                                            
                                            arreglo.push(valor);
                                            arreglo2.push(valor2);
                                        }
                                        
                                        // id documentos
                                        var valor4=$('#id_doc'+i).val();
                                        arreglo4.push(valor4); 
                                        
                                    }
                                        //alert(arreglo3+'-'+arreglo4)
                                        var json=JSON.stringify(arreglo);
                                        var json2=JSON.stringify(arreglo2);
                                        var json3=JSON.stringify(arreglo3);
                                        var id_doc=JSON.stringify(arreglo4);
                                        
                                        $.ajax({
                                            method: "POST",
                                            url: "enviar_observacion.php",
                                            data: {data:json,data2:json2,data3:json3,contratista:contratista,fecha_val:fecha_val,id_doc:id_doc},
                                            cache: false,
                                            beforeSend: function(){
                                                const progressBar = document.getElementById('myBar');
                                                const progresBarText = progressBar.querySelector('.progress-bar-text');
                                                let percent = 0;
                                                progressBar.style.width = percent + '%';
                                                progresBarText.textContent = percent + '%';
                                                                    
                                                let progress = setInterval(function() {
                                                    if (percent >= 100) {
                                                        clearInterval(progress);                                                                                                       
                                                    } else {
                                                        percent = percent + 1; 
                                                        progressBar.style.width = percent + '%';
                                                        progresBarText.textContent = percent + '%';
                                                    }
                                                }, 100);
                                                $('#modal_cargar').modal('show');						
                                                    },
                                            success: function(data){
                                                if (data==0) {
                                                    $('#modal_cargar').modal('hide');
                                                    if (falta_revisar==true) {
                                                        swal({
                                                                title: "Procesado",
                                                                text: "Documentos sin validar",
                                                                type: "warning"
                                                        });
                                                        window.location.href='verificar_documentos_trabajador_mandante.php';
                                                    } else {
                                                        $('#modal_cargar').modal('hide');
                                                        swal({
                                                            title: "Trabajador Validado",
                                                            //text: "Un Documento no validado esta sin comentario",
                                                            type: "success"
                                                            });
                                                        window.location.href='verificar_documentos_trabajador_mandante.php';
                                                    }                        
                                                } else {
                                                    $('#modal_cargar').modal('hide');
                                                    if (falta_revisar==true) {
                                                        swal({
                                                                title: "Actualizado",
                                                                text: "Documentos sin validar",
                                                                type: "warning"
                                                        });
                                                        window.location.href='verificar_documentos_trabajador_mandante.php';
                                                    } else {
                                                        $('#modal_cargar').modal('hide');
                                                    swal({
                                                            title: "Trabajador Validado",
                                                            //text: "Un Documento no validado esta sin comentario",
                                                            type: "success"
                                                    });
                                                    window.location.href='verificar_documentos_trabajador_mandante.php';
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
                    }
            }
       }   
   }   
      
   function poner_cero(id){
      $("#verificar_doc"+id).prop('checked', true);
      document.getElementById("verificar_doc"+id).value = "0";
      
   }
    
    
    </script>

<style>
        
        
        
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
        .checkboxtexto {
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
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
}  

        .fondo {
            background:#e9eafb;
            color:#292929;
            border-bottom: #fff 2px solid;
            border-left: #fff 2px solid;
            width:15%;
        }

        .fondo_td {
            background:#e9eafb;
            width: 20%;
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

hr {
    height: 0.3px;
    background-color: #B9B9B9;
    }

    .input_div{
        display: flex;
        flex-direction:column;
    }

    .input_container{
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 20px;
    }

    .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
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
                    <h2 style="color: #010829;font-weight: bold;">DOCUMENTOS DEL TRABAJADOR <?php    ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
            
           <form  method="post" id="frmObs">   
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                               <div class="ibox-title">
                               
                                    <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="gestion_contratos_mandantes.php" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i>Gestion de Contratos</a>
                                      </div>
                                   </div>    
                                   <?php include('resumen.php') ?>
                                    
                             </div>   
                        
                        
                        <div class="ibox-content">

                        <table class="table table-responsive">                                                   
                                                    <tr>
                                                        <?php 
                                                            #si esta acredetodo mostrar foto asociada al contrato
                                                            if ($existe_acreditado!=0) {

                                                                if ($result_ta['url_foto']=="") {  ?>
                                                                    <td class="fondo_td" rowspan="10">
                                                                        <label  class="col-form-label"><label class="col-form-label"><img width="150" heigth="150" src="img/sinimagen.png" /></label>
                                                                    </td>         
                                                                <?php 
                                                                } else { ?>
                                                                    <td class="fondo_td" rowspan="10">
                                                                        <label  class="col-form-label"><label class="col-form-label"><img width="150" heigth="150" src="<?php echo $result_ta['url_foto'] ?>" /></label>
                                                                    </td>
                                                                <?php 
                                                                }  ?>     
                                                            <?php 
                                                            } else { 
                                                                    # sino tiene una foto
                                                                    if ($result_trabajador['foto']=="") {  ?>
                                                                        <td class="fondo_td" rowspan="10">
                                                                            <label  class="col-form-label"><label class="col-form-label"><img src="img/sinimagen.png" /></label>
                                                                        </td>
                                                                        <input type="hidden" name="control_foto" id="control_foto" value="0" />
                                                                    <?php
                                                                    # si tiene una foto
                                                                    } else { ?>   
                                                                        <td class="fondo_td" rowspan="10">
                                                                            <label  class="col-form-label"><label class="col-form-label"><img width="150" heigth="150" src="<?php echo $result_trabajador['foto'] ?>" /></label>
                                                                        </td>    
                                                                        <input type="hidden" name="control_foto" id="control_foto" value="1" />
                                                            <?php       }  
                                                            }  ?>

                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Contratista </b></label></td>
                                                        <td ><label class="col-form-label"><?php echo $result_contratista['razon_social'] ?></label></td>
                                                    </tr> 

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Contrato </b></label></td>
                                                        <td ><label class="col-form-label"><?php echo $result_contrato['nombre_contrato'] ?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Trabajador </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_trabajador['nombre1'].' '.$result_trabajador['nombre2'].' '.$result_trabajador['apellido1'].' '.$result_trabajador['apellido2']  ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>RUT</b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_trabajador['rut'] ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Cargo </b></label></td>
                                                        <td><label class="col-form-label"><?php echo $result_cargo['cargo'] ;?></label></td>
                                                    </tr> 
                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Documentos </b></label></td>
                                                        <?php 
                                                            $rut_t=$result_trabajador['rut'];
                                                            $url ='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut_t.'/'.$result_ta['codigo'].'/zip/documentos_validados_trabajador_'.$rut_t.'.zip';
                                                            if ($existe_acreditado!=0) {  
                                                                  # sin foto en el contrato acreditado
                                                                    if ($result_ta['url_foto']=="") { ?>
                                                                    <td ><label class="col-form-label text-danger"><b>Trabajador Sin Foto</b></label></td>            
                                                            <?php 
                                                                # si hay foto en el contrato
                                                                  } else { ?>        
                                                                    <td ><label  class="col-form-label"><a class="" href="<?php echo $url ?>" ><u><b>Descargar</b></u></a></label></td>
                                                            <?php } ?>
                                                            <?php } else { ?>
                                                                <td ><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td>
                                                            <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b> Vencimiento </b></label></td>
                                                        <?php                                                            
                                                            if ($existe_acreditado!=0) {                                                                
                                                        ?>
                                                            <td ><label  class="col-form-label"><label class="col-form-label"><?php echo $result_ta['validez'] ;?> </label></td>
                                                            <?php } else { ?>
                                                                <td ><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td>
                                                            <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <td class="fondo" ><label class="col-form-label"><b>Credencial </b></label></td>
                                                        <?php 
                                                            if ($existe_acreditado!=0) { 
                                                                # sin foto en el contrato acreditado
                                                                    if ($result_ta['url_foto']=="") { ?>
                                                                    <td ><label class="col-form-label text-danger"><b>Trabajador Sin Foto</b></label></td>            
                                                            <?php 
                                                                # si hay foto en el contrato
                                                                  } else { ?>        
                                                                    <td ><label class="col-form-label"><a style="margin-left: 2%;text-decoration:underline" class="" href="credencial.php?codigo=<?php echo $result_ta['codigo'] ?>" target="_blank"><b>Descargar</b></a></label></td>
                                                            <?php } ?>                
                                                        <?php } else { ?>
                                                            <td><label style="font-size:12px" class="col-form-label badge badge-danger"><b>Trabajador No Acreditado</b></label></td> 
                                                                
                                                        <?php } ?>                                                        
                                                    </tr>

                                                    <tr id="acreditacion" style="display: none;">
                                                        <td class="fondo" ><label class="col-form-label"><b>Acreditacion </b></label></td>                                                 
                                                        <td> 

                                                            <div class="input_container">
                                                                <div class="input_div">
                                                                    <input type="date" name="fecha_val" id="fecha_val" value="0000-00-00" class="form-control">
                                                                </div>
                                                                <div style="margin-top:4%">
                                                                    <input name="indefinido" id="indefinido" type="checkbox" value="1" onclick="deshabilitar_fecha()" ><span style="color: #FF0000;font-weight: bold;font-size: 16px;">&nbsp;&nbsp;Indefinido</span>
                                                                </div>
                                                            </div>                                                            
                                                        </td>
                                                    </tr>

                                                </table>

                                        
                                        <!--<div id="acreditacion" class="row"  style="display: ;">
                                            <label style="background:#BFC6D4"  class="col-2 col-form-label"><b>Acreditacion: </b></label>
                                            <div style="background: ;margin-left: 1%;" class="col-4">
                                                <input style="border:1px solid #969696" type="date" name="fecha_val" id="fecha_val"  class="form-control" value="0000-00-00" />
                                                
                                               <div style="margin-top: 4%;"> <input style="" class="checkboxtexto" name="indefinido" id="indefinido" type="checkbox" value="1" onclick="deshabilitar_fecha()" /> <span style="color: #FF0000;font-weight: bold;font-size: 16px;">&nbsp;&nbsp;Indefinido</span> </div>
                                          
                                            </div>
                                        </div>-->
                                        
                                        
                                        <?php if ($existe_acreditado!=0) { 
                                              
                                              if ($result_obs['fecha']=='0000-00-00') {
                                                $fecha='Indefinido';    
                                              } else {
                                                $fecha=$result_obs['fecha'];
                                              }
                                         } ?>
                       
                        <?php if($existe_acreditado==0) { ?>                 
                                
                                <div style="margin-top:2%" class="row">                            
                                        <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                        <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                        
                                        <thead class="cabecera_tabla">
                                            <tr>                                               
                                                <th  style="width: 40%;border-right:1px #fff solid">Documento</th>
                                                <th  style="width: 5%;text-align: center;10%;border-right:1px #fff solid">Verificado</th>
                                                <th  style="width: 40%;border-right:1px #fff solid">Observaciones</th>
                                                <th  style="width: 15%;border-right:1px #fff solid;text-align:center">Estado</th>
                                                
                                            </tr>
                                            </thead>
                                            
                                        <tbody>
                                            
                                            <?php          
                                                $i=0; 
                                                $cont_veri=0;
                                                $cont_doc=0;
                                                foreach ($documentos as $row) {
                                                    $cont_doc=$cont_doc+1;
                                                    $sql=mysqli_query($con,"select * from doc where id_doc='$row' "); 
                                                    $result=mysqli_fetch_array($sql);  
                                                    
                                                    //$sql2=mysqli_query($con,"select * from observaciones where trabajador='$id' and contrato='$contrato' and mandante='$mandante' and cargo='$idcargo' and documento='$row' ");
                                                    //$result2=mysqli_fetch_array($sql2);   
                                                    
                                                    $query_com=mysqli_query($con,"select * from comentarios where id_obs='".$result_obs['id_obs']."' and doc='".$result['documento']."' and estado='0' order by id_com desc ");
                                                    $result_com=mysqli_fetch_array($query_com);
                                                    $list_com=($result_com['comentarios']);

                                                    $query_noaplica=mysqli_query($con,"select * from noaplica_trabajador where documento='$row' and contratista='$contratista' and mandante='$mandante' ");
                                                    $resul_noaplica=mysqli_num_rows($query_noaplica);
                                                    
                                                    if ($existe_acreditado==1) {
                                                        $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$result_contratista['id_contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut.'/'.$result['documento'].'_'.$rut.'.pdf';
                                                    } else { 
                                                        $carpeta='doc/temporal/'.$_SESSION['mandante'].'/'.$result_contratista['id_contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$rut.'/'.$result['documento'].'_'.$rut.'.pdf';
                                                        
                                                    }    
                                                    
                                                    
                                                    $archivo_existe=file_exists($carpeta);  ?>  
                                                    
                                                    <tr>                    
                                                    <?php 
                                                    # si existe el archivo
                                                    if ($archivo_existe) {  ?>
                                                            <!--<td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>-->
                                                            
                                                            <?php if ($resul_noaplica>0) { ?>
                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?> <small><label style="border-radius:5px" class="badge-primary">&nbsp;NO APLICA&nbsp;</label><small></a></td>
                                                            <?php 
                                                            } else { ?>
                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                            <?php 
                                                            } ?>
                                                            
                                                            <input type="hidden" id="doc<?php echo $i?>" value="<?php echo $result['documento'] ?>" />
                                                            <input type="hidden" id="id_doc<?php echo $i?>" value="<?php echo $result['id_doc'] ?>" />
                                                            
                                                            <div><?php
                                                            if ($list_veri[$i]==0 ) { ?>
                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo  $i ?>) "  /></td>
                                                                <td>
                                                                    <div class="btn-group"> 
                                                                        <?php #if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) { ?>
                                                                            <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $list_com ?></textarea>
                                                                        <?php #} else { ?>
                                                                            <!--<textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ></textarea>-->
                                                                        <?php #} ?>    
                                                                        
                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $id ?>,<?php echo $contrato ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </td>
                                                                 <?php   
                                                                 if  ($result_com['doc']==$result['documento']) {        
                                                                    if ($result_com['leer_mandante']==1 and $result_com['leer_contratista']==1) { ?>
                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">RECIBIDO</div></td>
                                                                    <?php      
                                                                    }     
                                                                    if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) { ?>
                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">OBSERVACION</div></td>
                                                                    <?php     
                                                                    }     
                                                                } else { ?>
                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">RECIBIDO</div></td>
                                                                <?php   
                                                                }        
                                                            
                                                            } else {
                                                                     $cont_veri=$cont_veri+1;
                                                                    // si trabajador esta verificado deshabilitar checkbos verificacion
                                                                    if ($result_obs['estado']!=1) { ?>
                                                                        <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  checked="" onclick="deshabilitar(<?php echo $i ?>)" disabled="" /></td>
                                                                    <?php  
                                                                    } else { ?>
                                                                        <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  checked="" disabled="" /></td>
                                                                    <?php  
                                                                    }    ?>                                                                
                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                            <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly="" ></textarea>
                                                                            <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $result_obs['id_obs'] ?>)" ><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-success p-xxs text-mute">VALIDADO</div></td>
                                                                    <?php 
                                                                    }    
                                                    
                                                    # sino existe el archivo       
                                                    } else { ?>
                                                            <!--<td style="text-align:center"><i style="color: #FF0000;font-size: 20px;" class="fa fa-window-close" aria-hidden="true"></i></td>-->
                                                            <td style=""><?php echo $result['documento'] ?></td>
                                                            <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>
                                                            <td>
                                                                <div class="btn-group"> 
                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" disabled=""></textarea>
                                                                    <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                </div>
                                                            </td>
                                                            <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-danger p-xxs text-mute">NO RECIBIDO</div></td>
                                                    <?php  
                                                    }   ?> 
                                                </tr>
                                                    
                                            <?php $i++;} 
                                            $query_com=mysqli_query($con,"select * from comentarios where doc='Foto del trabajador' and trabajador='$id' and estado='0' order by id_com desc ");
                                            $result_com=mysqli_fetch_array($query_com);
                                            $list_com=($result_com['comentarios']);

                                            if ($result_trabajador['foto']=="") { ?>
                                                    <tr>
                                                        <td>Foto del trabajador</td>
                                                        <input type="hidden" id="doc<?php echo $i?>" value="Foto del trabajador" />
                                                        <input type="hidden" id="id_doc<?php echo $i?>" value="35" />
                                                        <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>
                                                        <td>
                                                            <div class="btn-group"> 
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" disabled=""></textarea>
                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                            </div>
                                                        </td>
                                                        <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-danger p-xxs text-mute">NO ENVIADO</div></td>
                                                    </tr>
                                            <?php 
                                            } else { ?>
                                                    <tr>
                                                        <td>Foto del trabajador</td>       
                                                        <input type="hidden" id="doc<?php echo $i?>" value="Foto del trabajador" />     
                                                        <input type="hidden" id="id_doc<?php echo $i?>" value="35" />                                            
                                                            <?php 
                                                            if ($list_veri[$i]==0 ) { ?>
                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo  $i ?>) "  /></td>
                                                                <td>
                                                                    <div class="btn-group"> 
                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $list_com ?></textarea>
                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(35,<?php echo $id ?>,<?php echo $contrato ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                                if (empty($list_com)) {  ?>
                                                                    <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">EN PROCESO</div></td>
                                                                <?php 
                                                                } else { ?>
                                                                    <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-info p-xxs text-mute">OBSERVACION</div></td>
                                                                <?php 
                                                                } ?>                                                                
                                                            <?php 
                                                            } else { ?>
                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" disabled="" checked=""  /></td>
                                                                <td>
                                                                    <div class="btn-group"> 
                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" disabled="" ></textarea>
                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(35,<?php echo $id ?>,<?php echo $contrato ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </td>
                                                                <td style="text-align:center;font-size:14px;font-weight:700"><div class="bg-success p-xxs text-mute">VALIDADO</div></td>
                                                            <?php 
                                                            }  ?>
                                                    </tr>

                                            <?php 
                                            }  ?>
                                            
                                        </tbody>
                                    </table>
                                </div> 
                        
                                <?php } else { ?>

                                    <div style="margin-top: 3%;" class="row">  
                                        <div class="table table-responsive">
                                            <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                                <thead>
                                                    <tr style="background:#010829;color:#fff">
                                                        <th style="width: 3%;" >#</th>
                                                        <th style="width: 97%;">Documentos Acreditados del Trabajador</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                            $i=1;
                                                            foreach ($doc_ta as $row) {
                                                                    
                                                                    
                                                                $sql=mysqli_query($con,"select * from doc where id_doc='$row' ");  
                                                                $result=mysqli_fetch_array($sql);  
                                                                    
                                                                $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$result['documento'].'_'.$rut.'.pdf';
                                                                if ($result['documento']!="Foto del trabajador") { ?>        
                                                                    <tr>                                                                
                                                                        <td><?php echo $i ?></td>
                                                                        <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                                    </tr> 
                                                            <?php } $i++;
                                                            } ?>


                                                            <!-- dcumentos mensuale -->
                                                            <?php    
                                                                    $query_dm=mysqli_query($con,"select d.documento, m.* from mensuales_trabajador as m Left Join doc_mensuales as d On d.id_dm=m.doc where m.verificado=1 and m.trabajador='$id' ");
                                                                    $d=$i;    
                                                                    foreach ($query_dm as $row) {
                                                                        $carpeta_d= 'doc/validados/'.$row['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'_'.$row['mes'].'_'.$row['year'].'.pdf';; 
                                                                ?>

                                                                <tr>
                                                                    <td><?php echo $d ?></td>
                                                                    <td style=""><a href="<?php echo $carpeta_d ?>" target="_blank"><?php echo $row['documento'] ?></a></td>        
                                                                </tr>
                                                                <?php
                                                                   $d++; }  
                                                                ?>
                                                    
                                                            <!-- documentos extras tipo 2 --->    
                                                            <?php
                                                                    $query_de2=mysqli_query($con,"select d.* from documentos_extras as d where d.contrato='".$contrato."' and trabajador='".$_SESSION['trabajador']."' and d.tipo=2 and d.estado=3 ");
                                                                    $result_de=mysqli_fetch_array($query_de2);
                                                                    $cantidad2=mysqli_num_rows($query_de2);
        
                                                                    $j=$d;    
                                                                    # si hay documentos extras tipo 2                                               
                                                                 
                                                                        $existe=0;
                                                                        foreach ($query_de2 as $row) { 
                                                                            $carpeta = 'doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'.pdf'; 
                                                                              
                                                                ?>
                                                                            <tr>    
                                                                                <td><?php echo $j ?></td>
                                                                                <!-- documento  -->
                                                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                                                            </tr>
                                                                        <?php  
                                                                        $j++;}
                                                                        ?>  

                                                            <!-- documentos extras tipo 3 --->    
                                                            <?php
                                                                    $query_de2=mysqli_query($con,"select d.* from documentos_extras as d where d.contrato='".$contrato."' and trabajador='".$_SESSION['trabajador']."' and d.tipo=3 and d.estado=3 ");
                                                                    $result_de=mysqli_fetch_array($query_de2);
                                                                    $cantidad2=mysqli_num_rows($query_de2);
        
                                                                    $e=$j;    
                                                                    # si hay documentos extras tipo 2                                               
                                                                 
                                                                        $existe=0;
                                                                        foreach ($query_de2 as $row) { 
                                                                            $carpeta = 'doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/'.$result_ta['codigo'].'/'.$row['documento'].'_'.$rut.'.pdf'; 
                                                                              
                                                                ?>
                                                                            <tr>    
                                                                                <td><?php echo $e ?></td>
                                                                                <!-- documento  -->
                                                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                                                            </tr>
                                                                        <?php  
                                                                        $e++;}
                                                                        ?>        

                                                        
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                            </div>    
                                    </div>

                                    <?php } ?>                                 


                           <input type="hidden" name="total_doc" id="total_doc" value="<?php echo $i ?>" /> 
                           <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" /> 
                           <input type="hidden" name="rut" id="rut" value="<?php echo $result_trabajador['rut'] ?>" />
                           
                           <?php if ($existe_acreditado==0) { ?> 
                                <div style="border:1px #c0c0c0 solid;border-radius:5px; padding: 0.5% 0%" class="form-group row">
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                            <button style="font-size:16px" class="btn btn-sm btn-success btn-block" type="button" onclick="enviar(<?php echo $i ?>,<?php echo $result_contratista['mandante'] ?>,<?php echo $result_contratista['id_contratista'] ?>)">PROCESAR DOCUMENTOS</button>
                                    </div>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                   </div> 
                 </div>
               </form>
                        <script>
                            function modal_ver_obs(id_doc,id,contrato) {
                                var condicion=0;
                                $('.body').load('selid_ver_obs.php?doc='+id_doc+'&id='+id+'&contrato='+contrato,function(){
                                    $('#modal_ver_obs').modal({show:true});
                                });
                            }
                        </script>
                        
                          <div class="modal fade" id="modal_fecha_val" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Fecha de Acreditaci&oacute;n</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                                    </div>
                                      <?php
                                      include('config/config.php');
                                      ?>   
                                      
                                      <form  method="post" id="frmAsignar"> 
                                        <div class="modal-body">
                                        
                                          <div class="row">
                                               <input type="date" name="fecha_val" id="fecha_val" class="form-control" value="0000-00-00" />
                                               <input type="hidden" name="id" value="<?php echo $_SESSION['trabajador'] ?>" />
                                          </div>
                                          <br />
                                          <div class="row">
                                               <div style="margin-left: 2%;"> <input style="" class="checkboxtexto" name="indefinido" id="indefinido" type="checkbox" value="1" onclick="deshabilitar_fecha()" /> <span style="color: #FF0000;font-weight: bold;font-size: 16px;">&nbsp;&nbsp;Indefinido</span> </div>
                                          </div>
                                       </div>
                                       <div class="modal-footer">
                                                <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
                                                <a style="color: #fff;" class="btn btn-success" href="" onclick="fecha_val(<?php echo $_SESSION['contratista'] ?>)" >Guardar</a>
                                      </div>
                                    </form> 
                                    
                                    <script>
                                        
                                         
                                        function fecha_val(contratista) {
                                              var valores=$('#frmAsignar').serialize();
                                                $.ajax({
                                        			method: "POST",
                                                    url: "add/fecha_val.php",
                                                    data: valores,
                                        			beforeSend: function(){
                                                        $('#modal_cargar').modal('show');						
                                        			},
                                                    success: function(data){			  
                                                     if (data==0) {
                                                            swal({
                                                                title: "Trabajador Validado",
                                                                //text: "Un Documento no validado esta sin comentario",
                                                                type: "success"
                                                              });
                                                            window.location.href='verificar_documentos_trabajador_mandante.php';
                                        			  } else {
                                        			    swal({
                                                            title: "Fecha No Asignada",
                                                            text: "Vuelva a intentar",
                                                            type: "error"
                                                        }); 
                                        			  }
                                        			},
                                                    complete:function(data){
                                                         $('#modal_cargar').modal('hide');
                                                    }, 
                                                    error: function(data){
                                                    }                
                                               });
                                             }
                                      </script>                  
                                   </div>
                                </div>
                             </div> 
            
                           <div class="modal inmodal" id="modal_ver_obs" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div style="background:#e9eafb;color:#282828" class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Historial de Observaciones</h4>
                                        </div>
                                        <div class="body">                                             
                                        </div>                                    
                                   </div>
                                </div>
                             </div> 
                             
                         <div class="modal fade" id="modal_cargar22" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Validando trabajador, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>  

                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
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
    
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>


</body>


</body>

</html>
<?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
