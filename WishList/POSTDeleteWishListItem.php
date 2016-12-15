<?php
/*
* Deletes a row in WishListToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/WishListToItemGateway.php");
  $ID = $_POST['ID'];
   $wishToItem = new WishListToItemGateway();
   $wishToItem->deleteRow($ID);
 ?>
