<?php
require_once("../Models/ItemObject.php");

/**
 * Item Gateway Class
 * User: Alec Waddelow
 * Date: 11/22/2016
 * Time: 14:27
 */
class ItemGateway
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
            $con = $this->getConnection();
            $query = "SELECT * FROM webprog25.Item WHERE ID = ".$id.";";
            $result = $con->query($query);
            if($result>0)
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
        $query = "SELECT * FROM Item;";

        if ($result = $con->query($query))
        {
	        while($object = mysqli_fetch_object($result))
          {
            $array[] = $object;
          }
          return $array;
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
        $con = $this->getConnection();
        $Description = $object->Description;
        $UPC = $object->UPC;
        $Price = $object->Price;
        $Manufacturer = $object->Manufacturer;
        $Quantity = $object->Quantity;

        $query = "INSERT INTO Item (Description, UPC, Price, Manufacturer, Quantity) VALUES ('$Description', '$UPC', '$Price', '$Manufacturer', '$Quantity');";

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
        $con = $this->getConnection();
        $Description = $object->Description;
        $UPC = $object->UPC;
        $Price = $object->Price;
        $Manufacturer = $object->Manufacturer;
        $Quantity = $object->Quantity;

        $query = "UPDATE Item SET Description = '$Description', UPC = '$UPC', Price = '$Price', Manufacturer = '$Manufacturer', Quantity = '$Quantity';";

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

    /*
    * Gets each row as an object
    */
    // public function getByRowIDIntoArray($id)
    // {
    //   $con = $this->getConnection();
    //   $query = "SELECT * FROM webprog25.Item WHERE ID = ".$id.";";
    //   $entries = array();
    //   if ($result = $con->query($query))
    //   {
    //     while($row = $result->fetch_object())
    //     {
    //       $itemInCart = new ItemObject($row->ID, $row->Name, $row->Description, $row->UPC, $row->Price, $row->Manufacturer, $row->Quantity, $row->ImageLocation);
    //
    //       array_push($entries, $itemInCart);
    //     }
    //
    //   }
    //   echo $entires
    //   return "apples";
    // }

    public function getByRowIDIntoArray($id)
    {
        $con = $this->getConnection();
        $query = "SELECT * FROM webprog25.Item WHERE ID = ".$id.";";
        $entries = array();
          if ($result = $con->query($query))
          {
            while($row = $result->fetch_object())
            {

              $itemInCart = new ItemObject($row->ID, $row->Name, $row->Description, $row->UPC, $row->Price, $row->Manufacturer, $row->Quantity, $row->ImageLocation);

            }

          }
          return $itemInCart;
    }



}
