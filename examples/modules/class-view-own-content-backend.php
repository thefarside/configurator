<?php
namespace Configurator\Modules;

use WP_Query;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class View_Own_Content_Backend {

	public static function initialize() : void {
		add_action( 'pre_get_posts', array( static::class, 'exclude_others_posts' ), PHP_INT_MAX, 1 );
		add_filter( 'views_edit-post', array( static::class, 'remove_post_views' ), PHP_INT_MAX, 1 );
		add_filter( 'views_edit-page', array( static::class, 'remove_post_views' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-upload.php', array( static::class, 'remove_media_views' ), PHP_INT_MAX, 2 );
		add_action( 'admin_enqueue_scripts', array( static::class, 'remove_media_views_ajax' ), PHP_INT_MAX );
		add_action( 'manage_upload_columns', array( static::class, 'remove_media_column' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function exclude_others_posts( WP_Query $query ) : WP_Query {
		if( is_admin() && !current_user_can( 'edit_others_posts' ) ) {
			$query->set( 'author', get_current_user_id() );
		}
		return $query;
	}

	public static function remove_post_views( $views ) : array {
		if ( !current_user_can( 'edit_others_posts' ) ) {
			return array();
		}
		return $views;
	}

	public static function remove_media_views( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		if ( !current_user_can( 'edit_others_posts' ) ) {
			$view = $selector->querySelector( '//option[text() = "Mine"]' );
			$view?->remove();
		}
		return $document;
	}

	public static function remove_media_views_ajax() : void {
		global $pagenow;
		if ( 'upload.php' == $pagenow && !current_user_can( 'edit_others_posts' ) ) {
			$script = <<<EOD
				const callback = ( mutationList, observer ) => {
					const container = document.getElementById( 'media-attachment-filters' );
					const filter = container?.querySelector( 'option[value = "mine"]' );
					filter?.remove();
				};
				const observer = new MutationObserver( callback );
				observer.observe( document.body, { childList: true, subtree: true } );
			EOD;
			wp_register_script( 'wp-media-view-removal', false, array(), false, true );
			wp_enqueue_script( 'wp-media-view-removal' );
			wp_add_inline_script( 'wp-media-view-removal', $script );
		}
		return;
	}

	public static function remove_media_column( array $columns ) : array {
		if ( !current_user_can( 'edit_others_posts' ) ) {
			unset( $columns['author'] );
		}
		return $columns;
	}
}