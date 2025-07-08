<?php
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

//$regiones= consulta_general('regiones');
$regiones=mysqli_query($con,"Select * from regiones ");
$bancos=mysqli_query($con,"SELECT * from bancos");
$afps=mysqli_query($con,"SELECT * from afp");
$salud=mysqli_query($con,"SELECT * from salud"); 
$fcargos=mysqli_query($con,"SELECT * from cargos where estado=1");
$contratistas=mysqli_query($con,"SELECT id_contratista from contratistas where rut='".$_SESSION['usuario']."' ");
$fcontratista=mysqli_fetch_array($contratistas);

$contratos=mysqli_query($con,"SELECT * from contratos where estado=1 and contratista='".$fcontratista['id_contratista']."' ");

$query_extras=mysqli_query($con,"SELECT d.estado as estado_de, c.id_contratista, c.razon_social, o.nombre_contrato, d.* from documentos_extras as d LEFT JOIN contratistas as c On id_contratista=d.contratista LEFT JOIN contratos as o On o.id_contrato=d.contrato  where  d.mandante='".$_SESSION['mandante']."' order by d.id_de DESC ");
$existe_extra=mysqli_num_rows($query_extras);
    
$idcontratista=$fcontratista['id_contratista'];
$idtrabajador=$_GET['idtrabajador'];

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

if (!empty($idtrabajador)) {
    $qconstancia=mysqli_query($con,"select * from constancia where idtrabajador='".$idtrabajador."' ");
    $fconstancia=mysqli_fetch_array($qconstancia);
    
    $qcarga=mysqli_query($con,"select * from carga where idtrabajador='".$idtrabajador."' ");
    $fcarga=mysqli_fetch_array($qcarga);
    
    $contcarga=mysqli_query($con,"select count(*) total from carga where idtrabajador='".$idtrabajador."' ");
    $totalcarga=mysqli_fetch_array($contcarga);
    
    $qtrabajador=mysqli_query($con,"select t.pcontrato1, t.pcontrato2, t.estado, t.idtrabajador, t.tpantalon, t.tpolera, t.tzapatos, t.banco as idbanco,t.afp as idafp, t.cargo as idcargo, t.region,t.comuna, t.rut, t.nombre1, t.nombre2, t.apellido1, t.apellido2, t.direccion1, t.direccion2, t.estadocivil, t.email, t.telefono, t.dia, t.mes, t.ano, t.tipocargo, t.licencia, t.tipolicencia, t.acreditacion, t.adia, t.ames, t.aano, t.observacion, t.cuenta, t.tipocuenta, r.Region, c.Comuna, a.cargo, b.banco, f.afp, s.institucion, s.idsalud  from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna 
    LEFT JOIN cargos a ON a.idcargo=t.cargo 
    LEFT JOIN bancos b ON idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud
    where t.idtrabajador=$idtrabajador ");
    $ftrabajador=mysqli_fetch_array($qtrabajador);
}

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Crear Documentos Extras</title> 
     <!-- Favicons -->
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


<script>


    $(document).ready(function(){
        $('#menu-doc-extras').attr('class','active');
        $('.footable').footable();
             
    });
    
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

    

  
  function seltipo(id){
    //alert(id);
    // si tipo es contratista 
    if (id==1) {
        $("#div_contratistas").show();         
        $("#div_trabajador_contratos").hide();
        $("#div_contratos").hide();
        $("#div_list_contratos").hide(); 
        
        
    // si tipo trabajador     
    } 
    if (id==2){
        $("#div_contratistas").hide();         
        $("#div_trabajador_contratos").show();
        $("#div_list_contratos").hide();

    }
    
    if (id==0){
        $("#div_contratistas").hide();         
        $("#div_trabajador_contratos").hide();
    }    
 }    
 
 function selct(id){
    //alert(id);
    // trabajadores todos de un contrato 
    if (id==3) {
        $("#div_contratos").show();         
        $("#div_list_contratos").hide();
        $("#div_list_contratos_cargos").hide();
        
        
    // trabajadores individuales de contrato     
    } 
    if (id==4){
        $("#div_contratos").hide();         
        $("#div_list_contratos_cargos").hide();
        $("#div_list_contratos").show();
    }

    if (id==5){
        $("#div_contratos").hide();     
        $("#div_list_contratos").hide();    
        $("#div_list_contratos_cargos").show();
    }
    
    if (id==0){
        
        $("#div_contratos").hide();         
        $("#div_list_contratos").hide();
    }    
 }
 
 function selcontratos(id) {
     //alert(id);
     if (id==0) {
        $("#div_list_contratos").show();
     } else {
        
        var nombre_doc=$('#nombre_doc').val();
        if (nombre_doc!='') {
            $('.body').load('selid_list_contratos.php?contrato='+id,function(){
            $('#modal_list_contratos').modal({show:true});
        });
        } else {
            swal({
                title: "Falta nombre del documento",
                type: "warning"
            }); 
            $('#de_trabajadores_contratos_t').get(0).selectedIndex = 0;
        }
    }
 }

 function selcontratos_cargos(id) {
     //alert(id);
     if (id==0) {
        $("#div_list_contratos_cargos").show();
     } else {
        var nombre_doc=$('#nombre_doc').val();
        if (nombre_doc!='') {
            $('.body').load('selid_list_cargos.php?contrato='+id,function(){
                $('#modal_list_cargos').modal({show:true});
            });
        } else {
            swal({
                title: "Falta nombre del documento",
                type: "warning"
            });
            $('#de_trabajadores_contratos_c').get(0).selectedIndex = 0;
        }   
    }
 }

function crear_doc() {
    var arreglo_contratistas=[];
    var arreglo_contratos=[];
    var mandante=$('#mandante').val();
    var nombre_doc=$('#nombre_doc').val();
    var tipo=$('#tipo').val();
    var tipo_doc=$('#de_trabajadores_contratos').val();
    var cantidad=$('#cant_contratistas').val();
    var cantidad_c=0;
    var cantidad2=$('#cant_contratos').val();
    var cantidad_t=0;
    
    var i=0;
    var chequeado=false;  
    for (i=0;i<=cantidad-1;i++) {
          if ( $('#idcon_de'+i).prop('checked') ) {
            var chequeado=true;
            var valor_contratista=$('#idcon_de'+i).val();
            arreglo_contratistas.push(valor_contratista);
            cantidad_c++; 
          } 
     }
     
     var i=0;
     var chequeado_t=false;  
     for (i=0;i<=cantidad2-1;i++) {
          if ( $('#idtra_de'+i).prop('checked') ) {
            var chequeado_t=true;
            var valor_contrato=$('#idtra_de'+i).val();
            arreglo_contratos.push(valor_contrato);
            cantidad_t++; 
          } 
      }  
       
    
    //alert(cantidad_c);    
    
    // si tiene nombre el documento
    if (nombre_doc!='') {
        
        // si se ha seleccionado un tipo
        if (tipo!=0) {
            
            // si tipo es contratista
            if (tipo==1) {
                
                // si se ha seleccionado al menos una contratista
                if (chequeado==true) {
                    
                    var contratistas=JSON.stringify(arreglo_contratistas);
                    var mandante=$('#mandante').val();
                    
                    var formData = new FormData();
                    formData.append('contratistas',contratistas);
                    formData.append('nombre_doc', nombre_doc );
                    formData.append('mandante', mandante );
                    formData.append('cantidad_c', cantidad_c );
                    formData.append('tipo', tipo );
                    formData.append('tipo_doc', tipo_doc );
                    
                    $.ajax({
                        url: 'add/adddoc_extra.php',
                        type: 'post',
                        data:formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $('#modal_cargar').modal('show');						
             			},
                        success: function(data){
                            if (data==0) {
                                swal({
                                    title: "Documento Creado",
                                    type: "success" 
                                });
                                window.location.href='crear_doc_extra.php';
                                                                          
                            } else {
                                swal({
                                     title: "Documento No Creado",
                                     type: "erroe"
                                 });	  
             			    };
                        },
                        complete:function(data){
                            $('#modal_cargar').modal('hide');
                        }, 
                        error: function(data){
                        }
                    });     
                // sino se ha seleccionado una contratista                    
                } else {
                     swal({
                         title: "Debe seleccionar al menos una contratista",
                         type: "warning"
                     });   
                }
            
               
            } 
            
            // si tipo es trabajadores 
            if (tipo==2) {
                
                if (tipo_doc==3) {
                    
                    // si se ha seleccionado al menos una contratista
                    if (chequeado_t==true) {
                        
                        var contratos=JSON.stringify(arreglo_contratos);
                        var mandante=$('#mandante').val();
                        
                        var formData = new FormData();
                        formData.append('contratos',contratos);
                        formData.append('nombre_doc', nombre_doc );
                        formData.append('mandante', mandante );
                        formData.append('cantidad_t', cantidad_t );
                        formData.append('tipo', tipo );
                        formData.append('tipo_doc', tipo_doc );
                        
                        $.ajax({
                            url: 'add/adddoc_extra.php',
                            type: 'post',
                            data:formData,
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                $('#modal_cargar').modal('show');						
                            },
                            success: function(data){
                                if (data==0) {
                                    swal({
                                        title: "Documento Creado",
                                        type: "success"
                                    });
                                    window.location.href='crear_doc_extra.php';
                                                                            
                                } else {
                                    swal({
                                        title: "Documento No Creado",
                                        type: "erroe"
                                    });	  
                                };
                            },
                            complete:function(data){
                                $('#modal_cargar').modal('hide');
                            }, 
                            error: function(data){
                            }
                        });     
                    // sino se ha seleccionado una contratista                    
                    } else {
                        swal({
                            title: "Debe seleccionar al menos un contrato",
                            type: "warning"
                        });   
                    }     

                }

                if (tipo_doc==4) {

                    var cantidad_t=$('#cant_trabajadores').val();
                    alert(cantidad_t)    
                }

                
            }
        
        // sino se ha seleccionado un tipo    
        } else {
           swal({
                title: "Seleccione un Tipo documento",
                type: "warning"
            }); 
        }
    
    // si documento no tiene nombre    
    } else {
        swal({
                title: "Falta nombre del documento",
                type: "warning"
        });
    }   
        
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
                    <h2 style="color: #010829;font-weight: bold;"> Crear Documento Extraordinario <?php #echo $_SESSION['mandante']   ?> </h2>
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
                                    <h3 class="form-label">Crear Nuevo Documento Extraordinario</h3>
                                </div>
                            </div>
                            
                            <form  method="post"  enctype="multipart/form-data" id="frmTrabajador">                                  
                                <div class="row form-group">
                                  
                                    <div class="col-lg-12">
                                        <div class="ibox ">
                                            
                                            <!-- nombre del documento -->            
                                            <div class="row"> 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Nombre</label>                                                            
                                                <div class="col-sm-3">
                                                    <input style="border:1px solid #969696" class="form-control" type="text" name="nombre_doc" id="nombre_doc" placeholder="" onblur="validar(1)"  required="">
                                                    <span style="color: #FF0000;font-weight: bold;" id="lbl_nombre_doc" class="form-label" ></span>
                                                </div>
                                            </div>
                                                         
                                          <!-- tipo del documento -->              
                                          </br>
                                          <div class="row"> 
                                                    <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Tipo Documento </label>                                                 
                                                    <div class="col-sm-3">
                                                        <div class="form-wrap">
                                                            <select style="border:1px solid #969696" name="tipo" id="tipo" class="form-control" onchange="seltipo(this.value)">
                                                                <option value="0" selected="">Seleccione Tipo</option>
                                                                <option value="1" >Empresas</option>
                                                                <option value="2" >Trabajadores</option>    
                                                            </select>
                                                        </div>
                                                    </div>                                                                                               
                                            </div>
                                            
                                            <!-- si es por contratistas -->
                                            <div id="div_contratistas" style="display: none;margin-top:1.5%" class="row"> 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Contratistas</label>                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                   <button class="btn btn-success btn-block" type="button" onclick="contratistas()">Seleccionar Contratistas</button>
                                                </div>                                                                                               
                                            </div>
                                            
                                            <!-- si es por trabajadores contratos/trabajafores -->
                                            <div id="div_trabajador_contratos" style="display: none;margin-top:1.5%" class="row">                                                 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Contratos/Trabajadores</label>
                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="form-wrap">
                                                        <select style="border:1px solid #969696" name="de_trabajadores_contratos" id="de_trabajadores_contratos" class="form-control" onchange="selct(this.value)">
                                                            <option value="0" selected="" >Seleccione Opci&oacute;n</option>
                                                            <option value="3">Trabajadores Todos de un Contrato</option>
                                                             <!--<option value="4">Trabajadores Individuales Contrato </option>    
                                                           <option value="5">Trabajadores por Cargos </option>-->
                                                        </select>
                                                    </div>
                                                </div>                                                                                               
                                            </div>
                                            
                                            <!-- si es por contratos contratos -->
                                            <div id="div_contratos" style="display: none;margin-top:1.5%" class="row">                                                 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Contratos</label>                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                   <button class="btn btn-success btn-block" type="button" onclick="contratos()">Seleccionar contrato</button>
                                                </div>                                                                                               
                                            </div>
                                            
                                            <!-- contratos/trabajafores -->
                                            <div id="div_list_contratos" style="display: none;margin-top:1.5%" class="row"> 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Lista Contratos</label>                                                
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="form-wrap">
                                                        <select style="border:1px solid #969696" name="de_trabajadores_contratos_t" id="de_trabajadores_contratos_t" class="form-control" onchange="selcontratos(this.value)">
                                                            <option value="0" selected="" >Seleccionar Contratos</option>
                                                            
                                                            <?php 
                                                                 $query=mysqli_query($con,"select m.acreditada, c.* from contratos as c Left Join contratistas_mandantes as m On m.contratista=c.contratista where m.acreditada=1 and c.mandante='".$_SESSION['mandante']."' group by c.id_contrato "); 
                                                                 
                                                                 foreach ($query as $row ) {

                                                                    # trabajadores asignados
                                                                    $query_a=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$row['id_contrato']."' ");
                                                                    $result_a=mysqli_num_rows($query_a);

                                                                    # si trabajadores asignados es mayor que cero (0)
                                                                    #if ($result_a>0) {

                                                                        # trabajadores acreditados
                                                                        $query_t=mysqli_query($con,"select * from trabajadores_acreditados where contrato='".$row['id_contrato']."' ");
                                                                        $result_t=mysqli_num_rows($query_t); 
                                                                        
                                                                        # si trabajadores acreditados es igual a los asignados
                                                                        #if ($result_t==$result_a) { 
                                                                            echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                                        #}  
                                                                    #}    
                                                                 }   
                                                            
                                                            ?>
                                                              
                                                        </select>
                                                    </div>
                                                </div>                                                                                               
                                            </div>


                                            <!-- contratos/trabajafores para opcion cargos -->
                                            <div id="div_list_contratos_cargos" style="display: none;margin-top:1.5%" class="row"> 
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#292929;font-weight:bold"  class="col-2 col-form-label">Lista Contratos</label>
                                                <div class="form-group col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                                    <div class="form-wrap">
                                                        <select style="border:1px solid #969696" name="de_trabajadores_contratos_c" id="de_trabajadores_contratos_c" class="form-control" onchange="selcontratos_cargos(this.value)">
                                                            <option value="0" selected="" >Seleccionar Contratos</option>
                                                            
                                                            <?php 
                                                                 $query=mysqli_query($con,"select m.acreditada, c.* from contratos as c Left Join contratistas_mandantes as m On m.contratista=c.contratista where m.acreditada=1 and c.mandante='".$_SESSION['mandante']."' group by c.id_contrato "); 
                                                                 
                                                                 foreach ($query as $row ) {

                                                                    # trabajadores asignados
                                                                    $query_a=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$row['id_contrato']."' ");
                                                                    $result_a=mysqli_num_rows($query_a);

                                                                    # si trabajadores asignados es mayor que cero (0)
                                                                    #if ($result_a>0) {

                                                                        # trabajadores acreditados
                                                                        $query_t=mysqli_query($con,"select * from trabajadores_acreditados where contrato='".$row['id_contrato']."' ");
                                                                        $result_t=mysqli_num_rows($query_t); 
                                                                        
                                                                        # si trabajadores acreditados es igual a los asignados
                                                                        #if ($result_t==$result_a) { 
                                                                            echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                                        #}  
                                                                    }    
                                                                 #}   
                                                            
                                                            ?>
                                                              
                                                        </select>
                                                    </div>
                                                </div>                                                                                               
                                            </div>
                                            
                                           
                                           
                                                                                        
                                        
                                                   
                                    </div>           
                                    <input type="hidden" name="mandante" id="mandante" value="<?php echo $_SESSION['mandante'] ?>" />                                                                                                              
                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="form-wrap">
                                                <button name="" id="creardoc" class="btn btn-success btn-md" type="button" onclick="crear_doc()" value="" >Crear Documento</button>
                                            </div>
                                        </div>
                                    </div>-->
                                    
                                    
                                  </div>

                                                                      
                                </div>

                        </form>
                        <hr>             
<!----------------------------------- reporte doc extras ---------------------------------------------------------------------------->                               
                        <div class="row form-group" >
                            <div class="col-lg-12"> 
                                 <h3 class="form-label">Reporte de Documentos Extraordinarios</h3>
                            </div>
                        </div>                        
                        <div class="row form-group" >
                           <div class="col-lg-12"> 
                            <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un documento">-->
                                <div class="table-responsive">
                                     <table style="100%;"  class="table footable" data-page-size="25" data-filter="#filter">
                                       <thead class="cabecera_tabla">
                                            <tr style="font-size: 12px;">
                                                <th style="width: 10%;border-right:1px #fff solid" >Acción</th>
                                                <th style="width: 20%;border-right:1px #fff solid" >Documento</th>
                                                <th style="width: 20%;border-right:1px #fff solid" >Contratista</th>
                                                <th style="width: 15%;border-right:1px #fff solid" >Contrato</th>
                                                <th style="width: 10%;border-right:1px #fff solid" >Tipo</th>
                                                <th style="width: 10%;border-right:1px #fff solid" >Fecha</th>
                                                <th style="width: 15%;text-align: center;border-right:1px #fff solid" >Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($existe_extra>0) {  
                                                foreach ($query_extras as $row) { 
                                                    
                                                    switch ($row['tipo']) {
                                                        case '1': $tipo='Contratista';break;
                                                        case '2': $tipo='Contrato';break;
                                                        case '3': $tipo='Trabajadores';break;
                                                    }

                                                    switch ($row['estado']) {
                                                        case 0: $estado='NO RECIBIDO';$class='bg-danger p-xxs'; break;
                                                        case 1: $estado='EN PROCESO';$class='bg-info p-xxs'; break;
                                                        case 2: $estado='OBSERVACION';$class='bg-info p-xxs'; break;
                                                        case 3: $estado='VALIDADO';$class='bg-success p-xxs'; break;

                                                    }

                                                    $fecha=substr($row['creado'],0,10);

                                                    ?>   
                                                    <tr>
                                                        <?php
                                                            if ($row['estado_de']==3 or $row['estado_de']==0) {?>
                                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-secondary btn-xs" type="button" disabeld ><small>GESTIONAR</small></button></td>
                                                        <?php } else {   ?>        
                                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-success btn-xs" type="button" onclick="gestionar(<?php echo $row['contrato'] ?>,<?php echo $row['id_contratista'] ?>,<?php echo $row['tipo'] ?>)"><small>GESTIONAR</small></button></td>
                                                                
                                                        <?php } ?>                                                           
                                                        <td><?php echo $row['documento'] ?></td>
                                                        <td><?php echo $row['razon_social'] ?></td>
                                                            <?php if ($row['tipo']==1) { ?>
                                                                    <td>NO APLICA</td>  
                                                            <?php } else { ?>
                                                                    <td><?php echo $row['nombre_contrato'] ?></td> 
                                                            <?php }  ?>
                                                        <td><?php echo $tipo ?></td>
                                                        <td><?php echo $fecha ?></td>
                                                        <td style="text-align:center;font-size:12px;font-weight:700"><div class="<?php echo $class ?>"><?php echo $estado ?></div></td>
                                                    </tr>


                                            <?php
                                                } 
                                            } ?>    
                                        </tbody>
                                        <tfoot>
                                        </tbody>    
                                    </table>
                                </div>
                            </div>
                        </div>
                            
                            
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
            
            
        <script>
            function contratistas() {
                var nombre_doc=$('#nombre_doc').val();
                if (nombre_doc!='') {
                    $('#modal_contratistas_extra').modal({show:true})
                } else {
                    swal({
                            title: "Falta nombre del documento",
                            type: "warning"
                    });
                    $('#tipo').get(0).selectedIndex = 0;
                }     
            }
            
            function contratos() {
                var nombre_doc=$('#nombre_doc').val();
                if (nombre_doc!='') {
                    $('#modal_contratos').modal({show:true})
                } else {
                    swal({
                            title: "Falta nombre del documento",
                            type: "warning"
                    });
                    $('#de_trabajadores_contratos').get(0).selectedIndex = 0;
                }    
            }               
            
                            
            
        </script>

                            
        
        <!-- modal contratistas --->
        <div class="modal inmodal" id="modal_contratistas_extra" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                        <h4 style="font-weight:bold;" id="titulo" class="modal-title">Seleccionar Contratista</h4>
                        <span>Puede crear documento a Contratista Acreditada</span>
                    </div>
                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select cm.acreditada as acreditacion, cm.*, c.* from contratistas_mandantes as cm Left Join contratistas as c On c.id_contratista=cm.contratista  where cm.mandante='".$_SESSION['mandante']."'    ");
                    
                    $activo=0;
                    
                    ?>        
                    <form method="post" id="frmContratistas">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        <?php $i=0; foreach ($query as $row) {   ?> 
                                            <tr>    
                                                <?php if ($row['acreditacion']==1) { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="idcon_de<?php echo $i ?>" name="contratistas_de[]" type="checkbox" value="<?php echo $row['id_contratista'] ?>" /> </div></td>
                                                <?php } else { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="idcon_de<?php echo $i ?>" name="contratistas_de[]" type="checkbox" value="<?php echo $row['id_contratista'] ?>" disabled /> </div></td>
                                                <?php } ?>    
                                                <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['razon_social'] ?></label></td>
                                            </tr>
                                        <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>
                        
                    </div>
                    <input type="hidden" id="cant_contratistas" value="<?php echo $i ?>" />   
                    <input type="hidden" id="tipo_doc" value="1" />
                    <input type="hidden" id="mandante" value="<?php echo $_SESSION['mandante'] ?>" />
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>                        
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratistas_p(<?php echo $i ?>)">Crear Documento</button>                        
                    </div>
                    </form>    
                    <script>
                        function asignar_contratistas_p(cantidad) {
                            var arreglo_contratistas=[];  
                            var mandante=$('#mandante').val();
                            var nombre_doc=$('#nombre_doc').val();
                            var tipo_doc=1;
                            var cantidad_c=0;  
                            var i=0;
                            var chequeado=false;  
                            
                            for (i=0;i<=cantidad-1;i++) {
                                if ( $('#idcon_de'+i).prop('checked') ) {
                                    var chequeado=true;
                                    var valor_contratista=$('#idcon_de'+i).val();
                                    arreglo_contratistas.push(valor_contratista);
                                    cantidad_c++; 
                                } 
                            }
                             
                            if ( chequeado==true) {
                                
                                var contratistas=JSON.stringify(arreglo_contratistas);
                                
                                var formData = new FormData();
                                formData.append('contratistas',contratistas);
                                formData.append('nombre_doc', nombre_doc );
                                formData.append('mandante', mandante );
                                formData.append('cantidad_c', cantidad_c );
                                formData.append('tipo', tipo_doc );
                                $.ajax({
                                    url: 'add/adddoc_extra.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function(){                                    
                                        $('#modal_cargar').modal('show');						
                                    },
                                    success: function(data){ 
                                        if (data==0) {
                                            swal({ 
                                                title: "Documento Creado",
                                                type: "success"
                                            });
                                            window.location.href='crear_doc_extra.php';
                                                                                     
                                        } else {
                                            swal({
                                                title: "Documento No Creado",
                                                type: "erroe"
                                            });	  
                                        };
                                    },
                                    complete:function(data){
                                        $('#modal_cargar').modal('hide');
                                    }, 
                                    error: function(data){
                                    }
                                }); 
                                
                                //alert(contratistas+'-'+nombre_doc);
                            } else {
                                swal({
                                    title: "Debe seleccionar al menos una contratista",
                                    type: "warning"
                                });   
                            }    
                            
                           //var valores=$('#frmContratistas').serialize();
                           //alert(valores);
                          //$.ajax({
                    		//	method: "POST",
                            //    url: "sesion/session_contratistas_de.php",
                            //    data: valores,
                    		//	success: function(data){
                    		//	     $('#modal_contratistas').modal('hide') 
                    		//	}                
                            //});
                        }
                    </script>                         
                </div>
            </div>
        </div>
         
        <!-- modal seleccionar todos los trabajadores del contrato --> 
         <div class="modal inmodal" id="modal_contratos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                        <h4 style="font-weight:bold;" id="titulo" class="modal-title">Seleccionar Contrato</h4>
                        <span>Puede crear documento a Contratos con Trabajadores Acreditados</span>
                    </div>
                    <?php

                    session_start(); 
                    include('config/config.php');
                                        
                    $query=mysqli_query($con,"select * from contratos  where mandante='".$_SESSION['mandante']."'     ");
                    
                    
                    ?>        
                    <form method="post" id="frmContratos">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        <?php 
                                              $i=0;                                               
                                              foreach ($query as $row) {    

                                                # trabajadores asignados
                                                #$query_a=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$row['id_contrato']."' and mandante='".$_SESSION['mandante']."' ");
                                                #$result_a=mysqli_num_rows($query_a);
                                                
                                                # trabajadores acreditados
                                                $query_t=mysqli_query($con,"select * from trabajadores_acreditados where contrato='".$row['id_contrato']."' ");
                                                $result_t=mysqli_num_rows($query_t); 
                                                ?>
                                                <tr>                            
                                                    <?php if ($result_t>0) { ?>
                                                        <td style="width: 2%;"><div class=""> <input class="form-control" id="idtra_de<?php echo $i ?>" name="contratos_de[]" type="checkbox" value="<?php echo $row['id_contrato'] ?>" /> </div></td>
                                                    <?php } else { ?>
                                                        <td style="width: 2%;"><div class=""> <input class="form-control" id="idtra_de<?php echo $i ?>" name="contratos_de[]" type="checkbox" value="<?php echo $row['id_contrato'] ?>" disabled /> </div></td>
                                                    <?php } ?>
                                                    <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['nombre_contrato'] ?></label></td>
                                                        
                                                </tr>
                                                        
                                                <?php
                                                $i++; 
                                            } 
                                        ?>
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>
                        
                    </div>
                    <input type="hidden" id="cant_contratos" value="<?php echo $i ?>" />
                    <input type="hidden" id="tipo_doc" value="2" />   
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                        <?php if ($accion==TRUE) { ?>
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratos_p(<?php echo $i ?>)">Enviar Solicitud</button>
                        <?php } else { ?>
                            <button style="color: #fff;" class="btn btn-secondary btn-md" type="button" name="asignar" disabled="">Enviar Solicitud</button>   
                        <?php }  ?>        
                    </div>
                    </form>    
                    <script>
                        function asignar_contratos_p(cantidad) {

                            var arreglo_contratos=[];  
                            var mandante=$('#mandante').val();
                            var nombre_doc=$('#nombre_doc').val();
                            var tipo_doc=2;
                            var cantidad_t=0;  
                            var i=0;
                            var chequeado=false;

                            for (i=0;i<=cantidad-1;i++) { 
                                if ( $('#idtra_de'+i).prop('checked') ) {
                                    var chequeado=true;
                                    var valor_contrato=$('#idtra_de'+i).val();
                                    arreglo_contratos.push(valor_contrato);
                                    cantidad_t++; 
                                } 
                            } 
                            
                            if (chequeado==true) {

                                var contratos=JSON.stringify(arreglo_contratos);
                                
                                var formData = new FormData();
                                formData.append('contratos',contratos);
                                formData.append('nombre_doc', nombre_doc);
                                formData.append('mandante', mandante );
                                formData.append('cantidad_t', cantidad_t);
                                formData.append('tipo', tipo_doc );
                                
                                $.ajax({
                                    url: 'add/adddoc_extra.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function(){
                                        $('#modal_cargar').modal('show');						
                                    },
                                    success: function(data){ 
                                        if (data==0) {
                                            swal({ 
                                                title: "Solicitud Enviada",
                                                type: "success"
                                            });
                                            window.location.href='crear_doc_extra.php';
                                                                                     
                                        } else {
                                            swal({
                                                title: "Disculpe! Error de sistema. Vuelva a intentar",
                                                type: "errors"
                                            });	  
                                        };
                                    },
                                    complete:function(data){
                                        $('#modal_cargar').modal('hide');
                                    }, 
                                    error: function(data){
                                    }
                                }); 
                                
                                //alert(contratistas+'-'+nombre_doc);    

                            } else {
                                swal({
                                    title: "Debe seleccionar al menos una contrato",
                                    type: "warning"
                                });   
                            }
                        }
                    </script>                 
                </div>
            </div>
        </div>
        
        
        <!-- modal list contrato --> 
         <div class="modal fade" id="modal_list_contratos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Trabajadores</h3>
                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="body">
                    </div>             
                </div>
            </div>
        </div>


        <!-- modal list contrato --> 
        <div class="modal fade" id="modal_list_cargos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Cargo</h3>
                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
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
                                  <h3>Creando Documento, por favor espere un momento</h3>
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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>

     <!-- FooTable -->
     <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    

</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
