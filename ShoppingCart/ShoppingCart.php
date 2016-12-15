
<?php
 /*
 * ShoppingCart Class to handle the ShoppingCart page
 * Author: Ronald Sease
 */
  require_once("../Gateways/CartGateway.php");
  require_once("../Gateways/CartToItemGateway.php");
  require_once("../Gateways/ItemGateway.php");


  $userID = 1;
  //echo $_SESSION['ID']
  $gateway = new CartGateway();
  if(!is_null($gateway))
  {
    $cartID = $gateway->rowDataQueryByUserID($userID);
    $relatedGateway = new CartToItemGateway();
    $itemIDs = $relatedGateway->rowDataQueryByID($cartID);
    $items = array();
    $itemGateway = new ItemGateway();
    for($i = 0; $i < count($itemIDs); $i++)
    {
       $result = $itemGateway->getByRowIDIntoArray($itemIDs[$i]);
      array_push($items, $result);
    }
    echo "<br><br><br>";

  }
?>
<html>
<style>
body{width:99%;height:98%;}
#sidebar{height: 95%;width: 15%;background-color: #d9d9d9;float: left;}
#mainview{width: 85%; height: 95%; background-color: #e6e6e6;float: left;overflow-y:auto;}
ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }
li {float: left;}
li a {display: block;color: white;text-align: center;padding: 14px 16px;text-decoration: none;}
li a:hover:not(.active) {background-color: #111;}
.active {background-color: #4CAF50;}
table {display: block;color: black;text-align: center;}
#items {font-family: arial, sans-serif; border-collapse: collapse;width: 97%;padding: 1%;}
.item{float: left; text-align: center; width:25%; height:30%;border-style: solid;margin: 1.5%;border-radius: 5px;}
.item p{float: left;text-align: center; margin-left: 2%;}
.itemimg{width:100%; height: 80%;border-bottom: 1px solid black;}
.cart{float: right; width:10%;height:10%;margin-top: 3%; margin-right: 2.5%;}
.removeButton{float: right; width:20%;height:10%;margin-top: 3%; margin-right: 2.5%; }

.cart:hover{cursor: pointer;}
#livesearch{overflow: auto;}
#livesearch a{text-decoration: none; color: black;text-align: center; float: left; margin-left: 33%;}
</style>
<body>
  <ul>
    <li> <a href="/Home.html">Home</a></li>
    <li> <a href="../account_management/Login.html">Login</a></li>
    <li> <a href="/account_management/myAccount.php">My Account</a> </li>
    <li> <a href="/account_management/registerAccount.php">Create New Account</a></li>
    <li> <a class="active" href="/ShoppingCart/ShoppingCart.php">Shopping Cart</a></li>
    <li> <a href="/WishList/WishList.php">Wish List</a></li>
    <li> <a href="/OrderHistory/OrderHistory.php">Order History</a></li>
    <li> <a href="/Checkout/Checkout.php">Check Out</a></li>
    <?php  if(($_SESSION['isLoggedIn'] == true))
    {
      echo "<li> <a href='../account_management/logout.php'>Logout</a></li>";
    } ?>
</ul>
  <div id="sidebar">
    Search: <input type="text" onkeyup="showResult(this.value)"></input>
    <div id="livesearch"></div>
  </div>
  <div id="mainview">
    <table id="items">
    </table>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type ="text/javascript">
  $(document).ready(function(){

    var self =this;
  var itemsInCart = <?php echo json_encode( $items)?>;
  $.each(itemsInCart,function(index, object){
    //Create containing div
    var div=document.createElement("div");
    div.setAttribute("id",object.id);
    div.setAttribute("class","item");
    //create image in div
    var img=document.createElement("img");
    img.setAttribute("src",'.'+object.ImageLocation);
    img.setAttribute("class","itemimg");
    //add cost
    var p=document.createElement("p");
    p.append("$"+object.Price+"\t"+object.Name);
    //append stuff
    div.append(img);
    div.append(p);
    div.append(createRemoveButton(object.id));
    div.append(createWishlistImage(object.id));
    $("#items").append(div);
  });
});

function createRemoveButton(id)
{
  var img=document.createElement("button");
  img.setAttribute("class","glyphicon glyphicon-remove cart");
  img.setAttribute("onclick","removeItemFromCart("+id+")");
  return img;
}

function createWishlistImage(id)
{
  var img=document.createElement("img");
  img.setAttribute("src","../images/wishlist.png");
  img.setAttribute("class","cart");
  img.setAttribute("onclick","addItemToWishList("+id+")");
  return img;
}

function removeItemFromCart(id)
{
  var cartID = <?php echo $cartID?>;
  $.ajax({
          type: "POST",
          url:'./POSTDeleteCartItem.php',
          data: ({CartID: cartID, ItemID: id}),
          success:function(response){ alert("Removed from cart"); }
      });
  var divToHide = '#' + id;
  $(divToHide).hide();
}

function addItemToWishList(id)
{
  var UserID = <?php echo $userID?>;
  $.ajax({
    type: "POST",
    url: "./POSTAddItemToWishList.php",
    data: ({UserID: UserID, ItemID: id}),
    success: function(response){
      alert("added to wishlist");
    }
  })
}
</script>
</html>
