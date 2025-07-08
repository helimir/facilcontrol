<?php
//start session
session_start();

//get logged in user ID from sesion
$loggedInUserID = 17;
#$loggedInUserID = "idHelimir";

//PayPal variables
$paypalURL 	= 'https://sandbox.paypal.com/cgi-bin/webscr';
$paypalID 	= 'sb-wohlr36833816@business.example.com';
$successURL = 'https://facilcontrol.cl/paypal4/success.php';
$cancelURL 	= 'https://facilcontrol.cl/paypal4/index.php';
$notifyURL 	= 'https://facilcontrol.cl/paypal4/paypal_ipn.php';

$itemName = 'Membresia Ssuscripciones';
$itemNumber = 'MS'.$loggedInUserID;

//subscription price for one month
$itemPrice = 25.00;
?>
<!DOCTYPE html>
<html>
<head>
<style>
.main{ padding:15px;}
</style>
	<title>PayPal suscripción PHP con integración pasarela de pago</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="main">
<div class="panel panel-default">
<div class="panel-heading"> 

<ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="index.php">Inicio</a></li>

</ul>
</div>

<div class="panel-body">
  
  
	<h2>PayPal suscripción PHP con integración pasarela de pago</h2>

	<p>Elegir una opcion valida:
		<select name="validity" onchange="getSubsPrice(this);">
			<option value="1" selected="selected">1 Mes</option>
			<option value="3">3 Meses</option>
			<option value="6">6 Meses</option>
			<option value="9">9 Meses</option>
			<option value="12">12 Meses</option>
		</select>
	</p>
	<p>Precio: <span id="subPrice"><?php echo '$'.$itemPrice.' USD'; ?></span></p>
	<form action="<?php echo $paypalURL; ?>" method="post">
		<!-- identify your business so that you can collect the payments -->
		<input type="hidden" name="business" value="<?php echo $paypalID; ?>">
		<!-- specify a subscriptions button. -->
		<input type="hidden" name="cmd" value="_xclick-subscriptions">
		<!-- specify details about the subscription that buyers will purchase -->
		<input type="hidden" name="item_name" value="<?php echo $itemName; ?>">
		<input type="hidden" name="item_number" value="<?php echo $itemNumber; ?>">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="a3" id="paypalAmt" value="<?php echo $itemPrice; ?>">
		<input type="hidden" name="p3" id="paypalValid" value="1">
		<input type="hidden" name="t3" value="M">
		<!-- custom variable user ID -->
		<input type="hidden" name="custom" value="<?php echo $loggedInUserID; ?>">
		<!-- specify urls -->
		<input type="hidden" name="cancel_return" value="<?php echo $cancelURL; ?>">
		<input type="hidden" name="return" value="<?php echo $successURL; ?>">
		<input type="hidden" name="notify_url" value="<?php echo $notifyURL; ?>">
		<!-- display the payment button -->
		<input class="paypal_button btn btn-primary" type="submit" value="Compar Suscripción">
	</form>

<script>
function getSubsPrice(obj){
	var month = obj.value;
	var price = (month * <?php echo $itemPrice; ?>);
	document.getElementById('subPrice').innerHTML = '$'+price+' USD';
	document.getElementById('paypalValid').value = month;
	document.getElementById('paypalAmt').value = price;
}
</script>
     </div>
 <div class="panel-footer">BaulPHP</div>
 </div><!--Panel cierra-->
  
</div>
</body>
</html>