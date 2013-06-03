<?php

//
// Wetstone v1.0 β
//

// start a session
session_start();

// require the helper file
require_once "wetstone/helper.php";
// require the rout file
require_once "wetstone/route.php";
// require the controllers file
require_once "wetstone/controller.php";

// load the controllers from the controller directory
Controller::loadDir("controllers");

// require the router file
require_once "router.php";

// proccess the route
Route::proccess();

?>
