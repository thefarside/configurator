<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Required_Email {

	public static function initialize() : void {
		add_filter( 'wpmu_validate_user_signup', array( static::class, 'remove_signup_errors' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-wp-signup.php', array( static::class, 'remove_signup_notice' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-site-users.php', array( static::class, 'override_new_site_user_field_requirement' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_new_user_field_requirement' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_signup_errors( array $result ) : array {
		$result['errors']->remove( 'user_email' );
		return $result;
	}

	public static function remove_signup_notice( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$notice = $selector->querySelector( '//*[text()[contains( ., "Check your inbox" )]]' );
		$notice?->remove();
		return $document;
	}

	public static function override_new_site_user_field_requirement( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$field = $selector->querySelector( '//input[@id = "user_email"]' );
		$field?->setAttribute( 'type', 'hidden' );
		$field?->setAttribute( 'value', ' ' );
		$form = $selector->querySelector( '//form[@id = "newuser"]' );
		$form?->append( $field  ?? '' );
		$row = $selector->querySelector( '//tr[.//input[@id = "user_email"]]' );
		$row?->remove();
		return $document;
	}

	public static function remove_new_user_field_requirement( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		if ( is_network_admin() ) {
			$notice = $selector->querySelector( '//label[@for = "email"]/span[@class = "required"]' );
			$notice?->remove();
			$field = $document->getElementById( 'email' );
			$field?->removeAttribute( 'required' );
		}
		return $document;
	}
}