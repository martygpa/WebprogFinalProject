<?php
/*
 * This PHP is used to handle the HTTP POST requests.
 * The correct gateway is setup and then the post
 * is made. All sanitization is done in the gateway.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/ItemGateway.php');
$gateway = new ItemGateway();

  $name = sanitize_input($_POST["name"]);
  $imagelocation = sanitize_input($_POST["imagelocation"]);
  $description = sanitize_input($_POST["description"]);
  $UPC = sanitize_input($_POST["UPC"]);
  $price = sanitize_input($_POST["price"]);
  $manufacturer = sanitize_input($_POST["manufacturer"]);
  $quantity = sanitize_input($_POST["quantity"]);


if(!empty($_POST["ID"]))
{
	$data = $gateway->rowDataQueryByID($_GET["ID"]);
	echo(json_encode($data));
}
else
{
	$data = $gateway->tableDataQuery();
	echo(json_encode($data));
}

function sanitize_input($data) {
  //$data = trim($data);
  //$data = stripslashes($data);
  //$data = htmlspecialchars($data);
  return $data;
}

?>
