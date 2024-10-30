<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Content_Holder_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'content-holder';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Content_Holder_Loader. Orchestrates the hooks of the plugin.
	 * - Content_Holder_i18n. Defines internationalization functionality.
	 * - Content_Holder_Admin. Defines all hooks for the admin area.
	 * - Content_Holder_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-content-holder-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-content-holder-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-content-holder-admin.php';


		$this->loader = new Content_Holder_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Content_Holder_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Content_Holder_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Content_Holder_Admin( $this->get_plugin_name(), $this->get_version() );
		
		if( $this->is_editor_page() === TRUE )
		{
			$this->loader->add_action( 'media_buttons', $plugin_admin, 'media_button' );
			$this->loader->add_action( 'admin_footer',  $plugin_admin, 'add_mce_popup' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Content_Holder_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	/**
	 * Determines if the current page contains an editor window
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
 	public function is_editor_page(){
		return in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'));	
	}
	
	
	/**
	 * Retreive a post with slug or id
	 *
	 * @since    1.0.1
	 */
	public static function get_content_holders($slug='',$id=false,$type='content_holder') {
        $args = array(
            'post_type' => $type,
        );
        
        if( $slug != "" ){
            
            $args['name'] = $slug;
            
        }else if( is_numeric($id) ){
            
            $args['p'] = $id;
            
        }

        return new WP_Query($args);
    }
	
	/**
	 * Retreive content from post type
	 *
	 * @since    1.0.1
	 */
	public static function get_content_holder($id_or_slug,$type='content_holder') {
        
        if( is_numeric($id_or_slug)){
        
            $query = $this->get_content_holders("",$id_or_slug,$type);
            
            $content_holder = '<em>[content_holder id="'.$id_or_slug.'" type="'.$type.'"]</em>';
        
        }elseif(is_string($id_or_slug)){
        
            $query = $this->get_content_holders($id_or_slug,false,$type);
            
            $content_holder = '<em>[content_holder slug="'.$id_or_slug.'" type="'.$type.'"]</em>';

        }

        if( $query->have_posts() ){
            
            while ( $query->have_posts() ){
            
                $query->the_post();
                
                remove_filter( 'the_content', 'wpautop' );
                
                $content_holder = apply_filters( 'the_content', $content);
                
                add_filter( 'the_content', 'wpautop' );
                
                wp_reset_postdata();
        
                return $content_holder;
            }

        }
    }
	

}
