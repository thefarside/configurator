<?php

namespace Configurator\Modules;

class Head {

	public static function initialize() : void {
		add_action( 'wp_head', array( static::class, 'append' ), 2 );
		add_action( 'admin_head', array( static::class, 'append' ), PHP_INT_MIN );
		add_action( 'login_head', array( static::class, 'append' ), PHP_INT_MIN );
		return;
	}

	public static function append() : void {
		$page = basename( $_SERVER['SCRIPT_NAME'] );
		$elements = array_merge( apply_filters( 'append_head', array() ), apply_filters( "append_head-{$page}", array() ) );
		foreach ( $elements as $element ) {
			echo $element;
		}
		return;
	}
}