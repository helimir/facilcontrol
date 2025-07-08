<?php
include('config/config.php');
session_start();


if ($_GET['tipo']==1) {
    $query_m=mysqli_query($con,"select e.*, m.razon_social from documentos_extras as e Left Join mandantes as m On m.id_mandante=e.mandante where e.contratista='".$_GET['contratista']."' and e.mandante='".$_GET['mandante']."' and e.id_de='".$_GET['doc']."' and e.tipo='1' and e.estado!='3'  ");
    $result_m=mysqli_fetch_array($query_m);
}

if ($_GET['tipo']==2) {
    $query_t=mysqli_query($con,"select m.documento, t.*, a.razon_social, c.nombre_contrato from trabajador as t INNER JOIN documentos_extras as m ON m.trabajador=t.idtrabajador left join mandantes as a On a.id_mandante=m.mandante left join contratos as c On c.id_contrato=m.contrato WHERE m.trabajador='".$_GET['trabajador']."' and m.tipo='2' and m.estado!='3'  ");
    $result_t=mysqli_fetch_array($query_t);    
}

if ($_GET['tipo']==3) {
    $query_t=mysqli_query($con,"select m.documento, t.*, a.razon_social, c.nombre_contrato from trabajador as t INNER JOIN documentos_extras as m ON m.trabajador=t.idtrabajador left join mandantes as a On a.id_mandante=m.mandante left join contratos as c On c.id_contrato=m.contrato WHERE m.trabajador='".$_GET['trabajador']."' and m.tipo='3' and m.estado!='3'  ");
    $result_t=mysqli_fetch_array($query_t);    
} 



                                    
                                    if ($_GET['tipo']==1)  { ?> 

                                       
                                        <div class="modal-body">      
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label style="font-size:12px" class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documento:</label>
                                                    </div>   
                                                    <div class="col-6">
                                                        <label style="" class="form-label" id="nom_doc"><?php echo $result_m['documento'] ?></label>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Mandante:</label>
                                                    </div>   
                                                    <div class="col-6">
                                                        <label style="font-weight:" class="form-label" id="nom_doc"><?php echo $result_m['razon_social'] ?></label>
                                                    </div> 
                                                </div>
                                                
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i><strong> Adjunte archivo solicitado:</strong><br/><small>(Archivos tipo PDF permitidos)</small></label>
                                                    </div> 
                                                    <div style="background:#282828;text-align:center" class="col-sm-6">
                                                        <div style="margin-top:3%" class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span  style="background: #282828;color: #000;border: 1px #fff solid;color:#fff;" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                            <span  class="fileinput-exists">Cambiar</span><input  class="form-control"  type="file" id="carga_doc_simultaneo" name="carga_doc_simultaneo" accept="application/pdf" /></span>
                                                            <span class="fileinput-filename"></span>                                                             
                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>  
                                                </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
                                            <button class="btn btn-success btn-sm" type="button" onclick="cargar_doc_extra(1,<?php echo $_GET['mandante'] ?>,<?php echo $_GET['tipo'] ?>,<?php echo $_GET['doc'] ?>)" >Enviar documento</button>  
                                        </div>

                                        <?php }  ?>              
                                        
                        <?php if ($_GET['tipo']==2) { ?>

                                       <div class="modal-body">     
                                                <div class="row">
                                                  <div class="col-sm-3">
                                                     <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajador:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre1'].' '.$result_t['apellido1'].' ('.$result_t['rut'].')' ?></label>
                                                  </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                         <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Contrato:</label>
                                                    </div>   
                                                    <div class="col-6">
                                                         <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre_contrato'] ?></label>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-3">
                                                     <label style="font-size:12px" class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documento:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label style="" class="form-label" id="nom_doc"><?php echo $result_t['documento'] ?></label>
                                                  </div> 
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-3">
                                                     <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Mandante:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label style="font-weight:" class="form-label" id="nom_doc"><?php echo $result_t['razon_social'] ?></label>
                                                  </div> 
                                                </div>
                                                
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i><strong> Adjunte archivo solicitado:</strong><br/><small>(Archivos tipo PDF permitidos)</small></label>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                        <div style="background:#282828;text-align:center" class="col-12">
                                                            <div style="margin-top:3%" class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span  style="background: #282828;color: #000;border: 1px #fff solid;color:#fff;" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                                <span  class="fileinput-exists">Cambiar</span><input  class="form-control"  type="file" id="carga_doc_simultaneo" name="carga_doc_simultaneo" accept="application/pdf" /></span>
                                                                <span class="fileinput-filename"></span>                                                             
                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>  
                                                </div>
                                                <input style="display:none" class="estilo" id="trabajadores0" name="trabajadores[]" type="checkbox" checked="" value="<?php echo $_GET['trabajador'] ?>" />            
                                               

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" >Cerrar</button>
                                                <button class="btn btn-success btn-sm" type="button" onclick="cargar_doc_extra(1,<?php echo $_GET['mandante'] ?>,<?php echo $_GET['tipo'] ?>,<?php echo $_GET['doc'] ?>,<?php echo $_GET['trabajador'] ?>,<?php echo $_GET['contrato'] ?>)" >Enviar documento</button>
                                            </div>

                        <?php } 


                        if ($_GET['tipo']==3) { ?>

                            <div class="modal-body">     
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajador:</label>
                                    </div>   
                                    <div class="col-6">
                                        <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre1'].' '.$result_t['apellido1'].' ('.$result_t['rut'].')' ?></label>
                                    </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Contrato:</label>
                                        </div>   
                                        <div class="col-6">
                                            <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre_contrato'] ?></label>
                                        </div> 
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <label style="font-size:12px" class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documento:</label>
                                    </div>   
                                    <div class="col-6">
                                        <label style="" class="form-label" id="nom_doc"><?php echo $result_t['documento'] ?></label>
                                    </div> 
                                    </div>
                                    <div class="row">
                                    <div class="col-sm-3">
                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i> Mandante:</label>
                                    </div>   
                                    <div class="col-6">
                                        <label style="font-weight:" class="form-label" id="nom_doc"><?php echo $result_t['razon_social'] ?></label>
                                    </div> 
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label class="form-label"><i class="fa fa-chevron-right" aria-hidden="true"></i><strong> Adjunte archivo solicitado:</strong><br/><small>(Archivos tipo PDF permitidos)</small></label>
                                    </div> 
                                        <div style="background:#282828;text-align:center" class="col-sm-6">
                                            <div style="margin-top:3%" class="fileinput fileinput-new" data-provides="fileinput">
                                                <span  style="background: #282828;color: #000;border: 1px #fff solid;color:#fff;" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                <span  class="fileinput-exists">Cambiar</span><input  class="form-control"  type="file" id="carga_doc_simultaneo" name="carga_doc_simultaneo" accept="application/pdf" /></span>
                                                <span class="fileinput-filename"></span>                                                             
                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                            </div>
                                        </div>  
                                    </div>

                                    
                                    <?php if ($_GET['estado']!='2') { ?> 
                                            <div class="row" style="margin-top: 5%;" >
                                                <div style="text-align:"  class="col-12">
                                                    <label class="label form-label block"><i class="fa fa-info-circle" aria-hidden="true"></i> Puede agregar el archivo a otros trabajadores del contrato</label>
                                                </div>
                                                <div class="col-12">
                                                    
                                                    <table style="overflow-y: auto;" class="table">
                                                        <thead style="background:#010829;color:#fff">
                                                            <tr>
                                                                <th style="width: 20%;border-right:1px #fff solid">Trabajador</th>
                                                                <th class="text-center" style="width: 10%;">RUT</th>
                                                                <th class="text-center" style="width: 10%;">Seleccionar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $i=1; 
                                                            if ($_GET['tipo']==2) { 
                                                                $query_tm=mysqli_query($con,"select a.*, t.* from documentos_extras as a left join trabajador as t On t.idtrabajador=a.trabajador where  a.contrato='".$_GET['contrato']."' and a.documento='".$result_t['documento']."' and a.estado!='3' and a.tipo='2' ");
                                                            }

                                                            if ($_GET['tipo']==3) { 
                                                                $query_tm=mysqli_query($con,"select a.*, t.* from documentos_extras as a left join trabajador as t On t.idtrabajador=a.trabajador where  a.contrato='".$_GET['contrato']."' and a.documento='".$result_t['documento']."' and a.estado!='3' and a.tipo='3' ");
                                                            }
                                                        
                                                            
                                                            foreach ($query_tm as $row) {  
                                                                if ($row['trabajador']!=$_GET['trabajador']) { ?>
                                                                    <tr>
                                                                        <td><label class="col-form-label"><?php echo $row['nombre1'].' '.$row['apellido1'] ?></label></td>
                                                                        <td><label class="col-form-label"><?php echo $row['rut'] ?></label></td>
                                                                        <td style="text-align:center" >
                                                                                <input class="estilo" id="trabajadores<?php echo $i ?>" name="trabajadores[]" type="checkbox" value="<?php echo $row['idtrabajador'] ?>" /> 
                                                                        </td>
                                                                    </tr>
                                                            <?php } else { ?>    
                                                                        <input style="display:none" class="estilo" id="trabajadores<?php echo $i ?>" name="trabajadores[]" type="checkbox" checked="" value="<?php echo $_GET['trabajador'] ?>" />     
                                                            <?php }  ?>     
                                                                <?php $i++; 
                                                            }
                                                            $total=$i+1; ?>
                                                        </tbody>
                                                    </table>
                                                </div>   
                                            </div>  
                                    <?php } else {                        
                                            $i=1; ?>
                                            <input style="display:none" class="estilo" id="trabajadores0" name="trabajadores[]" type="checkbox" checked="" value="<?php echo $_GET['trabajador'] ?>" />            
                                    <?php  }  ?>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
                                    <button class="btn btn-success btn-sm" type="button" onclick="cargar_doc_extra(<?php echo $_GET['contrato'] ?>,<?php echo $i ?>,<?php echo $_GET['mandante'] ?>,<?php echo $_GET['tipo'] ?>)" >Envuar documento</button>  
                                </div>

                        <?php } 
                        
                        
                                            
                                            
                                                

