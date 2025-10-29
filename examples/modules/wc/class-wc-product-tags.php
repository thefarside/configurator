<?php

namespace Configurator\Modules\WC;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class WC_Product_Tags {

	public static function initialize() : void {
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_page' ), PHP_INT_MAX );
		add_filter( 'set_302-term.php', array( static::class, 'change_product_tags_endpoints' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-edit-tags.php', array( static::class, 'change_product_tags_endpoints' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-options-permalink.php', array( static::class, 'remove_permalink_setting' ), PHP_INT_MAX, 2 );
		add_filter( 'manage_product_posts_columns', array( static::class, 'remove_products_column' ), PHP_INT_MAX, 1 );
		add_filter( 'quick_edit_show_taxonomy', array( static::class, 'remove_products_quick_edit_field' ), PHP_INT_MAX, 2 );
		add_action( 'admin_init', array( static::class, 'remove_post_metabox' ), PHP_INT_MAX );
		add_action( 'admin_head', array( static::class, 'remove_menu_metabox' ), PHP_INT_MAX );
		add_action( 'widgets_init', array( static::class, 'remove_widget' ), PHP_INT_MIN );
		add_action( 'admin_init', array( static::class, 'delete_taxonomy_and_terms' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_menu_page() : void {
		remove_submenu_page( 'edit.php?post_type=product', 'edit-tags.php?taxonomy=product_tag&amp;post_type=product' );
		return;
	}

	public static function change_product_tags_endpoints( string $url ) : string {
		if ( isset( $_GET['taxonomy'] ) && 'product_tag' === $_GET['taxonomy'] ) {
			return admin_url();
		}
		return $url;
	}

	public static function remove_permalink_setting( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//tr[./td/input[@name = "woocommerce_product_tag_slug"]]' );
		$setting?->remove();
		return $document;
	}

	public static function remove_products_column( array $columns ) : array {
		unset( $columns['product_tag'] );
		return $columns;
	}

	public static function remove_products_quick_edit_field( bool $show, string $taxonomy_name ) : bool {
		if ( 'product_tag' === $taxonomy_name ) {
			return false;
		}
		return $show;
	}

	public static function remove_post_metabox() : void {
		remove_meta_box( 'tagsdiv-product_tag', 'product', 'side' );
		return;
	}

	public static function remove_menu_metabox() : void {
		remove_meta_box( 'add-product_tag', 'nav-menus', 'side' );
		return;
	}

	public static function remove_widget() : void {
		unregister_widget( 'WC_Widget_Product_Tag_Cloud' );
		return;
	}

	public static function delete_taxonomy_and_terms() : void {
		register_taxonomy( 'product_tag', array() );
		$terms = get_terms( array( 
			'taxonomy'   => 'product_tag',
			'hide_empty' => false,
		 ) );
		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, $term->taxonomy ); 
		}
		return;
	}
}