<?php
/**
 * Module Name: Return Types
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/helpers/class-return-types.php
 * Version: 0.0.1
 * Description: Helpers to handle return types consistently and avoid hooking anonymous functions.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Helpers;

class Return_Types {

	public static function initialize() : void {
		return;
	}

	public static function return_true() : bool {
		return true;
	}

	public static function return_false() : false {
		return false;
	}

	public static function return_null() : null {
		return null;
	}

	public static function return_empty_string() : string {
		return '';
	}

	public static function return_empty_array() : array {
		return array();
	}
}