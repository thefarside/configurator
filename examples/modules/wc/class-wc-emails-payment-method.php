<?php

namespace Configurator\Modules\WC;

use WC_Payment_Gateways;

class WC_Emails_Payment_Method {

	public static function initialize() : void {
		add_filter( 'pre_wp_mail', array( static::class, 'disable_email_notification' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function disable_email_notification( null $bool, array $atts ) : null|bool {
		if ( ! class_exists( 'WC_Payment_Gateways' ) ) return null;
		if ( '' !== get_option( 'blogname' ) ) {
			$site_title = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
		} else {
			$site_title = wp_parse_url( home_url(), PHP_URL_HOST );
		}
		$payment_gateways_instance = WC_Payment_Gateways::instance();
		$payment_gateways = $payment_gateways_instance->payment_gateways();
		foreach ( $payment_gateways as $payment_gateway ) {
			$gateway_title = $payment_gateway->title;
			$subject = sprintf(
				__( '[%1$s] Payment gateway "%2$s" enabled', 'woocommerce' ),
				$site_title,
				$gateway_title
			);
			if ( $subject === $atts['subject'] ) {
				return false;
			}
		}
		return null;
	}
}