<?php

namespace Configurator\Modules\MS;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class MS_Emails_New_User {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_network_setting' ), PHP_INT_MAX );
		add_filter( 'parse_html-settings.php', array( static::class, 'remove_network_setting' ), PHP_INT_MAX, 2 );
		add_filter( 'wpmu_signup_user_notification', array( static::class, 'disable_email_sending' ), PHP_INT_MAX );
		add_filter( 'wpmu_welcome_user_notification', array( static::class, 'disable_email_sending' ), PHP_INT_MAX );
		add_filter( 'parse_html-user-new.php', array( static::class, 'disable_user_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'wp_admin_notice_markup', array( static::class, 'remove_user_notice' ), PHP_INT_MAX, 3 );
		return;
	}

	public static function disable_network_setting() : void {
		update_site_option( 'registrationnotification', 'no' );
		return;
	}

	public static function remove_network_setting( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[.//th[text() = "Registration notification"]]' );
		$setting?->remove();
		return $document;
	}

	public static function disable_email_sending() : bool {
		if ( is_super_admin() && isset( $_POST['noconfirmation'] ) ) {
			return false;
		}
		return true;
	}

	public static function disable_user_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		if ( is_super_admin() ) {
			$add_user_checkbox = $selector->querySelector( '//input[@id = "adduser-noconfirmation"]' );
			$add_user_checkbox?->setAttribute( 'checked', 'checked' );
			$add_user_section = $selector->querySelector( '//tr[.//input[@id = "adduser-noconfirmation"]]' );
			$add_user_section?->setAttribute( 'style', 'display: none' );
			$add_user_description = $selector->querySelector( '//h2[@id = "add-existing-user"]/following-sibling::p[1]' );
			$add_user_description?->remove();
			$new_user_checkbox = $selector->querySelector( '//input[@id = "noconfirmation"]' );
			$new_user_checkbox?->setAttribute( 'checked', 'checked' );
			$new_user_section = $selector->querySelector( '//tr[.//input[@id = "noconfirmation"]]' );
			$new_user_section?->setAttribute( 'style', 'display: none' );
			$new_user_description = $selector->querySelector( '//h2[@id = "create-new-user"]/following-sibling::p[1]' );
			$new_user_description?->remove();
		}
		return $document;
	}

	public static function remove_user_notice( string $markup, string $message, array $args ) : string {
		if ( is_super_admin() && 'user-new.php' === $GLOBALS['pagenow'] && 'message' === $args['id'] ) {
			return '';
		}
		return $markup;
	}
}