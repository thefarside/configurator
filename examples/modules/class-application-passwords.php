<?php

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