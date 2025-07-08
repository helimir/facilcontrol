<?php

$params=array(
        'token' => 'EAAH2ivV2fg4BO6d7bdySv8vdzZBnnC3LhSJH97PzfAk9Aq1IpH8tC20jqSpweHMMIWqu9k5uy6NkpLzlDNe4Q1WVw771QPWLMOqhHpiLpkdqL3ZAAE3P9Lrp6TtcfRIedC2XPlwzKOnAlerAQBqDZCYQhv92ZAIcjCqHqkrGjbtxSs9rrcaznwDQnq8YPZCoEYqleClaplOL5m9ZA1AS4WbRKUvAZDZD',
        'to' => '56936450940',
        'image' => 'https://prueba.facilcontrol.cl/assets/img/logo_2.png',
        'caption' => 'image caption',
        'priority' => '',
        'message_id' => ''
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://graph.facebook.com/v20.0/470773022788629/messages",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => http_build_query($params),
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }

//TOKEN QUE NOS DA FACEBOOK
$token = 'EAAH2ivV2fg4BO6d7bdySv8vdzZBnnC3LhSJH97PzfAk9Aq1IpH8tC20jqSpweHMMIWqu9k5uy6NkpLzlDNe4Q1WVw771QPWLMOqhHpiLpkdqL3ZAAE3P9Lrp6TtcfRIedC2XPlwzKOnAlerAQBqDZCYQhv92ZAIcjCqHqkrGjbtxSs9rrcaznwDQnq8YPZCoEYqleClaplOL5m9ZA1AS4WbRKUvAZDZD';
//NUESTRO TELEFONO
$telefono = '56936450940';
//URL A DONDE SE MANDARA EL MENSAJE
$url = 'https://graph.facebook.com/v20.0/470773022788629/messages';

//CONFIGURACION DEL MENSAJE
$mensaje = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"to": "'.$telefono.'", '
        . '"type": "template", '
        . '"template": '
        . '{'
        . '     "name": "hello_world",'
        . '     "language":{ "code": "en_US" } '
        . '} '
        . '}';


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