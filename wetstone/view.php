<?php

class View {
	
	public static function wet($view, $arguments = array()) {

		// compile the view and echo it out
		echo View::compile($view, $arguments);
		
	}

	public static function compile($view, $arguments = array()) {

		// store the view path
		$view_path = __DIR__ . "view/$view.view.php";

		// initialize blank buffer
		$buffer = "";

		// does the view path exist
		if (file_exists($view_path)) {
			// start the output buffer
			ob_start();

			// extract arguments from array into scope
			extract($arguments);

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
