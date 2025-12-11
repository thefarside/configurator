<?php
/**
 * Module Name: MS Posts
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-posts.php
 * Version: 0.0.1
 * Description: Extends Configurator\Modules\Posts to include multisite fields and GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Posts {

	public static function initialize() : void {
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_network_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_network_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//textarea[@id = "first_post"]]' );
		$setting?->remove();
		return $document;
	}
}