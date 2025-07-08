                    <?php

                    session_start();
                    include('config/config.php');
                    setlocale(LC_MONETARY,"es_CL");
                    setlocale(LC_ALL,"es_CL");
                    
                    $minimo_acreditaciones=3;

                    $query=mysqli_query($con,"select * from acreditaciones ");

                    $query_c=mysqli_query($con,"select c.*, p.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista where c.rut='".$_GET['rut']."' ");
                    $result_c=mysqli_fetch_array($query_c);

                    $query_a=mysqli_query($con,"select * from trabajadores_acreditados where contratista='".$result_c['id_contratista']."' and estado=0 ");
                    $num_acreditaciones=mysqli_num_rows($query_a);
                    #$num_acreditaciones=27;

                    $query_p=mysqli_query($con,"select * from acreditaciones ");

                    if ($num_acreditaciones>$minimo_acreditaciones) {
                        foreach ($query_p as $row) {
                            if ($num_acreditaciones>$minimo_acreditaciones and $num_acreditaciones<$row['acreditaciones']) {
                                $id_plan=$row['id_a'];
                                $plan=$row['plan'];
                                $pago=$row['costo'];
                                $acreditaciones=$row['acreditaciones'];
                                break;
                            }
                        }
                    } else {
                        $id_plan=1;
                        $plan="PLAN FREE";
                        $pago=0;
                        $acreditaciones=5;

                    }

                    ?>  

                    <div class="modal-body"> 
                          
                            <div style="overflow-y: auto;font-size:14px" class="row">
                               
                                

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Contratista: <strong><?php echo $result_c['razon_social'].' ['.$result_c['rut'].']' ?></strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha inicio: <strong><?php echo $result_c['fecha_inicio_plan'] ?></strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha culminaci&oacute;n: <strong><?php echo $result_c['fecha_fin_plan'] ?></strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Numero de Acreditaciones: <strong><?php echo $num_acreditaciones ?></strong></label><br>
                                   <hr>
                                </div>
                                                                
                                <div style="margin-top: -20px" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
                                    <label><strong>Informaci&oacute;n del Plan que aplica:</strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Plan: <strong><?php echo $plan ?></strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Acreditaciones: <strong><?php echo $acreditaciones ?></strong></label><br>
                                   <label><i class="fa fa-angle-right" aria-hidden="true"></i> Pago: <strong><?php echo money_format('%.0n',$pago) ?> mensual.</strong></label>
                                </div>
                                


                                <!--<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                    
                                        <table class="table" >
                                            
                                            <thead>
                                                <tr style="background: #333399; color:#fff">
                                                    <th style="text-align: ;">Plan</th>
                                                    <th style="text-align: center;">Acreditaciones</th>
                                                    <th style="text-align: center;">Mensualidad</th>
                                                    <th style="text-align: center;">Seleccionar</th>
                                                    
                                                </tr>
                                            </thead>
                                        
                                            <tbody>
                                            <?php 
                                                $i=0;
                                                foreach ($query as $row) {

                                                   #$query_d=mysqli_query($con,"select * from contratistas_mandantes where contratista='".$_GET['id']."' and mandante='".$_SESSION['mandante']."' and plan='".$row['id_a']."' ");
                                                   #$result_d=mysqli_fetch_array($query_d);
                                            ?>
                                                    <tr>
                                                        <td style="color:#333399;font-weight: bold "><?php echo $row['plan'] ?></td>
                                                        <td style="text-align: center"><?php echo $row['acreditaciones'] ?></td>
                                                        <td style="text-align: center"><?php echo money_format('%.0n',$row['costo']) ?></td>
                                                        
                                                        <?php if ($num_acreditaciones>3 and $num_acreditaciones<$row['acreditaciones']) { ?>
                                                            <td class="text-center" style="width: "><input  class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>
                                                        <?php } else { ?>    
                                                            <td class="text-center" style="width: "><input disabled=""  class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>        
                                                        <?php }  ?>        

                                                    </tr>
                                        <?php
                                                    $i++; 
                                                } 
                                            
                                            ?>
                                            </tbody>
                                        </table>
                                </div> -->                   
                        </div>
                        
                    </div>
              
                    <div style="margin-top: -20px" class="modal-footer">
                        <a style="color: #fff;" class="btn btn-danger btn-sm" data-dismiss="modal" >Cancelar</a>
                        <?php if ($id_plan==1) { ?>
                            <button style="color: #fff;" class="btn btn-primary btn-sm" type="button" name="asignar" onclick="plan(<?php echo $result_c['id_contratista'] ?>,<?php echo $id_plan ?>)">Continuar PLAN FREE</button> |
                        <?php }  ?>
                        <button style="color: #fff;" class="btn btn-success btn-sm" type="button" name="asignar" onclick="plan(<?php echo $result_c['id_contratista'] ?>,<?php echo $id_plan ?>)">Actualizar Plan</button>
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

                            function plan(id,plan) {
                                //var plan=document.querySelector('input[name="plan"]:checked').value;
                                //alert(id+' '+plan);
                                if (plan!=1) { 
                                    $.ajax({
                                        method: "POST",
                                        url: "flow/flow.php",
                                        data: 'id='+id+'&plan='+plan,
                                        success: function(data){			  
                                            if (data!=1) {
                                                window.open(data, '_blank');
                                            } else {
                                                swal("Error de Sistema", "Vuelva a Intentar.", "error");
                                                setTimeout(window.location.href='admin.php', 3000);
                                            }
                                        }                
                                    });
                                } else {
                                    $.ajax({
                                        method: "POST",
                                        url: "add/continuar_plan_free.php",
                                        data: 'id='+id+'&plan='+plan,
                                        success: function(data){			  
                                            if (data==1) {
                                                window.location.href="https://facilcontrol.cl/list_contratos_contratistas.php";
                                            } else {
                                                swal("Error de Sistema", "Vuelva a Intentar.", "error");
                                            }
                                        }                
                                    });    

                                }
                            }     
                            
                            function planxxx(id) {
                                var plan=document.querySelector('input[name="plan"]:checked').value;
                                //alert(plan);
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



                      
                    