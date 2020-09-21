<?php

class settings {

	private const DEBUG = false;
	private const TIMEZONE = "UTC";
	private const SMTP_PORT = 25;
	private const SMTP_HOST = "localhost";
	private const TITLE = "Posting Log";

	public static function get_version() {
		return VERSION;
	}

	public static function get_title() {
		if (defined("TITLE") && (TITLE != "")) {
			return TITLE; 
		}
		return self::TITLE;
	}


	public static function get_website_url() {
		return WEBSITE_URL;
	}

	public static function get_debug() {
		if (defined("DEBUG") && (DEBUG != "")) {
			return DEBUG;
		}
		return self::DEBUG;
	}
	public static function get_timezone() {
		if (defined("TIMEZONE") && (TIMEZONE != "")) {
			return TIMEZONE;
		}
		return self::TIMEZONE;
	}

	public static function get_apache_logs() {
		if (defined("APACHE_LOG") && (APACHE_LOG != "") && file_exists(APACHE_LOG)) {			
			$files = glob(APACHE_LOG . "*");
			return $files;

		}
		return array();

	}
	public static function get_twig_dir() {
		$dir = dirname(__DIR__) . "/" . TWIG_DIR;
		return $dir;
	}

	public static function get_emails() {
		if (defined("TO")) {
			$to_array = explode(",",TO);
			$to_array = array_map('trim',$to_array);
			$to_array = array_map('rtrim',$to_array);
			return $to_array;
		}
		return array();

	}
	public static function get_from_email() {
		if (defined("FROM")) {
			return FROM;
		}
		

	}
	public static function get_smtp_host() {
		if (defined("SMTP_HOST")) {
			return SMTP_HOST;
		}
		return self::SMTP_HOST;

	}
	public static function get_smtp_port() {
		if (defined("SMTP_PORT")) {
			return SMTP_PORT;
		}
		return self::SMTP_PORT;

	}
}
