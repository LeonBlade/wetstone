<?php

// set default timezone
date_default_timezone_set("UTC");

// allow for short open tags
ini_set("short_open_tag", 1);

// define the hostname to switch over
define("HOSTNAME", $_SERVER['HTTP_HOST']);

switch (HOSTNAME) {
	default:
		// define("DB_HOST", "localhost");
		// define("DB_USER", "root");
		// define("DB_PASS", "root");
		// define("DB_DATABASE", "app");
		break;
}

?>
