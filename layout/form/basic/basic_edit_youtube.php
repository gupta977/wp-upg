<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">
	<fieldset>
		<div class="pure-control-group">
			<label for="name"><?php _e('Video Title', 'wp-upg'); ?></label>
			<input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="<?php echo $post->post_title; ?>" placeholder="<?php _e('Post Title', 'wp-upg'); ?>" required>
		</div>




		<?php
		if ($options['primary_show_formshow_desp'] == '1') {
			if ($editor) { ?>
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
				} else {
					?>
				<div class="pure-control-group">
					<label for="desp"><?php _e('Video Description', 'wp-upg'); ?></label>

					<textarea class="pure-input-1 pure-input-rounded" id="desp" name="user-submitted-content" rows="5" placeholder="<?php _e('Post Content', 'usp'); ?>" required> <?php echo $post->post_content; ?> </textarea>
				</div>
		<?php
			}
		} else {
			echo "<input type='hidden' name='user-submitted-content' value='No Information'> ";
		}

		?>



		<div class="pure-control-group">
			<label for="cat"><?php _e('Select Album/Group', 'wp-upg'); ?></label>
			<?php echo upg_droplist_category(upg_get_album($post, 'term_id'), 'embed'); ?>
		</div>
		<div class="pure-control-group">
			<label for="tags"><?php _e('Enter Tags', 'wp-upg'); ?></label>
			<input name='tags' id="tags" placeholder='<?php _e('Tags separated by commas', 'wp-upg'); ?>' value='<?php echo upg_get_taxonony_raw($post->ID, 'upg_tag'); ?>'>

		</div>
		<?php
		//Display 5 custom fields loop
		for ($x = 1; $x <= 5; $x++) {
			if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {
				if ($options['upg_custom_field_type_' . $x] == 'checkbox') {
					?>
					<div class="pure-control-group">
						<label for="upg_custom_field_<?php echo $x; ?>" class="pure-checkbox">
							<input type="checkbox" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo 'upg_custom_field_' . $x . '_checked'; ?>" <?php
																																										if (upg_get_value('upg_custom_field_' . $x, $post) == "upg_custom_field_" . $x . "_checked")
																																											echo "checked";
																																										?>>
							<?php echo $options['upg_custom_field_' . $x]; ?>

						</label>

					</div>
				<?php
						} else {
							?>
					<div class="pure-control-group">
						<label for="upg_custom_field_<?php echo $x; ?>">
							<?php echo $options['upg_custom_field_' . $x]; ?> </label>
						<input type="text" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo upg_get_value('upg_custom_field_' . $x, $post); ?>" class="pure-input-1 pure-input-rounded">
					</div>

		<?php
				}
			}
		}

		?>

		<div class="pure-control-group">
			<label for="url"><?php _e('Embed URL', 'wp-upg'); ?></label>

			<input class="pure-input-1 pure-input-rounded" id="url" name="user-submitted-url" type="url" value="<?php echo esc_url(upg_isVideo($post)); ?>" placeholder="<?php _e('copy/paste Video URL', 'wp-upg'); ?>" required>

			<ul>
				<li>Only oEmbed URL is allowed.<br> Eg. <i>https://www.youtube.com/watch?v=QU_V52Ou04Q <br>
						&nbsp; &nbsp;&nbsp;&nbsp; https://vimeo.com/channels/staffpicks/261025185?autoplay=1</i></li>

			</ul>
			<img src="<?php echo upg_image_src('thumbnail', $post); ?>" width="200" align="right">
		</div>





		<?php
		do_action("upg_submit_form");
		?>


		<div class="pure-controls">
			<input type="reset">
			<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fa fa-film"></i> <?php esc_html_e('Update', 'wp-upg'); ?></button>
			<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?>
		</div>
	</fieldset>
</form>
<script>
	jQuery(document).ready(function() {

		jQuery('#tags').tagsInput();
	});
</script>