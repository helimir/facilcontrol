<?php 
 session_start();
 $url_host=$_SERVER['HTTP_HOST'];
?>

<style>

.encabezado {
    background: #010829;
}

.btn-submenu  {
    background: #FF00FF;
    border: #FF00FF;
}

.collapse > li > a:hover {
    background: #7285A8 !important ;
}

.floatm1 {   
	position:fixed;
	width:60px;
	height:60px;
	bottom:35%;
	right:0%;
	background:#25d366;
	color:#FFFFFF !important;
	border-radius:0px;
	text-align:center;
    font-size:30px;
    padding-right: ;
    padding-left: ;
	/**box-shadow: 2px 2px 3px #999;**/
    z-index:100;
}
.my-floatm1{
	margin-top:12px;
}

.float {   
	position:fixed;
	width:140px;
	height:40px;
	bottom:20%;
	right:0%;
	background:#25d366;
	color:#FFFFFF !important;
	text-align:right;
    font-size:15px;
    padding-right: 1%;
    padding-left: ;
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
	/**box-shadow: 2px 2px 3px #999;**/
    z-index:100;
}
 
.my-float{
	margin-top:14px;
}

.whatsapp {
  position:fixed;
  width:60px;
  height:60px;
  bottom:45px;
  right:30px;
  background-color:#25d366;
  color:#FFF;
  border-radius:50px;
  text-align:center;
  font-size:30px;
  z-index:100;
}

.whatsapp-icon {
  margin-top:13px;
}

</style>

<script>
    function cambiar(usuario,valor,url) {
        //alert(url)
        $.ajax({
        method: "POST",
        url: "cambiar_dual.php",
        data: 'valor='+valor+'&rut='+usuario,
		success: function(data){	
            //alert(data)
            //contratista		  
            //if (data==1) {
            //    window.location.href="list_contratos_contratistas.php";
            //}
            //mandante
            ///if (data==2) {
                window.location.href="tareas.php";
		    //}
        }                        
    });
    }
</script>

<script id="respondio__widget" src="https://cdn.respond.io/webchat/widget/widget.js?cId=1884fc2a939f31940f3c820abb928e6776b318038f0b6b55d1ac496a340316aa"></script><!-- https://respond.io -->

<?php $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/mobile/i", $useragent) ) { ?>
         <a title="Soporte Tecnico FacilControl" href="https://api.whatsapp.com/send?phone=56936450940&text=Hola, soporte ayuda sobre," class="whatsapp" target="_blank"><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
       <!--<a href="https://clubi.cl/tienda/" class="floatm2" target="_blank"><span style="font-size: 15px;color: #fff !important;"><i class="fa fa-shopping-bag my-floatm2"></i></span></a>
        <a href="https://www.instagram.com/clubipets/" class="floatm3" target="_blank"><span style="font-size: 15px;color: #fff !important;"><i class="fa fa-instagram my-floatm3"></i></span></a>-->
        
	<?php } else {  ?>       
       <a title="Soporte Tecnico FacilControl" href="https://web.whatsapp.com/send?phone=56936450940&text=Hola, necesito soporte sobre," class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><span  style=""><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
         <!--<a title="Escribanos para cualquier consulta" href="https://web.whatsapp.com/send?phone=56997835878&text=Hola, para m�s informaci�n sobre," class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><span  style=""><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
        <a href="https://clubi.cl/tienda/" class="float2" target="_blank"><span style="" title="Compre directo sin registro">Tienda Clubi <i class="fa fa-shopping-bag my-float2"></i></span></a>
        <a href="https://www.instagram.com/clubipets/" class="float3" target="_blank"><span style="" title="Siguenos es nuestra cuenta">Instagram <i class="fa fa-instagram my-float3"></i></span></a>-->
<?php }   ?>


<?php 
  
  # si es mandante
  if ($_SESSION['nivel']==1) {
    $mandante=isset($_SESSION['mandante']) ? $_SESSION['mandante']: '';
  
    $query_n=mysqli_query($con,"select n.* from notificaciones as n where n.recibe='".$mandante."' and n.procesada=0  ");
    $num_noti=mysqli_num_rows($query_n);
    
    $query_c=mysqli_query($con,"select razon_social from mandantes where id_mandante='".$mandante."' ");
    $result_c=mysqli_fetch_array($query_c);
    
    
    ?>
    <nav style="background:#010829 ;" class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li style="background:#010829 ;" class="nav-header">
                <div class="dropdown profile-element">
                     <?php if (empty($result_con['logo'])) { ?>
                        <div style="width:100%">
                                <img alt="image" class="" style="heigth:100%;width:100%;;border-radius:5px;padding-top:-4%" src="assets\img\logo_fc.png">
                        </div>                        
                    <?php } else { ?>
                        <div style="width:100%">
                                <img height="100" alt="image" class="" style="width:100%;background:#fff;border-radius:5px;padding-top:-4%" src="<?php echo $result_con['logo'] ?>">
                        </div>
                    <?php } ?>
                    
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo isset($result_c['razon_social']) ?></span>
                        <span class="text-muted text-xs block">Super Admin </span>
                        <!--<span class="text-muted text-xs block">Contratista <b class="caret"></b></span>-->
                    </a>
                    <!--<ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="">Profile</a></li>
                        <li><a class="dropdown-item" href="">Contacts</a></li>
                        <li><a class="dropdown-item" href="">Mailbox</a></li>
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="">Salir</a></li>
                    </ul>-->
                </div>
                <div class="logo-element">
                    FC+
                </div>
            </li>
            <li>
                <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Mandantes</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_mandante.php">Nuevo Mandante</a></li>
                    <li><a href="list_mandantes.php">Reporte Mandantess</a></li>
                </ul>
            </li>
            <li>
                <a href="solicitudes.php"><i class="fa fa-user-plus" aria-hidden="true"></i> <span class="nav-label">Solicitudes</span></a>
            </li>
            <li class="" >
                <a href=""><i class="fa fa-file-text" aria-hidden="true"></i> <span class="nav-label">Contratistas</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="list_contratistas.php">Reporte Contratista</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Trabajadores</span><span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level collapse">                
                    <li><a href="list_trabajadores_mandantes.php">Reporte trabajadores</a></li>
                    <li><a href="trabajadores_acreditados_mandantes.php">Acreditados</a></li>
                    <li><a href="trabajadores_desvinculados_mandantes.php">Desvinculados</a></li>
                </ul>
            </li>   
            <li>
                <a href="#"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <span class="nav-label">Bases de Datos</span><span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level collapse">                
                    <li><a  href="bd_acreditados.php">Acreditados Documentos</a></li>
                    <li><a  href="bd_acreditados_t.php">Acreditados Trabajador</a></li>
                    <li><a  href="bd_contratistas.php">Contratistas</a></li>
                </ul>
            </li>         
            <!--<li>
                <a href="facilcontrol_pro.php"><i class="fa fa-certificate"></i> <span class="nav-label">FacilControl <b>PRO</b></span></a>
            </li>-->
            <li >
                <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> <span style="color:#fff" class="nav-label">Salir</span></a>
            </li>
        </ul>

    </div>
    </nav>
<?php } ?> 

<?php 

  # si es mandante
  if ($_SESSION['nivel']==2) { 
    $mandante=$_SESSION['mandante'];
    $query_n=mysqli_query($con,"select n.* from notificaciones as n where n.recibe='".$mandante."' and n.procesada=0  ");
    $num_noti=mysqli_num_rows($query_n);
    
    $query_con=mysqli_query($con,"select * from mandantes where id_mandante='".$mandante."' ");
    $result_con=mysqli_fetch_array($query_con);
    
    
    ?>
    <nav style="background:#010829 ;" class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li style="background:#010829 ;" class="nav-header">
                <div class="dropdown profile-element">

                     <?php if (empty($result_con['logo'])) { ?>
                        <div style="width:100%">
                                <img alt="image" class="" style="heigth:100%;width:100%;;border-radius:5px;padding-top:-4%" src="assets\img\logo_fc.png">
                        </div>                        
                    <?php } else { ?>
                        <div style="width:100%">
                                <img height="100" alt="image" class="" style="width:100%;background:#fff;border-radius:5px;padding-top:-4%" src="<?php echo $result_con['logo'] ?>">
                        </div>
                    <?php } ?>

                    <?PHP if ($result_con['dualidad']==1) { ?>
                            <div data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span style="color:#fff" class="block m-t-xs font-bold"><?php echo $result_con['razon_social'].'<br/>'. $result_con['rut_empresa'] ?></span>                                
                                <span style="font-size:12px;margin-top:1%" class="badge badge-info block">MANDANTE <b class="caret"></b></span>
                                <!--<span class="text-muted text-xs block">Contratista <b class="caret"></b></span>-->
                            </div>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="" onclick="cambiar('<?php echo $_SESSION['usuario'] ?>',1,'<?php echo $url_host ?>')">Cambiar a Contratista</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
                            </ul>
                    <?PHP } else { ?>
                        <div data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span style="color:#fff" class="block m-t-xs font-bold"><?php echo $result_con['razon_social'].'<br/>'. $result_con['rut_empresa'] ?></span>                                
                                <span style="font-size:12px;margin-top:1%" class="badge badge-info block">MANDANTE </span>
                            </div>
                    <?PHP } ?>
                   
                </div>
                <div class="logo-element">
                    FC+
                </div>
            </li>
            <li id="menu-tareas">
                <a href="tareas.php"><i class="fa fa-bell-o" aria-hidden="true"></i> <span class="nav-label">Tareas </span><span style="color:#010829;font-size:14px;background:#fff;font-weight:bold" class="label label-warning float-right"><?php echo $num_noti ?></span></a>
            </li>
            <li id="menu-contratistas">
                <a href="#"><i class="fa fa-list"></i> <span class="nav-label">Contratistas</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_contratista.php">Nueva Contratista</a></li>
                    <li><a href="list_contratistas_mandantes.php">Reporte Contratistas</a></li>
                    
                </ul>
            </li>
            <li id="menu-contratos" >
                <a href=""><i class="fa fa-file-text" aria-hidden="true"></i> <span class="nav-label">Contratos</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_contrato.php">Nuevo Contrato</a></li>
                    <li><a href="list_contratos.php">Gesti&oacute;n de Contratos</a></li>
                </ul>
            </li>
            <li id="menu-trabajadores">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Trabajadores</span><span class="fa arrow"></span></a>
                 <ul class="nav nav-second-level collapse">                
                    <li><a href="list_trabajadores_mandantes.php">Reporte trabajadores</a></li>
                    <li><a href="trabajadores_acreditados_mandantes.php">Acreditados</a></li>
                    <li><a href="trabajadores_desvinculados_mandantes.php">Desvinculados</a></li>
                </ul>
            </li>
             <li id="menu-vehiculos">
                <a href="list_vehiculos_mandante.php"><i class="fa fa-car" aria-hidden="true"></i> <span class="nav-label">Reporte Vehiculos/Maquinarias</span></a>
            </li>
            <!--<li>
                <a href="desvinculaciones_mandante.php"><i class="fa fa-user-times" aria-hidden="true"></i> <span class="nav-label">Desvinculaciones</span></a>
            </li>-->
            <li id="menu-doc-extras">
                <a href="crear_doc_extra.php"><i class="fa fa-file" aria-hidden="true"></i> <span class="nav-label">Docs. Extraordinarios</span> </a>                
            </li>
            <li id="menu-doc-mensuales">
                <a href="gestion_doc_mensuales_mandantes.php"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="nav-label">Docs. Mensulaes</span></a>
            </li>
            <li id="menu-perfiles">
                <a href=""><i class="fa fa-address-card-o"></i> <span class="nav-label">Perfiles </span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_perfil.php">Crear Perfil Cargos</a></li>
                    <li><a href="crear_perfil_vehiculos.php">Crear Perfil Vehiculo/Maquinaria</a></li>
                    <li><a href="list_perfil.php">Reporte Perfiles</a></li>
                </ul>
            </li>
            <li id="menu-datos-mandante">
                <a href="perfil_mandante.php"><i class="fa fa-address-card-o"></i> <span class="nav-label">Datos Mandante</span>  </a>
            </li>        
            <li>
                <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> <span style="color:#fff" class="nav-label">Salir</span></a>
            </li>
        </ul>

    </div>
    </nav>
<?php } ?>   


<?php 

  # si es contratista   
  if ($_SESSION['nivel']==3) { 
    $contratista=$_SESSION['contratista'];
    $query_n=mysqli_query($con,"select n.* from notificaciones as n where n.recibe='".$contratista."' and n.procesada=0  ");
    $num_noti=mysqli_num_rows($query_n);
    
    $query_c=mysqli_query($con,"select * from contratistas where id_contratista='".$contratista."' ");
    $result_c=mysqli_fetch_array($query_c);
    
    
    ?> 
    <nav style="background:#010829 ;" class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul  class="nav metismenu" id="side-menu">
            <li style="background:#010829 ;" class="nav-header">
                <div class="dropdown profile-element">
                    <?php if (empty($result_c['url_logo'])) { ?>
                        <div style="width:100%">
                            <img alt="image" class="" style="heigth:100%;width:100%;border-radius:5px;padding-top:-4%" src="assets\img\logo_fc.png">
                        </div>                        
                    <?php } else { ?>
                        <div style="width:100%">
                            <img alt="image" class="" style="width:100%;background:#fff;border-radius:5px;padding-top:-4%" src="img/contratista/<?php echo $contratista ?>/logo_<?php echo $contratista ?>.png">
                        </div>
                    <?php } ?>
                    
                    <?PHP if ($result_c['dualidad']==1) { ?>
                            <div data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span style="color:#fff" class="block m-t-xs font-bold"><?php echo $result_c['razon_social'].'<br/>'. $result_c['rut'] ?></span>                                
                                <span style="font-size:12px;margin-top:1%" class="badge badge-info block">CONTRATISTA <b class="caret"></b></span>
                                <!--<span class="text-muted text-xs block">Contratista <b class="caret"></b></span>-->
                            </div>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="" onclick="cambiar('<?php echo $_SESSION['usuario'] ?>',2,'<?php echo $url_host ?>')">Cambiar a Mandante</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Salir</a></li>
                            </ul>
                    <?PHP } else { ?>
                        <div data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span style="color:#fff" class="block m-t-xs font-bold"><?php echo $result_c['razon_social'].'<br/>'. $result_c['rut'] ?></span>                                
                                <span style="font-size:12px;margin-top:1%" class="badge badge-info block">CONTRATISTA</span>
                            </div>
                    <?PHP } ?>
                </div>
                <div class="logo-element"> 
                    FC+
                </div>
            </li>
            <li id="menu-tareas">
                <a href="tareas.php"><i class="fa fa-bell-o" aria-hidden="true"></i> <span class="nav-label">Tareas </span><span style="color:#010829;font-size:14px;background:#fff;font-weight:bold" class="label label-warning float-right"><?php echo $num_noti ?></span></a>
            </li>
            <li id="menu-gestion">
                <a href="#"><i class="fa fa-file-text"></i> <span class="nav-label">Gestion Documentos</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="gestion_documentos.php">Contratista</a></li>
                    <li><a href="gestion_doc_mensuales_contratista.php">Mensuales</a></li>
                    <li><a href="desvinculaciones_contratista.php">Desvinculaciones</a></li>
                </ul>
            </li>
            <li id="menu-extras">
                <a href="list_doc_extras_contratista.php"><i class="fa fa-file" aria-hidden="true"></i> <span class="nav-label">Docs. Extraordinarios</span></a>
            </li> 
            
            <li id="menu-contratos" >
                <a href="list_contratos_contratistas.php"><i class="fa fa-file" aria-hidden="true"></i> <span class="nav-label">Contratos</span></a>
            </li>

            <li id="menu-trabajadores">
                <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Trabajadores</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_trabajador.php">Nuevo trabajador</a></li>
                    <li><a href="list_trabajadores.php">Reporte trabajadores</a></li>
                    <li><a href="trabajadores_acreditados.php">Acreditados</a></li>
                    <li><a href="trabajadores_desvinculados.php">Desvinculados</a></li>
                </ul>
            </li>
            
            <li id="menu-vehiculos">
                <a href="#"><i class="fa fa-taxi"></i> <span class="nav-label">Vehiculo/Maquinaria</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="crear_auto.php">Nuevo Vehiculo/Maquinaria</a></li>
                    <li><a href="list_vehiculos.php">Reporte Vehiculos/Maquinaria</a></li>
                    <li><a href="vehiculos_acreditados.php">Acreditados</a></li>
                </ul>
            </li>
            <li id="menu-cuadrillas" >
                <a href="crear_cuadrilla.php"><i class="fa fa-file" aria-hidden="true"></i> <span class="nav-label">Cuadrillas</span></a>
            </li>
            <li id="menu-epp" >
                <a href="crear_epp.php"><i class="fa fa-file" aria-hidden="true"></i> <span class="nav-label">EPPs</span></a>
            </li>
            <li id="menu-mis-mandantes">
                <a href="list_mis_mandantes.php"><i class="fa fa-address-book" aria-hidden="true"></i> <span class="nav-label">Mis Mandantes </span></a>
            </li>          
            <li id="menu-datos-contratista">
                <a href="perfil_contratista.php"><i class="fa fa-address-card-o"></i> <span class="nav-label">Datos Contratista</span>  </a>
            </li>
            <li>
                <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> <span class="nav-label">Salir</span></a>
            </li>
        </ul>

    </div>
    </nav>
<?php } ?>   