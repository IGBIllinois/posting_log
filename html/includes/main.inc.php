<?php
ini_set("log_errors", 1);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


$include_paths = array('../libs');

set_include_path(get_include_path() . ":" . implode(':',$include_paths));
require_once '../conf/app.inc.php';
require_once '../conf/settings.inc.php';

require_once '../vendor/autoload.php';

function my_autoloader($class_name) {
	if(file_exists("../libs/" . $class_name . ".class.inc.php")) {
		require_once $class_name . '.class.inc.php';
	}
}

spl_autoload_register('my_autoloader');

if (settings::get_debug()) {
	ini_set("log_errors", 1);
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);

}

$db = new db(MYSQL_HOST,MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD);

?>
