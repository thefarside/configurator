<?php
/**
 * Module Name: HTTP Status Codes
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/helpers/class-http-status-codes.php
 * Version: 0.0.1
 * Description: Helpers to handle HTTP codes consistently.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Helpers;

class HTTP_Status_Codes {

	public static function initialize() : void {
		add_action( 'wp_loaded', array( static::class, 'set_302' ), PHP_INT_MAX );
		return;
	}

	public static function set_302() : void {
		$page = basename( $_SERVER['SCRIPT_NAME'] );
		$url = apply_filters( "set_302-{$page}", '' );
		if ( $url ) {
			wp_safe_redirect( $url, 302, false );
			exit;
		}
	}

	public static function set_403() : void {
		http_response_code( 403 );
		exit;
	}

	public static function set_404() : void {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
		return;
	}
}