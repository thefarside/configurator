<?php
/**
 * Module Name: Attachment Pages
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/class-attachment-pages.php
 * Version: 0.0.1
 * Description: Disables attachment pages with HTTP code 404 and removes related GUI elements.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 * Requires Modules: Configurator\Helpers\Return_Types, Configurator\Helpers\HTTP_Status_Codes
 */

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;
use Configurator\Helpers\HTTP_Status_Codes;

class Attachment_Pages {

	public static function initialize() : void {
		add_filter( 'attachment_link', array( Return_Types::class, 'return_empty_string' ), PHP_INT_MAX );
		add_filter( 'redirect_canonical', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_filter( 'template_redirect', array( static::class, 'disable_endpoints' ), PHP_INT_MAX );
		add_filter( 'wp_unique_post_slug', array( static::class, 'fix_slugs' ), PHP_INT_MAX, 4 );
		return;
	}

	public static function disable_endpoints() : void {
		if ( is_attachment() ) {
			HTTP_Status_Codes::set_404();
		}
		return;
	}

	public static function fix_slugs( string $slug, int $post_id, string $post_status, string $post_type ) : string {
		if ( 'attachment' === $post_type && ! wp_is_uuid( $slug ) ) {
			return wp_generate_uuid4();
		}
		return $slug;
	}
}