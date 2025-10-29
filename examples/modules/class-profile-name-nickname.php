<?php

namespace Configurator\Modules;

use WP_Error;
use DOMDocument;
use Configurator\Helpers\DOMXPath;
use Configurator\Helpers\Return_Types;

class Profile_Name_Nickname {

	public static function initialize() : void {
		add_filter( 'pre_user_nickname', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		add_action( 'wp_error_added', array( static::class, 'remove_profile_error' ), PHP_INT_MAX, 4 );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_profile_error( string|int $code, string $message, mixed $data, WP_Error $wp_error ) : void {
		unset( $wp_error->errors['nickname'] );
		return;
	}

	public static function remove_profile_field( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$field = $selector->querySelector( '//tr[@class = "user-nickname-wrap"]' );
		$field?->remove();
		return $document;
	}
}