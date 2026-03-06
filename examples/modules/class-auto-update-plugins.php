<?php
/**
 * Module Name: Auto Update Plugins
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-auto-update-plugins.php
 * Version: 0.0.1
 * Description: Disables plugin auto updates, removes related notifications.
 * Requires at least: 6.9.1
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Auto_Update_Plugins {

	public static function initialize() : void {
		add_filter( 'auto_update_plugin', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'plugins_auto_update_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'site_status_tests', array( static::class, 'remove_site_status_tests' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_site_status_tests( array $tests ) : array {
		unset( $tests['direct']['plugin_version'] );
		if ( isset( $tests['direct']['plugin_theme_auto_updates'] ) ) {
			unset( $tests['direct']['plugin_theme_auto_updates'] );
		}
		return $tests;
	}
}