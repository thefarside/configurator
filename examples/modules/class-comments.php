<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Comments {

	public static function initialize() : void {
		add_action( 'admin_init', array( static::class, 'prevent_new_comments' ), PHP_INT_MAX );
		add_filter( 'pings_open', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'comments_open', array( static::class, 'close_existing_comments' ), PHP_INT_MAX, 2 );
		add_action( 'wp_before_admin_bar_render', array( static::class, 'remove_admin_bar_node' ), PHP_INT_MAX );
		add_action( 'admin_menu', array( static::class, 'remove_admin_menu_pages' ), PHP_INT_MAX );
		add_filter( 'set_302-edit-comments.php', array( static::class, 'change_edit_comments_endpoint' ), PHP_INT_MAX, 1 );
		add_filter( 'set_302-options-discussion.php', array( static::class, 'change_discussion_options_endpoint' ), PHP_INT_MAX, 1 );
		add_action( 'do_feed_rss', array( static::class, 'disable_feeds' ), PHP_INT_MIN, 1 );
		add_action( 'do_feed_rss2', array( static::class, 'disable_feeds' ), PHP_INT_MIN, 1 );
		add_action( 'do_feed_atom', array( static::class, 'disable_feeds' ), PHP_INT_MIN, 1 );
		add_filter( 'feed_links_show_comments_feed', array( Return_Types::class, 'return_false' ) );
		add_filter( 'rest_endpoints', array( static::class, 'remove_rest_endpoints' ), PHP_INT_MAX, 1 );
		add_filter( 'xmlrpc_methods', array( static::class, 'remove_xmlrpc_methods' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'remove_metaboxes' ), PHP_INT_MAX );
		add_action( 'widgets_init', array( static::class, 'remove_widgets' ), PHP_INT_MIN );
		add_action( 'admin_init', array( static::class, 'delete_content' ), PHP_INT_MAX );
		return;
	}

	public static function prevent_new_comments() : void {
		update_option( 'default_pingback_flag', 0 );
		update_option( 'default_ping_status', 'closed' );
		update_option( 'default_comment_status', 'closed' );
		return;
	}

	public static function close_existing_comments( bool $comments_open, int $post_id ) : bool {
		$post_types = get_post_types( array(
			'public' => true,
			'_builtin' => true,
		) );
		$post_type = get_post_type( $post_id );
		if ( in_array( $post_type, $post_types ) ) {
			return false;
		}
		return true;
	}

	public static function remove_admin_bar_node() : void {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'comments' );
		return;
	}

	public static function remove_admin_menu_pages() : void {
		remove_menu_page( 'edit-comments.php' );
		remove_submenu_page( 'options-general.php', 'options-discussion.php' );
		return;
	}

	public static function change_edit_comments_endpoint( string $url ) : string {
		if ( ! isset( $_GET['p'] ) ) {
			return admin_url();
		}
		return $url;
	}

	public static function change_discussion_options_endpoint( string $url ) : string {
		if ( ! $url ) {
			return admin_url();
		}
		return $url;
	}

	public static function disable_feeds( bool $for_comments ) : void {
		if( $for_comments ) {
			remove_action( 'do_feed_rss', 'do_feed_rss', 10, 1 );
			remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
			remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );
		}
		return;
	}

	public static function remove_rest_endpoints( array $endpoints ) : array {
		foreach ( $endpoints as $path => $endpoint ) {
			if ( preg_match( '~^/wp/v[0-9]+/comment~i', $path ) ) {
				unset( $endpoints[ $path ] );
			}
		}
		return $endpoints;
	}

	public static function remove_xmlrpc_methods( array $methods ) : array {
		$blacklist = array(
			'wp.getCommentCount',
			'wp.getComment',
			'wp.getComments',
			'wp.deleteComment',
			'wp.editComment',
			'wp.newComment',
			'wp.getCommentStatusList',
			'pingback.ping',
			'pingback.extensions.getPingbacks',
		);
		return array_diff_key( $methods, array_flip( $blacklist ) );
    }

	public static function remove_metaboxes() : void {
		foreach ( get_post_types() as $post_type ) {
			if ( post_type_supports( $post_type, 'comments' ) ) {
				remove_post_type_support( $post_type, 'comments' );
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}
		remove_meta_box( 'commentstatusdiv', 'wp_block', 'normal' );
		return;
	}

	public static function remove_widgets() : void {
		unregister_widget( 'WP_Widget_Recent_Comments' );
		return;
	}

	public static function delete_content() : void {
		$comments = get_comments( array( 
			'type' => 'comment',
			'status' => 'any',
		 ) );
		foreach ( $comments as $comment ) {
			wp_delete_comment( $comment->comment_ID, true );
		}
		return;
	}
}