<?php
/**
 * Order History Gateway
 * Author: Ronald Sease
 */
class OrderHistoryGateway
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
            $query = "SELECT * FROM OrderHistory WHERE ID = '$id';";

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
     * Queries WishList table by user id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByUserID($id)
    {
      $con = $this->getConnection();
      $query = "SELECT * FROM webprog25.OrderHistory WHERE UserID = ".$id.";";
      $array = array();
      if($result = $con->query($query))
      {
        while($object = mysqli_fetch_object($result))
        {
          $entry = new stdClass();
          $entry->ID = $object->ID;
          $entry->DateCreated = $object->DateCreated;
          array_push($array, $entry);
        }
        return $array;
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
    public function insertRow($UserID)
    {
        $con = $this->getConnection();

        $statement = mysqli_prepare($con, "INSERT INTO OrderHistory (UserID) VALUES (".$UserID.");");
        mysqli_stmt_execute($statement);
    }
}
