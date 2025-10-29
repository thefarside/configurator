<?php

namespace Configurator\Modules;

class Debug {

	public static array $backtrace = array();
	public static array $filters = array();
	public static array $actions = array();
	public static array $queries = array();
	public static array $options = array();

	public static function initialize() : void {
		add_action( 'setup_theme', array( static::class, 'configure' ), PHP_INT_MAX );
		return;
	}

	public static function configure() : void {
		$hooks = apply_filters( 'log_filters', array() );
		if ( $hooks ) {
			static::$options['hook'] = $hooks;
			add_action( 'all', array( static::class, 'log_backtrace' ), PHP_INT_MAX );
			add_action( 'shutdown', array( static::class, 'parse_filters' ), PHP_INT_MAX );
			add_action( 'shutdown', array( static::class, 'collect_actions' ), PHP_INT_MAX );
			add_action( 'shutdown', array( static::class, 'print_hooks' ), PHP_INT_MAX );
		}
		$queries = apply_filters( 'log_queries', array() );
		if ( $queries ) {
			static::$options['query'] = $queries;
			define( 'SAVEQUERIES', true );
			add_action( 'shutdown', array( static::class, 'parse_queries' ), PHP_INT_MAX );
			add_action( 'shutdown', array( static::class, 'print_queries' ), PHP_INT_MAX );
		}
		return;
	}

	public static function log_backtrace() : void {
		$backtrace = debug_backtrace( 1 );
		$location = "{$backtrace[3]['file']}:{$backtrace[3]['line']}";
		$caller = $backtrace[3]['function'];
		if ( 'do_action' === $caller || 'do_action_ref_array' === $caller ) {
			$callee = $backtrace[3]['args'][0];
			$arguments = $backtrace[3]['args'];
			$flattened_arguments = json_encode( $arguments, JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE, 8 );
			$parameters = str_replace( array( '[', ']' ), '', $flattened_arguments );
			static::$backtrace[ $callee ][ $location ][] = "{$caller}({$parameters})";
		}
		return;
	}

	public static function parse_filters() : void {
		global $wp_filter;
		foreach ( $wp_filter as $hook => $properties ) {
			foreach ( $properties->callbacks as $priority => $callables ) {
				static::$filters[ $hook ][ $priority ] = array_keys( $callables );
			}
		}
		return;
	}

	public static function collect_actions() : void {
		global $wp_actions;
		static::$actions = $wp_actions;
		return;
	}

	public static function print_hooks() : void {
		$backtraced_actions = array_intersect_key( static::$backtrace, static::$actions );
		$filtered_actions = array_intersect_key( static::$filters, static::$actions );
		$hooks = array_replace_recursive( static::$actions, $backtraced_actions, $filtered_actions );
		$hook_output = json_encode( array( home_url( $_SERVER['REQUEST_URI'] ) => $hooks ), static::$options['hook']['json_flags'] );
		file_put_contents(
			trailingslashit( WP_CONTENT_DIR ) . sanitize_file_name( static::$options['hook']['file'] ),
			$hook_output . PHP_EOL,
			static::$options['hook']['file_flags']
		);
		return;
	}

	public static function parse_queries() : void {
		global $wpdb;
		if ( $wpdb->queries ) {
			foreach ( $wpdb->queries as $log ) {
				$backtrace = explode( ', ', $log[2] );
				$caller = end( $backtrace );
				$query = preg_replace( '/\s+/S', ' ', $log[0] );
				static::$queries[ $caller ] = $query;
			}
		}
	}

	public static function print_queries() : void {
		$sql_output = json_encode( array( home_url( $_SERVER['REQUEST_URI'] ) => static::$queries ), static::$options['query']['json_flags'] );
		file_put_contents(
			trailingslashit( WP_CONTENT_DIR ) . sanitize_file_name( static::$options['query']['file'] ),
			$sql_output . PHP_EOL,
			static::$options['query']['file_flags']
		);
		return;
	}
}