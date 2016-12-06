<?php
    echo "before require";
    require("../Gateways/UserGateway.php");

  /*  if (!isset($_SESSION['ID']))
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/account_management/Login.html");
    }*/

    echo "before if";
/*
    if (1)
        echo "after if";
/*
        getConnection();
        $id = 2;//$_SESSION['ID'];
        //Grab current user from db
        $user = rowDataQueryByID($id);


        //Compare current PW to DB
        $old = $_POST["old"];
        $old = saltAndHash($old);
        if (strcmp($old, $user[4]))
        {
            //Update PW
            $new = $_POST["new"];
            $new = saltAndHash($new);
            $user[4] = $new;
            updateRow($user);
            echo "success";
        }
        else echo "strcmp fail";
*/
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