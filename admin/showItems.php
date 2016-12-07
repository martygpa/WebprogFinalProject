<form action="addItem.php"><input type="submit" value="Add Item"></form>
<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 11/29/16
 * Time: 9:30 AM
 */

/*Add Item*/
/*Edit Item*/
/*Delete Item*/
/*Display Items*/

require_once('../Gateways/ItemGateway.php');
require_once("../Gateways/UserGateway.php");

//Resume Session
session_start();

//Check if user is Logged In
if (isset($_SESSION['ID']))
{
    //check if user is admin
    $userGateway = new UserGateway();
    $user = $userGateway->rowDataQueryByID($_SESSION['ID'])[0];
    if ($user->IsAdmin)
    {
        displayItems();
    } else
    {
        echo "Insufficient Privilege";
    }
} else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}


function displayItems()
{
    $itemGateway = new ItemGateway();
    $items = $itemGateway->tableDataQuery();
    if (!$items) die("Query Error");

    echo "Items:<br>";
    echo "<table border=\"1\" cellpadding=\"10\"><tr><th>ID</th><th>Name</th><th>Description</th><th>UPC</th><th>Price</th><th>Manufacturer</th><th>Quantity</th><th>ImageLocation</th><th>Delete</th><th>Edit</th></tr>\n";
    $i = 0;
    while ($items[$i] != NULL)
    {
        $j = 0;
        echo '<tr>';
        echo '<td>'.$items[$i]->ID.'</td>';
        echo '<td>'.$items[$i]->Name.'</td>';
        echo '<td>'.$items[$i]->Description.'</td>';
        echo '<td>'.$items[$i]->UPC.'</td>';
        echo '<td>'.$items[$i]->Price.'</td>';
        echo '<td>'.$items[$i]->Manufacturer.'</td>';
        echo '<td>'.$items[$i]->Quantity.'</td>';
        echo '<td>'.$items[$i]->ImageLocation.'</td>';
        echo '<td><form action="deleteItem.php" method="post"><input type="hidden" name="itemID" value="'.$items[$i]->ID.'"><input type="submit" value="Delete"></form></td>';
        echo '<td><form action="editItem.php" method="post"><input type="hidden" name="itemID" value="' .$items[$i]->ID.'"><input type="submit" value="Edit"></form></td>';
        $i++;
    }
    echo "</table>";

}
?>