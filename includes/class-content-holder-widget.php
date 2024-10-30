<?php

/**
 * Widget to add content holder to sidebars
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    DCM
 * @subpackage DCM/includes
 */

class ContentHolder_Widget extends WP_Widget {
	
	public function __construct() {
		
		parent::__construct( 	
			
			'content_holders',	__( 'Content Holder', 'dcm' ), 
			
			array(
				'classname' 		=>	'content_holders',
				'description'	=>	__( 'Display a content holder', 'dcm' )
			),
			
			array(
				'width' 			=>	200,
				'height'			=>	250,
				'id_base' 		=> 'content_holders'
			)
		);
	}
	
	/**
	 * Render the output of the widget using the shortcode content_holder
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function widget( $args, $instance ) {
		
		//extract( $args );
		
		if( isset($instance['id']) ){
			
			$content = do_shortcode('[content_holder id="'.$instance['id'].'"]');
			
			echo apply_filters("the_content",$content);
		
		}
	}
	
	/**
	 * Switch the old with the new widget when clicking update
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;
		
		$instance["id"] = $new_instance["id"];
		
		return $instance;
	}
	
	/**
	 * Render the admin widget form to select the content holder
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	function form( $instance )
	{
		global $post;
		
		//$defaults = array();

		//$instance = wp_parse_args( (array) $instance, $defaults);
		
		$selected_id = ( isset($instance['id']) ) ? $instance['id'] : '';

		$query = Content_Holder::get_content_holders();
		
		echo '<p><label for="' . $this->get_field_id( 'id' ) . '">' . __("Insert A Content Holder", "content-holder").':</label>';
            
		echo '<select id="' . $this->get_field_id( 'id' ) . '" name="' . $this->get_field_name( 'id' ) . '" style="width:90%;">';

		echo '<option value="">None</option>';
		
		while ( $query->have_posts() )
		{
			$query->the_post();
		
			echo '<option' . selected( $selected_id, $post->ID ) . ' value="' . $post->ID . '">' . esc_html($post->post_title) . '</option>';
		}
		
		wp_reset_postdata();
		
		echo '</select></p>';
		
	}
}
