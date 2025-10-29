<?php

namespace Configurator\Modules\WC;

class WC_Onboarding {

	public static function initialize() : void {
		add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_onboarding_features' ), PHP_INT_MAX, 1 );
	}

	public static function disable_onboarding_features( array $features ) : array {
		$features['onboarding'] = false;
		$features['onboarding-tasks'] = false;
		return $features;
	}
}