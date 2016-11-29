<?php
/**
 * Login Handler
 * Author: Alec Waddelow
 * Date: 11/28/16
 * Time: 8:22 PM
 */


require_once 'UserGateway.php';

$conn = new UserGateway();
$conn->getConnection();

if(isset($_POST['loginSubmit']) && isset($_POST['userName']) && isset($_POST['password']))
{
    $username = htmlspecialchars($_POST['userName']);
    $password = htmlspecialchars($_POST['password']);

    $returnSet = $conn->tableDataQuery();
    if($returnSet == true)
    {
        //begin session with user now logged in
        //redirect to home page for browsing 
    }

}