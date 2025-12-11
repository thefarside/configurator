<?php
/**
 * Module Name: Test
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/test.php
 * Version: 0.0.1
 * Description: Test description.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Load
 */

namespace Configurator\Modules;

use Configurator\Load;

class Test {

	public static function initialize() : void {
		add_action( 'shutdown', array( static::class, 'debug' ), PHP_INT_MAX );
		return;
	}

	public static function debug() : void {
		echo '<pre>';
			print_r( Load::$modules );
		echo '</pre>';
		return;
	}
}