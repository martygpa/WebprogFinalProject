<?php
/**
 * Register User Handler
 * Author: Alec Waddelow
 * Date: 12/4/2016
 */
session_start();

require_once('../Gateways/UserGateway.php');
require_once('../Models/UserObject.php');

$gateway = new UserGateway();
$connection = $gateway->getConnection();

if(isset($_POST['registerSubmit']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['userName']) && isset($_POST['password']) && isset($_POST['passwordConfirm']))
{
    $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $lastName =  mysqli_real_escape_string($connection, $_POST['lastName']);
    $userName = mysqli_real_escape_string($connection, $_POST['userName']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $passwordConfirm = mysqli_real_escape_string($connection, $_POST['passwordConfirm']);

    if($password != $passwordConfirm)
    {
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.html");
      exit;
    }


    $securePassword = saltAndHash($password);

    $newUser = new UserObject($firstName, $lastName, $userName, $securePassword, 0);
    $gateway->insertRow($newUser);
    $returnSuccess = $gateway->queryForLogin($userName, $securePassword);

    if($returnSuccess>0)
    {
      $_SESSION['ID'] = $returnSuccess;
      ini_set('session.gc_maxlifetime', 60 * 30);
      header("Location: http://webprog.cs.ship.edu/webprog25/Home.html");
      exit;
    }
    else
    {
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.html");
      exit;
    }
  }
  else
  {
    header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.html");
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
?>
