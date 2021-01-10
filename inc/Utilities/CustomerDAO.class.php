<?php

class CustomerDAO    {

    private static $db;

    static function initialize()    {

        //Initialize the database connection
        self::$db = new PDOAgent('Customer');
    
    }

    //CREATE a single Customer
    static function createCustomer(Customer $newCustomer): int   {

        //Generate the INSERT STATEMENT for the customer;
        $sqlInsert = "INSERT INTO Customers (Name, Address, City) VALUES (:name, :address, :city);";

        //prepare the query
        self::$db->query($sqlInsert);

        //Setup the bind parameters
        self::$db->bind(':name',$newCustomer->getName());
        self::$db->bind(':address', $newCustomer->getAddress());
        self::$db->bind(':city', $newCustomer->getCity());

        //Execute the query
        self::$db->execute();

        //Return the last inserted ID!!
       return  self::$db->lastInsertId();

    }

    //READ a single Customer
    static function getCustomer(int $id) : Customer   {
        
        $singleSelect = "SELECT * FROM Customers WHERE CustomerID = :customerid";

        //Prepare the query
        self::$db->query($singleSelect);
        //Set the bind parameters
        self::$db->bind(':customerid', $id);
        //Execute the query
        self::$db->execute();
        //Get the row
        return self::$db->singleResult();

    }

    //READ a list of Customers
    static function getCustomers(): Array   {

        $selectAll = "SELECT * FROM Customers;";
        //Prepare the query
        self::$db->query($selectAll);
        //Execute the query
        self::$db->execute();
        //Get the row
        return self::$db->resultset();
    }

    //UPDATE 
    static function updateCustomer(Customer $updatedCustomer): int   {
        try {
            //Create the query
            $updateQuery = "UPDATE Customers SET Name = :name, City = :city, Address = :address WHERE CustomerId = :id;";

            self::$db->query($updateQuery);

            $data = [
                ':city' => $updatedCustomer->getCity(),
                ':address' => $updatedCustomer->getAddress(),
                ':name' => $updatedCustomer->getName(),
                ':id' => $updatedCustomer->getCustomerID()
            ];
            
            //Execute the query
            self::$db->execute($data);

            //Check the appropriate updates
            if (self::$db->rowCount() !=1)    {
                throw new Exception("There was an error updating the database!");
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            self::$db->debugDumpParams();
        }    

        //Get the number of affected rows
        return self::$db->rowCount();
    }

    //DELETE
    static function deleteCustomer(int $id): bool {

        try {

            //Create the delete query
            $deleteQuery = "DELETE FROM Customers WHERE CustomerId = :customerid";
            self::$db->query($deleteQuery);
            //Bind the id
            self::$db->bind(':customerid', $id);
            //Execute the query
            self::$db->execute();

            if (self::$db->rowCount() != 1) {
                throw new Exception("There was an error deleting customer $id");
            } 
        
        } catch (Exception $ex) {

            echo $ex->getMessage();
            self::$db->debugDumpParams();
            return false;
        
        }

        return true;
        
    }

}

?>