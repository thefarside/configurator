<?php

namespace Configurator\Modules\WC;

class WC_Reviews {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'disable_settings' ), PHP_INT_MAX );
		add_filter( 'woocommerce_product_settings', array( static::class, 'remove_settings' ), PHP_INT_MAX, 1 );
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		add_filter( 'set_302-edit.php', array( static::class, 'change_reviews_endpoint' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'delete_content' ), PHP_INT_MAX );
		return;
	}

	public static function disable_settings() : void {
		update_option( 'woocommerce_enable_reviews', 'no' );
		return;
	}

	public static function remove_settings( array $settings ) : array {
		return array_filter( $settings, function( array $setting ) : bool {
			return ! in_array( $setting['id'], array(
				'product_rating_options',
				'woocommerce_enable_reviews',
				'woocommerce_review_rating_verification_label',
				'woocommerce_review_rating_verification_required',
				'woocommerce_enable_review_rating',
				'woocommerce_review_rating_required',
			) );
		} );
	}

	public static function remove_admin_menu_pages() : void {
		remove_submenu_page( 'edit.php?post_type=product', 'product-reviews' );
		return;
	}

	public static function change_reviews_endpoint( string $url ) : string {
		if ( isset( $_GET['page'] ) && 'product-reviews' === $_GET['page'] ) {
			return admin_url();
		}
		return $url;
	}

	public static function delete_content() : void {
		$comments = get_comments( array( 
			'type' => 'review',
			'status' => 'any',
		 ) );
		foreach ( $comments as $comment ) {
			wp_delete_comment( $comment->comment_ID, true );
		}
		return;
	}
}