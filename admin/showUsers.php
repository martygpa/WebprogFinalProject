<?php
/**
 * showUsers.php
 * Ian Faust
 * CSC 434
 *
 */
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
        displayUsers();
    } else
    {
        echo "Insufficient Privilege";
    }
} else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}


function displayUsers()
{
    $userGateway = new UserGateway();
    $users = $userGateway->tableDataQuery();
    if (!$users) die("Query Error");

    echo "Users:<br>";
    echo "<table border=\"1\" cellpadding=\"10\"><tr><th>ID</th><th>FirstName</th><th>LastName</th><th>Username</th><th>Admin</th><th>Delete</th><th>Edit</th></tr>\n";
    $i = 0;
    while ($users[$i] != NULL)
    {
        $j = 0;
        echo '<tr>';
        echo '<td>'.$users[$i]->ID.'</td>';
        echo '<td>'.$users[$i]->FirstName.'</td>';
        echo '<td>'.$users[$i]->LastName.'</td>';
        echo '<td>'.$users[$i]->UserName.'</td>';
        echo '<td>'.$users[$i]->IsAdmin.'</td>';
        echo '<td><form action="deleteUser.php" method="post"><input type="hidden" name="userID" value="'.$users[$i]->ID.'"><input type="submit" value="Delete"></form></td>';
        echo '<td><form action="editUser.php" method="post"><input type="hidden" name="userID" value="' .$users[$i]->ID.'"><input type="submit" value="Edit"></form></td>';
        $i++;
    }
    echo "</table>";

}
?>