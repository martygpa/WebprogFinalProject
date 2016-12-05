<?php
/**
 * Login Handler
 * Author: Alec Waddelow
 * Date: 11/28/16
 * Time: 8:22 PM
 */
session_start();

require_once('../Gateways/UserGateway.php');
$conn = new UserGateway();
$conn->getConnection();

if(isset($_POST['loginSubmit']) && isset($_POST['userName']) && isset($_POST['password']))
{
    $userName = htmlspecialchars($_POST['userName']);
    $password = htmlspecialchars($_POST['password']);

    $returnSuccess = $conn->queryForLogin($userName, $password);
    if($returnSuccess>0)
    {
        $_SESSION['ID'] = $returnSuccess;
        ini_set('session.gc_maxlifetime', 60 * 30);
        header("Location: http://webprog.cs.ship.edu/webprog25/Home.html");
        exit;
    }
    else
    {
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
      exit;
    }
}
else
{
  header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
  exit;
}

?>
