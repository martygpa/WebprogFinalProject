<?php
session_start();



?>
<!DOCTYPE html>
<!--Programmer: Alec Waddelow
    Class: CSC434
    Assignment: Final Project - E-Commerce
    Professor: Dr. Girard
    -->
<html>
<title>Register Account </title>
<head>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }
        li {
            float: left;
        }
        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        li a:hover:not(.active) {
            background-color: #111;
        }
        .active {
            background-color: #4CAF50;
        }
        table {
            display: block;
            color: black;
            text-align: center;
        }
        .body {
          margin :0;
          padding: 0;
          text-align: center;
        }
        .loginContainer {
          margin: 0 auto;
          text-align: left;
          width: 800 px;
        }
        tr {
          text-align: left;;
        }
    </style>
</head>
<body>
  <script type ="text/javascript">
    function confirmPassword()
    {
      var pass1 = document.getElementById("password").value;
      var pass2 = document.getElementById("passwordConfirm").value;

      var success = true;
      if(pass1 != pass2)
      {
        alert("Passwords did not match!");
        success = false;
      }
      return success;
    }
  </script>


<ul>
  <li> <a href="../Home.php">Home</a></li>
  <li> <a href="../account_management/Login.html">Login</a></li>
  <li> <a href="../account_management/myAccount.php">My Account</a> </li>
  <li> <a class="active" href="../account_management/registerAccount.php">Create New Account</a></li>
  <li> <a href="../ShoppingCart/ShoppingCart.php">Shopping Cart</a></li>
  <li> <a href="../WishList/WishList.php">Wish List</a></li>
  <li> <a href="../OrderHistory/OrderHistory.php">Order History</a></li>
  <li> <a href="../Checkout/Checkout.php">Check Out</a></li>
  <?php  if(($_SESSION['isLoggedIn'] == true))
  {
    echo "<li> <a href='../account_management/logout.php'>Logout</a></li>";
  } ?>
</ul>


<h1>Please fill out the form below to create an account</h1>

<table>
    <form action="registerUser.php" onsubmit="confirmPassword();" method="post" >
        <tr>
            <td>Enter First Name </td>
            <td><input type="text" placeholder="First Name" name="firstName" required> </td>
        </tr>
        <tr>
            <td>Enter Last Name</td>
            <td> <input type="text" placeholder="Last Name" name="lastName" required> </td>
        </tr>
        <tr>
            <td>Enter User Name</td>
            <td> <input type="text" placeholder="User Name" name="userName" id="userName" required> </td>
        </tr>
        <tr>
            <td>Enter Password</td>
            <td> <input type="password" placeholder="Password" name="password" id="password" required> </td>
        </tr>
        <tr>
            <td>Confirm Password</td>
            <td> <input type="password" placeholder="Password" name="passwordConfirm" id="passwordConfirm" required> </td>
        </tr>
        <tr>
            <td><input type="submit" value="Submit" name="registerSubmit"> </td>
        </tr>

    </form>
</table>



</body>
</html>
