<?php
/**
 * Register User Handler
 * Author: Alec Waddelow
 * Date: 12/4/2016
 */
session_start();

require_once('../Gateways/UserGateway.php');
require_once('../Gateways/CartGateway.php');
require_once('../Gateways/WishListGateway.php');
require_once('../Models/UserObject.php');

$gateway = new UserGateway();
$cartGateway = new CartGateway();
$wishListGateway = new WishListGateway();
$connection = $gateway->getConnection();

if(isset($_POST['registerSubmit']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['userName']) && isset($_POST['password']) && isset($_POST['passwordConfirm']))
{
    $firstName = sanitizeData($_POST['firstName']);
    $lastName =  sanitizeData($_POST['lastName']);
    $userName = sanitizeData($_POST['userName']);
    $password = sanitizeData($_POST['password']);
    $passwordConfirm = sanitizeData($_POST['passwordConfirm']);

    if($password != $passwordConfirm)
    {
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.php");
      exit;
    }

    $securePassword = saltAndHash($password);
    $newUser = new UserObject($firstName, $lastName, $userName, $securePassword, 0);
    $gateway->insertRow($newUser);
    $returnSuccess = $gateway->queryForLogin($userName, $securePassword);

    if($returnSuccess>0)
    {
	$_SESSION['ID'] = $returnSuccess;
	$cartGateway->insertRow($_SESSION['ID']);
	$wishListGateway->insertRow($_SESSION['ID']);
      	ini_set('session.gc_maxlifetime', 60 * 30);
     	header("Location: http://webprog.cs.ship.edu/webprog25/Home.php");
      	exit;
    }
    else
    {
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.php");
      exit;
    }
  }
  else
  {
    header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.php");
    exit;
  }

  /*
  * Salts and hashes password for storage in the database
  */
  function saltAndHash($password)
  {
    $salt1 = "3r541/f";
    $salt2 = "io.,;/[/[,;]]";

    $newPassword = hash('sha384', "$salt1$password$salt2");
    return $newPassword;
  }

  function sanitizeData($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>
