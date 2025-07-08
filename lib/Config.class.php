<?php
/**
 * Clase para Configurar el cliente
 * @Filename: Config.class.php
 * @version: 2.0
 * @Author: flow.cl
 * @Email: csepulveda@tuxpan.com
 * @Date: 28-04-2017 11:32
 * @Last Modified by: Carlos Sepulveda
 * @Last Modified time: 28-04-2017 11:32
 */
 

 $COMMERCE_CONFIG = array(
	"APIKEY" => "640370F5-956D-4BDF-9DA4-871A5523LEC5", // Registre aquí su apiKey
	"SECRETKEY" => "2266d7042a2852822b6f85be14aedd031c834c13", // Registre aquí su secretKey
	"APIURL" => "https://sandbox.flow.cl/api", // Producción EndPoint o Sandbox EndPoint    
 	"BASEURL" => "https://facilcontrol.cl/flow" //Registre aquí la URL base en su página donde instalará el cliente
 );

 #$COMMERCE_CONFIG = array(
#	"APIKEY" => "709C96CF-73E7-4F3B-989E-3A7L2748E7FE", // Registre aquí su apiKey
#	"SECRETKEY" => "9686a6b0c0cd13913d862ce5d847b873ff917305", // Registre aquí su secretKey
#	"APIURL" => "https://www.flow.cl/api", // Producción EndPoint o Sandbox EndPoint   
# 	"BASEURL" => "https://www.pensionjusta.cl/flow" //Registre aquí la URL base en su página donde instalará el cliente
# );
 
 class Config {
 	
	static function get($name) {
		global $COMMERCE_CONFIG;
		if(!isset($COMMERCE_CONFIG[$name])) {
			throw new Exception("The configuration element thas not exist", 1);
		}
		return $COMMERCE_CONFIG[$name];
	}
 }
