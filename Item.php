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
#itemview
{
  width: 75%;
  height:50%;
  padding-top: 1.5%;
  padding-right: 1.5%;
  padding-left: 1.5%;
  border-left: solid;
  border-right: solid;
  border-top: solid;
  margin-top: 1.5%;
  margin-left: 1.5%;
  margin-right: 1.5%;
  border-radius: 5px;
}
#commentview
{
  width: 75%;
  height:35%;
  padding-bottom: 1.5%;
  padding-right: 1.5%;
  padding-left: 1.5%;
  border-left: solid;
  border-right: solid;
  border-bottom: solid;
  margin-bottom: 1.5%;
  margin-left: 1.5%;
  margin-right: 1.5%;
  border-radius: 5px;
  overflow-y: auto;
}
#itemimage{width: 40%; height:100%; float: left;}
#itemdetail{width: 60%;height:100%; float: left;}
#itemattributes{width: 100%;height:80%; float: left; text-align: center;}
.cart{float: left;width:5%;height:7.5%;margin: 1.5%;}
.cart:hover{cursor: pointer;}
#livesearch{overflow: auto;}
#livesearch a{text-decoration: none; color: black;text-align: center; float: left; margin-left: 33%;}
#commenttable
{
  width: 50%;
  margin-left: 50%;
  height:100%;

}
#blanket
{
  width: 50%;
  height:100%;
  float: left;
}
</style>
<body>
  <ul>
    <li> <a class="active" href="./Home.php">Home</a></li>
    <li> <a href="./account_management/Login.html">Login</a></li>
    <li> <a href="./account_management/myAccount.php">My Account</a> </li>
    <li> <a href="./account_management/registerAccount.php">Create New Account</a></li>
    <li> <a href="./ShippingCart/ShoppingCart.php">Shopping Cart</a></li>
    <li> <a href="./WishList/WishList.php">Wish List</a></li>
    <li> <a href="./OrderHistory/OrderHistory.php">Order History</a></li>
    <li> <a href="./Checkout/Checkout.php">Check Out</a></li>
    <?php  if(($_SESSION['isLoggedIn'] == true))
    {
      echo "<li> <a href='./account_management/logout.php'>Logout</a></li>";
    } ?>
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
  <div id="commentview">
    <div id="blanket"></div>
    <table id="commenttable"></table>
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
  getComments(<?php echo($_GET["ID"]);?>);
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
    addRatingStars(data.Rating,"itemrating");
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

function getComments(ItemID)
{
  $.getJSON("./CRUD/GETComment.php?JoinID="+ItemID,true, function(data)
  {
    var parent = document.getElementById("commenttable");
    $.each(data,function(index,object)
    {
      //UserName
      var tr = document.createElement('tr');
      var th = document.createElement('th');
      th.innerHTML = object.UserName;
      tr.appendChild(th);
      parent.appendChild(tr);
      //Comment
      var tr = document.createElement('tr');
      var td = document.createElement('td');
      td.innerHTML = "<b>"+"Comment:" +"</b>";
      tr.appendChild(td)
      var td = document.createElement('td');
      td.innerHTML = object.Comment;
      tr.appendChild(td);
      parent.appendChild(tr);
      //Rating
      var tr = document.createElement('tr');
      var td = document.createElement('td');
      td.innerHTML = "<b>"+"Rating:" +"</b>";
      tr.appendChild(td)
      var td = document.createElement('td');
      td.innerHTML = "<div id='Stars"+object.ID+"'</div>";
      tr.appendChild(td);
      parent.appendChild(tr);
      //
      var tr = document.createElement('tr');
      var td = document.createElement('td');
      td.innerHTML = "<br>";
      tr.appendChild(td);
      parent.appendChild(tr);
      addRatingStars(object.Rating,"Stars"+object.ID);
    });
  });
}
/*
 *This function is used to add the rating stars to the item
 * rating section
 */
function addRatingStars(numberOfStars,elementID)
{
  var i = parseInt(numberOfStars, 10);
  element = document.getElementById(elementID);
  if(element == undefined)
  {
    return;
  }
  var height = '15%';
  if(elementID == "itemrating")
  {
    element.innerHTML = "<b>Rating: </b>";
    height = '5%';
  }
  while(i>0)
  {
    oImg=document.createElement("img");
    oImg.setAttribute('src', './images/ratings/fullstar.png');
    oImg.setAttribute('height', height);
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
    i = i-1;
  }
  if(numberOfStars % 1 >= .5)
  {
    oImg=document.createElement("img");
    oImg.setAttribute('src', './images/ratings/halfstar.png');
    oImg.setAttribute('height', height);
    oImg.setAttribute('width', '3%');
    element.appendChild(oImg);
  }
  return element;
}
</script>
</html>
