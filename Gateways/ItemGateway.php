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
     * Queries Item table by id
     *
     * @param $id
     * @return bool $object containing result set data, else returns false
     */
    public function rowDataQueryByID($id)
    {
      $id = $this->sanitize($id);
      $con = $this->getConnection();
      $query = "SELECT * FROM webprog25.Item WHERE ID = ".$id.";";

      if($result = $con->query($query))
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
	* Author: Alec Waddelow
	*
	*
	*/
	public function queryRow($id)
	{
		//$id = $this->sanitize($id);
		$con = $this->getConnection();
		
		$query = "SELECT * FROM webprog25.Item WHERE ID = " . $id . ";";

		if($result = $con->query($query))
		{
			$row = $result->fetch_assoc();
			return $row;
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
        $Name = $this->sanitize($object->Name);
        $Description = $this->sanitize($object->Description);
        $UPC = $this->sanitize($object->UPC);
        $Price = $this->sanitize($object->Price);
        $Manufacturer = $this->sanitize($object->Manufacturer);
        $Quantity = $this->sanitize($object->Quantity);
        $ImageLocation = $this->sanitize($object->ImageLocation);

        //$query = "INSERT INTO Item (Name, Description, UPC, Price, Manufacturer, Quantity, ImageLocation) VALUES ('$Name', '$Description', '$UPC', '$Price', '$Manufacturer', '$Quantity', '$ImageLocation');";
        $stmt = $conn->prepare("INSERT INTO Item (Name, Description, UPC, Price, Manufacturer, Quantity, ImageLocation)
                                VALUES (? , ? , ? , ? , ? , ? ,? );");
        $stmt->bindParam('s', $Name);
        $stmt->bindParam('s', $Description);
        $stmt->bindParam('s', $UPC);
        $stmt->bindParam('d', $Price);
        $stmt->bindParam('s', $Manufacturer);
        $stmt->bindParam('i', $Quantity);
        $stmt->bindParam('s', $ImageLocation);
        if($result = $stmt->execute())
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
        $ID = $object->ID;
        $Name = $object->Name;
        $Description = $object->Description;
        $UPC = $object->UPC;
        $Price = $object->Price;
        $Manufacturer = $object->Manufacturer;
        $Quantity = $object->Quantity;
        $ImageLocation = $object->ImageLocation;

        $stmt = $conn->prepare("UPDATE Item SET
                                Name = ?,
                                Description = ?,
                                UPC = ?,
                                 Price = ?,
                                Manufacturer = ?,
                                Quantity = ?,
                                ImageLocation = ?
                                WHERE ID= ? ;");
        $stmt->bindParam('s', $Name);
        $stmt->bindParam('s', $Description);
        $stmt->bindParam('s', $UPC);
        $stmt->bindParam('d', $Price);
        $stmt->bindParam('s', $Manufacturer);
        $stmt->bindParam('i', $Quantity);
        $stmt->bindParam('s', $ImageLocation);
        $stmt->bindParam('i', $ID);

        if($result = $stmt->execute())
        {
            $success = true;
        }
        else
        {
            $success = false;
        }
        return $success;
    }

    public function getByRowIDIntoArray($id)
    {
        $id = $this->sanitize($id);
        $con = $this->getConnection();
        $query = "SELECT * FROM webprog25.Item WHERE ID = ".$id.";";
        if ($result = $con->query($query))
        {
          while($row = $result->fetch_object())
          {
            $itemInCart = new ItemObject($row->ID, $row->Name, $row->Description, $row->UPC, $row->Price, $row->Manufacturer, $row->Quantity, $row->ImageLocation);
          }
        }
       return $itemInCart;
    }

    /*
     * Delete an item from the table
     * Author: Ian
     */
    public function deleteRow($id)
    {
        $id = $this->sanitize($id);
        $con = $this->getConnection();
        $query = "DELETE FROM Item WHERE ID = ".$id.";";
        return $con->query($query);
    }

    public function sanitize($input)
    {
      return preg_replace('/[;{%()}]/', '', $input);
    }
}
