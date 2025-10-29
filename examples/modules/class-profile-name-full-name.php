<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Profile_Name_Full_Name {

	public static function initialize() : void {
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_new_user_fields' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_fields' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_fields' ), PHP_INT_MAX, 2 );
		add_filter( 'manage_users_columns', array( static::class, 'remove_users_column' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_new_user_fields( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$first_name = $selector->querySelector( '//tr[.//input[@id = "first_name"]]' );
		$first_name?->remove();
		$last_name = $selector->querySelector( '//tr[.//input[@id = "last_name"]]' );
		$last_name?->remove();
		return $document;
	}

	public static function remove_profile_fields( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$first_name = $selector->querySelector( '//tr[@class = "user-first-name-wrap"]' );
		$first_name?->remove();
		$last_name = $selector->querySelector( '//tr[@class = "user-last-name-wrap"]' );
		$last_name?->remove();
		return $document;
	}

	public static function remove_users_column( array $columns ) : array {
		unset( $columns['name'] );
		return $columns;
	}
}