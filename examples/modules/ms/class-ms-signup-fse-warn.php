<?php

namespace Configurator\Modules\MS;

class MS_Signup_FSE_Warn {

	public static function initialize() : void {
		add_filter( 'remove_deprecated_file_trigger_error', array( static::class, 'remove_deprecated_file_trigger_error' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_deprecated_file_trigger_error( array $pages ) : array {
		array_push( $pages, 'wp-signup.php' );
		return $pages;
	}
}