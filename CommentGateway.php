<?php

/**
 * Author: Alec Waddelow
 *
 */
class CommentGateway
{
    /**
     * @return connection to the database
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
     * @return bool
     */
    public function rowDataQueryByID($id)
    {
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM InventoryItem WHERE id = $id;";

            if ($result = $con->query($query))
            {

                $row = $result->fetch_object();
                return $row;
            }
            else
            {
                return false;
            }
        }
    }



}