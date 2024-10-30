<script>
function InsertContentHolder(){
	
	var id = document.getElementById("add_content_holder").value;
	
	if(id === "")
	{
		alert("<?php _e("Please select a content holder", "content-holder") ?>");
		
		return;
	}
	
	window.send_to_editor("[content_holder slug=\"" + id + "\"]");
}
</script>

<div id="select_content_holder" style="display:none;">
	<div class="wrap">
    
        <div style="padding:15px 15px 0 15px;">
            <h3><?php _e("Insert A Content Holder", "content-holder"); ?></h3>
            <span><?php _e("Select a content holder below to add it to your post or page.", "content-holder"); ?></span>
        </div>
        
        <div style="padding:15px 15px 0 15px;">
            <select id="add_content_holder">
                <option value=""><?php _e("Select a Content Holder", "content-holder"); ?></option>
                <?php
                    $query = Content_Holder::get_content_holders();

                    while ( $query->have_posts() )
					{
                        $query->the_post();
                        
						echo '<option value="'. basename(get_permalink()) .'">';
                        
						echo esc_html(the_title());
                        
						echo '</option>';
                    }
					
                    wp_reset_postdata();
                ?>
            </select>
        </div>
        
        <div style="padding:15px;">
            
            <input type="button" class="button-primary" value="<?php _e("Insert A Content Holder", "content-holder"); ?>" onclick="InsertContentHolder();"/>&nbsp;&nbsp;&nbsp;
        	
            <a class="button" style="color:#bbb;" href="#" onclick="tb_remove(); return false;"><?php _e("Cancel", "content-holder"); ?></a>
        
        </div>
    </div>

</div>