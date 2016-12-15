<?php
/**
 * Login Handler
 * Author: Alec Waddelow
 * Date: 11/28/16
 */
session_start();

require_once('../Gateways/UserGateway.php');
$conn = new UserGateway();
$conn->getConnection();

if(isset($_POST['loginSubmit']) && isset($_POST['userName']) && isset($_POST['password']))
{
    $userName = sanitizeData($_POST['userName']);
    $password = sanitizeData($_POST['password']);
    $token = saltAndHash($password);

    $returnSuccess = $conn->queryForLogin($userName, $token);
    if($returnSuccess>0)
    {
        $_SESSION['ID'] = $returnSuccess;
        $_SESSION['isLoggedIn'] = true;
        ini_set('session.gc_maxlifetime', 60 * 30);
        header("Location: http://webprog.cs.ship.edu/webprog25/Home.php");
        exit;
    }
    else
    {
      $_SESSION['isLoggedIn'] = false;
      header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
      exit;
    }
}
else
{
  header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
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
