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
if(isset($_SESSION['ID']))
{
    $ID = $_SESSION['ID'];
}
?>

<html>
<style>
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
    <li> <a href="../account_management/registerAccount.html">Create New Account</a></li>
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
  <p> First Name: <?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['FirstName'] ?> </p>
  <p> Last Name: <?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['LastName'] ?> </p>
  <p> User Name: <?php echo $gateway->rowDataQueryByID($_SESSION['ID'])['UserName'] ?> </p>
</div>

</body>

</html>
