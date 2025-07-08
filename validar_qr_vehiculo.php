<?php
session_start();
include('config/config.php');
$query=mysqli_query($con,"select c.contrato,  c.url_foto, c.codigo, n.nombre_contrato, o.razon_social as nom_contratista, m.razon_social as nom_mandante, m.logo, a.tipo, a.marca, a.modelo, a.color, a.patente from autos as a Left Join vehiculos_acreditados as c On c.vehiculo=a.id_auto Left join contratistas as o On o.id_contratista=c.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratos as n On id_contrato=c.contrato where c.codigo='".$_GET['codigo']."' ");
$result=mysqli_fetch_array($query);

if ($result['fecha']=='0000-00-00') {
    $fecha='Indefinido';
} else {
    $fecha=$result['fecha'];
}
?>
<!DOCTYPE html>
   <meta name="google" content="notranslate" />
   <html lang="es-ES">

   <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title>FacilControl | Validar QR</title>
            
      <link href="css\bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
      <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
      <link href="css\animate.css" rel="stylesheet">
      <link href="css\style.css?n=1" rel="stylesheet">

      <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
      
      <meta http-equiv='cache-control' content='no-cache'>
      <meta http-equiv='expires' content='0'>
      <meta http-equiv='pragma' content='no-cache'>

      <style>

         .fuente {
            font-size:25px;
            color:#000;
            font-weight:700
         }

        @media (max-width: 768px) {
            .fuente {
               font-size: 8px;
            }
         }

      </style>

</head>
<body >


<?php $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/mobile/i", $useragent) ) { 
      
      $codigo1=substr($result['codigo'],0,3);
      $codigo2=substr($result['codigo'],-3);
         ?>

            <style>

            .fuente {
               font-size:7px;
               color:#000;
               font-weight:700
            }
            </style>

         <div style="width:100%" id="wrapper">
            <div   id="page-wrapper" class="gray-bg">
               <div  class="wrapper wrapper-content animated fadeIn">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="ibox ">

                                 <div class="ibox-title">                                            
                                       <div class="form-group row">
                                          <div style="text-align:center;font-weight:700;color:#292929" class="col-lg-12 col-sm-12 col-sm-offset-2">
                                             <h3>Información del Vehículo/Maquinaria</h3>
                                          </div>
                                       </div> 
                                 </div>
                                       
                                       
                           <div class="ibox-content">
                              <div class="row">
                                 <div class="col-lg-12">
                           
                                 <div style="position:relative;" class="row">
                                          <div class="col-12" >
                                             <img width="100%" heigth="30%" src="img/credencial_vehiculo.png">
                                          </div> 
                                          <div style="position: absolute;margin-top:6%;margin-left:22%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_contratista'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:3%;margin-left:65%" class="col-12" >
                                             <img width="22%"  src="<?php echo $result['url_foto'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:3%;margin-left:3%" class="col-12" >
                                             <img width="15%"  src="<?php echo $result['logo'] ?>"> 
                                          </div>
                                          <div style="position: absolute;margin-top:13%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:17%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_mandante'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:22%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['tipo'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:26%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['marca'].' '.$result['modelo'] ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:31%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['color']  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:36%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['patente']  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:50%;margin-left:30%" class="row">
                                             <div class="col-12" >
                                                <label style=font-size:20px class="fuente"><?php echo $codigo1  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:50%;margin-left:50%" class="row">
                                             <div class="col-12" >
                                                <label style=font-size:20px class="fuente"><?php echo $codigo2  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:29%;margin-left:70%;color:#fff" class="row">
                                             <div class="col-12" >
                                                   <img width="50%" src="img/qr/vehiculos/<?php echo $result['patente']  ?>/qr_<?php echo $result['contrato']  ?>_<?php echo $result['patente']  ?>.png" >
                                             </div> 
                                       </div>

                                    </div>     

                                 </div>
                              </div>
                           </div>
                     </div>               
                  </div>                  
               </div>
            </div>
         </div>
	<?php } else {        

      $codigo1=substr($result['codigo'],0,3);
      $codigo2=substr($result['codigo'],-3);
         ?>

            <style>

            .fuente {
               font-size:25px;
               color:#000;
               font-weight:700
            }
            </style>

         <div style="width:100%" id="wrapper">
            <div   id="page-wrapper" class="gray-bg">
               <div  class="wrapper wrapper-content animated fadeIn">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="ibox ">

                                 <div class="ibox-title">                                            
                                       <div class="form-group row">
                                          <div style="text-align:center;font-weight:700;color:#292929" class="col-lg-12 col-sm-12 col-sm-offset-2">
                                             <h3>Información del Vehículo/Maquinaria</h3>
                                          </div>
                                       </div> 
                                 </div>
                                       
                                       
                           <div class="ibox-content">
                              <div class="row">
                                 <div class="col-lg-12">
                           
                                 <div style="position:relative;" class="row">
                                          <div class="col-12" >
                                             <img width="100%" heigth="30%" src="img/credencial_vehiculo.png">
                                          </div> 
                                          <div style="position: absolute;margin-top:9%;margin-left:22%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_contratista'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:3%;margin-left:70%" class="col-12" >
                                             <img width="20%"  src="<?php echo $result['url_foto'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:16%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:21%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['nom_mandante'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:26%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['tipo'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:31%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['marca'].' '.$result['modelo'] ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:36%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['color']  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:41%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label class="fuente"><?php echo $result['patente']  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:53%;margin-left:32%;" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:80px;color:#fff" class="fuente"><?php echo $codigo1  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:53%;margin-left:54%;color:#fff" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:80px;color:#fff" class="fuente"><?php echo $codigo2  ?></label>
                                             </div> 
                                       </div>

                                       <div style="position: absolute;margin-top:28%;margin-left:72%;color:#fff" class="row">
                                             <div class="col-12" >
                                                   <img width="63%" src="img/qr/vehiculos/<?php echo $result['patente']  ?>/qr_<?php echo $result['contrato']  ?>_<?php echo $result['patente']  ?>.png" > >
                                             </div> 
                                       </div>
                                    </div>     

                                 </div>
                              </div>
                           </div>
                     </div>               
                  </div>                  
               </div>
            </div>
         </div>
  <?php }   ?>

<body>


              