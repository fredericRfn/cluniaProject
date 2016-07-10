<?php
/* 
    Author: Frédéric Rouffineau (fred.rouffineau@gmail.com)

    IMPLEMENTATION OF THE FRONT CONTROLLER PARADIGM

    This class is the front controller, this script is executed whenever a
    request is made to the apache server (see .htaccess file), except for the
    assets (images, css and js)

    This script cheks if the URL given is valid, and instantiates the required
    controller if this controller is specified in the table $valid_routes and
    the action required exists.

    As a reminder: the URL looks like this:
       * http://urlbase/controller/action/parameters
        => This will call the controller/controller.php file and its action() function
       * http://urlbase 
        => This one is the same as http://domain/home/index
       * http://domain/index.php (same)

    Here, a controller is just a set of methods gathered in a class that prepare and echoes the
    reponse to the client.

    Example of action: If you want to render the header just include it:
    public function myaction() {
        include('template/header.php');
        //do some stuff such as data processing
        include('template/controller/action.php') (for instance)
        OR redirect, or whatever you want this action to do
    }

    STEPS TO ADD A CONTROLLER Yourcontroller AND SOME ACTIONS actionX:
    1) Add line $valid_routes[controller]=array("action1", "action2" ...) after the other ones
    2) Create a Yourcontroller class in the file controllers/yourcontroller.php, extending AbstractController
    3) Define one method per action, with its name
       (here we would define action1() and action2()... )
       Those action method takes care of answer to the client request and must return a
       string containing the formatted output

       THATS ALL FOLKS! 
       You can invoke your newly created controller with the URL:
       http://urlbase/yourcontroller/action

       Those controller have access to the $_GET, $_POST and $_SESSION php arrays.

*/

include("etc/config.php");

$valid_routes = array();
// Controllers ------------- Actions
$valid_routes["cms"]       = array("error", "about", "contact");
$valid_routes["home"]      = array("index");
$valid_routes["user"]      = array("signup", "login", "logout", "register", "profile");
$valid_routes["dashboard"] = array("import", "store", "remove");
$valid_routes["data"]      = array("retrieve");


class AbstractController {
    protected var $basePath = __DIR__;
    protected var $isLogged; // Boolean
    protected var $template; // Template of the response 
    public AbstractController($isLogged) {
        $this->isLogged = $isLogged;
        $this->template = __DIR__ . "template/empty.php";
    }
}

// This class is reponsible for parsing the URL and getting the appropriate controller / action
class FrontController {
    var controller;
    var action;
    var isLogged;

    public function FrontController($uri) {
        $this->parseUri($uri);
    }

    private function parseUri($uri) {
        $tokens = explode('/', $uri);
        $this->controller="cms";
        $this->action="error";
        
        // STANDARD CASE - URI = "/controller/action"
        if (count($tokens)>=3) {
            if(array_key_exists($tokens[1], $valid_routes)) {
                if ( in_array( $tokens[2], $valid_routes[ $tokens[1] ])) {
                    $this->controller=$tokens[1];
                    $this->action=$tokens[2];
                }
            }
        }

        // HOME CASE
        if (count($tokens) == 1) {
            $this->controller="home";
            $this->action="index";
        }
    }

    public function callControllerAction() {
        $controllerClass = 'Class' . ucfirst($this->controller);
        $controller = new $controllerClass(isLogged());
        call_user_func(array($controller, $this->action);
    }

    public function getControllerFile() {
        return "controllers/" . $this->controller . ".php"
    }

    private function isLogged() {
        session_start();
        $user_check = $_SESSION['user_id'];
        $conn= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        $sql = "SELECT id FROM Users WHERE id = '$user_check' ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            isLogged = true;
        } else {
            session_destroy();
            isLogged = false;
        }
    }
}


$frontController = new FrontController($_SERVER['REQUEST_URI']);

// Once the controller is determined: include it
include($frontController->getControllerFile());

// Call the appropriate method of the newly included class
$frontController -> callControllerAction();