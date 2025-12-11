<?php
/**
 * Module Name: MS User Passwords
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-user-passwords.php
 * Version: 0.0.1
 * Description: Extends Configurator\Modules\User_Passwords to include multisite fields and GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_User_Passwords {

	public static function initialize() : void {
		add_filter( 'bulk_actions-site-users-network', array( static::class, 'remove_bulk_change' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-site-users.php', array( static::class, 'remove_notice' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-new.php', array( static::class, 'remove_notice' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_bulk_change( array $actions ) : array {
		unset( $actions['resetpassword'] );
		return $actions;
	}

	public static function remove_notice( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$notice = $selector->querySelector( '//td[@class = "td-full"]' );
		$notice?->remove();
		return $document;
	}
}