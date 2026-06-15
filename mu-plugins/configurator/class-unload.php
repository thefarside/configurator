<?php
/**
 * Module Name: Unload
 * Module URI: https://github.com/thefarside/configurator/tree/main/mu-plugins/configurator/class-unload.php
 * Version: 0.0.1
 * Description: Filter out modules from initialization by blog id.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator;

class Unload {
	public static array $modules = array(
		'Configurator\Modules\Test' => array( 1 ),
	);
}