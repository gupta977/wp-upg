<div id="upg_ajax">
	<!-- Image loader -->
	<div id='upg_loader' style='display: none;'>
		<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
		<br>
		<?php echo __("Uploading", "wp-upg"); ?>
		<div class="upg_progress-bar">
			<span id="upg_progress" class="upg_progress-bar-load" style="width: 0%;text-align: center;"></span>
		</div>
		<br>
		<?php echo __("Processing", "wp-upg"); ?>
		<div class="upg_progress-bar">
			<span id="upg_progress_process" class="upg_progress-bar-process" style="width: 0%;text-align: center;"></span>
		</div>

	</div>

	<div class='upg_response'></div>
</div>
<div id="upg_form">
	<?php
	if ($upg_ajax) {
		echo '<form id="upg-request-form" class="upg_ajax_post pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="' . admin_url("admin-ajax.php") . '">';
	} else {
		echo '<form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data" action="">';
	}
	?>

	<fieldset>
		<div class="pure-control-group">
			<label for="name"><?php _e('Title', 'wp-upg'); ?></label>
			<input class="pure-input-1 pure-input-rounded" id="name" name="user-submitted-title" type="text" value="" placeholder="<?php _e('Post Title', 'wp-upg'); ?>" required>
		</div>

		<input type='hidden' name='user-submitted-content' value='No Information'>
		<input type='hidden' name='cat' value='<?php echo upg_get_term_id($options['global_album'], 'term_id'); ?>'>


		<div class="pure-control-group">

			<?php
			$put = "";
			ob_start();
			?>
			<label for="file"><?php _e('Select Image', 'wp-upg'); ?></label>
			<input class="pure-input-1-2 pure-input-rounded" accept="image/*" id="file" name="user-submitted-image[]" type="file" size="25" <?php
																																			if ($options['image_required'] == '1') {
																																				echo "required";
																																			}
																																			?>>

			<?php
			$put = ob_get_clean();
			//Bulk upload will not work if ajax submit is enabled.
			if (!$upg_ajax)
				echo apply_filters('upg_bulk_limit_submit_form', $put);
			else
				echo $put;

			?>


		</div>


		<?php
		//Display 5 custom fields loop
		for ($x = 1; $x <= 5; $x++) {
			if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {
				if ($options['upg_custom_field_type_' . $x] == 'checkbox') {
					?>
					<div class="pure-control-group">
						<label for="upg_custom_field_<?php echo $x; ?>" class="pure-checkbox">
							<input type="checkbox" name="upg_custom_field_<?php echo $x; ?>" value="<?php echo 'upg_custom_field_' . $x . '_checked'; ?>">
							<?php echo $options['upg_custom_field_' . $x]; ?>

						</label>

					</div>
				<?php
						} else {
							?>
					<div class="pure-control-group">
						<label for="upg_custom_field_<?php echo $x; ?>">
							<?php echo $options['upg_custom_field_' . $x]; ?> </label>
						<input type="text" name="upg_custom_field_<?php echo $x; ?>" class="pure-input-1 pure-input-rounded">
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
			<button type="submit" name="SN" class="pure-button pure-button-primary"><i class="fas fa-file-upload"></i> <?php esc_html_e('Post', 'wp-upg'); ?></button>
			<button type="reset" value="<?php esc_html_e('Reset', 'wp-upg'); ?>" class="pure-button"><?php esc_html_e('Reset', 'wp-upg'); ?></button>

			<?php wp_nonce_field('upg-nonce', 'upg-nonce', false); ?>
			<input type="hidden" name="action" value="upg_ajax_post">
			<input type="hidden" name="upload_type" value="upg">
			<input type="hidden" name="preview" value="<?php echo $preview; ?>">
			<input type="hidden" name="form_name" value="<?php echo $form_name; ?>">
			<input type="hidden" name="media_private" value="<?php echo $media_private; ?>">
			<input type="hidden" name="form_attach" value="<?php echo $form_attach_id; ?>">
		</div>
	</fieldset>
	</form>
</div>