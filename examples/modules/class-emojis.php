<?php

namespace Configurator\Modules;

class Emojis {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'remove_scripts' ), PHP_INT_MAX );
		add_action( 'admin_init', array( static::class, 'remove_scripts' ), PHP_INT_MAX );
		add_filter( 'tiny_mce_plugins', array( static::class, 'remove_editor_plugin' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function remove_scripts() : void {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		return;
	}

	public static function remove_editor_plugin( array $plugins ) : array {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}
}