<?php

/**
 * WishListToItem Table Gateway Class
 * Author: Alec Waddelow & Ronald Sease & Darnell Martin
 * Date: 11/22/2016
 * Time: 15:22
 */
class WishListToItemGateway
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
     * Queries WishListToItem table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
          $con = $this->getConnection();
          $query = "SELECT * FROM WishListToItem WHERE WishListID = $id;";
          $entries = array();
          if ($result = $con->query($query))
          {
              while($row = $result->fetch_object()->ItemID)
              {
                array_push($entries, $row);
              }
              return $entries;
          }
          else
          {
            return false;
          }
    }

    /**
     * Returns entire table in one object
     *
     * @return bool $object of entire table result set
     */
    public function tableDataQuery()
    {
        $con = $this->getConnection();
        $query = "SELECT * FROM WishListToItem;";

        if ($result = $con->query($query))
        {
            $object = $result->fetch_object();
            return $object;
        }
        else
        {
            return false;
        }
    }

    /**
     * Insert a single row
     *
     * @param $object containing all three fields to be set in a single row in CartToItem table
     * @return bool true or false of success of insert
     */
    public function insertRow($object)
    {
        $ItemId = $object->ItemID;
        $WishListID = $object->WishListID;

        $con = $this->getConnection();
        $query = "INSERT INTO WishListToItem (ItemID, WishListID) VALUES ('$ItemId', '$WishListID');";
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

    /**
     * Updates a single row
     *
     * @param $object
     * @return bool
     */
    public function updateRow($object)
    {
        $con = $this->getConnection();
        $ID = $object->ID;
        $ItemID = $object->ItemID;
        $WishListID = $object->WishListID;

        $query = "UPDATE WishListToItem SET ItemID = '$ItemID', WishListID = '$WishListID' WHERE ID = '$ID';";
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

    /**
     * Deletes a single row based on cart id and item id
     *
     * @param $object
     * @return bool
     */
    public function deleteRow($WishListID, $ItemID)
    {

        $con = $this->getConnection();
        $query = "DELETE FROM WishListToItem WHERE ItemID = '$ItemID' AND WishListID = '$WishListID';";
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
