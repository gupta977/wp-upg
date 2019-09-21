<tr>
	<td>

		<?php
		if ($post_status == "draft")
			$permalink = 0;


		if ($permalink == "0") {
			//echo '<img src="'.$image.'" class="pure-img">';
			echo '<div class="upg_image_container"><img src="' . $image . '"> <div class="upg_image_centered">';
			echo '<div class="upg_tooltip"><i class="fas fa-eye-slash fa-2x fa-border"></i><span class="upg_tooltiptext">' . __("Under review", "wp-upg") . '</span></div>';
			echo '</div></div>';
		} else {
			if ($popup == "on") {

				echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '" data-caption="' . $thetitle . '" title="' . $thetitle . '" border=0><img src="' . $image . '" style="margin:auto;"></a>';
			} else {
				echo '<a href="' . $permalink . '" border="0"><img src="' . $image . '" style="margin:auto;"></a>';
			}
		}

		?>

	</td>
	<td><?php echo $thetitle; ?></td>
	<?php

	for ($x = 1; $x <= 5; $x++) {
		if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {

			echo "<td>" . upg_get_value('upg_custom_field_' . $x) . "</td>";
		}
	}

	?>

	<td><?php echo get_the_date(); ?></td>
	<td><?php echo upg_show_icon_grid(); ?></td>
</tr>