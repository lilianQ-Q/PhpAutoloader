<?php
define("CONFIG_FILE_PATH", __DIR__ . "/../../config/autoloader.json");
define("ROOT_PROJECT_PATH", __DIR__ . "/../../");

class Autoloader
{
	static function register() : bool
	{
		return (spl_autoload_register(array(__CLASS__, 'autoload')));
	}

	static function autoload(string $class)
	{
		$fileContent = file_get_contents(CONFIG_FILE_PATH);
		$array = json_decode($fileContent, true);

		foreach ($array as $namespace => $path)
		{
			if (strpos($class, $namespace) === 0)
			{
				$class = str_replace($namespace, $path, $class);
				$class = str_replace('\\', '/', $class);
				require (ROOT_PROJECT_PATH . "$class.php");
				break ;
			}
		}
	}
}

Autoloader::register();