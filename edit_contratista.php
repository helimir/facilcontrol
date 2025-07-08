<?php
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==2 or $_SESSION['nivel']==1)  ) { 
    
include('config/config.php');

$regiones=mysqli_query($con,"Select * from regiones ");

if ($_SESSION['nivel']==2) {
    $qcontratista=mysqli_query($con,"Select d.doc_contratista, d.acreditada, o2.IdComuna as idcomuna2, o2.Comuna as comuna2, r2.IdRegion as idregion2, r2.Region as region2, r.IdRegion as idregion1, r.Region as region1, o.*, r.*, c.*, p.* from contratistas as c Left Join pagos as p On p.idcontratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna Left Join regiones as r2 On r2.IdRegion=c.region_rep Left Join comunas as o2 On o2.IdComuna=c.comuna_rep Left Join contratistas_mandantes as d On d.contratista=c.id_contratista  where c.id_contratista='".$_SESSION['contratista']."' and d.mandante='".$_SESSION['mandante']."' ");
} else {
    $qcontratista=mysqli_query($con,"Select d.doc_contratista, d.acreditada, o2.IdComuna as idcomuna2, o2.Comuna as comuna2, r2.IdRegion as idregion2, r2.Region as region2, r.IdRegion as idregion1, r.Region as region1, o.*, r.*, c.*, p.* from contratistas as c Left Join pagos as p On p.idcontratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna Left Join regiones as r2 On r2.IdRegion=c.region_rep Left Join comunas as o2 On o2.IdComuna=c.comuna_rep Left Join contratistas_mandantes as d On d.contratista=c.id_contratista  where c.id_contratista='".$_SESSION['contratista']."' ");
}    

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

    <title>FacilControl | Editar Contratista</title>
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

</style>



</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Editar Contratista <?php  ?> </h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-md btn-success btn-submenu" href="crear_contratista.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contratista</a>
                                        <a class="btn btn-md btn-success btn-submenu" href="list_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratistas</a>
                                    </div>
                              </div>
                         
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmContratistas_e">
                               
                                <!--- estado -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Estado</label>
                                    <?php if ($fcontratista['acreditada']==0) { ?>
                                        <label style="margin-left: 1%;" class="col-sm-2 col-form-label font-bold badge-danger text-center">No Acreditada</label>
                                    <?php } else { ?>
                                        <label style="margin-left: 1%;" class="col-sm-2 col-form-label font-bold badge-success text-center">Acreditada</label>
                                    <?php } ?>    
                                    
                                </div>
                                
                                <!--- rut -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">RUT</label>
                                    <div class="col-sm-2"><input name="rut" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" value="<?php echo $fcontratista['rut'] ?>" readonly="" /></div>
                                </div>
                                
                                 <!--- razon social -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Raz&oacute;n Social</label>
                                    <div class="col-sm-6"><input name="razon_social" type="text" class="form-control" value="<?php echo $fcontratista['razon_social'] ?>" readonly="" /></div>
                                </div>
                                
                                 <!--- giro -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label font-bold">Giro</label>
                                    <div class="col-sm-6"><input name="giro" type="text" class="form-control" value="<?php echo $giro ?>" /></div>
                                </div>
                                 <!--- descripcion -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Descripci&oacute;n del giro</label>
                                    <div class="col-sm-6"><input name="descripcion" type="text" class="form-control" value="<?php echo $fcontratista['descripcion_giro'] ?>" /></div>
                                </div>
                                 <!--- nombre de fantasia -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Nombre de Fantas&iacute;a</label>
                                    <div class="col-sm-6"><input name="nombre_fantasia" type="text" class="form-control" value="<?php echo $fcontratista['nombre_fantasia'] ?>" /></div>
                                </div>
                                
                                
                                <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Direcci&oacute;n Comercial</label>
                                    <div class="col-sm-4">
                                        <select id="region_com" name="region_com" class="form-control">
                                           <option value="<?php echo $fcontratista['idregion1'] ?>" selected=""><?php echo $fcontratista['region1'] ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold"></label>
                                    <div class="col-sm-4">
                                        <select id="comuna_com" name="comuna_com" class="form-control">
                                           <option value="<?php echo $fcontratista['idcomuna1'] ?>" selected=""><?php echo $fcontratista['comuna1'] ?></option>
                                               
                                        </select>
                                    </div>
                                </div>         
                                
                                <hr />
                                <div class="form-group row">
                                    <div class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Administrador del Sistema</h3> </div>
                                </div> 
                                
                                                       
                                <!-- administrador -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label font-bold">Nombre</label>
                                    <div class="col-sm-4"><input name="administrador" type="text" class="form-control" value="<?php echo $fcontratista['administrador'] ?>" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label font-bold">Tel&eacute;fono</label>
                                    <div class="col-sm-2"><input name="fono" type="text" class="form-control" value="<?php echo $fcontratista['fono'] ?>" /></div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label font-bold">Correo</label>
                                    <div class="col-sm-2"><input name="email" type="email" class="form-control" value="<?php echo $fcontratista['email'] ?>" /></div>
                                </div>
                                <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Ciudad</label>
                                    <div class="col-sm-4">
                                        <select  name="region_rep" id="region_rep" class="form-control">
                                           <option value="<?php echo $fcontratista['idregion2'] ?>" selected=""><?php echo $fcontratista['region2'] ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold"></label>
                                    <div class="col-sm-4">
                                        <select name="comuna_rep" id="comuna_rep" class="form-control">
                                           <option value="<?php echo $fcontratista['idcomuna2'] ?>" selected=""><?php echo $fcontratista['comuna2'] ?></option>
                                               
                                        </select>
                                    </div>
                                </div>
                                
                               
                                <hr />
                                <div class="form-group row">
                                    <div class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Representante Legal</h3> </div>
                                </div>           
                                <!-- representante -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label font-bold">Nombre</label>
                                    <div class="col-sm-4"><input name="representante" type="text" class="form-control" value="<?php echo $fcontratista['representante'] ?>"   /></div>
                                </div>
                                
                                <!-- rut -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">RUT</label>
                                    <div class="col-sm-2"><input name="rut_rep" type="text" class="form-control" placeholder="11111111-1" autocomplete="off" maxlength="10"   oninput="checkRut(this)" value="<?php echo $fcontratista['rut_rep'] ?>"  /></div>
                                </div>
                               
                                 <!--- direccion representante -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Direcci&oacute;n</label>
                                    <div class="col-sm-6"><input name="direccion_rep" type="text" class="form-control" value="<?php echo $fcontratista['direccion_rep'] ?>"  /></div>
                                </div>
                                                                
                                <!--- direccion rep -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Regi&oacute;n</label>
                                    <div class="col-sm-4">
                                        <select id="region_rep" name="region_rep" class="form-control">
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Comuna</label>
                                    <div class="col-sm-4">
                                        <select id="comuna_rep" name="comuna_rep" class="form-control">
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
                                        </select>
                                    </div>
                                </div>   
                                
                                <div class="form-group row"><label class="col-sm-2 col-form-label font-bold">Estado Civil</label>
                                    <div class="col-sm-4">
                                        <select id="estado_civil" name="estado_civil" class="form-control">
                                           <option value="Soltero" selected="">Soltero</option>
                                           <option value="Casado" >Casado</option>
                                               
                                        </select>
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
                                
                                
                                
                                
                                 <table class="table table-responsive">
                                    <thead>
                                   
                                    <tr>
                                        <th class="col-1" style="width: 5%;">#</th>
                                        <th class="col-10" style="width: 20%;">Documento</th>
                                        <th class="col-2 text-center" style="width: 10%;">Habilitar</th>
                                        <!--<th style="width: 15%;">Vencimiento <a class="tags2" gloss="Sin fecha seleccionada se considera indefinido"><sup  ><i style="font-size: 14px;" class="fa fa-info-circle" aria-hidden="true"></i></sup></a></th>
                                        <th style="width: 5%;">Reset</th>-->
                                    </tr>
                                    
                                    </thead>
                                    <tbody>
                                    
                                    <?php 
                                       $i=1;$j=0; 
                                       
                                       foreach ($doc as $row) {
                                                $doc_habilitado=FALSE;
                                                if (in_array($row['id_cdoc'],$array_doc)) {
                                                    $doc_habilitado=TRUE;
                                                } 
                                           switch ($array_fechas[$j]) {
                                            case 1:$periodo='Indefinido';break;
                                            case 2:$periodo='Fin de A&ntilde;o';break;
                                            case 3:$periodo='&Uacute;ltimo d&iacute;a de cada mes';break;
                                            case 4:$periodo='D&iacute;a 5 de cada mes';break;
                                            case 5:$periodo='D&iacute;a 15 de cada mes';break;
                                           }                                                    
                                    ?>    
                                       <tr>
                                           <td><?php echo $i ?></td> 
                                           <td><label class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                           <?php if ($doc_habilitado) { ?>
                                                <td class="text-center" ><input id="doc_contratista<?php echo $i ?>"  name="doc_contratista[]" type="checkbox" value="<?php echo $row['id_cdoc'] ?>" checked="" onclick="habilitar_fecha(<?php echo $i ?>)" /></td>
                                                
                                                <!--<td>
                                                    <?php if ($array_fechas[$j]=="") { ?>
                                                        <input name="periodo<?php echo $i ?>" id="periodo<?php echo $i ?>" type="date" class="form-control" value="00-00-0000" />
                                                    <?php } else { ?>
                                                        <input name="periodo<?php echo $i ?>" id="periodo<?php echo $i ?>" type="date" class="form-control" value="<?php echo $array_fechas[$j]  ?>" />    
                                                    <?php } ?>    
                                                    
                                                </td>
                                                <td>
                                                   <select class="form-control" name="periodo<?php echo $i ?>" id="periodo<?php echo $i ?>" >
                                                    <option value="<?php echo $array_fechas[$j] ?>" selected=""><?php echo $periodo ?></option>
                                                    <option value="0">Seleccionar Periodo</option>
                                                    <option value="1">Idenfinido</option>
                                                    <option value="2">Fin de A&ntilde;o</option>
                                                    <option value="3">&Uacute;ltimo d&iacute;a de cada mes</option>
                                                    <option value="4">D&iacute;a 5 de cada mes</option>
                                                    <option value="5">D&iacute;a 15 de cada mes</option>
                                                   </select>                                            
                                                </td> 
                                                <td><button id="indefinido<?php echo $i ?>" type="button" onclick="indefinido(<?php echo $i  ?>)" class="btn btn-xs btn-primary" >Sin fecha</button></td>-->
                                                
                                           <?php $j++; 
                                              } else { ?>     
                                                <td class="text-center" ><input id="doc_contratista<?php echo $i ?>" name="doc_contratista[]" type="checkbox" value="<?php echo $row['id_cdoc'] ?>" onclick="habilitar_fecha(<?php echo $i ?>)"  /></td>
                                                
                                                <!--<td><input name="periodo<?php echo $i ?>" id="periodo<?php echo $i ?>" type="date" class="form-control" value="00-00-0000" disabled="" /></td>
                                                <td>
                                                   <select class="form-control" name="periodo<?php echo $i ?>" id="periodo<?php echo $i ?>" disabled="">
                                                    <option value="0" selected="">Seleccionar Periodo</option>
                                                    <option value="1">Idenfinido</option>
                                                    <option value="2">Fin de A&ntilde;o</option>
                                                    <option value="3">&Uacute;ltimo d&iacute;a de cada mes</option>
                                                    <option value="4">D&iacute;a 5 de cada mes</option>
                                                    <option value="5">D&iacute;a 15 de Cada mes</option>
                                                   </select>                                            
                                               </td> 
                                                <td><button id="indefinido<?php echo $i ?>" type="button" onclick="indefinido(<?php echo $i  ?>)" class="btn btn-xs btn-primary" disabled="">Sin fecha</button></td>-->
                                                
                                           <?php } ?>
                                            
                                               
                                       </tr>
                                    <?php $i++;} ?> 
                                    
                                    </tbody>
                                </table>
                                
                                  
                                <hr />
                                
                                
                                <input type="hidden" name="id_contratista" value="<?php echo $fcontratista['id_contratista']  ?>" />
                                <input type="hidden" name="contratistas" value="actualizar" />
                                <input type="hidden" name="total_doc" value="<?php echo $i ?>" />
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <!--<button style="background:#010829;color:#fff" class="btn btn-white btn-md" type="button">Cambiar</button>-->
                                        <button class="btn btn-success btn-md" type="button" onclick="editar_contratista()">Actualizar Contratista</button>
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
            
            function indefinido(i) {                                            
                alert(i);
                $("#periodo"+i).val('');
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
   
    function habilitar_fecha(id) {
        //alert (id);
        var isChecked = $('#doc_contratista'+id).prop('checked');
        if (isChecked) {
           $("#periodo"+id).removeAttr("disabled");
           $("#indefinido"+id).removeAttr("disabled");
        } else {
           $("#periodo"+id).attr("disabled","disabled");
           $("#indefinido"+id).attr("disabled","disabled");
        }
      }
    
    function refresh_editar(){
        window.location.href='edit_contratista.php';
    }
    
    function editar_contratista(){
      //alert('hola');
      var valores=$('#frmContratistas_e').serialize();
      $.ajax({
    			method: "POST",
                url: "add/contratistas.php",
                data: valores,
    			success: function(data){			  
                 if (data==2) {
                    //alert(data);
                     swal({
                            title: "Contratista Actualizada",
                            //text: "You clicked the button!",
                            type: "success"
                        }
                     );
                     setTimeout(refresh_editar, 1000);
    			  } else {
    			     //alert(data);
                        swal("Contratista No Actualizada", "Vuelva a Intentar.", "error");                        
                        setTimeout(refreshrefresh_editar, 1000);
                                                                           
    			  }
    			}                
           });
            
           
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
