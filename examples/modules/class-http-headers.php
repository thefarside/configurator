<?php

namespace Configurator\Modules;

use WpOrg\Requests\Cookie;

require_once ABSPATH . 'wp-includes' . DIRECTORY_SEPARATOR . 'Requests' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Cookie.php';

class HTTP_Headers {

	public static function initialize() : void {
		add_action( 'wp_print_scripts', array( static::class, 'revise_cookies' ), PHP_INT_MAX );
		add_action( 'wp_print_scripts', array( static::class, 'revise_headers' ), PHP_INT_MAX );
		add_filter( 'rest_pre_serve_request', array( static::class, 'revise_headers' ), PHP_INT_MAX );
		return;
	}

	public static function revise_headers() : void {
		$blacklist = apply_filters( 'header_blacklist', array() );
		if ( in_array( 'X-Frame-Options', $blacklist ) ) {
			remove_action( 'admin_init', 'send_frame_options_header', 10 );
			remove_action( 'login_init', 'send_frame_options_header', 10 );
		}
		if ( in_array( 'Referrer-Policy', $blacklist ) ) {
			remove_action( 'admin_init', 'wp_admin_headers' );
			remove_action( 'login_init', 'wp_admin_headers' );
		}
		foreach ( headers_list() as $header ) {
			$header_name = explode( ': ', $header )[0];
			if ( in_array( $header_name, $blacklist ) ) {
				header_remove( $header_name );
			}
		}
		foreach ( apply_filters( 'add_headers', array() ) as $header ) {
			header( $header );
		}
		$page = basename( $_SERVER['SCRIPT_NAME'] );
		foreach ( apply_filters( "add_headers-{$page}", array() ) as $header ) {
			header( $header );
		}
	}

	public static function revise_cookies() : void {
		$cookie_headers = array_filter( headers_list(), function( string $header ) : bool {
			return str_contains( $header, 'Set-Cookie');
		} );
		$cookies = array_map( function( string $cookie_header ) : Cookie {
			return Cookie::parse( trim( explode( ':', $cookie_header, 2 )[1] ) );
		}, $cookie_headers );
		$valid_cookies = array_filter( $cookies, function( Cookie $cookie ) : bool {
			return ! in_array( $cookie->name, apply_filters( 'cookie_blacklist', array() ) );
		} );
		$page = basename( $_SERVER['SCRIPT_NAME'] );
		$new_cookies = array_merge( $valid_cookies, apply_filters( "add_cookies-{$page}", array() ) );
		header_remove( 'Set-Cookie' );
		foreach ( $new_cookies as $cookie ) {
			foreach ( $cookie->attributes as $option => $value ) {
				if ( 'max-age' !== $option ) {
					$options[ $option ] = $value;
				}
			}
			setcookie( $cookie->name, $cookie->value, $options );
		}
		return;
	}
}