<?php

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