<?php
session_start();
if (isset($_SESSION['usuario']) ) { 

$id=$_GET['id'];
   
include('config/config.php');
$mandante=mysqli_query($con,"Select * from mandantes where id_mandante='$id' ");
$result=mysqli_fetch_array($mandante);
$regiones=mysqli_query($con,"select * from regiones");
$giro=isset($result['giro']) ? $result['giro']: '';
$descripcion=isset($result['descripcion_giro']) ? $result['descripcion_giro']: '';
$nombre=isset($result['nombre_fantasia']) ? $result['nombre_fantasia']: '';
$razon=isset($result['razon_social']) ? $result['razon_social']: '';
$rut_empresa=isset($result['rut_empresa']) ? $result['rut_empresa']: '';
$rut_representante=isset($result['rut_representante']) ? $result['rut_representante']: '';
$representante=isset($result['representante_legal']) ? $result['representante_legal']: '';
$dir_comercial_region=isset($result['dir_comercial_region']) ? $result['dir_comercial_region']: '';
$dir_comercial_comuna=isset($result['dir_comercial_comuna']) ? $result['dir_comercial_comuna']: '';
$dir_matriz_region=isset($result['dir_matriz_region']) ? $result['dir_matriz_region']: '';
$dir_matriz_comuna=isset($result['dir_matriz_comuna']) ? $result['dir_matriz_comuna']: '';
$administrador=isset($result['administrador']) ? $result['administrador']: '';
$fono=isset($result['fono']) ? $result['fono']: '';
$email=isset($result['email']) ? $result['email']: '';

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

    <title>FacilControl | Editar Mandante</title>
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


<script src="js\jquery-3.1.1.min.js"></script>
<script>

function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Gui�n
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y D�gito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el m�nimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular D�gito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada d�gito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el M�ltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar M�ltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular D�gito Verificador en base al M�dulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su D�gito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Invalido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es v�lido)
    rut.setCustomValidity('');
}

    $(document).ready(function(){
				$("#region").change(function () {				
					$("#region option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna").html(data);
						});            
					});
				})
    });
    
</script>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style="" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Mandante</h2>
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
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-md" type="button">Crear Mandante</button>
                                    </div>
                              </div>
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmMandantes">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Giro</label>
                                    <div class="col-sm-6"><input name="giro" type="text" class="form-control" value="<?php echo $giro ?>"  required=""/></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Descripci&oacute;n del giro</label>
                                    <div class="col-sm-6"><input name="descripcion" type="text" class="form-control" value="<?php echo $descripcion ?>" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Nombre de Fantas&iacute;</label>
                                    <div class="col-sm-6"><input name="nombre_fantasia" type="text" class="form-control" value="<?php echo $nombre ?>" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Raz&oacute;n Social</label>
                                    <div class="col-sm-6"><input name="razon_social" type="text" class="form-control" value="<?php echo $razon ?>" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">RUT Empresa</label>
                                    <div class="col-sm-2"><input name="rut_empresa" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" value="<?php echo $rut_empresa ?>" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">RUT Representante</label>
                                    <div class="col-sm-2"><input name="rut_representante" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" value="<?php echo $rut_representante ?>" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Representante Legal</label>
                                    <div class="col-sm-6"><input name="representante" type="text" class="form-control" value="<?php echo $representante ?>"  required="" /></div>
                                </div>
                                 <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Direcci&oacute;n Comercial</label>
                                    <div class="col-sm-4">
                                        <select id="region_com" name="region_com" class="form-control">
                                           <option value="<?php echo $dir_comercial_region ?>" selected=""><?php echo $dir_comercial_region ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        <select id="comuna_com" name="comuna_com" class="form-control">
                                           <option value="<?php echo $dir_comercial_comuna ?>" selected=""><?php echo $dir_comercial_comuna ?></option>
                                               
                                        </select>
                                    </div>
                                </div>
                                <!--- direccion matriz -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Direcci&oacute;n Matriz</label>
                                    <div class="col-sm-4">
                                        <select id="region_mat" name="region_mat" class="form-control">
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        <select id="comuna_mat" name="comuna_mat" class="form-control">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
                                        </select>
                                    </div>
                                </div>
                                <!-- administrador -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre del Administrador</label>
                                    <div class="col-sm-4"><input name="administrador" type="text" class="form-control" value="<?php echo $administrador ?>" required=""  /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Tel&eacute;fono</label>
                                    <div class="col-sm-2"><input name="fono" type="text" class="form-control" value="<?php echo $fono ?>" required="" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo</label>
                                    <div class="col-sm-4"><input name="email" type="email" class="form-control" value="<?php echo $email ?>" required="" /></div>
                                </div>
                                
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button style="background:#010829;color:#fff" class="btn btn-white btn-md" type="button">Cambiar</button>
                                        <button class="btn btn-primary btn-md" type="button" onclick="crear_mandante()">Guardar</button>
                                    </div>
                                </div>
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
                <strong>Copyright</strong> Proyecto Empresas &copy; 2022
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
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
        <script>
        
        
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
    
    function refresh(){
        window.location.href='crear_mandante.php';
    }
    
    
    function crear_mandante(){
      //alert('hola');
      var valores=$('#frmMandantes').serialize();
      $.ajax({
    			method: "POST",
                url: "add/mandantes.php",
                data: valores,
    			success: function(data){			  
                 if (data==1) {
                     swal({
                            title: "Mandante Creado",
                            //text: "You clicked the button!",
                            type: "success"
                        }
                     );
                     setTimeout(refresh, 1000);
    			  } else {
                     swal("Cancelled", "Mandante No Creado. Vuelva a Intentar.", "error");                        
                     setTimeout(refresh, 1000);                         
    			  }
    			}                
           });    
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="index.php"; </script>';
}

?>
