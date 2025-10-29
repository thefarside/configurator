<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;
use Configurator\Helpers\HTTP_Status_Codes;

class Author_Archives {

	public static function initialize() : void {
		add_filter( 'author_link', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		add_action( 'template_redirect', array( static::class, 'disable_endpoint' ), PHP_INT_MAX );
		add_filter( 'xmlrpc_methods', array( static::class, 'remove_xmlrpc_methods' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_endpoint() : void {
		if ( is_author() ) {
			HTTP_Status_Codes::set_404();
		}
		return;
	}

	public static function remove_xmlrpc_methods( array $methods ) : array {
		unset( $methods['wp.getAuthors'] );
		return $methods;
    }
}