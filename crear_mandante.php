<?php
/**
 * @author helimirlopez
 * @copyright 20224
 */
include('sesion_manager.php');
session_start();
if (isset($_SESSION['usuario']))  {    
include('config/config.php');
$regiones=mysqli_query($con,"Select * from regiones ");


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

    <title>FacilControl | Nuevo Mandante</title> 
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <style>    
    .etiqueta {
        color:#000;
    }
    .elabel {
      background:#e9eafb;
      color:#292929;
      font-weight:bold;
    }
    
    .bordes {
        border: 1px solid #c0c0c0;
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


<script src="js\jquery-3.1.1.min.js"></script>
<script>

// Permitir solo numeros y letra K en el imput
function isNumber(evt) {
  let charCode = evt.which;

  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode === 75) {
    return false;
  }

  return true;
}

function checkRut(rut) {
  

  if (rut.value.length <= 1) {
      $("#help").html("<span style='color:#1AB394;' >Ingrese un RUT válido</span>");
    return false
  }

  // Obtiene el valor ingresado quitando puntos y guion.
  let valor = clean(rut.value);

  // Divide el valor ingresado en digito verificador y resto del RUT.
  let bodyRut = valor.slice(0, -1);
  let dv = valor.slice(-1).toUpperCase();

  // Separa con un Guión el cuerpo del dilgito verificador.
  rut.value = format(rut.value);

  // Si no cumple con el minimo ej. (n.nnn.nnn)
  if (bodyRut.length < 7) {
    $("#help").html("<span style='color:#1AB394;font-weight:bold' >Rut de ser mayor de 7 d&iacute;gitos</span>");
    return validacion=false;
  }

  // Calcular Dígito Verificador "Método del Módulo 11"
  suma = 0;
  multiplo = 2;

  // Para cada dígito del Cuerpo
  for (i = 1; i <= bodyRut.length; i++) {
    // Obtener su Producto con el Múltiplo Correspondiente
    index = multiplo * valor.charAt(bodyRut.length - i);

    // Sumar al Contador General
    suma = suma + index;

    // Consolidar Múltiplo dentro del rango [2,7]
    if (multiplo < 7) {
      multiplo = multiplo + 1;
    } else {
      multiplo = 2;
    }
  }

  // Calcular Dígito Verificador en base al Módulo 11
  dvEsperado = 11 - (suma % 11);

  // Casos Especiales (0 y K)
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su Dígito Verificador
  if (dvEsperado != dv) {    
    $("#help").html("<span style='color:#ED5565;font-weight:bold' >Rut Inv&aacute;lido</span>");
    return validacion=false;
  } else {
    $("#help").html("<span style='color:#1C84C6;font-weight:bold' >Rut V&aacute;lido</span>");
    return validacion=true;
  }
}

function format (rut) {
  rut = clean(rut)

  var result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
  for (var i = 4; i < rut.length; i += 3) {
    result = rut.slice(-3 - i, -i) + '.' + result
  }

  return result;
}

function clean (rut) {
  return typeof rut === 'string'
    ? rut.replace(/^0+|[^0-9kK]+/g, '').toUpperCase()
    : ''
}
      
// validar rut repsesentante --------------------------------------------------------------------------------


function validar_rep(rut_rep) {
  

  if (rut_rep.value.length <= 1) {
      $("#help_rep").html("<span style='color:#1AB394;' >Ingrese un RUT v&aacute;lido</span>");
    return false
  }

  // Obtiene el valor ingresado quitando puntos y guion.
  let valor = clean(rut_rep.value);

  // Divide el valor ingresado en digito verificador y resto del rut_rep.
  let bodyrut_rep = valor.slice(0, -1);
  let dv = valor.slice(-1).toUpperCase();

  // Separa con un Guión el cuerpo del dilgito verificador.
  rut_rep.value = format(rut_rep.value);

  // Si no cumple con el minimo ej. (n.nnn.nnn)
  if (bodyrut_rep.length < 7) {
    $("#help_rep").html("<span style='color:#1AB394;font-weight:bold' >RUT de ser mayor de 7 d&iacute;gitos</span>");
    
  }

  // Calcular Dígito Verificador "Método del Módulo 11"
  suma = 0;
  multiplo = 2;

  // Para cada dígito del Cuerpo
  for (i = 1; i <= bodyrut_rep.length; i++) {
    // Obtener su Producto con el Múltiplo Correspondiente
    index = multiplo * valor.charAt(bodyrut_rep.length - i);

    // Sumar al Contador General
    suma = suma + index;

    // Consolidar Múltiplo dentro del rango [2,7]
    if (multiplo < 7) {
      multiplo = multiplo + 1;
    } else {
      multiplo = 2;
    }
  }

  // Calcular Dígito Verificador en base al Módulo 11
  dvEsperado = 11 - (suma % 11);

  // Casos Especiales (0 y K)
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su Dígito Verificador
  if (dvEsperado != dv) {    
    $("#help_rep").html("<span style='color:#ED5565;font-weight:bold' >RUT Inv&aacute;lido</span>");
  } else {
    $("#help_rep").html("<span style='color:#1C84C6;font-weight:bold' >RUT V&aacute;lido</span>");
  }
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
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Crear Mandante</h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a  class="btn btn-sm btn-success btn-submenu" href="list_mandantes.php" class="" type="button">Reporte Mandante</a>
                                        <!--<a  class="btn btn-sm btn-success btn-submenu" href="list_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i><b>Reporte de Contratistas</b></a>-->
                                    </div>
                              </div>                              
                              <?php #include('resumen.php') ?>
                              <hr>
                              <form  method="post" id="frmMandantes">

                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">RUT Empresa</label>                                    
                                        <input class="form-control bordes col-lg-2 col-md-2 col-sm-12 col-xs-12" maxlength="12" name="rut_empresa" id="rut" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" oninput="checkRut(this)" required=""  />
                                        <span style="color: #1AB394;"  id="help" class="form-label" ><strong>ingrese un RUT v&aacute;lido</strong></span>                                    
                                  </div>
                                </div>

                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Raz&oacute;n Social</label>
                                    <input name="razon_social" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                                  </div>
                                </div>
                               
                                <div class="form-group  row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Giro</label>
                                    <input name="giro" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Descripci&oacute;n del giro</label>
                                    <input name="descripcion" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Nombre de Fantas&iacute;a</label>
                                    <input name="nombre_fantasia" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                                  </div>
                                </div>
                               
                               
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Representante Legal</label>
                                    <input name="representante" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" />
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">RUT Representante</label>
                                        <input class="form-control  col-lg-2 col-md-2 col-sm-12 col-xs-12" maxlength="12" name="rut_representante" id="rut_rep" type="text"  placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)"   oninput="validar_rep(this)" required="" />
                                        <span style="color: #1AB394;"  id="help_rep" class="form-label" ><strong>ingrese un RUT v&aacute;lido</strong></span>
                                    </div>
                                </div>
                               
                                 <!--- direccion comercial -->
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Direcci&oacute;n Comercial</label>                                    
                                        <select id="region_com" name="region_com" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <br>
                                        <select id="comuna_com" name="comuna_com" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                        </select>


                                  </div>
                                </div>
                                
                                <!--- direccion matriz -->
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Direcci&oacute;n Matriz</label>
                                        <select id="region_mat" name="region_mat" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <br>
                                        <select id="comuna_mat" name="comuna_mat" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                           <option value="0" selected="">Seleccionar Comuna</option>                                               
                                        </select>
                                  </div>
                                </div>
                                
                                
                                 <!--- direccion representante -->
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Direcci&oacute;n</label>
                                    <input name="direccion_emp" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  </div>
                                </div>
                                
                                
                                <!-- administrador -->
                                <div class="form-group  row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Administrador</label>
                                    <input name="administrador" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Tel&eacute;fono</label>
                                    <input name="fono" type="number" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Correo</label>
                                    <input name="email" type="email" class="form-control bordes col-lg-21 col-md-12 col-sm-12 col-xs-12">
                                  </div>
                                </div>
                                
                                <div class="form-group  row">
                                  <div class="col-12">
                                    <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Dualidad</label>
                                    <input id="dualidad" name="dualidad" type="checkbox" class="form-control col-lg-1 col-sm-1 col-xs-1">
                                  </div>
                                </div>
                                
                                <hr>
                               
                                <div style="" class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-md" type="button" onclick="crear_mandante()"><strong>CREAR NUEVO MANDANTE</strong></button>
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
                                  <h3>Creando Mandante, por favor espere un momento</h3>
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
    
 <script>
 
  
  
    
   function crear_mandante(){
      if ($("#dualidad").is(':checked')) { 
          dualidad=document.getElementById('dualidad').value=1;
      } else {
          document.getElementById('dualidad').value=0;
      }
      var dualidad=$('#dualidad').val();

      const form = document.getElementById('frmMandantes');
      const inputs = form.querySelectorAll('input');
      let formularioValido = true;

      inputs.forEach(input => {
        if (input.value.trim() === '') {
          formularioValido = false;
          
        } 
      });
      
      if (formularioValido) { 
          var valores=$('#frmMandantes').serialize();
          $.ajax({
                  method: "POST",
                  url: "add/add_mandantes.php",
                  data: valores+'&dualidad='+dualidad, 
                  beforeSend: function(){
                      $('#modal_cargar').modal('show');						
                  },
                  success: function(data){			  
                      if (data==0 || data==3) {
                          Swal.fire({
                            title: "Mandante Creado",
                            icon: "success",
                            draggable: true
                          });
                        setTimeout(window.location.href='list_mandantes.php', 3000);
                      } 
                      if (data==1) {
                          Swal.fire({
                            title: "Oops!! Error de Sistema. Vuelva a intentar",
                            icon: "error",
                            draggable: true
                          });
                      } 
                      if (data==2) {
                          Swal.fire({
                            title: "Mandante Existe. Intente con otro RUT",
                            icon: "warning",
                            draggable: true
                          });

                      }                            
                      
                  },
                  complete:function(data){
                    $('#modal_cargar').modal('hide');
                  }, 
                  error: function(data){
                  }                  
        });   
    } else {
      Swal.fire({
        title: "Formulario Vacio",
        text: "Favor llenar campos solicitados",
        icon: "warning"
      });
    } 
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
