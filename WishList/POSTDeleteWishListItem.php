<?php
/*
* Deletes a row in WishListToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/WishListToItemGateway.php");
  $wishListID = $_POST['WishListID'];
  $itemID = $_POST['ItemID'];
    $wishToItem = new WishListToItemGateway();
   $wishToItem->deleteRow($wishListID, $itemID);
 ?>
