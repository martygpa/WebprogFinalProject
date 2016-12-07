<?php
/**
* Adds an item to the WishListToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/WishListGateway.php");
 require_once("../Gateways/WishListToItemGateway.php");
  $userID = $_POST['UserID'];
  $itemID = $_POST['ItemID'];
  $wishListGateway = new WishListGateway();
  $wishListResult = $wishListGateway->rowDataQueryByUserID($userID);
  $wishListID = $wishListResult;
  $wishToItemGateway = new WishListToItemGateway();
  $entry = new stdClass();
  $entry->WishListID = $wishListID;
  $entry->ItemID = $itemID;
  $wishToItemGateway->insertRow($entry);
 ?>
