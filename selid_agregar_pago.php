<?php
session_start();
if (isset($_SESSION['usuario'])) {
   
        include('config/config.php');
        setlocale(LC_MONETARY,"es_CL");
      
        $contratista=$_GET['contratista'];
        
        $query_bancos=mysqli_query($con,"select * from bancos ");
        
        $query_contratista=mysqli_query($con,"select c.*, p.*, a.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista left join control_pagos as a On a.idcontratista=c.id_contratista where c.id_contratista='".$_GET['id']."'  ");
        $result_contratista=mysqli_fetch_array($query_contratista);
        
        $fecha='02-11-2022';
        
        #$dia_inicio=substr($result_contratista['fecha_inicio_plan'],0,2);
        #$mes_inicio=substr($result_contratista['fecha_inicio_plan'],3,2);
        #$ano_inicio=substr($result_contratista['fecha_inicio_plan'],6,4);
        
        $dia_inicio=substr($fecha,0,2);
        $mes_inicio=substr($fecha,3,2);
        $ano_inicio=substr($fecha,6,4);

        
        ?>  
        
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
  
        
    <div class="modal-body"> 
    
        
        <div class="form-group row">
            <label class="col-4 col-form-label">Fecha de pago:</label>
            <div class="col-7"><input type="date" name="fecha_pago" class="form-control" /></div>
        </div>    
        
        <div class="form-group row">
            <label class="col-4 col-form-label">Banco</label>
            <div class="col-7">
                <select class="form-control" name="banco">
                    <option value="0" selected="">Seleccionar</option>
                    <?php while($row = mysqli_fetch_assoc($query_bancos)) { 
                    $banco=utf8_encode($row['banco']);
                    ?>                                                                                                            
              		<option value="<?php echo $row['idbanco']; ?>"><?php echo $row['banco'] ?></option>
              		<?php } ?>
                </select>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-4 col-form-label">Metodo Pago</label>
            <div class="col-7">
                <select class="form-control" name="metodo_pago">
                    <option value="0" selected="">Seleccionar</option>
                    <option value="1">Flow</option>
                    <option value="2">Transferencia</option>
              		
                </select>
            </div>
        </div> 
        
        <div class="form-group row">
            <label class="col-4 col-form-label">Mes</label>
            <div class="col-7">
                <select class="form-control" name="mes_pago">
                    <option value="0" selected="">Seleccionar</option>
                    
                    <?php if ($result_contratista['plan']==2) {
                             for ($i=0;$i<=$result_contratista['total_pagos']-1;$i++) { 
                                
                                $mes_num=strval($mes_inicio)+$i;
                                if ($mes_num>12) {
                                    $mes_num=(strval($mes_inicio)+$i)-12;
                                } 
                                
                                switch ($mes_num) {
                                    case '1':$mes='Enero';break;
                                    case '2':$mes='Febrero';break;
                                    case '3':$mes='Marzo';break;
                                    case '4':$mes='Abril';break;
                                    case '5':$mes='Mayo';break;
                                    case '6':$mes='Junio';break;
                                    case '7':$mes='Julio';break;
                                    case '8':$mes='Agosto';break;
                                    case '9':$mes='Septiembre';break;
                                    case '10':$mes='Octubre';break;
                                    case '11':$mes='Noviembre';break;
                                    case '12':$mes='Diciembre';break;
                                    
                                } ?>
                             
                             <option value="<?php echo $mes_num ?>"><?php echo $mes ?></option>
                                 
                     <?php    }   
                                                            
                          } ?>
              		
                </select>
            </div>
        </div> 
        
         <div class="form-group row">
            <label class="col-4 col-form-label">Monto de pago:</label>
            <div class="col-7"><input type="text" name="monto_pago" class="form-control" /></div>
        </div> 
        
         <div class="form-group row">
            <label class="col-4 col-form-label">Observaciones:</label>
            <div class="col-7"><textarea class="form-control" rows="2"></textarea></div>
        </div> 
            
        <br />
        <div class="row">
            <table class="table" >
               
               <tbody>
                       <tr>  
                        <td > 
                             <div  style="width:80%;background:" class="fileinput fileinput-new" data-provides="fileinput">
                                 <span   class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                 <span class="fileinput-exists">Cambiar</span><input  type="file" id="carga" name="carga" accept="pdf" /></span>
                                 <span class="fileinput-filename"></span>
                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                             </div>
                       </td>
                       <td>
                            <button title="Cargar Archivo" class="ladda-button btn-success btn btn-xs " data-style="expand-right" type="button" onclick="cargar2('<?php echo $doc  ?>','<?php echo $contratista  ?>','<?php echo $com  ?>')"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                       </td>
                    </tr>
              </tbody>
           </table>
        </div>
        
        
    </div>

 <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    


    

<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
} ?>       
        