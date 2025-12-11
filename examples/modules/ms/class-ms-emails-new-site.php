<?php
/**
 * Module Name: MS Emails New Site
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/ms/class-ms-emails-new-site.php
 * Version: 0.0.1
 * Description: Disables sending all emails related to new site registration and removes the related GUI elements.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 * Requires Modules: Configurator\Helpers\Return_Types, Configurator\Helpers\DOMXPath, \DOMDocument
 */

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;
use Configurator\Helpers\Return_Types;

class MS_Emails_New_Site {

	public static function initialize() : void {
		add_filter( 'send_new_site_email', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'wpmu_welcome_notification', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'wpmu_signup_blog_notification', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//textarea[@id = "welcome_email"]]' );
		$setting?->remove();
		return $document;
	}
}