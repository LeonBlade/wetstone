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

function php_errors() {
	ini_set('display_errors', 1); 
 	error_reporting(E_ALL);
}

?>
