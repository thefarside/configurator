<?php

namespace Configurator\Modules;

class Theme_Patterns {

	public static function initialize() : void {
		add_action( 'after_setup_theme', array( static::class, 'remove_theme_patterns' ), PHP_INT_MAX );
		return;
	}

	public static function remove_theme_patterns() : void {
		remove_theme_support( 'core-block-patterns' );
		return;
	}
}