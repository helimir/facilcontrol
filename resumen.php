<?php

if ($_SESSION['nivel']==3) {
    $query_gestion_doc_contratista=mysqli_query($con,"select count(*) as total  from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 and tipo='1' order by n.idnoti desc    ");
    $result_gestion_doc_contratista=mysqli_fetch_array($query_gestion_doc_contratista);
    $cant_gestion_doc_contratista=$result_gestion_doc_contratista['total'] ?? '';

    $query_gestion_doc_trabajador=mysqli_query($con,"select count(*) as total from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 and tipo='2' order by n.idnoti desc    ");
    $result_gestion_doc_trabajador=mysqli_fetch_array($query_gestion_doc_trabajador);
    $cant_gestion_doc_trabajador=$result_gestion_doc_trabajador['total'] ?? '';

    $query_gestion_doc_vehiculo=mysqli_query($con,"select count(*) as total from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 and tipo='3' order by n.idnoti desc    ");
    $result_gestion_doc_vehiculo=mysqli_fetch_array($query_gestion_doc_vehiculo);
    $cant_gestion_doc_vehiculo=$result_gestion_doc_vehiculo['total'] ?? '';

    $query_gestion_doc_mensuales=mysqli_query($con,"select count(*) as total from notificaciones as n left join contratistas as m On m.id_contratista=n.recibe where m.rut='".$_SESSION['usuario']."' and procesada=0 and tipo='4' order by n.idnoti desc    ");
    $result_gestion_doc_mensuales=mysqli_fetch_array($query_gestion_doc_mensuales);
    $cant_gestion_doc_mensuales=$result_gestion_doc_mensuales['total'] ?? '';
}

if ($_SESSION['nivel']==2) {
    $query_gestion_doc_contratista=mysqli_query($con,"select count(*) as total from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='1' order by n.idnoti desc ");
    $result_gestion_doc_contratista=mysqli_fetch_array($query_gestion_doc_contratista);
    $cant_gestion_doc_contratista=$result_gestion_doc_contratista['total'] ?? '';

    $query_gestion_doc_trabajador=mysqli_query($con,"select count(*) as total from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='2' order by n.idnoti desc    ");
    $result_gestion_doc_trabajador=mysqli_fetch_array($query_gestion_doc_trabajador);
    $cant_gestion_doc_trabajador=$result_gestion_doc_trabajador['total'] ?? '';

    $query_gestion_doc_vehiculo=mysqli_query($con,"select count(*) as total from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='3' order by n.idnoti desc    ");
    $result_gestion_doc_vehiculo=mysqli_fetch_array($query_gestion_doc_vehiculo);
    $cant_gestion_doc_vehiculo=$result_gestion_doc_vehiculo['total'] ?? '';

    $query_gestion_doc_mensuales=mysqli_query($con,"select count(*) as total from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='4' order by n.idnoti desc    ");
    $result_gestion_doc_mensuales=mysqli_fetch_array($query_gestion_doc_mensuales);
    $cant_gestion_doc_mensuales=$result_gestion_doc_mensuales['total'] ?? '';
}


if ($_SESSION['nivel']==1) {
    $query_gestion_doc_contratista=mysqli_query($con,"select count(*) as total from notificaciones  where procesada=0 and tipo='1' order by idnoti desc    ");
    $result_gestion_doc_contratista=mysqli_fetch_array($query_gestion_doc_contratista);
    $cant_gestion_doc_contratista=$result_gestion_doc_contratista['total'] ?? '';

    $query_gestion_doc_trabajador=mysqli_query($con,"select count(*) as total from notificaciones  where procesada=0 and tipo='2' order by idnoti desc    ");
    $result_gestion_doc_trabajador=mysqli_fetch_array($query_gestion_doc_trabajador);
    $cant_gestion_doc_trabajador=$result_gestion_doc_trabajador['total'] ?? '';

    $query_gestion_doc_vehiculo=mysqli_query($con,"select count(*) as total from notificaciones where procesada=0 and tipo='3' order by idnoti desc    ");
    $result_gestion_doc_vehiculo=mysqli_fetch_array($query_gestion_doc_vehiculo);
    $cant_gestion_doc_vehiculo=$result_gestion_doc_vehiculo['total'] ?? '';

    $query_gestion_doc_mensuales=mysqli_query($con,"select count(*) as total from notificaciones where procesada=0 and tipo='4' order by idnoti desc    ");
    $result_gestion_doc_mensuales=mysqli_fetch_array($query_gestion_doc_mensuales);
    $cant_gestion_doc_mensuales=$result_gestion_doc_mensuales['total'] ?? '';
}

?>
<style>
    .enlace_resumen {
        color:#fff;
    }
    .enlace_resumen:hover .fila {
        background:#1C84C6 !important;
        color:#fff;
        border:none;

    }
</style>

                                    <div class="row">
                                            <div class="col-lg-4 col-xs-12 col-sm-12">
                                                <?php
                                                if ($cant_gestion_doc_contratista==0) { ?>
                                                    <div class="widget style1 navy-bg">
                                                        <div class="row ">                                                             
                                                            <div class="col-4 text-center">
                                                                <i class="fa fa-list fa-4x"></i>
                                                            </div>
                                                            <div class="col-8 text-right">
                                                                <span style="font-size:16px;font-weight:bold">Contratista</span>
                                                                <h2 class="font-bold"><?php echo 0 ?></h2>
                                                            </div>                                                                                                                        
                                                        </div>   
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <a class="enlace_resumen" href="#" onclick="modal_contratistas(1)"> 
                                                        <div class="widget fila style1 navy-bg">
                                                                <div class="row ">                                                             
                                                                    <div class="col-4 text-center">
                                                                        <i class="fa fa-list fa-4x"></i>
                                                                    </div>
                                                                    <div class="col-8 text-right">
                                                                        <span style="font-size:16px;font-weight:bold">Contratista</span>
                                                                        <h2 class="font-bold"><?php echo $cant_gestion_doc_contratista ?></h2>
                                                                    </div>                                                                                                                        
                                                                </div>   
                                                        </div>
                                                    </a>
                                                <?php
                                                }  ?>
                                            </div>
                                            <div class="col-lg-4 col-xs-12 col-sm-12">
                                                <?php
                                                if ($cant_gestion_doc_trabajador==0) { ?>
                                                    <div class="widget style1 navy-bg">
                                                        <div class="row ">                                                             
                                                            <div class="col-4 text-center">
                                                                <i class="fa fa-list fa-4x"></i>
                                                            </div>
                                                            <div class="col-8 text-right">
                                                                <span style="font-size:16px;font-weight:bold">Trabajadores</span>
                                                                <h2 class="font-bold"><?php echo 0 ?></h2>
                                                            </div>                                                                                                                        
                                                        </div>   
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <a class="enlace_resumen" href="#" onclick="modal_trabajadores(2)"> 
                                                        <div class="widget fila style1 navy-bg">
                                                                <div class="row ">                                                             
                                                                    <div class="col-4 text-center">
                                                                        <i class="fa fa-list fa-4x"></i>
                                                                    </div>
                                                                    <div class="col-8 text-right">
                                                                        <span style="font-size:16px;font-weight:bold">Trabajadores</span>
                                                                        <h2 class="font-bold"><?php echo $cant_gestion_doc_trabajador ?></h2>
                                                                    </div>                                                                                                                        
                                                                </div>   
                                                        </div>
                                                    </a>
                                                <?php
                                                }  ?>
                                            </div>
                                            <div class="col-lg-4 col-xs-12 col-sm-12">
                                                <?php
                                                if ($cant_gestion_doc_vehiculo==0) { ?>
                                                    <div class="widget style1 navy-bg">
                                                        <div class="row ">                                                             
                                                            <div class="col-4 text-center">
                                                                <i class="fa fa-list fa-4x"></i>
                                                            </div>
                                                            <div class="col-8 text-right">
                                                                <span style="font-size:16px;font-weight:bold">Vehículos</span>
                                                                <h2 class="font-bold"><?php echo 0 ?></h2>
                                                            </div>                                                                                                                        
                                                        </div>   
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <a class="enlace_resumen" href="#" onclick="modal_vehiculos_r(3)"> 
                                                        <div class="widget fila style1 navy-bg">
                                                                <div class="row ">                                                             
                                                                    <div class="col-4 text-center">
                                                                        <i class="fa fa-list fa-4x"></i>
                                                                    </div>
                                                                    <div class="col-8 text-right">
                                                                        <span style="font-size:16px;font-weight:bold">Vehículos</span>
                                                                        <h2 class="font-bold"><?php echo $cant_gestion_doc_vehiculo ?></h2>
                                                                    </div>                                                                                                                        
                                                                </div>   
                                                        </div>
                                                    </a>
                                                <?php
                                                }  ?>
                                            </div>
                                            <!--<div class="col-lg-3 col-xs-12 col-sm-12">
                                                <?php
                                                if ($cant_gestion_doc_mensuales==0) { ?>
                                                    <div class="widget style1 navy-bg">
                                                        <div class="row ">                                                             
                                                            <div class="col-4 text-center">
                                                                <i class="fa fa-list fa-4x"></i>
                                                            </div>
                                                            <div class="col-8 text-right">
                                                                <span style="font-size:16px;font-weight:bold">Mensuales</span>
                                                                <h2 class="font-bold"><?php echo 0 ?></h2>
                                                            </div>                                                                                                                        
                                                        </div>   
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <a class="enlace_resumen" href="#" onclick="modal_mensuales(4)"> 
                                                        <div class="widget fila style1 navy-bg">
                                                                <div class="row ">                                                             
                                                                    <div class="col-4 text-center">
                                                                        <i class="fa fa-list fa-4x"></i>
                                                                    </div>
                                                                    <div class="col-8 text-right">
                                                                        <span style="font-size:16px;font-weight:bold">Mensuales</span>
                                                                        <h2 class="font-bold"><?php echo $cant_gestion_doc_mensuales ?></h2>
                                                                    </div>                                                                                                                        
                                                                </div>   
                                                        </div>
                                                    </a>
                                                <?php
                                                }  ?>
                                            </div>-->
                                        </div>

<script>

                                function modal_contratistas(opcion) {
                                        $('.body').load('sel/selid_resumen_contratistas.php?opcion='+opcion,function(){
                                            document.getElementById("titulo").innerHTML="Documentos Contratista Pendientes";
                                            $('#modal_contratistas').modal('show');
                                    });
                                }

                                function modal_trabajadores(opcion) {
                                        $('.body').load('sel/selid_resumen_contratistas.php?opcion='+opcion,function(){
                                            document.getElementById("titulo").innerHTML="Documentos Trabajadores Pendientes";
                                            $('#modal_contratistas').modal('show');
                                    });
                                }

                                function modal_vehiculos_r(opcion) {
                                        $('.body').load('sel/selid_resumen_contratistas.php?opcion='+opcion,function(){
                                            document.getElementById("titulo").innerHTML="Documentos Vehículos Pendientes";
                                            $('#modal_contratistas').modal('show');

                                    });
                                }

                                function modal_mensuales(opcion) {
                                        $('.body').load('sel/selid_resumen_contratistas.php?opcion='+opcion,function(){
                                            document.getElementById("titulo").innerHTML="Documentos Mensuales Pendientes";
                                            $('#modal_contratistas').modal('show');
                                    });
                                }

</script>

                            <div class="modal inmodal" id="modal_contratistas" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div style="background:#e9eafb;color:#282828" class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 id="titulo" class="modal-title"></h4>
                                        </div>
                                        <div class="body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="modal inmodal" id="modal_trabajadores" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 id="titulo" class="modal-title"></h4>
                                        </div>
                                        <div class="body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal inmodal" id="modal_vehiculos" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Documentos Vehículos Pendientes</h4>
                                        </div>
                                        <div class="body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>-->

                            <div class="modal inmodal" id="modal_mensuales" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Documentos Mensuales Pendientes</h4>
                                        </div>
                                        <div class="body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            