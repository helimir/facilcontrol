                    <?php

                    session_start();
                    include('config/config.php');
                    
                    $query=mysqli_query($con,"select * from acreditaciones ");

                    $query_c=mysqli_query($con,"select razon_social,rut from contratistas where id_contratista='".$_GET['id']."' ");
                    $result_c=mysqli_fetch_array($query_c);
                    
                    ?>        
                    
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="">
                                   <label>Contratista: <strong><?php echo $result_c['razon_social'].' ['.$result_c['rut'].']' ?></strong></label>
                                </div>
                            
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="">
                                    <div class="ibox-content">
                                        <table class="table" >
                                            
                                            <thead>
                                                <tr>
                                                    <th style="text-align: ;">Plan</th>
                                                    <th style="text-align: center;">Acreditaciones</th>
                                                    <th style="text-align: center;">Seleccionar</th>
                                                    
                                                </tr>
                                            </thead>
                                        
                                            <tbody>
                                            <?php 
                                                $i=0; 
                                                $accion=FALSE;
                                                foreach ($query as $row) {

                                                    $query_d=mysqli_query($con,"select * from contratistas_mandantes where contratista='".$_GET['id']."' and mandante='".$_SESSION['mandante']."' and plan='".$row['id_a']."' ");
                                                    $result_d=mysqli_fetch_array($query_d);
                                            ?>
                                                    <tr>
                                                        <td style="width: "><?php echo $row['plan'] ?></td>
                                                        <td style="text-align: center"><?php echo $row['acreditaciones'] ?></td>
                                                        
                                                        <?php if ($result_d!='') { ?>
                                                            <td class="text-center" style="width: "><input checked="" class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>
                                                        <?php } else { ?>    
                                                            <td class="text-center" style="width: "><input class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>        
                                                        <?php }  ?>        

                                                    </tr>
                                        <?php
                                                    $i++; 
                                                } 
                                            
                                            ?>
                                            </tbody>
                                        </table>
                                            </div>    
                                </div>                    
                            </div>
                        
                    </div>
              
                    <div class="modal-footer">
                        
                        <a style="color: #fff;" class="btn btn-danger btn-md" data-dismiss="modal" >Cancelar</a>
                        <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="plan(<?php echo $_GET['id'] ?>)">Actualizar Plan</button>
                     

                    </div>

                    <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Actualizado Plan, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>


                     <!-- iCheck -->
                    <script src="js\plugins\iCheck\icheck.min.js"></script>
                    <script>
                            $(document).ready(function () {
                                $('.i-checks').iCheck({
                                    checkboxClass: 'icheckbox_square-green',
                                    radioClass: 'iradio_square-green',
                                });
                            });

                            function plan(id) {
                                var plan=document.querySelector('input[name="plan"]:checked').value;
                                $.ajax({
                                    method: "POST",
                                    url: "add/plan_acreditaciones.php",
                                    data: 'id='+id+'&plan='+plan,
                                    beforeSend: function(){
                                        $('#modal_cargar').modal('show');						
                                    },
                                    success: function(data){
                                        if (data==0) {         
                                            swal({
                                                title: "Plan Actualizado",
                                                //text: "You clicked the button!",
                                                type: "success"
                                            });
                                            window.location.href='list_contratistas_mandantes.php';
                                        } 
                                        if (data==1) {
                                            swal({
                                                title: "Plan No Actualizado",
                                                text: "Vuelva a Intentar",
                                                type: "error"
                                            });
                                            
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
                      
                    