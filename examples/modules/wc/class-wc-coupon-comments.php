<?php

namespace Configurator\Modules\WC;

class WC_Coupon_Comments {

	public static function initialize() : void {
		add_action( 'add_meta_boxes', array( static::class, 'remove_meta_box' ), PHP_INT_MAX );
		return;
	}

	public static function remove_meta_box() : void {
		remove_meta_box( 'commentsdiv', 'shop_coupon', 'normal' );
		return;
	}
}