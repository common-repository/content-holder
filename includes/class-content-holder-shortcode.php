<?php

/**
 * Shortcode to render the content of the content holder post
 *
 * @since      1.0.1
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder_Shortcode {

	/**
	 * Returns the content of the content holder post 
	 *
	 * @since    1.0.1
	 */
	 
	 public static function shortcode( $atts ) {
	
		$defaults = array('id' => false, 'slug' => '', 'type' => '');
		
        extract( shortcode_atts( $defaults, $atts ) );
		
        if( $slug != "" || is_numeric($id) ){

            $query = Content_Holder::get_content_holders($slug, $id);
            
            while ( $query->have_posts() ){
                
                $query->the_post();
                
                $content = do_shortcode(get_the_content());
    
				wp_reset_postdata();
    
                remove_filter( 'the_content', 'wpautop' );
                
                $content = apply_filters( 'the_content', $content);
                
                add_filter( 'the_content', 'wpautop' );
                
				return $content;
                
            }
        }
		
        if( WP_DEBUG )
		{
            return 	Content_Holder_Shortcode::make_shortcode($atts);
        }
		
        return '';
    }
	
    /**
	 * Generate preview of the shortcode
	 *
	 * @since    1.0.0
	 */
    
	private static function make_shortcode($atts){
        
        $code = '[content_holder ';
        
        foreach( $atts as $key => $val )
		{
            $code.= $key.'="'.$val.'" ';	
        }
        
        return $code.']';
    }
	
}