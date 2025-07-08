<?php 
session_start();
if (isset($_SESSION['usuario'])) { 
include('config/config.php');

$query=mysqli_query($con,"select c.* from cuadrillas as c where c.id_cuadrilla='".$_GET['cuadrilla']."' ");
$result=mysqli_fetch_array($query);
$trabajadores=unserialize($result['trabajadores']);
$cantidad=$result['cantidad'];
$lider=$result['lider'];
?>

<link href="css\plugins\footable\footable.core.css" rel="stylesheet"/>


                    
                    
                    <div class="modal-body">                                             
                                <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una trabajador"> 
                                <div class="table-responsive">
                                <table style="width:100%;overflow-x: auto;font-size:12px" class="table footable table-hover" data-page-size="8" data-filter="#filter"> 
                                        <tbody>
                                        <?php 
                                            $i=0;                                               
                                            for ($i=0;$i<=$cantidad-1;$i++) { 
                                                $query_trabajador=mysqli_query($con,"select * from trabajador where idtrabajador='".$trabajadores[$i]."' ");
                                                $result_trabajador=mysqli_fetch_array($query_trabajador);

                                                $trabajador=$result_trabajador['nombre1'].' '.$result_trabajador['apellido1'];
                                                $rut=$result_trabajador['rut'];    
                                            ?>                                                
                                                <tr style="font-size:14px">    
                                                    <?php if ($lider==$trabajadores[$i]) { ?>                                                
                                                        <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $trabajador ?> <small><span style="border-radius:5px;color:#282828;font-weight:bold" class="bg bg-warning">&nbsp;&nbsp;LIDER&nbsp;&nbsp;</span></small> </label></td>                                                        
                                                    <?php } else { ?>                                                
                                                        <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $trabajador ?></label></td>
                                                    <?php } ?>                                                

                                                    <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $rut ?></label></td>                                                                                                            
                                                </tr>
                                                       
                                                <?php 
                                            } 
                                        ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <ul class="pagination float-right"></ul>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    
                                    

                                    </table>
                                </div>                               
                        
                    </div>  
                    
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                    </div>          
                    
                    
 <!-- FooTable -->

 
<!-- FooTable -->
<script src="js\plugins\footable\footable.all.min.js"></script>


 
<?php } else { 

echo "<script> window.location.href='../admin.php'; </script>";
}