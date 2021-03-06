<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 12/6/16
 * Time: 3:53 PM
 */

require_once('../Gateways/ItemGateway.php');
require_once("../Gateways/UserGateway.php");

//Resume Session
session_start();

//Check if user is Logged In
if (isset($_SESSION['ID']))
{
    //check if user is admin
    $userGateway = new UserGateway();
    $user = $userGateway->rowDataQueryByID($_SESSION['ID']);
    if ($user['isAdmin'] == true)
    {
        //Deletes Item
        deleteItem();

    } else
    {
        echo "Insufficient Privilege";
    }
} else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}


//Deletes an Item from the DB
function deleteItem()
{
    $itemGateway = new ItemGateway();
    $id = $_POST['itemID'];

    if (!$itemGateway->deleteRow($id))
    {
        echo "<p>Error deleteing item!</p>";
    } else
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/admin/showItems.php");
    }
}
?>