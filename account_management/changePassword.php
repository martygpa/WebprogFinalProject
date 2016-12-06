<?php
    echo "before require";
    require_once("../Gateways/UserGateway.php");

    if (isset($_SESSION['ID']))
    {
        $gateway = new UserGateway();
        $id = $_SESSION['ID'];
        //Grab current user from db
        $user = $gateway->rowDataQueryByID($id);
        echo $user[0]->ID;


        //Compare current PW to DB
        $old = $_POST["old"];
        echo $old;
        $old = saltAndHash($old);
        echo "<br>".$old;
        echo "<br>".$user[0]->Password;
        if (!strcmp($old, $user[0]->Password))
        {
            //Update PW
            $new = $_POST["new"];
            $new = saltAndHash($new);
            $user[0]->Password = $new;
            $gateway->updateRow($user[0]);
        }
    } else
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
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
?>