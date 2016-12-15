<?php
/*
* Deletes a row in CartToItemGateway.
* Author: Ronald Sease
*/
 require_once("../Gateways/CartToItemGateway.php");
  $ID = $_POST['ID'];
  echo $ID;
   $cartToItem = new CartToItemGateway();
  $cartToItem->deleteRow($ID);
 ?>
