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

        if (isset($_POST["submit"]))
        {
            unset($_POST["submit"]);
            //Compare current PW to DB
            $old = $_POST["old"];
            $old = saltAndHash($old);
            if (!strcmp($old, $user[0]->Password)) {
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
            echo    '<form action="changePassword.php" method="post" onsubmit="changePassword.php">
                    Old Password:
                    <br>
                    <input type="password" name="old" id="old" value="" required="required">
                    <br>
                    New Password:
                    <br>
                    <input type="password" name="new" id="new" value ="" required="required">
                    <br>
                    <br>
                    <input type="submit" value="Submit" name="submit">
                    </form>';
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
        echo 'Password was incorrect! <a href="http://webprog.cs.ship.edu/webprog25/account_management/changePassword.php">Try Again</a>';
    }
?>