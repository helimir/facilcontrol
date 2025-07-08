<style>

body {
    font-family: Arial;
    color: #212121;
}



#subscription-plan {
    padding: 20px;
    border: #E0E0E0 2px solid;
    text-align: center;
    width: 200px;
    border-radius: 3px;
    margin: 40px auto;
}

.plan-info {
    font-size: 1em;
}

.plan-desc {
    margin: 10px 0px 20px 0px;
    color: #a3a3a3;
    font-size: 0.95em;
}

.price {
    font-size: 1.5em;
    padding: 30px 0px;
    border-top: #f3f1f1 1px solid;
}

.btn-subscribe {
    padding: 10px;
    background: #e2bf56;
    width: 100%;
    border-radius: 3px;
    border: #d4b759 1px solid;
    font-size: 0.95em;
}

</style>
<?php
if($_GET['status'] == "success"){
?>

<div id="subscription-plan">
    <div class="plan-info">Respuesta</div>
    <div class="plan-desc">Suscripcion aprobada</div>
</div>

<?php	} ?>