<?php
/*
 * This PHP is used to handle the HTTP POST requests.
 * The correct gateway is setup and then the post
 * is made. All sanitization is done in the gateway.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/WishListToItemGateway.php');
$gateway = new WishListToItemGateway();
$ItemID = $_POST["ItemID"];
$WishListID = $_POST["WishListID"];
$object->ItemID = $ItemID;
$object->WishListID = $WishListID;
$gateway->insertRow($object);
?>
