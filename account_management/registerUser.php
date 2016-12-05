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

if(isset($_POST['registerSubmit']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['userName']) && isset($_POST['password']))
{
    $firstName = htmlspecialchars($_POST['firstName']);
    $lastName =  htmlspecialchars($_POST['lastName']);
    $userName = htmlspecialchars($_POST['userName']);
    $password = htmlspecialchars($_POST['password']);

    $newUser = new UserObject($firstName, $lastName, $userName, $password);

    $gateway->insertRow($newUser);
    header("Location: http://webprog.cs.ship.edu/webprog25/Home.html")
    exit;
}
else
{
  echo("failure ");
  //header("Location: http://webprog.cs.ship.edu/webprog25/account_management/registerAccount.html");
  //exit;
}
?>
