<?php

namespace Configurator\Modules;

class Custom_Post_Type {

	public static string $label = '';

	public static function initialize() : void {
		add_filter( 'init', array( static::class, 'register_post_type' ), PHP_INT_MAX );
		return;
	}

	public static function register_post_type() : void {
		$args = apply_filters( 'register_post_type_params', array( 'labels' => array ( 'name' => '' ) ) );
		static::$label = strtolower( $args['labels']['name'] );
		if ( ! $args['labels']['name'] ) return;
		register_post_type( static::$label, $args );
		return;
	}
}