<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$contratista=$_GET['contratista'];
$mandante=$_GET['mandante'];
$condicion=$_GET['condicion'];     


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
                                                            <?php $i=0; 
                                                            $query=mysqli_query($con,"select * from doc_mensuales "); 
                                                            foreach ($query as $row) {    
                                                                $query_doc=mysqli_query($con,"select documentos from mensuales where contratista='$contratista'  ");
                                                                ?>
                                                            <tr>
                                                                <td><?php echo $i+1 ?></td> 
                                                                <td><label class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                                    
                                                                    <td><div class="i-checks"> <input id="doc_mensuales<?php echo $i ?>" name="doc_mensuales[]" type="checkbox" value="<?php echo $row['id_dm'] ?>" /> </div></td>
                                                                    
                                                             </tr>
                                                            <?php $i++; } ?>
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
                                            
                                              function crear_perfil_mensual(){
                                                    //alert('hola1');       
                                                    const doc_m = document.querySelectorAll(".i-checks input[type=checkbox]:checked"); 
                                                    if(doc_m.length <= 0){
                                                        swal({
                                                            title: "Lista Vacia",
                                                            text: "Debe seleccionar al menos un documento",
                                                            type: "warning"
                                                        });   
                                                    } else { 
                                                         var habilitar=document.getElementById('mensual');
                                                         if(habilitar.checked) {
                                                            var chequeado=1;
                                                            //alert('chequeado');
                                                         } else {
                                                            var chequeado=0;
                                                            //alert('no chequeado');
                                                        }
                                                        
                                                         var valores=$('#frmMensual').serialize();
                                                              $.ajax({
                                                        			method: "POST",
                                                                    url: "add/addmensual.php",
                                                                    data: valores,
                                                        			success: function(data){			  
                                                                     if (data==0) {                        
                                                                         swal({
                                                                                title: "Perfil Mensual Creado",
                                                                                //text: "You clicked the button!",
                                                                                type: "success"
                                                                         });
                                                                         setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);
                                                        			  }
                                                                      if (data==2) {                        
                                                                         swal({
                                                                                title: "Perfil Mensual Deshabilitado",
                                                                                //text: "You clicked the button!",
                                                                                type: "success"
                                                                         });
                                                                         setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);
                                                        			  } 
                                                                      if (data==3) {                        
                                                                         swal({
                                                                                title: "Perfil Mensual Habilitado",
                                                                                //text: "You clicked the button!",
                                                                                type: "success"
                                                                         });
                                                                         setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);
                                                        			  }                                                                      
                                                                                                                                            
                                                                      if (data==1) { 
                                                                            swal("Error de Sistema", "Perfil No Creado. Vuelva a Intentar.", "error");                            
                                                        			  }
                                                        			}                
                                                                });                                             
                                                
                                                    }
                                                }   
                                                 
                                                
                                              $(document).ready(function() {
    
                                                    $('.i-checks').iCheck({
                                                            checkboxClass: 'icheckbox_square-green',
                                                            radioClass: 'iradio_square-green',
                                                    });  
                                              });      
                                            
 
                                            </script>
 

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
