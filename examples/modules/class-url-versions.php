<?php
/**
 * Module Name: URL Versions
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-url-versions.php
 * Version: 0.0.1
 * Description: Disables auto appending a "cache breaking" version number on styles and scripts.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

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