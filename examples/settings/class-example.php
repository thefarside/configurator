<?php

namespace Configurator\Settings;

class Example {

	public static function initialize() : void {
		add_filter( 'permalink_base_author_custom', array( static::class, 'permalink_base_author_custom' ), PHP_INT_MAX );
		add_filter( 'permalink_base_category_custom', array( static::class, 'permalink_base_category_custom' ), PHP_INT_MAX );
		add_filter( 'register_post_type_params', array( static::class, 'register_post_type_params' ), PHP_INT_MAX );
		add_filter( 'blacklist_editor_blocks', array( static::class, 'blacklist_editor_blocks' ), PHP_INT_MAX );
		add_filter( 'blacklist_editor_panels', array( static::class, 'blacklist_editor_panels' ), PHP_INT_MAX );
		add_filter( 'blacklist_editor_patterns', array( static::class, 'blacklist_editor_patterns' ), PHP_INT_MAX );
		add_filter( 'admin_bar_node_whitelist', array( static::class, 'admin_bar_node_whitelist' ), PHP_INT_MAX );
		add_filter( 'admin_bar_node_additions', array( static::class, 'admin_bar_node_additions' ), PHP_INT_MAX );
		add_filter( 'admin_menu_pages_blacklist', array( static::class, 'admin_menu_pages_blacklist' ), PHP_INT_MAX );
		add_filter( 'log_filters', array( static::class, 'log_filters' ), PHP_INT_MAX );
		add_filter( 'log_queries', array( static::class, 'log_queries' ), PHP_INT_MAX );
		add_filter( 'append_head', array( static::class, 'append_head' ), PHP_INT_MAX );
		add_filter( 'append_head-users.php', array( static::class, 'append_head_users' ), PHP_INT_MAX );
		add_filter( 'header_blacklist', array( static::class, 'header_blacklist' ), PHP_INT_MAX );
		add_filter( 'add_headers', array( static::class, 'add_headers' ), PHP_INT_MAX );
		add_filter( 'add_headers-users.php', array( static::class, 'add_headers_users' ), PHP_INT_MAX );
		add_filter( 'cookie_blacklist', array( static::class, 'cookie_blacklist' ), PHP_INT_MAX );
		add_filter( 'add_cookies-users.php', array( static::class, 'add_cookies_users' ), PHP_INT_MAX );
		add_filter( 'set_wp_mail_from', array( static::class, 'set_wp_mail_from' ), PHP_INT_MAX );
		add_filter( 'log_mail', array( static::class, 'log_mail' ), PHP_INT_MAX );
		add_filter( 'set_persistent_user_meta', array( static::class, 'set_persistent_user_meta' ), PHP_INT_MAX );
		add_filter( 'rest_endpoint_whitelist', array( static::class, 'rest_endpoint_whitelist' ), PHP_INT_MAX );
		return;
	}

	public static function permalink_base_author_custom() : string {
		return '';
	}

	public static function permalink_base_category_custom() : string {
		return '';
	}

	public static function register_post_type_params() : array {
		return array(
			'labels' => array(
				'name'          => 'Custom Posts',
				'singular_name' => 'Custom Post',
				'menu_name'     => 'Custom Posts',
				'add_new'       => 'Add New Custom Posts',
				'add_new_item'  => 'Add New Custom Posts',
				'new_item'      => 'New Custom Post',
				'edit_item'     => 'Edit Custom Post',
				'view_item'     => 'View Custom Post',
				'all_items'     => 'All Custom Posts',
				'search_items'  => 'Search Custom Posts',
			),
			'public' => true,
			'has_archive' => true,
			'show_in_rest' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
			'menu_position' => 5,
		);
	}

	public static function blacklist_editor_blocks() : array {
		return array(
			'core/freeform',
			'core/verse',
			'core/search',
			'core/rss',
			'core/embed',
		);
	}

	public static function blacklist_editor_panels() : array {
		return array(
			'//button[@id = "tabs-1-accessibility"]',
		);
	}

	public static function blacklist_editor_patterns() : array {
		return array(
			'core/query-standard-posts',
			'core/query-medium-posts',
			'core/query-small-posts',
			'core/query-grid-posts',
			'core/query-large-title-posts',
			'core/query-offset-posts',
			'core/social-links-shared-background-color',
		);
	}

	public static function admin_bar_node_whitelist() : array {
		return array(
			'top-secondary',
		);
	}

	public static function admin_bar_node_additions() : array {
		return array(
			array(
				'role' => 'super',
				'interface' => 'super',
				'content' => array(
					'id'     => 'network',
					'title'  => 'Network',
					'href'   => network_admin_url( 'sites.php' ),
				),
			),
			array(
				'role' => 'super',
				'interface' => 'admin',
				'content' => array(
					'id'     => 'network',
					'title'  => 'Network',
					'href'   => network_admin_url( 'sites.php' ),
				),
			),
			array(
				'role' => 'all',
				'interface' => 'admin',
				'content' => array(
				'id'    => 'site',
				'title' => get_bloginfo( 'name' ),
				'href'  => home_url( '/' ),
				),
			),
			array(
				'role' => 'all',
				'interface' => 'user',
				'content' => array(
				'id'    => 'site',
				'title' => get_bloginfo( 'name' ),
				'href'  => admin_url(),
				),
			),
			array(
				'role' => 'all',
				'interface' => 'all',
				'content' => array(
					'parent' => 'top-secondary',
					'id'     => 'logout',
					'title'  => 'Log Out',
					'href'   => wp_logout_url(),
				),
			),
		);
	}

	public static function admin_menu_pages_blacklist() : array {
		return array(
			array( 'tools.php', 'tools.php' ),
			array( 'tools.php', 'import.php' ),
		);
	}

	public static function log_filters() : array {
		return array(
			'file' => 'hook.log',
			'file_flags' => FILE_APPEND,
			'json_flags' => JSON_PRETTY_PRINT,
		);
	}

	public static function log_queries() : array {
		return array(
			'file' => 'sql.log',
			'file_flags' => FILE_APPEND,
			'json_flags' => JSON_PRETTY_PRINT,
		);
	}

	public static function append_head() : array {
		return array(
			'<meta name="example1" content="All pages">',
		);
	}

	public static function append_head_users() : array {
		return array(
			'<meta name="example2" content="/wp-admin/users.php">',
		);
	}

	public static function header_blacklist() : array {
		return array(
			'X-Powered-By',
		);
	}

	public static function add_headers() : array {
		return array(
			'Example: All pages',
		);
	}

	public static function add_headers_users() : array {
		return array(
			'Example2: Shows on the /wp-admin/users.php page',
		);
	}

	public static function cookie_blacklist() : array {
		return array(
			'wordpress_test_cookie',
		);
	}

	public static function add_cookies_users() : array {
		return array(
			(object) array(
				'name' => 'Example',
				'value' => 'Added on the /wp-admin/users.php page',
				'attributes' => array(
					'expires' => 0,
					'path' => '/',
					'domain' => '.example.com',
					'secure' => true,
					'httponly' => true,
				),
			),
		);
	}

	public static function set_wp_mail_from() : string {
		return 'test@localhost.com';
	}

	public static function log_mail() : array {
		return array(
			'file' => 'mail.log',
			'file_flags' => FILE_APPEND,
			'json_flags' => JSON_PRETTY_PRINT,
		);
	}

	public static function set_persistent_user_meta() : array {
		return array(
			'admin_color' => 'midnight',
			'wp_media_library_mode' => 'list',
		);
	}

	public static function rest_endpoint_whitelist() : array {
		return array(
			'wp-json/wc/store',
			'wp-json/wc/store/v1/batch',
			'wp-json/wc/store/v1/cart',
			'wp-json/wc/store/v1/cart/add-item',
			'wp-json/wc/store/v1/cart/apply-coupon',
			'wp-json/wc/store/v1/cart/coupons',
			'wp-json/wc/store/v1/cart/extensions',
			'wp-json/wc/store/v1/cart/items',
			'wp-json/wc/store/v1/cart/remove-coupon',
			'wp-json/wc/store/v1/cart/remove-item',
			'wp-json/wc/store/v1/cart/select-shipping-rate',
			'wp-json/wc/store/v1/cart/update-item',
			'wp-json/wc/store/v1/cart/update-customer',
			'wp-json/wc/store/v1/checkout',
			'wp-json/wc/store/v1/products',
			'wp-json/wc/store/v1/products/attributes',
			'wp-json/wc/store/v1/products/categories',
			'wp-json/wc/store/v1/products/collection-data',
			'wp-json/wc/store/v1/products/reviews',
			'wp-json/wc/store/v1/products/tags',
		);
	}
}
