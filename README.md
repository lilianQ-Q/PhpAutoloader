# Autoloader

## Config
 First place autoloader.json in your project config folder and autoloader.php in your lib folder
 for example :

	├── bin
	├── config
	│	 └── autoloader.json
	├── src
	│ ├── libs
	│ │    └── autoloader.php
	│ └── app.php
	└── tests
	Dockerfile
	Makefile

 In autoloader.json you have to place the desired namespace and its corresponding folder like :

 ```json
{
	"Everest" : "src/libs/Everest/src"
}
 ```

 Then in autoloader.php, you have to place the path for the config file and for the root project.

 ```php
<?php
define("CONFIG_FILE_PATH", "PATH OF THE CONFIG FILE TO READ");
define("ROOT_PROJECT_PATH", "PATH OF THE ROOT PROJECT FOLDER");

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
?>
 ```

## Usage

To use your new fresh autoloader after you made config for it, just require the autoloader.php file in your binary file.

```php
<?php
	// Require autoloader
	require_once(__DIR__ . '/libs/Autoloader.php');

	// Use a lib
	use My\Awesome\Library;

	// Start using it
	Library::makeSomething();
?>
```

## Thanks

Thanks to grafikart that made an easy video to introduce autoloading from scratch !