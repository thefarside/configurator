<?php

namespace Configurator\Modules;

use WP_User;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class User_Passwords {

	public static function initialize() : void {
		add_filter( 'allow_password_reset', array( static::class, 'restrict_reset' ), PHP_INT_MAX, 2 );
		add_filter( 'show_password_fields', array( static::class, 'restrict_change' ), PHP_INT_MAX, 2 );
		add_filter( 'bulk_actions-users', array( static::class, 'remove_bulk_change' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'hide_creation' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function restrict_reset( bool $allow, int $id ) : bool {
		if ( array_intersect( ['administrator'], get_userdata( $id )->roles ) || 
			 isset( $_POST['send_user_notification'] ) ||
			 isset( $_POST['wp-submit'] ) && 'Register' === $_POST['wp-submit'] ) {
			return true;
		}
		return false;
	}

	public static function restrict_change( bool $show, WP_User $profile_user ) : bool {
		if ( array_intersect( ['administrator'], $profile_user->roles ) ) {
			return true;
		}
		return false;
	}

	public static function remove_bulk_change( array $actions ) : array {
		unset( $actions['resetpassword'] );
		return $actions;
	}

	public static function hide_creation( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$pass1 = $selector->querySelector( '//tr[.//input[@id = "pass1"]]' );
		$pass1?->setAttribute( 'class', "{$pass1->getAttribute( 'class' )} hide-if-js" );
		return $document;
	}
}