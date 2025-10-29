<?php

namespace Configurator\Modules\FSE;

class FSE_Comments {

	public static function initialize() : void {
		add_filter( 'unregister_editor_blocks', array( static::class, 'unregister_editor_blocks' ), PHP_INT_MAX, 1 );
		add_filter( 'unregister_site_editor_panels', array( static::class, 'unregister_site_editor_panels' ), PHP_INT_MAX, 1 );
		return;
	}

	public static function unregister_editor_blocks( array $blocks ) : array {
		return array_merge( $blocks, array(
			'core/comments',
			'core/comments-title',
			'core/comments-pagination',
			'core/comments-pagination-next',
			'core/comments-pagination-previous',
			'core/comments-pagination-numbers',
			'core/comment-template',
			'core/comment-author-name',
			'core/comment-date',
			'core/comment-content',
			'core/comment-edit-link',
			'core/comment-reply-link',
			'core/post-comments-form',
			'core/latest-comments',
		) );
	}

	public static function unregister_site_editor_panels( array $panels ) : array {
		return array_merge( $panels, array(
			'//h2[contains( text(), "Discussion" )]/ancestor::div[contains( @class, "edit-site-sidebar-navigation-details-screen-panel" )]',
			'//button[contains( text(), "Discussion" )]/ancestor::h2[contains( @class, "components-panel__body-title" )]',
			'//label[contains( text(), "Allow comments" )]/ancestor::div[contains( @class, "components-panel__row" )]',
			'//label[contains( text(), "Discussion" )]/ancestor::div[contains( @class, "components-base-control" )]',
		) );
	}
}