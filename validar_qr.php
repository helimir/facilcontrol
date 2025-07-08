<?php
session_start();
include('config/config.php');
$query=mysqli_query($con,"select a.url_foto, m.id_mandante, t.nombre1, t.apellido1, t.rut, a.codigo, a.url_foto, a.validez, r.cargo as cargo_t, m.razon_social as nom_mandante, c.razon_social as nom_contratista, o.nombre_contrato from trabajadores_acreditados as a Left join contratos as o On o.id_contrato=a.contrato Left Join contratistas as c On c.id_contratista=a.contratista Left Join mandantes as m On m.id_mandante=a.mandante Left Join trabajador as t On t.idtrabajador=a.trabajador Left Join cargos as r On r.idcargo=a.cargo  where a.codigo='".$_GET['codigo']."' ");
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
</head>
<body >


<?php $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/mobile/i", $useragent) ) { ?>
         <div style="width:100%" id="wrapper">
            <div   id="page-wrapper" class="gray-bg">
               <div  class="wrapper wrapper-content animated fadeIn">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="ibox ">

                                 <div class="ibox-title">                                            
                                       <div class="form-group row">
                                          <div style="text-align:center;font-weight:7" class="col-lg-12 col-sm-12 col-sm-offset-2">
                                             <h3>Información del Trabajador</h3>
                                          </div>
                                       </div> 
                                 </div>
                                       
                                       
                           <div class="ibox-content">
                              <div class="row">
                                 <div class="col-lg-12">
                           
                                       <div style="position:relative;" class="row">
                                          <div class="col-12" >
                                             <img width="100%" heigth="30%" src="img/credencial_nueva.jpeg">
                                          </div> 
                                          <div style="position: absolute;margin-top:7%;margin-left:22%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000"><?php echo $result['nom_contratista'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:3%;margin-left:70%" class="col-12" >
                                             <img width="22%"  src="<?php echo $result['url_foto'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:15%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:20.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['nom_mandante'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:25.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['cargo_t'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:30.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['nombre1'].' '.$result['apellido1'] ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:35.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['rut']  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:41%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:9px;color:#000;font-weight:500"><?php echo $result['validez']  ?></label>
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
	<?php } else {  ?>       
      <div style="width:100%" id="wrapper">
            <div   id="page-wrapper" class="gray-bg">
               <div  class="wrapper wrapper-content animated fadeIn">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="ibox ">

                                 <div class="ibox-title">                                            
                                       <div class="form-group row">
                                          <div style="text-align:center;font-weight:7" class="col-lg-12 col-sm-12 col-sm-offset-2">
                                             <h3>Información del Trabajador</h3>
                                          </div>
                                       </div> 
                                 </div>
                                       
                                       
                           <div class="ibox-content">
                              <div class="row">
                                 <div class="col-lg-12">
                           
                                       <div style="position:relative;" class="row">
                                          <div class="col-12" >
                                             <img width="100%" heigth="30%" src="img/credencial_nueva.jpeg">
                                          </div> 
                                          <div style="position: absolute;margin-top:8%;margin-left:22%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:12px;color:#000"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:4%;margin-left:70%" class="col-12" >
                                             <img width="22%"  src="<?php echo $result['url_foto'] ?>"> 
                                          </div> 
                                          <div style="position: absolute;margin-top:16%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['nombre_contrato'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:21%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['nom_mandante'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:26.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['nom_cargo'] ?></label>
                                             </div> 
                                          </div>
                                          <div style="position: absolute;margin-top:32%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['nombre1'].' '.$result['apellido1'] ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:37.5%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['rut']  ?></label>
                                             </div> 
                                       </div>
                                       <div style="position: absolute;margin-top:43%;margin-left:20%" class="row">
                                             <div class="col-12" >
                                                <label style="font-size:10px;color:#000;font-weight:500"><?php echo $result['validez']  ?></label>
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


              