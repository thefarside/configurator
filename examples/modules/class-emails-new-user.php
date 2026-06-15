<?php
/**
 * Module Name: Emails New User
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-emails-new-user.php
 * Version: 0.0.1
 * Description: Disables sending user registration receipt email and removes related GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\Return_Types;

class Emails_New_User {

	public static function initialize() : void {
		add_filter( 'wp_send_new_user_notification_to_admin', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'parse_html-user-new.php', array( static::class, 'set_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function set_settings( DOMDocument $document ) : DOMDocument {
		$checkbox = $document->getElementById( 'send_user_notification' );
		$checkbox?->removeAttribute( 'checked' );
		return $document;
	}
}