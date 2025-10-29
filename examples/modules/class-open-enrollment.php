<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Open_Enrollment {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'close_enrollment' ), PHP_INT_MAX );
		add_filter( 'parse_html-options-general.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function close_enrollment() : void {
		update_option( 'users_can_register', 0 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//input[@id = "users_can_register"]]' );
		$setting?->remove();
		return $document;
	}
}