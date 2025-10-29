<?php

namespace Configurator\Modules;

class Viewport_Meta {

	public static function initialize() : void {
		add_action( 'wp_head', array( static::class, 'reprioritize_head' ), PHP_INT_MIN );
		add_action( 'admin_head', array( static::class, 'reprioritize_admin_head' ), PHP_INT_MIN );
		add_action( 'login_head', array( static::class, 'reprioritize_login_head' ), PHP_INT_MIN );
		return;
	}

	public static function reprioritize_head() : void {
		remove_action( 'wp_head', '_block_template_viewport_meta_tag', 0 );
		return;
	}

	public static function reprioritize_admin_head() : void {
		remove_action( 'admin_head', 'wp_admin_viewport_meta' );
		return;
	}

	public static function reprioritize_login_head() : void {
		remove_action( 'login_head', 'wp_login_viewport_meta' );
		return;
	}
}