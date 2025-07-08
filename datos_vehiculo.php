                                <form action=""  method="post" id="frmTrabajador">
                            
                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox "> 

                                                <div class="row"> 
                                                                 <div class="form-group estilo col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                                                    <label  class="col-form-label" for="quantity"><strong>Fotografia</strong></label>
                                                                </div> 
                                                                <div  class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                                                    <?php if ($ftrabajador['url_foto']=="") {
                                                                        echo '<img id="imagen"  src="img/sinimagen.png" />';
                                                                     } else {
                                                                        echo '<img id="imagen" width="150" heigth="150" src="'.$ftrabajador['url_foto'].'" />';
                                                                     }   
                                                                    
                                                                    ?>
                                                                   <br />
                                                                   <br />
                                                                   <div style="background: #282828;" class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <span style="background: #282828;color:#fff;border:1px #282828 solid" class="btn btn-default btn-file"><span id="seleccionar"  class="fileinput-new ">Seleccione Imagen</span>
                                                                        <span id="cambiar" class="fileinput-exists">Cambiar</span><input  type="file" id="foto" name="foto" accept="image/jpeg,image/jpg,image/png" /></span>
                                                                        <span id="cambiar2" class="fileinput-filename"></span>
                                                                        <a id="cambiar3" title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                    </div>
                                                                    <br />
                                                                      <button  style="width: 70%;" class="btn btn-success btn-sm " name="" id="" type="button" onclick="subir_foto(<?php echo $ftrabajador['id_auto'] ?>,'<?php echo $siglas ?>')">Subir Imagen</button>
                                                                  </div>
                                                        </div>
                                                          
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>SIGLAS</b></label> 
                                                    <div class="col-10">                                       
                                                        <label style="font-weight:bold;font-size:18px;border:1px #eee solid" id="siglas" class="col-4 col-form-label"> <?php echo $siglas ?></label>
                                                        <input type="hidden" id="h_siglas" name="h_siglas" >
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>                  
                                                    </div>
                                                </div>
                                                <br><br>
                                                <!--- tipo-->
                                                <div class="row">
                                                    <label class="col-2 estilo col-form-label"><b>Tipo</b></label>                                    
                                                    <div class="col-lg-3 col-sm-12">
                                                        <select id="tipo_auto" name="tipo_auto" class="form-control bordes" onchange="on_tipo(<?php echo $contratista ?>)" >
                                                            <option value="seleccionar"><?php echo $ftrabajador['tipo'] ?></option>
                                                            <?php 
                                                                $query_tipos_autos=mysqli_query($con,"select * from tipo_autos where estado='0' ");
                                                                foreach ($query_tipos_autos as $row) {  ?>
                                                                    <option value="<?php echo $row['auto'] ?>"><?php echo $row['auto'] ?></option>
                                                                <?php } ?>
                                                        </select>    
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_tipo" class="form-label" ></span>
                                                    </div>
                                                </div>
                                                
                                                <!--- patente -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Patente</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                            <input style="text-transform: uppercase;" maxlength="8"  name="patente" id="patente" type="text" class="form-control bordes" onBlur="on_patente(<?php echo $contratista ?>)" value="<?php echo $ftrabajador['patente'] ?>"  />
                                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>
                                                    </div>
                                                    <div class="col-2">  
                                                        <?php if ($ftrabajador['patente']=="SP") { ?>                                              
                                                            <input style="margin-top:10px" name="sin_panente" id="sin_patente" type="checkbox" class="bordes" checked onclick="sel_patente(<?php echo $contratista ?>)" />&nbsp;&nbsp;&nbsp;&nbsp;Sin patente
                                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>
                                                        <?php } else { ?>
                                                            <input style="margin-top:10px" name="sin_panente" id="sin_patente" type="checkbox" class="bordes" onclick="sel_patente(<?php echo $contratista ?>)" />&nbsp;&nbsp;&nbsp;&nbsp;Sin patente
                                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>
                                                        <?php }  ?>
                                                    </div>                         
                                                </div>
                                                
                                                <!---motor -->
                                                <div style="padding-top:0.5%" class=" row">
                                                    <label class="col-2 col-form-label estilo"><b>Motor </b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="motor" id="motor" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['motor'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_motor" class="form-label" ></span>
                                                    </div>
                                                </div>
                                                
                                                <!--- chasis -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label  class="col-2 col-form-label estilo"><b>No. Chasis </b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="chasis" id="chasis" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['chasis'] ?>"  />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_chasis" class="form-label" ></span>
                                                    </div>
                                                </div>
                                                
                                                <!--- marca -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Marca</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="marca" id="marca" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['marca'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_marca" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- modelo -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Modelo</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="modelo" id="modelo" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['modelo'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_modelo" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- año -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Año</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input name="year" id="year" type="number" class="form-control bordes"  value="<?php echo $ftrabajador['year'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_year" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- color -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Color</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <select id="color" name="color" class="form-control bordes" >
                                                            <option value="seleccionar"><?php echo $ftrabajador['color'] ?></option>
                                                            <option value="BLANCO">BLANCO</option>
                                                            <option value="AZUL">AZUL</option>
                                                            <option value="AMARILLO">AMARILLO</option>
                                                            <option value="ROJO">ROJO</option>
                                                            <option value="GRIS">GRIS</option>
                                                            <option value="NEGRO">NEGRO</option>
                                                            <option value="DORADO">DORADO</option>
                                                            <option value="NARANJA">NARANJA</option>
                                                            <option value="CELESTE">CELESTE</option>
                                                            
                                                        </select>    
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_tipo" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- pasajeros -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>No. pasajeros</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input name="puestos" id="puestos" type="number" class="form-control bordes"  value="<?php echo $ftrabajador['puestos'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_pasajeros" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- revision -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Revisión técnica</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input name="revision" id="revision" type="date" class="form-control bordes"  value="<?php echo $ftrabajador['revision'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_revision" class="form-label" ></span>
                                                    </div>
                                                    <div class="col-2">
                                                            <input name="sin_revision" id="sin_revision" type="checkbox" class="bordes" onclick="sel_revision()" />&nbsp;&nbsp;&nbsp;&nbsp;N/A
                                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_revision" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <hr>

                                                <!--- propietario -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>Propietario</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="propietario" id="propietario" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['propietario'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_propietario" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- propietario -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label class="col-2 col-form-label estilo"><b>RUT</b></label>
                                                    <div class="col-lg-3 col-sm-12">
                                                        <input style="text-transform: uppercase;" name="rut_propietario" id="rut_propietario" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" oninput="checkRut(this)" class="form-control bordes" value="<?php echo $ftrabajador['rut_propietario'] ?>" />
                                                        <span style="color: #1AB394;"  id="help" class="form-label" >ingrese un RUT v&aacute;lido</span>
                                                    </div>
                                                </div>

                                                <!--- propietario -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label style="font-size:12px" class="col-2 col-form-label estilo"><b>Fono</b></label>
                                                    <div class="col-6">
                                                        <input style="text-transform: uppercase;" name="fono_propietario" id="fono_propietario" type="text" class="form-control bordes"  value="<?php echo $ftrabajador['fono_propietario'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_fono_propietario" class="form-label" ></span>
                                                    </div>
                                                </div>

                                                <!--- propietario -->
                                                <div style="padding-top:0.5%" class="row">
                                                    <label style="font-size:12px" class="col-2 col-form-label estilo"><b>Email</b></label>
                                                    <div class="col-6">
                                                        <input style="text-transform: uppercase;" name="email_propietario" id="email_propietario" type="email" class="form-control bordes"  value="<?php echo $ftrabajador['email_propietario'] ?>" />
                                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email_propietario" class="form-label" ></span>
                                                    </div>
                                                </div>
                                                
                                                <input type="hidden" name="contratista" value="<?php echo $_SESSION['contratista'] ?>" />
                                                <input type="hidden" name="mandante" value="<?php echo $_SESSION['mandante'] ?>" />                                            
                                                <input type="hidden" name="vehiculo"  value="<?php echo $idtrabajador  ?>" />  
                                                <input type="hidden" name="control"  value="<?php echo $ftrabajador['control']  ?>" />                                                    
                                                <input type="hidden" name="siglas"  value="<?php echo $ftrabajador['siglas']  ?>" />
                                                <input type="hidden" name="tipo"  value="<?php echo $ftrabajador['tipo']  ?>" />
                                                                                              
                                                <hr />  
                                                   
                                                    </div>
                                                                            
                                                     <div style="margin-left: 2%;margin-top: 4%;" class="row">
                                                               <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button title="Actualizar" name="update" id="update" class="btn btn-success btn-md" type="button" onclick="editar_vehiculo(<?php echo $idtrabajador ?>)" >ACTUALIZAR INFORMACI&Oacute;N DEL VEHICULO</strong></button>
                                                                
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                </div>
                                              </form>  
                                              
                                              