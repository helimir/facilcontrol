<?php 
session_start();
if (isset($_SESSION['usuario'])) { 
include('config/config.php');

$query_trabajadores=mysqli_query($con,"select c.mandante,c.contratista,c.nombre_contrato, a.*, t.* from trabajadores_acreditados as a Left Join trabajador as t On t.idtrabajador=a.trabajador left join contratos as c On c.id_contrato=a.contrato where a.estado!='3' and a.contrato='".$_GET['contrato']."' ");
$result=mysqli_fetch_array($query_trabajadores);
?>

<link href="css\plugins\footable\footable.core.css" rel="stylesheet"/>


                    
                    
                    <div class="modal-body">                                             
                                <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una trabajador"> 
                                <div class="table-responsive">
                                <table style="width:100%;overflow-x: auto;font-size:12px" class="table footable table-hover" data-page-size="8" data-filter="#filter"> 
                                        <tbody>
                                        <?php 
                                            $i=0;                                               
                                            foreach ($query_trabajadores as $row) { 
                                                $trabajador=$row['nombre1'].' '.$row['apellido1'];    
                                            ?>                                                
                                                <tr>
                                                    <td class="text-center" style="width: 20%;"><input onclick="seleccion(<?php echo $i ?>)" class="form-control" id="trabajadores_sel<?php echo $i ?>"  name="trabajadores_sel<?php echo $i ?>" type="checkbox" value="<?php echo $row['idtrabajador'] ?>" /></td>                                                   
                                                    <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $trabajador ?></label></td>                                                        
                                                    <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['rut'] ?></label></td>                                                        
                                                    <td class="text-center" style="width: 20%;"><input onclick="seleccion_lider(<?php echo $row['idtrabajador'] ?>)" class="form-control" id="lider<?php echo $i ?>"  name="lider" type="radio" value="<?php echo $row['idtrabajador'] ?>" /></td>                                                   
                                                </tr>
                                                       
                                                <?php
                                                $i++; 
                                            } 
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="4">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <input type="hidden" id="input_lider" name="input_lider" /> 
                                    <input type="hidden" id="mandante" name="mandante" value="<?php echo $result['mandante'] ?>" /> 
                                    <input type="hidden" id="contratista" name="contratista" value="<?php echo $result['contratista'] ?>" /> 
                                    <input type="hidden" id="contrato" name="contratista" value="<?php echo $_GET['contrato'] ?>" /> 
                                     
                                    <input type="hidden" id="nombre_contrato" name="nombre_contrato" value="<?php echo $result['nombre_contrato'] ?>" />

                                    

                                    </table>
                                </div>                               
                        
                    </div>  
                    
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                        <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="crear_cuadrilla(<?php echo $i ?>,<?php echo $_GET['contrato'] ?>)">Crear Cuadrilla</button>
                    </div>          
                    
                    
 <!-- FooTable -->

 
<!-- FooTable -->
<script src="js\plugins\footable\footable.all.min.js"></script>
<script>
                                        $(document).ready(function(){                                                                                                
                                            $('.footable').footable();
                                            $('.footable2').footable();
                                        }); 

                                        function seleccion(i) {
                                            var seleccion=$('#trabajadores_sel'+i).prop('checked');
                                            if (seleccion) {
                                                $('#trabajadores_sel'+i).removeAttr('checked','true');
                                            } else {
                                                $('#trabajadores_sel'+i).attr('checked','true');   
                                                
                                            }
                                        }

                                        function seleccion_lider(valor) {
                                            $('#input_lider').val(valor);
                                            
                                        }
  
                                        function crear_cuadrilla(cantidad,contrato) {
                                            const doc = document.querySelectorAll('input[type=checkbox]:checked'); 
                                            var cuadrilla_nombre=$('#input_cuadrilla').val();
                                            //alert(cuadrilla_nombre)
                                            if(doc.length <= 0){
                                                    swal({
                                                        title: "Lista Vacia",
                                                        text: "Debe seleccionar al menos un trabajador",
                                                        type: "warning"
                                                    });   
                                                
                                            } else {
                                                    var cantidad_t=0;
                                                    var arreglo_trabajadores=[];
                                                    var lider=false;
                                                    for (var i=0;i<=cantidad-1;i++) { 
                                                        //var isChecked=document.getElementById('trabajadores_sel'+i).value;
                                                        //var valor=document.getElementById('trabajadores_sel'+i).value;
                                                        //alert(isChecked)
                                                        //var trabajador_sel=document.getElementById('trabajadores_sel'+i);     
                                                        //$('#trabajadores_sel'+i).prop('input[type=checkbox]:checked');
                                                        //var trabajador_sel=$('#trabajadores_sel'+i).is('input[type=checkbox]:checked');                                                        

                                                        var trabajador_sel=$('#trabajadores_sel'+i).prop('checked');
                                                        var valor_lider=$('#input_lider').val();                                                                                                                
                                                        if (trabajador_sel==true) {
                                                            var valor_trabajador=$('#trabajadores_sel'+i).val();
                                                            arreglo_trabajadores.push(valor_trabajador);
                                                            cantidad_t++;                                                             
                                                            if (valor_trabajador==valor_lider) {
                                                                var lider=true;
                                                            }
                                                        } 
                                                        
                                                    }                                                     
                                                    
                                                    var trabajadores=JSON.stringify(arreglo_trabajadores);  

                                                    if (!lider) {
                                                        swal({
                                                            title: "Lider No Seleccionado",
                                                            //text: "Debe seleccionar al menos un trabajador",
                                                            type: "warning"
                                                        }); 
                                                    } else {
                                                        var contratista=$('#contratista').val();
                                                        var contrato=$('#contrato').val();
                                                        var mandante=$('#mandante').val();
                                                        var nombre_contrato=$('#nombre_contrato').val();
                                                        var cuadrilla_nombre=$('#input_cuadrilla').val();

                                                        var formData = new FormData();         
                                                        formData.append('trabajadores',trabajadores);
                                                        formData.append('contrato',contrato);
                                                        formData.append('contratista',contratista);
                                                        formData.append('mandante',mandante);
                                                        formData.append('lider',valor_lider);
                                                        formData.append('cuadrilla',cuadrilla_nombre);
                                                        formData.append('nombre_contrato',nombre_contrato);


                                                        $.ajax({
                                                            url: 'add/cuadrilla.php',
                                                            type: 'post',
                                                            data:formData,
                                                            contentType: false,
                                                            processData: false,
                                                            success: function(data) {
                                                                if (data==0) {                                          
                                                                    swal({
                                                                        title: "Cuadrilla Agregada",
                                                                        //text: "Dimensiones no validas",
                                                                        type: "success"
                                                                    });                                               
                                                                    window.location.href='crear_cuadrilla.php';
                                                                    
                                                                } else {  
                                                                    swal({
                                                                        title: "Error de Sistema",
                                                                        text: "Vuelva a intentar",
                                                                        type: "error"
                                                                    });    
                                                                } 
                                                            }
                                                        });  
                                                        //alert(trabajadores+' '+valor_lider+' '+contratista+' '+mandante+' '+contrato)
                                                    }
                                                    
                                                    
                                            }						
                                        }                           

                                    </script>

 
<?php } else { 

echo "<script> window.location.href='../admin.php'; </script>";
}