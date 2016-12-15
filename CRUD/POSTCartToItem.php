<?php
/*
 * This PHP is used to handle the HTTP POST requests.
 * The correct gateway is setup and then the post
 * is made. All sanitization is done in the gateway.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/CartToItemGateway.php');
$gateway = new CartToItemGateway();
$ItemID = $_POST["ItemID"];
$CartID = $_POST["CartID"];
$object->ItemID = $ItemID;
$object->CartID = $CartID;
$gateway->insertRow($object);
?>
