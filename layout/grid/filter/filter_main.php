<div class="list-item box" id="upg_<?php echo get_the_ID(); ?>">
	<!-- img -->
	<div class="img left">

		<?php
		if ($post_status == "draft")
			$permalink = 0;


		if ($permalink == "0") {
			//echo '<img src="'.$image.'" class="pure-img">';
			echo '<div class="upg_image_container"><img src="' . $image . '" data-original="' . $image . '" alt="" title="" style="display: inline;"><div class="upg_image_centered">';
			echo '<div class="upg_tooltip"><i class="fas fa-eye-slash fa-2x fa-border"></i><span class="upg_tooltiptext">' . __("Under review", "wp-upg") . '</span></div>';
			echo '</div></div>';
		} else {
			if ($popup == "on") {

				echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '" data-caption="' . $thetitle . '" title="' . $thetitle . '" border=0><img src="' . $image . '" data-original="' . $image . '" alt="" title="" style="display: inline;"></a>';
			} else {
				echo '<a href="' . $permalink . '" border="0"><img src="' . $image . '" data-original="' . $image . '" alt="" title="" style="display: inline;"></a>';
			}
		}

		?>



	</div>

	<!-- data -->
	<div class="block right">
		<p class="date"><?php echo get_the_date(); ?></p>
		<p class="title"><?php echo $thetitle; ?></p>
		<p class="desc"><?php echo upg_breakLongText($text, $length = 200, $maxLength = 250); ?></p>
		<p class="like"><?php echo upg_show_icon_grid(); ?></p>
	</div>
	<div class="upg_divider upg_div-transparent"></div>
</div>