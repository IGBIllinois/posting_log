#!/usr/bin/env php

<?php

chdir(dirname(__FILE__));

$include_paths = array('../libs');
set_include_path(get_include_path() . ":" . implode(':',$include_paths));

function my_autoloader($class_name) {
	if(file_exists("../libs/" . $class_name . ".class.inc.php")) {
		require_once $class_name . '.class.inc.php';
	}
}
spl_autoload_register('my_autoloader');
date_default_timezone_set(settings::get_timezone());

require_once '../conf/settings.inc.php';
require_once '../vendor/autoload.php';

ini_set("log_errors", 0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
if (settings::get_debug()) {
        ini_set("log_errors", 1);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

}

//Command parameters
$output_command = "Usage: php email_digest.php \n";
$output_command .= "    --dry-run Do Dry Run.  Doesn't insert into database\n";
$output_command .= "	--help Show this help menu\n";
$output_command .= "	--version Show Version\n";

//If run from command line
if (php_sapi_name() != 'cli') {
        exit("Error: This script can only be run from the command line.\n");
}

$db = new db(MYSQL_HOST,MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD);


?>
