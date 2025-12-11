<?php
/**
 * Module Name: Application Passwords
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-application-passwords.php
 * Version: 0.0.1
 * Description: Disables the use of user application passwords and removes related GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\Return_Types;

class Application_Passwords {

	public static function initialize() : void {
		add_filter( 'wp_is_application_passwords_available', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_settings( DOMDocument $document ) : DOMDocument {
		$section = $document->getElementById( 'application-passwords-section' );
		$section?->remove();
		return $document;
	}
}