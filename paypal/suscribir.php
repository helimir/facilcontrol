<?php
// Recibe el plan elegido por el usuario
$plan = $_POST['plan'];

// Define los precios de cada plan
if ($plan == "mensual") {
    $precio = 10;  // Precio mensual en USD
    $frecuencia = "1";  // Frecuencia mensual
    $tipo = "MENSUAL";
} else {
    $precio = 100;  // Precio anual en USD
    $frecuencia = "12";  // Frecuencia anual
    $tipo = "ANUAL";
}

// Aqu� deber�as tener las credenciales de PayPal API (Client ID y Secret)
// Para crear una suscripci�n, necesitas usar la API de PayPal.

// Definir la URL para el API de PayPal para crear la suscripci�n
$paypal_url = 'https://api.sandbox.paypal.com/v1/checkout/orders'; // Usar la URL de producci�n para pagos reales
$client_id = 'AUBukDP64DaNU_8VliKUi1FYqmQLlkMBgThZDf-cXdtDiHGKaOIfZJZPs56-ViLHhHYVUqU9Z-x4gx-J';
$client_secret = 'EA8v6dHQXIYTQySPI1gz7Of36Qn9H5uTFg1Xb71eS1EVq6VSTzsHTrh9FOG06LIrxuwkaq1-ZiEfK7U5';

// Autenticaci�n b�sica con las credenciales de PayPal
$headers = array(
    'Authorization: Basic ' . base64_encode($client_id . ':' . $client_secret),
    'Content-Type: application/json'
);

// Crear el cuerpo de la solicitud para crear un pedido (order)
$data = array(
    "intent" => "CAPTURE",
    "purchase_units" => array(
        array(
            "amount" => array(
                "currency_code" => "USD",
                "value" => $precio
            ),
            "description" => "Suscripcion de plan " . $tipo
        )
    ),
    "application_context" => array(
        "return_url" => "https://facilcontrol.cl/pagos/confirmar.php", // Redirige aqu� despu�s de la compra
        "cancel_url" => "https://facilcontrol.cl/pagos/cancelar.php"  // Redirige aqu� si el usuario cancela
    )
);

// Inicializa cURL para enviar la solicitud a PayPal
$ch = curl_init($paypal_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Ejecutar la solicitud y obtener la respuesta
$response = curl_exec($ch);
curl_close($ch);

// Decodificar la respuesta de PayPal
$response_data = json_decode($response, true);

// Verifica si se ha creado el pedido correctamente
if (isset($response_data['id'])) {
    $paypal_order_id = $response_data['id'];

    // Redirigir al usuario a PayPal para completar el pago
    foreach ($response_data['links'] as $link) {
        if ($link['rel'] == 'approve') {
            header("Location: " . $link['href']);
            exit;
        }
    }
} else {
    echo "Error al crear el pedido en PayPal.";
}
?>