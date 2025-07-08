                                <form action="add/addtrabajador.php"  method="post"  enctype="multipart/form-data" id="formulario">
                            
                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox "> 
                                                          
                                                       <!-- id trabajador -->
                                                       <div class="row"> 
                                                                 <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                    <label  class="col-form-label" for="quantity">Id Trabajador</label> 
                                                                </div> 
                                                                <div class="form-group col-lg-2 col-md-21 col-sm-2 col-xs-2">
                                                                   <input  class="form-control" type="text" name="idtrabajador" id="idtrabajador"  value="<?php echo $ftrabajador['idtrabajador'] ?>"  readonly="" />
                                                                </div>
                                                        </div>
                                                        <hr />
                                                       
                                                        <!-- rut  --> 
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">RUT</label> 
                                                            </div> 
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                               <input class="form-control" type="text" name="rut" id="rut" placeholder="11111111-1" autocomplete="off" maxlength="10"  value="<?php echo $ftrabajador['rut'] ?>"  oninput="checkRut(this)"   required="" >
                                                            </div>
                                                         </div>
                                                        <hr />
                                                        
                                                        <!-- 1 nombre -->
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">1er. Nombre</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="nombre1" id="nombre1" placeholder="" value="<?php echo $ftrabajador['nombre1'] ?>"  required="">
                                                            </div>
                                                         </div>
                                                        
                                                        <!-- 2 nombre  --> 
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">2do. Nombre</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="nombre2" id="nombre2" placeholder="" value="<?php echo $ftrabajador['nombre2'] ?>"  />
                                                            </div>
                                                         </div> 
                                                        
                                                        <!-- 1 apellido --> 
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">1er. Apellido</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="apellido1" id="apellido1" placeholder="" value="<?php echo  $ftrabajador['apellido1'] ?>"  required=""/>
                                                            </div>
                                                         </div> 
                                                        
                                                        <!-- 2 apellido --> 
                                                         <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">2do. Apellido</label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="apellido2" id="apellido2" placeholder="" value="<?php echo $ftrabajador['apellido2'] ?>" />
                                                            </div>                                
                                                         </div> 
                                                        <hr />
                                                        
                                                        <!-- direccion -->
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Direcci&oacute;n</label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="direccion1" id="direccion1" placeholder="Calle" value="<?php echo $ftrabajador['direccion1'] ?>"  required=""/>
                                                            </div>                                               
                                                         </div>
                                                        
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong></strong> </label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                    <input class="form-control" type="text" name="direccion2" id="direccion2" placeholder="No. casa/Dpto " value="<?php echo $ftrabajador['direccion2'] ?>"  required=""/>
                                                            </div>                                                        
                                                         </div>
                                                        
                                                        <!-- region  --> 
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong></strong> </label> 
                                                            </div>         
                                                             <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                   <div class="form-wrap">
                                                                        <select name="region" id="region" class="form-control">
                                                                                <option value="<?php echo $ftrabajador['region'] ?>" selected=""><?php echo utf8_encode($ftrabajador['Region'])  ?></option>
                                                                                 <?php while($row = mysqli_fetch_assoc($regiones)) { 
                                                                                        $region=utf8_encode($row['Region']);
                                                                                         ?>                                                                                                            
                                                                    					<option value="<?php echo $row['IdRegion']; ?>"><?php echo $row['Region'] ?></option>
                                                                    				<?php } ?>
                                                                              </select>
                                                                    </div>
                                                                </div>             
                                                       </div>     
                                                       
                                                       <!-- comuna -->  
                                                       <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong></strong> </label> 
                                                            </div>                     
                                                                <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                  <div class="form-wrap">
                                                                        <select name="comuna" id="comuna" class="form-control">
                                                                            <option value="<?php echo $ftrabajador['comuna'] ?>" selected=""><?php echo $ftrabajador['Comuna']  ?></option>
                                                                         </select>   
                                                                    </div>
                                                                </div>              
                                                       </div> 
                                                      <hr />  
                                                       
                                                       <!-- estado civil  -->
                                                        <div class="row">    
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Estado Civil</label> 
                                                            </div>  
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <select class="form-control" style="width: 100%;" name="estadocivil" id="estadocivil">
                                                                            <option value="<?php echo $ftrabajador['estadocivil'] ?>" selected=""><?php echo $ftrabajador['estadocivil'] ?></option>
                                                                            <option value="Soltero">Soltero</option>
                                                                            <option value="Casado">Casado</option>
                                                                            <option value="Union">Union</option>
                                                                            <option value="Viudo">Viudo</option>
                                                                            <option value="Separado">Separado</option>
                                                                            <option value="Divorciado">Divorciado</option> 
                                                                        </select>
                                                            </div>
                                                        </div> 
                                                        
                                                        <!-- email --> 
                                                        <div class="row"> 
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Email </label> 
                                                            </div>         
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="email" name="email" id="email" placeholder="" value="<?php echo $ftrabajador['email'] ?>"   />                               
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- telefono -->
                                                        <div class="row">   
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Telefono</label> 
                                                            </div>    
                                                           <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input class="form-control" type="text" name="telefono" id="telefono" placeholder="" value="<?php echo $ftrabajador['telefono'] ?>"  />
                                                            </div>
                                                        </div>    
                                                       
                                                       <!-- fecha nacimiento -->
                                                       <div class="row">   
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Fecha Nac. </label> 
                                                            </div>                    
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                  <label class="col-form-label" for="quantity">D&iacute;a</label>
                                                                  <select class="form-control" name="dia">                                                                                                       
                                                                                <?php
                                                                                
                                                                                if ($ftrabajador['dia']<10) {
                                                                                    echo "<option style='text-align: center' value=".$ftrabajador['dia']." select=''>0".$ftrabajador['dia']."</option>";
                                                                                } else {
                                                                                    echo "<option style='text-align: center' value=".$ftrabajador['dia']." select=''>".$ftrabajador['dia']."</option>";
                                                                                }
                                                                                
                                                                                for ($i=1; $i<=31; $i++) {
                                                                                                                   
                                                                                       echo '<option value="'.$i.'">0'.$i.'</option>';
                                                                                       
                                                                                }
                                                                                ?>
                                                                         </select>
                                                                  </div>
                                                                  <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">       
                                                                         <label class="col-form-label" for="quantity">Mes</label>
                                                                         <select class="form-control"  name="mes">
                                                                                <?php
                                                                                
                                                                                switch ($ftrabajador['mes']) {
                                                                                           case 1: $mest="Enero";break;
                                                                                           case 2: $mest="Febrero";break;
                                                                                           case 3: $mest="Marzo";break;
                                                                                           case 4: $mest="Abril";break;
                                                                                           case 5: $mest="Mayo";break;
                                                                                           case 6: $mest="Junio";break;
                                                                                           case 7: $mest="Julio";break;
                                                                                           case 8: $mest="Agosto";break;
                                                                                           case 9: $mest="Septiembre";break;
                                                                                           case 10: $mest="Octubre";break;
                                                                                           case 11: $mest="Noviembre";break;
                                                                                           case 12: $mest="Diciembre";break;  
                                                                                            
                                                                                         }
                                                                                
                                                                                
                                                                                echo "<option style='text-align: center' value=".$ftrabajador['mes']." select>".$mest."</option>";
                                                                                for ($i=1; $i<=12; $i++) {                                                       
                                                                                         
                                                                                         switch ($i) {
                                                                                           case 1: $mes="Enero";break;
                                                                                           case 2: $mes="Febrero";break;
                                                                                           case 3: $mes="Marzo";break;
                                                                                           case 4: $mes="Abril";break;
                                                                                           case 5: $mes="Mayo";break;
                                                                                           case 6: $mes="Junio";break;
                                                                                           case 7: $mes="Julio";break;
                                                                                           case 8: $mes="Agosto";break;
                                                                                           case 9: $mes="Septiembre";break;
                                                                                           case 10: $mes="Octubre";break;
                                                                                           case 11: $mes="Noviembre";break;
                                                                                           case 12: $mes="Diciembre";break;
                                                                                         }
                                                                                         echo '<option value="0'.$i.'"> '.$mes.'</option>';
                                                                                        
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                   </div>
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">     
                                                                        <label class="col-form-label" for="quantity">A&ntilde;o</label>
                                                                        <select class="form-control" name="ano">
                                                                                <?php
                                                                                echo "<option style='text-align: center' value=".$ftrabajador['ano']." selected>".$ftrabajador['ano']."</option>";
                                                                                for($i=date('o'); $i>=1910; $i--){
                                                                                    
                                                                                        echo '<option value="'.$i.'"> '.$i.'</option>';
                                                                                    
                                                                                }
                                                                                ?>
                                                                        </select>
                                                                    </div> 
                                                        </div>  
                                                        
                                                        <!-- tallas  -->      
                                                           <div class="row">
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Tallas</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Pantalon</label>
                                                                        <select class="form-control"  style="width: 100%;" name="tpantalon" id="tpantalon">
                                                                            <option value="<?php echo $ftrabajador['tpantalon'] ?>" selected=""><?php echo $ftrabajador['tpantalon'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Poleras</label>
                                                                        <select class="form-control"  style="width: 100%;" name="tpolera" id="tpolera">
                                                                            <option value="<?php echo $ftrabajador['tpolera'] ?>" selected=""><?php echo $ftrabajador['tpolera'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Zapatos</label>
                                                                        <select class="form-control"  style="width: 100%;" name="tzapatos" id="tzapatos">
                                                                            <option value="<?php echo $ftrabajador['tzapatos'] ?>" selected=""><?php echo $ftrabajador['tzapatos'] ?></option> 
                                                                            <?php                                                                             
                                                                            for ($i=30;$i<=50;$i++) {                                                                                
                                                                               echo '<option value="'.$i.'">'.$i.'</option>'; 
                                                                            }  ?>                                                                            
                                                                        </select>
                                                                    </div>
                                                            </div> 
                                                          
                                                        
                                                        <hr />
                                                        <!-- cargo  -->
                                                        <!--<div class="row">    
                                                            <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Cargo</label> 
                                                            </div>   
                                                            
                                                            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                <select class="form-control" style="width: 100%;" name="cargo" id="cargo">
                                                                           
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <select class="form-control" style="width: 100%;" name="tipocargo" id="tipocargo">
                                                                            <option value="<?php echo $ftrabajador['tipocargo'] ?>" selected=""><?php echo $ftrabajador['tipocargo'] ?></option>
                                                                            <option value="M">M</option>
                                                                            <option value="E">E</option>
                                                                            <option value="J">J</option>
                                                                            <option value="OP">OP</option>   
                                                                            <option value="JV">JV</option>
                                                                            <option value="AD">AD</option>  
                                                                        </select>
                                                            </div>
                                                        </div> -->  
                                                        
                                                        <!-- conductor -->
                                                         <div class="row">    
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity">Conductor</label> 
                                                            </div>   
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                 
                                                                        <select class="form-control"  style="width: 100%;" name="licencia" id="licencia" onchange="ShowSelected()"> 
                                                                            <option value="<?php echo $ftrabajador['licencia'] ?>"><?php echo $ftrabajador['licencia'] ?></option>
                                                                            <option value="NO">NO</option>
                                                                            <option value="SI">SI</option>                                            
                                                                        </select>                                             
                                                            </div>            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">            
                                                                     <?php  if ($ftrabajador['licencia']=="SI") {
                                                                                ?>  
                                                                                <select class="form-control" style="width: 100%;" name="tipolicencia" id="tipolicencia" >
                                                                                    <option value="<?php echo $ftrabajador['tipolicencia'] ?>" selected=""><?php echo $ftrabajador['tipolicencia'] ?></option>
                                                                                    <option value="A1">A1</option>
                                                                                    <option value="A2">A2</option>
                                                                                    <option value="A3">A3</option>
                                                                                    <option value="A4">A4</option>
                                                                                    <option value="B">B</option>
                                                                                    <option value="D">D</option>
                                                                                    <option value="C">C</option>
                                                                                    <option value="E">E</option>
                                                                                </select> 
                                                                           <?php } else { ?>
                                                                                    <select class="form-control" style="width: 100%;" name="tipolicencia" id="tipolicencia" disabled="" >
                                                                                    <option value="0" selected="">Tipo</option>
                                                                                    <option value="A1">A1</option>
                                                                                    <option value="A2">A2</option>
                                                                                    <option value="A3">A3</option>
                                                                                    <option value="A4">A4</option>
                                                                                    <option value="B">B</option>
                                                                                    <option value="D">D</option>
                                                                                    <option value="C">C</option>
                                                                                    <option value="E">E</option>
                                                                                </select>
                                                                      <?php }  ?>     
                                                                                             
                                                            </div>
                                                        </div>  
                                                        
                                                       <hr /> 
                                                        <!-- bancos afp y salud-->
                                                            <div class="row">
                                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Banco </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label" for="quantity">Entidad</label>
                                                                        <select class="form-control"  style="width: 100%;" name="banco" id="banco">
                                                                            <option value="<?php echo $ftrabajador['idbanco'] ?>" selected=""><?php echo $ftrabajador['banco'] ?></option>
                                                                            <?php while($row = mysqli_fetch_assoc($bancos)) { 
                                                                               $banco=utf8_encode($row['banco']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idbanco']; ?>"><?php echo $row['banco'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label" for="quantity">Tipo Cuenta </label>
                                                                        <select class="form-control"  style="width: 100%;" name="tipocuenta" id="tipocuenta">
                                                                            <option value="<?php echo $ftrabajador['tipocuenta'] ?>" selected=""><?php echo $ftrabajador['tipocuenta'] ?></option>
                                                                            <option value="Corriente">Corriente</option>
                                                                            <option value="Vista">Vista</option>
                                                                            <option value="Ahorro">Ahorro</option>   
                                                                            <option value="Chequera Electronica">Chequera Electr&oacute;nica</option>                                                                         
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label" for="quantity">N&uacute;mero Cuenta</label>
                                                                        <input class="form-control" type="text" name="cuenta" id="cuenta" placeholder="" value="<?php echo $ftrabajador['cuenta'] ?>"  />
                                                                    </div>
                                                            </div> 
                                                            
                                                     <!-- AFP  -->      
                                                           <div class="row">
                                                                     <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">AFP </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control"  style="width: 100%;" name="afp" id="afp">
                                                                            <option value="<?php echo $ftrabajador['idafp'] ?>" selected=""><?php echo $ftrabajador['afp'] ?></option>
                                                                             <?php while($row = mysqli_fetch_assoc($afps)) { 
                                                                               $afp=utf8_encode($row['afp']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idafp']; ?>"><?php echo$row['afp'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                            </div>  
                                                        
                                                        <!-- SALUD -->      
                                                             <div class="row">
                                                                     <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity">Salud</label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select class="form-control"  style="width: 100%;" name="salud" id="salud">
                                                                            <option value="<?php echo $ftrabajador['idsalud'] ?>" selected=""><?php echo $ftrabajador['institucion'] ?></option>
                                                                            <?php while($row = mysqli_fetch_assoc($salud)) { 
                                                                               $institucion=utf8_encode($row['institucion']);
                                                                             ?>                                                                                                            
                                                                    		<option value="<?php echo $row['idsalud']; ?>"><?php echo $row['institucion'] ?></option>
                                                                    		<?php } ?>
                                                                        </select>
                                                                    </div>
                                                            </div>
                                                            
                                            
                                                                                              
                                                      <hr />  
                                                   
                                                    </div>
                                                     
                                                     <input type="hidden" name="idtrabajador" id="idtrabajador" value="<?php echo $idtrabajador  ?>" />
                                                     <input type="hidden" name="idcontratista" id="idcontratista" value="<?php echo $fcontratista  ?>" />                                                     
                                                     <div style="margin-left: 2%;margin-top: 4%;" class="row">
                                                               <div class="col-md-12">
                                                                <div class="form-wrap">
                                                                 
                                                                  <?php if ($ftrabajador['estado']!=0) { ?>  
                                                                   
                                                                    <button type="button" class="btn-danger btn btn-md" name="borrar" id="borrar" onclick="eliminar(<?php echo $idtrabajador ?>,<?php echo $ftrabajador['rut'] ?>)">Desvincular</button>
                                                                    <button name="update" id="update" class="btn btn-success btn-md" type="submit" ><i class="fa fa-refresh" aria-hidden="true"></i> Actualizar Trabajador</button>
                                                                    <!--<a style="" class="btn btn-success  btn-md" href="files/<?php echo $ftrabajador['rut'] ?>/bajar.php?rut=<?php echo $ftrabajador['rut'] ?>" >Descargar Archivos</a>--> 
                                                                  <?php } ?> 
                                                                 
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                </div>
                                              </form>  