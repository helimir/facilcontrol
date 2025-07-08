<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

    


?>
                                       <div class="modal-body"> 

                                            <form  method="post" id="frmMensual">    
                                               <div class="modal-body">
                                                <div class="row">
                                                  <div class="text-right col-12">
                                                    <button class="btn btn-success btn-xs" type="button" onclick="crear_perfil_mensual()" ><i class="fa fa-upload"></i> Asignar Documentos</button>  
                                                    <button class="btn btn-danger btn-xs" title="Cerrar Ventana" data-dismiss="modal" ><i class="fa fa-window-close" ></i> </button>
                                                  </div>  
                                                </div>
                                                <hr />
                                                <div class="row" >
                                                    <table style="overflow-y: auto;" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="col-1" style="width: ;">#</th>
                                                                <th class="col-5" style="width: ;">Documento</th>
                                                                <th class="col-1 text-rigth" >Seleccionar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                           
                                                        </tbody>
                                                    </table>
                                                </div>                                                  
                                               </div>
                                               
                                                                                       
                                               <div class="modal-footer">      
                                                <button class="btn btn-success btn-xs" type="button" onclick="crear_perfil_mensual()" ><i class="fa fa-upload"></i> Asignar Documentos</button>  
                                                <button class="btn btn-danger btn-xs" title="Cerrar Ventana" data-dismiss="modal" ><i class="fa fa-window-close" ></i> </button>
                                               </div> 
                                               
                                               <input type="hidden" id="contratista" name="contratista" value="<?php echo $contratista ?>" />
                                               <input type="hidden" id="mandante" name="mandante" value="<?php echo $mandante ?>" />
                                               <input type="hidden" id="condicion" name="condicion" value="<?php echo $condicion ?>" />
                                                
                                            </form>
                                        </div>
                                        
                                            <script>
                                            
                                          
 

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

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
     <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
