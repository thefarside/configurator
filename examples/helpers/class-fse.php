<?php

namespace Configurator\Helpers;

class FSE {

	public static function initialize() : void {
		add_action( 'deprecated_file_included', array( static::class, 'multisite_header_fix' ), PHP_INT_MAX, 1 );
		add_filter( 'doing_it_wrong_trigger_error', array( static::class, 'widget_fix' ), PHP_INT_MAX, 3 );
		add_action( 'admin_init', array( static::class, 'customizer_fix' ), PHP_INT_MAX );
		add_filter( 'enqueue_block_editor_assets', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX );
		add_filter( 'enqueue_block_editor_assets', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX );
		return;
	}

	public static function multisite_header_fix( string $file ) : void {
		$pages = apply_filters( 'remove_deprecated_file_trigger_error', array() );
		if( str_ends_with( $file, 'header.php' ) && in_array( basename( $_SERVER['REQUEST_URI'] ), $pages ) ) {
			add_filter( 'deprecated_file_trigger_error', array( Return_Types::class, 'return_false' ), PHP_INT_MAX, 1 );
		}
	}

	public static function widget_fix( bool $trigger, string $function_name, string $message ) : bool {
		if ( str_contains( $message, '"wp-editor" script should not be enqueued together with the new widgets editor' ) ) {
			return false;
		}
		return $trigger;
	}

	public static function customizer_fix() : void {
		global $wp_customize;
		if ( isset( $wp_customize ) && wp_is_block_theme() ) {
			remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize->widgets, 'output_widget_control_templates' ) );
		}
		return;
	}

	public static function unregister_editor_blocks() : void {
		$blocks = apply_filters( 'unregister_editor_blocks', array() );
		if ( $blocks ) {
			$formatted_flat_blocks = "'" . implode( "',\n\t\t'", $blocks ) . "'";
			$script = <<<EOD
				const blocks = [
					{$formatted_flat_blocks}
				];
				wp.domReady( () => {
					blocks.forEach( block => {
						if ( wp.blocks.getBlockType( block ) ) {
							wp.blocks.unregisterBlockType( block );
						}
					} );
				} );
			EOD;
			wp_register_script( 'wp-block-removal', false, array(), false, true );
			wp_enqueue_script( 'wp-block-removal' );
			wp_add_inline_script( 'wp-block-removal', $script );
		}
		return;
	}

	public static function unregister_site_editor_panels() : void {
		$selectors = apply_filters( 'unregister_site_editor_panels', array() );
		if ( $selectors ) {
			$formatted_flat_selectors = "'" . implode( "',\n\t\t'", $selectors ) . "'";
			$script = <<<EOD
				const selectors = [
					{$formatted_flat_selectors}
				];
				const callback = ( mutationList, observer ) => {
					selectors.forEach( ( selector, index ) => {
						let panel = document.evaluate( selector, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null )?.singleNodeValue;
						if ( panel ) {
							panel.parentElement.classList.remove( 'is-opened' );
							panel.remove();
							if ( selector.length - 1 === index ) {
								observer.disconnect();
							}
						}
					} );
				};
				const observer = new MutationObserver( callback );
				observer.observe( document.body, { childList: true, subtree: true } );
			EOD;
			wp_register_script( 'wp-site-editor-panel-removal', false, array(), false, true );
			wp_enqueue_script( 'wp-site-editor-panel-removal' );
			wp_add_inline_script( 'wp-site-editor-panel-removal', $script );
		}
		return;
	}
}