<?php

namespace Configurator\Modules;

class Permalink_Base_Author_Custom {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'rewrite_link' ), PHP_INT_MAX );
		add_filter( 'author_rewrite_rules', array( static::class, 'rewrite_rules' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function rewrite_link() : void {
		global $wp_rewrite;
		$url_base = apply_filters( 'permalink_base_author_custom', 'author' );
		$wp_rewrite->author_base = $url_base;
		return;
	}

	public static function rewrite_rules( array $rules ) : array {
		global $wpdb;
		$rules = array();
		$filter_base = apply_filters( 'permalink_base_author_custom', '' );
		$url_base = $filter_base ? "{$filter_base}/" : $filter_base;
		$authors = $wpdb->get_results( "SELECT user_nicename AS nicename from $wpdb->users" );
		foreach( $authors as $author ) {
			$author_nicename = $url_base . $author->nicename;
			$rules["({$author_nicename})/page/?([0-9]+)/?$"] = 'index.php?author_name=$matches[1]&paged=$matches[2]';
			$rules["({$author_nicename})/?$"] = 'index.php?author_name=$matches[1]';
		}
		return $rules;
	}
}