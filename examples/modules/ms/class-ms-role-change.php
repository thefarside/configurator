<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;
use Configurator\Helpers\Return_Types;

class MS_Role_Change {

	public static function initialize() : void {
		add_action( 'granted_super_admin', array( static::class, 'revoke_super_admin' ), PHP_INT_MAX, 1 );
		add_action( 'revoked_super_admin', array( static::class, 'grant_super_admin' ), PHP_INT_MAX, 1 );
		add_filter( 'views_users-network', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'views_site-users-network', array( Return_Types::class, 'return_empty_array' ), PHP_INT_MAX );
		add_filter( 'manage_site-users-network_columns', array( static::class, 'remove_column' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-site-users.php', array( static::class, 'remove_users_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_edit_user_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'hide_new_user_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-site-users.php', array( static::class, 'hide_site_users_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function grant_super_admin( int $user_id ) : void {
		$super_admins = get_site_option( 'site_admins', array( 'admin' ) );
		$user = get_userdata( $user_id );
		if ( ! in_array( $user->user_login, $super_admins, true ) ) {
			$super_admins[] = $user->user_login;
			update_site_option( 'site_admins', $super_admins );
		}
		return;
	}

	public static function revoke_super_admin( int $user_id ) : void {
		$super_admins = get_site_option( 'site_admins', array( 'admin' ) );
		$user = get_userdata( $user_id );
		if ( $user && 0 !== strcasecmp( $user->user_email, get_site_option( 'admin_email' ) ) ) {
			$key = array_search( $user->user_login, $super_admins, true );
			if ( false !== $key ) {
				unset( $super_admins[ $key ] );
				update_site_option( 'site_admins', $super_admins );
			}
		}
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

	public static function remove_edit_user_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[@class = "user-super-admin-wrap"]' );
		$setting?->remove();
		return $document;
	}

	public static function hide_new_user_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//select[@id = "adduser-role"]]' );
		$setting?->setAttribute( 'style', 'display: none' );
		return $document;
	}

	public static function hide_site_users_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//tr[.//select[@id = "new_role_adduser"]] |
			//tr[.//select[@id = "new_role_newuser"]]
		' );
		foreach ( $settings as $setting ) {
			$setting->setAttribute( 'style', 'display: none' );
		}
		return $document;
	}
}