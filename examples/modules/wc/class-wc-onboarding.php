<?php
/**
 * Module Name: WC Onboarding
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-onboarding.php
 * Version: 0.0.1
 * Description: Prevents onboarding tasks from showing on the WooCommerce "Home" page.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\WC;

class WC_Onboarding {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_onboarding_features' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_onboarding_features( array $features ) : array {
		//$features['onboarding'] = false;
		$features['onboarding-tasks'] = false;
		return $features;
	}
}