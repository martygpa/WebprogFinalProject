<?php
require_once("../Gateways/OrderHistoryGateway.php");
require_once("../Gateways/OrderHistoryToItemGateway.php");
$userID = $_POST['UserID'];
$itemsInCart = $_POST['itemsInCart'];
$historyGateway = new OrderHistoryGateway();
$historyGateway->insertRow($userID);
$orderHistorys = $historyGateway->rowDataQueryByUserID($userID);
$newestHistoryID = end($orderHistorys)->ID;
//echo $newestHistoryID;
$orderToItem = new OrderHistoryToItemGateway();
//echo $newestHistoryID;
//echo var_dump($itemsInCart);
for($i = 0; $i < count($itemsInCart); $i++)
{
  $orderToItem->insertRow($newestHistoryID, $itemsInCart[$i]['id']);
}
//echo end($orderHistorys);

?>
