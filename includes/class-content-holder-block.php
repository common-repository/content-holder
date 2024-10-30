<?php

/**
 * Bloc to render the content of the content holder post
 *
 * @since      1.1.0
 * @package    Content_Holder
 * @subpackage Content_Holder/includes
 * @author     Joel Laverdure <webmaster@globalsecuresystem.com>
 */
class Content_Holder_Block {

	/**
	 * Init hook function adds content holder support for blocks
	 *
	 * @since    1.1.0
	 */
	 
	 public function __construct() {
        global $post;

        $content_holders = Content_Holder::get_content_holders();
        //$content_holders = new WP_Query(array('post_type'=>'content_holder','post__not_in'=>array($_GET['post']) ));
        
        $options = array(['value' => '','label' => 'Select a Content Holder']);//

           
        while ( $content_holders->have_posts() )
		{
            $content_holders->the_post();
           
            array_push($options, ['id' => $post->ID, 'value' => $post->post_name, 'label' => esc_html($post->post_title)]);
            
        }
		
		wp_reset_postdata();
		
	    // Register content-holder block type into content-holder plugin scope
        register_block_type( 'content-holder/block',array(
            'editor_script' => 'content-holder-block-editor',
            'editor_style'  => 'content-holder-block-editor',
            'style'         => 'content-holder-block',
            'attributes' => [
                'text' => [
                    'default' => ''
                ],
                'id' => [
                    'default' => 0
                ],
                'slug' => [
                    'default' => ''
                ],
                'options' => [
                    'default' => $options
                ]
                
            ],
            'render_callback' => array($this,'content_holder_block')
        ) );
    }
   
    /**
	 * Returns the content of the content holder block
	 *
	 * @since    1.1.0
	 */
	 
	public function content_holder_block($atts) {
        if( is_array($atts) ){
            
            //$query = new WP_Query(array('name'=>$atts['slug'],'post_type'=>'content_holder'));
            $query = Content_Holder::get_content_holders($atts['slug'],$atts['id']);
            
            while ( $query->have_posts() ){ $query->the_post();
                
                
                $output = do_blocks(  do_shortcode(get_the_content()) );
                
                return $output;
                
                // The code below currently behaves the same as `do_blocks` check difference with load_innder_blocks...


                /**
                 * Using the data from the blocks traverse recursively each innerBlocks 
                 * in attempt to fix the preview and render the custom color code on the element with 
                 * backgroundColor set to primary.
                 */
                $blocks =  parse_blocks(  get_the_content() );
                
                $this->load_inner_blocks($blocks[0]);
               
                wp_reset_postdata();
				
                $output = '';
                
                foreach ( $blocks as $block ) {
                        $output .= render_block( $block );
                }
                
                return $output;
            }
        }
        
    }

    /**
	 * Replace the innerBlocks data with data from content holder 
	 *
	 * @since    1.1.0
	 */
    
    private function load_inner_blocks(&$block){

        if( isset($block['innerBlocks']) ){
            
            for($i=0; $i<count($block['innerBlocks']); $i++){
                
                if( $block['innerBlocks'][$i]['blockName'] == 'content-holder/block' ){

                    $slug = $block['innerBlocks'][$i]['attrs']['slug'];
                    
                    $query = new WP_Query(array('name'=>$slug,'post_type'=>'content_holder'));

                    while ( $query->have_posts() ){ 
                        
                        $query->the_post();

                        $content = parse_blocks( get_the_content() );

                        $block['innerBlocks'][$i]['innerBlocks'] = $content;
                    }
                    
                    wp_reset_postdata();

                }else{

                    $this->load_inner_blocks($block['innerBlocks'][$i]);

                }
            }
            
        }
    }

    /**
     * Enqueue Gutenberg block assets for backend editor.
     *
     * `wp-blocks`: includes block type registration and related functions.
     * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
     * `wp-i18n`: To internationalize the block's text.
     *
     * @since 1.1.0
     */
    public function content_holder_editor_assets() {

        $dir = realpath(dirname(__FILE__) . '/..');

        $index_js = 'blocks/content-holder/block.js';
        wp_register_script(
            'content-holder-block-editor',
            plugins_url( $index_js, dirname(__FILE__) ),
            array( 
                'wp-blocks',
                'wp-dom',
                'wp-i18n',
                'wp-element',
                'wp-editor',
                'wp-edit-post', 
                'wp-data', 
                'wp-plugins', 
                'wp-api',
                'wp-components',
            ),
            filemtime( "$dir/$index_js" )
        );
       
        $editor_css = 'blocks/content-holder/editor.css';
        wp_register_style(
            'content-holder-block-editor',
            plugins_url( $editor_css, dirname(__FILE__).'../' ),
            array('wp-edit-blocks', 'wp-block-library', 'wp-block-library-theme' )
            //filemtime( "$dir/$editor_css" )
        );
        /*
        wp_enqueue_style(
            'content-holder-block-editor',
            plugins_url( $editor_css, dirname(__FILE__).'../' ),
            array( 'wp-edit-blocks', 'wp-block-library' )
            //filemtime( "$dir/$editor_css" )
        );

        //'wp-core-blocks-theme', 'wp-block-library-theme'
        //plugins_url( 'editor.css', __FILE__ ),
		
        */
        /* The content holders should not be exposed by loading stylesheets
        all visual aspects of the bloc should not be overriden.


         
        $editor_css = '/blocks/content-holder/editor.css';
        wp_enqueue_style(
            'content-holder-block-editor',
            plugins_url( $editor_css, dirname(__FILE__).'../' ),
            array( 'edit-blocks', 'block-library','core-blocks-theme'),
            filemtime( plugin_dir_path( dirname(__FILE__).'../' ) . $editor_css )
        );


        
        */ 
       

        //wp_enqueue_style( 'content-holder-block-editor');
        /*
        $style_css = 'blocks/content-holder/style.css';
        wp_register_style(
            'content-holder-block',
            plugins_url( $style_css, dirname(__FILE__) ),
            ''
            //array('wp-edit-blocks','wp-block-library','wp-core-blocks-theme')
            //filemtime( "$dir/$style_css" )
        );

        
        wp_enqueue_style( 'content-holder-block');
        

        //wp_enqueue_registered_block_scripts_and_styles();
        */
        
    } 
	
}