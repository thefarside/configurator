<?php
/**
 * Module Name: Lazy Loading
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-lazing-loading.php
 * Version: 0.0.1
 * Description: Disables WordPress "lazy loading".
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Lazy_Loading {

	public static function initialize() : void {
		add_filter( 'wp_lazy_loading_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		return;
	}
}