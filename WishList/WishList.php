/**
 * WishList Class to handle the WishList page
 * Author: Ronald Sease
 */
<?php
  require_once("WishListGateway.php");
  require_once("WishListToItemGateway.php");
  $userID = 1;
  $gateway = new WishListGateway();
  if(is_null($gateway))
  {
    echo "null";
  }
  if(!is_null($gateway))
  {
    $result = $gateway->rowDataQueryByID($userID);
    $wishListID = (int)$result->UserID;
    echo $wishListID;
    $relatedGateway = new WishListToItemGateway();
    $itemIDs = $relatedGateway->rowDataQueryByID($wishListID);
    echo "hello";
    for($i = 0; $i < count($itemIDs); $i++)
    {
      echo $itemIDs[$i];
    }

  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Wishlist</title>
  </head>
  <body>

  </body>
</html>
