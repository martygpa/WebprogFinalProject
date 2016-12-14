<?php
/*
 * This PHP is used to redirect the HTTP GET requests
 * depending on if an UserID parameter is passed in or not.
 * If the ID is passed in then the Cart with that UserID
 * is retrieved.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once("../Gateways/CartGateway.php");
$gateway = new CartGateway();
if(!empty($_GET["UserID"]))
{
	$data = $gateway->rowDataQueryByUserID($_GET["UserID"]);
	echo(json_encode($data));
}
?>
