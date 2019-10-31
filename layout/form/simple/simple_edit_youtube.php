<div id="upg_form">
	<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">

		<fieldset>
			<div class="pure-control-group">
				<label for="name"><?php _e('Video Title', 'wp-upg'); ?></label>
				<input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="<?php echo $post->post_title; ?>" placeholder="<?php _e('Post Title', 'wp-upg'); ?>" required>
			</div>



			<input type='hidden' name='user-submitted-content' value='No Information'>
			<input type='hidden' name='cat' value='2'>


			<div class="pure-control-group">
				<label for="url"><?php _e('Embed URL', 'wp-upg'); ?></label>
				<input class="pure-input-1 pure-input-rounded" id="url" name="user-submitted-url" type="url" value="<?php echo esc_url(upg_isVideo($post)); ?>" placeholder="<?php _e('copy/paste Video URL', 'wp-upg'); ?>" required>
				<?php echo __('Only URL from YouTube & Vimeo is allowed', 'wp-upg'); ?>
			</div>
			<img src="<?php echo upg_image_src('thumbnail', $post); ?>" width="200" align="right">

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



			<?php
			do_action("upg_submit_form");
			?>


			<div class="pure-controls">

				<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fab fa-youtube"></i> <?php esc_html_e('Update', 'wp-upg'); ?></button>
				<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?>
				<input type="hidden" name="action" value="upg_ajax_post">
				<input type="hidden" name="upload_type" value="video_url">
				<input type="hidden" name="preview" value="<?php echo $preview; ?>">

			</div>
		</fieldset>
	</form>
</div>