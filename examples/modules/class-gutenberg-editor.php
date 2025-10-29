<?php

namespace Configurator\Modules;

use Configurator\Helpers\Return_Types;

class Gutenberg_Editor {

	public static function initialize() : void {
		add_filter( 'use_block_editor_for_post_type', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_filter( 'use_widgets_block_editor', array( Return_Types::class, 'return_false' ), PHP_INT_MAX );
		add_action( 'wp_enqueue_scripts', array( static::class, 'dequeue_head_styles' ), PHP_INT_MAX );
		add_action( 'wp_footer', array( static::class, 'dequeue_footer_styles' ), PHP_INT_MAX );
		return;
	}

	public static function dequeue_head_styles() : void {
		wp_dequeue_style( 'global-styles' );
		wp_deregister_style( 'global-styles' );
		wp_dequeue_style( 'wp-block-library' );
		wp_deregister_style( 'wp-block-library' );
		wp_dequeue_style( 'classic-theme-styles' );
		wp_deregister_style( 'classic-theme-styles' );
		return;
	}

	public static function dequeue_footer_styles() : void {
		wp_dequeue_style( 'core-block-supports' );
		wp_deregister_style( 'core-block-supports' );
		wp_dequeue_style( 'core-block-supports-duotone' );
		wp_deregister_style( 'core-block-supports-duotone' );
		return;
	}
}