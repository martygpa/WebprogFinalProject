<?php
/**
 * Logout
 * Author: Alec Waddelow
 * Date: 12/14/2016
 */

 session_start();
 session_destroy();
 echo "
 <html>
 <p1> Successfully logged out! </p1>
 <a href='webprog.cs.ship.edu/webprog25/Home.php'> Home </a>

 </html>";
 exit;
 ?>
