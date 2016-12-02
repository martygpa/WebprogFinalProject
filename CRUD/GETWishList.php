<?php
/*
 * This PHP is used to redirect the HTTP GET requests
 * depending on if an ID parameter is passed in or not.
 * If the ID is passed in then the Item with that ID
 * is retrieved. If the q parameter is passed in for
 * the live search then it goes through each row
 * searching, Otherwise all items are retrieved.
 * @author Darnell R. Martin
 * @date 12/1/2016
 */
require_once('../Gateways/WishListGateway.php');
$gateway = new WishListGateway();
if(!empty($_GET["UserID"]))
{
	$data = $gateway->rowDataQueryByUserID($_GET["UserID"]);
	echo(json_encode($data));
}
?>
