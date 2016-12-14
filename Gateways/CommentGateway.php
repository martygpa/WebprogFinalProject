<?php

/**
 * Author: Darnell Martin
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
            $id = $this->sanitize($id);
            $con = $this->getConnection();
            $query = "SELECT * FROM webprog25.Comment WHERE ID = ".$id.";";
            if ($result = $con->query($query))
            {
              while($object = mysqli_fetch_object($result))
              {
                $array[] = $object;
              }
            }
            else
            {
                return false;
            }
        }
    }

    public function rowDataQueryByItemID($id)
    {
      $id = $this->sanitize($id);
      $con = $this->getConnection();
      $query = "SELECT * FROM webprog25.Comment WHERE ItemID = ".$id.";";
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

    public function rowDataQueryByJoinID($id)
    {
      $id = $this->sanitize($id);
      $con = $this->getConnection();
      $query = ("SELECT A.UserName AS UserName, B.Comment AS Comment, B.Rating AS Rating,B.ID AS ID FROM webprog25.User AS A , webprog25.Comment AS B WHERE A.ID = B.UserID AND B.ItemID = ".$id.";");
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
        $ItemID = $this->sanitize($object->ItemID);
        $UserID = $this->sanitize($object->UserID);
        $Comment = $this->sanitize($object->Comment);
        $Rating = $this->sanitize($object->Rating);

        $con = $this->getConnection();
        $query = "INSERT INTO Comment (ItemID, UserID, Comment, Rating) VALUES (".$ItemID."," .$UserID.", '".$Comment."', '".$Rating."');";

        if ($result = $con->query($query))
        {
            $success = true;
        }
        else
        {
            $success = false;
        }
        return $success;
    }

    public function sanitize($input)
    {
      return preg_replace('/[;{%()}]/', '', $input);
    }
}
