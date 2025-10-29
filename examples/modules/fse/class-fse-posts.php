<?php

namespace Configurator\Modules\FSE;

use Configurator\Helpers\FSE;

class FSE_Posts {

	public static function initialize() : void {
		add_action( 'admin_init', array( FSE::class, 'customizer_fix' ), PHP_INT_MAX );
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'core/query',
			'core/query-no-results',
			'core/query-title',
			'core/query-pagination',
			'core/query-pagination-next',
			'core/query-pagination-previous',
			'core/query-pagination-numbers',
			'core/more',
			'core/read-more',
			'core/latest-posts',
			'core/post-title',
			'core/post-excerpt',
			'core/post-featured-image',
			'core/post-content',
			'core/post-date',
			'core/post-terms',
			'core/post-navigation-link',
			'core/post-template',
			'core/term-description',
			'core/categories',
			'core/tag-cloud',
			'core/archives',
			'core/calendar',
		) );
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		return array_merge( $panels, array(
			'//label[contains( text(), "Posts per page" )]/ancestor::div[contains( @class, "edit-site-sidebar-navigation-details-screen-panel" )]',
			'//button[contains( text(), "Content" )]/ancestor::h2[contains( @class, "components-panel__body-title" )]',
			'//button[contains( text(), "Featured image" )]/ancestor::h2[contains( @class, "components-panel__body-title" )]',
			'//label[contains( text(), "Featured image" )]/ancestor::div[contains( @class, "components-base-control" )]',
			'//span[contains( text(), "Featured Image" )]/ancestor::div[contains( @role, "menuitemcheckbox" )]',
		) );
	}
}