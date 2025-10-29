<?php

namespace Configurator\Modules;

class URL_Versions {

	public static function initialize() : void {
		add_filter( 'script_loader_src', array( static::class, 'remove' ), PHP_INT_MAX, 1 );
		add_filter( 'style_loader_src', array( static::class, 'remove' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove( string $src ) : string {
		$src = remove_query_arg( 'ver', $src );
		return $src;
	}
}