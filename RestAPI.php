<?php

//RestAPI is another view, but instead of HTML CSS etc it displays JSON.
require_once("inc/config.inc.php");
require_once("inc/Utilities/PDOAgent.class.php");
require_once("inc/Utilities/CustomerDAO.class.php");
require_once("inc/Utilities/CustomerConverter.class.php");

require_once("inc/Entities/Customer.class.php");

//initialize Customer DAO
CustomerDAO::initialize();

//grab the json sent to the API
$requestData = json_decode(file_get_contents('php://input'));

//This function will just receive data and json encode it
function sendResponseBack() {

    //reads the input stream
    $requestData = json_decode(file_get_contents('php://input'));

    //set the header -> it's one of the HTTP GETs that the server always has
    header('Content-Type: application/json');
    echo json_encode($requestData);
}

//Do some thing with the request
switch($_SERVER["REQUEST_METHOD"]) {

    case "POST":
        //Do post things
        if (isset($requestData->name) && isset($requestData->address) && isset($requestData->city)) {
            //Insert the Customer
            $nc = new Customer();
            $nc->setName($requestData->name);
            $nc->setAddress($requestData->address);
            $nc->setCity($requestData->city);

            $result = CustomerDAO::createCustomer($nc);

            header('Content-Type: application/json');
            echo json_encode($result);
        }
    break;

    case "GET":
        if (isset($requestData->id)) {
            $customer = CustomerDAO::getCustomer($requestData->id);
            $stdCustomer = CustomerConverter::convertToStdClass($customer);
            header('Content-Type: application/json');
            echo json_encode($stdCustomer);
        } else {
            header('Content-Type: application/json');
            $stdCustomers = CustomerConverter::convertToStdClass(CustomerDAO::getCustomers());
            echo json_encode($stdCustomers);
        }
        //do get things
        
    break;

    case "PUT":
        //Do put things
        if (isset($requestData->id) && isset($requestData->name) && isset($requestData->address) 
            && isset($requestData->city)) {

            $nc = new Customer();
            $nc->setCustomerID($requestData->id);
            $nc->setName($requestData->name);
            $nc->setAddress($requestData->address);
            $nc->setCity($requestData->city);

            $result = CustomerDAO::updateCustomer($nc);

            header('Content-Type: application/json');
            echo json_encode($result);
        }
    break;

    case "DELETE":
        //do delete things
        if (isset($requestData->id)) {
            $result = CustomerDAO::deleteCustomer($requestData->id);
            echo $requestData->id;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array("message" => "Must specify an id"));
        }
        
    break;

    default:
        echo json_encode("Voce fala HTTP?");
break;

    
}

?>