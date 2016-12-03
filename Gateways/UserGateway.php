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
     */
    public function insertRow($object)
    {
        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "INSERT INTO User (FirstName, LastName, UserName, Password) VALUES (?, ?, ?, ?)");

        mysqli_stmt_bind_param($statement, 'ssssi', $FirstName, $LastName, $UserName, $LastName);
        $FirstName = $object->FirstName;
        $LastName = $object->LastName;
        $UserName = $object->UserName;
        $Password = $object->Password;
        mysqli_stmt_execute($statement);
    }

    /**
     * Update a single row
     *
     * @param $object containing all three fields to be set in a single row in CartToItem table
     */
    public function updateRow($object)
    {
        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "UPDATE User SET FirstName =?, LastName =?, UserName =?, Password =? WHERE ID=?");
        mysqli_stmt_bind_param($statement, 'ssssi', $FirstName, $LastName, $UserName, $LastName, $ID);

        $ID = $object->ID;
        $FirstName = $object->FirstName;
        $LastName = $object->LastName;
        $UserName = $object->UserName;
        $Password = $object->Password;
        mysqli_stmt_execute($statement);
    }

    /**
     * Queries Table to see if user exists already
     *
     * @param $object
     * @return bool true if user exists, false if they don't exist in DB
     */
    public function queryForLogin($userName, $password)
    {
        $conn = $this->getConnection();
        $query = "SELECT * FROM User WHERE UserName = '$userName', Password = '$password';";

        if($result = $conn->query($query))
        {
            $returnObject = $result->fetch_assoc();
            if($returnObject['ID'] != null)
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
