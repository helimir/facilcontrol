<?php

/**
 * @author lolkittens
 * @copyright 2022
 */



?>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Basic Form</title>

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/img/iconofc.ico">
    
    <style>
    
    .tags {
  display: inline;
  position: relative;
}

.tags:hover:after {
  background: #333;
  background: rgba(0, 0, 0, .8);
  border-radius: 5px;
  bottom: -34px;
  color: #fff;
  content: attr(gloss);
  left: 20%;
  padding: 5px 15px;
  position: absolute;
  z-index: 98;
  width: 350px;
}

.tags:hover:before {
  border: solid;
  border-color: #333 transparent;
  border-width: 0 6px 6px 6px;
  bottom: -4px;
  content: "";
  left: 50%;
  position: absolute;
  z-index: 99;
}

.submenu {
    background: #E957A5;
    border: #E957A5;
}        
        
        
    
   </style>

</head>

<script>

 $(document).ready(function(){
				$("#region").change(function () {				
					$("#region option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna").html(data);
						});            
					});
				})
			}); 

</script>