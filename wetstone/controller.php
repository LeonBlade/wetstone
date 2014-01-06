<?php

class Controller {

	private static $controllers = array();

	public static function get($name = null) {
		if ($name) return ris(array(self::$controllers, $name));
		return self::$controllers;
	}

	public static function load($name) {
		if (!isset(self::$controllers[$name])) {
			require_once $name;
			$path_array = explode("/", $name);
			$file = str_replace(".controller.php", "", array_pop($path_array));
			$class = ucfirst($file);
			self::$controllers[$file] = new $class;
		}
	}

	public static function loadDir($dir) {
		// ensure controllers folder exists
		if (is_dir($dir))
			if ($dh = opendir($dir))
				while (($file = readdir($dh)) !== false)
					if ($file != "." && $file != "..") 
						self::load("$dir/$file");
	}

}

?>
