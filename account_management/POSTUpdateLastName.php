/*
* Updates the first name of a user
* Author: Alec Waddelow & Ronald Sease
*/
<?php
require_once("../Gateways/UserGateway.php");
$newName = $_POST['NewName'];
$id = $_POST['ID'];
$gateway = new UserGateway();
$gateway->updateLastName($newName, $id);
?>
