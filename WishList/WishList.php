
<?php
 /*
 * WishList Class to handle the WishList page
 * Author: Ronald Sease
 */
  require_once("../Gateways/WishListGateway.php");
  require_once("../Gateways/WishListToItemGateway.php");
  $userID = 1;
  $gateway = new WishListGateway();
  if(!is_null($gateway))
  {
    $result = $gateway->rowDataQueryByUserID($userID);
    $wishListID = (int)$result->ID;
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
