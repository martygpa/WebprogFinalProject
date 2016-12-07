<?php
/**
* Adds an item to the WishListToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/CartGateway.php");
 require_once("../Gateways/CartToItemGateway.php");
  $userID = $_POST['UserID'];
  $itemID = $_POST['ItemID'];
   $cartGateway = new CartGateway();
   $cartResult = $cartGateway->rowDataQueryByUserID($userID);
  $cartID = $cartResult;
  $cartToItemGateway = new CartToItemGateway();
  $entry = new stdClass();
  $entry->CartID = $cartID;
  $entry->ItemID = $itemID;
  $cartToItemGateway->insertRow($entry);
 ?>
