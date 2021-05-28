<div class="pure-g">
	<div class="pure-u-1-1"></div>
	<div class="pure-u-1-1" style="text-align:center;"><?php echo upg_position1(); ?></div>

	<div class="pure-u-1-1">

		<div class="margin-box">
			<center>
				<?php
				if ("draft" == $post_status) {
					echo '<div class="upg_tooltip"><i class="fas fa-eye-slash"></i><span class="upg_tooltiptext">' . __("Under review", "wp-upg") . '</span></div>';
				}

				?>
				<?php do_action("upg_layout_up"); ?>
				<?php
				if (upg_isVideo($post)) {
					$attr = array(
						'src'    => esc_url(upg_isVideo($post)),
						'width'  => 560,
						'height' => 315,

					);

					//echo wp_video_shortcode( $attr );
					echo wp_oembed_get($attr['src']);
				} else {
					//Display image only if available
					if (stripos($image, 'spacer.png') == false) {
				?>
						<div class="upg_image-frame"><img src="<?php echo $image; ?>"></div>
						<?php echo upg_show_icon_grid(); ?>
				<?php
					}
				}
				?>

			</center>
		</div>

	</div>

	<div class="pure-u-1">
		<div class="margin-box">

			<div class="upg-desp"> <?php echo $text; ?> </div>

		</div>
	</div>

	<div class="pure-u-1">
		<?php echo upg_position2(); ?>
	</div>
	<div class="pure-u-1 pure-u-md-2-5">
		<div class="margin-box">

			<?php
			//Display 5 custom fields loop
			for ($x = 1; $x <= 5; $x++) {
				if ('on' == $options['upg_custom_field_' . $x . '_show_front']) {

			?>
					<div class="pure-u-1"><?php echo upg_get_filed_label('upg_custom_field_' . $x); ?> :
						<?php echo upg_get_value('upg_custom_field_' . $x); ?></div>

			<?php

				}
			}

			?>
		</div>
	</div>
	<div class="pure-u-1 pure-u-md-2-5">

		<?php upg_list_tags($post); ?> <br>
		<?php do_action("upg_layout_down"); ?>

	</div>

	<div class="pure-u-1 pure-u-md-1-5">
		<?php echo upg_author($author, false); ?>
	</div>

</div>