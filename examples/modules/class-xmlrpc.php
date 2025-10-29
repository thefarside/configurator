<?php

namespace Configurator\Modules;

use Configurator\Helpers\HTTP_Status_Codes;

class XMLRPC {

	public static function initialize() : void {
		remove_action( 'wp_head', 'rsd_link' );
		add_action( 'setup_theme', array( static::class, 'disable_endpoint' ), PHP_INT_MAX );
		return;
	}

	public static function disable_endpoint() : void {
		if ( defined( 'XMLRPC_REQUEST' ) ) {
			HTTP_Status_Codes::set_403();
		}
		return;
	}
}