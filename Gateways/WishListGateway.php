<?php

/**
 * WishList Table Gateway Class
 * Author: Alec Waddelow & Ronald Sease & Darnell Martin
 * Date: 11/22/2016
 * Time: 15:20
 */
class WishListGateway
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
     * Queries WishList table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM WishList WHERE ID = '$id';";
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

    public function rowDataQueryByUserID($id)
    {
            $con = $this->getConnection();
            $query = "SELECT * FROM WishList WHERE UserID = ".$id.";";
            if ($result = $con->query($query))
            {
              while($object = mysqli_fetch_object($result))
              {
                $array[] = $object;
              }
              return $array;
            }
            else
            {
                return false;
          }
    }

    /**
     * Queries WishList table by user id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByUserID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM WishList WHERE UserID = '$id';";
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
        $query = "SELECT * FROM WishList;";

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
        $UserID = $object->UserID;
        $con = $this->getConnection();
        $query = "INSERT INTO WishList (UserID) VALUES ('$UserID');";

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

        $query = "UPDATE WishList SET UserID = '$UserID' WHERE ID = '$ID';";
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
