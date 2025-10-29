<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Robots_Meta {

	public static function initialize() : void {
		add_filter( 'parse_html-site-info.php', array( static::class, 'remove_network_site_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-wp-signup.php', array( static::class, 'hide_signup_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_network_site_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//label[.//input[@name = "blog[public]"]] |
			//label[.//input[@name = "blog[public]"]]/following-sibling::br[1]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}

	public static function hide_signup_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$option = $selector->querySelector( '//input[@id = "blog_public_on"]' );
		$option?->setAttribute( 'checked', 'checked' );
		$option?->setAttribute( 'type', 'hidden' );
		$form = $selector->querySelector( '//form[@id = "setupform"]' );
		$form?->append( $option ?? '' );
		$setting = $selector->querySelector( '//div[@id = "privacy"]' );
		$setting?->remove();
		return $document;
	}
}