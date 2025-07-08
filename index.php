<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Facil Control | Inicio</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Sweet Alert -->
  <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />

  <script src="js\jquery-3.1.1.min.js"></script>
  
  <!-- Sweet alert -->
  <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

  <!-- =======================================================
  * Template Name: Gp
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <script>

function isNumber(evt) {
  let charCode = evt.which;

  if (charCode < 48 || charCode > 57) {
    return false;
  }

  return true;
}

    $(document).ready(function(){
            
        $("#region").change(function () {				
            $("#region option:selected").each(function () {
              IdRegion = $(this).val();
              $.post("comunas.php", { IdRegion: IdRegion }, function(data){
                $("#comuna").html(data);
              });            
            });
          })
                  
                  $("#contrato").change(function () {				
            $("#contrato option:selected").each(function () {
              id= $(this).val();
              $.post("cargos.php", { id: id }, function(data){
                $("#cargo").html(data);
              });            
            });
          });

        
    });

    function enviar() {
      var nombre=$('#nombre').val();
      var email=$('#email').val();
      var empresa=$('#empresa').val();
      var telefono=$('#telefono').val();
      var tipo=$('#tipo').val();
      var trabajadores=$('#trabajadores').val();
      var tamano=telefono.length;

      if (nombre=="" || email=="" || empresa=="" || telefono=="" || tipo=="0" || trabajadores=="0") {
        swal("Todos los campos del formulario son requeridos", "", "warning"); 
      } else {
        if (tamano<8) {
          swal("Faltan numeros en el telefono", "", "warning"); 
        } else {        
          $.ajax({             
                  method: "POST",
                  url: "add/solicitar_demo.php",
                  data:'nombre='+nombre+'&email='+email+'&empresa='+empresa+'&telefono='+telefono+'&tipo='+tipo+'&trabajadores='+trabajadores,
                  success: function(data){
                    if (data==0) {
                      $("#enviado").show();
                      $("#cargando").hide();
                      $("#error").hide();
                    }  
                    if (data==1) {
                      $("#enviado").hide();
                      $("#cargando").hide();
                      $("#error").show();

                    }
                    if (data==2) {
                      $("#enviado").hide();
                      $("#cargando").hide();
                      $("#error").show();

                    }
                }
            });
        }
      }
    }

  </script>

  <style>
.boton {
  color:#fff;
  background:#05D3BF;
}

.boton:hover {
  background:#05023A;
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
        /**box-shadow: 2px 2px 3px #999;**/
        z-index:100;
    };
    .my-floatm1{
        margin-top:12px;
    };

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
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        /**box-shadow: 2px 2px 3px #999;**/
        z-index:100;
    };
    
    .my-float{
        margin-top:14px;
    }

    .whatsapp {
    position:fixed;
    width:60px;
    height:60px;
    bottom:65px;
    right:25px;
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

</head>

<?php $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match("/mobile/i", $useragent) ) { ?>
         <a title="Soporte Tecnico Facil Control" href="https://api.whatsapp.com/send?phone=56936450940&text=Hola, para mas informacion," class="whatsapp" target="_blank"><img src="assets/img/ws.png" class="img-fluid"></span></a>
        
	<?php } else {  ?>       
       <a title="Soporte Tecnico Facil Control" href="https://web.whatsapp.com/send?phone=56936450940&text=Hola, para mas informacion," class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><img src="assets/img/ws.png" class="img-fluid"></a>
<?php }   ?>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">

      
     <!--<h1 class="logo me-auto me-lg-0"><a href="index.html">Gp<span>.</span></a></h1>-->
     <a href="index.php" class="logo me-auto me-lg-0"><img   src="assets/img/logo_2.png" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
          <li><a class="nav-link scrollto" href="#acerca">Acerca De</a></li>
          <li><a class="nav-link scrollto" href="#services">Servicios</a></li>
          <li><a class="nav-link scrollto" href="#clientes">Clientes</a></li>
          <li><a class="nav-link scrollto " href="#beneficios">Beneficios</a></li>
          <li><a class="nav-link scrollto " href="#precios">Precios</a></li> 
          <li><a class="nav-link scrollto " href="admin.php" target="_black">Sistema</a></li>
          <!--<li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li>-->
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="#contact" class="get-started-btn scrollto">Solicita aqu&iacute; una demostración</a>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center justify-content-center">
    <div style="margin-top:-8%" class="container" data-aos="fade-up">

      <!--<div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-10 col-lg-10">
          <h1>Gestor de documentaci&oacute;n<br>para<span> empresas.</span></h1>
          <h2>El Software que brida seguridad a  tus documentos.</h2>
        </div>
      </div>-->

      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
        
        <div class="col-xl-12 col-md-12">
          <div class="icon-box">
          <i class="fa fa-file-text" aria-hidden="true"></i>
            <h2 style="color:#fff">&iquest;Tus contratistas tienen toda la documentación laboral de sus trabajadores al d&iacute;a?</h2>
          </div>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="icon-box">
            <i class="fa fa-archive" aria-hidden="true"></i>
            <h2 style="color:#fff">&iquest;Si se accidenta un trabajador tienes certeza de que est&aacute; su documentaci&oacute;n correctamente firmada y respaldada?</h2>
          </div>
        </div>
        <div class="col-xl-12 col-md-12">
          <div class="icon-box">
            <i class="fa fa-address-card" aria-hidden="true"></i>
            <h2 style="color:#fff">&iquest;Sabes con exactitud  quien esta entrando a trabajar a tus instalaciones?</h2>
          </div>
        </div>
        
        <div style="margin-top:2%" class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
            <div class="col-xl-12 col-lg-12">
              <h2><u>Si dudas en alguna de esas preguntas es porque</u></h2>
              <h1>Debes utilizar<span> Facil Control</span></h1>
            </div>
        </div>

        <!--<div class="col-xl-2 col-md-4">
          <div class="icon-box">
          <i class="fa fa-user-circle" aria-hidden="true"></i>
            <h3><a href="#clientes">Clientes</a></h3>
          </div>
        </div>
        <div class="col-xl-2 col-md-4">
          <div class="icon-box">
            <i class="ri-calendar-todo-line"></i>
            <h3><a href="#precios">Precios</a></h3>
          </div>
        </div>-->
        
      </div>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section 
    <section style="margin-top: 4%;" id="acerca" class="about">
     
     <div class="container" data-aos="fade-up">    
       
         <div class="section-title">
           <h2>Facil Control</h2>
         </div>        
       
         <div style="background-color: #FFC451;color:#282828;padding: 2%;border-radius: 6px;font-weight: 700;" class="row">
           <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/pq1.png" class="img-fluid" alt=""></div>
           <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
               <p style="font-size:18px">Si crees que la documentaci&oacute;n  de seguridad de tu empresa no est&aacute; 100% en orden es porque NO lo est&aacute;. F&aacute;cil control es un software que permite que mantengas  todo el control  de quien entra a tus instalaciones como si fueras una gran empresa pero a un m&iacute;nimo costo. Nuestro servicio es accesible para todo  tama&ntilde;o de empresas y ajustable  a todo rubro.<br>&nbsp;</p>
           </div>
         </div>

         <div style="margin-top: 2%;background-color: #FFC451;color:#282828;padding: 2%;border-radius: 6px;font-weight: 700;" class="row">
           <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/pq2.png" class="img-fluid" alt=""></div>
           <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
           <p style="font-size:18px">&iquest;Sabes con exactitud  quien esta entrando a trabajar a tus instalaciones? F&aacute;cil  control te permite acreditar y certificar que todo el que entre a tus dependencias cuente con toda la documentaci&oacute;n legal al d&iacute;a  ya que todo lo que ocurre en tus instalaciones es legalmente tu responsabilidad.<br>&nbsp;</p>
           </div>
         </div>

         <div style="margin-top: 2%;background-color: #FFC451;color:#282828;padding: 2%;border-radius: 6px;font-weight: 700;" class="row">
           <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/pq3.png" class="img-fluid" alt=""></div>
           <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
           <p style="font-size:18px">
           &iquest;Si un trabajador de una contratista te denuncia a la inspecci&oacute;n del trabajo tienes toda la documentaci&oacute;n  en orden? F&aacute;cil control te permite ordenar y respaldar toda la documentaci&oacute;n  de quien accede a tus instalaciones de manera profesional d&aacute;ndote la tranquilidad  que necesitas para que te concentres en tus operaciones.<br>&nbsp;
           </p>
           </div>
         </div>       
       <br>
       <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita una demostración</strong></a>
     </div>
     <hr>
   </section>-->
    
    <!-- ======= About Section ======= -->
    <section style="margin-top:" id="acerca" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="assets/img/acerca1.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
            <h3>Acerca de Facil Control.</h3>
            
            <ul style="font-size:18px">
              <li><i class="ri-check-double-line"></i><strong>Facil Control</strong> es una <strong>Software</strong> que permite que todo tama&ntilde;o de empresas pueda incorporar herramientas de <strong>gesti&oacute;n de prevenci&oacute;n de riesgos y control laboral</strong> que hasta ahora estaban disponibles solo para la gran industria.</li>
              <li><i class="ri-check-double-line"></i><strong>Facil Control</strong> permite la <strong>creaci&oacute;n de credenciales</strong> para todo trabajador que deba ingresar a tu obra, instalaciones o campo. Estas credenciales son verificables on line y garantizan que el trabajador tiene toda la documentaci&oacute;n de seguridad al d&iacute;a.</li>
            </ul>
            <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita aqu&iacute; una demostración</strong></a>
            </div>
            <!--<a class="cta-btn" href="#">Call To Action</a>-->
          </div>
        </div>

      </div>
    </section>

    <!-- ======= About Section ======= -->
    <section style="margin-top: -4%;" id="" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="image col-lg-6"  data-aos="fade-right"><img src="assets/img/ley20123.png" class="img-fluid" alt=""></div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
            <h3>Fundamentos Legales.</h3>
            <br>
            <p style="font-size:18px">
                La <a href="https://www.bcn.cl/leychile/navegar?idNorma=254080" target="_blank">Ley 20.123</a> es la que regula la subcontrataci&oacute;n en Chile. <strong>Esta <a href="https://www.bcn.cl/leychile/navegar?idNorma=254080" target="_blank">Ley</a> hace responsable de forma subsidiaria a la empresa mandante
                aunque el trabajador est&eacute; contratado por otra raz&oacute;n social</strong> si es que est&eacute; presta servicios en tus instalaciones. Esta <strong><a href="https://www.bcn.cl/leychile/navegar?idNorma=254080" target="_blank">Ley</a></strong> faculta al mandante para solicitar y verificar si un trabajador cuenta con toda
                la documentaci&oacute;n en regla y faculta para retener estados de pagos si es que el contratista no est&aacute; cumpliendo sus obligaciones.<br>
                &iquest;Estas usando las facultades que te otorga la ley o solo estas siendo v&iacute;ctima de las obligaciones?

            </p>
            <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita aqu&iacute; una demostración</strong></a>
            </div>
          </div>
        </div>

      </div>
    </section>


     <!-- ======= About Section ======= -->
     <section style="margin-top: -4%;" id="services" class="about">
     
      <div class="container" data-aos="fade-up">    
        
          <div class="section-title">
           
            <p style="font-size:26px;text-align:center">&iquest;A&uacuten gestionas la documentaci&oacute;n por correos electr&oacute;nicos?</p>
          </div>        
        
          <div style="background-color: #0F316F;color:#fff;padding: 2%;border-radius: 6px;" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/serv1.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
                <p style="font-size:18px"><strong>Facil Control</strong> agiliza la gesti&oacute;n entre la empresa mandante y sus contratistas de solicitud y <strong>entrega de documentaci&oacute;n laboral</strong>. <strong>Facil Control</strong> 
                 gestiona la documentaci&oacute;n ya sea de la empresa contratista o de los trabajadores. Es as&iacute; que <strong>Facil Control</strong> acredita empresas de servicios y a sus trabajadores dejando respaldos con 100% de trazabiliadad.<br>&nbsp;</p>
            </div>
          </div>

          <div style="margin-top: 2%;background-color: #0F316F;color:#fff;padding: 2%;border-radius: 6px;" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/serv2.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
            <p style="font-size:18px"><strong>Facil Control</strong> estandariza y <strong>garantiza la entrega de los documentos</strong> que se solicitan a las empresas contratistas. Ademas <strong>se pueden crear perfiles
               de cargos seg&uacute;n riesgo</strong> o exposici&oacute;n para que as&iacute; las empresas mandantes queden 100% cubiertos en caso de una accidente o contigencia laboral.<br>&nbsp;</p>
            </div>
          </div>

          <div style="margin-top: 2%;background-color: #0F316F;color:#fff;padding: 2%;border-radius: 6px;" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/serv3.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
            <p style="font-size:18px">
              Al momento de ocurrir un accidente o una denuncia a la direcci&oacute;n del trabajo todo el mundo corre para juntar documentaci&oacute;n para no sufrir multas por incumplimientos. <strong>Facil Control garantiza el orden y respaldo de la documentaci&oacute;n</strong>
              mediante sus sistema de generaci&oacute;n de respaldo y creaci&oacute;n de credenciales de acreditaci&oacute;n.<br>&nbsp;
            </p>
            </div>
          </div>

          <div style="margin-top: 2%;background-color: #0F316F;color:#fff;padding: 2%;border-radius: 6px;" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/serv4.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-left" data-aos-delay="100">
            <p style="font-size:18px"><strong>Facil Control permite a la empresas contratistas ordenar toda la documentaci&oacute;n legal y de seguridad de sus trabajadores</strong>. Esto le permite a la empresa de servicios acceder m&aacute;s f&aacute;cil a nuevos clientes
              facilitando la gesti&oacute;n y entrega de los antecedentes reuqeridos por las empresas mandantes. <strong>Facil Control acerca a la empresa a una software que hasta ahora estaba disponible para grandes empresas.<br>&nbsp;</strong>
            </p>
            </div>
          </div>

                
        
        <br>
        <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita aqu&iacute; una demostración</strong></a>
      </div>
    </section>

    
    <!-- ======= Services Section ======= -->
    <section style="margin-top: -4%;" id="clientes" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
        <p style="font-size:26px;text-align:center">&iquest;A quien va dirigido Facil Control?</p>
        </div> 

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            
            <div style="background: #8AEDE2;color:#000;border: 4px #05D3BF solid" class="icon-box">
              <h2><strong>Mandante</strong></h2>
              <div  class=""><img style="border: 2px #05023A solid" src="assets/img/mandante3.png" class="img-fluid" alt=""> </div>
              <hr>
              <ul style="list-style: none;text-align: left;color:#000" >
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Estandariza perfiles de control por cargos.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Control de acceso solo para personal autorizado.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Creaci&oacute;n de credenciales digitales.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Trazabilidad de la informaci&oacute;n.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Respaldo seguro de la documentacion.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Agilizar la gesti&oacute;n de la documentaci&oacute;n.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> No tiene costo (gratis).<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Libre de costo de almacenamiento por (2) a&ntilde;os.</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
            <div style="background: #8AEDE2;color:#000;border: 4px #05D3BF solid " class="icon-box">
              <h2><strong>Contratista</strong></h2>
              <div class=""><img style="border: 2px #05023A solid" src="assets/img/contratista.png" class="img-fluid" alt=""> </div>
              <hr>
              <ul style="list-style: none;text-align: left;color:#000" >
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Ordena la documentacion laboral/seguridad.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Agiliza el proceso de acreditaci&oacute;n.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Disminuye los costos administrativos.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Trazabilidad de la informaci&oacute;n.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Respaldo seguro de la documentacion.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Pago seg&uacute;n uso real.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Mejora la comunicaci&oacute;n potencial de nuevos clientes.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Libre de costo de almacenamiento por (2) a&ntilde;os.</li>
              </ul>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
            <div style="background:#8AEDE2;color:#000;border: 4px #05D3BF solid" class="icon-box">
              <h2><strong>Prevencionista</strong></h2>
              <div class=""><img style="border: 2px #05023A solid" src="assets/img/prevencionista2.png" class="img-fluid" alt=""> </div>
              <hr>
              <ul style="list-style: none;text-align: left;color:#000" >
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Orden estandarizado de todos sus clientes.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Ordena la documentaci&oacute;n laboral/seguridad de cada cliente.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Agiliza el proceso de acreditaci&oacute;n de los clientes.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Respaldo seguro de la documentaci&oacute;n.<br>&nbsp;</li>
                <li><i class="fa fa-chevron-right" aria-hidden="true"></i> Permite la trazabilidad de la informaci&oacute;n.<br>&nbsp;</li>
              </ul>
            </div>
          </div>
          
        </div>
      </div>
    </section><!-- End Services Section -->

    <!-- ======= About Section ======= -->
    <section style="margin-top: -4%;" id="beneficios" class="about">
     
      <div style="background:#F2F4F7;padding:  4% 1% 4% 7%;" class="container" data-aos="fade-up">    
        <div style="" class="row">
        <div class="section-title">
        <p style="font-size:26px;text-align:center">&iquest;Cuales son los beneficios de Facil Control?</p>
        </div>          
        
        <div style="background-color: #fff;color:#000;padding: 2%;border-radius: 6px;border: 2px #282828 solid" class="row">
            <div style="border-radius:6px" class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/ante1.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
            <p style="font-size:18px">
              En la actualidad toda la gran industria cuenta con software que les ayudan a manejar el gran volumen de <strong>documentaci&oacute;n que se genera por cada trabajador</strong> que ingresa a sus instalaciones. 
              Estas empresas cuentan con servicios especializados que les llevan el proceso de acreditaci&oacute;n para que un trabajador pueda ingresar a sus obras o faenas. <strong>Facil Control</strong> entrega a la peque&ntilde;a 
              y mediana empresa una herramienta inform&aacute;tica que antes estaba disponible solo para empresas con un gran volumen de trabajadores.
            </p>
            </div>
        </div>

        <div style="margin-top: 2%;background-color: #fff;color:#000;padding: 2%;border-radius: 6px;border: 2px #282828 solid" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/ante2.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
            <p style="font-size:18px">
              <strong>Si un trabajador tiene un accidente</strong> o cualquier problema laboral, es el due&ntilde;o de las obras, instalaciones o campo el que debe responder si es que la empresa contratista no tiene los 
              recursos para hacerlo. <strong>Facil Control</strong> es una herramienta de <strong>acreditaci&oacute;n de trabajadores que garantiza a las empresas que una persona se encuentra con toda su documentaci&oacute;n de respaldo al d&iacute;a</strong> antes del ingreso a tus instalaciones.
            </p>
            </div>
          </div>

          <div style="margin-top: 2%;background-color: #fff;color:#000;padding: 2%;border-radius: 6px;border: 2px #282828 solid" class="row">
            <div class="image col-lg-2"  data-aos="fade-right"><img src="assets/img/ante3.png" class="img-fluid" alt=""></div>
            <div class="col-lg-10 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
            <p style="font-size:18px">
              Las empresas contratistas son una herramienta que permite contar con mano de obra especializada de forma &aacute;gil y r&aacute;pida. Sin embargo una contratista no necesariamente es una empresa ordenada y 
              prolija en cuanto a la gesti&oacute;n de los documentos de respaldo. <strong>Facil Control es un software que ordena a la empresas contratistas</strong> y permite que una mandante se asegure que no ingrese 
              personal no acreditado a sus instalaciones.
            </p>
            </div>
          </div>

        </div>
        <br>
        <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita aqu&iacute; una demostración</strong></a>
      </div>
    </section> 


     <!-- ======= Features Section ======= -->
     <section id="precios" class="features">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <p style="font-size:26pxt;text-align:center">Tabla de valores</p>
        </div>
        <div class="row">
        <div class="image col-lg-6" style='background-image: url("assets/img/tabla3.png");' data-aos="fade-right"></div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
            <div class="icon-box mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
              <h4>Costo seg&uacute;n acreditaciones vigentes.</h4>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
              <h4>Uso de la Plataforma es <strong>gratis hasta la 5ta acreditaci&oacute;n</strong>.</h4>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
            <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
              <h4>El costo de las acreditaciones puede ser linkeado directamente a las empresas contratistas o el mandante puede asumir el costo por todos sus empresas de servicios</h4>
            </div>
            <br>
            <div class="text-center"><a href="#contact" class="get-started-btn scrollto text-dark"><strong>Solicita aqu&iacute; una demostración</strong></a>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Features Section -->

     
    

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Contactanos</h3>
          <p style="font-size: 22px;"> Escribenos mediante el formulario o al WhatsApp para obtener m&aacute;s informaci&oacute;n sobre la Plataforma Facil Control, el Gestor de Documentos que toda empresa debe tener.</p>
          <a class="cta-btn" href="#contact">Solicita aqu&iacute; una demostración</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

   
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

       
        <div style="background:#05D3BF;color:#fff; padding:2% 0%;border-radius:4px" class="row">
          <div class="col-lg-12 mt-5 mt-lg-0 text-center">
              <h3><strong>SI QUIERES UNA DEMOSTRACION GRATIS LLENA EL FORMULARIO Y TE CONTACTAREMOS A LA BREVEDAD</strong></h3>
          </div>  
        </div>    
       <!--<div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe>
        </div>-->

        <div class="row mt-5">

          <!--<div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i style="color:#fff" class="bi bi-geo-alt"></i>
                <h4>Direcci&oacute;n:</h4>
                <p>Lord Cochrane 136. Santiago. Chile.</p>
              </div>

              <div class="email">
                <i style="color:#fff" class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@Facil Control.cl</p>
              </div>

              <div class="phone">
                <i style="color:#fff" class="bi bi-phone"></i>
                <h4>Telefono:</h4>
                <p>+56 9-3645-0940</p>
              </div>

            </div>

          </div>-->
          

          <div class="col-lg-12 mt-5 mt-lg-0">

            <form action="" method="post" id="frm" role="form" class="php-email-form">
              <div class=" form-group row">
                  <div class="col-md-6 form-group">
                    <input style="border: 1px solid #05023A;" type="text" name="nombre" class="form-control" id="nombre" placeholder="Su nombre" required>
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input style="border: 1px solid #05023A;" type="email" class="form-control" name="email" id="email" placeholder="Su Email" required>
                  </div>
              </div>
              
              <div class="form-group row">
                <div class="col-md-6 form-group">
                  <input style="border: 1px solid #05023A;" type="text" name="empresa" class="form-control" id="empresa" placeholder="Nombre de Empresa" required>
                </div>

                <div class="col-sm-1 form-group">
                  <input style="font-size:14px" type="text" id="" name="" class="form-control" value="(+56)-9" readonly="" >
                </div>

                <div class="col-sm-5 form-group">
                <input style="border: 1px solid #05023A;" type="text" id="telefono" name="telefono" class="form-control" onkeypress="return isNumber(event)" maxlength="8" placeholder="Su número teléfono Ej. 1234-5678" >
                </div>

              </div>

              <div class="form-group row">
                  <div class="col-md-6 form-group">
                      <select style="border: 1px solid #05023A;" name="tipo" id="tipo" class="form-control" >
                          <option value="0" select="">Seleccion tipo Empresa</option>
                          <option value="Mandante">Mandante</option>
                          <option value="Contratista">Contratista</option>
                      <select>  
                  </div>

                  <div class="col-sm-6 form-group">
                          <select style="border: 1px solid #05023A;" name="trabajadores" id="trabajadores" class="form-control" >
                              <option value="0" select="">Seleccion No trabajadores</option>
                              <option value="1-5">1-5</option>
                              <option value="5-20">5-20</option>
                              <option value="20-100">20-100</option>
                              <option value="100">+100</option>
                          <select>  
                  </div>
              </div>

              <div class="my-3">
                <div style="display: none" id="cargando" class="loading">Loading</div>
                <div style="display: none" id="error" class="error-message">Ups. Hubo error de sistema, vuelva a intentar.</div>
                <div style="display: none" id="enviado" class="sent-message">Felicitaciones! Por querer mejorar el sistema de gesti&oacute;n de tu empresa,  lo antes posible se contactara contigo un ejecutivo de F&aacute;cil Control para hacerte una demostraci&oacute;n gratis.</div>
              </div>
              <div class="text-center text-white"><button class="btn btn-md boton" type="button" onclick="enviar()">Solicitar demostraci&oacute;n</button></div>
            </form>

          </div>
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
   

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Facil Control</span></strong>.
      </div>
      <div class="credits">
      </div>
    </div>
  </footer>

  <!--<div id="preloader"></div>-->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>



</body>

</html>
