<?php
session_start();
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
.cart:hover{cursor: pointer;}
#livesearch{overflow: auto;}
#livesearch a{text-decoration: none; color: black;text-align: center; float: left; margin-left: 33%;}
</style>
<body>
  <ul>
    <li> <a class="active" href="/Home.html">Home</a></li>
    <li> <a href="/account_management/login.html">Login</a></li>
    <li> <a href="/account_management/myAccount.html">My Account</a> </li>
    <li> <a href="/account_management/registerAccount.html">Create New Account</a></li>
    <li> <a href="/shopping/shoppingCart.html">Shopping Cart</a></li>
    <li> <a href="/shopping/wishList.html">Wish List</a></li>
    <li> <a href="/shopping/orderHistory.html">Order History</a></li>
    <li> <a href="/shopping/checkOut.html">Check Out</a></li>
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
      var img=document.createElement("img");
      img.setAttribute("src",object.ImageLocation);
      img.setAttribute("class","itemimg");
      //add cost
      var p=document.createElement("p");
      p.append("$"+object.Price+"\t"+object.Name);
      //append stuff
      div.append(img);
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
    $.post("./CRUD/POSTCartToItem.php", { ItemID: ItemID, CartID: CartID } );
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
    $.post("./CRUD/POSTCartToItem.php", { ItemID: ItemID, WishListID: WishListID } );
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
        CartID = data[0].ID;
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
      info.innerHTML = "Welcome back "+ data[0].FirstName;
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
