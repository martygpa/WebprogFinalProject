<?php
session_start();
/*
* Author: Alec Waddelow
* Date: 12/14/2016
*
*/
require_once('../Gateways/UserGateway.php');
require_once('../Models/UserObject.php');

$gateway = new UserGateway();
$connection = $gateway->getConnection();

if(!isset($_SESSION['ID']))
{
	header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
	exit;
}
?>

<html>
<style>
body {
			font-family: Arial, Helvetica, sans-serif;
			width:100%;
			height:98%;
			margin: 0;
		}
  ul {list-style-type: none; margin: 0;padding: 0;overflow: hidden;background-color: #333;}
  li {float: left;}
  li a {display: block;color: white;text-align: center;padding: 14px 16px;text-decoration: none;}
  li a:hover:not(.active) {background-color: #111;}
  .active {background-color: #4CAF50;}
</style>

<body>
<ul>
    <li> <a href="../Home.php">Home</a></li>
    <li> <a href="../account_management/Login.html">Login</a></li>
    <li> <a class="active" href="../account_management/myAccount.php">My Account</a> </li>
    <li> <a href="../account_management/registerAccount.php">Create New Account</a></li>
    <li> <a href="../ShoppingCart/ShoppingCart.php">Shopping Cart</a></li>
    <li> <a href="../WishList/WishList.php">Wish List</a></li>
    <li> <a href="../OrderHistory/OrderHistory.php">Order History</a></li>
    <li> <a href="../Checkout/Checkout.php">Check Out</a></li>
    <?php  if(($_SESSION['isLoggedIn'] == true))
    {
      echo "<li> <a href='../account_management/logout.php'>Logout</a></li>";
    }
    ?>
</ul>


<div class="accountOverview" align="center">
  <h1>Account Overview </h1>
  <p>First name: <input type="text" id="FirstName" value="<?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['FirstName'] ?>">
      <button type="button" onclick = "changeFirstName()" id="firstNameButton" class="btn btn-success">Submit</button><br>
  <p>Last name: <input type="text" id="LastName" value="<?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['LastName'] ?>">
      <button type="button" onclick = "changeLastName()" id="lastNameButton" class="btn btn-success">Submit</button><br>
  <p>User name: <input type="text"  id="UserName" value="<?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['UserName'] ?>">
     <button type="button" onclick = "changeUserName()" id="userNameButton" class="btn btn-success">Submit</button><br><br>
  <p> Change Password <a href="../account_management/changePassword.php">Here</a></p>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type ="text/javascript">
function changeFirstName()
{
	var UserID = <?php echo $_SESSION['ID']?>;
	var newName = $('#FirstName').val();
	$.ajax({
            type: "POST",
    	    url: "./POSTUpdateFirstName.php",
            data: ({NewName: newName, ID: UserID}),
            success: function(response){
      		alert("First Name Changed");
    	     }
        });
}

function changeLastName()
{
	var UserID = <?php echo $_SESSION['ID']?>;
	var newName = $('#LastName').val();
	$.ajax({
            type: "POST",
    	    url: "./POSTUpdateLastName.php",
            data: ({NewName: newName, ID: UserID}),
            success: function(response){
      		alert("Last Name Changed");
    	     }
        });
}

function changeUserName()
{
	var UserID = <?php echo $_SESSION['ID']?>;
	var newName = $('#UserName').val();
	$.ajax({
            type: "POST",
    	    url: "./POSTUpdateUserName.php",
            data: ({NewName: newName, ID: UserID}),
            success: function(response){
      		alert("User Name Changed");
    	     }
        });
}

</script>

</html>
