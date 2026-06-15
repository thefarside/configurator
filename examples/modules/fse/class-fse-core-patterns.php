<?php
/**
 * Module Name: FSE Core Patterns
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-core-patterns.php
 * Version: 0.0.1
 * Description: Removes the default block patterns from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\FSE;

class FSE_Core_Patterns {

	public static function initialize() : void {
		add_action( 'after_setup_theme', array( static::class, 'remove_theme_patterns' ), PHP_INT_MAX );
		return;
	}

	public static function remove_theme_patterns() : void {
		remove_theme_support( 'core-block-patterns' );
		return;
	}
}