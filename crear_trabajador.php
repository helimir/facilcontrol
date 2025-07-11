<?php
include('sesion_manager.php');
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

    
$idcontratista=$fcontratista['id_contratista'];
$idtrabajador=isset($_GET['idtrabajador']) ? $_GET['idtrabajador']: '';

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

     <title>FacilControl | Crear Trabajador </title> 
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
    
    
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    

<script src="js\jquery-3.1.1.min.js"></script>
<script>


// verificar que existe rut trabajador
function existerut(rut) {    
      if (rut!='') {   
       
        $.ajax({
 			method: "POST",
            url: "add/verificar_rut_trabajador.php",
            data: 'rut='+rut,
 			success: function(data) {
                 //alert(data);
                 if (data==0) {
 			        swal({
                        title: "Trabajador Existe en FacilControl.Desea Agregar?",
                        //text: "Desea Agregarla",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1AB394",
                        confirmButtonText: "Si, Agregar!",
                        cancelButtonText: "No, Agregar!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({ 
                         			method: "POST",
                                    url: "add/agregar_trabajador_existente.php",
                                    data: 'rut='+rut,
                         			success: function(data) {
                         			  //alert(data);  
                                      if (data==0) {
                                          swal("Trabajador Agregado", "El esta en su lista.", "success");      
                                          window.location.href='list_trabajadores.php'                                   
                                      } else {
                                          swal("Trabajado No Agregado", "vuelva a intentar", "error");
                                      }  
                                    },
                                });     
                                //swal("Confirmado!", "El Mandante ha sido deshabilitado.", "success");                                
                                //setTimeout(window.location.href='list_contratos.php', 3000);
                        } else {
                           swal("Cancelado", "Accion Cancelada", "error");
                          
                        }
                    });                    
 			    } 
                if (data==1) {
 			        swal("Trabajador esta en su Lista", "Intente con otro RUT", "warning");
 			    } 
            }                                                            
        });
     } else {
        swal({          
            title: "RUT no puede estar vacío",
            //text: "You clicked the button!",
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
      $("#help").html("<span style='color:#1AB394;' >Ingrese un RUT v&aacute;lido</span>");
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
    $("#help").html("<span style='color:#1AB394;font-weight:bold' >Rut de ser mayor de 7 d�gitos</span>");
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

    $(document).ready(function(){
				
                $("#region").change(function () {				
					$("#region option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna").html(data);
						});            
					});
				})
                
                $("#contrato").change(function () {				
					$("#contrato option:selected").each(function () {
						id= $(this).val();
						$.post("cargos.php", { id: id }, function(data){
							$("#cargo").html(data);
						});            
					});
				});
                
                
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
    
   
    
   function add() {
    window.location.href='crear_trabajador.php'; 
  } 
  
  function addconstancia(idtrabajador) {
    window.location.href='constancias.php?idtrabajador='+idtrabajador; 
  } 
  
  function eliminar(idtrabajador){
   if (confirm('Confirtmar Desvincular Trabajador')) { 
		$.ajax({
			method: "POST",
            url: "del/deltrabajador.php",
			data:'idtrabajador='+idtrabajador,
			success: function(data){
			   window.location.href='reptrabajadores.php?sms=2'; 
			}
       });
    }    
  }  
  
 
function ShowSelected()
{
var combo = document.getElementById("licencia");
var selected = combo.options[combo.selectedIndex].text;
  
  if (selected=='NO)') {
      $('#tipolicencia').prop('disabled',true);
  } else  {
      $('#tipolicencia').prop('disabled',false);
  }  
   
} 
 
function descargar(rut) {
   window.location.href='files/bajar.php?rut='+rut;  
} 

function carga() { 
   var nombre1= $('#nombres1').val();
   var apellido1= $('#apellidos1').val();
   var parentesco1= $('#parentesco1').val();
   var sexo1= $('#sexo1').val();    
   var cfecha1= $('#cfecha1').val();
    
   var nombre2= $('#nombres2').val();
   var apellido2= $('#apellidos2').val();
   var parentesco2= $('#parentesco2').val();
   var sexo2= $('#sexo2').val();    
   var cfecha2= $('#cfecha2').val();
    
   var nombre3= $('#nombres3').val();
   var apellido3= $('#apellidos3').val();
   var parentesco3= $('#parentesco3').val();
   var sexo3= $('#sexo3').val();    
   var cfecha3= $('#cfecha3').val();
    
   var nombre4= $('#nombres4').val();
   var apellido4= $('#apellidos4').val();
   var parentesco4= $('#parentesco4').val();
   var sexo4= $('#sexo4').val();    
   var cfecha4= $('#cfecha4').val();
   
   var idtrabajador= $('#idtrabajador').val();
    
   $.ajax({
			method: "GET",
            url: "add/addcarga.php",
			data:'nombre1='+nombre1+'&apellido1='+apellido1+'&parentesco1='+parentesco1+'&sexo1='+sexo1+'&cfecha1='+cfecha1+'&nombre2='+nombre2+'&apellido2='+apellido2+'&parentesco2='+parentesco2+'&sexo2='+sexo2+'&cfecha2='+cfecha2+'&nombre3='+nombre3+'&apellido3='+apellido3+'&parentesco3='+parentesco3+'&sexo3='+sexo3+'&cfecha3='+cfecha3+'&nombre4='+nombre4+'&apellido4='+apellido4+'&parentesco4='+parentesco4+'&sexo4='+sexo4+'&cfecha4='+cfecha4+'&idtrabajador='+idtrabajador,
			success: function(data){
			   //alert('Cargas asignada'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
			}
       });
}

function cupdate2(idcarga,idtrabajador) {
   var nombre1= $('#nombres1').val();
   var apellido1= $('#apellidos1').val();
   var parentesco1= $('#parentesco1').val();
   var sexo1= $('#sexo1').val();    
   var cfecha1= $('#cfecha1').val();
      
   var idtrabajador= $('#idtrabajador').val();
   alert(idcarga+nombre1); 
   $.ajax({
			method: "GET",
            url: "add/upcarga.php",
			data:'nombre1='+nombre1+'&apellido1='+apellido1+'&parentesco1='+parentesco1+'&sexo1='+sexo1+'&cfecha1='+cfecha1+'&idcarga='+idcarga,
			success: function(data){
			   alert('Datos Actualizados'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
			}
       }); 
     
} 

function celiminar(idcarga,idtrabajador) {
  var accion=confirm('Esta seguro que desea borrar') 
  if (accion==true) { 
   $.ajax({
			method: "GET",
            url: "del/delcarga1.php",
			data:'idcarga='+idcarga,
			success: function(data){
			   alert('Datos han sido borrados'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
               
			}
       });  
   }    
}

function borrar(idtrabajador) {
  var accion=confirm('Esta seguro que desea borrar la Carga Familiar') 
  if (accion==true) { 
   $.ajax({
			method: "GET",
            url: "del/delcarga2.php",
			data:'idtrabajador='+idtrabajador,
			success: function(data){
			   alert('Datos han sido borrados'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
               
			}
       });  
   }    
}  


$(document).ready(function () {
   
   $('#menu-trabajadores').attr('class','active');
    
    $('.update').click(function(){ 
        
        var idtrabajador = $(this).closest('tr').find('input[name="idtrabajador"]').val();        
        var idcarga = $(this).closest('tr').find('input[name="idcarga"]').val();
        var nombre1 = $(this).closest('tr').find('input[name="nombres1"]').val();
        var apellido1 = $(this).closest('tr').find('input[name="apellidos1"]').val();
        var rut1 = $(this).closest('tr').find('input[name="rut1"]').val();
        var rut1 = $(this).closest('tr').find('input[name="rut1"]').val();
        var sexo1 = $(this).closest('tr').find('select[name="sexo1"]').val();
        var parentesco1 = $(this).closest('tr').find('select[name="parentesco1"]').val();
        var cfecha1 = $(this).closest('tr').find('input[name="cfecha1"]').val();
        
        $.ajax({
			method: "GET",
            url: "add/upcarga.php",
			data:'nombre1='+nombre1+'&apellido1='+apellido1+'&parentesco1='+parentesco1+'&sexo1='+sexo1+'&cfecha1='+cfecha1+'&idcarga='+idcarga+'&rut1='+rut1,
			success: function(data){
			   alert('Datos Actualizados'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
			}
       });
    });
    
    $('.agregar').click(function(){ 
        
        var idtrabajador = $(this).closest('tr').find('input[name="idtrabajador"]').val();        
        var idcarga = $(this).closest('tr').find('input[name="idcarga"]').val();
        var nombre1 = $(this).closest('tr').find('input[name="nombres1"]').val();
        var apellido1 = $(this).closest('tr').find('input[name="apellidos1"]').val();
        var rut1 = $(this).closest('tr').find('input[name="rut1"]').val();
        var sexo1 = $(this).closest('tr').find('select[name="sexo1"]').val();
        var parentesco1 = $(this).closest('tr').find('select[name="parentesco1"]').val();
        var cfecha1 = $(this).closest('tr').find('input[name="cfecha1"]').val();
        
        $.ajax({
			method: "GET",
            url: "add/upcarga.php",
			data:'nombre1='+nombre1+'&apellido1='+apellido1+'&parentesco1='+parentesco1+'&sexo1='+sexo1+'&cfecha1='+cfecha1+'&idcarga='+idcarga+'&rut1='+rut1,
			success: function(data){
			   alert('Cargar Familiar Agregada'); 
               window.location.href='creartrabajador.php?idtrabajador='+idtrabajador;
			}
       });
    });
    
})

function abrir(archivo,rut) {
    //alert('prueba');
    window.open('files/'+rut+'/ver.php?pdf='+archivo, '_blank');
    //window.location.href='files/27069177-3/ver.php?pdf='+archivo;
}
function modaldelcon(archivo,rut,id) {
    $('#delcon').val(archivo);
    $('#delrut').val(rut);
    $('#delid').val(id);
    $('#modalocupa').modal('show');
}
function borrarcon() {
    var doc=$('#delcon').val();
    var rut=$('#delrut').val();
    var id=$('#delid').val();
    var idcon=$('#delidcon').val();
    //alert(doc);
    $.ajax({
        method: "POST",
        url: "delcon.php",
     			data:'doc='+doc+'&rut='+rut+'&idcon='+id,
     			success: function(data){
 			    window.location.href='creartrabajador.php?idtrabajador='+id+'&sms=7';
     			}
        });
}
    
  
  function crear_trabajador(){
     //alert('hola');
     var rut = $('#rut').val();
     var nombre1 = $('#nombre1').val();
     var apellido1 = $('#apellido1').val();
     var direccion1 = $('#direccion1').val();
     var direccion2 = $('#direccion2').val();
     var region = $('#region').val();
     var comuna = $('#comuna').val();
     var estadocivil = $('#estadocivil').val();
     var email = $('#email').val();
     var telefono = $('#telefono').val();
     
     if (rut=="") {
         swal({
            title: "Rut es requerido",
            //text: "You clicked the button!",
            type: "error"
         });
        
     } else {
        
         if (nombre1=="") {
            swal({
                title: "Primer Nombre es requerido",
                //text: "You clicked the button!",
                type: "error"
             });
            
         } else {
            
             if (apellido1=="") {
                swal({
                    title: "Primer Apellido es requerido",
                    //text: "You clicked the button!",
                    type: "error"
                 });
                
             } else {
                 
                 if (direccion1==0) {                    
                     swal({
                        title: "Direccion es requerida",
                        //text: "You clicked the button!",
                        type: "error"
                     });
                    
                 } else {
                    
                      if (direccion2=="") {
                          swal({
                            title: "No Casa/Dpto es requerida",
                            //text: "You clicked the button!",
                            type: "error"
                         });
                        
                      } else {
                        
                          if (region==0) {
                                swal({
                                    title: "Region es requerida",
                                    //text: "You clicked the button!",
                                    type: "error"
                                 });
                            
                          } else {
                            
                             if (comuna==0) {
                                 swal({
                                    title: "Comuna es requerida",
                                    //text: "You clicked the button!",
                                    type: "error"
                                 });
                                
                             } else {
                                
                                if (estadocivil==0) {
                                    swal({
                                        title: "Estado Civil es requerido",
                                        //text: "You clicked the button!",
                                        type: "error"
                                     });
                                    
                                } else {
                                    
                                    if (email=="") {
                                        swal({
                                            title: "Email es requerido",
                                            //text: "You clicked the button!",
                                            type: "error"
                                         });
                                    } else {
                                        
                                        if (telefono=="") {
                                             swal({
                                                title: "Telefono Trabajador es requerido",
                                                //text: "You clicked the button!",
                                                type: "error"
                                             });
                                        } else {                                      
                                        
             
                                              var valores=$('#frmTrabajador').serialize();
                                              $.ajax({
                                        			method: "POST",
                                                    url: "add/addtrabajador.php",
                                                    data: valores,
                                                     beforeSend: function(){
                                                        $('#modal_cargar').modal('show');						
                                        			},
                                        			success: function(data){			  
                                                     if (data==0) { 
                                                         $('#modal_cargar').modal('hide');   
                                                         swal({
                                                                title: "Trabajador Creado",
                                                                //text: "You clicked the button!", 
                                                                type: "success"
                                                         });
                                                         setTimeout(window.location.href='crear_trabajador.php', 3000);
                                        			  } else {
                                        			     $('#modal_cargar').modal('hide'); 
                                        			     if (data==1) { 
                                                            swal("Trabajador No Creado", "Vuelva a Intentar.", "error");
                                                         }
                                                         if (data==2) { 
                                                            swal({
                                                                title: "RUT Existe",
                                                                //text: "You clicked the button!",
                                                                type: "error"
                                                            });
                                                         }
                                                         if (data==3) { 
                                                            swal({
                                                                title: "Trabajador Actualizado",
                                                                //text: "Nombre de Perfil ya creado",
                                                                type: "success"
                                                            });
                                                         }
                                                         if (data==4) { 
                                                            swal("Trabajador No Actualizado", "Vuelva a Intentar.", "error");
                                                         }
                                                         if (data==5) { 
                                                            swal({
                                                                title: "Falta Informacion",
                                                                text: "Favor falta campos requeridos",
                                                                type: "warning"
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
                                     }  // telefono         
                       }    // email                        
                     }      // estdo civil                          
                   }        // comuna                    
                 }          // region                      
               }            // casa/dpto                        
             }              // direccion                          
           }                // primer apellido                           
         }                  // primer nombre 
      }                     // rut              
   } 
    
    
</script>

<style>

.bordes {
    border:1px #c0c0c0 solid;
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
    border-bottom: #fff 2px solid;
    color:#292929;
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
                    <h2 style="color: #010829;font-weight: bold;"> Crear Trabajador <?php  ?> </h2>
                    <!--<label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>-->
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="form-group row"> 
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_trabajadores.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Trabajadores</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                        </div>
                        <div class="ibox-content">
                            <form  method="post"  enctype="multipart/form-data" id="frmTrabajador">
                            
                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox "> 
                                                                                                                  
                                                        <?php if($idtrabajador!="") { ?>
                                                            <div class="row"> 
                                                                 <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                    <label style="font-size: 18px;" class="col-form-label font-bold font-bold" for="quantity">Id Trabajador</label> 
                                                                </div> 
                                                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                   <input style="font-size: 18px;" class="form-control" type="text" name="idtrabajador" id="idtrabajador"  value="<?php echo $ftrabajador['idtrabajador'] ?>"  readonly="" />
                                                                </div>
                                                             </div>
                                                            <hr />
                                                        <?php } ?>
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold font-bold" for="quantity">RUT <span style="color: #FF0000;">*</span></label> 
                                                            </div> 
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                               <input class="form-control bordes" type="text" name="rut" id="rut" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" onBlur="existerut(this.value)" oninput="checkRut(this)"   required=""  />
                                                               <span style="color: #1AB394;"  id="help" class="form-label" ><strong>ingrese un RUT v&aacute;lido</strong></span>
                                                            </div>
                                                         </div>
                                                                                                          
                                                        
                                                        <hr />
                                                        
                                                        
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">1er. Nombre <span style="color: #FF0000;">*</span></label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="text" name="nombre1" id="nombre1" placeholder="" value="<?php echo isset($ftrabajador['nombre1']) ?>"  required="">
                                                            </div>
                                                         </div>
                                                         
                                                        <div class="row"> 
                                                             <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">2do. Nombre</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="text" name="nombre2" id="nombre2" placeholder="" value="<?php echo isset($ftrabajador['nombre2']) ?>"  />
                                                            </div>
                                                         </div> 
                                                         
                                                        <div class="row"> 
                                                             <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">1er. Apellido <span style="color: #FF0000;">*</span></label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="text" name="apellido1" id="apellido1" placeholder="" value="<?php echo  isset($ftrabajador['apellido1']) ?>"  required=""/>
                                                            </div>
                                                         </div> 
                                                         
                                                         <div class="row"> 
                                                             <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">2do. Apellido</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="text" name="apellido2" id="apellido2" placeholder="" value="<?php echo isset($ftrabajador['apellido2']) ?>" />
                                                            </div>                                
                                                         </div>  
                                                        
                                                        <hr />
                                                        <div class="row"> 
                                                             <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Direcci&oacute;n <span style="color: #FF0000;">*</span></label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="text" name="direccion1" id="direccion1" placeholder="Calle" value="<?php echo isset($ftrabajador['direccion1']) ?>"  required=""/>
                                                            </div>                                               
                                                         </div>
                                                        
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label font-bold" for="quantity"><strong></strong> </label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                    <input class="form-control bordes" type="text" name="direccion2" id="direccion2" placeholder="No. casa/Dpto " value="<?php echo isset($ftrabajador['direccion2']) ?>"  required=""/>
                                                            </div>                                                        
                                                         </div>
                                                         
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label font-bold" for="quantity"><strong></strong> </label> 
                                                            </div>         
                                                            
                                                            <?php if($idtrabajador=="") { ?>
                                                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                   <div class="form-wrap">
                                                                        <select name="region" id="region" class="form-control bordes">
                                                                                <option value="0" selected="">Seleccione Region</option>
                                                                                 <?php while($row = mysqli_fetch_assoc($regiones)) { 
                                                                                        $region=utf8_encode($row['Region']);
                                                                                         ?>                                                                                                            
                                                                    					<option value="<?php echo $row['IdRegion']; ?>"><?php echo $row['Region'] ?></option>
                                                                    				<?php } ?>
                                                                              </select>
                                                                    </div>
                                                                </div>
                                                             <?php } else { ?>
                                                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                   <div class="form-wrap">
                                                                        <select name="region" id="region" class="form-control bordes">
                                                                                <option value="<?php echo $ftrabajador['region'] ?>" selected=""><?php echo utf8_encode($ftrabajador['Region'])  ?></option>
                                                                                 <?php while($row = mysqli_fetch_assoc($regiones)) { 
                                                                                        $region=utf8_encode($row['Region']);
                                                                                         ?>                                                                                                            
                                                                    					<option value="<?php echo $row['IdRegion']; ?>"><?php echo $row['Region'] ?></option>
                                                                    				<?php } ?>
                                                                              </select>
                                                                    </div>
                                                                </div> 
                                                             <?php } ?> 
                                                                                     
                                                       </div>     
                                                         
                                                       <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label font-bold" for="quantity"><strong></strong> </label> 
                                                            </div>         
                                                             <?php if($idtrabajador=="") { ?>
                                                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                  <div class="form-wrap">
                                                                        <select name="comuna" id="comuna" class="form-control bordes">
                                                                            <option value="0" selected="">Seleccionar Comuna</option>
                                                                         </select>   
                                                                    </div>
                                                                </div> 
                                                             <?php } else { ?>                                   
                                                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                  <div class="form-wrap">
                                                                        <select name="comuna" id="comuna" class="form-control bordes">
                                                                            <option value="<?php echo $ftrabajador['comuna'] ?>" selected=""><?php echo $ftrabajador['Comuna']  ?></option>
                                                                         </select>   
                                                                    </div>
                                                                </div> 
                                                             <?php } ?> 
                                                                                     
                                                       </div>      
                                                         
                                                      <hr />   
                                                        <div class="row">    
                                                            <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Estado Civil <span style="color: #FF0000;">*</span></label> 
                                                            </div>   
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                    <?php if($idtrabajador=="") { ?>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="estadocivil" id="estadocivil">
                                                                            <option value="0" selected="" selected="">Seleccionar</option>
                                                                            <option value="Soltero">Soltero</option>
                                                                            <option value="Casado">Casado</option>
                                                                            <option value="Union">Union</option>
                                                                            <option value="Viudo">Viudo</option>
                                                                            <option value="Separado">Separado</option>
                                                                            <option value="Divorciado">Divorciado</option> 
                                                                        </select>
                                                                    <?php } else { ?>
                                                                        <select class="form-control" style="width: 100%;" name="estadocivil" id="estadocivil">
                                                                            <option value="<?php echo $ftrabajador['estadocivil'] ?>" selected=""><?php echo isset($ftrabajador['estadocivil']) ?></option>
                                                                            <option value="Soltero">Soltero</option> 
                                                                            <option value="Casado">Casado</option>
                                                                            <option value="Union">Union</option>
                                                                            <option value="Viudo">Viudo</option>
                                                                            <option value="Separado">Separado</option>
                                                                            <option value="Divorciado">Divorciado</option> 
                                                                        </select>
                                                                    <?php } ?>
                                                            </div>
                                                        </div> 
                                                        
                                                        <div class="row"> 
                                                            <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Email <span style="color: #FF0000;">*</span></label> 
                                                            </div>         
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="email" name="email" id="email" placeholder="" value="<?php echo isset($ftrabajador['email']) ?>"   />                               
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- telefono -->
                                                        <div class="row">   
                                                            <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Telefono <span style="color: #FF0000;">*</span></label> 
                                                            </div>    
                                                           <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control bordes" type="number" name="telefono" id="telefono" placeholder="" value="<?php echo isset($ftrabajador['telefono']) ?>"  />
                                                            </div>
                                                        </div>    
                                                       
                                                       <!-- fecha nacimiento -->
                                                       <div class="row">   
                                                            <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Fecha Nac. </label> 
                                                            </div>    
                                                            <?php if($idtrabajador=="") { ?>
                                                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">                                        
                                                                         <label class="col-form-label font-bold" for="quantity">D&iacute;a</label>
                                                                         <select class="form-control bordes" name="dia">
                                                                                <?php
                                                                                for ($i=1; $i<=31; $i++) {
                                                                                    if ($i == date('j'))
                                                                                    
                                                                                        if ($i<10) {
                                                                                            echo '<option value="'.$i.'" selected>0'.$i.'</option>';
                                                                                        } else {
                                                                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                                                                        }   
                                                                                   
                                                                                    else
                                                                                       
                                                                                        if ($i<10) {
                                                                                            echo '<option value="'.$i.'">0'.$i.'</option>';
                                                                                        } else {
                                                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                        }  
                                                                                }
                                                                                ?>
                                                                         </select>
                                                                  </div>
                                                                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">       
                                                                         <label class="col-form-label font-bold" for="quantity">Mes</label>
                                                                         <select class="form-control bordes"  name="mes">
                                                                                <?php
                                                                                for ($i=1; $i<=12; $i++) {
                                                                                    switch ($i) {
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
                                                                                    
                                                                                    if ($i == date('m')){
                                                                                        
                                                                                        switch ($i) {
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
                                                                                        
                                                                                        
                                                                                        if ($i<10) {
                                                                                            echo '<option value="'.$i.'" selected>'.$mes.'</option>';
                                                                                        } else {
                                                                                            echo '<option value="'.$i.'" selected>'.$mes.'</option>';
                                                                                        }   
                                                                                   
                                                                                   } else {
                                                                                       
                                                                                        if ($i<10) {
                                                                                            echo '<option value="'.$i.'">'.$mes.'</option>';
                                                                                        } else {
                                                                                            echo '<option value="'.$i.'">'.$mes.'</option>';
                                                                                        }  
                                                                                   }     
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                   </div>
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">     
                                                                        <label class="col-form-label font-bold" for="quantity">A&ntilde;o</label>
                                                                        <select class="form-control bordes" name="ano">
                                                                                <?php
                                                                                for($i=date('o'); $i>=1910; $i--){
                                                                                    if ($i == date('o'))
                                                                                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                                                                    else
                                                                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                    </div>
                                                           <?php } else { ?>                                
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                  <label class="col-form-label font-bold" for="quantity">D&iacute;a</label>
                                                                  <select class="form-control bordes" name="dia">                                                                                                       
                                                                                <?php
                                                                                
                                                                                if ($ftrabajador['dia']<10) {
                                                                                    echo "<option style='text-align: center' value=".$ftrabajador['dia']." select=''>0".$ftrabajador['dia']."</option>";
                                                                                } else {
                                                                                    echo "<option style='text-align: center' value=".$ftrabajador['dia']." select=''>".$ftrabajador['dia']."</option>";
                                                                                }
                                                                                
                                                                                for ($i=1; $i<=31; $i++) {
                                                                                                                   
                                                                                       echo '<option value="'.$i.'">0'.$i.'</option>';
                                                                                       
                                                                                }
                                                                                ?>
                                                                         </select>
                                                                  </div>
                                                                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">       
                                                                         <label class="col-form-label font-bold" for="quantity">Mes</label>
                                                                         <select class="form-control bordes"  name="mes">
                                                                                <?php
                                                                                
                                                                                switch ($ftrabajador['mes']) {
                                                                                           case 1: $mest="Enero";break;
                                                                                           case 2: $mest="Febrero";break;
                                                                                           case 3: $mest="Marzo";break;
                                                                                           case 4: $mest="Abril";break;
                                                                                           case 5: $mest="Mayo";break;
                                                                                           case 6: $mest="Junio";break;
                                                                                           case 7: $mest="Julio";break;
                                                                                           case 8: $mest="Agosto";break;
                                                                                           case 9: $mest="Septiembre";break;
                                                                                           case 10: $mest="Octubre";break;
                                                                                           case 11: $mest="Noviembre";break;
                                                                                           case 12: $mest="Diciembre";break;  
                                                                                            
                                                                                         }
                                                                                
                                                                                
                                                                                echo "<option style='text-align: center' value=".$ftrabajador['mes']." select>".$mest."</option>";
                                                                                for ($i=1; $i<=12; $i++) {                                                       
                                                                                         
                                                                                         switch ($i) {
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
                                                                                         echo '<option value="0'.$i.'"> '.$mes.'</option>';
                                                                                        
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                   </div>
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">     
                                                                        <label class="col-form-label font-bold" for="quantity">A&ntilde;o</label>
                                                                        <select class="form-control bordes" name="ano">
                                                                                <?php
                                                                                echo "<option style='text-align: center' value=".$ftrabajador['ano']." selected>".$ftrabajador['ano']."</option>";
                                                                                for($i=date('o'); $i>=1910; $i--){
                                                                                    
                                                                                        echo '<option value="'.$i.'"> '.$i.'</option>';
                                                                                    
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                    </div>
                                                           <?php }  ?>     
                                                        </div>  
                                                        
                                                        <!-- tallas  -->      
                                                           <div class="row">
                                                               <?php if ($idtrabajador=="") { ?>
                                                                   <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                        <label class="col-form-label font-bold" for="quantity">Tallas</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Pantalon</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tpantalon" id="tpantalon">
                                                                            <option value="0" selected="">Seleccionar</option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Poleras</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tpolera" id="tpolera">
                                                                            <option value="0" selected="">Seleccionar</option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Zapatos</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tzapatos" id="tzapatos">
                                                                            <option value="0" selected="">Seleccionar</option> 
                                                                            <?php                                                                             
                                                                            for ($i=30;$i<=50;$i++) {                                                                                
                                                                               echo '<option value="'.$i.'">'.$i.'</option>'; 
                                                                            }  ?>                                                                            
                                                                        </select>
                                                                    </div>
                                                                    
                                                                 <?php } else { ?>
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Tallas</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Pantalon</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tpantalon" id="tpantalon">
                                                                            <option value="<?php echo $ftrabajador['tpantalon'] ?>" selected=""><?php echo $ftrabajador['tpantalon'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Poleras</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tpolera" id="tpolera">
                                                                            <option value="<?php echo $ftrabajador['tpolera'] ?>" selected=""><?php echo $ftrabajador['tpolera'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Zapatos</label>
                                                                        <select class="form-control bordes"  style="width: 100%;" name="tzapatos" id="tzapatos">
                                                                            <option value="<?php echo $ftrabajador['tzapatos'] ?>" selected=""><?php echo $ftrabajador['tzapatos'] ?></option> 
                                                                            <?php                                                                             
                                                                            for ($i=30;$i<=50;$i++) {                                                                                
                                                                               echo '<option value="'.$i.'">'.$i.'</option>'; 
                                                                            }  ?>                                                                            
                                                                        </select>
                                                                    </div>
                                                                 <?php } ?>
                                                            </div> 
                                                          
                                                        
                                                        <hr />
                                                                                                               
                                                         <div class="row">    
                                                            <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                <label class="col-form-label font-bold" for="quantity">Conductor</label> 
                                                            </div>   
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                     
                                                                    <?php if($idtrabajador=="") { ?>    
                                                                        <select class="form-control bordes"  style="width: 100%;" name="licencia" id="licencia" onchange="ShowSelected()"> 
                                                                            <option value="NO">NO</option>
                                                                            <option value="SI">SI</option>                                            
                                                                        </select>
                                                                     <?php } else { ?>  
                                                                        <select class="form-control bordes"  style="width: 100%;" name="licencia" id="licencia" onchange="ShowSelected()"> 
                                                                            <option value="<?php echo $ftrabajador['licencia'] ?>"><?php echo $ftrabajador['licencia'] ?></option>
                                                                            <option value="NO">NO</option>
                                                                            <option value="SI">SI</option>                                            
                                                                        </select>  
                                                                     <?php } ?>                                                
                                                            </div>            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">            
                                                                     <?php if($idtrabajador=="") { ?>    
                                                                        <select class="form-control bordes" style="width: 100%;" name="tipolicencia" id="tipolicencia" disabled="" >
                                                                            <option value="0" >Tipo</option>
                                                                            <option value="A1">A1</option>
                                                                            <option value="A2">A2</option>
                                                                            <option value="A3">A3</option>
                                                                            <option value="A4">A4</option>
                                                                            <option value="B">B</option>
                                                                            <option value="D">D</option>
                                                                            <option value="C">C</option>
                                                                            <option value="E">E</option>
                                                                        </select>  
                                                                      <?php } else { 
                                                                        
                                                                            if ($ftrabajador['licencia']=="SI") {
                                                                                ?>  
                                                                                <select class="form-control bordes" style="width: 100%;" name="tipolicencia" id="tipolicencia" >
                                                                                    <option value="<?php echo $ftrabajador['tipolicencia'] ?>" selected=""><?php echo $ftrabajador['tipolicencia'] ?></option>
                                                                                    <option value="A1">A1</option>
                                                                                    <option value="A2">A2</option>
                                                                                    <option value="A3">A3</option>
                                                                                    <option value="A4">A4</option>
                                                                                    <option value="B">B</option>
                                                                                    <option value="D">D</option>
                                                                                    <option value="C">C</option>
                                                                                    <option value="E">E</option>
                                                                                </select> 
                                                                           <?php } else { ?>
                                                                                    <select class="form-control bordes" style="width: 100%;" name="tipolicencia" id="tipolicencia" disabled="" >
                                                                                    <option value="0" selected="">Tipo</option>
                                                                                    <option value="A1">A1</option>
                                                                                    <option value="A2">A2</option>
                                                                                    <option value="A3">A3</option>
                                                                                    <option value="A4">A4</option>
                                                                                    <option value="B">B</option>
                                                                                    <option value="D">D</option>
                                                                                    <option value="C">C</option>
                                                                                    <option value="E">E</option>
                                                                                </select>      
                                                                                
                                                                      <?php } 
                                                                       } ?>     
                                                                                             
                                                            </div>
                                                        </div>  
                                                        
                                                       <hr /> 
                                                        <!-- bancos afp y salud-->
                                                            <div class="row">
                                                               <?php if ($idtrabajador=="") { ?>
                                                                   <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                        <label class="col-form-label font-bold" for="quantity">Banco</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Entidad</label>
                                                                        <select class="form-control bordes"  name="banco" id="banco">
                                                                            <option value="0" selected="">Seleccionar</option>
                                                                            <?php while($row = mysqli_fetch_assoc($bancos)) { 
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idbanco']; ?>"><?php echo $row['banco'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Tipo Cuenta</label>
                                                                        <select class="form-control bordes"  name="tipocuenta" id="tipocuenta">
                                                                            <option value="0" selected="">Seleccionar</option>
                                                                            <option value="RUT">RUT</option>
                                                                            <option value="Corriente">Corriente</option>
                                                                            <option value="Vista">Vista</option>
                                                                            <option value="Ahorro">Ahorro</option>
                                                                            <option value="Chequera Electronica">Chequera Electr&oacute;nica</option>                                                                             
                                                                        </select>
                                                                        
                                                                        
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">N&uacute;mero Cuenta</label>
                                                                        <input class="form-control bordes" type="text" name="cuenta" id="cuenta" placeholder="" value=""  />
                                                                    </div>
                                                                    
                                                                 <?php } else { ?>
                                                                    <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Banco </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Entidad</label>
                                                                        <select class="form-control bordes"  name="banco" id="banco">
                                                                            <option value="<?php echo $ftrabajador['idbanco'] ?>" selected=""><?php echo $ftrabajador['banco'] ?></option>
                                                                            <?php while($row = mysqli_fetch_assoc($bancos)) { 
                                                                               $banco=utf8_encode($row['banco']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idbanco']; ?>"><?php echo $row['banco'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Tipo Cuenta </label>
                                                                        <select class="form-control bordes"  name="tipocuenta" id="tipocuenta">
                                                                            <option value="<?php echo $ftrabajador['tipocuenta'] ?>" selected=""><?php echo $ftrabajador['tipocuenta'] ?></option>
                                                                            <option value="Corriente">Corriente</option>
                                                                            <option value="Vista">Vista</option>
                                                                            <option value="Ahorro">Ahorro</option>   
                                                                            <option value="Chequera Electronica">Chequera Electr&oacute;nica</option>                                                                         
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">N&uacute;mero Cuenta</label>
                                                                        <input class="form-control bordes" type="text" name="cuenta" id="cuenta" placeholder="" value="<?php echo $ftrabajador['cuenta'] ?>"  />
                                                                    </div>
                                                                    
                                                                 <?php } ?>
                                                            </div> 
                                                            
                                                     <!-- AFP  -->      
                                                           <div class="row">
                                                               <?php if ($idtrabajador=="") { ?>
                                                                   <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                        <label class="col-form-label font-bold" for="quantity">AFP</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3  bordescol-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control bordes"  style="width: 100%;" name="afp" id="afp">
                                                                            <option value="0" selected="">Seleccionar</option>
                                                                            <?php while($row = mysqli_fetch_assoc($afps)) { 
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idafp']; ?>"><?php echo $row['afp'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                 <?php } else { ?>
                                                                     <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">AFP </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control bordes"  style="width: 100%;" name="afp" id="afp">
                                                                            <option value="<?php echo $ftrabajador['idafp'] ?>" selected=""><?php echo $ftrabajador['afp'] ?></option>
                                                                             <?php while($row = mysqli_fetch_assoc($afps)) { 
                                                                               $afp=utf8_encode($row['afp']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idafp']; ?>"><?php echo$row['afp'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                 <?php } ?>
                                                            </div>  
                                                        
                                                        <!-- SALUD -->      
                                                             <div class="row">
                                                               <?php if ($idtrabajador=="") { ?>
                                                                   <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2 fondo">
                                                                        <label class="col-form-label font-bold" for="quantity">Salud</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control bordes"  style="width: 100%;" name="salud" id="salud">
                                                                            <option value="0" selected="">Seleccionar</option>
                                                                            <?php while($row = mysqli_fetch_assoc($salud)) { 
                                                                               $institucion=utf8_encode($row['institucion']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idsalud']; ?>"><?php echo $row['institucion'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                 <?php } else { ?>
                                                                     <div  class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Salud</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control bordes"  style="width: 100%;" name="salud" id="salud">
                                                                            <option value="<?php echo $ftrabajador['idsalud'] ?>" selected=""><?php echo $ftrabajador['institucion'] ?></option>
                                                                            <?php while($row = mysqli_fetch_assoc($salud)) { 
                                                                               $institucion=utf8_encode($row['institucion']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idsalud']; ?>"><?php echo $row['institucion'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                 <?php } ?>
                                                            </div>
                                               
                                                   
                                                    </div>
                                                     
                                                     <input type="hidden" name="idtrabajador" id="idtrabajador" value="<?php echo $idtrabajador  ?>" />
                                                     <input type="hidden" name="idcontratista" id="idcontratista" value="<?php echo $idcontratista  ?>" />                                                     
                                                     <div style="border:1px #c0c0c0 solid;border-radius:5px;padding: 1% 0%;" class="row">
                                                               <div class="col-md-12">
                                                                <div class="form-wrap">
                                                                  <?php if ($idtrabajador=="") { ?>    
                                                                    <!--<a class="btn btn-dark btn-md" href="javascript:close_window();">Cancelar</a> |-->
                                                                    <button class="btn btn-success btn-lg" type="button" onclick="crear_trabajador()" value="" ><strong>CREAR TRABAJADOR</strong></button> 
                                                                    <input type="hidden" name="accion" id="accion" value="guardar" />
                                                                  <?php } else {  ?>
                                                                    
                                                                  <?php if ($ftrabajador['estado']!=0) { ?>  
                                                                     <button type="button" class="btn-danger btn btn-lg" name="borrar" id="borrar" onclick="eliminar(<?php echo $idtrabajador ?>,<?php echo $ftrabajador['rut'] ?>)"><strong>Desvincular</strong></button>
                                                                     <button name="update" id="update" class="btn btn-info btn-lg" type="button"  onclick="crear_trabajador()" >Actualizar</button>
                                                                     <input type="hidden" name="accion" id="accion" value="editar" />
                                                                  <?php } ?>   
                                                                                                          
                                                                    
                                                                    <a style="margin-left: 3%;" class="btn btn-warning  btn-lg" href="files/<?php echo $ftrabajador['rut'] ?>/bajar.php?rut=<?php echo $ftrabajador['rut'] ?>" >Descargar Archivos</a>
                                                                 <?php if ($fconstancia['idconstancia']=="" and $ftrabajador['estado']!=0 ) { ?>
                                                                            <a class="btn btn-dark btn-md" href="javascript:addconstancia(<?php echo $idtrabajador  ?>);">Agregar Constancias</a> 
                                                                       <?php } else { ?> 
                                                                            <a class="btn btn-dark btn-md" href="javascript:addconstancia(<?php echo $idtrabajador  ?>);">Ver Constancias</a>
                                                                       <?php }  ?> 
                                                                  <?php } ?>
                                                                
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                </div>
                                </form>
                            
                            
                        </div>
                    </div>
                </div>
                
                
            </div>
            
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando Trabajador, por favor espere un momento</h3>
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
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    

</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
