<?php

namespace Configurator\Modules;

class Referrer_Meta {

	public static function initialize() : void {
		add_action( 'login_head', array( static::class, 'reprioritize_login_head' ), PHP_INT_MIN );
		return;
	}

	public static function reprioritize_login_head() : void {
		remove_action( 'login_head', 'wp_strict_cross_origin_referrer', 10 );
		return;
	}
}