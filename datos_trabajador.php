                                <form action=""  method="post" id="frmTrabajador">
                            
                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox "> 
                                                          
                                                       <!-- id trabajador -->
                                                       <div class="row"> 
                                                                 <div class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                    <label  class="col-form-label" for="quantity"><strong>Id Trabajador</strong> </label> 
                                                                </div> 
                                                                <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                    <label style="font-size:18px"  class="col-form-label" for="quantity"><strong><?php echo $ftrabajador['idtrabajador'] ?></strong> </label> 
                                                                </div>
                                                        </div>
                                                        
                                                        <div class="row"> 
                                                                 <div class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                                    <label  class="col-form-label" for="quantity"><strong>Fotografia</strong></label>
                                                                </div> 
                                                                <div  class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                    <?php if ($ftrabajador['url_foto']=="") {
                                                                        echo '<img src="img/sinimagen.png" />';
                                                                     } else {
                                                                        echo '<img width="150" heigth="150" src="'.$ftrabajador['url_foto'].'" />';
                                                                     }   
                                                                    
                                                                    ?>
                                                                   <br />
                                                                   <br />
                                                                   <div   class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <span style="background: #282828;color:#fff" class="btn btn-default btn-file"><span  class="fileinput-new ">Seleccione Imagen</span>
                                                                        <span class="fileinput-exists">Cambiar</span><input  type="file" id="foto_t" name="foto_" accept="image/jpeg,image/jpg,image/png" /></span>
                                                                        <span class="fileinput-filename"></span>
                                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <br />
                                                                      <button  style="width: 70%;" class="btn btn-success btn-sm " name="" id="" type="button" onclick="subir_foto(<?php echo $ftrabajador['contratista'] ?>)">Subir Imagen</button>
                                                                  </div>
                                                        </div>

                                                       <!-- <div class="row">
                                                            <div class="col-lg-2 col-md-2 col-sm-2 "> 
                                                            <label  class="col-form-label" for="quantity">&nbsp;</label>
                                                            </div>
                                                            <div class="col-lg-10 col-md-10 col-sm-10 ">  
                                                                <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> La imagen deber ser tomada con fondo claro y de forma vertical desde la aplicacion WhatsApp.</label>
                                                            </div>
                                                        </div>  -->
                                                        
                                                        
                                                        <hr />
                                                       
                                                        <!-- rut  --> 
                                                        <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>RUT</strong></label> 
                                                            </div> 
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                <label style="font-size:18px;"  class="col-form-label" for="quantity"><strong><?php echo $ftrabajador['rut'] ?></strong> </label> 
                                                            </div>
                                                         </div>
                                                        <hr />
                                                        
                                                        <!-- 1 nombre -->
                                                        <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>1er. Nombre</strong> <span style="color: #FF0000;">*</span></label> 
                                                            </div>          
                                                            
                                                            <div  class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="nombre1" id="nombre1" placeholder="" value="<?php echo $ftrabajador['nombre1'] ?>"  required="">
                                                            </div>
                                                         </div>
                                                        
                                                        <!-- 2 nombre  --> 
                                                        <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>2do. Nombre</strong> </label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="nombre2" id="nombre2" placeholder="" value="<?php echo $ftrabajador['nombre2'] ?>"  />
                                                            </div>
                                                         </div> 
                                                        
                                                        <!-- 1 apellido --> 
                                                        <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>1er. Apellido</strong> <span style="color: #FF0000;">*</span></label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="apellido1" id="apellido1" placeholder="" value="<?php echo  $ftrabajador['apellido1'] ?>"  required=""/>
                                                            </div>
                                                         </div> 
                                                        
                                                        <!-- 2 apellido --> 
                                                         <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>2do. Apellido</strong> </label> 
                                                            </div>          
                                                            
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="apellido2" id="apellido2" placeholder="" value="<?php echo $ftrabajador['apellido2'] ?>" />
                                                            </div>                                
                                                         </div> 
                                                        <hr />
                                                        
                                                        <!-- direccion -->
                                                        <div class="row"> 
                                                             <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong> Direcci&oacute;n</strong> <span style="color: #FF0000;">*</span></label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="direccion1" id="direccion1" placeholder="Calle" value="<?php echo $ftrabajador['direccion1'] ?>"  required=""/>
                                                            </div>                                               
                                                         </div>
                                                        
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"></label> 
                                                            </div>
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-2">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="direccion2" id="direccion2" placeholder="No. casa/Dpto " value="<?php echo $ftrabajador['direccion2'] ?>"  required=""/>
                                                            </div>                                                        
                                                         </div>
                                                        
                                                        <!-- region  --> 
                                                        <div class="row"> 
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong></strong> </label> 
                                                            </div>         
                                                             <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                   <div class="form-wrap">
                                                                        <select style="border:1px #c0c0c0 solid" name="region" id="region" class="form-control">
                                                                                
                                                                            <?php if (empty($ftrabajador['Region'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['region'] ?>" selected="">Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['region'] ?>" selected=""><?php echo utf8_encode($ftrabajador['Region'])  ?></option>
                                                                            <?php
                                                                            }  ?>
                                                                            <?php 
                                                                            while($row = mysqli_fetch_assoc($regiones)) { 
                                                                                        $region=utf8_encode($row['Region']);
                                                                                         ?>                                                                                                            
                                                                    					<option value="<?php echo $row['IdRegion']; ?>"><?php echo $row['Region'] ?></option>
                                                                    	    <?php 
                                                                            } ?>
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
                                                                        <select style="border:1px #c0c0c0 solid" name="comuna" id="comuna" class="form-control">                                                                            
                                                                            <?php if (empty($ftrabajador['Comuna'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['comuna'] ?>" selected="">Seleccionar Comuna</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['comuna'] ?>" selected=""><?php echo $ftrabajador['Comuna']  ?></option>
                                                                            <?php
                                                                            }  ?>
                                                                         </select>   
                                                                    </div>
                                                                </div>              
                                                       </div> 
                                                      <hr />  
                                                       
                                                       <!-- estado civil  -->
                                                        <div class="row">    
                                                            <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>Estado Civil </strong> <span style="color: #FF0000;">*</span></label> 
                                                            </div>  
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control" style="width: 100%;" name="estadocivil" id="estadocivil">
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
                                                            <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>Email</strong> <span style="color: #FF0000;">*</span></label> 
                                                            </div>         
                                                            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="email" name="email" id="email" placeholder="" value="<?php echo $ftrabajador['email'] ?>"   />                               
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- telefono -->
                                                        <div class="row">   
                                                            <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>Telefono</strong>  </label> 
                                                            </div>    
                                                           <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                                    <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="telefono" id="telefono" placeholder="" value="<?php echo $ftrabajador['telefono'] ?>"  />
                                                            </div>
                                                        </div>    
                                                       
                                                       <!-- fecha nacimiento -->
                                                       <div class="row">   
                                                            <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>Fecha Nac.</strong>  </label> 
                                                            </div>                    
                                                             <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                  <label class="col-form-label font-bold" for="quantity">D&iacute;a</label>
                                                                  <select style="border:1px #c0c0c0 solid" class="form-control" name="dia">                                                                                                       
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
                                                                         <label class="col-form-label font-bold" for="quantity">Mes</label>
                                                                         <select style="border:1px #c0c0c0 solid" class="form-control"  name="mes">
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
                                                                        <label class="col-form-label font-bold" for="quantity">A&ntilde;o</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control" name="ano">
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
                                                                   <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity"><strong>Tallas</strong> </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Pantalon</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="tpantalon" id="tpantalon">
                                                                            <option value="<?php echo $ftrabajador['tpantalon'] ?>" selected=""><?php echo $ftrabajador['tpantalon'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                   <div class="form-group  col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Poleras</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="tpolera" id="tpolera">
                                                                            <option value="<?php echo $ftrabajador['tpolera'] ?>" selected=""><?php echo $ftrabajador['tpolera'] ?></option>                                                                                                                                                                                      
                                                                    		<option value="S">S</option>
                                                                            <option value="M">M</option>
                                                                            <option value="L">L</option>
                                                                            <option value="XL">XL</option>
                                                                            <option value="XXL">XXL</option>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label font-bold" for="quantity">Zapatos</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="tzapatos" id="tzapatos">
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
                                                            <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                <label class="col-form-label" for="quantity"><strong>Conductor</strong> </label> 
                                                            </div>   
                                                            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                 
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="licencia" id="licencia" onchange="ShowSelected()">                                                                             
                                                                            <?php if (empty($ftrabajador['licencia'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['licencia'] ?>">Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['licencia'] ?>"><?php echo $ftrabajador['licencia'] ?></option>
                                                                            <?php
                                                                            }  ?>
                                                                            <option value="NO">NO</option>
                                                                            <option value="SI">SI</option>                                            
                                                                        </select>                                             
                                                            </div>            
                                                            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-2">            
                                                                     <?php  if ($ftrabajador['licencia']=="SI") {
                                                                                ?>  
                                                                                <select style="border:1px #c0c0c0 solid" class="form-control" style="width: 100%;" name="tipolicencia" id="tipolicencia" >
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
                                                                                    <select style="border:1px #c0c0c0 solid" class="form-control" style="width: 100%;" name="tipolicencia" id="tipolicencia" disabled="" >
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
                                                                    <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity"><strong>Banco</strong>  </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Entidad</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="banco" id="banco">
                                                                            
                                                                            <?php if (empty($ftrabajador['idbanco'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['idbanco'] ?>" selected="">Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['idbanco'] ?>" selected=""><?php echo $ftrabajador['banco'] ?></option>
                                                                            <?php
                                                                            }  ?>
                                                                            <?php 
                                                                            while($row = mysqli_fetch_assoc($bancos)) { 
                                                                               $banco=utf8_encode($row['banco']); ?>                                                                                                            
                                                                    		        <option value="<?php echo $row['idbanco']; ?>"><?php echo $row['banco'] ?></option>
                                                                    		<?php 
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">Tipo Cuenta</label>
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="tipocuenta" id="tipocuenta">                                                                            
                                                                            <?php if (empty($ftrabajador['tipocuenta'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['tipocuenta'] ?>" selected="">Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['tipocuenta'] ?>" selected=""><?php echo $ftrabajador['tipocuenta'] ?></option>
                                                                            <?php
                                                                            }  ?>
                                                                            <option value="Corriente">Corriente</option>
                                                                            <option value="Vista">Vista</option>
                                                                            <option value="Ahorro">Ahorro</option>   
                                                                            <option value="Chequera Electronica">Chequera Electr&oacute;nica</option>                                                                         
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <label class="col-form-label font-bold" for="quantity">N&uacute;mero Cuenta</label>
                                                                        <input style="border:1px #c0c0c0 solid" class="form-control" type="text" name="cuenta" id="cuenta" placeholder="" value="<?php echo $ftrabajador['cuenta'] ?>"  />
                                                                    </div>
                                                            </div> 
                                                            
                                                     <!-- AFP  -->      
                                                           <div class="row">
                                                                     <div class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity"><strong>AFP</strong>  </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="afp" id="afp">                                                                            
                                                                            <?php if (empty($ftrabajador['idafp'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['idafp'] ?>" selected="">Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['idafp'] ?>" selected=""><?php echo $ftrabajador['afp'] ?></option>
                                                                            <?php
                                                                            }  ?>
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
                                                                     <div  class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                                        <label class="col-form-label" for="quantity"><strong>Salud</strong> </label> 
                                                                    </div>    
                                                                   <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                        <select style="border:1px #c0c0c0 solid" class="form-control"  style="width: 100%;" name="salud" id="salud">
                                                                            <?php if (empty($ftrabajador['idsalud'])) { ?>
                                                                                <option value="<?php echo $ftrabajador['idsalud'] ?>" selected="" ?>Seleccionar</option>
                                                                            <?php 
                                                                            } else { ?>
                                                                                <option value="<?php echo $ftrabajador['idsalud'] ?>" selected=""><?php echo $ftrabajador['institucion'] ?></option>
                                                                            <?php
                                                                            }  ?>

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
                                                     <input type="hidden" name="rut_t" id="rut_t" value="<?php echo $ftrabajador['rut']  ?>" />
                                                     
                                                     <input type="hidden" name="accion" id="accion" value="editar" />                                                     
                                                     <div style="margin-top: 4%;" class="row">
                                                               <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <!--<button type="button" class="btn-danger btn btn-md" name="borrar" id="borrar" onclick="eliminar(<?php echo $idtrabajador ?>,<?php echo $ftrabajador['rut'] ?>)">Desvincular</button>-->
                                                                    <button title="Actualizar" name="update" id="update" class="btn btn-success btn-lg" type="button" onclick="editar(<?php echo $ftrabajador['contratista'] ?>)" ><strong>ACTUALIZAR INFORMACI&Oacute;N DEL TRABAJADOR</strong></button>
                                                                
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                </div>
                                              </form>  
                                              
                                              