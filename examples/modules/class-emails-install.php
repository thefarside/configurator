<?php
/**
 * Module Name: Emails Install
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-emails-install.php
 * Version: 0.0.1
 * Description: Disables sending the welcome email for a new install.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules;

class Emails_Install {

	public static function initialize() : void {
		add_filter( 'wp_installed_email', array( static::class, 'blank_out_email_fields' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function blank_out_email_fields( array $installed_email ) : array {
		$installed_email['to'] = '';
		$installed_email['subject'] = '';
		$installed_email['message'] = '';
		return $installed_email;
	}
}