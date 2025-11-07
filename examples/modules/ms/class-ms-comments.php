<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Comments {

	public static function initialize() : void {
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//tr[.//textarea[@id = "first_comment"]] |
			//tr[.//input[@id = "first_comment_author"]] |
			//tr[.//input[@id = "first_comment_email"]] |
			//tr[.//input[@id = "first_comment_url"]]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}
}