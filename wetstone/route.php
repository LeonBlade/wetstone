<?php

class Route {

	/* the types of route methods/types available */
	private static $routes = array(
		"GET" => array(),
		"POST" => array(),
		"PUT" => array(),
		"DELETE" => array(),
		"CONTROLLER" => array(),
		"ERROR" => array()
	);

	/* respond to get on path */
	public static function get($path, $callback) {
		Route::_route("GET", $path, $callback);
	}

	/* respond to post on path */
	public static function post($path, $callback) {
		Route::_route("POST", $path, $callback);
	}

	/* respond to put on path */
	public static function put($path, $callback) {
		Route::_route("PUT", $path, $callback);
	}

	/* respond to delete on path */
	public static function delete($path, $callback) {
		Route::_route("DELETE", $path, $callback);
	}

	/* responds to a 404 */
	public static function error($status, $callback) {
		Route::_route("ERROR", $status, $callback);
	}

	/* shouldn't be called directly adds routes to the route object */
	private static function _route($method, $path, $callback) {
		Route::$routes[$method][$path] = $callback;
	}

	/* controller will create appropriate connections to various methods for you */
	public static function controller($name) {
		Route::get("/$name", array(Controller::get($name), "get"));
		Route::get("/$name/:id", array(Controller::get($name), "get"));
		Route::delete("/$name/:id/delete", array(Controller::get($name), "delete"));
		Route::post("/$name/:id/update", array(Controller::get($name), "post"));
	}

	/* process the url and route accordingly */
	public static function proccess() {
		// grabbing server variables for this request
		$method = Wetstone::ris(array($_SERVER, 'REQUEST_METHOD'), "GET");
		$uri = Wetstone::ris(array($_SERVER, 'REQUEST_URI'), "/");

		// explode off the uri for query
		$uri_parts = explode("?", $uri);

		// set the main uri to the first part
		if (!empty($uri_parts))
			$uri = $uri_parts[0];

		// is this a normal uri path and does it exist in routes
		if (isset(Route::$routes[$method][$uri])) {
			// grab the callback
			$callback = Route::$routes[$method][$uri];
			// execute callback
			call_user_func_array($callback, $_REQUEST);
		}
		else {
			// test the uri against any possible regex matching
			foreach (Route::$routes[$method] as $path => $callback) {
				// set up valid variable
				$valid = false;

				// split the url path 
				$path_parts = explode("/", $path);
				array_shift($path_parts);

				// split up the current uri
				$uri_parts = explode("/", $uri);
				array_shift($uri_parts);

				// do the lengths match
				if (count($path_parts) == count($uri_parts)) {
					// initialize args
					$args = array();
					// loop over the parts
					foreach ($path_parts as $i => $piece) {
						// if either path parts is a variable or the parts match
						if (!empty($path_parts[$i]) && ($path_parts[$i][0] == ":" || $path_parts[$i] == $uri_parts[$i])) {
							// set valid to true
							$valid = true;
							// if this is a variable then pass it into the args
							if ($path_parts[$i][0] == ":") {
								$args[] = $uri_parts[$i];
							}
						}
						else {
							// we are not valid
							$valid = false;
							// break out of this for loop
							break;
						}
					}
					// if the path is valid for this uri
					if ($valid) {
						// call the callback with an array merge of query args and uri args
						call_user_func_array($callback, array_merge($args, $_REQUEST));
						// get outta here bud
						return;
					}
				}
			}

			// no route was found call the 404 route if exists
			if (Wetstone::ris([Route::$routes, "ERROR", "404"]))
				call_user_func_array(Route::$routes["ERROR"]["404"], array_merge($args, $_REQUEST));
			else
				header("Location: /");
		}
	}

}

?>
