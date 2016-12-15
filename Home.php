<?php
session_start();
?>
<html>
<style>
body{font-family: Arial, Helvetica, sans-serif;width:100%;height:98%;margin: 0;}
#sidebar{
  height: 95%;
  width: 15%;
  background-color: #d9d9d9;
  float: left;
}
#mainview{
  width: 85%;
  height: 95%;
  background-color: white;
  float: left;
  overflow-y:auto;
}
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
.item{float: left; text-align: center; width:25%; height:35%;border-style: solid;margin: 1.5%;border-radius: 5px;}
.item p{float: left;text-align: center; margin-left: 2%;}
.itemimg{width:100%; height: 80%;border-bottom: 1px solid black;}
.itemimg:hover{cursor: pointer;}
.cart{float: right; width:10%;height:10%;margin-top: 3%; margin-right: 2.5%;}
.cart:hover{cursor: pointer;}
#livesearch{overflow: auto;}
#livesearch a{text-decoration: none; color: black;text-align: center; float: left; margin-left: 33%;}
</style>
<body>
  <ul>
    <li> <a class="active" href="./Home.php">Home</a></li>
    <li> <a href="./account_management/myAccount.php">My Account</a> </li>
    <li> <a href="./account_management/registerAccount.php">Create New Account</a></li>
    <li> <a href="./ShoppingCart/ShoppingCart.php">Shopping Cart</a></li>
    <li> <a href="./WishList/WishList.php">Wish List</a></li>
    <li> <a href="./OrderHistory/OrderHistory.php">Order History</a></li>
    <li> <a href="./Checkout/Checkout.php">Check Out</a></li>
    <?php
    require_once("./Gateways/UserGateway.php");
    if(($_SESSION['isLoggedIn'] == true))
    {
      echo "<li> <a href='./account_management/logout.php'>Logout</a></li>";
    }
    else
    {
        echo "<li> <a href='./account_management/Login.html'>Login</a></li>";
    }
    $userGateway = new UserGateway();
    $user = $userGateway->rowDataQueryByIDIan($_SESSION['ID']);
    if ($user->isAdmin)
    {
        echo "<li> <a href='./admin/admin.php'>Admin</a></li>";
    }
    ?>
</ul>
  <div id="sidebar">
    <div id="UserInfo"></div>
    Search: <input type="text" onkeyup="showResult(this.value)"></input>
    <div id="livesearch"></div>
  </div>
  <div id="mainview">
    <table id="items">
    </table>
  </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
var UserID = <?php if(!empty($_SESSION["ID"])){echo($_SESSION["ID"]);}else{echo 0;}?>;
onLoad();
function onLoad()
{
  getItems();
  getUser();
  getWishlistID();
  getCartID();
}

function getItems()
{
  $.getJSON('./CRUD/GETItem.php', function(data)
  {
    $.each(data,function(index, object){
      //Create containing div
      var div=document.createElement("div");
      div.setAttribute("id",object.ID);
      div.setAttribute("class","item");
      //create image in div
      var link = document.createElement("a");
      link.setAttribute("href","./Item.php?ID="+object.ID);
      var img=document.createElement("img");
      img.setAttribute("src",object.ImageLocation);
      img.setAttribute("class","itemimg");
      //add cost
      var p=document.createElement("p");
      p.append("$"+object.Price+"\t"+object.Name);
      //append stuff
      link.append(img);
      div.append(link);
      div.append(p);
      div.append(createCartImage(object.ID));
      div.append(createWishlistImage(object.ID));
      $("#items").append(div);
    });
  });
}

function createCartImage(ID)
{
  var img=document.createElement("img");
  img.setAttribute("src","./images/cart.png");
  img.setAttribute("class","cart");
  img.setAttribute("onclick","addItemToCart("+ID+")")
  return img;
}

function createWishlistImage(ID)
{
  var img=document.createElement("img");
  img.setAttribute("src","./images/wishlist.png");
  img.setAttribute("class","cart");
  img.setAttribute("onclick","addItemToWishlist("+ID+")")
  return img;
}

/*
 *This function is used for the live search to dyanmically
 * generate the results
 */
function showResult(str)
{
  if (str.length==0)
  {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  document.getElementById("livesearch").innerHTML="";
  document.getElementById("livesearch").style.border="0px";
  $.getJSON("./CRUD/GETItem.php?q="+str,true, function(data)
  {
    $.each(data,function(index,object){
      var br=document.createElement("br");
      var link = document.createElement("a");
      link.href = "./Item.php?ID="+object.ID;
      link.innerHTML = object.Name;
      document.getElementById("livesearch").append(link);
      document.getElementById("livesearch").append(br);
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    });
  });
}

function addItemToCart(ItemID)
{
  if(UserID > 0)
  {
    $.post("./CRUD/POSTCartToItem.php", { ItemID: ItemID, CartID: Number.parseInt(CartID) } );
    alert("Item has been added to the cart");
  }
  else
  {
    alert("Please sign in to add the to your wishlist");
  }
}

function addItemToWishlist(ItemID)
{
  if(UserID > 0)
  {
    $.post("./CRUD/POSTWishListToItem.php", { ItemID: ItemID, WishListID: WishListID } );
    alert("Item has been added to the wishlist");
  }
  else
  {
    alert("Please sign in to add the item to your wishlist");
  }
}

function getWishlistID()
{
  $.getJSON('./CRUD/GETWishList.php?UserID='+UserID, function(data)
  {
    if(data == false)
    {
        alert("Database Error");
    }
    else
    {
        WishListID = data[0].ID;
    }
  });
}

function getCartID()
{
  $.getJSON('./CRUD/GETCart.php?UserID='+UserID, function(data)
  {
    if(data == false)
    {
        alert("Database Error");
    }
    else
    {
        CartID = data;
    }
  });
}

function getUser()
{
  if(UserID>0)
  {
    $.getJSON("./CRUD/GETUser.php?ID="+UserID,true, function(data)
    {
      var info = document.getElementById("UserInfo");
      info.innerHTML = "Welcome back "+ data.FirstName;
    });
  }
  else
  {
    var info = document.getElementById("UserInfo");
    info.innerHTML = "Hello, Welcome to the Ecommerce Site";
  }
}
</script>
</html>
