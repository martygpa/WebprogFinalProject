<?php
/**
 * Logout
 * Author: Alec Waddelow
 * Date: 12/14/2016
 */

session_start();
session_unset(); 
session_destroy();
header("Location: http://webprog.cs.ship.edu/webprog25/Home.php");
exit;
?>
