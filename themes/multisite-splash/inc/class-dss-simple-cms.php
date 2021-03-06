<?php

/**
 * Simple CMS Setup
 * Adapted from the Simple CMS Plugin
 * 
 * @copyright Copyright (c), Ryan Hellyer
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 * @since 1.8
 */
class DSS_Simple_CMS {

	/**
	 * Class constructor
	 * Adds all the methods to appropriate hooks
	 * 
	 * @since 1.8
	 * @updated 1.8
	 * @author Ryan Hellyer <ryanhellyer@gmail.com>
	 */
	public function __construct() {

		// Add action hooks
		add_action( 'admin_menu',                 array( $this, 'remove_menus' ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'remove_admin_bar_links' ) );
		add_action( 'admin_menu',                 array( $this, 'remove_meta_boxes' ) );
		add_action( 'wp_head',                    array( $this, 'simplecms_comments' ) );

	}

	/**
	 * Remove admin bar menus
	 *
	 * @author Ryan Hellyer <ryanhellyer@gmail.com>
	 * @since 1.8
	 * @updated 1.8
	 * @global array $wp_admin_bar
	 */
	function remove_admin_bar_links() {
	
		// Bail out now if not in admin or user can't activate plugins
		if ( current_user_can( 'manage_options' ) || ! is_admin() )
			return;
	
		global $wp_admin_bar;
	
		$wp_admin_bar->remove_menu( 'comments' );
		$wp_admin_bar->remove_menu( 'new-content' );
		$wp_admin_bar->remove_menu( 'blog-6-n' );
		$wp_admin_bar->remove_menu( 'blog-6-c' );
	
	}
	
	/**
	 * Remove meta boxes
	 * 
	 * @author Ryan Hellyer <ryanhellyer@gmail.com>
	 * @since 1.8
	 * @updated 1.8
	*/
	function remove_meta_boxes() {
	
		// List of meta boxes
		$meta_boxes = array(
			'commentsdiv',
			'trackbacksdiv',
			'postcustom',
//			'postexcerpt',
			'commentstatusdiv',
			'commentsdiv',
		);
	
		// Removing the meta boxes
		foreach( $meta_boxes as $box ) {
			remove_meta_box(
				$box, // ID of meta box to remove
				'page', // Post type
				'normal' // Context
			);
		}
	
	}
	
	/**
	 * Remove menus
	 * Redirect dashboard
	 *
	 * @author Ryan Hellyer <ryanhellyer@gmail.com>
	 * @since 1.5
	 * @updated 1.8
	 */
	function remove_menus () {
	
		// Bail out now if not in admin or user can't activate plugins and 'SIMPLECMS_EVERYBODY' constant is not set
		if ( ( current_user_can( 'manage_options' ) || ! is_admin() ) && ! defined( 'SIMPLECMS_EVERYBODY' ) )
			return;
	
		// List of items to remove
		$restricted_sub_level = array(
			'edit-tags.php?taxonomy=category' =>'edit.php', // This doesn't actually do anything since posts aren't present, but left here so that you can see how to remove sub menus if needed in your own projects
			'edit.php'                        => 'TOP',
			'edit-comments.php'               => 'TOP',
			'tools.php'                       => 'TOP',
			'link-manager.php'                => 'TOP',
		);
		foreach( $restricted_sub_level as $page => $top ) {
	
			// If a top leve page, then remove whole block
			if ( 'TOP' == $top )
				remove_menu_page( $page );
			else
				remove_submenu_page( $top, $page );
	
		}
	
		// Redirect from dashboard to edit pages - Thanks to WP Engineer for this code snippet ... http://wpengineer.com/redirects-to-another-page-in-wordpress-backend/
		if ( preg_match( '#wp-admin/?(index.php)?$#', esc_url( $_SERVER['REQUEST_URI'] ) ) )
			wp_redirect( admin_url( 'edit.php?post_type=page' ) );
	
	}
	
	/**
	 * Add comments in header
	 * 
	 * @since 1.8
	 * @updated 1.8
	 * @author Ryan Hellyer <ryanhellyer@gmail.com>
	 */
	function simplecms_comments() {
		
		// Add comments
		echo "\n	<!-- Ryans Simple CMS plugin for WordPress ... http://geek.ryanhellyer.net/products/simplecms/ -->\n";
	}
}




