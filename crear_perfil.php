<?php
include('sesion_manager.php');
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 
    
include('config/config.php');
$sql_doc=mysqli_query($con,"select * from doc where estado=1  ");

$sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
$result=mysqli_fetch_array($sql_mandante);
$mandante=$result['id_mandante'];


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

     <title>FacilControl | Crear Perfil</title>
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
      
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="loader.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="js\jquery-3.1.1.min.js"></script>
<script>


            $(document).ready(function () {
                
                $('#menu-perfiles').attr('class','active');
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                }); 
                
                
            });
    
 
   function validar() {
        var item=$('#nombre_perfil').val();
        if (item=='') {
            $("#lbl_nombre_perfil").html("<span><small><b>*NOMBRE DE PERFIL REQUERIDO</b></small></span>");
        }
   } 
   function sel_doc(id) {
        var isChecked = $('#doc_perfil'+id).prop('checked');
        if (isChecked) {
            document.getElementById("doc"+id).style.fontWeight = "bold";
        } else {
            document.getElementById("doc"+id).style.fontWeight = "Normal";
        }
      }
    
</script>

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

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10"> 
                    <h2 style="color: #010829;font-weight: bold;">CREAR PERFIL DE CARGOS <?php #echo $_SESSION['usuario'] ?></h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="form-group row">
                                    <div class="col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu"  href="crear_contratista.php" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i>Crear Contratista</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_perfil.php" class=""><i class="fa fa-chevron-right" aria-hidden="true"></i>Reporte de Perfiles</a>
                                        
                                    </div>
                            </div>  
                            <?php include('resumen.php') ?>  
                            <div class="row">
                                   <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                    <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                   </div>  
                            </div>
                              
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmPerfil">
                            
                             <div class="row"> 
                                <div class="form-group col-lg-3 col-md-12 col-sm-12 col-xs-12 text-left">
                                    <label style="#282828;font-weight:bold" class="col-form-label" for="quantity">Nombre del Perfil de Cargos</label> 
                                </div>                      
                                <div class="form-group col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <input class="form-control" type="text" name="nombre_perfil" id="nombre_perfil"  placeholder="escriba un nombre para el perfil" onBlur="validar()"  required=""/>
                                    <span style="color: #FF0000" id="lbl_nombre_perfil" class="form-label" ></span>
                                </div>
                             </div>
                                                         
                                
                                 <table class="table">
                                    <thead class="">
                                        <tr >
                                            <th style="width: 10%;">Seleccionar</th>
                                            <th class="text-rigth" style="width: 90%;">Documento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i=0; 
                                        foreach ($sql_doc as $row) {    
                                            if ($row['documento']!="Foto del trabajador") { ?>
                                                <tr>                                          
                                                    <td><input class="form-control" id="doc_perfil<?php echo $i ?>"  name="doc[]" type="checkbox" value="<?php echo $row['id_doc'] ?>" onclick="sel_doc(<?php echo $i ?>)" /> </td>
                                                    <td><label id="doc<?php echo $i ?>" class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                </tr>
                                    <?php 
                                        }
                                    $i++;
                                     } ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                   <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                    <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                   </div>  
                                </div>  
                                
                                
                                <input type="hidden" name="idmandante" value="<?php echo $mandante ?>" />
                                
                                <div style="border:1px #c0c0c0 solid;border-radius;5px;padding:1% 0%" class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-lg"  type="button" onclick="crear_perfil()"><strong>CREAR PERFIL DE CARGOS</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                        <!-- modal cargando--->
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando Perfil, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>
        
        <?php echo include('footer.php') ?>

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
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
       <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
        <script>
      
            
   function prueba(id) {
    alert($('input:checkbox[name=2]:checked').val());
   }       
    
   
    function crear_perfil(){
      //alert('hola');
      var nombre=$('#nombre_perfil').val();
      if (nombre!="") {
          const doc = document.querySelectorAll('input[type=checkbox]:checked'); 
         if(doc.length <= 0){
            Swal.fire({
                title: "Lista Vacía",
                icon: "warning",
                draggable: true
            });
         } else {
              var valores=$('#frmPerfil').serialize();
              $.ajax({
        			method: "POST",
                    url: "add/addperfil.php",
                    data: valores,
                     beforeSend: function(){
                        $('#modal_cargar').modal('show');						
        			},
        			success: function(data){			  
                     if (data==0) {                        
                         Swal.fire({
                                title: "Perfil Creado",
                                icon: "success",
                                draggable: true
                            });
                         setTimeout(window.location.href='list_perfil.php', 3000);
        			  } else {
        			     if (data==1) { 
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Error de sistema! Vuelva a intentar",
                            });
                         }
                         if (data==2) { 
                            Swal.fire({
                                title: "Nombre de Perfil Ya Existe",
                                icon: "warning",
                                draggable: true
                            });
                         }                          
                            
        			  }
        			},
                    complete:function(data){
                        $('#modal_cargar').modal('hide');
                    }, 
                    error: function(data){
                    }                 
                });
             }  
        } else {
            Swal.fire({
                title: "Falta Nombre del Perfil",
                icon: "warning",
                draggable: true
            });
        }                   
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
