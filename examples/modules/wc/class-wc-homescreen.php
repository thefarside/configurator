<?php

namespace Configurator\Modules\WC;

class WC_Homescreen {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function disable_feature( array $features ) : array {
		$features['homescreen'] = false;
		return $features;
	}
}