<?php
/*
 * This PHP is used to handle the HTTP POST requests.
 * The correct gateway is setup and then the post
 * is made. All sanitization is done in the gateway.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/CommentGateway.php');
$gateway = new CommentGateway();

  $object->Comment = $_POST["Comment"];
  $object->Rating = $_POST["Rating"];
  $object->UserID = $_POST["UserID"];
  $object->ItemID = $_POST["ItemID"];
if(!empty($_POST["ItemID"]))
{
	echo($gateway->insertRow($object));
}
else{}
?>
