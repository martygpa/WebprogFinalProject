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
    public function rowDataQueryByUserID($id)
    {
      $con = $this->getConnection();
      $query = "SELECT * FROM Cart WHERE UserID = '".$id."';";
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
            $query = "SELECT * FROM Cart WHERE UserID = '$id';";
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
            $object = $result->fetch_objetct();
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
     */
    public function insertRow($object)
    {
        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "INSERT INTO Cart (UserID) VALUES (?)");

        mysqli_stmt_bind_param($statement, 's', $UserID);
        $UserID = $object->UserID;
        mysqli_stmt_execute($statement);

    }

    /**
     * Updates a single row
     *
     * @param $object
     */
    public function updateRow($object)
    {
        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "UPDATE Comment SET UserID=? WHERE ID =?");
        mysqli_stmt_bind_param($statement, 'ii', $UserID, $ID);
        $ID = $object->ID;
        $UserID = $object->UserID;
        mysqli_stmt_execute($statement);
    }
}
