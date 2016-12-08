<?php
    /**
    * admin.php
    * Ian Faust
    *
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
            display();
        } else
        {
            echo "Insufficient Privilege";
        }
    } else
    {
        echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
    }

    function display()
    {
        echo
        '
        <p>Welcome Admin!</p>
        <a href="showItems.php">Edit Items</a><br>
        <a href="showUsers.php">Edit Users</a>
        '
        ;
    }
?>