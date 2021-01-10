<?php

class CustomerConverter {

    //This function will conver tot Standard Classes
    public static function convertToStdClass($data) {
        if (is_array($data)) {
            $stdObjects = array();
            foreach ($data as $customer) {
                $stdCustomer = new stdClass;
                $stdCustomer->CustomerID = $customer->getCustomerID();
                $stdCustomer->Name = $customer->getName();
                $stdCustomer->Address = $customer->getAddress();
                $stdCustomer->City = $customer->getCity();

                $stdObjects[] = $stdCustomer;
            }
        } else {
            //This path will be hit if a single object is passed in as $data, we assume its a single student becuase we are in the student DAO
            $stdObjects = new stdClass;

            $stdObjects->CustomerID = $data->getCustomerID();
            $stdObjects->Name = $data->getName();
            $stdObjects->Address = $data->getAddress();
            $stdObjects->City = $data->getCity();
        }
        //REturn the stdObjects
        return $stdObjects;
    }

    public static function convertToCustomerClass($data)    {
        //Store the new Customers
        $newCustomers = array();
        
        if (is_array($data)){
            //Go through all stndard Customers
            foreach ($data as $stdCustomer) {
                //Create new Customer with the data
                $nc = new Customer;
                $nc->setCustomerID($stdCustomer->CustomerID);
                $nc->setName($stdCustomer->Name);
                $nc->setAddress($stdCustomer->Address);
                $nc->setCity($stdCustomer->City);

                //Store the new Customer in the array
                $newCustomers[] = $nc;
            }

        } else {
            //Create a single new Customer
            $newCustomers = new Customer;
            $newCustomers->setCustomerID($data->CustomerID);
            $newCustomers->setName($data->Name);
            $newCustomers->setAddress($data->Address);
            $newCustomers->setCity($data->City);
        }
        return $newCustomers;
    }

}