<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    
   
    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='".$_GET['id']."' ");
    $result_t=mysqli_fetch_array($query_t);

    $query_c=mysqli_query($con,"select * from contratos where id_contrato='".$_GET['contrato']."' ");
    $result_c=mysqli_fetch_array($query_c);

?>    
    
        <form  method="post" name="frmDesvincular" id="frmDesvincular" enctype="multipart/form-data" >    
          <div class="modal-body"> 
                  <div class="form-group row">
                          <div class="col-sm-3">
                            <label><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajador:</label>
                          </div>  
                          <div class="col-sm-9">
                            <label> <strong><?php echo $result_t['nombre1'].' '.$result_t['apellido1'] ?></strong>  </label>
                          </div>

                          <div class="col-sm-3">
                            <label><i class="fa fa-chevron-right" aria-hidden="true"></i> Contrato:</label>
                          </div>  
                          <div class="col-sm-9">
                            <label> <strong><?php echo $result_c['nombre_contrato'] ?></strong>  </label>
                          </div>
                  </div>

                  <div class="hr-line-dashed"></div>
                  
                  <div class="row">                                                  
                      <div class="form-group col-12">
                          
                          <div class="i-checks"> <input name="tipo_desvincular" id="tipo_desvincular" type="radio" value="1"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contratista</span> </div> 
                          <br />
                          <div class="i-checks"> <input name="tipo_desvincular" id="tipo_desvincular" type="radio" value="2"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contrato</span> </div>
                      </div>   
                  </div>
                                                        
                  <div class="row">                                                  
                      <div class="form-group col-12">
                          <div style="width: 100%;display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                              <span  style="background:#282828; color: #fff;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                  <span  class="fileinput-exists">Cambiar</span>
                                  <input class="form-control" type="file" id="archivo_desvincular" name="archivo_desvincular" accept="application/pdf"  />
                              </span>
                              <span class="fileinput-filename"></span>                                                             
                              <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                          </div>
                        </div>   
                  </div>                                                                                                                                                  
            </div>                      
            <div style="text-align: left;" class="modal-footer">
                <button class="btn btn-secondary btn-md" title="Cerrar Ventana" class="close" data-dismiss="modal" aria-label="Close"  >Cancelar </button>
                <button class="btn btn-success btn-md" type="button" onclick="cargar_desvincular()" >Enviar Desvinculacion</button>  
                
            </div> 

            <input type="hidden" name="trabajador" id="trabajador_desvincular" value="<?php echo $_GET['id'] ?>" />
            <input type="hidden" name="contrato" id="contrato_desvincular" value="<?php echo $_GET['contrato'] ?>" /> 
            <input type="hidden" name="rut" id="rut_desvincular" value="<?php echo $result_t['rut'] ?>" />
            <input type="hidden" name="mandante" id="madante_desvincular" value="<?php echo $_GET['mandante'] ?>" />
        </form>

<script>
    $(document).ready(function() {
      $('.i-checks').iCheck({ 
              checkboxClass: 'icheckbox_square-green',
              radioClass: 'iradio_square-green',
      });
    });  
</script>