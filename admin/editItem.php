<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 12/6/16
 * Time: 3:53 PM
 */

require_once('../Gateways/ItemGateway.php');
require_once('../Gateways/UserGateway.php');

//Resume Session
session_start();

//Check if user is Logged In
if (isset($_SESSION['ID']))
{
    //check if user is admin
    $userGateway = new UserGateway();
    $user = $userGateway->rowDataQueryByID($_SESSION['ID']);

    if ($user['isAdmin'] == 1)
    {
        //Check if information was updated
        if (isset($_POST['update']))
        {
            updateItem();
        }
        //Shows current item information in editable forms
        displayItemForm();

    } 
	else
    {
        echo "Insufficient Privilege";
    }
}
else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}

//Shows current item information in editable forms
function displayItemForm()
{
    $itemGateway = new ItemGateway();
    $id = $_POST['itemID'];
    $item = $itemGateway->queryRow($id);

    if ($item != null)
    {
        echo '<form action="editItem.php" method="post">';
        echo 'Item ID:' . $item['ID'] . '<br>';
        echo '<input name="itemID" type="hidden" value="' . $item['ID'] . '">';
        echo 'Name: <input name="Name" type="text" value="' . $item['Name'] . '"><br> ';
        echo 'Description: <input name="Description" type="text" value="' . $item['Description'] . '"><br> ';
        echo 'UPC: <input name="UPC" type="text" value="' . $item['UPC'] . '"><br>  ';
        echo 'Price: <input name="Price" type="text" value="' . $item['Price'] . '"><br>  ';
        echo 'Manufacturer: <input name="Manufacturer" type="text" value="' . $item['Manufacturer'] . '"><br> ';
        echo 'Quantity: <input name="Quantity" type="text" value="' . $item['Quantity'] . '"><br>  ';
        echo 'Image Location: <input name="ImageLocation" type="text" value="' . $item['ImageLocation'] . '"><br>  ';
        echo '<input name="update" type="hidden" value="true">';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    } 
else
    {
        echo "Error retrieving item!";
    }
}

//Updates Item and displays Update Status
function updateItem()
{
    $itemGateway = new ItemGateway();
    $id = $_POST['itemID'];
    $item = $itemGateway->rowDataQueryByID($id)[0];
    $item->Name = $_POST['Name'];
    $item->Description = $_POST['Description'];
    $item->UPC = $_POST['UPC'];
    $item->Price = $_POST['Price'];
    $item->Manufacturer = $_POST['Manufacturer'];
    $item->Quantity = $_POST['Quantity'];
    $item->ImageLocation = $_POST['ImageLocation'];
    unset($_POST['update']);

    if (!$itemGateway->updateRow($item))
    {
        echo "<p>Error updating item!</p>";
    } else
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/admin/showItems.php");
    }
}
?>
