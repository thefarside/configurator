<?php

namespace Configurator\Modules;

class Permalink_Base_Category_Custom {

	public static function initialize() : void {
		add_action( 'init', array( static::class, 'rewrite_link' ), PHP_INT_MAX );
		add_filter( 'category_rewrite_rules', array( static::class, 'rewrite_rules' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function rewrite_link() : void {
		global $wp_rewrite;
		$filter_base = apply_filters( 'permalink_base_category_custom', '' );
		$url_base = $filter_base ? "/{$filter_base}/" : $filter_base;
		$wp_rewrite->extra_permastructs['category']['struct'] = "{$url_base}%category%";
		return;
	}

	public static function rewrite_rules( array $rules ) : array {
		global $wp_rewrite;
		$rules = array();
		$filter_base = apply_filters( 'permalink_base_category_custom', '' );
		$url_base = $filter_base ? "{$filter_base}/" : $filter_base;
		$categories = get_categories( array( 'hide_empty' => false ) );
		foreach( $categories as $category ) {
			if ( $category->parent ) {
				$category_nicename = $url_base . get_category_parents( $category->parent, false, '/', true ) . $category->slug;
			} else {
				$category_nicename = "{$url_base}{$category->slug}";
			}
			$rules['('.$category_nicename.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
			$rules["({$category_nicename})/{$wp_rewrite->pagination_base}/?([0-9]{1,})/?$"] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
			$rules['('.$category_nicename.')/?$'] = 'index.php?category_name=$matches[1]';
		}
		return $rules;
	}
}