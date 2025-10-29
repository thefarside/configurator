<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;

class Robots_Meta {

	public static function initialize() : void {
		remove_filter( 'wp_robots', 'wp_robots_noindex' );
		remove_filter( 'wp_robots', 'wp_robots_noindex_embeds' );
		remove_filter( 'wp_robots', 'wp_robots_noindex_search' );
		remove_filter( 'wp_robots', 'wp_robots_max_image_preview_large' );
		add_action( 'login_head', array( static::class, 'reprioritize_login_head' ), PHP_INT_MIN );
		add_action( 'admin_init', array( static::class, 'set_public_blog' ), PHP_INT_MAX );
		add_filter( 'parse_html-options-reading.php', array( static::class, 'remove_settings' ), PHP_INT_MAX, 2 );
		return;
	}

	public static function reprioritize_login_head() : void {
		remove_filter( 'wp_robots', 'wp_robots_sensitive_page' );
		return;
	}

	public static function set_public_blog() : void {
		update_option( 'blog_public', 1 );
		return;
	}

	public static function remove_settings( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[@class = "option-site-visibility"]' );
		$settings?->remove();
		return $document;
	}
}