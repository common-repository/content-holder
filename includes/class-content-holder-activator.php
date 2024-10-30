<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

			flush_rewrite_rules();
	}

}
