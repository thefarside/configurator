<?php

namespace Configurator\Modules;

class Customizer {

	public static function initialize() : void {
		add_action( 'wp_before_admin_bar_render', array(  static::class, 'remove_admin_bar_node' ), PHP_INT_MAX );
		add_filter( 'map_meta_cap', array( static::class, 'remove_capability' ), PHP_INT_MAX, 2 );
		add_filter( 'set_302-customize.php', array( static::class, 'disable_endpoint' ), PHP_INT_MAX, 1 );
		add_action( 'load-themes.php', array( static::class, 'fix_gui' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_bar_node() : void {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'customize' );
		return;
	}

	public static function fix_gui() : void {
		$script = <<<EOD
			const callback = ( mutationList, observer ) => {
				const container = document.querySelectorAll( '.theme.active .theme-actions, .theme-overlay.active .theme-actions' )[0];
				const button = document.getElementsByClassName( 'load-customize' )[0];
				container?.remove();
				button?.remove();
			};
			const observer = new MutationObserver( callback );
			observer.observe( document.body, { childList: true, subtree: true } );
		EOD;
		wp_register_script( 'wp-customizer-removal', false, array(), false, true );
		wp_enqueue_script( 'wp-customizer-removal' );
		wp_add_inline_script( 'wp-customizer-removal', $script );
		return;
	}

	public static function remove_capability( array $caps, string $cap ) : array {
		if ( 'customize' === $cap ) {
			return array('');
		}
		return $caps;
	}

	public static function disable_endpoint( string $url ) : string {
		if ( ! $url ) {
			return admin_url( 'themes.php' );
		}
		return $url;
	}
}