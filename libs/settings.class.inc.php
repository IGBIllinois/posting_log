<?php

class settings {

	private const DEBUG = false;

	public static function get_version() {
		return VERSION;
	}

	public static function get_title() {
		return TITLE; 
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

}
