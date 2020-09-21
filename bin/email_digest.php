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

require_once '../conf/app.inc.php';
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

$log_date = date("Y-m-d",strtotime("-1 days"));

//Command parameters
$output_command = "Usage: php email_digest.php \n";
$output_command .= "	--date		(YYYY-MM-DD) (Defaults: Yesterday)\n";
$output_command .= "	--help		Show this help menu\n";
$output_command .= "	--version	Show Version\n";

$shortopts = "h";

$longopts = array(
        "date::",
        "help",
        "version"
);

$options = getopt($shortopts,$longopts);

//If run from command line
if (php_sapi_name() != 'cli') {
        exit("Error: This script can only be run from the command line.\n");
}

if (isset($options['h']) || isset($options['help'])) {
        print $output_command;
        exit(0);
}

elseif (isset($options['version'])) {
        print settings::get_version() . "\n";
        exit(0);
}
elseif (isset($options['date'])) {
	if ($options['date'] == "") {
		print("Please specify date with --date='YYYY-MM-DD'\n");
		exit(1);
	}
	if (!functions::verify_date($options['date'])) {
		print("Invalid date format for --date\n");
                exit(1);
	}
	else {
		$log_date = $options['date'];	
	}

}


$db = new db(MYSQL_HOST,MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD);

$start_date = $log_date . " 00:00:00";
$end_date = $log_date . " 23:59:59";

functions::send_emaiL_digest($db,$start_date,$end_date);


?>
