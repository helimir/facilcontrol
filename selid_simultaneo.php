<?php
include('config/config.php');

$query_t=mysqli_query($con,"select m.mes as mes_dm, t.*, d.documento, a.razon_social, c.nombre_contrato from trabajador as t INNER JOIN mensuales_trabajador as m ON m.trabajador=t.idtrabajador left join doc_mensuales as d On d.id_dm=m.doc left join mandantes as a On a.id_mandante=m.mandante left join contratos as c On c.id_contrato=m.contrato WHERE m.trabajador='".$_GET['trabajador']."' and m.doc='".$_GET['doc']."' and m.mes='".$_GET['mes']."' and m.verificado='0' ");
$result_t=mysqli_fetch_array($query_t);

switch ($result_t['mes_dm']) { 
    case '01':$mes='Enero';break;
    case '02':$mes='Febrero';break;
    case '03':$mes='Marzo';break;
    case '04':$mes='Abril';break;
    case '05':$mes='Mayo';break;
    case '06':$mes='Junio';break;
    case '07':$mes='Julio';break;
    case '08':$mes='Agosto';break;                                            
    case '09':$mes='Septiembre';break;
    case '10':$mes='Octubre';break;
    case '11':$mes='Noviembre';break; 
    case '12':$mes='Diciembre';break;
  }  

?>
                                    
                                      <div class="modal-body">
                                            <form  method="" name="f1" id="frmSimultaneo" enctype="multipart/form-data">        
                                                <div class="row">
                                                  <div  style="font-weight:bold" class="col-2">
                                                     <labe class="form-label">Trabajador:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre1'].' '.$result_t['apellido1'].' ('.$result_t['rut'].')' ?></label>
                                                  </div> 
                                                </div>
                                                <div class="row">
                                                    <div class="col-2">
                                                         <label style="font-weight:bold" class="form-label">Contrato:</label>
                                                    </div>   
                                                    <div class="col-6">
                                                         <label style="" class="form-label" id="trabajador"><?php echo $result_t['nombre_contrato'] ?></label>
                                                    </div> 
                                                </div>
                                                <div class="row">
                                                  <div class="col-2">
                                                     <label style="font-weight:bold" class="form-label">Doc.:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label style="" class="form-label" id="nom_doc"><?php echo $result_t['documento'] ?></label>
                                                  </div> 
                                                </div>
                                                <div class="row">
                                                  <div class="col-2">
                                                     <label style="font-weight:bold" class="form-label">Mandante:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label class="form-label" id="nom_doc"><?php echo $result_t['razon_social'] ?></label>
                                                  </div> 
                                                </div>
                                                <div class="row">
                                                  <div class="col-2">
                                                     <label style="font-weight:bold" class="form-label">Mes:</label>
                                                  </div>   
                                                  <div class="col-6">
                                                     <label class="form-label" id="nom_doc"><?php echo $mes ?></label>
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

                                               
                                            <?php if ($_GET['enviado']!='2') { ?> 
                                                        <div class="row" style="margin-top: 5%;" >
                                                            <div style="text-align:center"  class="col-12">
                                                                <label class="label form-label label-warning text-dark">Puede agregar el archivo a otros trabajadores del contrato</label>
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
                                                                        $i=0; 
                                                                        $query_tm=mysqli_query($con,"select a.*, t.* from mensuales_trabajador as a left join trabajador as t On t.idtrabajador=a.trabajador where  a.contrato='".$_GET['contrato']."' and a.doc='".$_GET['doc']."' and a.mes='".$_GET['mes']."' and a.verificado='0' ");
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

                                                                        <?php $i++; }
                                                                        $total=$i+1; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>   
                                                        </div>   
                                            <?php } else {                        
                                                        $i=1; ?>
                                                        <input style="display:none" class="estilo" id="trabajadores0" name="trabajadores[]" type="checkbox" checked="" value="<?php echo $_GET['trabajador'] ?>" />                 
                                            <?php  }  ?>
                                                
                                            </form>  
                                            
                                            
                                        </div>

                                        <div class="modal-footer">
                                            
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"  ><span aria-hidden="true">Cerrar</span></button>
                                            <button class="btn btn-success btn-sm" type="button" onclick="cargar_simultaneo(<?php echo $_GET['contrato'] ?>,<?php echo $i ?>,<?php echo $_GET['doc'] ?>,'<?php echo $_GET['mes'] ?>')" >Cargar Documentos</button>  
                                                    
                                        </div>

