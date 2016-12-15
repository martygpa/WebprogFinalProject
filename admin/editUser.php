<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 12/6/16
 * Time: 3:53 PM
 */

require_once("../Gateways/UserGateway.php");

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
            updateUser();
        }
        //Shows current item information in editable forms
        displayUserForm();

    } else
    {
        echo "Insufficient Privilege";
    }
} else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}

//Shows current user information in editable forms
function displayUserForm()
{
    $id = $_POST['userID'];
    $editUserGateway = new UserGateway();
    $editUser = $editUserGateway->rowDataQueryByID($id);

    if ($editUser != null)
    {
        echo '<form action="editUser.php" method="post">';
        echo 'User ID:' . $editUser['ID'] . '<br>';
        echo '<input name="userID" type="hidden" value="' . $editUser['ID'] . '">';
        echo 'First Name: <input name="FirstName" type="text" value="' . $editUser['FirstName'] . '"><br> ';
        echo 'Last Name: <input name="LastName" type="text" value="' . $editUser['LastName'] . '"><br> ';
        echo 'Username: <input name="UserName" type="text" value="' . $editUser['UserName'] . '"><br>  ';
        if ($editUser['isAdmin'] == 1)
            echo 'Admin: <input name="IsAdmin" type="checkbox" value="1" checked="checked"><br>  ';
        else
            echo 'Admin: <input name="IsAdmin" type="checkbox" value="1"><br>  ';
        echo '<input name="update" type="hidden" value="true">';
        echo '<input type="submit" value="Submit">';
        echo '</form>';
    } else
    {
        echo "Error retrieving user!";
    }
}

//Updates User and displays Update Status
function updateUser()
{
    $updateUserGateway = new UserGateway();
    $id = $_POST['userID'];
    $updateUser = $updateUserGateway->rowDataQueryByID($id);
    $updateUser['FirstName'] = $_POST['FirstName'];
    $updateUser['LastName'] = $_POST['LastName'];
    $updateUser['UserName'] = $_POST['UserName'];
    if ($_POST['IsAdmin'])
        $updateUser['IsAdmin'] = 1;
    else
        $updateUser['IsAdmin'] = 0;
    unset($_POST['update']);

    if (!$updateUserGateway->updateRow($updateUser))
    {
        echo "<p>Error updating user!</p>";
    } else
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/admin/showUsers.php");
    }
}
?>
