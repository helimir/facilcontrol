<?php
session_start();
if (isset($_SESSION['usuario']) ) { 
    
session_destroy($_SESSION['active']);
$_SESSION['active']=25;
    
include('config/config.php');
$sql_doc=mysqli_query($con,"select * from doc where estado=1  ");
$sql_mandante=mysqli_query($con,"select * from mandantes where email='".$_SESSION['usuario']."'  ");
$result=mysqli_fetch_array($sql_mandante);
$mandante=$result['id_mandante'];

$sql_perfile=mysqli_query($con,"select * from perfiles where id_perfil='".$_SESSION['idperfil']."' ");
$fila_perfil=mysqli_fetch_array($sql_perfile);

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

    <title>FacilControl | Editar Perfil</title>
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
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


<script src="js\jquery-3.1.1.min.js"></script>
<script>
 
    
</script>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style="" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Editar Perfil <?php ?></h2>
                    <!--<ol style="background: #010829;" class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Forms</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Basic Form</strong>
                        </li>
                    </ol>-->
                </div>
                <div class="col-lg-2">

                </div>
        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-md btn-success btn-submenu" href="crear_perfil.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Nuevo Perfil</a>
                                        <a class="btn btn-md btn-success btn-submenu" href="list_perfil.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Perfiles</a>
                                    </div>
                              </div>  
                              
                              <div class="row">
                               <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                               </div>  
                            </div>  
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmPerfil">
                            
                             <div class="row"> 
                                <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2 text-left">
                                    <label class="col-form-label" for="quantity">Nombre</label> 
                                </div>                      
                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <input class="form-control" type="text" name="nombre_perfil" id="nombre_perfil"  placeholder=""  required="" value="<?php echo $fila_perfil['nombre_perfil'] ?>" />
                                </div>
                             </div>
                                                         
                                
                                 <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 1%;">#</th>
                                        <th style="width: 20%;">Documento</th>
                                        <th class="text-rigth" style="width: 5%;">Seleccionar</th>
                                        <th class="text-rigth" style="width: 5%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     <?php $i=1; 
                                        
                                        $doc_perfil=unserialize($fila_perfil['doc']);
                                        foreach ($sql_doc as $row) {
                                        $condicion=false;   
                                        echo '<tr>';
                                            echo '<td><?php'.$i.'</td>'; 
                                            echo '<td><label class="col-form-label">'.$row['documento'].'</label></td>'; 
                                            
                                            foreach ($doc_perfil as $row2) { 
                                                   if ($row2==$row['id_doc']) {
                                                        echo '<td><div class="i-checks"> <input name="doc[]" type="checkbox" value="'.$i.'" checked="" /> </div></td>';
                                                       $condicion=true; 
                                                    } 
                                                  }
                                            if ($condicion==false) {     
                                                echo '<td><div class="i-checks"> <input name="doc[]" type="checkbox" value="'.$i.'"  /> </div></td>';
                                            } 
                                            echo '<td><button class="btn btn-success btn-sm" type="button" onclick="actualizar_perfil()"><i class="fa fa-refresh" aria-hidden="true"></i> Actualizar</button></td>';   
                                       echo '</tr>';
                                     $i++; } ?>
                                    </tbody>
                                </table>
                                
                                
                                
                                <input type="hidden" name="idmandante" value="<?php echo $mandante ?>" />
                                <input type="hidden" name="idperfil" value="<?php echo $_SESSION['idperfil']  ?>" />
                                <input type="hidden" name="accion" value="actualizar" />
                                
                                <!--<div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-md" type="button" onclick="actualizar_perfil()"><i class="fa fa-refresh" aria-hidden="true"></i> Actualizar Perfil</button>
                                    </div>
                                </div>-->
                            </form>
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
                <strong>Copyright</strong> Proyecto &copy; <?php echo $year ?>
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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
   
    
    <script>
        
     function actualizar_perfil(){
     const doc = document.querySelectorAll('input[type=checkbox]:checked'); 
     if(doc.length <= 0){
        swal({
            title: "Lista Vacia",
            text: "Debe seleccionar al menos un documento",
            type: "warning"
        });   
     } else {
        var valores=$('#frmPerfil').serialize();
        $.ajax({
            method: "POST",
            url: "get_perfil.php",
            data: valores,
            success: function(data){
             if (data==0) {   
                swal({
                    title: "Perfil Actualizado",
                    //text: "Un Documento no validado esta sin comentario",
                    type: "success"
                });
                setTimeout(
                    function() {
	                   window.location.href='list_perfil.php';
                    },3000);
                //window.location.href='list_perfil.php';
            } else {
                swal({
                    title:"Perfil No Actualizado",
                    text: "Por favor, vuelva a intentar",
                    type: "error"
                });
            } 
          }    
        });
      }   
    }
        
        
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
                
                $('.demo1').click(function(){
                    swal({
                        title: "Welcome in Alerts",
                        text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                    });
                    
                });
        
                $('.demo2').click(function(){
                    swal({
                        title: "Plato Agregado",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                });
        
                $('.demo3').click(function () {
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }, function () {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    });
                });
        
                $('.demo4').click(function () {
                    swal({
                                title: "Are you sure?",
                                text: "Your will not be able to recover this imaginary file!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: false,
                                closeOnCancel: false },
                            function (isConfirm) {
                                if (isConfirm) {
                                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                } else {
                                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                                }
                            });
                }); 
                
                
            });


    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="index.php"; </script>';
}

?>
