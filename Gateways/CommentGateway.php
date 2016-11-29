<?php

/**
 * Author: Alec Waddelow
 * Table Data Gateway to Comment table
 */
class CommentGateway
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
     * Queries Comment table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM Comment WHERE ID = '$id';";

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
        $query = "SELECT * FROM Comment;";

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
     * @param $object containing all five fields to be set in a single row in Comment table
     * @return bool true or false of success of insert
     */
    public function insertRow($object)
    {
        $ItemID = $object->ItemID;
        $UserID = $object->UserID;
        $Comment = $object->Comment;
        $Rating = $object->Rating;

        $con = $this->getConnection();
        $query = "INSERT INTO Comment (ItemID, UserID, Comment, Rating) VALUES ('$ItemID', '$UserID', '$Comment', '$Rating');";

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
        $UserID = $object->UserID;
        $Comment = $object->Comment;
        $Rating = $object->Rating;

        $query = "UPDATE Comment SET ItemID = '$ItemID', UserID = '$UserID', Comment = '$Comment', Rating = '$Rating' WHERE ID = '$ID';";
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