<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if ( $_SESSION['nivel']==1 ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$regiones=mysqli_query($con,"Select * from regiones ");

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proyecto| Admin</title>

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
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Invalido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

    $(document).ready(function(){
				$("#region_com").change(function () {				
					$("#region_com option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_com").html(data);
						});            
					});
				})
                
                $("#region_mat").change(function () {				
					$("#region_mat option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_mat").html(data);
						});            
					});
				})
    });
    
</script>

</head>

<body>

 <div id="wrapper">

    <?php include('nav.php') ?>

      <div id="page-wrapper" class="gray-bg">
       
       <?php include('superior.php') ?> 
      
      <div style="background: #010829;color: #fff;" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Crear Mandante</h2>
                </div>
                <div class="col-lg-2">

                </div>
        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <!--<h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                
                            </div>-->
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmMandantes">
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Giro</label>
                                    <div class="col-sm-6"><input name="giro" type="text" class="form-control" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Descripci&oacute;n del giro</label>
                                    <div class="col-sm-6"><input name="descripcion" type="text" class="form-control" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Nombre de Fantas&iacute;</label>
                                    <div class="col-sm-6"><input name="nombre_fantasia" type="text" class="form-control" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Raz&oacute;n Social</label>
                                    <div class="col-sm-6"><input name="razon_social" type="text" class="form-control" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">RUT Empresa</label>
                                    <div class="col-sm-2"><input name="rut_empresa" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">RUT Representante</label>
                                    <div class="col-sm-2"><input name="rut_representante" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" required="" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Representante Legal</label>
                                    <div class="col-sm-6"><input name="representante" type="text" class="form-control" /></div>
                                </div>
                                 <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Direcci&oacute;n Comercial</label>
                                    <div class="col-sm-4">
                                        <select id="region_com" name="region_com" class="form-control">
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
                                        <select id="comuna_com" name="comuna_com" class="form-control">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
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
                                    <div class="col-sm-4"><input name="administrador" type="text" class="form-control" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Tel&eacute;fono</label>
                                    <div class="col-sm-4"><input name="fono" type="text" class="form-control" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo</label>
                                    <div class="col-sm-4"><input name="email" type="email" class="form-control" /></div>
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
                <strong>Copyright</strong> Proyecto  &copy; <?php echo $year ?>
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
    			      if (data==0) {
                         swal("Cancelled", "Mandante No Creado. Vuelva a Intentar.", "error");                        
                         setTimeout(refresh, 1000);
                      } else {
                         swal({
                            title: "Email Ya existe",
                            text: "Mandante no se puede crear. Favor usar otro email."
                        });
                      }                            
    			  }
    			}                
           });    
  }

    </script>
</body>

</html><?php  } else { 

echo "<script> window.location.href='index.php'; </script>";
}


?>
