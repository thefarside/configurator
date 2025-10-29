<?php

namespace Configurator\Modules\WC;

class WC_Pay_Promotion {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
	}

	public static function disable_feature( array $features ) : array {
		$features['wc-pay-promotion'] = false;
		return $features;
	}
}