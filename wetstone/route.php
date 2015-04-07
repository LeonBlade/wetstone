<?php

class Route {

	/* the types of route methods/types available */
	private static $routes = array(
		"GET" => array(),
		"POST" => array(),
		"PUT" => array(),
		"DELETE" => array(),
		"CONTROLLER" => array()
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
		$method = ris(array($_SERVER, 'REQUEST_METHOD'), "GET");
		$uri = ris(array($_SERVER, 'REQUEST_URI'), "/");

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
				// create regex pattern based on path
				$regex_path = preg_replace("/:([\w_\-]+)/", "([^/&+?]+)", $path);
				// escape out our regex expression
				$regex_path = preg_quote($regex_path, "/");

				// match against the url
				if (preg_match_all("/^$regex_path$/", $uri, $matches)) {
					// shift off the full patern matched
					array_shift($matches);
					// fix the array
					foreach ($matches as $key => $value)
						$matches[$key] = $value[0];
					// call the callback with an array merge of the query args and uri args
					call_user_func_array($callback, array_merge($matches, $_REQUEST));
					return;
				}
			}

			// no route was found
			header("Location: /");
		}
	}

}

?>
