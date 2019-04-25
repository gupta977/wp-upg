<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">
<fieldset>
       <label for="user-submitted-title">Product Name</label>
            <input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="" placeholder="<?php _e('Item Title', 'wp-upg'); ?>" required>
      
	   <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
                <label for="upg_custom_field_1"><?php echo $options['upg_custom_field_1']; ?></label>
                <input id="upg_custom_field_1" name="upg_custom_field_1" class="pure-u-23-24" type="text" placeholder="0" required>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
                <label for="upg_custom_field_2"><?php echo $options['upg_custom_field_2']; ?></label>
                <input id="upg_custom_field_2" name="upg_custom_field_2" class="pure-u-23-24" type="text" placeholder="0">
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
			
               <label for="cat"><?php _e('Select category', 'wp-upg'); ?></label>
           <?php echo upg_droplist_category(); ?>
				
            </div>
			</div>
			
			<div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
			
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
					<input type="checkbox" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo 'upg_custom_field_'.$x.'_checked'; ?>" >
					<?php echo $options['upg_custom_field_'.$x]; ?> 
					
					</label> 
					
					</div>
					<?php
				}
			}
		}
		
		?>
			
			
			</div>
			 <div class="pure-u-1 pure-u-md-1-2">
			 
			 
		  <label for="upg_custom_field_5"><?php echo $options['upg_custom_field_5']; ?></label>
                <input id="upg_custom_field_5" name="upg_custom_field_5" class="pure-u-23-24" type="text" placeholder="Eg. Gift hamper on each purchase.">
				
			 </div>
			
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
				wp_editor('', 'upgcontent', apply_filters('upg_editor_settings', $settings)); ?>
				
				</div>
			</div>
			<?php 
			} 
			else 
			{ 
		?>
		  <div class="pure-control-group">
				 <label for="desp"><?php _e('Description', 'wp-upg'); ?></label>
			
			<textarea class="pure-input-1 pure-input-rounded" id="desp"  name="user-submitted-content" rows="5" placeholder="<?php _e('Post Content', 'wp-upg'); ?>" required></textarea>
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
		
            <?php
			$put="";
			ob_start ();
				?>
					<label for="file"><?php _e('Select Image', 'wp-upg'); ?></label>
				  <input class="pure-input-1-2 pure-input-rounded" id="file" name="user-submitted-image[]" type="file" size="25" 
				  <?php
					if($options['image_required']=='1')
					{
						echo "required";
					}
					?>>
				
				<?php
			$put=ob_get_clean (); 
				//Bulk upload will not work if ajax submit is enabled.
				if(!$upg_ajax)
					echo apply_filters('upg_bulk_limit_submit_form',$put);
				else 
					echo $put;

			?>
			
		
		</div>
	
		  <ul>
		  <li><?php echo _e('Only picture file are allowed.','wp-upg') ?></li>
		  <li><?php echo _e('Maximum upload file size limit is','wp-upg') ?> <b><?php //echo ini_get('post_max_size'); ?> <?php echo size_format( wp_max_upload_size() ); ?></b></li>
		  </ul>
        
		
	
		
			<?php
		do_action( "upg_submit_form");
		?>
		
		 <div class="pure-controls">
		  
			<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fa fa-upload fa-lg"></i> <?php esc_html_e( 'Post Product', 'wp-upg' ); ?></button>
			<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?> 
			<button type="reset" value="<?php esc_html_e( 'Reset', 'wp-upg' ); ?>" class="pure-button"><?php esc_html_e( 'Reset', 'wp-upg' ); ?></button>
		</div>
</fieldset>
</form>	