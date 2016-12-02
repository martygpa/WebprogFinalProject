<?php

/**
 * CartToItem Gateway Class
 * Author: Alec Waddelow
 * Date: 11/22/2016
 * Time: 14:12
 */
class CartToItemGateway
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
     * Queries CartToItem table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
      if(is_int($id))
      {
          $con = $this->getConnection();
          $query = "SELECT * FROM CartToItem WHERE CartID = '$id';";
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
    }

    /**
     * Returns entire table in one object
     *
     * @return bool $object of entire table result set
     */
    public function tableDataQuery()
    {
        $con = $this->getConnection();
        $query = "SELECT * FROM CartToItem;";

        if ($result = $con->query($query))
        {
            $object = $result->fetch_object();
            return $object;
        } else
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
        $ItemID = $object->ItemID;
        $CartID = $object->CartID;

        $con = $this->getConnection();
        $query = "INSERT INTO CartToItem (CartID, ItemID) VALUES ('$CartID', '$ItemID');";

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
        $CartID = $object->CartID;
        $ItemID = $object->ItemID;

        $query = "UPDATE Comment SET ItemID = '$ItemID', CartId = '$CartID' WHERE ID = '$ID';";
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
