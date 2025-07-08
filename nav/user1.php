<?php
 @session_start();

if (isset($_SESSION['usuario'])) {
 
 ?>
 <li>
                   <a style="font-size: 14px;" href="dashboard.php"><i class="fas fa-th-large"></i> <span class="nav-label">Inicio</span></a>
                </li>
                <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-dog"></i> <span class="nav-label">Clubi Mascotas</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="../mascotas.php">Formulario Web</a></li>
                        <li><a href="../mascotasc.php">Captadores</a></li>
                        <li><a href="../mascotasv.php">Validadas</a></li>                        
                    </ul>
                </li>
                
                 <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-city"></i> <span class="nav-label">Ciudades</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="ciudadadd.php">Crear</a></li>
                        <li><a href="repciudades.php">Reporte</a></li>                        
                    </ul>
                </li>
                <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-paw"></i> <span class="nav-label">Fundaciones</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="fundacionadd.php">Crear</a></li>
                        <li><a href="repfundacion.php">Reportes</a></li>                        
                    </ul>
                </li>
               
                 <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-user-plus"></i> <span class="nav-label">Captadores</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="captadoradd.php">Crear</a></li>
                        <li><a href="repcaptador.php">Reportes</a></li>                        
                    </ul>
                </li>
                 <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-check-double"></i> <span class="nav-label">Validadores</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="validadoradd.php">Crear</a></li>
                        <li><a href="repvalidador.php">Reportes</a></li>                        
                    </ul>
                </li>
                <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-arrows-alt"></i> <span class="nav-label">Centros Distribici&oacute;n</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="centrosadd.php">Crear</a></li>
                        <li><a href="repcentros.php">Reportes</a></li>                        
                    </ul>
                </li>
                 <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-shipping-fast"></i> <span class="nav-label">Transportistas</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="">Crear</a></li>
                        <li><a href="">Reportes</a></li>                        
                    </ul>
                </li>
                 
                 
                 
                <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-shopping-bag"></i> <span class="nav-label">Productos</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="">Crear</a></li>
                        <li><a href="">Reportes</a></li>                        
                    </ul>
                </li>
                
                <li>
                   <a style="font-size: 14px;" href="#"><i class="fas fa-users"></i> <span class="nav-label">Usuarios</span><span class="fa arrow"></span></a>
                   <ul class="nav nav-second-level collapse">
                        <li><a href="useradd.php">Crear</a></li>               
                    </ul>
                </li>
                <li>
                   <a style="font-size: 14px;" href="logout.php"><i class="fas fa-sign-out-alt"></i> <span class="nav-label">Salir</span></a>
                </li>
                
<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
} ?>