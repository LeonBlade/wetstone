<?php

class Wetstone {
	
	/* this will "pretty print" your variable */
	public static function debug($variable) {
		echo "<pre>";
		print_r($variable);
		echo "</pre>";
	}
	
	/* ris stands for return if set which will return a variable/array value if it's set or a default */
	public static function ris($variable, $default = null) {
		// check to see if this is an array
		if (is_array($variable)) {
			// shift off the first part of the array
			$array = array_shift($variable);
			// loop through the contents of the param array
			foreach ($variable as $piece) {
				// if its not set then we return the default
				if (!isset($array[$piece]))
					return $default;
				// keep resetting array to go deeper into a nested array
				$array = $array[$piece];
			}
			// return the final array
			return $array;
		}
		// by default let's just make sure the value is set and return
		return (isset($variable)) ? $variable : $default;
	}
					
	/* cURL provides a simple solution for cURLing a resource with one line call */
	public static function cURL($url, $options = null, $json = false) {
		// initialize the cURL handle
		$ch = curl_init($url);
		// set the cURL option for return transfer
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
	
	/* errors will allow you to view PHP errors with a simple line call */				
	public static function errors() {
		ini_set("display_errors", 1); 
		error_reporting(E_ALL);
	}

	/* email will send out an emails set variable to as an array for mass email */
	public static function email($to, $from = null, $subject = "No Subject", $message = null) {
		// return if to is empty
		if (empty($to))
			return false;

		// if from is null or empty then set it to a no-reply email address
		if (!$from || empty($from))
			$from = "no-reply" . HOSTNAME;

		// check if to is an array
		if (is_array($to)) {
			// loop through each email and send 
			foreach ($to as $email)
				Wetstone::email($email, $from, $subject, $message);
		}

		// form the headers for this message
		$headers = "From: $from\r\nReply-To: $from\r\nX-Mailer: PHP/" . phpversion();

		// send the actual message
		if (!mail($to, $subject, $message))
			Wetstone::debug("Mail couldn't be sent!");
	}
			
}

?>
