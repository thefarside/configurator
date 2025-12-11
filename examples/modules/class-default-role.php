<?php
/**
 * Module Name: Default Role
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-default-role.php
 * Version: 0.0.1
 * Description: Sets the default role to "Subscriber" then disables the setting and removes related GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Default_Role {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'set_role' ), PHP_INT_MAX );
		add_filter( 'parse_html-options-general.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function set_role() : void {
		update_option( 'default_role', 'subscriber' );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[./td/select[@id = "default_role"]]' );
		$setting?->remove();
		return $document;
	}
}