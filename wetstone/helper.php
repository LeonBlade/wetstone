<?php

function debug($variable) {
	echo "<pre>";
	print_r($variable);
	echo "</pre>";
}

function ris($var, $default = null) {
	if (is_array($var)) {
		$arr = array_shift($var);
		foreach ($var as $piece) {
			if (!isset($arr[$piece]))
				return $default;
			$arr = $arr[$piece];
		}
		return $arr;
	}
	return (isset($var)) ? $var : $default;
}

function better_curl($url, $options = null, $json = false) {
	// initialize the cURL handle
	$ch = curl_init($url);
	// set the cURL option for return transfer
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// follow location to prevent move permanently error
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// if the options array isn't null
	if (!is_null($options) && is_array($options))
		curl_setopt_array($ch, $options);
	// go ahead and grab the execution now
	$return = curl_exec($ch);
	// close the handle
	curl_close($ch);

	// return the execution return JSON or not
	return ($json) ? json_decode($return, true) : $return;
}

function php_errors() {
	ini_set('display_errors', 1); 
 	error_reporting(E_ALL);
}

?>
