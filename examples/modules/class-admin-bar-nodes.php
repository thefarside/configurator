<?php

namespace Configurator\Modules;

class Admin_Bar_Nodes {

	public static function initialize() : void {
		add_action( 'wp_before_admin_bar_render', array( static::class, 'remove_admin_bar_nodes' ), PHP_INT_MAX );
		add_action( 'wp_before_admin_bar_render', array( static::class, 'add_admin_bar_nodes' ), PHP_INT_MAX );
		return;
	}

	public static function remove_admin_bar_nodes() : void {
		global $wp_admin_bar;
		$whitelist = apply_filters( 'admin_bar_node_whitelist', array() );
		foreach ( $wp_admin_bar->get_nodes() as $node ) {
			if ( in_array( $node->id, $whitelist ) ) {
				continue;
			}
			$wp_admin_bar->remove_menu( $node->id );
		}
		return;
	}

	public static function add_admin_bar_nodes() : void {
		$user = wp_get_current_user();
		$roles = $user->roles;
		if ( is_super_admin() ) {
			array_push( $roles, 'super' );
		}
		if ( is_network_admin() ) {
			$interface = 'super';
		} elseif ( is_admin() ) {
			$interface = 'admin';
		} else {
			$interface = 'user';
		}
		global $wp_admin_bar;
		foreach ( apply_filters( 'admin_bar_node_additions', array() ) as $addition ) {
			if ( ( 'all' === $addition['role'] || in_array( $addition['role'], $roles ) )
				&& ( 'all' === $addition['interface'] || $interface === $addition['interface'] ) ) {
					$wp_admin_bar->add_node( $addition['content'] );
			}
		}
		return;
	}
}