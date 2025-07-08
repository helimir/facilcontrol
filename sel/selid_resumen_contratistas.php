<?php 
session_start();
if (isset($_SESSION['usuario'])) { 
include('../config/config.php');
?>
<!-- FooTable -->

<link href="..\css\plugins\footable\footable.core.css" rel="stylesheet" />

        <div class="modal-body">
                           <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una tarea pendiente..."> 
                           <div class="table-responsive">
                            <table style="width:100%;overflow-x: auto;font-size:12px" class="table footable table-hover" data-page-size="8" data-filter="#filter">                                
                                <tbody>
                                <?php 
                                

                                    if ($_SESSION['nivel']==3)  {
    
                                        $query_notificaciones=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 and tipo='".$_GET['opcion']."' order by n.idnoti desc    ");
                                        $result_notificaciones=mysqli_fetch_array($query_notificaciones);
                                    }
                                    
                                    if ($_SESSION['nivel']==2)  {
                                        
                                        $query_notificaciones=mysqli_query($con,"select n.*, m.razon_social as remitente,m.id_mandante from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='".$_GET['opcion']."'  order by n.idnoti desc  ");
                                        $result_notificaciones=mysqli_fetch_array($query_notificaciones);
                                    }
                                
                                
                                    foreach ($query_notificaciones as $row) { 
                                      
                                      if ($row['procesada']==0) { ?>
                                        <tr >
                                            <td style="width:15%">
                                                <a  style="background:#E957A5" class="btn btn-xs btn-danger block" target="_blank" onclick="atender(<?php echo $row['idnoti'] ?>,'<?php echo $row['url'] ?>',<?php echo $row['tipo'] ?>,'<?php echo $row['item'] ?>',<?php  echo $row['mandante'] ?>,<?php echo $row['contratista'] ?>,<?php echo $row['perfil'] ?>,<?php echo $row['cargo'] ?>,<?php echo $row['contrato'] ?>,<?php echo $row['trabajador'] ?>,'<?php echo $row['control'] ?>')"><b style="color: #fff;">ATENDER</b></a>
                                              
                                            </td>
                                            <td  >
                                                <?php echo $row['mensaje'] ?></p>
                                            </td>
                                        </tr>
                                        <!--<tr>
                                            <td></td>   
                                            <td></td>
                                        </tr>-->
                                <?php } 
                                   } ?>
                                </tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <ul class="pagination float-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                
                                <script>
                                    function atender(id,url,tipo,item,mandante,contratista,perfil,cargo,contrato,trabajador,control) {
                                       //alert(control);
                                        
                                        $.ajax({
                                			method: "POST",
                                            url: "../add/atender.php",
                                            data: 'id='+id+'&tipo='+tipo+'&mandante='+mandante+'&contratista='+contratista+'&item='+item+'&perfil='+perfil+'&cargo='+cargo+'&contrato='+contrato+'&trabajador='+trabajador+'&url='+url,
                                			success: function(data){			  
                                             if (data==1) {
                                                    window.location.href=url;
                                			  } else {
                                                 swal("Error", "Vuelva a Intentar.", "error");
                                                 setTimeout(window.location.href='notificaciones.php', 3000);
                                			  }
                                			}                
                                       });
                                        
                                    }

                                    $(document).ready(function(){                                        
                                                        
                                                        $('.footable').footable();
                                                        $('.footable2').footable();
                                            });
                                
                                </script>
                                
                            </table>
                            </div>
        </div>
 <!-- FooTable -->
 <script src="..\js\plugins\footable\footable.all.min.js"></script>

<?php } else { 

echo "<script> window.location.href='../admin.php'; </script>";
}



