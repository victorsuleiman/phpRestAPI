<?php

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

require_once('inc/Utilities/RestClient.class.php');
require_once('inc/Utilities/Page.class.php');
require_once('inc/Utilities/CustomerConverter.class.php');

//Check if there was get data, perofrm the action
if (!empty($_GET))    {
    //Perform the Action
    if ($_GET["action"] == "delete")  {
        RestClient::call("DELETE",array('id'=>$_GET["id"]));
    }

    if ($_GET["action"] == "edit")  {
        //Call the rest client with GET, decode the result
        $stdEc = json_decode(RestClient::call("GET",array('id'=>$_GET["id"])));
        //Convert the decoded customer
        $ec = CustomerConverter::convertToCustomerClass($stdEc);
    }

}

//Check for post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["action"]) && $_POST["action"] == "edit")    {
        //Assemble the the postData
        $nc = new Customer();
        $nc->setCustomerID($_POST["id"]);
        $nc->setName($_POST["name"]);
        $nc->setAddress($_POST["address"]);
        $nc->setCity($_POST["city"]);

        //Call the RestClient with PUT
        RestClient::call("PUT",array(
            'id' => $_POST["id"],
            'name' => $_POST["name"],
            'address' => $_POST["address"],
            'city' => $_POST["city"],
        ));
    //Was probably a create
    } else {
        //Assemble the Customer
        $nc = new Customer();
        $nc->setName($_POST["name"]);
        $nc->setAddress($_POST["address"]);
        $nc->setCity($_POST["city"]);

        //Add the the Customer 
        RestClient::call("POST",array(
            'name' => $_POST["name"],
            'address' => $_POST["address"],
            'city' => $_POST["city"],
        ));
        
    }
}

//Get all the customers from the web service via the REST client
$stdCustomers = json_decode(RestClient::call("GET",array()));

//Store the customer objects 
$customers = CustomerConverter::convertToCustomerClass($stdCustomers);


Page::$title = "Customer Address Database";
Page::header();
Page::listCustomers($customers);
//Check Get again, display the right form edit or add
if (!empty($_GET) && $_GET["action"] == "edit") {
        Page::editCustomer($ec);
} else {
        Page::addCustomer();
}

Page::footer();