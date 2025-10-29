<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Auto_Update_Themes {

	public static function initialize() : void {
		add_filter( 'auto_update_theme', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'themes_auto_update_enabled', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'site_status_tests', array( static::class, 'remove_site_status_tests' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_site_status_tests( array $tests ) : array {
		unset( $tests['direct']['theme_version'] );
		if ( isset( $tests['direct']['plugin_theme_auto_updates'] ) ) {
			unset( $tests['direct']['plugin_theme_auto_updates'] );
		}
		return $tests;
	}
}