                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select o.contratista as contratista_s, t.idtrabajador, m.acreditada, t.nombre1,t.apellido1, c.cargo as cargo_t, o.nombre_contrato, ta.*  from trabajadores_acreditados as ta Left Join trabajador as t On t.idtrabajador=ta.trabajador Left Join cargos as c On c.idcargo=ta.cargo Left Join contratos as o On o.id_contrato=ta.contrato Left Join contratistas_mandantes as m On m.contratista=ta.contratista where m.acreditada=1 AND ta.contrato='".$_GET['contrato']."' group by ta.trabajador  ");
                    $result=mysqli_fetch_array($query);
                    $existen=mysqli_num_rows($query);
                    $contratista=$result['contratista_s'];
                    
                    $query_c=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$_GET['contrato']."' ");
                    $result_c=mysqli_fetch_array($query_c);

                    ?>        
                    <form method="post" id="frmContratos">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        
                                            <tr>
                                                <td colspan="2">Contrato: <strong><?php echo $result_c['nombre_contrato'] ?></strong></td>
                                            </tr>

                                        <?php 
                                            $i=0; 
                                            $accion=FALSE;
                                            if ($existen>0) {
                                                foreach ($query as $row) {
                                        ?>
                                                     <tr>
                                                         <td style="width: 2%;"><div class=""> <input class="form-control" id="trabajadores_de<?php echo $i ?>" name="trabajadores_de[]" type="checkbox" value="<?php echo $row['idtrabajador'] ?>" /> </div></td>
                                                         <td class="text-rigth" style="width: 20%;"><label style="font-weight:bold" class="col-form-label"><?php echo $row['nombre1'].' '.$row['apellido1'] ?></label> (<span style="color: #010829;font-weight: ;" ><?php echo $row['cargo_t'] ?> </span>) </td>
                                                     </tr>
                                       <?php
                                                $i++; 
                                                } 
                                           } else {
                                        ?>
                                                <tr>
                                                    <td colspan="2" >Sin trabajadores acreditados</td>
                                                </tr>   

                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>
                        
                    </div>
                    <input type="hidden" id="cant_trabajadores" value="<?php echo $i ?>" />
                    <input type="hidden" id="tipo_doc" value="3" />   
                    <div class="modal-footer">
                        <!--label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para cargos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>-->
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                        
                        <?php if  ($result['acreditada']==1) { ?>
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratos_p(<?php echo $i ?>,<?php echo $_GET['contrato'] ?>,<?php echo $contratista ?>)">Crear Documento</button>
                        <?php } else { ?>
                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_contratos_p()" disabled="">Crear Documento</button>
                        <?php } ?>    

                    </div>
                    </form>    
                    <script>
                        function asignar_contratos_p(cantidad,contrato,contratista) {

                            var arreglo_trabajadores=[];  
                            var mandante=$('#mandante').val();
                            var nombre_doc=$('#nombre_doc').val();
                            var tipo_doc=3;
                            var cantidad_r=0;  
                            var i=0;
                            var chequeado=false;  
                            for (i=0;i<=cantidad-1;i++) {
                                if ( $('#trabajadores_de'+i).is(':checked') ) {
                                    var chequeado=true;
                                    var valor_trabajador=$('#trabajadores_de'+i).val();
                                    arreglo_trabajadores.push(valor_trabajador);
                                    cantidad_r++; 
                                } 
                            } 
                             
                            if ( chequeado==true) {

                                var trabajadores=JSON.stringify(arreglo_trabajadores);
                                
                                var formData = new FormData();
                                formData.append('trabajadores',trabajadores);
                                formData.append('nombre_doc', nombre_doc );
                                formData.append('mandante', mandante );
                                formData.append('cantidad_r', cantidad_r );
                                formData.append('tipo', tipo_doc );
                                formData.append('contrato_r', contrato );
                                formData.append('contratista', contratista );

                                //alert();

                                $.ajax({ 
                                    url: 'add/adddoc_extra.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function(){
                                        $('#modal_cargar').modal('show');						
                                    },
                                    success: function(data){
                                        if (data==0) {
                                            swal({
                                                title: "Documento Creado",
                                                type: "success"
                                            });
                                            window.location.href='gestion_doc_extradordinarios_mandante_trabajador.php';
                                                                                    
                                        } else {
                                            swal({
                                                title: "Documento No Creado",
                                                type: "erroe"
                                            });	  
                                        };
                                    },
                                    complete:function(data){
                                        $('#modal_cargar').modal('hide');
                                    }, 
                                    error: function(data){
                                    }
                                }); 

                            } else {
                                swal({
                                    title: "Debe seleccionar al menos una Trabajador",
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