<?php
/**
 * Module Name: WC Customizer
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-customizer.php
 * Version: 0.0.1
 * Description: Disables the WooCommerce "Customizer" (admin.php?page=wc-admin&path=/customize-store)
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

namespace Configurator\Modules\WC;

class WC_Customizer {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_feature( array $features ) : array {
		$features['customize-store'] = false;
		return $features;
	}
}