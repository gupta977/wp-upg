<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">
<fieldset>
        <div class="pure-control-group">
            <label for="name"><?php _e('Title', 'wp-upg'); ?></label>
            <input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="<?php echo $post->post_title; ?>" placeholder="<?php _e('Post Title', 'wp-upg'); ?>" required>
        </div>

           
           <?php 
		    if($options['primary_show_formshow_desp']=='1')
			{
				
		   if ($editor) 
		   { ?>
				<div class="pure-controls">
					<div class="usp_text-editor">
			<?php $settings = array(
				    'wpautop'          => true,  // enable rich text editor
				    'media_buttons'    => false,  // enable add media button
				    'textarea_name'    => 'user-submitted-content', // name
				    'textarea_rows'    => '10',  // number of textarea rows
				    'tabindex'         => '',    // tabindex
				    'editor_css'       => '',    // extra CSS
				    'editor_class'     => 'usp-rich-textarea', // class
				    'teeny'            => false, // output minimal editor config
				    'dfw'              => false, // replace fullscreen with DFW
				    'tinymce'          => true,  // enable TinyMCE
				    'quicktags'        => true,  // enable quicktags
				    'drag_drop_upload' => true, // enable drag-drop
				);
				wp_editor($post->post_content, 'upgcontent', apply_filters('upg_editor_settings', $settings)); ?>
				
				</div>
			</div>
			<?php 
			} 
			else 
			{ 
		?>
		  <div class="pure-control-group">
				 <label for="desp"><?php _e('Description', 'wp-upg'); ?></label>
			
			<textarea class="pure-input-1 pure-input-rounded" id="desp"  name="user-submitted-content" rows="5" placeholder="<?php _e('Post Content', 'wp-upg'); ?>" required><?php echo $post->post_content; ?></textarea>
			  </div>
			<?php 
			}

				}
			else
			{
				echo "<input type='hidden' name='user-submitted-content' value='No Information'> ";
			}
						?>
		   
	
      
		<div class="pure-control-group">
            <label for="cat"><?php _e('Select Album/Group', 'wp-upg'); ?></label>
           
					 <?php echo upg_droplist_category(upg_get_album($post,'term_id'),'image'); ?>
		  	  
		</div>
		<div class="pure-control-group">
            <label for="tags"><?php _e('Enter Tags', 'wp-upg'); ?></label>
			<input name='tags' id="tags" placeholder='<?php _e('Tags separated by commas', 'wp-upg'); ?>' value='<?php echo upg_get_taxonony_raw($post->ID, 'upg_tag') ; ?>'>
		     
        </div>
		
			<?php
		//Display 5 custom fields loop
		for ($x = 1; $x <= 5; $x++) 
		{
			if($options['upg_custom_field_'.$x.'_show_front']=='on')
			{
				if($options['upg_custom_field_type_'.$x]=='checkbox')
				{
					?>
					<div class="pure-control-group">
					<label for="upg_custom_field_<?php echo $x; ?>" class="pure-checkbox"> 
					<input type="checkbox" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo 'upg_custom_field_'.$x.'_checked'; ?>"
					<?php 
					if(upg_get_value('upg_custom_field_'.$x,$post)=="upg_custom_field_".$x."_checked")
						echo "checked";
					?>
					>
					<?php echo $options['upg_custom_field_'.$x]; ?> 
					
					</label> 
					
					</div>
					<?php
				}
				else
				{
			?>
			<div class="pure-control-group">
					<label for="upg_custom_field_<?php echo $x; ?>">
					<?php echo $options['upg_custom_field_'.$x]; ?> </label>
					<input type="text" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo upg_get_value('upg_custom_field_'.$x,$post); ?>" class="pure-input-1 pure-input-rounded">
					
					</div>
			
			<?php
				}
			}
		}
		
		?>
		
		<div class="pure-control-group">
		
          
					<label for="file"><?php _e('Select new image to replace', 'wp-upg'); ?></label>
				  <input class="pure-input-1-2 pure-input-rounded" id="file" name="user-submitted-image[]" type="file" size="25" >
				
			
		
		</div>
	
		  <ul>
		  <li><?php echo _e('Only picture files are allowed.','wp-upg') ?></li>
		  <li><?php echo _e('Maximum upload file size limit is','wp-upg') ?> <b><?php //echo ini_get('post_max_size'); ?> <?php echo size_format( wp_max_upload_size() ); ?></b></li>
		  </ul>
        <img src="<?php echo upg_image_src('thumbnail',$post); ?>" align="right">
		
			
			<?php
		do_action( "upg_submit_form");
		?>
		
		 <div class="pure-controls">
		  <input type="reset">
			<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fa fa-upload fa-lg"></i> <?php esc_html_e( 'Update Post', 'wp-upg' ); ?></button>
			<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?>
		</div>
</fieldset>
</form>	
<script>
jQuery(document).ready(function () 
{
	
	jQuery('#tags').tagsInput();
});
</script>