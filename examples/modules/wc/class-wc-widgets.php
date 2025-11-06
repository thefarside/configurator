<?php

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