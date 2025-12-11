<?php
/**
 * Module Name: FSE Editor Patterns Core
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-editor-patterns-core.php
 * Version: 0.0.1
 * Description: Disables use of core patterns with Gutenberg editors.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\FSE;

class FSE_Editor_Patterns_Core {

	public static function initialize() : void {
		add_action( 'after_setup_theme', array( static::class, 'unregister_core_editor_patterns' ), PHP_INT_MAX );
	}

	public static function unregister_core_editor_patterns() : void {
		remove_theme_support( 'core-block-patterns' );
		return;
	}
}