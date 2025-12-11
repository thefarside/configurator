<?php
/**
 * Module Name: MS Activate FSE Warn
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-activate-fse-warn.php
 * Version: 0.0.1
 * Description: Removes the depreciation notice displayed on wp-activate.php when using an FSE theme.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\MS;

class MS_Activate_FSE_Warn {

	public static function initialize() : void {
		add_filter( 'remove_deprecated_file_trigger_error', array( static::class, 'remove_deprecated_file_trigger_error' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_deprecated_file_trigger_error( array $pages ) : array {
		array_push( $pages, 'wp-activate.php' );
		return $pages;
	}
}