<?php

//
// Wetstone v1.1 β
//

// start a session
session_start();

// require a confiuration file for some constants
require_once "config.php";

// require the wetstone base class file
require_once "wetstone/wetstone.php";
// require the route class
require_once "wetstone/route.php";
// require the controller class
require_once "wetstone/controller.php";
// require the view class
require_once "wetstone/view.php";
// require the db class
require_once "wetstone/db.php";

// load the controllers from the controller directory
Controller::loadDir("controllers");

// require the router file
require_once "router.php";

// proccess the route
Route::proccess();

?>
