<div id="upg_form">

<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">
<fieldset>
        <div class="pure-control-group">
            <label for="name"><?php _e('Title', 'wp-upg'); ?></label>
            <input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="<?php echo $post->post_title; ?>" placeholder="<?php _e('Post Title', 'wp-upg'); ?>" required>
        </div>

    <input type='hidden' name='user-submitted-content' value='No Information'>
		   <input type='hidden' name='cat' value='2'>
		
		
		<div class="pure-control-group">
		
         
					<label for="file"><?php _e('Select new image to replace', 'wp-upg'); ?></label>
				  <input class="pure-input-1-2 pure-input-rounded" accept="image/*" id="file" name="user-submitted-image[]" type="file" size="25" >

			
		
		</div>
	
		  <ul>
		  <li><?php echo _e('Only picture files are allowed','wp-upg') ?></li>
		  <li><?php echo _e('Maximum upload file size limit:','wp-upg') ?> <b><?php //echo ini_get('post_max_size'); ?> <?php echo size_format( wp_max_upload_size() ); ?></b></li>
		  </ul>
          <img src="<?php echo upg_image_src('thumbnail',$post); ?>" align="right">
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
		
		
			<?php
		do_action( "upg_submit_form");
		?>
		
		 <div class="pure-controls">
		  <input type="reset" value="<?php esc_html_e( 'Reset', 'wp-upg' ); ?>" />
			<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fas fa-file-upload"></i> <?php esc_html_e( 'Post', 'wp-upg' ); ?></button>
			<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?>
			<input type="hidden" name="action" value="upg_ajax_post">
			<input type="hidden" name="upload_type" value="upg_post">
			<input type="hidden" name="preview" value="<?php echo $preview; ?>">
	
		</div>
</fieldset>
</form>	
</div>