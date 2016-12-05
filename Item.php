<?php
session_start();
?>
<html>
<style>
ul {list-style-type: none; margin: 0;padding: 0;overflow: hidden;background-color: #333;}
li {float: left;}
li a {display: block;color: white;text-align: center;padding: 14px 16px;text-decoration: none;}
li a:hover:not(.active) {background-color: #111;}
.active {background-color: #4CAF50;}
#sidebar{height: 95%;width: 15%;background-color: #d9d9d9;float: left;}
#mainview{width: 85%; height: 95%; background-color: #e6e6e6;float: left;}
#itemview{width: 75%; height:50%; padding: 1.5%;border-style: solid;margin: 1.5%;border-radius: 5px;}
#itemtitle{width: 100%; text-align: center; font-size: 200%;}
#itemimage{width: 40%; height:100%; background-color: white;float: left;}
#itemdetail{width: 60%;height:100%; background-color: white;float: left;}
#itemattributes{width: 100%;height:80%; background-color: white;float: left; text-align: center;}
.cart{float: left;width:5%;height:7.5%;margin: 1.5%;}
.cart:hover{cursor: pointer;}
#livesearch{overflow: auto;}
#livesearch a{text-decoration: none; color: black;text-align: center; float: left; margin-left: 33%;}
</style>
<body>
  <ul>
    <li> <a class="active" href="/home.html">Home</a></li>
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
    <div id="itemview">
      <img src="/" id="itemimage"></img>
      <div id="itemdetail">
        <table id="itemattributes"></table>
        <div id="itemrating">Rating: N/A</div>
    </div>
  </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
var UserID = <?php if(!empty($_SESSION["ID"])){echo($_SESSION["ID"]);}else{echo 0;}?>;
var WishListID = 0;
var CartID = 0;
onLoad();

/*
 *onLoad function that dynamically fills the page with content
 */
function onLoad()
{
  getItem(<?php echo($_GET["ID"]);?>);
  getUser();
  getWishlistID();
  getCartID();
}

/*
 *This function is used to add the rating stars to the item
 * rating section
 */
function addRatingStars(numberOfStars)
{
  var i = parseInt(numberOfStars, 10);
  element = document.getElementById("itemrating");
  element.innerHTML = "<b>Rating: </b>";
  while(i>0)
  {
    oImg=document.createElement("img");
    oImg.setAttribute('src', './images/ratings/fullstar.png');
    oImg.setAttribute('height', '5%');
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
    i = i-1;
  }
  if(numberOfStars % 1 >= .5)
  {
    oImg=document.createElement("img");
    oImg.setAttribute('src', './images/ratings/halfstar.png');
    oImg.setAttribute('height', '5%');
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
  }
}
/*
 *This function is used to append the item attributes
 *in the item attributes table on the page
 */
function addItemAttribute(attributeName,attributeValue)
{
 element = document.getElementById("itemattributes");
 var tr = document.createElement('tr');
 var td = document.createElement('td');
 td.innerHTML = "<b>"+attributeName+"</b>";
 tr.appendChild(td)
 var td = document.createElement('td');
 td.innerHTML = attributeValue;
 td.setAttribute('style','text-align: left');
 tr.appendChild(td);
 element.appendChild(tr);
}

/*
 *This function is used to append the item attributes
 *in the item attributes table on the page
 */
function addItemPicture(url)
{
  element = document.getElementById("itemimage");
  element.src = url;
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

function getItem(ID)
{
  $.getJSON('./CRUD/GETItem.php?ID='+ID, function(data)
  {
    if(data == false)
    {
      alert("Database Error");
    }
    else
    {
      addItemAttribute("Name:",data[0].Name);
      addItemAttribute("Price:","$"+data[0].Price);
      addItemAttribute("UPC:",data[0].UPC);
      addItemAttribute("Quantity:",data[0].Quantity);
      addItemAttribute("Manufacturer:",data[0].Manufacturer);
      addItemAttribute("Description:",data[0].Description);
      addItemPicture(data[0].ImageLocation);
      element = document.getElementById("itemdetail");
      element.append(createCartImage(data[0].ID));
      element.append(createWishlistImage(data[0].ID));
      element.append(createCommentImage(data[0].ID));
      getItemRating(ID);
    }
    });
}

function getItemRating(ID)
{
  $.getJSON('./CRUD/GETComment.php?ItemIDAvg='+ID, function(data)
  {
    addRatingStars(data.Rating);
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

function createCommentImage(ID)
{
  var img=document.createElement("img");
  img.setAttribute("src","./images/comment.png");
  img.setAttribute("class","cart");
  img.setAttribute("onclick","addCommentToItem("+ID+")")
  return img;
}


function addCommentToItem(ID)
{
  if(UserID == 0)
  {
    alert("Please sign in to rate and comment on items.");
  }
  else
  {
    var w = window.open('./Comment.php?ID='+ID, "", "width=600, height=400, scrollbars=yes");
  }
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
