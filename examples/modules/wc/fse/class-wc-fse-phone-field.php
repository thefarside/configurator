<?php
/**
 * Module Name: WC FSE Phone Field
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/wc/fse/class-wc-fse-phone-field.php
 * Version: 0.0.1
 * Description: Removes the "Phone" field and panel options from the WooCommerce "checkout" block.
 * Requires at least: 6.9
 * Requires PHP: 8.4.11
 */

namespace Configurator\Modules\WC\FSE;

class WC_FSE_Phone_Field {

	public static function initialize() : void {
		add_action( 'rest_api_init', array( static::class, 'force_setting' ), PHP_INT_MAX );
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function force_setting() : void {
		update_option( 'woocommerce_checkout_phone_field', 'hidden' );
		return;
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		return array_merge( $panels, array(
			'//label[contains( text(), "Phone" )]/ancestor::div[contains( @class, "components-base-control__field" )]',
			'//fieldset[contains( @class, "wc-block-components-require-phone-field" )]/child::div',
		) );
	}
}