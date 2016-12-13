<?php

/**
 * WishListToItem Table Gateway Class
 * Author: Alec Waddelow & Ronald Sease & Darnell Martin
 * Date: 11/22/2016
 * Time: 15:22
 */
class OrderHistoryToItemGateway
{
    /**
     * @return  connection to the database
     */
    public function getConnection()
    {
        $hostName = "webprog.cs.ship.edu";
        $database = "webprog25";
        $userName = "webprog25";
        $password = "gililtea";

        $connection = new mysqli($hostName, $userName, $password, $database);

        if ($connection->connect_error)
        {
            echo "Failed to connect to the Database";
        }
        return $connection;
    }


    /**
     * Insert a single row
     *
     * @param $object containing all three fields to be set in a single row in Or table
     * @return bool true or false of success of insert
     */
    public function insertRow($newestHistoryID, $itemID)
    {
        $con = $this->getConnection();
        $query = "INSERT INTO OrderHistoryToItem (OrderHistoryID, ItemID) VALUES ('$newestHistoryID', '$itemID');";
        if($result = $con->query($query))
        {
            $success = true;
        }
        else
        {
            $success = false;
        }
        return $success;
    }
}
