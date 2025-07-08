                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select *  from contratos where id_contrato='".$_GET['contrato']."' ");
                    $result=mysqli_fetch_array($query);
                    $cargos=unserialize($result['cargos']);
                    $contratista=$result['contratista'];
                    
                    ?>        
                    <form method="post" id="frmCargos">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        
                                            <tr>
                                                <td colspan="2">Contrato: <strong><?php echo $result['nombre_contrato'] ?></strong></td>
                                            </tr>

                                        <?php 
                                            $i=0; 
                                            $accion=FALSE;
                                            foreach ($cargos as $row) {
                                                $query_cargo=mysqli_query($con,"select * from cargos where idcargo='$row' ");
                                                $result_cargo=mysqli_fetch_array($query_cargo);
                                                $existe_cargos=mysqli_num_rows($query_cargo);
                                        ?>
                                                <tr>
                                                    <td style="width: 2%;"><div class=""> <input  class="form-control" id="cargos_de<?php echo $i ?>" name="cargos_de[]" type="checkbox" value="<?php echo $row ?>" /> </div></td>
                                                    <td class="text-rigth" style="width: 20%;"><label style="font-weight:bold" class="col-form-label"><?php echo $result_cargo['cargo'] ?></label> </td>
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
                  
                    <input type="hidden" id="cant_trabajadores" value="<?php echo $i ?>" />
                    <input type="hidden" id="tipo_doc" value="4" />   
                    <div class="modal-footer">
                        <!--label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para cargos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>-->
                        <a style="color: #fff;" class="btn btn-danger btn-md" data-dismiss="modal" >Cerrar</a>
                        
                       
                        <?php if ($existe_cargos>0) { ?>
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratos_c(<?php echo $i ?>,<?php echo $_GET['contrato'] ?>,<?php echo $contratista ?>)" disabled="">Crear Documento</button>
                        <?php } else { ?>
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratos_p()" disabled="">Crear Documento</button>
                        <?php } ?> 

                    </div>
                    </form>    
                    <script>
                        function asignar_contratos_c(cantidad,contrato,contratista) {
                            //alert(cantidad+' '+contrato+' '+contratista);    
                            
                            var arreglo_cargos=[];  
                            var mandante=$('#mandante').val();
                            var nombre_doc=$('#nombre_doc').val();
                            var tipo_doc=4;
                            var cantidad_a=0;  
                            var i=0;
                            var chequeado=false;  
                            for (i=0;i<=cantidad-1;i++) {
                                if ( $('#cargos_de'+i).is(':checked') ) {
                                    var chequeado=true;
                                    var valor_cargo=$('#cargos_de'+i).val();
                                    arreglo_cargos.push(valor_cargo);
                                    cantidad_a++; 
                                } 
                            }  

                            if ( chequeado==true) {

                                var cargos=JSON.stringify(arreglo_cargos);
                                
                                var formData = new FormData();
                                formData.append('cargos',cargos);
                                formData.append('nombre_doc', nombre_doc );
                                formData.append('mandante', mandante );
                                formData.append('cantidad_a', cantidad_a );
                                formData.append('tipo', tipo_doc );
                                formData.append('contrato', contrato );
                                formData.append('contratista', contratista );

                                alert(cantidad+' '+contrato+' '+contratista);

                                 

                            } else {
                                swal({
                                    title: "Debe seleccionar al menos un Cargo",
                                    type: "warning"
                                });   
                            }     

                         //var valores=$('#frmContratos').serialize();
                         //alert(valores);
                         // $.ajax({
                    	 //		method: "POST",
                         //       url: "sesion/session_contratos_de.php",
                         //       data: valores,
                    	 //		success: function(data){
                    	 //		     $('#modal_contratos').modal('hide') 
                    	 // 		}                
                         //   });
                        }
                    </script>     