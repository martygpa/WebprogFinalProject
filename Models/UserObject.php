<?php

/*
* Programmer: Alec Waddelow
* Class: CSC434
* Assignment: Final Project - E-Commerce
* Professor: Dr. Girard
*
* User Object class
*/

class UserObject
{
  public $firstName;
  public $lastName;
  public $userName;
  public $password;
  public $isAdmin;


  function UserObject($firstName, $lastName, $userName, $password, $isAdmin)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->userName = $userName;
    $this->password = $password;
    $this->isAdmin = $isAdmin;
  }
}
?>
