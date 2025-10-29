<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;
use Configurator\Helpers\Return_Types;

class Role_Change {

	public static function initialize() : void {
		add_action( 'add_user_role', array( static::class, 'remove_user_role' ), PHP_INT_MAX, 2 );
		add_action( 'remove_user_role', array( static::class, 'add_user_role' ), PHP_INT_MAX, 2 );
		add_filter( 'views_users', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'manage_users_columns', array( static::class, 'remove_column' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-users.php', array( static::class, 'remove_users_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'hide_new_user_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_edit_user_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function add_user_role( int $user_id, string $role ) : void {
		$user = get_userdata( $user_id );
		if ( empty( $role ) ) {
			return;
		}
		if ( in_array( $role, $user->roles, true ) ) {
			return;
		}
		$user->caps[ $role ] = true;
		update_user_meta( $user->ID, $user->cap_key, $user->caps );
		$user->get_role_caps();
		$user->update_user_level_from_caps();
		return;
	}

	public static function remove_user_role( int $user_id, string $role ) : void {
		$user = get_userdata( $user_id );
		if ( ! in_array( $role, $user->roles, true ) ) {
			return;
		}
		unset( $user->caps[ $role ] );
		update_user_meta( $user->ID, $user->cap_key, $user->caps );
		$user->get_role_caps();
		$user->update_user_level_from_caps();
		return;
	}

	public static function remove_column( array $columns ) : array {
		unset( $columns['role'] );
		return $columns;
	}

	public static function remove_users_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '//div[./select[contains( @id, "new_role" )]]' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}

	public static function hide_new_user_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//select[@id = "role"]]' );
		$setting?->setAttribute( 'style', 'display: none' );
		return $document;
	}

	public static function remove_edit_user_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//select[@id = "role"]]' );
		$setting?->remove();
		return $document;
	}
}