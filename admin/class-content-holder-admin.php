<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/admin
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	
	/**
	 * Inserts the HTML select element of all content holder post
	 *
	 * @since    1.0.0
	 */
	function content_holders_select( $post_id, $meta_key, $default="Default"){
        global $post;
		
        include('partials/content-holder-admin-select.php');
		
    }
	
	/**
	 * Inserts the content holder selector to the mce pop up window
	 *
	 * @since    1.0.0
	 */
	function add_mce_popup(){
		
		include('partials/content-holder-admin-mce-popup.php');
	}
	
	/**
	 * Inserts button link to prompt the content holder selector pop up
	 *
	 * @since    1.0.0
	 */
	function media_button(){	
	
   		include('partials/content-holder-admin-media-button.php');
	}
}
