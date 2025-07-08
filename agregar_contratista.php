<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==2 or $_SESSION['nivel']==1)  ) { 
    
include('config/config.php');

$regiones=mysqli_query($con,"Select * from regiones ");
$qcontratista=mysqli_query($con,"Select o2.IdComuna as idcomuna2, o2.Comuna as comuna2, r2.IdRegion as idregion2,r2.Region as region2,o.IdComuna as idcomuna1, o.Comuna as comuna1, r.IdRegion as idregion1, r.Region as region1, o.*, r.*, c.*, p.* from contratistas as c Left Join pagos as p On p.idcontratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna Left Join regiones as r2 On r2.IdRegion=c.region_rep Left Join comunas as o2 On o2.IdComuna=c.comuna_rep  where c.id_contratista='".$_SESSION['contratista_agregada']."' ");
$fcontratista=mysqli_fetch_array($qcontratista);
$doc=mysqli_query($con,"Select * from doc_contratistas ");
$array_doc=unserialize($fcontratista['doc_contratista']);
$array_fechas=unserialize($fcontratista['doc_fechas']);

$giro=$fcontratista['giro'];

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

switch ($fcontratista['plan']) {
    case '0': $plan='Prueba';
    case '1': $plan='Mensual';
    case '2': $plan='Trimestral';
    case '3': $plan='Semestral';
    case '4': $plan='Anual';
    
}

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Agregar Contratista</title>

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



    $(document).ready(function(){
				$("#region_com").change(function () {				
					$("#region_com option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_com").html(data);
						});            
					});
				})
                
                $("#region_rep").change(function () {				
					$("#region_rep option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_rep").html(data);
						});            
					});
				})
    });

    
    function agregar_contratista(){
      //alert('hola');
      var valores=$('#frmContratistas').serialize();
      $.ajax({
    			method: "POST",
                url: "add/agregar_contratista_multiple.php",
                data: valores,
                beforeSend: function(){
                    $('#modal_cargar').modal('show');						
    			},
    			success: function(data){			  
                 if (data==0) {
                    //alert(data);
                     swal({
                            title: "Contratista Agregada",
                            //text: "You clicked the button!",
                            type: "success"
                        }
                     );
                     setTimeout(window.location.href='list_contratistas_mandantes.php', 5000);
    			  } else {
    			     //alert(data);
                        swal("Cancelado", "Contratista No Actualizada. Vuelva a Intentar.", "error");                        
                        setTimeout(refreshrefresh_editar, 1000);
                                                                           
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
<style>

        input[type=checkbox]
        {
          /* Doble-tama�o Checkboxes */
          -ms-transform: scale(2.5); /* IE */
          -moz-transform: scale(2.5); /* FF */
          -webkit-transform: scale(2.5); /* Safari y Chrome */
          -o-transform: scale(2.5); /* Opera */
          padding: 10px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
        .checkboxtexto
        {
          /* Checkbox texto */
          font-size: 80%;
          display: inline;
        }
        
        .tags {
          display: inline;
          position: relative;
        }
        
        .tags:hover:after {
          background: #333;
          background: rgba(0, 0, 0, .8);
          border-radius: 5px;
          bottom: -34px;
          color: #fff;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 350px;
        }
        
        .tags:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
        }
        
        
        .tags2 {
          display: inline;
          position: relative;
        }
        
        .tags2:hover:after {
          background: #333;
          background: rgba(0, 0, 0, .8);
          border-radius: 5px;
          bottom: -64px;
          color: #fff;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 150px;
        }
        
        .tags2:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
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

.caja_label {
    background:#BFC6D4;
    color:#282828;
    font-weight:bold;
}

.bordes {
    border: 1px solid #c0c0c0;
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
                    <h2 style="color: #010829;font-weight: bold;">Agregar Contratista <?php  ?> </h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-md btn-success btn-submenu" href="crear_contratista.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i><strong>Crear Contratista</strong></a>
                                        <a class="btn btn-md btn-success btn-submenu" href="list_contratistas_mandantes.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i><strong>Reporte de Contratistas</strong></a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmContratistas">
                               
                                <!--- rut -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">RUT</label>
                                    <div class="col-sm-2">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['rut'] ?></label>
                                        <input name="rut" id="rut" type="hidden" value="<?php echo $fcontratista['rut'] ?>" />
                                     </div>
                                </div>
                                
                                 <!--- razon social -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Raz&oacute;n Social</label>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['razon_social'] ?></label>
                                        <input name="razon_social" type="hidden" class="form-control" value="<?php echo $fcontratista['razon_social'] ?>" readonly="" />
                                    </div>
                                </div>
                                
                                 <!--- giro -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label caja_label">Giro</label>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;"><?php echo $giro ?></label>
                                        <input name="giro" type="hidden" class="form-control" value="<?php echo $giro ?>" />
                                    </div>
                                </div>
                                 <!--- descripcion -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Descripci&oacute;n del giro</label>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['descripcion_giro'] ?></label>
                                        <input name="descripcion" type="hidden" class="form-control" value="<?php echo $fcontratista['descripcion_giro'] ?>" />
                                     </div>
                                </div>
                                 <!--- nombre de fantasia -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Nombre de Fantas&iacute;a</label>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['nombre_fantasia'] ?></label>
                                        <input name="nombre_fantasia" type="hidden" class="form-control" value="<?php echo $fcontratista['nombre_fantasia'] ?>" />
                                    </div>
                                </div>
                                
                                
                                <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Direcci&oacute;n Comercial</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;">Regi&oacute;n: <?php echo $fcontratista['region1'] ?></label>
                                        <input type="hidden" name="region_com" value="<?php echo $fcontratista['idregion1'] ?>"  />
                                    </div>
                                </div>
                               
                                <div class="form-group row"><label class="col-sm-2 col-form-label "></label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;">Comuna: <?php echo $fcontratista['comuna1'] ?></label>
                                        <input type="hidden" name="comuna_com"  value="<?php echo $fcontratista['idcomuna1'] ?>"  />
                                    </div>
                                </div>         
                                
                               
                                <div style="border-bottom:1px #BFC6D4 solid;color:#292929" class="form-group row">
                                    <div class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Administrador del Sistema</h3> </div>
                                </div> 
                                
                                                       
                                <!-- administrador -->
                                <div class="form-group  row"><label class="col-2 col-form-label caja_label">Nombre</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['administrador'] ?></label>
                                        <input name="administrador" type="hidden" class="form-control" value="<?php echo $fcontratista['administrador'] ?>" />
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-2 col-form-label caja_label">Tel&eacute;fono</label>
                                    <div class="col-sm-2">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['fono'] ?></label>
                                        <input name="fono" type="hidden" class="form-control" value="<?php echo $fcontratista['fono'] ?>" />
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-2 col-form-label caja_label">Correo</label>
                                    <div class="col-sm-2">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['email'] ?></label>
                                        <input name="email" type="hidden" class="form-control" value="<?php echo $fcontratista['email'] ?>" />
                                    </div>
                                </div>
                                <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-2 col-form-label caja_label">Ciudad</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;">Regi&oacute;n: <?php echo $fcontratista['region1'] ?></label>
                                        <input name="region_rep" type="hidden" class="form-control" value="<?php echo $fcontratista['idregion1'] ?>" />
                                        
                                        <!--<select  name="region_rep" id="region_rep" class="form-control">
                                           <option value="<?php echo $fcontratista['idregion1'] ?>" selected=""><?php echo $fcontratista['region1'] ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>-->
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;">Comuna: <?php echo $fcontratista['comuna1'] ?></label>
                                        <input name="region_rep" type="hidden" class="form-control" value="<?php echo $fcontratista['idcomuna1'] ?>" />
                                        
                                        <!--<select name="comuna_rep" id="comuna_rep" class="form-control">
                                           <option value="<?php echo $fcontratista['idcomuna1'] ?>" selected=""><?php echo $fcontratista['comuna1'] ?></option>
                                               
                                        </select>-->
                                    </div>
                                </div>
                               
                                <div style="border-bottom:1px #BFC6D4 solid;color:#292929" class="form-group row">
                                    <div class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Representante Legal</h3> </div>
                                </div>           
                                <!-- representante -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label caja_label">Nombre</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['representante'] ?></label>
                                        <input name="representante" type="hidden" class="form-control" value="<?php echo $fcontratista['representante'] ?>"  />
                                    </div>
                                </div>
                                
                                <!-- rut -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">RUT</label>
                                    <div class="col-sm-2">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['rut_rep'] ?></label>
                                        <input name="rut_rep" type="hidden"  value="<?php echo $fcontratista['rut_rep'] ?>"  />
                                    </div>
                                </div>
                               
                                 <!--- direccion representante -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Direcci&oacute;n</label>
                                    <div class="col-sm-6">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['direccion_rep'] ?></label>
                                        <input name="direccion_rep" type="hidden" class="form-control" value="<?php echo $fcontratista['direccion_rep'] ?>"  />
                                    </div>
                                </div>
                                                                
                                <!--- direccion rep -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Regi&oacute;n</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;"><?php echo $fcontratista['region2'] ?></label>
                                        <input name="region_rep" type="hidden" class="form-control" value="<?php echo $fcontratista['idregion2']  ?>"  />
                                        
                                        <!--<select id="region_rep" name="region_rep" class="form-control">                                           
                                           <option value="<?php echo $fcontratista['idregion2'] ?>" selected=""><?php echo $fcontratista['region2'] ?></option>
                                           <option value="0" >Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>-->
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Comuna</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;"><?php echo  $fcontratista['comuna2'] ?></label>
                                        <input name="comuna_rep" type="hidden" class="form-control" value="<?php echo $fcontratista['idcomuna2']  ?>"  />
                                        
                                        <!--<select id="comuna_rep" name="comuna_rep" class="form-control">
                                           <option value="<?php echo $fcontratista['idcomuna2'] ?>" selected=""><?php echo $fcontratista['comuna2'] ?></option>
                                           <option value="0" >Seleccionar Comuna</option>
                                               
                                        </select>-->
                                    </div>
                                </div>   
                                
                                <div class="form-group row"><label class="col-sm-2 col-form-label caja_label">Estado Civil</label>
                                    <div class="col-sm-4">
                                        <label style="font-weight: bold;"><?php echo  $fcontratista['estado_civil'] ?></label>
                                        <input name="estado_civil" type="hidden" class="form-control" value="<?php echo $fcontratista['estado_civil']  ?>"  />
                                        
                                        <!--<select id="estado_civil" name="estado_civil" class="form-control">
                                           <option value="<?php echo $fcontratista['estado_civil'] ?>" selected=""><?php echo $fcontratista['estado_civil'] ?></option>
                                           <option value="Soltero">Soltero</option>
                                           <option value="Casado" >Casado</option>
                                               
                                        </select>-->
                                    </div>
                                </div>                                 
                                                                                              
                                <hr />
                                <div class="row">
                                    <div class="col-sm-12 col-form-label">
                                        <h3 style="text-align: ;">Documentacio&oacute;n que debe enviar el Contratista
                                            <a class="tags" gloss="Seleccionar en boton habilitar los documetnos que la empresa contratista debe enviar para revisi&oacute;n del mandante antes de comezar su operaci&oacute;n, si esta informaci&oacute;n no esta disponible no podr&aacute; crea acceso a su personal"><sup  ><i style="font-size: 14px;" class="fa fa-info-circle" aria-hidden="true"></i></sup></a>
                                        </h3>
                                        <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label> 
                                    </div>
                                </div>
                                
                                
                                
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-responsive">
                                            <thead>                                        
                                                <tr style="background:#010829;color:#fff">
                                                    <th  class="col-11">Documento</th>
                                                    <th  class="col-2" >Seleccionar</th>
                                                </tr>                                            
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $i=1;$j=0;                                                 
                                                foreach ($doc as $row) {?>    
                                                <tr>                                         
                                                    <td><label style="font-size:14px" id="doc<?php echo $i ?>" class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                    <td class="text-center" ><input id="doc_contratista<?php echo $i ?>" name="doc_contratista[]" type="checkbox" value="<?php echo $row['id_cdoc'] ?>" onclick="habilitar_fecha(<?php echo $i ?>)"  /></td>                                               
                                                </tr>
                                                <?php $i++;} ?>                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                  
                                <hr />
                                
                                
                                <input type="hidden" name="id_contratista" value="<?php echo $fcontratista['id_contratista']  ?>" />
                                <input type="hidden" name="nom_contratista" value="<?php echo $fcontratista['razon_social']  ?>" />
                                <input type="hidden" name="contratistas" value="actualizar" />
                                <input type="hidden" name="total_doc" value="<?php echo $i ?>" />
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <!--<button style="background:#010829;color:#fff" class="btn btn-white btn-md" type="button">Cambiar</button>-->
                                        <button class="btn btn-success btn-md" type="button" onclick="agregar_contratista()"><i class="fa fa-refresh" aria-hidden="true"></i> Agregar Contratista</button>
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
                                  <h3>Agregando Contratista, por favor espere un momento</h3>
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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
        <script>
            
            function habilitar_fecha(id) {
                //alert (id);
                var isChecked = $('#doc_contratista'+id).prop('checked');
                if (isChecked) {
                    document.getElementById("doc"+id).style.fontWeight = "bold";
                } else {
                    document.getElementById("doc"+id).style.fontWeight = "Normal";
                }
            }

            function indefinido(i) {                                            
                alert(i);
                $("#periodo"+i).val('');
            }
        
            $(document).ready(function () {
 
                
                
            });
   
   

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
