<?php
/**
 * Created by PhpStorm.
 * User: ian
 * Date: 12/6/16
 * Time: 3:53 PM
 */

require_once('../Gateways/ItemGateway.php');
require_once("../Gateways/UserGateway.php");
require_once("../Models/ItemObject.php");

//Resume Session
session_start();

//Check if user is Logged In
if (isset($_SESSION['ID']))
{
    //check if user is admin
    $userGateway = new UserGateway();
    $user = $userGateway->rowDataQueryByID($_SESSION['ID']);
    if ($user['isAdmin'] == true)
    {
        //Check if item info had already been filled out
        if (isset($_POST['add']))
        {
            unset($_POST['add']);
            addItem();
            header("Location : http://webprog.cs.ship.edu/webprog25/admin/showItems.php");
        }
        //Shows a form for adding a new item
        displayAddForm();

    } else
    {
        echo "Insufficient Privilege";
    }
} else
{
    echo '<p>Not Logged In</p><a href="http://webprog.cs.ship.edu/webprog25/account_management/Login.html">Login?</a>';
}

//Shows current item information in editable forms
function displayAddForm()
{

        echo '<form action="addItem.php" method="post" enctype="multipart/form-data">';
        echo "Item ID will be auto generated.<br>";
        echo 'Name: <input name="Name" type="text" placeholder="Item Name" required="required"><br> ';
        echo 'Description: <input name="Description" type="text" placeholder="Description" required="required"><br> ';
        echo 'UPC: <input name="UPC" type="text" placeholder="UPC" required="required"><br>  ';
        echo 'Price: <input name="Price" type="text" placeholder="Price (USD)" required="required"><br>  ';
        echo 'Manufacturer: <input name="Manufacturer" type="text" placeholder="Manufacturer" required="required"><br> ';
        echo 'Quantity: <input name="Quantity" type="text" placeholder="Quantity" required="required"><br>  ';
        echo 'Image: <input name="Image" type="file" required="required"><br>  ';
        echo '<input name="add" type="hidden" value="true">';
        echo '<input type="submit" value="Submit" name="submit">';
        echo '</form>';
}

//Updates Item and displays Update Status
function addItem()
{
    $itemGateway = new ItemGateway();
    $item = new ItemObject();

    //Adding normal attributes to new item object
    $item->Name = $_POST['Name'];
    $item->Description = $_POST['Description'];
    $item->UPC = $_POST['UPC'];
    $item->Price = $_POST['Price'];
    $item->Manufacturer = $_POST['Manufacturer'];
    $item->Quantity = $_POST['Quantity'];

    /* Upload image and add its location to the item object
     * Image upload code based off http://www.w3schools.com/php/php_file_upload.asp
     */
    $target_dir = "/home/webprog25/public_html/images/items/";
    $target_file = $target_dir . basename($_FILES["Image"]["name"]);
    echo "Uploading ".$_FILES["Image"]["name"]."<br>";
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["Image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".<br>";
            $uploadOk = 1;
        } else {
            echo "File is not an image.<br>";
            $uploadOk = 0;
        }
    }
// Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.<br>";
        $uploadOk = 0;
    }
// Check file size
//    if ($_FILES["Image"]["size"] > 500000) {
//        echo "Sorry, your file is too large.";
//        $uploadOk = 0;
//    }
 //Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        die("Sorry, your file was not uploaded.<br>");
// if everything is ok, try to upload file
    } else {
        if (!move_uploaded_file($_FILES["Image"]["tmp_name"], $target_file))
        {
            die("Sorry, there was an error uploading your file.");
        }
    }

    //Resume my code
    $item->ImageLocation = "./images/items/".$_FILES["Image"]["name"];

    if (!$itemGateway->insertRow($item))
    {
        echo "<p>Error updating item!</p>";
    } else
    {
        header("Location: http://webprog.cs.ship.edu/webprog25/admin/showItems.php");
    }
}
?>