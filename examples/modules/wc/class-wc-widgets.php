<?php
/**
 * Module Name: WC Widgets
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/class-wc-widgets.php
 * Version: 0.0.1
 * Description: Disables all Woocommerce widgets.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\WC;

class WC_Widgets {

	public static function initialize() : void {
		remove_action( 'widgets_init', 'wc_register_widgets' );
		add_action( 'widgets_init', array( static::class, 'unregister_wc_widgets' ), 11 );
		return;
	}

	public static function unregister_wc_widgets() : void {
		unregister_widget( 'WC_Widget_Brand_Description' );
		unregister_widget( 'WC_Widget_Brand_Nav' );
		unregister_widget( 'WC_Widget_Brand_Thumbnails' );
		return;
	}
}