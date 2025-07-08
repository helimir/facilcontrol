<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2 )  {

#session_destroy($_SESSION['active']);
#$_SESSION['active']=21;
    
include('config/config.php');
//$regiones= consulta_general('regiones');

$regiones=mysqli_query($con,"Select * from regiones order by orden asc ");

$query_m=mysqli_query($con,"Select r.Region as region_comercial, o.Comuna as comuna_comercial, c.* from mandantes as c left join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On IdComuna=c.dir_comercial_comuna where c.id_mandante='".$_SESSION['mandante']."' ");
$result_m=mysqli_fetch_array($query_m);


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

     <title>FacilControl | Perfil del Mandante</title> 
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
    
    <style>    
    .etiqueta {
        color:#000;
    }
    .elabel {
      background:#e9eafb;;
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



function subir_foto(mandante) {
        
        var fileInput = document.getElementById('logo');
        var filePath = fileInput.files.length;
        if (filePath>0 ) {
                
                var formData = new FormData(); 
                var files= $('#logo')[0].files[0];                   
                formData.append('foto',files);
                formData.append('mandante',mandante);
                $.ajax({
                    url: 'cargar/cargar_logo_mandante.php',
                    type: 'post',
                    data:formData,
                    contentType: false,
                    processData: false,
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
                    success: function(data) {    
                        $('#modal_cargar').modal('hide');
                        if (data==0) {
                            swal({
                                title: "Imagen Cargada",
                                //text: "Dimensiones no validas",
                                type: "success"
                            });                           
                            window.location.href='perfil_mandante.php';
                        } else {
                            swal({
                                title: "Imagen No se Cargo",
                                text: "Vuelva a intentar",
                                type: "error"
                            }); 
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
      swal({
        title: "Sin Archivo",
        text: "Debe Seleccionar una Imagen",
        type: "error"
      });    
    }    
  }  


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
      $("#help").html("<span style='color:#1AB394;' >Ingrese un RUT v�lido</span>");
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

      $('#menu-datos-mandante').attr('class','active');

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
                    <h2 style="color: #010829;font-weight: bold;">Datos del Mandante <?php  ?></h2>
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

                              <div class="row"> 
                                    <div class="form-group elabel col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                        <label  class="col-form-label" for="quantity"><strong>Logo empresa</strong></label>
                                    </div> 
                                    <div  class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <?php 
                                        if ($result_m['logo']=="") {
                                            echo '<img src="img/sinimagen.png" />';
                                        } else {
                                            echo '<img width="150" heigth="150" src="'.$result_m['logo'].'" />';
                                        }                                                                       
                                        ?>
                                        <br />
                                        <br />
                                        <div   class="fileinput fileinput-new" data-provides="fileinput">
                                            <span style="background: #282828;color:#fff" class="btn btn-default btn-file"><span  class="fileinput-new ">Seleccione Imagen</span>
                                            <input onchange="subir_foto(<?php echo $result_m['id_mandante'] ?>)"  type="file" id="logo" name="logo" accept="image/jpeg,image/jpg,image/png" /></span>
                                            <span class="fileinput-filename"></span>
                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label elabel">RUT Empresa</label>
                                    <div class="col-lg-10 col-sm-12">
                                        <label class="col-form-label"><?php echo $result_m['rut_empresa'] ?></label>
                                    </div>   
                                </div>

                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Raz&oacute;n Social</label>
                                    <div class="col-sm-6"><input name="razon_social" type="text" class="form-control bordes" value="<?php echo $result_m['razon_social'] ?>" /></div>
                                </div>
                               
                                <div class="form-group  row"><label class="col-sm-2 col-form-label elabel">Giro</label>
                                    <div class="col-sm-6"><input name="giro" type="text" class="form-control bordes" value="<?php echo $result_m['giro'] ?>" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Descripci&oacute;n del giro</label>
                                    <div class="col-sm-6"><input name="descripcion" type="text" class="form-control bordes" value="<?php echo $result_m['descripcion_giro'] ?>" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Nombre de Fantas&iacute;a</label>
                                    <div class="col-sm-6"><input name="nombre_fantasia" type="text" class="form-control bordes" /></div>
                                </div>
                               
                               
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Representante Legal</label>
                                    <div class="col-sm-6"><input name="representante" type="text" class="form-control bordes" /></div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">RUT Representante</label>
                                    <div class="col-sm-2">
                                        <input class="form-control bordes" maxlength="12" name="rut_representante" id="rut_rep" type="text"  placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)"   oninput="validar_rep(this)" required="" />
                                        <span style="color: #1AB394;"  id="help_rep" class="form-label" ><strong>ingrese un RUT v&aacute;lido</strong></span>
                                    </div>
                                </div>
                               
                                 <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Direcci&oacute;n Comercial</label>
                                    <div class="col-sm-4">
                                        <select id="region_com" name="region_com" class="form-control bordes">
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
                                        <select id="comuna_com" name="comuna_com" class="form-control bordes">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
                                        </select>
                                    </div>
                                </div>
                                <!--- direccion matriz -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Direcci&oacute;n Matriz</label>
                                    <div class="col-sm-4">
                                        <select id="region_mat" name="region_mat" class="form-control bordes">
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
                                        <select id="comuna_mat" name="comuna_mat" class="form-control bordes">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
                                        </select>
                                    </div>
                                </div>
                                
                                 <!--- direccion representante -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label elabel">Direcci&oacute;n</label>
                                    <div class="col-sm-6"><input name="direccion_emp" type="text" class="form-control bordes"  /></div>
                                </div>
                                
                                
                                <!-- administrador -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label elabel">Administrador</label>
                                    <div class="col-sm-4"><input name="administrador" type="text" class="form-control bordes" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label elabel">Tel&eacute;fono</label>
                                    <div class="col-sm-4"><input name="fono" type="number" class="form-control bordes" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label elabel">Correo</label>
                                    <div class="col-sm-4"><input name="email" type="email" class="form-control bordes" /></div>
                                </div>
                                
                                <div class="form-group  row"><label class="col-sm-2 col-form-label elabel">Dualidad</label>
                                    <div class="col-sm-1"><input id="dualida" name="dualida" type="checkbox" class="form-control" /></div>
                                </div>
                                
                                
                               
                                <div style="border:1px #c0c0c0 solid;border-radius;5px;padding:1% 0%" class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <!--<button style="background:#010829;color:#fff" class="btn btn-white btn-md" type="button">Cambiar</button>-->
                                        <button class="btn btn-success btn-md" type="button" disabled onclick="crear_mandante()"><strong>ACTUALIZAR DATOS DEL MANDANTE</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                        <!-- modal cargando--->
                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando Mandante, por favor espere un momento</h3>
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

   <!-- Jasny -->
   <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

<!-- iCheck -->
<script src="js\plugins\iCheck\icheck.min.js"></script>

<!-- Sweet alert -->
<script src="js\plugins\sweetalert\sweetalert.min.js"></script>

 <script>
 
  
  
    
   function crear_mandante(){
      if ($("#dualida").is(':checked')) { 
          dualida=document.getElementById('dualida').value=1;
      } else {
          document.getElementById('dualida').value=0;
      }
      var dualida=$('#dualida').val();

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
                  url: "add/mandantes.php",
                  data: valores+'&dualidad='+dualida, 
                  beforeSend: function(){
                      $('#modal_cargar').modal('show');						
                  },
                  success: function(data){			  
                      if (data==0) {
                          swal({
                              title: "Mandante Creado",
                              //text: "You clicked the button!",
                              type: "success"
                          });
                        setTimeout(window.location.href='list_mandantes.php', 3000);
                      } 
                      if (data==1) {
                              swal("Cancelled", "Mandante No Creado. Vuelva a Intentar.", "error");                        
                              setTimeout(window.location.href='crear_mandante.php', 3000);
                      } 
                      if (data==2) {
                              swal("RUT EXISTE", "Intento con otro RUT.", "warning");
                              setTimeout(window.location.href='crear_mandante.php', 3000);
                      }                            
                      
                  },
                  complete:function(data){
                    $('#modal_cargar').modal('hide');
                  }, 
                  error: function(data){
                  }                  
        });   
    } else {
        swal({
            title: "Formulario Vacio",
            //text: "You clicked the button!",
            type: "warning"
        });
    } 
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
