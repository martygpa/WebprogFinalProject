<?php

/**
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

        if($connection->connect_error)
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
    public function rowDataQueryByID($ID)
    {
		$conn = $this->getConnection();

        $query = "SELECT * FROM User WHERE ID = $ID;";
		if($result = $conn->query($query))
		{
		$returnObject = $result->fetch_assoc();
		return $returnObject;
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
     * Insert a single row
     *
     * @param $object containing all three fields to be set in a single row in User table
     */
    public function insertRow($UserObject)
    {
        $con = $this->getConnection();

        if($statement = $con->prepare("INSERT INTO User (FirstName, LastName, UserName, Password, isAdmin) VALUES (?, ?, ?, ?, ?)"))
        {
          $FirstName = $UserObject->firstName;
          $LastName = $UserObject->lastName;
          $UserName = $UserObject->userName;
          $Password = $UserObject->password;
          $isAdmin = $UserObject->isAdmin;

          $statement->bind_param('ssssi', $FirstName, $LastName, $UserName, $Password, $isAdmin);
          if($statement->execute())
          {
            $success = true;
          }
          else
          {
            $success = false;
          }

        }
        return $success;
    }

    /**
     * Update a single row
     *
     * @param $object containing all three fields to be set in a single row in User table
     */
    public function updateRow($object)
    {
        $ID = $object['ID'];
        $FirstName = $object['FirstName'];
        $LastName = $object['LastName'];
        $UserName = $object['UserName'];
        $Password = $object['Password'];
        $IsAdmin = $object['IsAdmin'];

        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "UPDATE User SET FirstName =?, LastName =?, UserName =?, Password =?, isAdmin=? WHERE ID=?");
        mysqli_stmt_bind_param($statement, 'ssssii', $FirstName, $LastName, $UserName, $Password, $IsAdmin, $ID);
        return mysqli_stmt_execute($statement);
    }


    public function updatePassword($password, $id)
    {
	$con = $this->getConnection();
	$statement = mysqli_prepare($con, "UPDATE User Set Password=? WHERE ID = ?");
	mysqli_stmt_bind_param($statement, 'si', $password, $id);
	return mysqli_stmt_execute($statement);
    } 


    /**
     * Queries Table to see if user exists already
     *
     * @param $userName $password
     * @return bool true if user exists, false if they don't exist in DB
     */
    public function queryForLogin($userName, $password)
    {
         $conn = $this->getConnection();
         $query = "SELECT * FROM User WHERE UserName ='$userName' AND Password ='$password';";
         if($result = $conn->query($query))
         {
           $returnObject = $result->fetch_assoc();
           if($returnObject['ID'] > 0)
           {
              return $returnObject['ID'];
           }
           else 
       	   {
         	  return false;
           }
         }
    }

    /*
     * Changes the first name of a user in the table
     * Author: Alec Waddelow & Ronald Sease
     */
     public function updateFirstName($name, $id)
     {
	$con = $this->getConnection();
	$statement = mysqli_prepare($con, "UPDATE User SET FirstName = ? WHERE ID = ?");
	mysqli_stmt_bind_param($statement, 'si', $name, $id);
	return mysqli_stmt_execute($statement); 
     }

     /*
     * Changes the last name of a user in the table
     * Author: Alec Waddelow & Ronald Sease
     */
     public function updateLastName($name, $id)
     {
	$con = $this->getConnection();
	$statement = mysqli_prepare($con, "UPDATE User SET LastName = ? WHERE ID = ?");
	mysqli_stmt_bind_param($statement, 'si', $name, $id);
	return mysqli_stmt_execute($statement); 
     }

    /*
     * Changes the last name of a user in the table
     * Author: Alec Waddelow & Ronald Sease
     */
     public function updateUserName($name, $id)
     {
	$con = $this->getConnection();
	$statement = mysqli_prepare($con, "UPDATE User SET UserName = ? WHERE ID = ?");
	mysqli_stmt_bind_param($statement, 'si', $name, $id);
	return mysqli_stmt_execute($statement); 
     }


    /*
     * Delete a user from the table
     * Author: Ian
     */
    public function deleteRow($id)
    {
        $con = $this->getConnection();
        $statement = mysqli_prepare($con, "DELETE FROM User WHERE ID = ?");
        mysqli_stmt_bind_param($statement, 'i', $id);
        return mysqli_stmt_execute($statement);
    }

    
}
