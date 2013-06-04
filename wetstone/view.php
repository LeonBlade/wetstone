<?php

class View {

	/* renders the compiled view on the page */
	public static function render($view, $arguments = array()) {
		// compile the view and echo it out
		echo View::compile($view, $arguments);
	}

	/* compiles the view with output buffers as a quick and dirty template renderer returns string of view */
	public static function compile($view, $arguments = array()) {
		// store the view path
		$view_path = "view/$view.view.php";

		// initialize blank buffer
		$buffer = "";

		// does the view path exist
		if (file_exists($view_path)) {
			// start the output buffer
			ob_start();

			// extract arguments from array into scope
			extract($arguments);

			// get uri for the page
			$uri = $_SERVER['REQUEST_URI'];

			// include the view
			include $view_path;

			// clean the buffer return what's in it
			$buffer = ob_get_clean();
		}

		// return the buffer
		return $buffer;
	}

}

?>
