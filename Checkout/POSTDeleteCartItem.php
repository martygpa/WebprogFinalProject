<?php
/*
* Deletes a row in CartToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/CartToItemGateway.php");
  $cartID = $_POST['CartID'];
  $itemID = $_POST['ItemID'];
   $cartToItem = new CartToItemGateway();
  $cartToItem->deleteRow($cartID, $itemID);
 ?>
