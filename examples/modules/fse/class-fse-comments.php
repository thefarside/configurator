<?php
/**
 * Module Name: FSE Comments
 * Module URI: https://github.com/thefarside/configurator/tree/main/examples/modules/fse/class-fse-comments.php
 * Version: 0.0.1
 * Description: Removes the comment blocks and option panels from Gutenberg editors.
 * Requires at least: 7.0
 * Requires PHP: 8.5.1
 */

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
			'core/comments-pagination',
			'core/comments-pagination-next',
			'core/comments-pagination-numbers',
			'core/comments-pagination-previous',
			'core/comments-title',
			'core/latest-comments',
			'core/comment-author-name',
			'core/comment-content',
			'core/comment-date',
			'core/comment-edit-link',
			'core/comment-reply-link',
			'core/comment-template',
			'core/post-comments-count',
			'core/post-comments-form',
			'core/post-comments-link',
			'core/post-comments',
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