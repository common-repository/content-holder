<?php

/**
 * Defines the content_holder custom post type
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 */

/**
 * Defines the content_holder custom post type
 *
 * This type is used to store a single piece of 
 * content to be placed anywhere on the site for reuse 
 * and quick maintenance. You can also use content holder 
 * inside content holder, enabling advanced scenarios
 *
 * @since      1.0.0
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder_Type {

	/**
	 * Register a content_holder post type
	 *
	 * @since    1.0.0
	 */
	public static function register() {

		$labels = array(
			'name'                => _x( 'Content Holders',                 'content-holder' ),
			'singular_name'       => _x( 'Content Holder',                  'content-holder' ),
			'add_new'             => _x( 'Add Content Holder', 				'content-holder' ),
			'add_new_item'        => _x( 'Add Content Holder', 				'content-holder' ),
			'edit_item'           => _x( 'Edit Content Holder', 			'content-holder' ),
			'new_item'            => _x( 'New Content Holder',              'content-holder' ),
			'view_item'           => _x( 'View Content Holder', 			'content-holder' ),
			'search_items'        => _x( 'Search',                          'content-holder' ),
			'not_found'           => _x( 'No content holder found', 		'content-holder' ),
			'not_found_in_trash'  => _x( 'No content holder found in Trash','content-holder' ),
			'parent_item_colon'   => '',
			'menu_name'           => _x( 'Content Holders', 				'content-holder' ),
			//'all_items'         => __( 'Content Holders', 				'content-holder' ),
			//'update_item'       => __( 'Update Content Holder', 			'content-holder' ), 
		);
		$capabilities = array(
			'edit_post'           => 'edit_post',
			'read_post'           => 'read_post',
			'delete_post'         => 'delete_content_holder',
			'edit_posts'          => 'edit_posts',
			'edit_others_posts'   => 'edit_others_posts',
			'publish_posts'       => 'publish_posts',
			'read_private_posts'  => 'read_private_posts',
		);
		$args = array(
			'labels'              => $labels,
			//'capabilities'        => $capabilities,
			'menu_icon'           => 'dashicons-migrate',
			'hierarchical'        => false,
			'supports'            => array('title','editor','revisions'),
			'show_in_rest'		  => true,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 50,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
			'description'         => 
			
			_x('Individual pieces of content that can be placed anywhere on the site', 
									'content-holder' ),
			
			'taxonomies'          => array( 'category' ),  
		);
	
		register_post_type( 'content_holder', $args );
	}

}



?>