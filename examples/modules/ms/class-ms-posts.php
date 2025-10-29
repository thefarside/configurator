<?php

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