<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.kingdomcreation.ca
 * @since             1.0.0
 * @package           Content_Holder
 *
 * @wordpress-plugin
 * Plugin Name:       Content Holder
 * Plugin URI:        http://www.globalsecuresystem.com/
 * Description:       Separate your content into reusable parts to use anywhere in your site through a function, shortcode or widget
 * Version:           1.1.0
 * Author:            Joel Laverdure
 * Author URI:        http://www.kingdomcreation.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content-holder
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-holder-activator.php
 */
function content_holder_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-widget.php';
	register_widget('ContentHolder_Widget');	
}

add_action('widgets_init', 'content_holder_widget');	

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-holder-activator.php
 */
function content_holder_shortcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-shortcode.php';
	add_shortcode('content_holder', 'Content_Holder_Shortcode::shortcode',1);
}

add_action('init', 'content_holder_shortcode');

/**
 * The code that runs during plugin activation.
 * 
 */
function register_content_holder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-type.php';
	Content_Holder_Type::register();
}

add_action('init', 'register_content_holder');

/**
 * The code responsible for the Guttenberg block editor
 *
 * @since    1.1.0
 */
function content_holder_block() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-block.php';
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	add_action('enqueue_block_editor_assets', 'Content_Holder_Block::content_holder_editor_assets');
	
	new Content_Holder_Block();
}

add_action('init', 'content_holder_block');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-holder-activator.php
 */
function activate_content_holder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-type.php';
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-activator.php';
	Content_Holder_Type::register();
	Content_Holder_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-content-holder-deactivator.php
 */
function deactivate_content_holder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-holder-deactivator.php';
	Content_Holder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_content_holder' );
register_deactivation_hook( __FILE__, 'deactivate_content_holder' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-content-holder.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_content_holder() {
	
	$plugin = new Content_Holder();
	$plugin->run();

}
run_content_holder();

