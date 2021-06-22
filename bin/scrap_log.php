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

//Command parameters
$output_command = "Usage: php scrap_log.php \n";
$output_command .= "	--dry-run 	Does Dry Run.  Does not insert into database\n";
$output_command .= "	-h, --help	Show this help menu\n";
$output_command .= "	--version 	Show Version\n";

$dry_run = false;
$shortopts = "h";

$longopts = array(
	"dry-run",
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
elseif (isset($options['dry-run'])) {
	$dry_run = true;
	print "Dry Run Enabled.\n";

}

if (!settings::get_lock_file()) {
	print "LOCK_FILE not defined in settings.inc.php.  Please specify a path where the lock file should be located.\n";
	exit(1);
}
elseif (file_exists(settings::get_lock_file())) {
	print "Lock File " . settings::get_lock_file() . " exists.  Exiting\n";
	exit(1);
}
else {
	functions::create_lock_file();	
}
$db = new \IGBIllinois\db(MYSQL_HOST,MYSQL_DATABASE,MYSQL_USER,MYSQL_PASSWORD);

$logs = settings::get_apache_logs();

$count = 0;
foreach ($logs as $log) {
	try {
		$posting_log = new posting_log($db,$log);
		$result = $posting_log->readlog($dry_run);
		if ($result) {
			print "Successfully imported " . $result . " from " . $log . "\n";
			$count += $result;
		}
		else {
			print "No records to import from " . $log . "\n";
		}
	}
	catch (Exception $e) {
		print "Error: " . $e->getMessage() . "\n";
	}
}

if ($count) {
	print "Successfully imported a total of " . $count . " records\n";
}

$result = functions::delete_lock_file();
if (!$result) {
	print "Error deleting lock file " . settings::get_lock_file() . ".\n";
	exit(1);

}


?>
