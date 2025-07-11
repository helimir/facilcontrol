<?php
/**
 * @author lolkittens
 * @copyright 2022
 */
session_start();
include('config/config.php');
$fecha_fin='';
$query=mysqli_query($con,"select a.plan as tipoplan,a.*, c.*, p.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista left join acreditaciones as a On a.id_a=p.plan where c.rut='".$_SESSION['usuario']."'");
$result=mysqli_fetch_array($query);

date_default_timezone_set('America/Santiago');
$fecha_actual = date("02-06-2023");
if (isset($result['fecha_fin_plan'])) {$fecha_fin=$result['fecha_fin_plan'];} 

$datetime1 = date_create($fecha_actual);
$datetime2 = date_create($fecha_fin);
$contador = date_diff($datetime2, $datetime1);
$differenceFormat = '%a';
$dias=($contador->format($differenceFormat));


if ($_SESSION['nivel']==2) {
    $sql_mandante=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and n.procesada=0  ");     
}
 if ($_SESSION['nivel']==3) {
    $sql_contratista=mysqli_query($con,"select * from notificaciones where recibe='".$_SESSION['contratista']."' and procesada=0  ");
    $num_noti=mysqli_num_rows($sql_contratista);
}

?>

<div style="background: #010829;" class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-success " href=""><i class="fa fa-th-large" aria-hidden="true"></i></a>
                  
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <?php if (isset($result['id_a'])==0 and $_SESSION['nivel']==3) { ?>
                        <!--<span class=""><b>FacilControl <a href="facil_pro.php"><span style="background:#F8AC59;color:#fff;font-size: 14px;padding: 1% 0% 1% 0%;">&nbsp;Prueba&nbsp;(<?php echo $dias;  ?> dias)&nbsp;</span> </b></span></a> -->
                        <?php if ($result['habilitada']!=2) { ?>
                            <!--<span class=""><b>FacilControl &nbsp;<span class="b-r-xl" style="background:#F8AC59;color:#fff;font-size: 14px;padding: 1% 0% 1% 0%;">&nbsp;Plan:&nbsp;Prueba&nbsp;(<?php echo $dias;  ?> dias)&nbsp;</b></span></a> -->
                            <span class=""><b>FacilControl &nbsp;&nbsp;</b></span></a>     
                        <?php } else { ?>    
                            <span class=""><b>FacilControl &nbsp;&nbsp;</b></span></a>     
                        <?php }  ?>    

                    <?php } else { ?> 
                        <span class=""><b>FacilControl&nbsp;&nbsp;</b></span>
                    <?php }  ?>    
                        
                </li>
                
                 <li class="dropdown">
                    <!--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"><?php echo $num_noti ?></span>
                    </a>-->
                    <!--<ul class="dropdown-menu dropdown-alerts">
                        <?php 
                           if ($_SESSION['nivel']==2) {
                               
                               foreach ($sql_mandante as $row) {  ?>    
                                <li>
                                    <a href="<?php echo $row['url'] ?>" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-chevron-right"></i> <?php echo $row['mensaje'] ?>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                        <?php  }
                         }   ?>
                         
                         <?php 
                           if ($_SESSION['nivel']==3) {
                              
                               foreach ($sql_contratista as $row) {  ?>    
                                <li>
                                    <a href="<?php echo $row['url'] ?>" class="dropdown-item">
                                        <div>
                                            <i class="fa fa-chevron-right"></i> <?php echo $row['mensaje'] ?>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown-divider"></li>
                        <?php  }
                         }   ?>
                         
                         
                        <li>
                            <div class="text-center link-block">
                                <a href="notificaciones.php" class="dropdown-item">
                                    <strong>Todas las Notificaciones</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>-->
                </li>
                
                <li style="background: #010829;">
                    <a style="color:#fff" href="logout.php">
                        <i class="fa fa-sign-out"></i> Salir
                    </a>
                </li>
            </ul>

        </nav>
     </div>