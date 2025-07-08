<?php
session_start();
include('../config/config.php');
$query=mysqli_query($con,"select c.contrato,  c.url_foto, c.codigo, n.nombre_contrato, o.razon_social as nom_contratista, m.razon_social as nom_mandante, m.logo, a.tipo, a.marca, a.modelo, a.color, a.patente from autos as a Left Join vehiculos_acreditados as c On c.vehiculo=a.id_auto Left join contratistas as o On o.id_contratista=c.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratos as n On id_contrato=c.contrato where c.codigo='".$_GET['codigo']."' ");$result=mysqli_fetch_array($query);
if ($result['fecha']=='0000-00-00') {
    $fecha='Indefinido';
} else {
    $fecha=$result['fecha'];
}
 $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/mobile/i", $useragent) ) { 
      
      $codigo1=substr($result['codigo'],0,3);
      $codigo2=substr($result['codigo'],-3);
         ?>


<? } else { 
   
   $codigo1=substr($result['codigo'],0,3);
   $codigo2=substr($result['codigo'],-3);?>
                    <div class="modal-body">
                                 <div style="position:relative;" class="row">
                                          <div class="col-12" >
                                             <img width="100%" heigth="30%" src="img/credencial_vehiculo.png">
                                          </div> 
                                          <div style="position: absolute;margin-top:8.5%;margin-left:22%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_contratista'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:3%;margin-left:70%" class="col-12" >
                                             <img width="20%"  src="<?php echo $result['url_foto'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:3%;margin-left:3%" class="col-12" >
                                             <img width="15%"  src="<?php echo $result['logo'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:14.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:19.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_mandante'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:24%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['tipo'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:29%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['marca'].' '.$result['modelo'] ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:34%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['color']  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:38.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['patente']  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:51%;margin-left:30%;" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:35px;color:#fff" class="fuente"><?php echo $codigo1  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:51%;margin-left:52%;color:#fff" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:35px;color:#fff" class="fuente"><?php echo $codigo2  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:25%;margin-left:69%;color:#fff" class="row">
                                             <div class="col-12" >
                                                   <img width="63%" src="img/qr/vehiculos/<?php echo $result['patente']  ?>/qr_<?php echo $result['contrato']  ?>_<?php echo $result['patente']  ?>.png" > >
                                             </div> 
                                       </div>
                                 </div>    
                            
                    
                        
                    </div>
      <? } ?>

                   <?php if ( $result['estado_ta']==2) { ?> 
                     <div style="text-align:center !important" class="modal-footer">
                           <label class="label bg bg-danger"><strong>Trabajador Desvinculado</strong></label>
                     </div>
                  <?php } ?> 