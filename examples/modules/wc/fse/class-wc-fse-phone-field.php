<?php

namespace Configurator\Modules\WC\FSE;

use stdClass;

class WC_FSE_Phone_Field {

	public static function initialize() : void {
		add_filter( 'wp_insert_post_data', array( static::class, 'remove_block_markup' ), PHP_INT_MAX, 1 );
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_block_markup( array $data ) : array {
		preg_match_all( '/<!--\s+wp:woocommerce\/checkout\s+.*-->/i', $data['post_content'], $instances );
		foreach ( $instances[0] as $instance ) {
			preg_match( '/{.*}/', $instance, $block_options );
			preg_match( '/(?=\s+-->)/', $instance, $no_options, PREG_OFFSET_CAPTURE );
			if ( $block_options ) {
				$options = $block_options[0];
				$decoded_options = json_decode( stripslashes( $options ) );
				$decoded_options->showPhoneField = false;
				$recoded_options = addslashes( json_encode( $decoded_options ) );
				$new_options = str_replace( $options, $recoded_options, $instance );
			}
			elseif ( $no_options ) {
				$decoded_options = new stdClass();
				$decoded_options->showPhoneField = false;
				$recoded_options = addslashes( json_encode( $decoded_options ) );
				$padded_options = str_pad( $recoded_options, strlen( $recoded_options ) + 1, ' ', STR_PAD_LEFT );
				$options_offset = $no_options[0][1];
				$new_options = substr_replace( $instance, $padded_options, $options_offset, 0 );
			}
			if ( $new_options ) {
				$data['post_content'] = str_replace( $instance, $new_options, $data['post_content'] );
			}
		}
		return $data;
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		return array_merge( $panels, array(
			'//label[contains( text(), "Phone" )]/ancestor::div[contains( @class, "components-base-control__field" )]',
			'//div[contains( @class, "wc-block-components-require-phone-field" )]/child::div',
			'//div[contains( @class, "wc-block-components-address-form__phone" )]',
		) );
	}
}