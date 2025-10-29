<?php

namespace Configurator\Modules;

use DOMDocument;
use Configurator\Helpers\DOMXPath;
use Configurator\Helpers\Return_Types;

class Profile_Name_Display_Name {

	public static function initialize() : void {
		add_filter( 'pre_user_display_name', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		add_filter( 'parse_html-profile.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		add_filter( 'parse_html-user-edit.php', array( static::class, 'remove_profile_field' ), PHP_INT_MAX, 2 );
		add_filter( 'manage_upload_columns', array( static::class, 'remove_media_column' ), PHP_INT_MAX, 1 );
		add_filter( 'available_permalink_structure_tags', array( static::class, 'remove_permalinks_tag' ), PHP_INT_MAX, 1 );
		add_action( 'admin_init', array( static::class, 'remove_posts_metabox' ), PHP_INT_MAX );
		return;
	}

	public static function remove_profile_field( DOMDocument $document, DOMXPath $selector ) : DOMDocument {
		$settings = $selector->querySelector( '//tr[@class = "user-display-name-wrap"]' );
		$settings?->remove();
		return $document;
	}

	public static function remove_media_column( array $columns ) : array {
		unset( $columns['author'] );
		return $columns;
	}

	public static function remove_permalinks_tag( array $available_tags ) : array {
		unset( $available_tags['author'] );
		return $available_tags;
	}

	public static function remove_posts_metabox() : void {
		remove_post_type_support( 'post','author' );
		remove_post_type_support( 'page','author' );
		return;
	}
}