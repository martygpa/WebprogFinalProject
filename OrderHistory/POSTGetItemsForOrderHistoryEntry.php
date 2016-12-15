<?php
  /*
  * Gets all the order history
  * Author: Ronald Sease
  */
  require_once("../Gateways/OrderHistoryToItemGateway.php");
  require_once("../Gateways/ItemGateway.php");
  require_once("../Gateways/OrderHistoryToItemGateway.php");

  $orderHistoryID = $_POST['OrderHistoryID'];
  $orderToItemGateway = new OrderHistoryToItemGateway();
  $itemIDs = $orderToItemGateway->getEntriesOfOrderHistoryID($orderHistoryID);
  $itemGateway = new ItemGateway();
  for($i = 0; $i < count($itemIDs); $i++)
  {
    $item = $itemGateway->rowDataQueryByID($itemIDs[$i]);
    for($j = 0; $j < count($item); $j++)
    {
      echo "<tr><td>".$item[$j]->Name."</td><td>".$item[$j]->Price."</td></tr>";
    }
  }


?>
