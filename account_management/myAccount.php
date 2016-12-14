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
    <?php if(!empty($_SESSION['isLoggedIn']))
    {
      echo "<li> <a href='../account_management/logout.php'>Logout</a></li>";
    } ?>
</ul>
