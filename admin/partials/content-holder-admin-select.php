<?php

/**
 * Renders a list of content holder into a select element
 *
 * @link       http://www.kingdomcreation.ca
 * @since      1.0.0
 *
 * @package    Content_Holder
 * @subpackage Content_Holder/public/partials
 */

$selected_id = get_post_meta($post_id, $meta_key, true);

$query = Content_Holder::get_content_holders(); 

echo '<select id="'.$meta_key.'" name="'.$meta_key.'">';

echo '<option value="0">'.$default.'</option>';

while( $query->have_posts() )
{
	$query->the_post(); 

	echo '<option' . selected( $selected_id, get_the_ID() ) . ' value="' . get_the_ID() .'">';
	
	echo esc_html(get_the_title());
	
	echo '</option>';

}

echo '</select>';

wp_reset_postdata();