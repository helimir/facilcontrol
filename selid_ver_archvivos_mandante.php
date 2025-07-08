<?php
session_start();
if (isset($_SESSION['usuario'])) {
    
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$id=$_GET['id'];
$idcargo=$_GET['cargo'];
$contrato=$_GET['contrato'];
$mandante=$_GET['mandante'];
$perfil=$_GET['perfil'];

$query_trabajador=mysqli_query($con,"select rut from trabajador where idtrabajador='$id' ");
$result_trabajador=mysqli_fetch_array($query_trabajador);
$rut=$result_trabajador['rut'];

$query_perfil_cargo=mysqli_query($con,"select * from perfiles_cargos where contrato='$contrato' ");
$result_perfil_cargo=mysqli_fetch_array($query_perfil_cargo);

$cargos=unserialize($result_perfil_cargo['cargos']);
$perfiles=unserialize($result_perfil_cargo['perfiles']);

$contador=0;
foreach ($cargos as $row) {    
    if ($row==$idcargo) {
            $posicion_cargo=$contador;
            break;
        }    
    $contador++;
}

$contador=0;
foreach ($perfiles as $row) {    
    if ($contador==$posicion_cargo) {
            //$perfil=$row;
            break;
        }    
    $contador++;
}


$query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
$result_doc=mysqli_fetch_array($query_doc); 

$documentos=unserialize($result_doc['doc']);

?>  

<head>
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
   
   <script src="js\jquery-3.1.1.min.js"></script> 
   
   
   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 20px;
        	height: 20px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 20px;
        	height: 20px;
        	margin: 0.5em 0.5em 0 0;
        }
    
    </style>
   
</head>
   
    
     <div class="modal-body">
    
      <div class="row">
            
            <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
            <table class="table table-stripped" data-page-size="15" data-filter="#filter">
            
               <thead>
                <tr>
                    <th style="width: 2%;" >Cargado</th>
                    <th style="width: 20%;">Documento</th>
                    <th style="width: 5%;text-align: center;">Verificado</th>
                    <th style="width: 30%;">Observaciones</th>
                    <th style="width: 5%;">Enviar</th>
                    
                </tr>
                </thead>
                
               <tbody>
                
                <?php          
                     $i=0; 
                     foreach ($documentos as $row) {                        
                        $sql=mysqli_query($con,"select * from doc where id_doc='$row' "); 
                        $result=mysqli_fetch_array($sql);  
                        
                        $sql2=mysqli_query($con,"select * from observaciones where trabajador='$id' and contrato='$contrato' and mandante='$mandante' and cargo='$idcargo' and documento='$row' ");
                        $result2=mysqli_fetch_array($sql2);   
                        
                        $carpeta='doc/trabajadores/'.$rut.'/'.$result['documento'].'_'.$rut.'.pdf';
                        $archivo_exitse=file_exists($carpeta);    
                        
                        echo '<tr>';                    
                         if ($archivo_exitse) {
                                echo '<td><i style="color: #000080;font-size: 20px;" class="fa fa-plus-square" aria-hidden="true"></i></td>';
                                echo '<td style=""><a href="'.$carpeta.'" target="_blank">'.$result['documento'].'</a></td>';
                                if ($result2['estado']==0) {
                                    echo '<td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar_doc[]" value="1" id="verificar_doc'.$i.'" onclick="" value="-1" /></td>';
                                    echo '<td><textarea rows="1" name="mensaje" id="mensaje'.$i.'" class="form-control">'.$result2['observacion'].'</textarea></td>';
                                    echo '<td><button class="btn btn-sm btn-success" type="button" onclick="enviar('.$id.','.$contrato.','.$mandante.','.$idcargo.','.$row.','.$i.')" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button></td>';
                                } else {
                                    echo '<td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar_doc[]" value="0" id="verificar_doc'.$i.'"  checked="" value="0" /></td>';
                                    echo '<td><textarea rows="1" name="mensaje" id="mensaje'.$i.'" class="form-control">'.$result2['observacion'].'</textarea></td>';
                                    echo '<td><button class="btn btn-sm btn-success" type="button" onclick="enviar('.$id.','.$contrato.','.$mandante.','.$idcargo.','.$row.','.$i.')" ><i class="fa fa-paper-plane" aria-hidden="true" ></i></button></td>';
                                }    
                                
                         } else {
                                echo '<td><i style="color: #FF0000;font-size: 20px;" class="fa fa-minus-square" aria-hidden="true"></i></td>';
                                echo '<td style="">'.$result['documento'].'</td>';
                                echo '<td style="text-align: center;"><input class="estilo" type="checkbox" name="" disabled="" /></td>';
                                echo '<td><textarea rows="1" name="mensaje" id="mensaje'.$i.'" class="form-control">'.$result2['observacion'].'</textarea></td>';
                                echo '<td><button class="btn btn-sm btn-success" type="button" onclick="enviar('.$id.','.$contrato.','.$mandante.','.$idcargo.','.$row.','.$i.')" ><i class="fa fa-paper-plane" aria-hidden="true" ></i></button></td>';
                         }   
                       echo '</tr>';  
                  $i++;} ?>
                
              </tbody>
           </table>
      </div>     
   </div>


    <!-- Mainly scripts -->
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

<script>

    $(document).ready(function() {
            $('.footable').footable();
            $('.footable2').footable();
    });

    function enviar(trabajador,contrato,mandante,cargo,doc,item) {
        var mensaje=$('#mensaje'+item).val();
        var isChecked =$('#verificar_doc'+item).prop('checked');
        if (isChecked){
            var estado=1;
        } else {
            var estado=0;   
        }
        $.ajax({    
            method: "POST",
            url: "add/enviar_observacion.php",
 			data:'contrato='+contrato+'&mensaje='+mensaje+'&trabajador='+trabajador+'&contrato='+contrato+'&mandante='+mandante+'&cargo='+cargo+'&doc='+doc+'&estado='+estado,
 			success: function(data){
                if (data==0) {
                    swal({
                        title: "Observacion Enviada",
                        type: "success"
                    });
                } 
                if (data==1) {
                    swal("No Enviado", "Vuelva a intentar", "error");
                }
                if (data==2) {
                    swal({
                        title: "Observacion Actualizada",
                        type: "warning"
                    });
                }
                if (data==3) {
                    swal("No Actualizado", "Vuelva a intentar", "error");
                }
 			}
        });
        
        
    }
    
    function verificar(id,contrato,mandante,cargo,doc,item) {
      var estado=$('#verificar_doc'+item).val();  
      swal({
            title: "Confirma verificacion de documento?",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Confirmar!",
            cancelButtonText: "No, Confirmar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
                if (isConfirm) {                
                    $.ajax({
            			method: "POST",
                        url: "add/verificar_doc.php",
            			data:'id='+id+'&contrato='+contrato+'&mandante='+mandante+'&cargo='+cargo+'&doc='+doc,
            			success: function(data){
                         if (data==0) {
                           swal({
                                title: "Documento Verificado",
                                type: "success"
                            });
                         } else {
                            swal("Cancelado", "Confirmacion Cancelada", "error");
                         }
            			}
                   });
                } else {
                    swal("Cancelado", "Confirmacion Cancelada", "error");
                    $("#verificar_doc"+item).prop("checked", false);
                }
        });   
      
    } 
    
    function prueba() {
        alert('hola');
    }
  

</script>

<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
} ?>       
        