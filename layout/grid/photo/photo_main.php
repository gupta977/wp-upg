<div class='upg_gallery_child' data-tags="<?php echo $tags; ?>">

	<?php
	if ($permalink == "0") {
		echo '<img src="' . $image_medium . '"  class="upg_hover-zoom">';
	} else {
		if ($popup == "on") {

			echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' data-caption="' . $thetitle . '" href="' . $preview_large . '"  border=0><img src="' . $image_medium . '" class="upg_hover-zoom">';
			echo ' <upg_figcaption><b>' . $thetitle . '</b><br>' . upg_breakLongText($text, $length = 200, $maxLength = 250) . '</upg_figcaption></a>';
		} else {
			echo '<a href="' . $permalink . '" border=0><img src="' . $image_medium . '"  class="upg_hover-zoom"></a>';
		}
	}
	?>

</div>