<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Open_Enrollment {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'close_enrollment' ), PHP_INT_MAX );
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function close_enrollment() : void {
		update_site_option( 'registration', 'none' );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//tr[.//th[text() = "Allow new registrations"]] |
			//tr[.//label[text() = "Banned Names"]] |
			//tr[.//label[text() = "Limited Email Registrations"]] |
			//tr[.//label[text() = "Banned Email Domains"]]
		' );
		foreach ( $settings as $setting ) {
			$setting?->remove();
		}
		return $document;
	}
}