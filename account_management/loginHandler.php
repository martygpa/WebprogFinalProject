<?php
/**
 * Login Handler
 * Author: Alec Waddelow
 * Date: 11/28/16
 * Time: 8:22 PM
 */
session_start();

require_once 'UserGateway.php';


$conn = new UserGateway();
$conn->getConnection();

if(isset($_POST['loginSubmit']) && isset($_POST['userName']) && isset($_POST['password']))
{
    $userName = htmlspecialchars($_POST['userName']);
    $password = htmlspecialchars($_POST['password']);

    $returnID = $conn->queryForLogin($userName, $password);
    if(is_int($returnID))
    {
        $_SESSION['ID'] = $returnID;
        ini_set('session.gc_maxlifetime', 60 * 30);
        header("Location: http://webprog.cs.ship.edu/webprog25/index.html");
        exit;
    }
    else
    {
      die("Invalid Username/Password Combination");
    }

}
