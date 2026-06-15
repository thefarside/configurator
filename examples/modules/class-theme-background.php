<?php
/**
 * Module Name: Theme Background
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-theme-background.php
 * Version: 0.0.1
 * Description: Disables custom background support for non-FSE themes.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Theme_Background {

	public static function initialize() : void {
		add_action( 'after_setup_theme', array( static::class, 'remove_theme_background' ), PHP_INT_MAX );
		return;
	}

	public static function remove_theme_background() : void {
		remove_theme_support( 'custom-background' );
		return;
	}
}