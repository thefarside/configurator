<?php

namespace Configurator\Modules\WC;

class WC_Widgets {

	public static function initialize() : void {
		remove_action( 'widgets_init', 'wc_register_widgets' );
	}
}