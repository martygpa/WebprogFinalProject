<?php

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
        if(is_int($id))
        {
            $con = $this->getConnection();
            $query = "SELECT * FROM Item WHERE ID = $id;";

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
        $query = "SELECT * FROM Item;";

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
        $con = $this->getConnection();
        $Description = $object->Description;
        $UPC = $object->UPC;
        $Price = $object->Price;
        $Manufacturer = $object->Manufacturer;
        $Quantity = $object->Quantity;

        $query = "INSERT INTO Item (Description, UPC, Price, Manufacturer, Quantity) VALUES ($Description, $UPC, $Price, $Manufacturer, $Quantity);";

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

        $query = "UPDATE Item SET Description = $Description, UPC = $UPC, Price = $Price, Manufacturer = $Manufacturer, Quantity = $Quantity;";

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