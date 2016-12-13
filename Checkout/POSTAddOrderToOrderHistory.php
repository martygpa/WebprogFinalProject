<?php
require_once("../Gateways/OrderHistoryGateway.php");
require_once("../Gateways/OrderHistoryToItemGateway.php");
require_once("../Gateways/CartGateway.php");
require_once("../Gateways/CartToItemGateway.php");
$userID = $_POST['UserID'];
$itemsInCart = $_POST['itemsInCart'];
$historyGateway = new OrderHistoryGateway();
$historyGateway->insertRow($userID);
$orderHistorys = $historyGateway->rowDataQueryByUserID($userID);
$newestHistoryID = end($orderHistorys)->ID;
$orderToItem = new OrderHistoryToItemGateway();
for($i = 0; $i < count($itemsInCart); $i++)
{
  $orderToItem->insertRow($newestHistoryID, $itemsInCart[$i]['id']);
}
$cartGateway = new CartGateway();
$cartToItemGateway = new CartToItemGateway();
$cartID = $cartGateway->rowDataQueryByUserID($userID);
$cartToItemGateway->deleteRowByCartID($cartID);

?>
