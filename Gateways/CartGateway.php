<?php

/**
 * Cart Gateway
 * Author: Alec Waddelow
 * Date: 11/22/2016
 * Time: 14:20
 */
class CartGateway
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
     * Queries Cart table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM Cart WHERE ID = '$id';";

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
    }

    /**
     * Returns entire table in one object
     *
     * @return bool $object of entire table result set
     */
    public function tableDataQuery()
    {
        $con = $this->getConnection();
        $query = "SELECT * FROM Cart;";

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
        $UserID = $object->UserID;
        $con = $this->getConnection();
        $query = "INSERT INTO Cart (UserID) VALUES ('$UserID');";

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
        $UserID = $object->UserID;

        $query = "UPDATE Comment SET UserID = $UserID WHERE ID = '$ID';";
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