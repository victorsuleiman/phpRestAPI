<?php

// mysql> DESC Customers;
// +------------+------------------+------+-----+---------+----------------+
// | Field      | Type             | Null | Key | Default | Extra          |
// +------------+------------------+------+-----+---------+----------------+
// | CustomerID | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
// | Name       | char(50)         | NO   |     | NULL    |                |
// | Address    | char(100)        | NO   |     | NULL    |                |
// | City       | char(30)         | NO   |     | NULL    |                |
// +------------+------------------+------+-----+---------+----------------+
// 4 rows in set (0.01 sec)

class Customer  {

    //Attributes for our POPO
    private $CustomerID;
    private $Name;
    private $Address;
    private $City;

    // //Consturct that bad boy!
    // public function __construct(String $newName, String $newAddress, String $newCity)   {

    //     $this->Name = $newName;
    //     $this->Address = $newAddress;
    //     $this->City = $newCity;
    // }

    function getCustomerID(): int {
        return $this->CustomerID;
    }

    function getName(): String {
        return $this->Name;
    }

    function getAddress(): String {
        return $this->Address;
    }

    function getCity(): String  {
        return $this->City;
    }


    //Setters

    function setName(String $newName)    {
      $this->Name = $newName;  
    }

    function setCity(String $newCity)   {
        $this->City = $newCity;
    }

    function setAddress(String $newAddress) {
        $this->Address = $newAddress;
    }

    function setCustomerID(int $CustomerID) {
        $this->CustomerID = $CustomerID;
    }
}

?>