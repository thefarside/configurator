<?php

namespace Configurator\Modules;

use Configurator\Helpers\HTTP_Status_Codes;

class Feeds {

	public static function initialize() : void {
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'do_feed_rss2', 'do_feed_rss2', 10 );
		remove_action( 'do_feed_atom', 'do_feed_atom', 10 );
		add_action( 'do_feed', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_action( 'do_feed_rdf', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_action( 'do_feed_rss', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_action( 'do_feed_rss2', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_action( 'do_feed_atom', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_action( 'widgets_init', array( static::class, 'unregister_widget' ), 10 );
		return;
	}

	public static function disable_endpoints() : void {
		HTTP_Status_Codes::set_403();
		return;
	}

	public static function unregister_widget() : void {
		unregister_widget( 'WP_Widget_RSS' );
		unregister_widget( 'WP_Widget_Meta' );
	}
}