<?php

//TOKEN QUE NOS DA FACEBOOK
$token = 'EAAH2ivV2fg4BOx0CJYa4k9IwNNRZBHoCe9aODSYILatcJBj9LxRL3qQFqVR4jYFSm0tZAmdlZCnPxdp8XI4lLLUDl0DliFz4Pq5KNQDgzFNjuT0GwG8r6hsPTiZAglalVMhz19aRqUw75hChZASzdJY0ZBZAzWclxQqWsK9c04OMS2r41ctJcU2MtI9MHicaKYmqFbNyaXS3deXUD1Mx8m8RY1i';
//NUESTRO TELEFONO
$telefono = '56935598173';
//URL A DONDE SE MANDARA EL MENSAJE
$url = 'https://graph.facebook.com/v20.0/470773022788629/messages';

//CONFIGURACION DEL MENSAJE
$mensaje = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"to": "'.$telefono.'", '
        . '"type": "document", '
        . '"document": '
        . '{'
        . '     "link": "https://prueba.facilcontrol.cl/tablas_Esperezan Torres_2024-11-14.pdf",'
        . '     "caption": "Tablas del Bingo para Helimir Lopez. Suerte!",'
        . '     "filename": "Tablas Sorteo 2024-11-14",'
        . '} '
        . '}';
//DECLARAMOS LAS CABECERAS
$header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
//INICIAMOS EL CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
$response = json_decode(curl_exec($curl), true);
//IMPRIMIMOS LA RESPUESTA 
print_r($response);
//OBTENEMOS EL CODIGO DE LA RESPUESTA
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//CERRAMOS EL CURL
curl_close($curl);
?>