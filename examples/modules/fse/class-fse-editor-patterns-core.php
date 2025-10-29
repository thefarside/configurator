<?php

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