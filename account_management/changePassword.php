<a href="http://webprog.cs.ship.edu/webprog25">Home<br></a>
<?php
    require_once("../Gateways/UserGateway.php");

    //Resume Session
    session_start();

    //Check if user is Logged In
    if (isset($_SESSION['ID']))
    {
        //Grab current user from db
        $gateway = new UserGateway();
        $id = $_SESSION['ID'];
        $user = $gateway->rowDataQueryByID($id);

        //Compare current PW to DB
        $old = $_POST["old"];
        $old = saltAndHash($old);
        if (!strcmp($old, $user[0]->Password))
        {
            //Update PW
            $new = $_POST["new"];
            $new = saltAndHash($new);
            $user[0]->Password = $new;
            $gateway->updateRow($user[0]);
            successMsg();
        } else
        {
            failureMsg();
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

    //Message for successful password change
    function successMsg()
    {
        echo "Password has been changed successfuly.";
    }

    //Message for failed password change
    function failureMsg()
    {
        echo 'Password was incorrect! <a href="http://webprog.cs.ship.edu/webprog25/account_management/changePassword.html">Try Again</a>';
    }
?>