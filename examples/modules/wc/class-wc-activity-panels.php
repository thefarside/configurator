<?php

namespace Configurator\Modules\WC;

class WC_Activity_Panels {

	public static function initialize() : void {
		//add_filter( 'woocommerce_admin_get_feature_config', array( static::class, 'disable_feature' ), PHP_INT_MAX, 1 );
		add_action( 'admin_enqueue_scripts', array( static::class, 'fix_gui' ), PHP_INT_MAX );
		return;
	}

	public static function disable_feature( array $features ) : array {
		$features['activity-panels'] = false;
		return $features;
	}

	public static function fix_gui() : void {
		if ( ! function_exists( 'wc_get_screen_ids' ) ) return;
		$screen_id = get_current_screen()?->id;
		$wc_screen_ids = array_filter( wc_get_screen_ids() );
		if ( in_array( $screen_id, $wc_screen_ids ) ) {
			$style = <<<EOD
				.woocommerce-admin-page #wpbody { margin-top: unset; }
				.woocommerce-admin-page #wpbody .wrap { margin-top: 10px; }
				.woocommerce-admin-page .woocommerce-layout__header { display: none; }
			EOD;
			wp_register_style( 'wc-activity-panels-fix', false, array(), false );
			wp_enqueue_style( 'wc-activity-panels-fix' );
			wp_add_inline_style( 'wc-activity-panels-fix', $style );
		}
		return;
	}
}