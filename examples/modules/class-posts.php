<?php

namespace Configurator\Modules;

use WP_Customize_Manager;
use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Posts {

	public static function initialize() : void {
		add_action( 'wp_before_admin_bar_render', array(  static::class, 'remove_admin_bar_node' ), PHP_INT_MAX );
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		add_filter( 'set_302-edit.php', array( static::class, 'change_edit_post_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-post-new.php', array( static::class, 'change_new_post_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-edit-tags.php', array( static::class, 'change_post_categories_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-edit-tags.php', array( static::class, 'change_post_tags_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-options-writing.php', array( static::class, 'change_writing_options_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'rest_endpoints', array( static::class, 'remove_rest_endpoints' ), PHP_INT_MAX, 1 );
		add_filter( 'xmlrpc_methods', array( static::class, 'remove_xmlrpc_methods' ), PHP_INT_MAX, 1 );
		add_filter( 'parse_html-export.php', array( static::class, 'remove_export_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-options-reading.php', array( static::class, 'remove_reading_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-options-permalink.php', array( static::class, 'remove_permalink_settings' ), PHP_INT_MAX, 2 );
		add_filter( 'available_permalink_structure_tags', array( static::class, 'remove_posts_tag' ), PHP_INT_MAX, 1 );
		add_filter( 'manage_users_columns', array( static::class, 'remove_user_column' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'remove_post_metaboxes' ), PHP_INT_MAX );
		add_action( 'admin_head', array( static::class, 'remove_menu_metaboxes' ), PHP_INT_MAX );
		add_action( 'widgets_init', array( static::class, 'remove_widgets' ), PHP_INT_MIN );
		add_action( 'customize_register', array( static::class, 'customizer_removal' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'delete_content' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_bar_node() : void {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'new-post' );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'post-new.php' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		remove_submenu_page( 'options-general.php', 'options-writing.php' );
		return;
	}

	public static function change_edit_post_endpoint( string $url ) : string {
		if ( isset( $_GET['post_type'] ) && 'post' === $_GET['post_type'] ) {
			return 'edit.php?post_type=page';
		}
		return $url;
	}

	public static function change_new_post_endpoint( string $url ) : string {
		if ( isset( $_GET['post_type'] ) && 'post' === $_GET['post_type'] ) {
			return 'post-new.php?post_type=page';
		}
		return $url;
	}

	public static function change_post_categories_endpoint( string $url ) : string {
		if ( isset( $_GET['taxonomy'] ) && 'category' === $_GET['taxonomy'] ) {
			return admin_url();
		}
		return $url;
	}

	public static function change_post_tags_endpoint( string $url ) : string {
		if ( isset( $_GET['taxonomy'] ) && 'post_tag' === $_GET['taxonomy'] ) {
			return admin_url();
		}
		return $url;
	}

	public static function change_writing_options_endpoint( string $url ) : string {
		if ( ! $url ) {
			return admin_url();
		}
		return $url;
	}

	public static function remove_rest_endpoints( array $endpoints ) : array {
		foreach ( $endpoints as $path => $endpoint ) {
			if (
				 preg_match( '~^/wp/v[0-9]+/posts~i', $path ) ||
				 preg_match( '~^/wp/v[0-9]+/categories~i', $path ) ||
				 preg_match( '~^/wp/v[0-9]+/tags~i', $path )
			) {
				unset( $endpoints[ $path ] );
			}
		}
		return $endpoints;
	}

	public static function remove_xmlrpc_methods( array $methods ) : array {
		$blacklist = array(
			'wp.getPost',
			'wp.getPosts',
			'wp.newPost',
			'wp.editPost',
			'wp.deletePost',
			'wp.getPostType',
			'wp.getPostTypes',
			'wp.getPostFormats',
			'wp.getPostStatusList',
			'wp.getRevisions',
			'wp.restoreRevision',
			'wp.getCategories',
			'wp.suggestCategories',
			'wp.newCategory',
			'wp.deleteCategory',
			'wp.getTags',
		);
		return array_diff_key( $methods, array_flip( $blacklist ) );
    }

	public static function remove_export_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$setting = $selector->querySelector( '//p[.//input[@value = "posts"]]' );
		$setting?->remove();
		foreach ( $selector->query( '//p[text()[contains( ., " posts," )]]' ) as $phrase ) {
			$phrase->nodeValue = str_ireplace( ' posts,', '', $phrase->nodeValue );
		}
		return $document;
	}

	public static function remove_reading_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//p[.//input[@value = "posts"]] |
			//li[.//select[@id = "page_for_posts"]] |
			//tr[.//input[@id = "posts_per_page"]] |
			//tr[.//input[@id = "posts_per_rss"]] |
			//tr[.//input[@name = "rss_use_excerpt"]]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		return $document;
	}

	public static function remove_permalink_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->query( '
			//tr[.//input[@id = "category_base"]] |
			//tr[.//input[@id = "tag_base"]]
		' );
		foreach ( $settings as $setting ) {
			$setting->remove();
		}
		$other_settings = count( $selector->query( '//h2[text() = "Optional"]/following-sibling::table[1]/tr' ) );
		if ( ! $other_settings ) {
			$remaining_settings = $selector->query( '
				//h2[text() = "Optional"] |
				//h2[text() = "Optional"]/following-sibling::p[1] |
				//h2[text() = "Optional"]/following-sibling::table[1]
			' );
			foreach ( $remaining_settings as $setting ) {
				$setting->remove();
			}
		}
		return $document;
	}

	public static function remove_posts_tag( array $available_tags ) : array {
		unset( $available_tags['category'] );
		return $available_tags;
	}

	public static function remove_user_column( array $columns ) : array {
		unset( $columns['posts'] );
		return $columns;
	}

	public static function remove_post_metaboxes() : void {
		remove_post_type_support( 'page', 'thumbnail' );
		return;
	}

	public static function remove_menu_metaboxes() : void {
		remove_meta_box( 'add-post-type-post', 'nav-menus', 'side' );
		remove_meta_box( 'add-category', 'nav-menus', 'side' );
		remove_meta_box( 'add-post_tag', 'nav-menus', 'side' );
		return;
	}

	public static function remove_widgets() : void {
		unregister_widget( 'WP_Widget_Archives' );
		unregister_widget( 'WP_Widget_Calendar' );
		unregister_widget( 'WP_Widget_Categories' );
		unregister_widget( 'WP_Widget_Recent_Posts' );
		unregister_widget( 'WP_Widget_Tag_Cloud' );
		return;
	}

	public static function customizer_removal( WP_Customize_Manager $manager ) : void {
		$manager->remove_section( 'static_front_page' );
		return;
	}

	public static function delete_content() : void {
		$posts = get_posts( array( 
			'post_status' => get_post_stati(),
			'post_type' => 'post',
		 ) );
		foreach ( $posts as $post ) {
			wp_delete_post( $post->ID, true );
		}
		$taxonomies = ['post_tag', 'category'];
		foreach ( $taxonomies as $taxonomy ) {
			register_taxonomy( $taxonomy, array() );
			$terms = get_terms( array( 
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			 ) );
			foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, $term->taxonomy ); 
			}
		}
		return;
	}
}
