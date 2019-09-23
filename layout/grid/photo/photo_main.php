<div class='upg_gallery_child' data-tags="<?php echo $tags; ?>">

	<?php
	if ($permalink == "0") {
		echo '<img src="' . $image_medium . '"  class="upg_hover-zoom">';
	} else {
		if ($popup == "on") {

			echo '<a data-fancybox="' . $preview_type . '" ' . $extra_param . ' href="' . $preview_large . '"  border=0><img src="' . $image_medium . '" class="upg_hover-zoom"></a>';
		} else {
			echo '<a href="' . $permalink . '" border=0><img src="' . $image_medium . '"  class="upg_hover-zoom"></a>';
		}
	}
	?>

</div>