<?php

namespace Configurator\Modules;

class Canonical_Link {

	public static function initialize() : void {
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'admin_head', array( static::class, 'reprioritize_admin_head' ), PHP_INT_MIN );
		return;
	}

	public static function reprioritize_admin_head() : void {
		remove_action( 'admin_head', 'wp_admin_canonical_url' );
		return;
	}
}