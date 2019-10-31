<div class="pure-u-1 pure-u-md-1-<?php echo round($perrow / 2); ?> pure-u-lg-1-<?php echo $perrow; ?> upg_gallery_child" id="upg_<?php echo get_the_ID(); ?>" data-tags="<?php echo $tags; ?>">
	<div class="obox">
		<div class="body" style="text-align:center">

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

					echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '" data-caption="' . $thetitle . '" title="' . $thetitle . '" border=0><img src="' . $image . '" style="margin:auto;">';
					echo ' <upg_figcaption><b>' . $thetitle . '</b><br>' . upg_breakLongText($text, $length = 200, $maxLength = 250) . '</upg_figcaption></a>';
				} else {
					echo '<a href="' . $permalink . '" border="0"><img src="' . $image . '" style="margin:auto;"></a>';
				}
			}

			?>

			<?php echo upg_show_icon_grid(); ?>

		</div>

		<div class="upg_basic_footer" style="text-align:center">

			<?php echo $thetitle; ?>

		</div>
	</div>

</div>