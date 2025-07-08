<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suscripción con PayPal</title>
</head>
<body>
    <h1>Elige tu plan de suscripción</h1>
    <form action="suscribir.php" method="POST">
        <label for="plan">Selecciona un plan:</label><br>
        <input type="radio" name="plan" value="mensual" checked> Mensual ($10/mes)<br>
        <input type="radio" name="plan" value="anual"> Anual ($100/año)<br><br>
        <button type="submit">Suscribirse con PayPal</button>
    </form>
</body>
</html>