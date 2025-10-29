<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Auto_Update_Core {

	public static function initialize() : void {
		add_filter( 'allow_dev_auto_core_updates', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'allow_minor_auto_core_updates', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'allow_major_auto_core_updates', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_action( 'admin_init', array( static::class, 'disallow_options' ), PHP_INT_MAX );
		add_action( 'wp_before_admin_bar_render', array( static::class, 'remove_admin_bar_node' ), PHP_INT_MAX );
		add_filter( 'site_status_tests', array( static::class, 'remove_site_status_tests' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disallow_options() : void {
		update_option( 'auto_update_core_minor', 'disabled' );
		update_option( 'auto_update_core_major', 'disabled' );
		update_option( 'auto_update_core_dev', 'disabled' );
		return;
	}

	public static function remove_admin_bar_node() : void {
		global $wp_admin_bar;
		$wp_admin_bar->remove_node( 'updates' );
		return;
	}

	public static function remove_site_status_tests( array $tests ) : array {
		unset( $tests['direct']['wordpress_version'] );
		unset( $tests['async']['background_updates'] );
		return $tests;
	}
}