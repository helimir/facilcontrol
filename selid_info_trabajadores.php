<?php
session_start();
include('config/config.php');
$query=mysqli_query($con,"select a.estado as estado_ta, a.url_foto, a.contratista, a.validez, r.cargo as nom_cargo, a.codigo, c.nombre_contrato, t.nombre1, t.apellido1, t.rut, m.razon_social as nom_mandante from trabajadores_acreditados as a Left Join contratos as c On id_contrato=a.contrato Left Join trabajador as t On t.idtrabajador=a.trabajador Left Join mandantes as m On m.id_mandante=a.mandante Left Join cargos as r On r.idcargo=a.cargo  where a.codigo='".$_GET['codigo']."' ");
$result=mysqli_fetch_array($query);
if ($result['fecha']=='0000-00-00') {
    $fecha='Indefinido';
} else {
    $fecha=$result['fecha'];
}
?>
                    <div class="modal-body">
                        <div style="position:relative;" class="row">
                               <div class="col-12" >
                                  <img width="100%" heigth="30%" src="img/credencial_nueva.jpeg">
                              </div> 
                              <div style="position: absolute;margin-top:9.5%;margin-left:22%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['nombre_contrato'] ?></strong></label>
                                 </div> 
                              </div>
                              <div style="position: absolute;margin-top:4%;margin-left:72%" class="col-12" >
                                  <img width="80px" heigth="30px" heigth="" src="<?php echo $result['url_foto'] ?>"> 
                              </div> 
                              <div style="position: absolute;margin-top:17%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['nombre_contrato'] ?></strong></label>
                                 </div> 
                              </div>
                              <div style="position: absolute;margin-top:22.5%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['nom_mandante'] ?></strong></label>
                                 </div> 
                              </div>
                              <div style="position: absolute;margin-top:27.5%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['nom_cargo'] ?></strong></label>
                                 </div> 
                              </div>
                              <div style="position: absolute;margin-top:33.5%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['nombre1'].' '.$result['apellido1'] ?></strong></label>
                                 </div> 
                            </div>
                            <div style="position: absolute;margin-top:39%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['rut']  ?></strong></label>
                                 </div> 
                            </div>
                            <div style="position: absolute;margin-top:44%;margin-left:20%" class="row">
                                 <div class="col-12" >
                                    <label><strong><?php echo $result['validez']  ?></strong></label>
                                 </div> 
                            </div>
                        </div>       
                            
                    
                           
                            <!-- <div class="row">
                               <div class="col-12" >
                                  <label><strong>RUT :</strong> <?php echo $result['rut'] ?></label>
                               </div> 
                            </div>
                            <div class="row">
                               <div class="col-12" >
                                  <label><strong>Contratista: </strong> <?php echo $result['contratista'] ?></label>
                               </div> 
                            </div>
                            <div class="row">
                               <div class="col-12" >
                                  <label><strong>Mandante: </strong> <?php echo $result['mandante'] ?></label>
                               </div> 
                            </div>
                            <div class="row">
                               <div class="col-12" >
                                  <label><strong>Fecha: </strong> <?php echo $fecha ?></label>
                               </div> 
                            </div> -->
                        
                    </div>
                   <?php if ( $result['estado_ta']==2) { ?> 
                     <div style="text-align:center !important" class="modal-footer">
                           <label class="label bg bg-danger"><strong>Trabajador Desvinculado</strong></label>
                     </div>
                  <?php } ?> 