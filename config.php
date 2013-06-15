<?php

date_default_timezone_set("UTC");

define("HOSTNAME", $_SERVER['HTTP_HOST']);

switch (HOSTNAME) {
	default:
		define("DB_HOST", "localhost");
		define("DB_USER", "root");
		define("DB_PASS", "root");
		define("DB_DATABASE", "sei");
		break;
}

?>
