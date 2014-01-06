<?php

//
// Wetstone v1.2 β
//

ini_set("short_open_tag", 1);

// start a session
session_start();

// require the helper file
require_once "wetstone/helper.php";
// require the route class
require_once "wetstone/route.php";
// require the controller class
require_once "wetstone/controller.php";
// require the view class
require_once "wetstone/view.php";
// require the database class
require_once "wetstone/db.php";

// connect to the database
//DB::connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

// load the controllers from the controller directory
Controller::loadDir("controllers");

// require the router file
require_once "router.php";

// proccess the route
Route::proccess();

?>
