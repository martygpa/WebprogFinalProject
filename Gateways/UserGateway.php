<?php

/**
 * Created by PhpStorm.
 * Author: Alec Waddelow
 * Date: 11/22/2016
 * Time: 14:46
 */
class UserGateway
{
    /**
     * @return  mysqli connection to the database
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
     * Queries User table by id
     *
     * @param $id
     * @return  $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = " SELECT * FROM User WHERE ID = '$id';";

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
        else
        {
            return false;
        }
    }

    /**
     * Returns entire table in one object
     *
     * @return $object of entire table result set
     */
    public function tableDataQuery()
    {
        $con = $this->getConnection();
        $query = "SELECT * FROM User;";

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
        $FirstName = $object->FirstName;
        $LastName = $object->LastName;
        $UserName = $object->UserName;
        $Password = $object->Password;

        $con = $this->getConnection();

        $query = "INSERT INTO User (FirstName, LastName, UserName, Password) VALUES ('$FirstName', '$LastName', '$UserName', '$Password');";

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
     * Update a single row
     *
     * @param $object containing all three fields to be set in a single row in CartToItem table
     * @return bool true or false of success of insert
     */
    public function updateRow($object)
    {
        $ID = $object->ID;
        $FirstName = $object->FirstName;
        $LastName = $object->LastName;
        $UserName = $object->UserName;
        $Password = $object->Password;

        $con = $this->getConnection();
        $query = "UPDATE User SET FirstName = '$FirstName', LastName = '$LastName', UserName = '$UserName', Password = '$Password' WHERE ID = '$ID';";

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
     * Queries Table to see if user exists already
     *
     * @param $object
     * @return bool true if user exists, false if they don't exist in DB
     */
    public function queryForLogin($object)
    {
        $userName = $object->userName;
        $password = $object->password;

        $conn = $this->getConnection();
        $query = "SELECT * FROM User WHERE UserName = '$userName', Password = '$password';";

        if($result = $conn->query($query))
        {
            $returnObject = $result->fetch_object();
            if($returnObject->ID == null)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}