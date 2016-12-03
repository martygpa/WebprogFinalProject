<?php
class ItemObject
{
  public $id;
  public $Name;
  public $Description;
  public $UPC;
  public $Price;
  public $Manufacturer;
  public $Quantity;
  public $ImageLocation;

  function ItemObject($id, $Name, $Description, $UPC, $Price, $Manufacturer, $Quantity, $ImageLocation)
  {
    $this->id = $id;
    $this->Name = $Name;
    $this->Description = $Description;
    $this->UPC = $UPC;
    $this->Price = $Price;
    $this->Manufacturer = $Manufacturer;
    $this->Quantity = $Quantity;
    $this->ImageLocation = $ImageLocation;
  }
}
?>
