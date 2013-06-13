<?php

class DB {

	public static function connect($host = "localhost", $user = "root", $password, $database) {
		// connect to the database server
		if (!mysql_connect($host, $user, $password)) {
			debug("Couldn't connect to the database server!");
			die();
		}

		// select the database
		if (!mysql_select_db($database)) {
			debug("Couldn't select database!");
			die();
		}
	}

	public static function mysqlDatetime($datetime) {
		return date("Y-m-d H:i:s", strtotime($datetime));
	}

	public static function safeMySQL($required = null, $post = null) {
		// if we aren't passing in the post manually then just grab the POST/GET variables
		if (!$post) 
			$post = $_REQUEST;

		// check if we have required fields
		if ($required && is_array($required)) {
			foreach ($required as $value) {
				// make sure we have the field entered
				if (!isset($_REQUEST[$value]) || empty($_REQUEST[$value])) {
					return false;
				}
			}
		}

		// if post is an array and not empty
		if (is_array($post) && !empty($post)) {
			// loop over each part of post
			foreach ($post as $value) {
				// if the value isn't empty
				if (!empty($value)) {
					// call self to safe the value
					$post[$key] = DB::safeMySQL(null, $value);
				}
				else {
					// just set the post to the value
					$post[$key] = $value;
				}
			}
		}
		else {
			// if not then we just escape the string
			$post = mysql_real_escape_string($post);
		}

		// return the post
		return $post;
	}

	// standard query
	public static function query($sql) {
		// get the result from the query
		$result = mysql_query($sql);
		// is there an error
		if ($error = mysql_error()) {
			debug("Error: $error");
		}

		// return the result
		return $result;
	}

	// requesting a value from a query
	public static function queryValue($sql) {
		// make the query
		$result = mysql_query($sql);
		// if the query came back okay
		if ((bool) $result) {
			// create an array from the results
			$array = mysql_fetch_assoc($result);

			// if this is an array
			if (is_array($array)) {
				// shift off the first element and return it
				$array = array_shift($array);
			}

			// is there an error
			if ($error = mysql_error()) {
				debug("Error: $error");
			}

			// return back the array
			return $array;
		}
	}

	// requesting one row from a query
	public static function querySingle($sql) {
		// make the query
		$result = mysql_query($sql);
		// if the query came back okay
		if ((bool) $result) {
			// create an array from the results
			$array = mysql_fetch_assoc($result);
			// if there is only one field then return it as a single value
			if (mysql_num_fields($result) == 1) {
				// shift off the first element and return it
				$array = array_shift($array);
			}
		}

		// is there an error
		if ($error = mysql_error()) {
			debug("Error: $error");
		}

		// return back the array
		return $array;
	}

	// requesting multiple rows from a query
	public static function queryMulti($sql) {
		// make the query
		$result = mysql_query($sql);
		// if the query came back okay
		if ((bool) $result) {
			// create an array for the results
			$array = array();
			// if there is only one field then return an array of those fields
			if (mysql_num_fields($result) > 1)
				while ($row = mysql_fetch_assoc($result))
					$array[] = $row;
			// otherwise populate the array with the trows
			else if (mysql_num_fields($result) == 1)
				while ($row = mysql_fetch_assoc($result))
					foreach ($row as $value) 
						$array[] = $value;
		}

		// is there an error
		if ($error = mysql_error()) {
			debug("Error: $error");
		}

		// return back the array
		return $array;
	}
}

?>
