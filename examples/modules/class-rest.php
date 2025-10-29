<?php

namespace Configurator\Modules;

use Configurator\Helpers\HTTP_Status_Codes;

class Rest {

	public static function initialize() : void {
		remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		remove_filter( 'rest_authentication_errors', 'rest_application_password_check_errors', 90 );
		remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );
		add_filter( 'rest_authentication_errors', array( static::class, 'restrict_endpoints' ), PHP_INT_MAX );
		return;
	}

	public static function restrict_endpoints() : void {
		$whitelisted_endpoints = apply_filters( 'rest_endpoint_whitelist', array() );
		global $wp;
		if ( ! is_user_logged_in() && ! in_array( $wp->request, $whitelisted_endpoints ) ) {
			HTTP_Status_Codes::set_403();
		}
		return;
	}
}