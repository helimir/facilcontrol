<?php
session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$contrato=$_GET['contrato'];
$num_cargos=$_GET['cargos']; ?>

   
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>
   
    <form method="post" id="frmPerfiles" action="add/perfil_cargo.php" >
        <div class="modal-body">     
            <div class="row">          
                <table class="table ">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Perfil Actual</th>
                        <th>Perfiles Disponibles</th>
                    </tr>
                </thead>              
                <tbody>               
                <?php 
                $sql_mandante=mysqli_query($con,"select id_mandante from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
                $result=mysqli_fetch_array($sql_mandante);
                $mandante=$result['id_mandante'];
                       
                $query=mysqli_query($con,"select cargos from contratos where id_contrato='".$contrato."' ");
                $fila=mysqli_fetch_array($query);
                $cargos=unserialize($fila['cargos']);
                    
                $query3=mysqli_query($con,"select perfiles from perfiles_cargos where contrato='$contrato' and mandante='$mandante' ");
                $fila3=mysqli_fetch_array($query3);
                $perfiles=unserialize($fila3['perfiles']);
                    
                $id=0;
                $asignado=0;
                foreach ($cargos as $row) {
                       
                    # seleccionar cargo de la lista
                    $query_cargo=mysqli_query($con,"select c.* from cargos as c where c.idcargo='$row'  ");
                    $result_cargo=mysqli_fetch_array($query_cargo);                        
                       
                    # listado de perfil del mandante
                    $query_lista_perfil=mysqli_query($con,"select * from  perfiles where id_mandante='$mandante' and eliminar=0 and tipo='0' ");
                       
                    $query_perfil=mysqli_query($con,"select * from  perfiles where id_perfil='$perfiles[$id]' and id_mandante='$mandante' and eliminar=0 and tipo='0'");     
                    $result_perfil=mysqli_fetch_array($query_perfil);                                            
                       
                    $query_obs=mysqli_query($con,"select * from observaciones where contrato='".$contrato."' and estado=1 and perfil='$perfiles[$id]' ");
                    $existe_obs=mysqli_num_rows($query_obs);                       
                    ?>  
                    <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $id ?>" />
                    <input type="hidden" name="contrato" id="contrato" value="<?php echo $contrato ?>" />
                    <input type="hidden" name="mandante" id="mandante" value="<?php echo $mandante ?>" />
                    <input type="hidden" name="cargos[]" id="cargos" value="<?php echo $row ?>" />
                    <tr>
                        <td style="width: 30%;font-size: 13px;"><?php echo $result_cargo['cargo'] ?></td>                                
                        <?php 
                        if ($result_perfil['nombre_perfil']=="") { ?>
                            <td><label style="font-weight:bold" class="form-label text-center text-danger">SIN PERFIL</label></td>
                            <td> 
                                <?php 
                                if ($existe_obs==0) { ?>
                                    <select  name="perfil_lista[]" id="perfil_lista-<?php echo $id ?>" class="form-control">
                                        <option value="0">Seleccionar Perfil</option>                                                                                
                                        <?php 
                                        while($row_p = mysqli_fetch_assoc($query_lista_perfil)) { ?> 
                                            <option value="<?php echo $row_p['id_perfil'] ?>"><?php echo $row_p['nombre_perfil'] ?></option>  
                                        <?php 
                                        } ?>                                         
                                    </select>                   
                                <?php 
                                } else { ?>
                                    <p style="color: #FF0000;">Perfil con Trabajadores Verificados</p>
                                <?php 
                                } ?>
                            </td>
                            <?php
                            } else { ?>
                                <td><label ><?php echo $result_perfil['nombre_perfil'] ?></label></td>
                                <td><label>Perfil Asigando</label></td>    
                                <input type="hidden" name="perfil_lista[]" id="perfil_lista-<?php echo $id ?>" value="<?php echo $perfiles[$id]  ?>" />
                                <?php 
                                $asignado++;
                            } ?>                                  
                    </tr> 
                           
                     <?php $id++; } ?>  
                </tbody>                
              </table>              
            </div> 
         </div>         
         
   
        <div class="modal-footer">
            <label style="color:#282828;font-weight:700" >Cargos que no esten la lista favor comunicarte con <span style="background:#1a9d37;color:#fff;border-radius:10px;padding:0 5px"><b>soporte vía WhatsApp</b></span></label>
            <a style="color: #fff;" class="btn btn-secondary btn-sm" data-dismiss="modal" >CERRAR</a>
            <?php 
            if ($asignado==$id) { ?>
                <button style="color: #fff;" class="ladda-button  btn btn-secondary btn-sm" data-style="expand-right" type="submit" disabled="" >ASIGNADO</button>
            <?php 
            } else { ?>
                <button style="color: #fff;" class="ladda-button  btn btn-success btn-sm" data-style="expand-right" type="submit" >ASIGNAR</button>
            <?php 
            }  ?> 
        </div>   
   </form>
  
 

 

   