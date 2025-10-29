<?php

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